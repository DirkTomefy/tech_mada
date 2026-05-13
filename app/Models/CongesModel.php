<?php

namespace App\Models;

use App\Models\SoldeModel;
use CodeIgniter\Model;

class CongesModel extends Model
{
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected $allowedFields = [
        'employe_id',
        'type_conge_id',
        'date_debut',
        'date_fin',
        'nb_jours',
        'motif',
        'statut',
        'commentaire_rh',
        'created_at',
        'traite_par',
    ];
    protected $businessError;
    protected SoldeModel $soldeModel;

    public function __construct()
    {
        parent::__construct();

        $this->soldeModel = new SoldeModel();
    }

    public function getBusinessError()
    {
        return $this->businessError;
    }

    public function getFilteredRequestsWithEmployees(?string $statut = null, ?int $departementId = null, int $limit = 100): array
    {
        $query = $this->select('conges.*, e.nom, e.prenom, e.email, d.nom AS departement, tc.libelle AS type_libelle, tc.deductible, tp.nom AS traiteur_nom, tp.prenom AS traiteur_prenom')
            ->join('employes e', 'e.id = conges.employe_id', 'left')
            ->join('departements d', 'd.id = e.departement_id', 'left')
            ->join('types_conge tc', 'tc.id = conges.type_conge_id', 'left')
            ->join('employes tp', 'tp.id = conges.traite_par', 'left');

        if (!empty($statut)) {
            $query->where('conges.statut', $statut);
        }

        if (!empty($departementId)) {
            $query->where('e.departement_id', $departementId);
        }

        $requests = $query->orderBy('conges.created_at', 'DESC')
            ->limit($limit)
            ->findAll();

        return $this->attachBalancesToRequests($requests);
    }

    protected function attachBalancesToRequests(array $requests): array
    {
        foreach ($requests as &$request) {
            $year = date('Y', strtotime($request['date_debut'] ?? date('Y-m-d')));
            $solde = $this->db->table('soldes')
                ->select('jours_attribues, jours_pris')
                ->where('employe_id', $request['employe_id'])
                ->where('type_conge_id', $request['type_conge_id'])
                ->where('annee', $year)
                ->get()
                ->getRowArray();

            if ($solde) {
                $request['solde_attribue'] = (float) ($solde['jours_attribues'] ?? 0);
                $request['solde_pris'] = (float) ($solde['jours_pris'] ?? 0);
                $request['solde_restant'] = round($request['solde_attribue'] - $request['solde_pris'], 1);
            } else {
                $request['solde_attribue'] = null;
                $request['solde_pris'] = null;
                $request['solde_restant'] = null;
            }
        }

        return $requests;
    }

    public function approveRequest(int $congeId, int $processedBy): bool
    {
        $this->businessError = null;

        $request = $this->db->table($this->table)
            ->select('conges.*, tc.deductible, tc.libelle AS type_libelle')
            ->join('types_conge tc', 'tc.id = conges.type_conge_id', 'left')
            ->where('conges.id', $congeId)
            ->get()
            ->getRowArray();

        if (!$request) {
            $this->businessError = 'Demande introuvable';
            return false;
        }

        if ($request['statut'] !== 'en_attente') {
            $this->businessError = 'La demande ne peut plus être traitée';
            return false;
        }

        $deductible = (int) ($request['deductible'] ?? 1);
        $solde = null;

        if ($deductible === 1) {
            $year = date('Y', strtotime($request['date_debut'] ?? date('Y-m-d')));
            $solde = $this->db->table('soldes')
                ->where('employe_id', $request['employe_id'])
                ->where('type_conge_id', $request['type_conge_id'])
                ->where('annee', $year)
                ->get()
                ->getRowArray();

            if (!$solde) {
                $this->businessError = 'Solde introuvable pour ce congé';
                return false;
            }

            $available = (float) ($solde['jours_attribues'] ?? 0) - (float) ($solde['jours_pris'] ?? 0);
            if ($available < (float) $request['nb_jours']) {
                $this->businessError = 'Solde insuffisant pour approuver cette demande';
                return false;
            }
        }

        $this->db->transStart();
        $this->db->table($this->table)
            ->where('id', $congeId)
            ->update([
                'statut' => 'approuve',
                'traite_par' => $processedBy,
                'commentaire_rh' => null,
            ]);

        if ($deductible === 1 && $solde) {
            $this->db->table('soldes')
                ->where('id', $solde['id'])
                ->update(['jours_pris' => (float) $solde['jours_pris'] + (float) $request['nb_jours']]);
        }

        $this->db->transComplete();

        if (!$this->db->transStatus()) {
            $this->businessError = 'Erreur lors de l\'approbation';
            return false;
        }

        return true;
    }

    public function refuseRequest(int $congeId, int $processedBy, string $commentaire): bool
    {
        $this->businessError = null;

        $request = $this->db->table($this->table)
            ->where('id', $congeId)
            ->get()
            ->getRowArray();

        if (!$request) {
            $this->businessError = 'Demande introuvable';
            return false;
        }

        if ($request['statut'] !== 'en_attente') {
            $this->businessError = 'La demande ne peut plus être traitée';
            return false;
        }

        if ($this->db->table($this->table)->where('id', $congeId)->update([
            'statut' => 'refuse',
            'traite_par' => $processedBy,
            'commentaire_rh' => $commentaire ?: null,
        ])) {
            return true;
        }

        $this->businessError = 'Erreur lors du refus';
        return false;
    }

    public function getAbsencesCurrentMonth(): array
    {
        $start = date('Y-m-01');
        $end = date('Y-m-t');

        return $this->select('conges.*, e.nom, e.prenom, e.email, tc.libelle AS type_libelle')
            ->join('employes e', 'e.id = conges.employe_id', 'left')
            ->join('types_conge tc', 'tc.id = conges.type_conge_id', 'left')
            ->where('conges.statut', 'approuve')
            ->groupStart()
                ->where('conges.date_debut <=', $end)
                ->where('conges.date_fin >=', $start)
            ->groupEnd()
            ->orderBy('conges.date_debut', 'ASC')
            ->findAll();
    }

    public function countAbsencesCurrentMonth(): int
    {
        return count($this->getAbsencesCurrentMonth());
    }

    /**
     * Compte les absents d'aujourd'hui (congés approuvés)
     */
    public function countAbsentsToday(): int
    {
        $today = date('Y-m-d');
        
        return $this->db->table($this->table)
            ->where('statut', 'approuve')
            ->where('date_debut <=', $today)
            ->where('date_fin >=', $today)
            ->countAllResults();
    }

    public function getDashboardStatsCurrentMonth(): array
    {
        $start = date('Y-m-01');
        $end = date('Y-m-t');

        $base = $this->db->table('conges')
            ->where('date_debut <=', $end)
            ->where('date_fin >=', $start);

        $approved = (clone $base)->where('statut', 'approuve')->countAllResults();
        $pending = (clone $base)->where('statut', 'en_attente')->countAllResults();
        $refused = (clone $base)->where('statut', 'refuse')->countAllResults();
        $employees = $this->db->table('conges')
            ->select('COUNT(DISTINCT employe_id) AS total', false)
            ->where('date_debut <=', $end)
            ->where('date_fin >=', $start)
            ->where('statut', 'approuve')
            ->get()
            ->getRowArray();

        return [
            'approved' => (int) $approved,
            'pending' => (int) $pending,
            'refused' => (int) $refused,
            'employees' => (int) ($employees['total'] ?? 0),
        ];
    }

    public function getRequestsWithEmployees(int $limit = 20): array
    {
        return $this->select('conges.*, e.nom, e.prenom, e.email, tc.libelle AS type_libelle')
            ->join('employes e', 'e.id = conges.employe_id', 'left')
            ->join('types_conge tc', 'tc.id = conges.type_conge_id', 'left')
            ->orderBy('conges.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Compte les demandes par statut (optionnellement par département)
     */
    public function countByStatus(?int $departementId = null): array
    {
        $query = $this->db->table($this->table)
            ->join('employes e', 'e.id = ' . $this->table . '.employe_id', 'left');

        if ($departementId !== null) {
            $query->where('e.departement_id', $departementId);
        }

        $result = $query->select('statut, COUNT(*) AS count', false)
            ->groupBy('statut')
            ->get()
            ->getResultArray();

        // Initialiser avec les valeurs par défaut
        $counts = [
            'en_attente' => 0,
            'approuve' => 0,
            'refuse' => 0,
            'annule' => 0,
        ];

        // Remplir avec les résultats de la requête
        foreach ($result as $row) {
            $counts[$row['statut']] = (int) $row['count'];
        }

        return $counts;
    }
}

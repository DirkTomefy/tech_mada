<?php

namespace App\Models;

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

    public function getBusinessError()
    {
        return $this->businessError;
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

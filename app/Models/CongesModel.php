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
}

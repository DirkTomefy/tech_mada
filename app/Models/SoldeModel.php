<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'soldes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
    protected $allowedFields = [
        'employe_id',
        'type_conge_id',
        'annee',
        'jours_attribues',
        'jours_pris',
    ];
    protected $businessError;

    protected $validationRules = [
        'employe_id' => 'required|integer',
        'type_conge_id' => 'required|integer',
        'annee' => 'required|integer|greater_than_equal_to[2000]',
        'jours_attribues' => 'required|numeric|greater_than_equal_to[0]',
        'jours_pris' => 'permit_empty|numeric|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'employe_id' => ['required' => 'L\'employé est requis.'],
        'type_conge_id' => ['required' => 'Le type de congé est requis.'],
        'annee' => ['required' => 'L\'année est requise.'],
        'jours_attribues' => ['required' => 'Le solde attribué est requis.'],
    ];

    public function getBusinessError()
    {
        return $this->businessError;
    }

    public function getByEmployeeAndYear(int $employeId, int $annee): array
    {
        return $this->select('soldes.*, types_conge.libelle AS type_libelle, types_conge.deductible')
            ->join('types_conge', 'types_conge.id = soldes.type_conge_id', 'left')
            ->where('soldes.employe_id', $employeId)
            ->where('soldes.annee', $annee)
            ->orderBy('types_conge.libelle', 'ASC')
            ->findAll();
    }

    public function initializeEmployeeBalances(int $employeId, int $annee): bool
    {
        $this->businessError = null;

        $employee = $this->db->table('employes')->where('id', $employeId)->get()->getRowArray();
        if (!$employee) {
            $this->businessError = 'Employé non trouvé';
            return false;
        }

        $types = $this->db->table('types_conge')->orderBy('libelle', 'ASC')->get()->getResultArray();
        if (empty($types)) {
            $this->businessError = 'Aucun type de congé configuré';
            return false;
        }

        $this->db->transStart();

        foreach ($types as $type) {
            $existing = $this->where('employe_id', $employeId)
                ->where('type_conge_id', $type['id'])
                ->where('annee', $annee)
                ->first();

            $data = [
                'employe_id' => $employeId,
                'type_conge_id' => (int) $type['id'],
                'annee' => $annee,
                'jours_attribues' => (float) ($type['jours_annuels'] ?? 0),
                'jours_pris' => 0,
            ];

            if ($existing) {
                $this->update($existing['id'], $data);
            } else {
                $this->insert($data);
            }
        }

        $this->db->transComplete();

        if (!$this->db->transStatus()) {
            $this->businessError = 'Erreur lors de l\'initialisation du solde';
            return false;
        }

        return true;
    }

    public function saveBalance(array $data): bool
    {
        $this->businessError = null;

        if (!$this->validate($data)) {
            $this->businessError = implode(' ', $this->errors());
            return false;
        }

        $employee = $this->db->table('employes')->where('id', (int) $data['employe_id'])->get()->getRowArray();
        if (!$employee) {
            $this->businessError = 'Employé non trouvé';
            return false;
        }

        $type = $this->db->table('types_conge')->where('id', (int) $data['type_conge_id'])->get()->getRowArray();
        if (!$type) {
            $this->businessError = 'Type de congé non trouvé';
            return false;
        }

        $existing = $this->where('employe_id', (int) $data['employe_id'])
            ->where('type_conge_id', (int) $data['type_conge_id'])
            ->where('annee', (int) $data['annee'])
            ->first();

        $payload = [
            'employe_id' => (int) $data['employe_id'],
            'type_conge_id' => (int) $data['type_conge_id'],
            'annee' => (int) $data['annee'],
            'jours_attribues' => (float) $data['jours_attribues'],
            'jours_pris' => (float) ($data['jours_pris'] ?? 0),
        ];

        if ($existing) {
            return (bool) $this->update($existing['id'], $payload);
        }

        return (bool) $this->insert($payload);
    }

    public function getBalancesByYear(int $annee): array
    {
        return $this->select('soldes.*, e.nom, e.prenom, e.email, types_conge.libelle AS type_libelle')
            ->join('employes e', 'e.id = soldes.employe_id', 'left')
            ->join('types_conge', 'types_conge.id = soldes.type_conge_id', 'left')
            ->where('soldes.annee', $annee)
            ->orderBy('e.nom', 'ASC')
            ->findAll();
    }
    /**
     * Récupérer le solde pour un employé et une année
     */
    public function getSoldeEmploye($employe_id, $annee = null)
    {
        if ($annee === null) {
            $annee = date('Y');
        }

        return $this->where('employe_id', $employe_id)
            ->where('annee', $annee)
            ->findAll();
    }

    /**
     * Récupérer le solde pour un employé, un type de congé et une année
     */
    public function getSoldeByType($employe_id, $type_conge_id, $annee = null)
    {
        if ($annee === null) {
            $annee = date('Y');
        }

        return $this->where('employe_id', $employe_id)
            ->where('type_conge_id', $type_conge_id)
            ->where('annee', $annee)
            ->first();
    }

    /**
     * Mettre à jour les jours pris
     */
    
}

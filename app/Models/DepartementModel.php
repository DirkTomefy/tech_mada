<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartementModel extends Model
{
    protected $table = 'departements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom',
        'description',
    ];
    protected $useTimestamps = false;
    protected $businessError;

    protected $validationRules = [
        'nom' => 'required|string|max_length[120]',
        'description' => 'permit_empty|string|max_length[500]',
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom du département est requis',
            'max_length' => 'Le nom ne doit pas dépasser 120 caractères',
        ],
        'description' => [
            'max_length' => 'La description ne doit pas dépasser 500 caractères',
        ],
    ];

    public function getAll()
    {
        return $this->orderBy('nom', 'ASC')->findAll();
    }

    public function getById($id)
    {
        return $this->find($id);
    }

    public function getAllWithEmployeeCount()
    {
        return $this->db->table('departements d')
            ->select('d.id, d.nom, d.description, COUNT(e.id) as employee_count')
            ->join('employes e', 'e.departement_id = d.id', 'left')
            ->groupBy('d.id, d.nom, d.description')
            ->orderBy('d.nom', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function createDepartement($data)
    {
        $this->businessError = null;

        if (!$this->validate($data)) {
            return false;
        }

        if ($this->existsByNom($data['nom'] ?? '')) {
            $this->businessError = 'Ce département existe déjà';
            return false;
        }

        return $this->insert($data);
    }

    public function updateDepartement($id, $data)
    {
        $this->businessError = null;

        $departement = $this->getById($id);
        if (!$departement) {
            $this->businessError = 'Département non trouvé';
            return false;
        }

        if (!$this->validate($data)) {
            return false;
        }

        $nom = $data['nom'] ?? null;
        if ($nom !== null) {
            $existing = $this->where('nom', $nom)
                ->where('id !=', $id)
                ->first();

            if ($existing) {
                $this->businessError = 'Ce département existe déjà';
                return false;
            }
        }

        return $this->update($id, $data);
    }

    public function deleteDepartement($id)
    {
        $this->businessError = null;

        $departement = $this->getById($id);
        if (!$departement) {
            $this->businessError = 'Département non trouvé';
            return false;
        }

        if ($this->hasEmployees($id)) {
            $this->businessError = 'Impossible de supprimer: ce département contient encore des employés';
            return false;
        }

        return $this->delete($id);
    }

    public function existsByNom($nom)
    {
        return $this->where('nom', $nom)->first() !== null;
    }

    public function hasEmployees($id)
    {
        return $this->db->table('employes')
            ->where('departement_id', $id)
            ->countAllResults() > 0;
    }

    public function getBusinessError()
    {
        return $this->businessError;
    }
}

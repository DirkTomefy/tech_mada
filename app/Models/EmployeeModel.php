<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'departement_id',
        'date_embauche',
        'actif',
    ];
    protected $useTimestamps = false;

    protected $validationRules = [
        'nom' => 'required|string|max_length[100]',
        'prenom' => 'required|string|max_length[100]',
        'email' => 'required|valid_email',
        'password' => 'required|string|min_length[6]',
        'role' => 'required|in_list[RH,EMPLOYE,ADMIN]',
        'departement_id' => 'permit_empty|integer',
        'date_embauche' => 'permit_empty|valid_date',
        'actif' => 'integer',
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom est requis',
            'max_length' => 'Le nom ne doit pas dépasser 100 caractères',
        ],
        'prenom' => [
            'required' => 'Le prénom est requis',
            'max_length' => 'Le prénom ne doit pas dépasser 100 caractères',
        ],
        'email' => [
            'required' => 'L\'email est requis',
            'valid_email' => 'Veuillez fournir un email valide',
        ],
        'password' => [
            'required' => 'Le mot de passe est requis',
            'min_length' => 'Le mot de passe doit contenir au moins 6 caractères',
        ],
        'role' => [
            'required' => 'Le rôle est requis',
            'in_list' => 'Le rôle doit être RH, EMPLOYE ou ADMIN',
        ],
    ];

    /**
     * Récupère tous les employés actifs
     */
    public function getAll()
    {
        return $this->where('actif', 1)
            ->orderBy('nom', 'ASC')
            ->findAll();
    }

    /**
     * Récupère un employé par ID
     */
    public function getById($id)
    {
        return $this->find($id);
    }

    /**
     * Crée un nouvel employé
     */
    public function createEmployee($data)
    {
        // Hash le mot de passe si présent
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        // Définit l'état actif par défaut
        if (!isset($data['actif'])) {
            $data['actif'] = 1;
        }
        try {
            $insertId = $this->insert($data);
            if ($insertId === false) {
                $db = \Config\Database::connect();
                $err = $db->error();
                log_message('error', 'EmployeeModel::createEmployee DB error: ' . json_encode($err));
                return false;
            }
            return $insertId;
        } catch (\Exception $e) {
            log_message('error', 'EmployeeModel::createEmployee Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour un employé
     */
    public function updateEmployee($id, $data)
    {
        // Hash le mot de passe s'il est modifié
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }

        return $this->update($id, $data);
    }

    /**
     * Supprime un employé (soft delete)
     */
    public function deactivateEmployee($id)
    {
        return $this->update($id, ['actif' => 0]);
    }

    /**
     * Récupère les employés par rôle
     */
    public function getByRole($role)
    {
        return $this->where('actif', 1)
            ->where('role', $role)
            ->orderBy('nom', 'ASC')
            ->findAll();
    }

    /**
     * Récupère les employés par département
     */
    public function getByDepartement($departement_id)
    {
        return $this->where('actif', 1)
            ->where('departement_id', $departement_id)
            ->orderBy('nom', 'ASC')
            ->findAll();
    }

    /**
     * Teste l'existence d'un employé par email
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Compte le nombre d'employés actifs
     */
    public function countActive()
    {
        return $this->where('actif', 1)->countAllResults();
    }

    /**
     * Compte par rôle
     */
    public function countByRole($role)
    {
        return $this->where('actif', 1)
            ->where('role', $role)
            ->countAllResults();
    }

    /**
     * Récupère les employés avec pagination
     */
    public function getPaginated($perPage = 10, $page = 1)
    {
        $offset = ($page - 1) * $perPage;
        return $this->where('actif', 1)
            ->orderBy('nom', 'ASC')
            ->limit($perPage, $offset)
            ->findAll();
    }

    /**
     * Compte le total d'employés actifs (pour la pagination)
     */
    public function getTotalActive()
    {
        return $this->where('actif', 1)->countAllResults();
    }

    /**
     * Trouver un employé par email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Authentifier un employé
     */
    public function authenticate(string $email, string $password): ?array
    {
        $employe = $this->findByEmail($email);

        // Vérifier que l'employé existe
        if ($employe === null) {
            return null;
        }

        // Vérifier que l'employé est actif
        if ($employe['actif'] != 1) {
            return null;
        }

        // Vérifier le mot de passe
        if (!password_verify($password, $employe['password'])) {
            return null;
        }

        return $employe;
    }

    /**
     * Vérifier si un utilisateur est un User (EMPLOYE)
     */
    public function isUser(int $id): bool
    {
        $employe = $this->find($id);
        return $employe !== null && $employe['role'] === 'EMPLOYE' && $employe['actif'] == 1;
    }

    /**
     * Vérifier si un utilisateur est RH
     */
    public function isRH(int $id): bool
    {
        $employe = $this->find($id);
        return $employe !== null && $employe['role'] === 'RH' && $employe['actif'] == 1;
    }

    /**
     * Vérifier si un utilisateur est ADMIN
     */
    public function isAdmin(int $id): bool
    {
        $employe = $this->find($id);
        return $employe !== null && $employe['role'] === 'ADMIN' && $employe['actif'] == 1;
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCongeModel extends Model
{
    protected $table = 'types_conge';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'libelle',
        'jours_annuels',
        'deductible'
    ];

    /**
     * Récupérer tous les types de congé
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * Récupérer les types de congé déductibles du solde
     */
    public function getDeductibles()
    {
        return $this->where('deductible', 1)->findAll();
    }
}

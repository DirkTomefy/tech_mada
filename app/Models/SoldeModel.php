<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'soldes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'employe_id',
        'type_conge_id',
        'annee',
        'jours_attribues',
        'jours_pris'
    ];

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
    public function updateJoursPris($employe_id, $type_conge_id, $nb_jours, $annee = null)
    {
        if ($annee === null) {
            $annee = date('Y');
        }

        $solde = $this->getSoldeByType($employe_id, $type_conge_id, $annee);

        if ($solde) {
            $nouveau_pris = $solde['jours_pris'] + $nb_jours;
            $this->where('id', $solde['id'])->update(['jours_pris' => $nouveau_pris]);
            return true;
        }

        return false;
    }

    /**
     * Calculer les jours restants
     */
    public function getJoursRestants($employe_id, $type_conge_id, $annee = null)
    {
        if ($annee === null) {
            $annee = date('Y');
        }

        $solde = $this->getSoldeByType($employe_id, $type_conge_id, $annee);

        if ($solde) {
            return $solde['jours_attribues'] - $solde['jours_pris'];
        }

        return 0;
    }
}

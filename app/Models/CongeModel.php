<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'employe_id',
        'type_conge_id',
        'date_debut',
        'date_fin',
        'nb_jours',
        'motif',
        'statut',
        'commentaire_rh',
        'traite_par'
    ];

    protected $useTimestamps = false;

    /**
     * Créer une demande de congé
     */
    public function creerDemande($data)
    {
        return $this->insert($data);
    }

    /**
     * Récupérer toutes les demandes d'un employé
     */
    public function getByEmploye($employe_id)
    {
        return $this->where('employe_id', $employe_id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Récupérer les demandes en attente
     */
    public function getEnAttente()
    {
        return $this->where('statut', 'en_attente')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Récupérer une demande avec les détails (employé, type de congé)
     */
    public function getDetailedConge($conge_id)
    {
        return $this->select('conges.*, employes.prenom, employes.nom, employes.email, types_conge.libelle as type_libelle')
            ->join('employes', 'employes.id = conges.employe_id')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->where('conges.id', $conge_id)
            ->first();
    }

    /**
     * Mettre à jour le statut d'une demande
     */
    public function updateStatut($conge_id, $statut, $commentaire = null)
    {
        $data = [
            'statut' => $statut,
            'traite_par' => session('id') // Récupère l'ID de l'utilisateur en session
        ];

        if ($commentaire !== null) {
            $data['commentaire_rh'] = $commentaire;
        }

        return $this->update($conge_id, $data);
    }

    /**
     * Calculer le nombre de jours entre deux dates (jours ouvrables)
     */
    public static function calculerJours($date_debut, $date_fin)
    {
        $debut = new \DateTime($date_debut);
        $fin   = new \DateTime($date_fin);

        // +1 pour inclure le dernier jour
        return $debut->diff($fin)->days + 1;
    }

    public static function validateDates($date_debut, $date_fin)
    {
        $debut = new \DateTime($date_debut);
        $fin   = new \DateTime($date_fin);

        // date fin >= date début
        if ($fin < $debut) {
            return false;
        }

        // pas dans le passé
        $today = new \DateTime('today');
        if ($debut < $today) {
            return false;
        }

        return true;
    }
}

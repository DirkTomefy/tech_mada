<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class CongeModel extends Model
{
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
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

    protected $lastError = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Valide que les dates sont au bon format et que date_fin >= date_debut
     */
    public static function validateDates(?string $debut, ?string $fin): bool
    {
        if (empty($debut) || empty($fin)) {
            return false;
        }

        $d1 = date_create_from_format('Y-m-d', $debut);
        $d2 = date_create_from_format('Y-m-d', $fin);

        if (!$d1 || !$d2) {
            return false;
        }

        return $d2 >= $d1;
    }

    /**
     * Calcule le nombre de jours calendaires inclusifs entre deux dates
     */
    public static function calculerJours(string $debut, string $fin): int
    {
        $d1 = new \DateTime($debut);
        $d2 = new \DateTime($fin);

        // inclusif : ajouter 1 jour
        $interval = $d1->diff($d2);
        return (int) $interval->days + 1;
    }

    /**
     * Wrapper d'insertion compatible avec CodeIgniter\Model::insert
     */
    public function insert($data = null, bool $returnID = true)
    {
        try {
            $result = parent::insert($data, $returnID);

            if ($result === false) {
                $this->lastError = $this->db->error();
            }

            return $result;
        } catch (Exception $e) {
            $this->lastError = ['message' => $e->getMessage()];
            return false;
        }
    }

    /**
     * Récupère les demandes d'un employé
     */
    public function getByEmploye(int $employe_id): array
    {
        return $this->where('employe_id', $employe_id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Met à jour le statut d'une demande
     */
    public function updateStatut(int $conge_id, string $statut, ?string $commentaire = null): bool
    {
        $data = ['statut' => $statut];
        if ($commentaire !== null) {
            $data['commentaire_rh'] = $commentaire;
        }

        try {
            return (bool) $this->where('id', $conge_id)->set($data)->update();
        } catch (Exception $e) {
            $this->lastError = ['message' => $e->getMessage()];
            return false;
        }
    }

    /**
     * Récupère les demandes en attente
     */
    public function getEnAttente(): array
    {
        return $this->where('statut', 'en_attente')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Retourne les dernières erreurs pour debug
     */
    public function errors(bool $forceDB = false)
    {
        $parentErrors = parent::errors($forceDB);
        if (!empty($parentErrors)) {
            return $parentErrors;
        }

        return (array) $this->lastError;
    }
}

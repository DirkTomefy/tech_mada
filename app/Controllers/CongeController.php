<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\TypeCongeModel;
use App\Models\SoldeModel;

class CongeController extends BaseController
{
    protected $congeModel;
    protected $typeCongeModel;
    protected $soldeModel;

    public function __construct()
    {
        $this->congeModel = new CongeModel();
        $this->typeCongeModel = new TypeCongeModel();
        $this->soldeModel = new SoldeModel();
    }

    /**
     * Afficher le formulaire de demande de congé
     */
    public function formulaire()
    {
        // Vérifier que l'utilisateur est connecté
        if (!session()->has('logged_in') || !session('logged_in')) {
            return redirect()->to('employee/login')->with('error', 'Vous devez être connecté');
        }

        $employe_id = session('id');

        // Récupérer tous les types de congé
        $types_conge = $this->typeCongeModel->getAll();

        // Récupérer les soldes de l'employé pour l'année actuelle
        $soldes = $this->soldeModel->getSoldeEmploye($employe_id, date('Y'));

        // Créer un tableau de soldes indexé par type_conge_id
        $soldes_par_type = [];
        foreach ($soldes as $solde) {
            $soldes_par_type[$solde['type_conge_id']] = $solde;
        }

        return view('employee/demande/formulaire', [
            'types_conge' => $types_conge,
            'soldes_par_type' => $soldes_par_type
        ]);
    }

    /**
     * Soumettre une demande de congé
     */
    public function soumettre()
    {
        if (!session()->has('logged_in') || !session('logged_in')) {
            return redirect()->to('employee/login')
                ->with('error', 'Vous devez être connecté');
        }

        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $employe_id    = session('id');
        $type_conge_id = $this->request->getPost('type_conge_id');
        $date_debut    = $this->request->getPost('date_debut');
        $date_fin      = $this->request->getPost('date_fin');
        $motif         = $this->request->getPost('motif');

        // validation
        $rules = [
            'type_conge_id' => 'required|numeric',
            'date_debut'    => 'required|valid_date[Y-m-d]',
            'date_fin'      => 'required|valid_date[Y-m-d]',
            'motif'         => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // dates
        if (!CongeModel::validateDates($date_debut, $date_fin)) {
            return redirect()->back()
                ->with('error', 'Dates invalides');
        }

        // calcul jours
        $nb_jours = CongeModel::calculerJours($date_debut, $date_fin);

        // data INSERT
        $data = [
            'employe_id'    => $employe_id,
            'type_conge_id' => $type_conge_id,
            'date_debut'    => $date_debut,
            'date_fin'      => $date_fin,
            'nb_jours'      => $nb_jours,
            'motif'         => $motif,
            'statut'        => 'en_attente'
        ];

        // INSERT + DEBUG
        if (!$this->congeModel->insert($data)) {
            dd([
                'errors' => $this->congeModel->errors(),
                'db_error' => $this->congeModel->db->error()
            ]);
        }

        return redirect()->to('employee/conges/mes-demandes')
            ->with('success', 'Demande envoyée avec succès');
    }

    /**
     * Afficher les demandes de congé de l'employé
     */
    public function mesDemandes()
    {
        // Vérifier que l'utilisateur est connecté
        if (!session()->has('logged_in') || !session('logged_in')) {
            return redirect()->to('employee/login')->with('error', 'Vous devez être connecté');
        }

        $employe_id = session('id');
        $demandes = $this->congeModel->getByEmploye($employe_id);

        // Enrichir les demandes avec les détails
        foreach ($demandes as &$demande) {
            $type = $this->typeCongeModel->find($demande['type_conge_id']);
            $demande['type_libelle'] = $type['libelle'] ?? 'N/A';
        }

        return view('employee/demande/mes_demandes', [
            'demandes' => $demandes
        ]);
    }

    /**
     * Afficher les demandes en attente (pour RH)
     */
    public function demandesEnAttente()
    {
        // Vérifier que l'utilisateur est RH ou ADMIN
        if (session('role') !== 'RH' && session('role') !== 'ADMIN') {
            return redirect()->back()->with('error', 'Accès refusé');
        }

        $demandes = $this->congeModel->getEnAttente();

        return view('employee/demande/demandes_en_attente', [
            'demandes' => $demandes
        ]);
    }

    /**
     * Approuver une demande (pour RH)
     */
    public function approuver($conge_id)
    {
        // Vérifier que l'utilisateur est RH ou ADMIN
        if (session('role') !== 'RH' && session('role') !== 'ADMIN') {
            return redirect()->back()->with('error', 'Accès refusé');
        }

        $commentaire = $this->request->getPost('commentaire');

        $conge = $this->congeModel->find($conge_id);

        if (!$conge) {
            return redirect()->back()->with('error', 'Congé non trouvé');
        }

        // Mettre à jour le statut
        if ($this->congeModel->updateStatut($conge_id, 'approuve', $commentaire)) {
            return redirect()->back()
                ->with('success', 'Demande approuvée');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'approbation');
        }
    }

    /**
     * Refuser une demande (pour RH)
     */
    public function refuser($conge_id)
    {
        // Vérifier que l'utilisateur est RH ou ADMIN
        if (session('role') !== 'RH' && session('role') !== 'ADMIN') {
            return redirect()->back()->with('error', 'Accès refusé');
        }

        $commentaire = $this->request->getPost('commentaire');

        $conge = $this->congeModel->find($conge_id);

        if (!$conge) {
            return redirect()->back()->with('error', 'Congé non trouvé');
        }

        // Mettre à jour le statut
        if ($this->congeModel->updateStatut($conge_id, 'refuse', $commentaire)) {
            return redirect()->back()
                ->with('success', 'Demande refusée');
        } else {
            return redirect()->back()
                ->with('error', 'Erreur lors du refus');
        }
    }
}

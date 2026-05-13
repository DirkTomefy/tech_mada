<?php

namespace App\Controllers;

use App\Models\CongesModel;
use App\Models\EmployeeModel;
use App\Models\DepartementModel;

class CongesController extends BaseController
{
    protected $congesModel;
    protected $employeeModel;
    protected $departementModel;

    public function __construct()
    {
        $this->congesModel = new CongesModel();
        $this->employeeModel = new EmployeeModel();
        $this->departementModel = new DepartementModel();
    }

    /**
     * Liste toutes les demandes de congés avec filtrage optionnel
     */
    public function index()
    {
        // Récupérer les filtres
        $statut = trim($this->request->getGet('statut') ?? '');
        $departementId = (int)($this->request->getGet('departement_id') ?? 0);

        // Récupérer les statistiques par statut depuis le model
        $stats = $this->congesModel->countByStatus($departementId ?: null);

        // Récupérer les absences du mois depuis le model
        $absences = $this->congesModel->getAbsencesCurrentMonth();

        // Récupérer les demandes récentes depuis le model
        $requests = $this->congesModel->getRequestsWithEmployees(20);

        // Récupérer le nombre d'absents aujourd'hui depuis le model
        $absencesToday = $this->congesModel->countAbsentsToday();

        // Nombre d'employés actifs depuis le model
        $employeesTotal = $this->employeeModel->countActive();

        // Nombre de départements depuis le model
        $departamentsTotal = count($this->departementModel->getAll());

        $data = [
            'title' => 'Vue d\'ensemble - Congés',
            'requests' => $requests,
            'stats' => $stats,
            'absences' => $absences,
            'employeesTotal' => $employeesTotal,
            'departamentsTotal' => $departamentsTotal,
            'absencesToday' => $absencesToday,
            'totalRequests' => count($requests),
            'selectedStatut' => $statut,
            'selectedDepartementId' => $departementId,
        ];

        return view('admin/conges/index', $data);
    }

    /**
     * Approuve une demande
     */
    public function approve($id)
    {
        $id = (int)$id;
        $userSession = session()->get();

        // Vérifier que l'utilisateur a les droits (RH ou ADMIN)
        if (!isset($userSession['id'])) {
            return redirect()->to('/employee/login')->with('error', 'Vous devez être connecté');
        }

        if ($this->congesModel->approveRequest($id, $userSession['id'])) {
            return redirect()->to('/admin/conges')->with('success', 'Demande approuvée avec succès');
        }

        $error = $this->congesModel->getBusinessError();
        return redirect()->back()->with('error', $error ?? 'Erreur lors de l\'approbation');
    }

    /**
     * Refuse une demande
     */
    public function refuse($id)
    {
        $id = (int)$id;
        $userSession = session()->get();
        $commentaire = trim($this->request->getPost('commentaire_rh') ?? '');

        // Vérifier que l'utilisateur a les droits
        if (!isset($userSession['id'])) {
            return redirect()->to('/employee/login')->with('error', 'Vous devez être connecté');
        }

        if ($this->congesModel->refuseRequest($id, $userSession['id'], $commentaire)) {
            return redirect()->to('/admin/conges')->with('success', 'Demande refusée');
        }

        $error = $this->congesModel->getBusinessError();
        return redirect()->back()->with('error', $error ?? 'Erreur lors du refus');
    }
}

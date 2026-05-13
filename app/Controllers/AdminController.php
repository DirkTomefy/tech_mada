<?php

namespace App\Controllers;

use App\Models\CongesModel;
use App\Models\DepartementModel;
use App\Models\EmployeeModel;
use App\Models\SoldeModel;
use Config\Database;

class AdminController extends BaseController
{
    protected EmployeeModel $employeeModel;
    protected SoldeModel $soldeModel;
    protected CongesModel $congesModel;
    protected DepartementModel $departementModel;
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->employeeModel = new EmployeeModel();
        $this->soldeModel = new SoldeModel();
        $this->congesModel = new CongesModel();
        $this->departementModel = new DepartementModel();
    }

    public function index()
    {
        $year = (int) date('Y');
        $employees = $this->employeeModel->getAllForAdmin();
        $departements = $this->departementModel->getAll();
        $balancesByYear = $this->soldeModel->getBalancesByYear($year);
        
        // Récupérer les statistiques du mois courant depuis les models
        $dashboardStats = $this->congesModel->getDashboardStatsCurrentMonth();
        $countByStatus = $this->congesModel->countByStatus();
        $absences = $this->congesModel->getAbsencesCurrentMonth();
        $absentsToday = $this->congesModel->countAbsentsToday();
        $requests = $this->congesModel->getRequestsWithEmployees(20);
        $employeesActive = $this->employeeModel->countActive();

        $data = [
            'title' => 'Vue d\'ensemble admin',
            'currentMonthLabel' => date('m/Y'),
            'stats' => $countByStatus,
            'dashboardStats' => $dashboardStats,
            'absences' => $absences,
            'absentsToday' => $absentsToday,
            'requests' => $requests,
            'employees' => $employees,
            'departements' => $departements,
            'balancesByYear' => $balancesByYear,
            'year' => $year,
            'typesConge' => $this->db->table('types_conge')->orderBy('libelle', 'ASC')->get()->getResultArray(),
            'generalStats' => [
                'employees_total' => count($employees),
                'employees_active' => $employeesActive,
                'absents_today' => $absentsToday,
                'departements_total' => count($departements),
                'balances_total' => count($balancesByYear),
                'pending_requests_total' => (int) ($countByStatus['en_attente'] ?? 0),
                'approved_requests_month' => (int) ($dashboardStats['approved'] ?? 0),
            ],
        ];

        return view('admin/dashboard', $data);
    }

    public function saveSolde()
    {
        $mode = trim((string) ($this->request->getPost('mode') ?? 'initialize'));
        $employeId = (int) $this->request->getPost('employe_id');
        $annee = (int) ($this->request->getPost('annee') ?? date('Y'));

        if ($employeId <= 0) {
            return redirect()->back()->withInput()->with('error', 'L\'employé est requis');
        }

        if ($mode === 'initialize') {
            if ($this->soldeModel->initializeEmployeeBalances($employeId, $annee)) {
                return redirect()->to('/admin')->with('success', 'Solde initialisé avec succès');
            }

            return redirect()->back()->withInput()->with('error', $this->soldeModel->getBusinessError() ?? 'Erreur lors de l\'initialisation du solde');
        }

        $payload = [
            'employe_id' => $employeId,
            'type_conge_id' => (int) $this->request->getPost('type_conge_id'),
            'annee' => $annee,
            'jours_attribues' => (float) $this->request->getPost('jours_attribues'),
            'jours_pris' => (float) ($this->request->getPost('jours_pris') ?? 0),
        ];

        if ($this->soldeModel->saveBalance($payload)) {
            return redirect()->to('/admin')->with('success', 'Solde enregistré avec succès');
        }

        $message = $this->soldeModel->getBusinessError();
        return redirect()->back()->withInput()->with('error', $message ?? 'Erreur lors de l\'enregistrement du solde');
    }
}

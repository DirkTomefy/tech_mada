<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\HTTP\ResponseInterface;

class EmployeeController extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    /**
     * Affiche la liste des employés
     */
    public function index()
    {
        $departementInput = $this->request->getGet('departement_id');
        $departementId = (is_numeric($departementInput) && (int) $departementInput > 0)
            ? (int) $departementInput
            : null;

        $employees = $this->employeeModel->getAllForAdmin($departementId);

        $data = [
            'title' => 'Gestion des Employés',
            'employees' => $employees,
            'totalEmployees' => count($employees),
            'selectedDepartementId' => $departementId,
        ];

        return view('admin/employee/index', $data);
    }

    /**
     * Affiche le formulaire de création d'un employé
     */
    public function create()
    {
        // Redirige vers la page unique qui contient le formulaire
        return redirect()->to('/employes');
    }

    /**
     * Stocke un nouvel employé
     */
    public function store()
    {
        $input = $this->request->getPost();

        // Valider les données avec les règles du modèle
        if (!$this->employeeModel->validate($input)) {
            session()->setFlashdata('errors', $this->employeeModel->errors());
            return redirect()->back()->withInput();
        }

        // Vérifier l'unicité de l'email
        if ($this->employeeModel->getByEmail($input['email'])) {
            session()->setFlashdata('error', 'Cet email existe déjà');
            return redirect()->back()->withInput();
        }

        // Tenter d'insérer l'employé
        if ($this->employeeModel->createEmployee($input)) {
            session()->setFlashdata('success', 'Employé créé avec succès');
            return redirect()->to('/admin/employes');
        }

        // Récupérer l'erreur de la base de données
        $dbError = $this->employeeModel->errors();
        $errorMsg = 'Erreur lors de la création de l\'employé';
        if (!empty($dbError)) {
            $errorMsg = implode(', ', $dbError);
        }
        
        log_message('error', 'Erreur insertion employé: ' . json_encode($dbError));
        return redirect()->back()->withInput()->with('error', $errorMsg);
    }

    /**
     * Affiche les détails d'un employé
     */
    public function show($id)
    {
        $employee = $this->employeeModel->getById($id);

        if (!$employee) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Employé non trouvé");
        }

        $data = [
            'title' => 'Détails de l\'employé',
            'employee' => $employee,
        ];

        return view('employee/show', $data);
    }

    /**
     * Affiche le formulaire d'édition d'un employé
     */
    public function edit($id)
    {
        $employee = $this->employeeModel->getById($id);

        if (!$employee) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Employé non trouvé");
        }

        $data = [
            'title' => 'Modifier l\'employé',
            'employee' => $employee,
        ];

        return view('employee/edit', $data);
    }

    /**
     * Met à jour un employé
     */
    public function update($id)
    {
        $input = $this->request->getPost();

        if ($this->employeeModel->updateEmployee($id, $input)) {
            return redirect()->to('/admin/employes')->with('success', 'Employé modifié avec succès');
        }

        $errors = $this->employeeModel->errors();
        $businessError = $this->employeeModel->getBusinessError();

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        return redirect()->back()->withInput()->with('error', $businessError ?? 'Erreur lors de la modification de l\'employé');
    }

    /**
     * Supprime un employé (soft delete)
     */
    public function delete($id)
    {
        if ($this->employeeModel->deleteEmployee($id)) {
            return redirect()->to('/admin/employes')->with('success', 'Employé supprimé avec succès');
        }

        $businessError = $this->employeeModel->getBusinessError();
        return redirect()->back()->with('error', $businessError ?? 'Erreur lors de la suppression de l\'employé');
    }

    /**
     * Récupère les employés par rôle (API)
     */
    public function getByRole($role)
    {
        return $this->response
            ->setHeader('Content-Type', 'application/json')
            ->setJSON(['data' => $this->employeeModel->getByRole($role)]);
    }

    /**
     * Récupère les employés par département (API)
     */
    public function getByDepartement($departement_id)
    {
        return $this->response
            ->setHeader('Content-Type', 'application/json')
            ->setJSON(['data' => $this->employeeModel->getByDepartement($departement_id)]);
    }
}

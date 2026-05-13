<?php

namespace App\Controllers;

use App\Models\DepartementModel;

class DepartementController extends BaseController
{
    protected $departementModel;

    public function __construct()
    {
        $this->departementModel = new DepartementModel();
    }

    public function index()
    {
        $departements = $this->departementModel->getAllWithEmployeeCount();

        $data = [
            'title' => 'Gestion des départements',
            'departements' => $departements,
            'totalDepartements' => count($departements),
        ];

        return view('admin/departement/index', $data);
    }

    public function store()
    {
        $input = $this->request->getPost();

        if ($this->departementModel->createDepartement($input)) {
            return redirect()->to('/admin/departements')->with('success', 'Département créé avec succès');
        }

        $errors = $this->departementModel->errors();
        $businessError = $this->departementModel->getBusinessError();

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        return redirect()->back()->withInput()->with('error', $businessError ?? 'Erreur lors de la création du département');
    }

    public function edit($id)
    {
        $departement = $this->departementModel->getById($id);

        if (!$departement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Département non trouvé');
        }

        $data = [
            'title' => 'Modifier le département',
            'departement' => $departement,
        ];

        return view('admin/departement/edit', $data);
    }

    public function update($id)
    {
        $input = $this->request->getPost();

        if ($this->departementModel->updateDepartement($id, $input)) {
            return redirect()->to('/admin/departements')->with('success', 'Département modifié avec succès');
        }

        $errors = $this->departementModel->errors();
        $businessError = $this->departementModel->getBusinessError();

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        return redirect()->back()->withInput()->with('error', $businessError ?? 'Erreur lors de la modification du département');
    }

    public function delete($id)
    {
        if ($this->departementModel->deleteDepartement($id)) {
            return redirect()->to('/admin/departements')->with('success', 'Département supprimé avec succès');
        }

        $businessError = $this->departementModel->getBusinessError();
        return redirect()->back()->with('error', $businessError ?? 'Erreur lors de la suppression du département');
    }
}

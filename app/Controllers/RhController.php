<?php

namespace App\Controllers;

use App\Models\CongesModel;
use App\Models\DepartementModel;

class RhController extends BaseController
{
    protected CongesModel $congesModel;
    protected DepartementModel $departementModel;

    public function __construct()
    {
        $this->congesModel = new CongesModel();
        $this->departementModel = new DepartementModel();
    }

    public function index()
    {
        $statut = trim((string) ($this->request->getGet('statut') ?? ''));
        $departementId = (int) ($this->request->getGet('departement_id') ?? 0);

        $requests = $this->congesModel->getFilteredRequestsWithEmployees(
            $statut ?: null,
            $departementId ?: null,
            100
        );

        $data = [
            'title' => 'Liste RH - Validation',
            'requests' => $requests,
            'stats' => $this->congesModel->countByStatus($departementId ?: null),
            'departements' => $this->departementModel->getAll(),
            'selectedStatut' => $statut,
            'selectedDepartementId' => $departementId,
            'pendingCount' => $this->congesModel->countByStatus($departementId ?: null)['en_attente'] ?? 0,
        ];

        return view('rh/index', $data);
    }

    public function approve($id)
    {
        $id = (int) $id;
        $userSession = session()->get();

        if (!isset($userSession['id'])) {
            return redirect()->to('/employee/login')->with('error', 'Vous devez être connecté');
        }

        if ($this->congesModel->approveRequest($id, $userSession['id'])) {
            return redirect()->to('/rh')->with('success', 'Demande approuvée avec succès');
        }

        return redirect()->back()->with('error', $this->congesModel->getBusinessError() ?? 'Erreur lors de l\'approbation');
    }

    public function refuse($id)
    {
        $id = (int) $id;
        $userSession = session()->get();
        $commentaire = trim((string) ($this->request->getPost('commentaire_rh') ?? ''));

        if (!isset($userSession['id'])) {
            return redirect()->to('/employee/login')->with('error', 'Vous devez être connecté');
        }

        if ($this->congesModel->refuseRequest($id, $userSession['id'], $commentaire)) {
            return redirect()->to('/rh')->with('success', 'Demande refusée');
        }

        return redirect()->back()->with('error', $this->congesModel->getBusinessError() ?? 'Erreur lors du refus');
    }
}

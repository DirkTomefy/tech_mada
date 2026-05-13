<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes demandes de congé — TechMada RH</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/style.css') ?>" rel="stylesheet">
</head>

<body>

<section id="page-mes-conges" style="margin-top:3rem">

<div class="app-wrap">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-brand">

            <div class="sidebar-logo-icon">
                <i class="bi bi-briefcase"></i>
            </div>

            <div class="sidebar-brand-name">
                TechMada RH
                <span>Espace employé</span>
            </div>

        </div>

        <ul class="sidebar-nav" style="margin-top:1rem">

            <li>
                <a href="<?= base_url('employee/dashboard') ?>">
                    <i class="bi bi-grid-1x2"></i>
                    Tableau de bord
                </a>
            </li>

            <li>
                <a href="<?= base_url('employee/conges/formulaire') ?>">
                    <i class="bi bi-plus-circle"></i>
                    Nouvelle demande
                </a>
            </li>

            <li>
                <a href="<?= base_url('employee/conges/mes-demandes') ?>" class="active">
                    <i class="bi bi-calendar3"></i>
                    Mes demandes
                </a>
            </li>

            <li>
                <a href="<?= base_url('employee/dashboard#profil') ?>">
                    <i class="bi bi-person"></i>
                    Mon profil
                </a>
            </li>

        </ul>

        <div class="sidebar-user">

            <div class="s-user-row">

                <div class="avatar av-green">
                    <?= strtoupper(substr(session('user_nom') ?? 'U', 0, 1)) ?>
                </div>

                <div>

                    <div class="user-name">
                        <?= esc(session('user_nom_complet') ?? 'Employé') ?>
                    </div>

                    <div class="user-role">
                        Employé
                    </div>

                </div>

            </div>

        </div>

    </aside>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>

                <div class="topbar-title">
                    Mes demandes de congé
                </div>

                <div class="topbar-breadcrumb">

                    <a href="<?= base_url('employee/dashboard') ?>">
                        Accueil
                    </a>

                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i>

                    Mes demandes

                </div>

            </div>

            <div class="topbar-actions">

                <a
                    href="<?= base_url('employee/conges/formulaire') ?>"
                    class="btn-forest"
                    style="padding:7px 14px;font-size:.82rem"
                >
                    <i class="bi bi-plus-lg"></i>
                    Nouvelle demande
                </a>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- SUCCESS -->
            <?php if (session()->has('success')): ?>

                <div class="flash flash-success" style="margin-bottom:1rem;">

                    <i class="bi bi-check-circle-fill"></i>

                    <span><?= session('success') ?></span>

                </div>

            <?php endif; ?>

            <!-- ERROR -->
            <?php if (session()->has('error')): ?>

                <div class="flash flash-error" style="margin-bottom:1rem;">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <span><?= session('error') ?></span>

                </div>

            <?php endif; ?>

            <!-- TABLE -->
            <div class="data-card">

                <div class="data-card-head">

                    <h3>Toutes mes demandes</h3>

                    <div style="display:flex;gap:6px">

                        <select
                            class="f-select"
                            style="font-size:.8rem;padding:6px 10px;width:auto"
                        >
                            <option>Tous les statuts</option>
                            <option>En attente</option>
                            <option>Approuvée</option>
                            <option>Refusée</option>
                            <option>Annulée</option>
                        </select>

                    </div>

                </div>

                <?php if (!empty($demandes)): ?>

                    <table class="tbl">

                        <thead>

                            <tr>
                                <th>Type</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Commentaire RH</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($demandes as $demande): ?>

                                <?php

                                    $statutClass = '';

                                    switch ($demande['statut']) {

                                        case 'en_attente':
                                            $statutClass = 's-attente';
                                            break;

                                        case 'approuve':
                                            $statutClass = 's-approuvee';
                                            break;

                                        case 'refuse':
                                            $statutClass = 's-refusee';
                                            break;

                                        case 'annule':
                                            $statutClass = 's-annulee';
                                            break;
                                    }

                                    $typeClass = 't-annuel';

                                    $typeLower = strtolower($demande['type_libelle']);

                                    if (str_contains($typeLower, 'maladie')) {
                                        $typeClass = 't-maladie';
                                    }

                                    if (str_contains($typeLower, 'special')) {
                                        $typeClass = 't-special';
                                    }

                                    if (str_contains($typeLower, 'sans')) {
                                        $typeClass = 't-sans-solde';
                                    }

                                ?>

                                <tr>

                                    <!-- TYPE -->
                                    <td>

                                        <span class="type-badge <?= $typeClass ?>">

                                            <?= esc($demande['type_libelle']) ?>

                                        </span>

                                    </td>

                                    <!-- DATE DEBUT -->
                                    <td class="td-muted">

                                        <?= date('d M Y', strtotime($demande['date_debut'])) ?>

                                    </td>

                                    <!-- DATE FIN -->
                                    <td class="td-muted">

                                        <?= date('d M Y', strtotime($demande['date_fin'])) ?>

                                    </td>

                                    <!-- DUREE -->
                                    <td class="td-mono">

                                        <?= esc($demande['nb_jours']) ?> j

                                    </td>

                                    <!-- STATUT -->
                                    <td>

                                        <span class="statut <?= $statutClass ?>">

                                            <?php

                                                $statuts = [
                                                    'en_attente' => 'en attente',
                                                    'approuve' => 'approuvée',
                                                    'refuse' => 'refusée',
                                                    'annule' => 'annulée'
                                                ];

                                                echo $statuts[$demande['statut']] ?? 'inconnu';

                                            ?>

                                        </span>

                                    </td>

                                    <!-- COMMENTAIRE RH -->
                                    <td
                                        class="td-muted"
                                        style="font-size:.78rem"
                                    >

                                        <?php if (!empty($demande['commentaire_rh'])): ?>

                                            <?= esc($demande['commentaire_rh']) ?>

                                        <?php else: ?>

                                            —

                                        <?php endif; ?>

                                    </td>

                                    <!-- ACTION -->
                                    <td>

                                        <?php if ($demande['statut'] == 'en_attente'): ?>

                                            <a
                                                href="<?= base_url('employee/conges/annuler/' . $demande['id']) ?>"
                                                class="btn-sm btn-cancel"
                                                onclick="return confirm('Annuler cette demande ?')"
                                            >
                                                <i class="bi bi-x"></i>
                                                Annuler
                                            </a>

                                        <?php else: ?>

                                            <span
                                                class="td-muted"
                                                style="font-size:.75rem"
                                            >
                                                —
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                <?php else: ?>

                    <!-- EMPTY -->
                    <div
                        style="
                            padding:3rem 1rem;
                            text-align:center;
                            color:var(--muted)
                        "
                    >

                        <i
                            class="bi bi-inbox"
                            style="
                                font-size:3rem;
                                opacity:.3;
                                display:block;
                                margin-bottom:1rem
                            "
                        ></i>

                        <h3 style="margin-bottom:.5rem;">
                            Aucune demande
                        </h3>

                        <p style="margin-bottom:1.5rem;font-size:.9rem;">

                            Vous n'avez encore soumis aucune demande
                            de congé.

                        </p>

                        <a
                            href="<?= base_url('employee/conges/formulaire') ?>"
                            class="btn-forest"
                        >
                            <i class="bi bi-plus-circle"></i>
                            Créer une demande
                        </a>

                    </div>

                <?php endif; ?>

            </div>

            <!-- INFO -->
            <div
                style="
                    margin-top:1rem;
                    padding:1rem;
                    background:var(--white);
                    border:1px solid var(--border);
                    border-radius:8px;
                    font-size:.85rem;
                    color:var(--muted)
                "
            >

                <i
                    class="bi bi-info-circle"
                    style="color:var(--info);margin-right:8px"
                ></i>

                <strong>Informations :</strong>

                Les demandes en attente sont en cours de traitement
                par le RH.

            </div>

        </div>

        <!-- FOOTER -->
        <div class="footer-app">

            <i class="bi bi-c-circle"></i>

            2025

            <span>TechMada RH</span>

        </div>

    </div>

</div>

</section>

</body>
</html>
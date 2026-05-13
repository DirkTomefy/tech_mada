<?php 
echo session('id');?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de congé — TechMada RH</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/style.css') ?>" rel="stylesheet">
</head>

<body>

<section id="page-form-conge" style="margin-top:3rem">

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
                <a href="<?= base_url('employee/conges/nouveau') ?>" class="active">
                    <i class="bi bi-plus-circle"></i>
                    Nouvelle demande
                </a>
            </li>

            <li>
                <a href="<?= base_url('employee/conges/mes-demandes') ?>">
                    <i class="bi bi-calendar3"></i>
                    Mes demandes
                </a>
            </li>

            <li>
                <a href="<?= base_url('employee/profil') ?>">
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
                    Nouvelle demande de congé
                </div>

                <div class="topbar-breadcrumb">
                    <a href="<?= base_url('employee/dashboard') ?>">Accueil</a>

                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i>

                    Nouvelle demande
                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- MESSAGE ERREUR -->
            <?php if (session()->has('error')): ?>
                <div class="flash flash-error" style="margin-bottom:1rem;">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= session('error') ?></span>
                </div>
            <?php endif; ?>

            <!-- MESSAGE SUCCESS -->
            <?php if (session()->has('success')): ?>
                <div class="flash flash-success" style="margin-bottom:1rem;">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= session('success') ?></span>
                </div>
            <?php endif; ?>

            <!-- ERREURS VALIDATION -->
            <?php if (session()->has('errors')): ?>

                <div class="flash flash-error" style="margin-bottom:1rem;">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <div>
                        <?php foreach (session('errors') as $error): ?>
                            <div><?= esc($error) ?></div>
                        <?php endforeach; ?>
                    </div>

                </div>

            <?php endif; ?>

            <div class="form-layout">

                <!-- FORMULAIRE -->
                <div>

                    <div class="form-section">

                        <h3>Détails de la demande</h3>

                        <form
                            method="POST"
                            action="<?= base_url('employee/conges/soumettre') ?>"
                            id="congeForm"
                        >

                            <?= csrf_field() ?>

                            <!-- TYPE -->
                            <div class="f-group" style="margin-bottom:1rem;">

                                <label class="f-label">
                                    Type de congé
                                    <span style="color:var(--danger)">*</span>
                                </label>

                                <select
                                    name="type_conge_id"
                                    class="f-select"
                                    id="typeCongeSelect"
                                    required
                                    onchange="updateSoldeInfo()"
                                >

                                    <option value="">
                                        -- Choisir un type --
                                    </option>

                                    <?php foreach ($types_conge as $type): ?>

                                        <option
                                            value="<?= $type['id'] ?>"
                                            data-jours="<?= $type['jours_annuels'] ?>"
                                            <?= old('type_conge_id') == $type['id'] ? 'selected' : '' ?>
                                        >
                                            <?= esc($type['libelle']) ?>
                                            (<?= $type['jours_annuels'] ?> jours/an)
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                                <?php if(session('errors.type_conge_id')): ?>

                                    <div class="f-error">
                                        <i class="bi bi-exclamation-circle"></i>
                                        <?= session('errors.type_conge_id') ?>
                                    </div>

                                <?php endif; ?>

                            </div>

                            <!-- DATES -->
                            <div class="form-grid-2" style="margin-bottom:1rem;">

                                <div class="f-group">

                                    <label class="f-label">
                                        Date de début
                                        <span style="color:var(--danger)">*</span>
                                    </label>

                                    <input
                                        type="date"
                                        name="date_debut"
                                        class="f-input"
                                        id="dateDebut"
                                        required
                                        onchange="calculerJours()"
                                        value="<?= old('date_debut') ?>"
                                    />

                                </div>

                                <div class="f-group">

                                    <label class="f-label">
                                        Date de fin
                                        <span style="color:var(--danger)">*</span>
                                    </label>

                                    <input
                                        type="date"
                                        name="date_fin"
                                        class="f-input"
                                        id="dateFin"
                                        required
                                        onchange="calculerJours()"
                                        value="<?= old('date_fin') ?>"
                                    />

                                </div>

                            </div>

                            <!-- CALCUL -->
                            <div class="f-computed" id="joursPreview" style="display:none;">

                                <div class="f-computed-num" id="joursCount">
                                    0
                                </div>

                                <div class="f-computed-label">
                                    jours calendaires calculés
                                    <br>

                                    <span
                                        id="joursTexte"
                                        style="font-size:.7rem;opacity:.7"
                                    ></span>
                                </div>

                            </div>

                            <!-- MOTIF -->
                            <div class="f-group" style="margin-bottom:1rem;">

                                <label class="f-label">
                                    Motif
                                    <span style="color:var(--danger)">*</span>
                                </label>

                                <textarea
                                    name="motif"
                                    class="f-textarea"
                                    placeholder="Précisez le motif de votre demande..."
                                    required
                                ><?= old('motif') ?></textarea>

                                <div class="f-hint">
                                    Le motif est visible par le responsable RH.
                                </div>

                            </div>

                            <!-- ACTIONS -->
                            <div class="form-actions">

                                <button class="btn-forest" type="submit">
                                    <i class="bi bi-send"></i>
                                    Soumettre la demande
                                </button>

                                <a
                                    href="<?= base_url('employee/conges/mes-demandes') ?>"
                                    class="btn-secondary"
                                >
                                    <i class="bi bi-x"></i>
                                    Annuler
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

                <!-- SIDEBAR DROITE -->
                <div style="display:flex;flex-direction:column;gap:1rem">

                    <!-- SOLDES -->
                    <div class="data-card" style="margin:0">

                        <div class="data-card-head">

                            <h3>
                                <i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>
                                Vos soldes actuels
                            </h3>

                        </div>

                        <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">

                            <?php foreach ($types_conge as $type): ?>

                                <?php
                                    $solde = $soldes_par_type[$type['id']] ?? null;

                                    $joursAttribues = $solde['jours_attribues'] ?? 0;
                                    $joursPris = $solde['jours_pris'] ?? 0;
                                    $joursRestants = $joursAttribues - $joursPris;

                                    $pourcentage = 0;

                                    if($joursAttribues > 0){
                                        $pourcentage = ($joursRestants / $joursAttribues) * 100;
                                    }
                                ?>

                                <div>

                                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">

                                        <span style="font-size:.8rem;color:var(--ink)">
                                            <?= esc($type['libelle']) ?>
                                        </span>

                                        <span
                                            style="
                                                font-family:'DM Mono',monospace;
                                                font-size:.8rem;
                                                color:<?= $joursRestants <= 2 ? 'var(--warn)' : 'var(--forest)' ?>;
                                                font-weight:500
                                            "
                                        >
                                            <?= $joursRestants ?> j
                                        </span>

                                    </div>

                                    <div class="solde-bar">

                                        <div
                                            class="solde-fill <?= $joursRestants <= 2 ? 'warn' : '' ?>"
                                            style="width:<?= $pourcentage ?>%"
                                        ></div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                    <!-- INFO -->
                    <div class="flash flash-info" style="margin:0">

                        <i class="bi bi-info-circle-fill"></i>

                        <span style="font-size:.8rem">
                            Le solde est déduit uniquement à l'approbation
                            de votre responsable.
                        </span>

                    </div>

                    <!-- REGLES -->
                    <div
                        style="
                            background:var(--cream);
                            border:1px solid var(--border);
                            border-radius:8px;
                            padding:.85rem 1rem
                        "
                    >

                        <div
                            style="
                                font-size:.78rem;
                                font-weight:500;
                                color:var(--ink);
                                margin-bottom:.5rem
                            "
                        >

                            <i
                                class="bi bi-clipboard-check"
                                style="color:var(--forest);margin-right:5px"
                            ></i>

                            Rappel des règles

                        </div>

                        <ul
                            style="
                                margin:0;
                                padding-left:1rem;
                                font-size:.75rem;
                                color:var(--muted);
                                line-height:1.7
                            "
                        >
                            <li>Préavis minimum : 48h avant la date de début</li>
                            <li>Pas de chevauchement avec une demande en cours</li>
                            <li>Solde insuffisant = demande refusée automatiquement</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="footer-app">
            <i class="bi bi-c-circle"></i>
            2025
            <span>TechMada RH</span>
        </div>

    </div>

</div>

</section>

<script>

    function calculerJours(){

        const dateDebut = document.getElementById('dateDebut').value;
        const dateFin = document.getElementById('dateFin').value;

        if(dateDebut && dateFin){

            const debut = new Date(dateDebut);
            const fin = new Date(dateFin);

            if(fin >= debut){

                fin.setDate(fin.getDate() + 1);

                const diff = fin - debut;

                const jours = Math.ceil(
                    diff / (1000 * 60 * 60 * 24)
                );

                document.getElementById('joursPreview').style.display = 'flex';

                document.getElementById('joursCount').textContent = jours;

                document.getElementById('joursTexte').textContent =
                    'Du ' + dateDebut + ' au ' + dateFin;
            }
        }
    }

    function updateSoldeInfo(){
        // tu peux ajouter ton JS dynamique ici
    }

    document.addEventListener('DOMContentLoaded', function(){
        calculerJours();
    });

</script>

</body>
</html>
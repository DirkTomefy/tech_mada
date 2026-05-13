<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title><?= esc($title ?? 'Modifier le département') ?> — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= base_url('/assets/css/template.css') ?>">
</head>
<body>
<div class="app-wrap">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-icon"><i class="bi bi-shield-check"></i></div>
            <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
        </div>
        <div class="sidebar-section">Gestion</div>
        <ul class="sidebar-nav">
            <li><a href="<?= site_url('admin') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
            <li><a href="<?= site_url('admin') ?>#solde"><i class="bi bi-wallet2"></i> Solde employé</a></li>
            <li><a href="<?= site_url('admin') ?>#demandes"><i class="bi bi-inbox"></i> Demandes</a></li>
            <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
            <li><a href="<?= site_url('admin/departements') ?>" class="active"><i class="bi bi-building"></i> Départements</a></li>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Modifier le département</div>
                <div class="topbar-breadcrumb">
                    <a href="<?= site_url('admin') ?>">Admin</a>
                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i>
                    <a href="<?= site_url('admin/departements') ?>">Départements</a>
                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Modifier
                </div>
            </div>
        </div>

        <div class="content">
            <?php $errors = session()->getFlashdata('errors') ?? []; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="flash flash-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('admin/departements/update/' . ($departement['id'] ?? '')) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-section">
                    <h3><i class="bi bi-pencil" style="color:var(--forest);margin-right:6px"></i>Modifier : <?= esc($departement['nom'] ?? '') ?></h3>

                    <div class="form-grid-2">
                        <div class="f-group">
                            <label class="f-label">Nom <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="nom" class="f-input" value="<?= esc(old('nom', $departement['nom'] ?? '')) ?>" required/>
                            <?php if (isset($errors['nom'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['nom']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Description</label>
                            <input type="text" name="description" class="f-input" value="<?= esc(old('description', $departement['description'] ?? '')) ?>"/>
                            <?php if (isset($errors['description'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['description']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top:1.5rem">
                        <button type="submit" class="btn-forest"><i class="bi bi-save"></i> Enregistrer</button>
                        <a href="<?= site_url('admin/departements') ?>" class="btn-secondary">Annuler</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="footer-app">
            <i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span>
        </div>
    </div>
</div>
</body>
</html>

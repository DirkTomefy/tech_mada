<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title><?= esc($title ?? 'Gestion des départements') ?> — TechMada RH</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="<?= base_url('/assets/css/template.css') ?>">
</head>
<body>
<section style="margin-top:3rem">
<div class="app-wrap">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="#"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
      <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
      <li><a href="<?= site_url('admin/departements') ?>" class="active"><i class="bi bi-building"></i> Départements</a></li>
    </ul>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Gestion des départements</div>
        <div class="topbar-breadcrumb"><a href="#">Admin</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Départements</div>
      </div>
    </div>

    <div class="content">

      <?php $errors = session()->getFlashdata('errors') ?? []; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="flash flash-success">
          <i class="bi bi-check-circle-fill"></i>
          <span><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="flash flash-danger">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <span><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
      <?php endif; ?>

      <div class="form-section">
        <h3><i class="bi bi-building-add" style="color:var(--forest);margin-right:6px"></i>Ajouter un département</h3>
        <form method="POST" action="<?= site_url('admin/departements/save') ?>">
          <?= csrf_field() ?>
          <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
              <label class="f-label">Nom <span style="color:var(--danger)">*</span></label>
              <input type="text" name="nom" class="f-input" value="<?= esc(old('nom')) ?>" placeholder="Ex: Informatique" required />
              <?php if (isset($errors['nom'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['nom']) ?></div>
              <?php endif; ?>
            </div>
            <div class="f-group">
              <label class="f-label">Description</label>
              <input type="text" name="description" class="f-input" value="<?= esc(old('description')) ?>" placeholder="Description du département" />
              <?php if (isset($errors['description'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['description']) ?></div>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer le département</button>
            <button type="reset" class="btn-secondary">Réinitialiser</button>
          </div>
        </form>
      </div>

      <div class="data-card">
        <div class="data-card-head">
          <h3>Tous les départements</h3>
          <p style="font-size:.8rem;color:var(--muted);margin:0">Total : <?= esc($totalDepartements ?? 0) ?></p>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Nom</th><th>Description</th><th>Employés</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($departements)): ?>
              <?php foreach ($departements as $departement): ?>
                <tr>
                  <td><strong><?= esc($departement['nom'] ?? '') ?></strong></td>
                  <td class="td-muted"><?= esc($departement['description'] ?? '—') ?></td>
                  <td><span class="type-badge"><?= esc($departement['employee_count'] ?? 0) ?></span></td>
                  <td>
                    <div class="action-btns">
                      <a href="<?= site_url('admin/departements/edit/' . ($departement['id'] ?? '')) ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a>
                      <a href="<?= site_url('admin/departements/delete/' . ($departement['id'] ?? '')) ?>" class="btn-sm btn-del" onclick="return confirm('Supprimer ce département ?')"><i class="bi bi-slash-circle"></i></a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" class="td-muted">Aucun département trouvé.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
    <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span></div>
  </div>

</div>
</section>
</body>
</html>

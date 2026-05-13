<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>TechMada RH — Gestion des congés CI4</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="<?= base_url('/assets/css/template.css') ?>">
</head>
<body>

<!-- Admin — employes (formulaire + liste) -->
<section id="page-admin-employes" style="margin-top:3rem">
<div class="app-wrap">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="<?= site_url('admin') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
      <li><a href="<?= site_url('admin') ?>#solde"><i class="bi bi-wallet2"></i> Solde employé</a></li>
      <li><a href="<?= site_url('admin') ?>#demandes"><i class="bi bi-inbox"></i> Demandes</a></li>
      <li><a href="<?= site_url('admin/employes') ?>" class="active"><i class="bi bi-people"></i> Employés</a></li>
      <li><a href="<?= site_url('admin/departements') ?>"><i class="bi bi-building"></i> Départements</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar" style="background:#5a2d82;width:32px;height:32px;font-size:.7rem">AD</div>
        <div><div class="user-name">Administrateur</div><div class="user-role">Admin système</div></div>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Gestion des employés</div>
        <div class="topbar-breadcrumb"><a href="<?= site_url('admin') ?>">Admin</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Employés</div>
      </div>
      <div class="topbar-actions">
        <a href="<?= site_url('employes/create') ?>" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-person-plus"></i> Ajouter</a>
      </div>
    </div>

    <div class="content">

      <!-- Formulaire ajout -->
      <div class="form-section">
        <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
        <form method="POST" action="<?= site_url('employes/save') ?>">
          <?= csrf_field() ?>
          <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
              <label class="f-label">Prénom</label>
              <input type="text" name="prenom" class="f-input" value="<?= old('prenom') ?>"/>
            </div>
            <div class="f-group">
              <label class="f-label">Nom</label>
              <input type="text" name="nom" class="f-input" value="<?= old('nom') ?>"/>
            </div>
            <div class="f-group">
              <label class="f-label">Email</label>
              <input type="email" name="email" class="f-input" value="<?= old('email') ?>"/>
            </div>
            <div class="f-group">
              <label class="f-label">Mot de passe initial</label>
              <input type="password" name="password" class="f-input" />
            </div>
            <div class="f-group">
              <label class="f-label">Département</label>
              <select name="departement_id" class="f-select">
                <option value="">-- Aucun --</option>
                <option value="1" <?= old('departement_id') == '1' ? 'selected' : '' ?>>IT</option>
                <option value="2" <?= old('departement_id') == '2' ? 'selected' : '' ?>>Finance</option>
                <option value="3" <?= old('departement_id') == '3' ? 'selected' : '' ?>>Marketing</option>
                <option value="4" <?= old('departement_id') == '4' ? 'selected' : '' ?>>RH</option>
              </select>
            </div>
            <div class="f-group">
              <label class="f-label">Rôle</label>
              <select name="role" class="f-select">
                <option value="EMPLOYE" <?= old('role') == 'EMPLOYE' ? 'selected' : '' ?>>Employé</option>
                <option value="RH" <?= old('role') == 'RH' ? 'selected' : '' ?>>Responsable RH</option>
                <option value="ADMIN" <?= old('role') == 'ADMIN' ? 'selected' : '' ?>>Administrateur</option>
              </select>
            </div>
            <div class="f-group">
              <label class="f-label">Date d'embauche</label>
              <input type="date" name="date_embauche" class="f-input" value="<?= old('date_embauche', date('Y-m-d')) ?>"/>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer l'employé</button>
            <button type="reset" class="btn-secondary">Réinitialiser</button>
          </div>
        </form>
      </div>

      <!-- Liste employés -->
      <div class="data-card">
        <div class="data-card-head">
          <h3>Tous les employés</h3>
          <form method="GET" action="<?= site_url('admin/employes') ?>" style="display:flex;gap:6px">
            <input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem"/>
            <select name="departement_id" class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto" onchange="this.form.submit()">
              <option value="">Tous les depts</option>
              <option value="1" <?= (int) ($selectedDepartementId ?? 0) === 1 ? 'selected' : '' ?>>IT</option>
              <option value="2" <?= (int) ($selectedDepartementId ?? 0) === 2 ? 'selected' : '' ?>>Finance</option>
              <option value="3" <?= (int) ($selectedDepartementId ?? 0) === 3 ? 'selected' : '' ?>>Marketing</option>
              <option value="4" <?= (int) ($selectedDepartementId ?? 0) === 4 ? 'selected' : '' ?>>RH</option>
            </select>
          </form>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Employé</th><th>Département</th><th>Rôle</th><th>Embauche</th><th>Statut</th><th>Solde annuel</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($employees)): ?>
                <?php foreach ($employees as $emp): ?>
                    <tr>
                      <td>
                        <div class="profile-row">
                          <div class="avatar" style="width:32px;height:32px;font-size:.68rem"><?= esc(strtoupper(substr($emp['prenom'] ?? '',0,1) . substr($emp['nom'] ?? '',0,1))) ?></div>
                          <div class="profile-info"><div class="pname"><?= esc(($emp['prenom'] ?? '') . ' ' . ($emp['nom'] ?? '')) ?></div><div class="pdept"><?= esc($emp['email'] ?? '') ?></div></div>
                        </div>
                      </td>
                      <td class="td-muted"><?= esc($emp['departement_id'] ?? '—') ?></td>
                      <td><span class="type-badge"><?= esc(strtolower($emp['role'] ?? '')) ?></span></td>
                      <td class="td-muted td-mono" style="font-size:.78rem"><?= esc($emp['date_embauche'] ?? '') ?></td>
                      <td><span class="statut <?= ($emp['actif'] ?? 0) ? 's-approuvee' : 's-annulee' ?>" style="font-size:.68rem"><?= ($emp['actif'] ?? 0) ? 'actif' : 'inactif' ?></span></td>
                      <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--forest)">—</span></td>
                      <td>
                        <div class="action-btns">
                          <a href="<?= site_url('employes/edit/' . ($emp['id'] ?? '')) ?>" class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</a>
                          <a href="<?= site_url('employes/delete/' . ($emp['id'] ?? '')) ?>" class="btn-sm btn-del" onclick="return confirm('Supprimer cet employé ?')"><i class="bi bi-slash-circle"></i></a>
                        </div>
                      </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="td-muted">Aucun employé trouvé.</td></tr>
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

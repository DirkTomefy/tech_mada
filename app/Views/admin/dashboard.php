<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title><?= esc($title ?? 'Admin') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="<?= base_url('assets/css/template.css') ?>">
</head>
<body>
<div class="app-wrap">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
    </div>
    <div class="sidebar-section">Gestion</div>
    <ul class="sidebar-nav">
      <li><a href="#vue-ensemble" class="active"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
      <li><a href="#solde"><i class="bi bi-wallet2"></i> Solde employé</a></li>
      <li><a href="#demandes"><i class="bi bi-inbox"></i> Demandes</a></li>
      <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
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
        <div class="topbar-title">Vue d'ensemble admin</div>
        <div class="topbar-breadcrumb">Absences, soldes et demandes</div>
      </div>
      <div class="topbar-actions">
        <a href="#solde" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-wallet2"></i> Gérer les soldes</a>
      </div>
    </div>

    <div class="content">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="flash flash-success"><i class="bi bi-check-circle-fill"></i> <?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="flash flash-error"><i class="bi bi-exclamation-circle-fill"></i> <?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

    

      <div class="data-card" style="margin-bottom:1.5rem" id="infos-generales">
        <div class="data-card-head">
          <h3>Informations générales</h3>
          <div class="td-muted">Résumé global de l'administration</div>
        </div>
        <div style="padding:1rem 1.25rem;">
          <div class="metrics" style="margin-bottom:0">
            <div class="metric">
              <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-people"></i></div></div>
              <div class="metric-val"><?= esc($generalStats['employees_active'] ?? 0) ?></div>
              <div class="metric-label">Employés actifs</div>
              <div class="metric-sub up"><i class="bi bi-arrow-up-short"></i> +2 ce mois</div>
            </div>
            <div class="metric">
              <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
              <div class="metric-val"><?= esc($generalStats['pending_requests_total'] ?? 0) ?></div>
              <div class="metric-label">Demandes en attente</div>
            </div>
            <div class="metric">
              <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
              <div class="metric-val"><?= esc($generalStats['approved_requests_month'] ?? 0) ?></div>
              <div class="metric-label">Approuvées ce mois</div>
              <div class="metric-sub up"><i class="bi bi-arrow-up-short"></i> +6 vs mois dernier</div>
            </div>
            <div class="metric">
              <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-building"></i></div></div>
              <div class="metric-val"><?= esc($generalStats['departements_total'] ?? 0) ?></div>
              <div class="metric-label">Départements</div>
            </div>
            <div class="metric">
              <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-person-slash"></i></div></div>
              <div class="metric-val"><?= esc($generalStats['absents_today'] ?? 0) ?></div>
              <div class="metric-label">Absents aujourd'hui</div>
            </div>
          </div>
        </div>
      </div>

      <div class="data-card" id="solde">
        <div class="data-card-head">
          <h3>Initialiser / ajouter un solde</h3>
        </div>
        <div style="padding:1rem 1.25rem;">
          <form method="POST" action="<?= site_url('admin/solde/save') ?>">
            <?= csrf_field() ?>
            <div class="form-grid-2">
              <div class="f-group">
                <label class="f-label">Employé</label>
                <select name="employe_id" class="f-select" required>
                  <option value="">-- Choisir --</option>
                  <?php foreach (($employees ?? []) as $emp): ?>
                    <option value="<?= esc($emp['id']) ?>"><?= esc(($emp['prenom'] ?? '') . ' ' . ($emp['nom'] ?? '')) ?> — <?= esc($emp['email'] ?? '') ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="f-group">
                <label class="f-label">Année</label>
                <input type="number" name="annee" class="f-input" value="<?= esc($year ?? date('Y')) ?>" min="2000" max="2100" required />
              </div>
              <div class="f-group">
                <label class="f-label">Mode</label>
                <select name="mode" class="f-select" id="solde-mode">
                  <option value="initialize">Initialiser tous les soldes</option>
                  <option value="manual">Ajouter / modifier un solde</option>
                </select>
              </div>
              <div class="f-group">
                <label class="f-label">Type de congé</label>
                <select name="type_conge_id" class="f-select">
                  <option value="">-- Choisir --</option>
                  <?php foreach (($typesConge ?? []) as $type): ?>
                    <option value="<?= esc($type['id']) ?>"><?= esc($type['libelle']) ?> (<?= esc($type['jours_annuels']) ?> j)</option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="f-group">
                <label class="f-label">Jours attribués</label>
                <input type="number" step="0.5" min="0" name="jours_attribues" class="f-input" placeholder="30" />
              </div>
              <div class="f-group">
                <label class="f-label">Jours pris</label>
                <input type="number" step="0.5" min="0" name="jours_pris" class="f-input" placeholder="0" />
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn-forest"><i class="bi bi-save"></i> Enregistrer</button>
              <a href="<?= site_url('admin') ?>" class="btn-secondary">Réinitialiser</a>
            </div>
          </form>
          <div class="f-hint" style="margin-top:.8rem">Le mode "Initialiser" crée ou met à jour tous les soldes selon les types de congé. Le mode "Ajouter / modifier" ne touche qu'un seul type.</div>
        </div>
      </div>

      <div class="data-card" style="margin-bottom:1.5rem">
        <div class="data-card-head">
          <h3>Absences du mois en cours</h3>
          <div class="td-muted"><?= esc($currentMonthLabel ?? date('m/Y')) ?></div>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Statut</th><th>Commentaire</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($absences)): ?>
              <?php foreach ($absences as $absence): ?>
                <tr>
                  <td>
                    <div class="profile-row">
                      <div class="avatar av-green" style="width:32px;height:32px;font-size:.68rem"><?= esc(strtoupper(substr($absence['prenom'] ?? '',0,1) . substr($absence['nom'] ?? '',0,1))) ?></div>
                      <div class="profile-info"><div class="pname"><?= esc(($absence['prenom'] ?? '') . ' ' . ($absence['nom'] ?? '')) ?></div><div class="pdept"><?= esc($absence['email'] ?? '') ?></div></div>
                    </div>
                  </td>
                  <td><span class="type-badge t-annuel"><?= esc($absence['type_libelle'] ?? 'Congé') ?></span></td>
                  <td class="td-muted td-mono"><?= esc($absence['date_debut'] ?? '') ?> → <?= esc($absence['date_fin'] ?? '') ?></td>
                  <td class="td-mono"><?= esc($absence['nb_jours'] ?? '0') ?> j</td>
                  <td><span class="statut s-approuvee">approuvée</span></td>
                  <td class="td-muted" style="font-size:.78rem"><?= esc($absence['commentaire_rh'] ?? '—') ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" class="td-muted">Aucune absence approuvée ce mois-ci.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="data-card" id="demandes">
        <div class="data-card-head">
          <h3>Liste des demandes</h3>
          <div class="td-muted">Dernières demandes enregistrées</div>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Statut</th><th>Créée le</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($requests)): ?>
              <?php foreach ($requests as $request): ?>
                <?php
                  $status = $request['statut'] ?? 'en_attente';
                  $badge = $status === 'approuve' ? 's-approuvee' : ($status === 'refuse' ? 's-refusee' : ($status === 'annule' ? 's-annulee' : 's-attente'));
                  $label = $status === 'approuve' ? 'approuvée' : ($status === 'refuse' ? 'refusée' : ($status === 'annule' ? 'annulée' : 'en attente'));
                ?>
                <tr>
                  <td>
                    <div class="profile-row">
                      <div class="avatar av-blue" style="width:32px;height:32px;font-size:.68rem"><?= esc(strtoupper(substr($request['prenom'] ?? '',0,1) . substr($request['nom'] ?? '',0,1))) ?></div>
                      <div class="profile-info"><div class="pname"><?= esc(($request['prenom'] ?? '') . ' ' . ($request['nom'] ?? '')) ?></div><div class="pdept"><?= esc($request['email'] ?? '') ?></div></div>
                    </div>
                  </td>
                  <td><span class="type-badge t-annuel"><?= esc($request['type_libelle'] ?? 'Congé') ?></span></td>
                  <td class="td-muted td-mono"><?= esc($request['date_debut'] ?? '') ?> → <?= esc($request['date_fin'] ?? '') ?></td>
                  <td class="td-mono"><?= esc($request['nb_jours'] ?? '0') ?> j</td>
                  <td><span class="statut <?= esc($badge) ?>"><?= esc($label) ?></span></td>
                  <td class="td-muted td-mono"><?= esc($request['created_at'] ?? '') ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" class="td-muted">Aucune demande trouvée.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="footer-app"><i class="bi bi-c-circle"></i> <?= date('Y') ?> <span>TechMada RH</span></div>
  </div>
</div>

<script>
const modeSelect = document.getElementById('solde-mode');
if (modeSelect) {
  const toggleFields = () => {
    const manual = modeSelect.value === 'manual';
    document.querySelectorAll('[name="type_conge_id"], [name="jours_attribues"], [name="jours_pris"]').forEach(el => {
      if (el.name === 'type_conge_id' || el.name === 'jours_attribues' || el.name === 'jours_pris') {
        el.closest('.f-group').style.opacity = manual ? '1' : '0.5';
      }
    });
  };
  modeSelect.addEventListener('change', toggleFields);
  toggleFields();
}
</script>
</body>
</html>

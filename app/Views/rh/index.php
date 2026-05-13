<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<title><?= esc($title ?? 'RH') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url('assets/css/template.css') ?>">
</head>
<body>
<div class="app-wrap">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-person-check"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace responsable</span></div>
    </div>
    <div class="sidebar-section">Menu</div>
    <ul class="sidebar-nav">
      <li><a href="<?= site_url('rh') ?>" class="active"><i class="bi bi-inbox"></i> Demandes à traiter</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar av-blue">RH</div>
        <div><div class="user-name">Responsable RH</div><div class="user-role">Validation des congés</div></div>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Demandes à traiter</div>
        <div class="topbar-breadcrumb"><a href="<?= site_url('rh') ?>">Accueil</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Validation</div>
      </div>
      <div class="topbar-actions">
        <span style="font-size:.8rem;color:var(--muted);background:var(--warn-bg);border:1px solid var(--warn-br);border-radius:6px;padding:5px 10px;display:flex;align-items:center;gap:5px;color:var(--warn)">
          <i class="bi bi-hourglass-split"></i> <?= esc($pendingCount ?? 0) ?> en attente
        </span>
      </div>
    </div>

    <div class="content">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="flash flash-success"><i class="bi bi-check-circle-fill"></i> <?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="flash flash-error"><i class="bi bi-exclamation-circle-fill"></i> <?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <div style="display:flex;gap:8px;margin-bottom:1.25rem;flex-wrap:wrap;align-items:center">
        <?php
          $total = array_sum($stats ?? []);
          $filters = [
            '' => ['label' => 'Tous', 'count' => $total],
            'en_attente' => ['label' => 'En attente', 'count' => $stats['en_attente'] ?? 0],
            'approuve' => ['label' => 'Approuvées', 'count' => $stats['approuve'] ?? 0],
            'refuse' => ['label' => 'Refusées', 'count' => $stats['refuse'] ?? 0],
            'annule' => ['label' => 'Annulées', 'count' => $stats['annule'] ?? 0],
          ];
        ?>
        <?php foreach ($filters as $value => $option): ?>
          <?php $active = $selectedStatut === $value ? 'background:var(--forest);color:var(--white);border-color:var(--forest);' : ''; ?>
          <a href="<?= site_url('rh') ?>?<?= http_build_query(['statut' => $value, 'departement_id' => $selectedDepartementId ?? 0]) ?>" class="btn" style="padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer;<?= $active ?>">
            <?= esc($option['label']) ?> (<?= esc($option['count']) ?>)
          </a>
        <?php endforeach; ?>

        <form method="get" action="<?= site_url('rh') ?>" style="margin-left:auto">
          <input type="hidden" name="statut" value="<?= esc($selectedStatut) ?>">
          <select name="departement_id" class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto" onchange="this.form.submit()">
            <option value="0">Tous les départements</option>
            <?php foreach ($departements as $departement): ?>
              <option value="<?= esc($departement['id']) ?>" <?= (int) $selectedDepartementId === (int) $departement['id'] ? 'selected' : '' ?>><?= esc($departement['nom']) ?></option>
            <?php endforeach; ?>
          </select>
        </form>
      </div>

      <div class="data-card">
        <div class="data-card-head"><h3>Toutes les demandes</h3></div>
        <table class="tbl">
          <thead>
            <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Solde dispo</th><th>Statut</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($requests)): ?>
              <?php foreach ($requests as $request): ?>
                <?php
                  $status = $request['statut'] ?? 'en_attente';
                  $badgeClass = $status === 'approuve' ? 's-approuvee' : ($status === 'refuse' ? 's-refusee' : ($status === 'annule' ? 's-annulee' : 's-attente'));
                  $statusLabel = $status === 'approuve' ? 'approuvée' : ($status === 'refuse' ? 'refusée' : ($status === 'annule' ? 'annulée' : 'en attente'));
                  $soldeLabel = isset($request['solde_restant']) ? (float) $request['solde_restant'] >= 0 ? esc((string) $request['solde_restant'] . ' j') : '—' : '—';
                ?>
                <tr>
                  <td>
                    <div class="profile-row">
                      <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem"><?= esc(strtoupper(substr($request['prenom'] ?? '', 0, 1) . substr($request['nom'] ?? '', 0, 1))) ?></div>
                      <div class="profile-info"><div class="pname"><?= esc(($request['prenom'] ?? '') . ' ' . ($request['nom'] ?? '')) ?></div><div class="pdept"><?= esc($request['departement'] ?? '—') ?></div></div>
                    </div>
                  </td>
                  <td><span class="type-badge t-annuel"><?= esc($request['type_libelle'] ?? 'Congé') ?></span></td>
                  <td class="td-muted" style="font-size:.8rem"><?= esc($request['date_debut'] ?? '') ?> – <?= esc($request['date_fin'] ?? '') ?></td>
                  <td class="td-mono"><?= esc($request['nb_jours'] ?? '0') ?> j</td>
                  <td><?= esc($soldeLabel) ?></td>
                  <td><span class="statut <?= esc($badgeClass) ?>"><?= esc($statusLabel) ?></span></td>
                  <td>
                    <?php if ($status === 'en_attente'): ?>
                      <div class="action-btns" style="display:flex;gap:.4rem;flex-wrap:wrap">
                        <form method="post" action="<?= site_url('rh/conges/approve/' . (int) $request['id']) ?>">
                          <?= csrf_field() ?>
                          <button type="submit" class="btn-sm btn-approve"><i class="bi bi-check-lg"></i> Approuver</button>
                        </form>
                        <form method="post" action="<?= site_url('rh/conges/refuse/' . (int) $request['id']) ?>" style="display:flex;flex-direction:column;gap:.4rem;max-width:220px">
                          <?= csrf_field() ?>
                          <textarea name="commentaire_rh" class="f-textarea" placeholder="Commentaire optionnel" style="min-height:64px"></textarea>
                          <button type="submit" class="btn-sm btn-refuse" style="width:100%"><i class="bi bi-x-lg"></i> Refuser</button>
                        </form>
                      </div>
                    <?php else: ?>
                      <div style="font-size:.8rem;color:var(--muted)">
                        Traité par <?= esc(trim(($request['traiteur_prenom'] ?? '') . ' ' . ($request['traiteur_nom'] ?? ''))) ?: '—' ?>
                      </div>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="td-muted">Aucune demande trouvée.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="footer-app"><i class="bi bi-c-circle"></i> <?= date('Y') ?> <span>TechMada RH</span></div>
  </div>
</div>
</body>
</html>

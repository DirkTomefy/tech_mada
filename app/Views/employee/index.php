<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title><?= htmlspecialchars($title ?? 'Gestion des Employés') ?> — TechMada RH</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/style.css') ?>" rel="stylesheet">
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
            <li><a href="/admin"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
            <li><a href="#" class="active"><i class="bi bi-people"></i> Employés</a></li>
            <li><a href="#"><i class="bi bi-building"></i> Départements</a></li>
            <li><a href="#"><i class="bi bi-tags"></i> Types de congé</a></li>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Gestion des employés</div>
                <div class="topbar-breadcrumb">
                    <a href="/admin">Admin</a>
                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Employés
                </div>
            </div>
            <div class="topbar-actions">
                <a href="/admin/employes/create" class="btn-forest"><i class="bi bi-person-plus"></i> Ajouter</a>
            </div>
        </div>

        <div class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="flash flash-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= htmlspecialchars(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="flash flash-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= htmlspecialchars(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <div class="data-card">
                <div class="data-card-head">
                    <div>
                        <h3>Tous les employés</h3>
                        <p style="font-size: .8rem; color: var(--muted); margin: 4px 0 0;">Total : <?= htmlspecialchars($totalEmployees ?? 0) ?> employés</p>
                    </div>
                    <input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem" id="searchInput"/>
                </div>

                <?php if (!empty($employees)): ?>
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Dipartement</th>
                                <th>Embauche</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $employee): ?>
                                <tr>
                                    <td>
                                        <div class="profile-row">
                                            <div class="avatar av-green">
                                                <?= htmlspecialchars(strtoupper(substr($employee['prenom'], 0, 1) . substr($employee['nom'], 0, 1))) ?>
                                            </div>
                                            <div class="profile-info">
                                                <div class="pname"><?= htmlspecialchars($employee['prenom'] . ' ' . $employee['nom']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td-muted"><?= htmlspecialchars($employee['email']) ?></td>
                                    <td>
                                        <span class="type-badge t-annuel">
                                            <?= htmlspecialchars(strtolower($employee['role'])) ?>
                                        </span>
                                    </td>
                                    <td class="td-muted">
                                        <?= isset($employee['departement_id']) ? 'Dépt. ' . htmlspecialchars($employee['departement_id']) : '—' ?>
                                    </td>
                                    <td class="td-muted td-mono" style="font-size:.78rem">
                                        <?= htmlspecialchars($employee['date_embauche'] ?? '—') ?>
                                    </td>
                                    <td>
                                        <span class="statut <?= $employee['actif'] ? 's-actif' : 's-inactif' ?>" style="font-size:.68rem">
                                            <?= $employee['actif'] ? 'actif' : 'inactif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="/admin/employes/<?= htmlspecialchars($employee['id']) ?>" class="btn-sm btn-edit">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                            <a href="/admin/employes/edit/<?= htmlspecialchars($employee['id']) ?>" class="btn-sm btn-edit">
                                                <i class="bi bi-pencil"></i> Éditer
                                            </a>
                                            <a href="/admin/employes/delete/<?= htmlspecialchars($employee['id']) ?>" class="btn-sm btn-delete" onclick="return confirm('Êtes-vous sûr?')">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="padding: 2rem; text-align: center; color: var(--muted);">
                        <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 1rem; opacity: .5;"></i>
                        <p>Aucun employé trouvé</p>
                        <a href="/admin/employes/create" class="btn-forest" style="margin-top: 1rem;">
                            <i class="bi bi-plus-lg"></i> Créer un employé
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-app">
            <i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span> — Projet CodeIgniter 4
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.tbl tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>

</body>
</html>

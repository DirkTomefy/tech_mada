<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title><?= htmlspecialchars($title ?? 'Gestion des Employés') ?> — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        :root {
            --ink: #1c2b1e;
            --forest: #2d5a3d;
            --forest2: #3d7a52;
            --leaf: #5fa876;
            --mint: #d4ede0;
            --cream: #f8f6f1;
            --white: #ffffff;
            --border: #dde8e1;
            --muted: #7a8f80;
            --danger: #c0392b;
            --danger-bg: #fdf0ee;
            --danger-br: #f0b8b2;
            --warn: #b8750a;
            --warn-bg: #fef9ee;
            --warn-br: #f5d98a;
            --success: #1e6b3f;
            --success-bg: #edf7f2;
            --success-br: #8fd4aa;
            --info: #1a4f7a;
            --info-bg: #eaf2fb;
            --info-br: #8fbde8;
            --sidebar-w: 240px;
            --topbar-h: 62px;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--ink);
            margin: 0;
            font-size: 15px;
        }
        h1, h2, h3, .brand-name { font-family: 'Playfair Display', serif; }
        code, pre, .mono { font-family: 'DM Mono', monospace; }

        .app-wrap {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--ink);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.4rem 1.2rem 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .sidebar-logo-icon {
            width: 34px;
            height: 34px;
            background: var(--forest);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-logo-icon i {
            color: var(--white);
            font-size: 1.1rem;
        }

        .sidebar-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            color: var(--white);
            line-height: 1.2;
        }

        .sidebar-brand-name span {
            display: block;
            font-size: .65rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            color: rgba(255,255,255,.35);
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .sidebar-section {
            padding: .75rem 1.1rem .3rem;
            font-size: .62rem;
            font-weight: 500;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: rgba(255,255,255,.25);
            margin-top: .25rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 .75rem;
            margin: 0;
        }

        .sidebar-nav li {
            margin-bottom: 2px;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 11px;
            border-radius: 7px;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            font-size: .85rem;
            font-weight: 400;
            transition: all .15s;
        }

        .sidebar-nav li a:hover {
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.9);
        }

        .sidebar-nav li a.active {
            background: var(--forest);
            color: var(--white);
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            border-bottom: 1px solid var(--border);
            background: var(--white);
        }

        .topbar-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--ink);
        }

        .topbar-breadcrumb {
            font-size: .8rem;
            color: var(--muted);
        }

        .topbar-breadcrumb a {
            color: var(--forest);
            text-decoration: none;
        }

        .topbar-actions {
            display: flex;
            gap: 8px;
        }

        .content {
            flex: 1;
            padding: 1.75rem 1.5rem;
            overflow-y: auto;
        }

        .data-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .data-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .data-card-head h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: .85rem;
        }

        .tbl thead tr {
            background: rgba(45, 90, 61, .02);
            border-bottom: 1px solid var(--border);
        }

        .tbl th {
            padding: .75rem 1rem;
            text-align: left;
            font-weight: 500;
            color: var(--muted);
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .tbl td {
            padding: .95rem 1rem;
            border-bottom: 1px solid var(--border);
        }

        .tbl tbody tr:last-child td {
            border-bottom: none;
        }

        .tbl tbody tr:hover {
            background: rgba(45, 90, 61, .02);
        }

        .profile-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            font-weight: 600;
            color: var(--white);
        }

        .av-green { background: #2d8659; }
        .av-blue { background: #2d5a8d; }
        .av-amber { background: #8d5a2d; }

        .profile-info .pname {
            font-weight: 500;
            color: var(--ink);
        }

        .profile-info .pdept {
            font-size: .75rem;
            color: var(--muted);
        }

        .td-muted {
            color: var(--muted);
        }

        .td-mono {
            font-family: 'DM Mono', monospace;
            font-size: .8rem;
        }

        .type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: .7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .t-annuel { background: rgba(29, 107, 63, .15); color: var(--success); }
        .t-maladie { background: rgba(184, 117, 10, .15); color: var(--warn); }

        .statut {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: .7rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .s-actif { background: rgba(29, 107, 63, .15); color: var(--success); }
        .s-inactif { background: rgba(192, 57, 43, .15); color: var(--danger); }

        .action-btns {
            display: flex;
            gap: 6px;
        }

        .btn-sm {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: .75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-edit {
            background: var(--info-bg);
            color: var(--info);
            border: 1px solid var(--info-br);
        }

        .btn-edit:hover {
            background: var(--info);
            color: var(--white);
        }

        .btn-delete {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid var(--danger-br);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: var(--white);
        }

        .btn-forest {
            background: var(--forest);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: .9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-forest:hover {
            background: var(--forest2);
            color: var(--white);
            text-decoration: none;
        }

        .flash {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .flash-success {
            background: var(--success-bg);
            border: 1px solid var(--success-br);
            color: var(--success);
        }

        .flash-danger {
            background: var(--danger-bg);
            border: 1px solid var(--danger-br);
            color: var(--danger);
        }

        .flash i {
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .footer-app {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
            font-size: .8rem;
            color: var(--muted);
            text-align: center;
        }

        .footer-app i {
            margin-right: 4px;
        }

        .form-section {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-section h3 {
            margin: 0 0 1.25rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--ink);
        }

        .f-group {
            margin-bottom: 1rem;
        }

        .f-label {
            font-size: .8rem;
            font-weight: 500;
            color: var(--ink);
            margin-bottom: 5px;
            display: block;
        }

        .f-input,
        .f-select {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: .875rem;
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--ink);
            transition: border-color .15s, box-shadow .15s;
        }

        .f-input:focus,
        .f-select:focus {
            border-color: var(--forest);
            box-shadow: 0 0 0 3px rgba(45, 90, 61, .1);
            outline: none;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 1.5rem;
        }

        .btn-secondary {
            background: var(--white);
            color: var(--muted);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 9px 16px;
            font-size: .9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-secondary:hover {
            border-color: var(--muted);
            color: var(--ink);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                left: -240px;
                height: 100%;
                z-index: 1000;
            }
            .content {
                padding: 1rem;
            }
        }
    </style>
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

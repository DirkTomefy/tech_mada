<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Détails de l'employé — TechMada RH</title>
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

        .profile-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--white);
            background: var(--forest);
        }

        .profile-text h2 {
            margin: 0 0 4px;
            font-size: 1.3rem;
        }

        .profile-text .role {
            font-size: .8rem;
            color: var(--forest);
            font-weight: 500;
        }

        .profile-text .dept {
            font-size: .75rem;
            color: var(--muted);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            padding: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .info-value {
            font-size: .95rem;
            color: var(--ink);
            font-weight: 500;
        }

        .info-value.mono {
            font-family: 'DM Mono', monospace;
            font-size: .85rem;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-active {
            background: var(--success-bg);
            color: var(--success);
        }

        .status-inactive {
            background: var(--danger-bg);
            color: var(--danger);
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

        .action-section {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
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
            <li><a href="/admin/employes" class="active"><i class="bi bi-people"></i> Employés</a></li>
            <li><a href="#"><i class="bi bi-building"></i> Départements</a></li>
            <li><a href="#"><i class="bi bi-tags"></i> Types de congé</a></li>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Détails de l'employé</div>
                <div class="topbar-breadcrumb">
                    <a href="/admin">Admin</a>
                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i>
                    <a href="/admin/employes">Employés</a>
                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Détails
                </div>
            </div>
            <div class="topbar-actions">
                <a href="/admin/employes/edit/<?= htmlspecialchars($employee['id']) ?>" class="btn-edit"><i class="bi bi-pencil"></i> Modifier</a>
            </div>
        </div>

        <div class="content">
            <div class="data-card">
                <div class="profile-header">
                    <div class="avatar-large">
                        <?= htmlspecialchars(strtoupper(substr($employee['prenom'], 0, 1) . substr($employee['nom'], 0, 1))) ?>
                    </div>
                    <div class="profile-text">
                        <h2><?= htmlspecialchars($employee['prenom'] . ' ' . $employee['nom']) ?></h2>
                        <div class="role"><?= htmlspecialchars(strtoupper($employee['role'])) ?></div>
                        <div class="dept">
                            <?= isset($employee['departement_id']) ? 'Département ' . htmlspecialchars($employee['departement_id']) : 'Aucun département' ?>
                        </div>
                        <div style="margin-top: 0.75rem;">
                            <span class="status-badge <?= $employee['actif'] ? 'status-active' : 'status-inactive' ?>">
                                <?= $employee['actif'] ? 'Actif' : 'Inactif' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value mono"><?= htmlspecialchars($employee['email']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Date d'embauche</div>
                        <div class="info-value"><?= htmlspecialchars($employee['date_embauche'] ?? '—') ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Rôle</div>
                        <div class="info-value"><?= htmlspecialchars($employee['role']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Département</div>
                        <div class="info-value">
                            <?= isset($employee['departement_id']) ? 'Dépt. ' . htmlspecialchars($employee['departement_id']) : 'Non assigné' ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Statut</div>
                        <div class="info-value">
                            <?= $employee['actif'] ? 'Actif' : 'Inactif' ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Identifiant</div>
                        <div class="info-value mono">#<?= htmlspecialchars($employee['id']) ?></div>
                    </div>
                </div>

                <div class="action-section">
                    <a href="/admin/employes/edit/<?= htmlspecialchars($employee['id']) ?>" class="btn-edit">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <a href="/admin/employes" class="btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-app">
            <i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span> — Projet CodeIgniter 4
        </div>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Modifier l'employé — TechMada RH</title>
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

        .content {
            flex: 1;
            padding: 1.75rem 1.5rem;
            overflow-y: auto;
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

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
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

        .f-error {
            font-size: .75rem;
            color: var(--danger);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .flash {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .flash-info {
            background: var(--info-bg);
            border: 1px solid var(--info-br);
            color: var(--info);
        }

        .flash i {
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 1.5rem;
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

        @media (max-width: 768px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
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
            <li><a href="/admin/employes" class="active"><i class="bi bi-people"></i> Employés</a></li>
            <li><a href="#"><i class="bi bi-building"></i> Départements</a></li>
            <li><a href="#"><i class="bi bi-tags"></i> Types de congé</a></li>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Modifier l'employé</div>
                <div class="topbar-breadcrumb">
                    <a href="/admin">Admin</a>
                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i>
                    <a href="/admin/employes">Employés</a>
                    <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Modifier
                </div>
            </div>
        </div>

        <div class="content">
            <form action="/admin/employes/update/<?= htmlspecialchars($employee['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-section">
                    <h3><i class="bi bi-pencil" style="color:var(--forest);margin-right:6px"></i>Modifier : <?= htmlspecialchars($employee['prenom'] . ' ' . $employee['nom']) ?></h3>

                    <div class="form-grid-2">
                        <div class="f-group">
                            <label class="f-label">Prénom <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="prenom" class="f-input" placeholder="Jean" value="<?= htmlspecialchars($employee['prenom'] ?? old('prenom')) ?>" required/>
                            <?php if (isset($errors['prenom'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['prenom']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Nom <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="nom" class="f-input" placeholder="Rakoto" value="<?= htmlspecialchars($employee['nom'] ?? old('nom')) ?>" required/>
                            <?php if (isset($errors['nom'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['nom']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Email <span style="color:var(--danger)">*</span></label>
                            <input type="email" name="email" class="f-input" placeholder="jean.rakoto@techmada.mg" value="<?= htmlspecialchars($employee['email'] ?? old('email')) ?>" required/>
                            <?php if (isset($errors['email'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Mot de passe (laisser vide pour ne pas modifier)</label>
                            <input type="password" name="password" class="f-input" placeholder="Minimum 6 caractères"/>
                            <?php if (isset($errors['password'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['password']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Département</label>
                            <select name="departement_id" class="f-select">
                                <option value="">-- Aucun --</option>
                                <option value="1" <?= (int)($employee['departement_id'] ?? old('departement_id')) === 1 ? 'selected' : '' ?>>IT</option>
                                <option value="2" <?= (int)($employee['departement_id'] ?? old('departement_id')) === 2 ? 'selected' : '' ?>>Finance</option>
                                <option value="3" <?= (int)($employee['departement_id'] ?? old('departement_id')) === 3 ? 'selected' : '' ?>>Marketing</option>
                                <option value="4" <?= (int)($employee['departement_id'] ?? old('departement_id')) === 4 ? 'selected' : '' ?>>RH</option>
                            </select>
                            <?php if (isset($errors['departement_id'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['departement_id']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Rôle <span style="color:var(--danger)">*</span></label>
                            <select name="role" class="f-select" required>
                                <option value="">-- Choisir --</option>
                                <option value="EMPLOYE" <?= ($employee['role'] ?? old('role')) === 'EMPLOYE' ? 'selected' : '' ?>>Employé</option>
                                <option value="RH" <?= ($employee['role'] ?? old('role')) === 'RH' ? 'selected' : '' ?>>Responsable RH</option>
                                <option value="ADMIN" <?= ($employee['role'] ?? old('role')) === 'ADMIN' ? 'selected' : '' ?>>Administrateur</option>
                            </select>
                            <?php if (isset($errors['role'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['role']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Date d'embauche</label>
                            <input type="date" name="date_embauche" class="f-input" value="<?= htmlspecialchars($employee['date_embauche'] ?? old('date_embauche')) ?>"/>
                            <?php if (isset($errors['date_embauche'])): ?>
                                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['date_embauche']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Statut</label>
                            <select name="actif" class="f-select">
                                <option value="1" <?= ((int)($employee['actif'] ?? old('actif')) === 1) ? 'selected' : '' ?>>Actif</option>
                                <option value="0" <?= ((int)($employee['actif'] ?? old('actif')) === 0) ? 'selected' : '' ?>>Inactif</option>
                            </select>
                        </div>
                    </div>

                    <div class="flash flash-info">
                        <i class="bi bi-info-circle-fill"></i>
                        <span style="font-size:.82rem">Laissez le champ mot de passe vide pour conserver le mot de passe actuel.</span>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-forest"><i class="bi bi-check"></i> Enregistrer les modifications</button>
                        <a href="/admin/employes" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="footer-app">
            <i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span> — Projet CodeIgniter 4
        </div>
    </div>
</div>

</body>
</html>

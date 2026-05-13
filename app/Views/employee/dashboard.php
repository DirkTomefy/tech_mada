<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — TechMada RH</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/style.css') ?>" rel="stylesheet">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        .welcome-card {
            background: linear-gradient(135deg, var(--forest) 0%, var(--forest2) 100%);
            color: var(--white);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(45, 90, 61, 0.2);
        }
        .welcome-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            font-family: 'Playfair Display', serif;
        }
        .welcome-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            margin: 0;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .dashboard-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: inherit;
        }
        .dashboard-card:hover {
            border-color: var(--forest);
            box-shadow: 0 6px 16px rgba(45, 90, 61, 0.1);
            transform: translateY(-4px);
        }
        .dashboard-icon {
            font-size: 2.5rem;
            color: var(--forest);
            margin-bottom: 1rem;
        }
        .dashboard-card-title {
            font-weight: 600;
            color: var(--ink);
            margin: 0 0 0.5rem;
            font-size: 1rem;
        }
        .dashboard-card-desc {
            font-size: 0.85rem;
            color: var(--muted);
            margin: 0;
            line-height: 1.4;
        }
        .info-section {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .info-section h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            color: var(--ink);
            margin: 0 0 1rem;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: var(--muted);
            font-weight: 500;
        }
        .info-value {
            color: var(--ink);
            font-weight: 600;
        }
    </style>
</head>
<body>

<div style="background: var(--cream); min-height: 100vh;">
    <div class="dashboard-container">
        <!-- Bienvenue -->
        <div class="welcome-card">
            <h1 class="welcome-title">
                <i class="bi bi-hand-thumbs-up"></i> Bienvenue, <?= htmlspecialchars(session('prenom')) ?>!
            </h1>
            <p class="welcome-subtitle">Espace de gestion des demandes de congé</p>
        </div>

        <!-- Cartes rapides -->
        <div class="dashboard-grid">
            <a href="<?= base_url('employee/conges/formulaire') ?>" class="dashboard-card">
                <div class="dashboard-icon">
                    <i class="bi bi-file-earmark-plus"></i>
                </div>
                <h3 class="dashboard-card-title">Nouvelle demande</h3>
                <p class="dashboard-card-desc">Soumettre une demande de congé</p>
            </a>

            <a href="<?= base_url('employee/conges/mes-demandes') ?>" class="dashboard-card">
                <div class="dashboard-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <h3 class="dashboard-card-title">Mes demandes</h3>
                <p class="dashboard-card-desc">Consulter l'historique de vos demandes</p>
            </a>

            <?php if (session('role') === 'RH' || session('role') === 'ADMIN'): ?>
                <a href="<?= base_url('rh/conges/en-attente') ?>" class="dashboard-card">
                    <div class="dashboard-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="dashboard-card-title">À traiter</h3>
                    <p class="dashboard-card-desc">Demandes en attente d'approbation</p>
                </a>
            <?php endif; ?>
        </div>

        <!-- Informations utilisateur -->
        <div class="info-section">
            <h3>
                <i class="bi bi-person-circle" style="color: var(--forest); margin-right: 8px;"></i>
                Mes informations
            </h3>
            <div class="info-row">
                <span class="info-label">Nom complet</span>
                <span class="info-value"><?= htmlspecialchars(session('prenom') . ' ' . session('nom')) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value"><?= htmlspecialchars(session('email')) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Rôle</span>
                <span class="info-value">
                    <?php
                        $roles = ['RH' => 'Responsable RH', 'ADMIN' => 'Administrateur', 'EMPLOYE' => 'Employé'];
                        echo $roles[session('role')] ?? session('role');
                    ?>
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div style="text-align: center; padding: 1.5rem;">
            <a href="<?= base_url('employee/logout') ?>" style="color: var(--danger); text-decoration: none; font-weight: 600;">
                <i class="bi bi-box-arrow-right"></i> Se déconnecter
            </a>
        </div>
    </div>
</div>

</body>
</html>

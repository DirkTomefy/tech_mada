<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion réussie - TechMada RH</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/style.css') ?>" rel="stylesheet">
</head>
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: slideUp 0.5s ease-out;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #edf7f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: #1e6b3f;
        }
        .success-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 0.5rem 0;
            font-family: 'Playfair Display', serif;
        }
        .success-subtitle {
            font-size: 0.95rem;
            color: var(--muted);
            margin: 0 0 2rem 0;
        }
        .user-info {
            background: #f8f6f1;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: var(--ink);
            font-size: 0.9rem;
        }
        .info-value {
            color: var(--muted);
            font-size: 0.9rem;
        }
        .role-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 1rem;
        }
        .role-badge.admin {
            background: #fdf0ee;
            color: #c0392b;
        }
        .role-badge.rh {
            background: #eaf2fb;
            color: #1a4f7a;
        }
        .role-badge.employe {
            background: #edf7f2;
            color: #1e6b3f;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .btn {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background: var(--forest2);
            color: white;
        }
        .btn-primary:hover {
            background: var(--forest);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 90, 61, 0.3);
        }
        .btn-secondary {
            background: var(--border);
            color: var(--ink);
        }
        .btn-secondary:hover {
            background: #d4dee5;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        
        <h1 class="success-title">Connexion réussie !</h1>
        <p class="success-subtitle">Bienvenue sur votre espace TechMada RH</p>

        <div class="user-info">
            <div class="info-row">
                <span class="info-label">👤 Nom</span>
                <span class="info-value"><?= htmlspecialchars($employe['nom'] ?? '') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">📧 Email</span>
                <span class="info-value"><?= htmlspecialchars($employe['email'] ?? '') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">🏢 Département</span>
                <span class="info-value"><?= ($employe['departement_id'] ?? null) ? 'ID: ' . $employe['departement_id'] : 'Non défini' ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">📅 Embauche</span>
                <span class="info-value"><?= $employe['date_embauche'] ?? 'Non défini' ?></span>
            </div>
            <div style="text-align: center;">
                <span class="role-badge <?= strtolower($employe['role'] ?? '') ?>">
                    <?= htmlspecialchars($employe['role'] ?? '') ?>
                </span>
            </div>
        </div>

        <div class="btn-group">
            <a href="<?= base_url('employee/dashboard') ?>" class="btn btn-primary">
                Accéder au dashboard <i class="bi bi-arrow-right"></i>
            </a>
            <a href="<?= base_url('employee/logout') ?>" class="btn btn-secondary">
                Se déconnecter
            </a>
        </div>
    </div>
</body>
</html>

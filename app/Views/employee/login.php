<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMada RH - Connexion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/style.css') ?>" rel="stylesheet">
    <style>
        .flash {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
        }
        .flash-error {
            background: var(--danger-bg);
            border: 1px solid var(--danger-br);
            color: var(--danger);
        }
        .flash-success {
            background: var(--success-bg);
            border: 1px solid var(--success-br);
            color: var(--success);
        }
        .f-group {
            margin-bottom: 1.5rem;
        }
        .f-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--ink);
            font-size: 0.9rem;
        }
        .f-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.2s;
        }
        .f-input:focus {
            outline: none;
            border-color: var(--forest2);
            box-shadow: 0 0 0 3px rgba(61, 122, 82, 0.1);
        }
        .btn-primary {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: var(--forest2);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .btn-primary:hover {
            background: var(--forest);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 90, 61, 0.3);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
<section id="page-login">
<div class="auth-page geo-bg">
<div class="auth-split">

  <!-- Panneau gauche -->
  <div class="auth-left">
    <div>
      <p class="auth-left-brand">TechMada RH<span>Gestion des congés</span></p>
      <p class="auth-left-text" style="margin-top:2rem">
        <strong>Bienvenue sur votre espace RH.</strong>
        Gérez vos demandes de congés, consultez votre solde et suivez l'état de vos demandes en temps réel.
      </p>
    </div>
    <div class="auth-roles">
      <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.25);margin-bottom:4px">Comptes de démonstration</div>
      <div class="role-pill">
        <i class="bi bi-shield-check"></i>
        <div><div class="role-pill-name">Administrateur</div><div class="role-pill-cred">michel.andry@test.com · admin123</div></div>
      </div>
      <div class="role-pill">
        <i class="bi bi-person-check"></i>
        <div><div class="role-pill-name">Responsable RH</div><div class="role-pill-cred">sarah.rabe@test.com · rh123</div></div>
      </div>
      <div class="role-pill">
        <i class="bi bi-person"></i>
        <div><div class="role-pill-name">Employé</div><div class="role-pill-cred">jean.rakoto@test.com · emp123</div></div>
      </div>
    </div>
  </div>

  <!-- Panneau droit -->
  <div class="auth-right">
    <p class="auth-title">Connexion</p>
    <p class="auth-sub">Entrez vos identifiants pour accéder à votre espace.</p>

    <!-- Messages d'erreur/succès -->
    <?php if (session()->has('error')): ?>
      <div class="flash flash-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <span><?= session('error') ?></span>
      </div>
    <?php endif; ?>

    <?php if (session()->has('success')): ?>
      <div class="flash flash-success">
        <i class="bi bi-check-circle-fill"></i>
        <span><?= session('success') ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('employee/loginProcess') ?>">
      <?= csrf_field() ?>
      <div class="f-group">
        <label class="f-label">Adresse email</label>
        <input type="email" name="email" class="f-input" placeholder="vous@techmada.mg" value="jean.rakoto@test.com" required/>
      </div>
      <div class="f-group">
        <label class="f-label">Mot de passe</label>
        <input type="password" name="password" class="f-input" placeholder="••••••••" value="emp123" required/>
      </div>
      <button type="submit" class="btn-primary">
        Se connecter <i class="bi bi-arrow-right-short"></i>
      </button>
    </form>
  </div>

</div>
</div>
</section>
</body>
</html>
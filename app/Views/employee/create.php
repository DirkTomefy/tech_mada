<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>TechMada RH — Gestion des employés</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<style>
:root{
  --ink:      #1c2b1e;
  --forest:   #2d5a3d;
  --forest2:  #3d7a52;
  --leaf:     #5fa876;
  --mint:     #d4ede0;
  --cream:    #f8f6f1;
  --white:    #ffffff;
  --border:   #dde8e1;
  --muted:    #7a8f80;
  --danger:   #c0392b;
  --danger-bg:#fdf0ee;
  --danger-br:#f0b8b2;
  --warn:     #b8750a;
  --warn-bg:  #fef9ee;
  --warn-br:  #f5d98a;
  --success:  #1e6b3f;
  --success-bg:#edf7f2;
  --success-br:#8fd4aa;
  --info:     #1a4f7a;
  --info-bg:  #eaf2fb;
  --info-br:  #8fbde8;
  --sidebar-w:240px;
  --topbar-h: 62px;
}
*{box-sizing:border-box}
body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);margin:0;font-size:15px}
h1,h2,h3,.brand-name{font-family:'Playfair Display',serif}

.app-wrap{display:flex;min-height:100vh}
.sidebar{width:var(--sidebar-w);background:var(--ink);display:flex;flex-direction:column;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto}
.sidebar-brand{padding:1.4rem 1.2rem 1rem;display:flex;align-items:center;gap:10px;border-bottom:1px solid rgba(255,255,255,.06)}
.sidebar-logo-icon{width:34px;height:34px;background:var(--forest);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sidebar-logo-icon i{color:var(--white);font-size:1.1rem}
.sidebar-brand-name{font-family:'Playfair Display',serif;font-size:1rem;color:var(--white);line-height:1.2}
.sidebar-brand-name span{display:block;font-size:.65rem;font-family:'DM Sans',sans-serif;font-weight:400;color:rgba(255,255,255,.35);letter-spacing:.05em;text-transform:uppercase}
.sidebar-section{padding:.75rem 1.1rem .3rem;font-size:.62rem;font-weight:500;letter-spacing:1.4px;text-transform:uppercase;color:rgba(255,255,255,.25);margin-top:.25rem}
.sidebar-nav{list-style:none;padding:0 .75rem;margin:0}
.sidebar-nav li{margin-bottom:2px}
.sidebar-nav li a{display:flex;align-items:center;gap:9px;padding:9px 11px;border-radius:7px;color:rgba(255,255,255,.55);text-decoration:none;font-size:.85rem;font-weight:400;transition:all .15s}
.sidebar-nav li a:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.9)}
.sidebar-nav li a.active{background:var(--forest);color:var(--white)}
.sidebar-user{padding:1.25rem .75rem;border-top:1px solid rgba(255,255,255,.06);margin-top:auto}
.s-user-row{display:flex;align-items:center;gap:10px;padding:.75rem;color:var(--white);font-size:.85rem}
.avatar{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:600;color:var(--white);background:#5a2d82}
.user-name{font-weight:500;line-height:1.2}
.user-role{font-size:.7rem;color:rgba(255,255,255,.5);line-height:1.2}
.main{flex:1;display:flex;flex-direction:column}
.topbar{height:var(--topbar-h);display:flex;align-items:center;justify-content:space-between;padding:0 1.5rem;border-bottom:1px solid var(--border);background:var(--white)}
.topbar-title{font-size:1.1rem;font-weight:600;color:var(--ink)}
.topbar-breadcrumb{font-size:.8rem;color:var(--muted)}
.topbar-breadcrumb a{color:var(--forest);text-decoration:none}
.topbar-actions{display:flex;gap:8px}
.btn-forest{background:var(--forest);color:var(--white);border:none;border-radius:8px;padding:9px 16px;font-size:.9rem;font-weight:500;cursor:pointer;transition:all .15s;font-family:'DM Sans',sans-serif;display:inline-flex;align-items:center;gap:6px;text-decoration:none}
.btn-forest:hover{background:var(--forest2);color:var(--white)}
.btn-secondary{background:var(--white);color:var(--muted);border:1.5px solid var(--border);border-radius:8px;padding:9px 16px;font-size:.9rem;font-weight:500;cursor:pointer;transition:all .15s;font-family:'DM Sans',sans-serif;display:inline-flex;align-items:center;gap:6px;text-decoration:none}
.btn-secondary:hover{border-color:var(--muted);color:var(--ink)}
.content{flex:1;padding:1.75rem 1.5rem;overflow-y:auto}
.form-section{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:1.5rem;margin-bottom:1.5rem}
.form-section h3{margin:0 0 1.25rem;font-size:1rem;font-weight:600;color:var(--ink)}
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
.f-group{margin-bottom:1rem}
.f-label{font-size:.8rem;font-weight:500;color:var(--ink);margin-bottom:5px;display:block}
.f-input,.f-select{width:100%;border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font-size:.875rem;font-family:'DM Sans',sans-serif;background:var(--white);color:var(--ink);transition:border-color .15s,box-shadow .15s}
.f-input:focus,.f-select:focus{border-color:var(--forest);box-shadow:0 0 0 3px rgba(45,90,61,.1);outline:none}
.f-error{font-size:.75rem;color:var(--danger);margin-top:4px}
.flash{padding:1rem 1.25rem;border-radius:8px;margin-bottom:1.5rem;display:flex;align-items:flex-start;gap:10px}
.flash-info{background:var(--info-bg);border:1px solid var(--info-br);color:var(--info)}
.flash i{font-size:1.1rem;flex-shrink:0;margin-top:2px}
.form-actions{display:flex;gap:10px;margin-top:1.5rem}
.footer-app{padding:1rem 1.5rem;border-top:1px solid var(--border);font-size:.8rem;color:var(--muted);text-align:center}
</style>
</head>
<body>

<div class="app-wrap">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="#"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
      <li><a href="#"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
      <li><a href="/employes/create" class="active"><i class="bi bi-people"></i> Employés</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar">AD</div>
        <div><div class="user-name">Administrateur</div><div class="user-role">Admin système</div></div>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Gestion des employés</div>
        <div class="topbar-breadcrumb">Admin <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Employés</div>
      </div>
      <div class="topbar-actions">
        <a href="/employes/create" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-person-plus"></i> Ajouter</a>
      </div>
    </div>

    <div class="content">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="flash flash-info" style="background:#edf7f2;border-color:#8fd4aa;color:#1e6b3f">
          <i class="bi bi-check-circle-fill"></i>
          <span><?= htmlspecialchars(session()->getFlashdata('success')) ?></span>
        </div>
      <?php endif; ?>

      <!-- Formulaire ajout -->
      <div class="form-section">
        <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
        <form method="POST" action="/employes/save">
          <?= csrf_field() ?>
          <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
              <label class="f-label">Prénom</label>
              <input type="text" name="prenom" class="f-input" placeholder="Jean" value="<?= old('prenom') ?>"/>
              <?php if (isset($errors['prenom'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['prenom']) ?></div>
              <?php endif; ?>
            </div>
            <div class="f-group">
              <label class="f-label">Nom</label>
              <input type="text" name="nom" class="f-input" placeholder="Rakoto" value="<?= old('nom') ?>"/>
              <?php if (isset($errors['nom'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['nom']) ?></div>
              <?php endif; ?>
            </div>
            <div class="f-group">
              <label class="f-label">Email</label>
              <input type="email" name="email" class="f-input" placeholder="jean.rakoto@techmada.mg" value="<?= old('email') ?>"/>
              <?php if (isset($errors['email'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['email']) ?></div>
              <?php endif; ?>
            </div>
            <div class="f-group">
              <label class="f-label">Mot de passe initial</label>
              <input type="password" name="password" class="f-input" placeholder="À communiquer à l'employé"/>
              <?php if (isset($errors['password'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['password']) ?></div>
              <?php endif; ?>
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
              <?php if (isset($errors['role'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($errors['role']) ?></div>
              <?php endif; ?>
            </div>
            <div class="f-group">
              <label class="f-label">Date d'embauche</label>
              <input type="date" name="date_embauche" class="f-input" value="<?= old('date_embauche', date('Y-m-d')) ?>"/>
            </div>
          </div>
          <div class="flash flash-info" style="margin-bottom:1rem">
            <i class="bi bi-info-circle-fill"></i>
            <span style="font-size:.82rem">Les soldes de congés seront initialisés automatiquement selon les types de congé configurés.</span>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer l'employé</button>
            <button type="reset" class="btn-secondary">Réinitialiser</button>
          </div>
        </form>
      </div>

    </div>
    <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span> — Projet CodeIgniter 4</div>
  </div>
</div>
</body>
</html>

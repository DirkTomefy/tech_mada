<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Modifier l'employé — TechMada RH</title>
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

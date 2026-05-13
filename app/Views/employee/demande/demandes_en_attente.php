<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes en attente — TechMada RH</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/style.css') ?>" rel="stylesheet">
    <style>
        .rh-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        .demande-rh-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.2s;
        }
        .demande-rh-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .demande-employee {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }
        .employee-avatar {
            width: 40px;
            height: 40px;
            background: var(--forest);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            flex-shrink: 0;
        }
        .employee-info h4 {
            margin: 0;
            font-size: 0.95rem;
            color: var(--ink);
            font-weight: 600;
        }
        .employee-info p {
            margin: 2px 0 0;
            font-size: 0.8rem;
            color: var(--muted);
        }
        .demande-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1rem 0;
            font-size: 0.85rem;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .detail-label {
            color: var(--muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .detail-value {
            color: var(--ink);
            font-weight: 500;
        }
        .motif-box {
            background: var(--cream);
            border-left: 3px solid var(--forest);
            padding: 1rem;
            border-radius: 0 6px 6px 0;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: var(--ink);
            line-height: 1.5;
        }
        .action-form {
            display: flex;
            gap: 8px;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }
        .action-textarea {
            flex: 1;
            border: 1.5px solid var(--border);
            border-radius: 6px;
            padding: 8px 10px;
            font-size: 0.8rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            min-height: 50px;
            resize: vertical;
        }
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 120px;
        }
        .btn-action {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            transition: all 0.2s;
        }
        .btn-approve {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid var(--success-br);
        }
        .btn-approve:hover {
            background: #d5f0e3;
        }
        .btn-refuse {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid var(--danger-br);
        }
        .btn-refuse:hover {
            background: #f8dbd8;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--muted);
        }
        .empty-state i {
            font-size: 3rem;
            opacity: 0.3;
            margin-bottom: 1rem;
            display: block;
        }
    </style>
</head>
<body>

<div style="background: var(--cream); min-height: 100vh;">
    <div class="rh-container">
        <!-- En-tête -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-family: 'Playfair Display', serif; color: var(--forest); margin-bottom: 0.5rem;">
                <i class="bi bi-inbox"></i> Demandes en attente
            </h1>
            <p style="color: var(--muted); font-size: 0.95rem; margin: 0;">Gestion des demandes de congé en cours de traitement</p>
        </div>

        <!-- Messages -->
        <?php if (session()->has('success')): ?>
            <div class="flash flash-success" style="margin-bottom: 1.5rem;">
                <i class="bi bi-check-circle-fill"></i>
                <span><?= session('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="flash flash-error" style="margin-bottom: 1.5rem;">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span><?= session('error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Liste des demandes -->
        <?php if (!empty($demandes)): ?>
            <?php foreach ($demandes as $demande): ?>
                <div class="demande-rh-card">
                    <!-- Employé -->
                    <div class="demande-employee">
                        <div class="employee-avatar">
                            <?= strtoupper(substr($demande['prenom'], 0, 1) . substr($demande['nom'], 0, 1)) ?>
                        </div>
                        <div class="employee-info">
                            <h4><?= htmlspecialchars($demande['prenom'] . ' ' . $demande['nom']) ?></h4>
                            <p><?= htmlspecialchars($demande['email']) ?></p>
                        </div>
                    </div>

                    <!-- Détails de la demande -->
                    <div class="demande-details">
                        <div class="detail-item">
                            <span class="detail-label">Type de congé</span>
                            <span class="detail-value"><?= htmlspecialchars($demande['type_libelle'] ?? 'N/A') ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Nombre de jours</span>
                            <span class="detail-value"><?= htmlspecialchars($demande['nb_jours']) ?> jour(s)</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Du</span>
                            <span class="detail-value"><?= date('d/m/Y', strtotime($demande['date_debut'])) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Au</span>
                            <span class="detail-value"><?= date('d/m/Y', strtotime($demande['date_fin'])) ?></span>
                        </div>
                    </div>

                    <!-- Motif -->
                    <div class="motif-box">
                        <strong style="display: block; margin-bottom: 8px; color: var(--forest); font-size: 0.8rem; text-transform: uppercase;">
                            <i class="bi bi-chat-square-text"></i> Motif
                        </strong>
                        <?= htmlspecialchars($demande['motif']) ?>
                    </div>

                    <!-- Actions -->
                    <form method="POST" action="<?= base_url('rh/conges/approuver/' . $demande['id']) ?>" class="action-form" id="form-<?= $demande['id'] ?>">
                        <?= csrf_field() ?>
                        <textarea name="commentaire" class="action-textarea" placeholder="Commentaire (optionnel)..."></textarea>
                        <div class="action-buttons">
                            <button type="submit" class="btn-action btn-approve" title="Approuver">
                                <i class="bi bi-check-circle"></i> Approuver
                            </button>
                            <button type="button" class="btn-action btn-refuse" onclick="refuser(<?= $demande['id'] ?>)" title="Refuser">
                                <i class="bi bi-x-circle"></i> Refuser
                            </button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="demande-rh-card">
                <div class="empty-state">
                    <i class="bi bi-check2-circle"></i>
                    <h3 style="margin: 0 0 0.5rem;">Aucune demande en attente</h3>
                    <p style="margin: 0; font-size: 0.9rem;">Toutes les demandes ont été traitées</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function refuser(congeId) {
        const form = document.getElementById('form-' + congeId);
        const commentaire = form.querySelector('textarea[name="commentaire"]').value;
        
        if (confirm('Êtes-vous sûr de vouloir refuser cette demande ?')) {
            const refuseForm = document.createElement('form');
            refuseForm.method = 'POST';
            refuseForm.action = '<?= base_url('rh/conges/refuser/') ?>' + congeId;
            
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '<?= csrf_token() ?>';
            csrfField.value = '<?= csrf_hash() ?>';
            
            const commentField = document.createElement('input');
            commentField.type = 'hidden';
            commentField.name = 'commentaire';
            commentField.value = commentaire;
            
            refuseForm.appendChild(csrfField);
            refuseForm.appendChild(commentField);
            document.body.appendChild(refuseForm);
            refuseForm.submit();
        }
    }
</script>

</body>
</html>

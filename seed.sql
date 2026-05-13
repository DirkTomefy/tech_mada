-- =========================================
-- DONNEES DE TEST
-- =========================================
-- =========================
-- DEPARTEMENTS
-- =========================
INSERT INTO departements(nom, description)
VALUES (
        'Informatique',
        'Service developpement et maintenance'
    ),
    ('Ressources Humaines', 'Gestion des employes'),
    ('Comptabilite', 'Gestion financiere'),
    ('Marketing', 'Communication et publicite');
-- =========================
-- TYPES DE CONGE
-- =========================
INSERT INTO types_conge(libelle, jours_annuels, deductible)
VALUES ('Conge annuel', 30, 1),
    ('Conge maladie', 15, 0),
    ('Conge maternité', 90, 0),
    ('Permission speciale', 5, 1);
-- =========================
-- EMPLOYES
-- =========================
INSERT INTO employes(
        nom,
        prenom,
        email,
        password,
        role,
        departement_id,
        date_embauche,
        actif
    )
VALUES (
        'Rakoto',
        'Jean',
        'jean.rakoto@test.com',
        '1234',
        'EMPLOYE',
        1,
        '2024-01-10',
        1
    ),
    (
        'Rabe',
        'Sarah',
        'sarah.rabe@test.com',
        '1234',
        'RH',
        2,
        '2023-05-15',
        1
    ),
    (
        'Andry',
        'Michel',
        'michel.andry@test.com',
        '1234',
        'MANAGER',
        1,
        '2022-03-01',
        1
    ),
    (
        'Rasoanaivo',
        'Julie',
        'julie.raso@test.com',
        '1234',
        'EMPLOYE',
        3,
        '2025-02-20',
        1
    );
-- =========================
-- SOLDES
-- =========================
INSERT INTO soldes(
        employe_id,
        type_conge_id,
        annee,
        jours_attribues,
        jours_pris
    )
VALUES (1, 1, 2026, 30, 5),
    (1, 2, 2026, 15, 2),
    (2, 1, 2026, 30, 10),
    (2, 4, 2026, 5, 1),
    (3, 1, 2026, 30, 12),
    (4, 1, 2026, 30, 0);
-- =========================
-- CONGES
-- =========================
INSERT INTO conges(
        employe_id,
        type_conge_id,
        date_debut,
        date_fin,
        nb_jours,
        motif,
        statut,
        commentaire_rh,
        traite_par
    )
VALUES (
        1,
        1,
        '2026-03-10',
        '2026-03-14',
        5,
        'Vacances',
        'approuve',
        'Bon repos',
        2
    ),
    (
        1,
        2,
        '2026-04-02',
        '2026-04-03',
        2,
        'Grippe',
        'approuve',
        'Certificat recu',
        2
    ),
    (
        3,
        1,
        '2026-06-01',
        '2026-06-12',
        12,
        'Voyage familial',
        'en_attente',
        NULL,
        NULL
    ),
    (
        4,
        1,
        '2026-07-15',
        '2026-07-20',
        6,
        'Vacances',
        'refuse',
        'Periode chargee',
        2
    );
-- =========================================
-- Insertion des données de test
-- =========================================

-- Types de congé
INSERT INTO types_conge (libelle, jours_annuels, deductible) VALUES
('Congé Annuel', 25, 1),
('Congé de Maladie', 15, 1),
('Congé de Maternité', 90, 0),
('Congé sans solde', 0, 0),
('Congé Spécial', 10, 1);

-- Soldes pour Jean Rakoto (EMPLOYE) - ID 1
INSERT INTO soldes (employe_id, type_conge_id, annee, jours_attribues, jours_pris) VALUES
(1, 1, 2026, 25, 3),  -- Congé Annuel
(1, 2, 2026, 15, 1),  -- Congé de Maladie
(1, 5, 2026, 10, 0);  -- Congé Spécial

-- Soldes pour Sarah Rabé (RH) - ID 2
INSERT INTO soldes (employe_id, type_conge_id, annee, jours_attribues, jours_pris) VALUES
(2, 1, 2026, 25, 5),  -- Congé Annuel
(2, 2, 2026, 15, 2),  -- Congé de Maladie
(2, 5, 2026, 10, 0);  -- Congé Spécial

-- Soldes pour Michel Andry (ADMIN) - ID 3
INSERT INTO soldes (employe_id, type_conge_id, annee, jours_attribues, jours_pris) VALUES
(3, 1, 2026, 25, 0),  -- Congé Annuel
(3, 2, 2026, 15, 0),  -- Congé de Maladie
(3, 5, 2026, 10, 0);  -- Congé Spécial

-- Soldes pour Julie Raso (EMPLOYE) - ID 4
INSERT INTO soldes (employe_id, type_conge_id, annee, jours_attribues, jours_pris) VALUES
(4, 1, 2026, 25, 8),  -- Congé Annuel
(4, 2, 2026, 15, 3),  -- Congé de Maladie
(4, 5, 2026, 10, 2);  -- Congé Spécial

-- Exemples de demandes de congé (optionnel)
-- INSERT INTO conges (employe_id, type_conge_id, date_debut, date_fin, nb_jours, motif, statut, created_at)
-- VALUES
-- (1, 1, '2026-05-20', '2026-05-22', 3, 'Vacances en famille', 'approuve', datetime('now')),
-- (4, 1, '2026-06-10', '2026-06-14', 5, 'Visite médicale et repos', 'en_attente', datetime('now'));

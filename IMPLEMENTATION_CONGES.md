# Implémentation du système de gestion des congés

## 📝 Résumé

Un système complet de gestion des demandes de congé a été implémenté pour l'application TechMada RH. Ce système permet aux employés de soumettre des demandes et aux responsables RH d'approuver ou refuser ces demandes.

## ✅ Fichiers créés/modifiés

### Modèles (app/Models/)
1. **CongeModel.php** - Gestion des demandes de congé
   - `creerDemande()` - Créer une demande
   - `getByEmploye()` - Récupérer les demandes d'un employé
   - `getEnAttente()` - Récupérer les demandes en attente
   - `updateStatut()` - Mettre à jour le statut
   - `calculerJours()` - Calculer le nombre de jours
   - `validateDates()` - Valider les dates

2. **TypeCongeModel.php** - Types de congé
   - `getAll()` - Récupérer tous les types
   - `getDeductibles()` - Récupérer les types déductibles

3. **SoldeModel.php** - Gestion des soldes
   - `getSoldeEmploye()` - Récupérer le solde d'un employé
   - `getJoursRestants()` - Calculer les jours restants
   - `updateJoursPris()` - Mettre à jour les jours pris

### Contrôleurs (app/Controllers/)
1. **CongeController.php** - Nouveau contrôleur pour les congés
   - `formulaire()` - Afficher le formulaire
   - `soumettre()` - Traiter la soumission
   - `mesDemandes()` - Afficher l'historique
   - `demandesEnAttente()` - Afficher les demandes en attente (RH)
   - `approuver()` - Approuver une demande (RH)
   - `refuser()` - Refuser une demande (RH)

2. **EmployeeController.php** - Modifié
   - Ajout de `dashboard()` - Affiche le dashboard après connexion
   - Modification de `loginProcess()` - Redirection vers dashboard

### Vues (app/Views/employee/demande/)
1. **formulaire.php** - Formulaire de demande
   - Sélection du type de congé
   - Choix des dates
   - Affichage du solde disponible
   - Calcul automatique des jours

2. **mes_demandes.php** - Historique des demandes
   - Liste des demandes avec statut
   - Filtrage par statut
   - Affichage des commentaires RH

3. **demandes_en_attente.php** - Interface RH
   - Liste des demandes à traiter
   - Formulaire d'approbation/refus
   - Ajout de commentaires

### Autres vues
1. **app/Views/employee/dashboard.php** - Dashboard après connexion
   - Accès rapide aux fonctionnalités
   - Informations utilisateur
   - Liens vers les demandes

### Configuration (app/Config/)
1. **Routes.php** - Modifié
   - Ajout des routes pour les congés
   - Ajout de la route dashboard

## 🗂️ Structure de base de données

Trois nouvelles tables ont été utilisées :

### types_conge
- id: PRIMARY KEY
- libelle: Nom du type de congé
- jours_annuels: Nombre de jours annuels
- deductible: Si déductible du solde

### conges
- id: PRIMARY KEY
- employe_id: Référence à l'employé
- type_conge_id: Référence au type de congé
- date_debut/fin: Dates de la demande
- nb_jours: Nombre de jours
- motif: Raison de la demande
- statut: en_attente, approuve, refuse, annule
- commentaire_rh: Commentaire du RH
- traite_par: Employé qui a traité
- created_at: Date de création

### soldes
- id: PRIMARY KEY
- employe_id: Référence à l'employé
- type_conge_id: Référence au type de congé
- annee: Année
- jours_attribues: Jours disponibles
- jours_pris: Jours utilisés

## 🔄 Flux de travail

### Pour un employé
1. ✅ Connexion → Dashboard
2. ✅ Clic sur "Nouvelle demande"
3. ✅ Remplissage du formulaire
4. ✅ Soumission (statut: en_attente)
5. ✅ Consultation de l'historique

### Pour un RH/Admin
1. ✅ Connexion → Dashboard (affiche le lien RH)
2. ✅ Accès à "À traiter"
3. ✅ Consultation des demandes
4. ✅ Approbation ou refus
5. ✅ Ajout de commentaires

## 🛡️ Sécurité implémentée

- ✅ Vérification de session pour chaque action
- ✅ CSRF protection sur tous les formulaires
- ✅ Validation des données côté serveur
- ✅ Vérification des rôles (RH/Admin)
- ✅ Hachage des mots de passe (bcrypt)
- ✅ Foreign keys dans la base de données

## 🧪 Données de test

Le fichier `seed_conges.sql` contient :
- 5 types de congé
- Soldes pour chaque employé (année 2026)
- Exemples commentés de demandes

### Comptes de test
```
EMPLOYE:
- jean.rakoto@test.com / emp123 (25 jours annuels, 3 pris)
- julie.raso@test.com / emp123 (25 jours annuels, 8 pris)

RH:
- sarah.rabe@test.com / rh123

ADMIN:
- michel.andry@test.com / admin123
```

## 📱 Design et UX

- ✅ Design système cohérent avec CSS unifié
- ✅ Icones Bootstrap (bi- prefix)
- ✅ Responsive design
- ✅ Animations et transitions fluides
- ✅ Messages d'erreur/succès clairs
- ✅ Calcul automatique des jours
- ✅ Affichage en temps réel du solde

## 🚀 Installation

### 1. Importer les tables
```bash
cd /home/omen-hp-pc/S4/Systeme_d_info/tech_mada
sqlite3 conge.db < conge.sql
```

### 2. Importer les données de test
```bash
sqlite3 conge.db < seed_conges.sql
```

### 3. Accéder à l'application
```bash
php -S localhost:8080 -t public
```

### 4. Premiers pas
- Login: http://localhost:8080/employee/login
- Email: jean.rakoto@test.com
- Mot de passe: emp123

## 📊 Statistiques

- **Modèles**: 4 (CongeModel, TypeCongeModel, SoldeModel, EmployeeModel)
- **Contrôleurs**: 2 (CongeController, EmployeeController modifié)
- **Vues**: 4 (formulaire, mes_demandes, demandes_en_attente, dashboard)
- **Routes**: 9 nouvelles routes
- **Tables DB**: 3 utilisées (types_conge, conges, soldes)
- **Fonctionnalités**: 7 principales

## 🔍 Points clés

1. **Session utilisateur** : L'ID de l'employé est stocké en session après la connexion
2. **Calcul des jours** : Automatique lors de la sélection des dates
3. **Validation du solde** : Avant la soumission
4. **Workflow d'approbation** : 4 statuts possibles
5. **Traçabilité** : Qui a traité la demande et quand
6. **Flexibilité** : Types de congé configurables, soldes modifiables

## ✨ Améliorations futures

- [ ] Notifications par email
- [ ] Export PDF des demandes
- [ ] Historique des modifications
- [ ] Recalcul automatique des soldes en fin d'année
- [ ] Import en masse des soldes
- [ ] Rapport statistique RH
- [ ] Calendrier visuel des congés
- [ ] API REST pour intégration

## 📞 Utilisation

### Routes disponibles

**Employé:**
- `GET /employee/dashboard` - Dashboard
- `GET /employee/conges/formulaire` - Formulaire
- `POST /employee/conges/soumettre` - Soumettre
- `GET /employee/conges/mes-demandes` - Historique
- `GET /employee/logout` - Déconnexion

**RH/Admin:**
- `GET /rh/conges/en-attente` - Demandes en attente
- `POST /rh/conges/approuver/:id` - Approuver
- `POST /rh/conges/refuser/:id` - Refuser

## 📄 Fichiers

```
app/
├── Models/
│   ├── CongeModel.php          ← NOUVEAU
│   ├── TypeCongeModel.php      ← NOUVEAU
│   ├── SoldeModel.php          ← NOUVEAU
│   └── EmployeeModel.php       ← Existant
├── Controllers/
│   ├── CongeController.php     ← NOUVEAU
│   └── EmployeeController.php  ← MODIFIÉ
├── Config/
│   └── Routes.php              ← MODIFIÉ
└── Views/
    └── employee/
        ├── dashboard.php                    ← NOUVEAU
        └── demande/
            ├── formulaire.php               ← NOUVEAU
            ├── mes_demandes.php             ← NOUVEAU
            └── demandes_en_attente.php      ← NOUVEAU
```

---

**Créé le:** 13 mai 2026
**Statut:** ✅ Complet et fonctionnel

# Système de Gestion des Congés - TechMada RH

## 📋 Vue d'ensemble

Ce système permet aux employés de soumettre des demandes de congé, et aux responsables RH d'approuver ou refuser ces demandes.

## 🎯 Fonctionnalités

### Pour les employés
- ✅ Soumettre une demande de congé
- ✅ Consulter l'historique des demandes
- ✅ Voir les soldes disponibles
- ✅ Calcul automatique du nombre de jours

### Pour les RH/Admin
- ✅ Consulter les demandes en attente
- ✅ Approuver/Refuser les demandes
- ✅ Ajouter des commentaires

## 🗂️ Structure des fichiers

```
app/
├── Models/
│   ├── CongeModel.php          # Gestion des demandes de congé
│   ├── TypeCongeModel.php      # Types de congé
│   └── SoldeModel.php          # Gestion des soldes
├── Controllers/
│   ├── CongeController.php     # Contrôleur des congés
│   └── EmployeeController.php  # Contrôleur des employés (modifié)
└── Views/
    └── employee/
        └── demande/
            ├── formulaire.php           # Formulaire de demande
            ├── mes_demandes.php         # Historique des demandes
            └── demandes_en_attente.php  # Demandes à traiter (RH)
```

## 📦 Tables de base de données

### `types_conge`
```sql
CREATE TABLE types_conge (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL,
    jours_annuels INTEGER NOT NULL DEFAULT 0,
    deductible INTEGER NOT NULL DEFAULT 1
);
```

### `conges`
```sql
CREATE TABLE conges (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conge_id INTEGER NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_jours REAL NOT NULL,
    motif TEXT,
    statut TEXT NOT NULL DEFAULT 'en_attente',
    commentaire_rh TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    traite_par INTEGER,
    FOREIGN KEY (employe_id) REFERENCES employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id),
    FOREIGN KEY (traite_par) REFERENCES employes(id)
);
```

### `soldes`
```sql
CREATE TABLE soldes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER NOT NULL,
    type_conge_id INTEGER NOT NULL,
    annee INTEGER NOT NULL,
    jours_attribues REAL NOT NULL DEFAULT 0,
    jours_pris REAL NOT NULL DEFAULT 0,
    FOREIGN KEY (employe_id) REFERENCES employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id),
    UNIQUE(employe_id, type_conge_id, annee)
);
```

## 🚀 Utilisation

### 1. Initialiser les données

Exécutez les scripts SQL suivants :
```bash
sqlite3 conge.db < conge.sql          # Tables principales
sqlite3 conge.db < seed_conges.sql    # Données de test
```

### 2. Flux employé

1. Se connecter : `http://localhost:8080/employee/login`
   - Email: `jean.rakoto@test.com`
   - Mot de passe: `emp123`

2. Accéder au dashboard : `http://localhost:8080/employee/dashboard`

3. Soumettre une demande : `http://localhost:8080/employee/conges/formulaire`
   - Sélectionner un type de congé
   - Choisir les dates
   - Ajouter un motif

4. Consulter l'historique : `http://localhost:8080/employee/conges/mes-demandes`

### 3. Flux RH/Admin

1. Se connecter avec un compte RH/Admin
   - Email: `sarah.rabe@test.com` (RH) / `michel.andry@test.com` (Admin)
   - Mot de passe: `rh123` / `admin123`

2. Accéder à la section RH : `http://localhost:8080/rh/conges/en-attente`

3. Traiter les demandes :
   - Consulter les détails de la demande
   - Ajouter un commentaire (optionnel)
   - Approuver ou Refuser

## 🔄 Flux de statut

```
Soumission par l'employé
         ↓
    en_attente
         ↓
    ┌────┴────┐
    ↓         ↓
 approuve   refuse
    ↓         ↓
 Validé    Rejeté
```

## 📊 Sessions

Après la connexion, les données suivantes sont stockées en session :

```php
session()->set([
    'id'        => 1,
    'email'     => 'jean.rakoto@test.com',
    'nom'       => 'Rakoto',
    'prenom'    => 'Jean',
    'role'      => 'EMPLOYE',     // EMPLOYE, RH ou ADMIN
    'logged_in' => true
]);
```

## 🛡️ Sécurité

- ✅ CSRF protection activée
- ✅ Validation des données
- ✅ Vérification de session à chaque action
- ✅ Vérification des rôles (RH/Admin)
- ✅ Hachage des mots de passe (bcrypt)

## 📝 Routes

### Employé
- `GET /employee/conges/formulaire` - Afficher le formulaire
- `POST /employee/conges/soumettre` - Soumettre une demande
- `GET /employee/conges/mes-demandes` - Voir ses demandes
- `GET /employee/dashboard` - Dashboard

### RH/Admin
- `GET /rh/conges/en-attente` - Demandes en attente
- `POST /rh/conges/approuver/:id` - Approuver
- `POST /rh/conges/refuser/:id` - Refuser

## 🧪 Données de test

```
Employés :
- jean.rakoto@test.com (EMPLOYE) - emp123
- sarah.rabe@test.com (RH) - rh123
- michel.andry@test.com (ADMIN) - admin123
- julie.raso@test.com (EMPLOYE) - emp123

Types de congé :
- Congé Annuel (25 jours/an)
- Congé de Maladie (15 jours/an)
- Congé de Maternité (90 jours, non déductible)
- Congé sans solde (illimité)
- Congé Spécial (10 jours/an)
```

## 📞 Support

Pour toute question ou problème, consultez la documentation CodeIgniter 4 :
https://codeigniter.com/user_guide/

## 📄 Licence

Ce projet fait partie du système TechMada RH.

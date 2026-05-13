#!/bin/bash

# Script de vérification du système de gestion des congés
# Utilisation: bash check_conges.sh

echo "=================================================="
echo "  ✓ Vérification du système de gestion des congés"
echo "=================================================="
echo ""

# Couleurs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Vérifier les fichiers modèles
echo "📦 Vérification des modèles:"
files=(
    "app/Models/CongeModel.php"
    "app/Models/TypeCongeModel.php"
    "app/Models/SoldeModel.php"
)
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "  ${GREEN}✓${NC} $file"
    else
        echo -e "  ${RED}✗${NC} $file (MANQUANT)"
    fi
done

echo ""
echo "🎮 Vérification des contrôleurs:"
files=(
    "app/Controllers/CongeController.php"
    "app/Controllers/EmployeeController.php"
)
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "  ${GREEN}✓${NC} $file"
    else
        echo -e "  ${RED}✗${NC} $file (MANQUANT)"
    fi
done

echo ""
echo "👁️  Vérification des vues:"
files=(
    "app/Views/employee/dashboard.php"
    "app/Views/employee/demande/formulaire.php"
    "app/Views/employee/demande/mes_demandes.php"
    "app/Views/employee/demande/demandes_en_attente.php"
)
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "  ${GREEN}✓${NC} $file"
    else
        echo -e "  ${RED}✗${NC} $file (MANQUANT)"
    fi
done

echo ""
echo "🗄️  Vérification de la base de données:"
if [ -f "conge.db" ]; then
    tables=$(sqlite3 conge.db "SELECT COUNT(*) FROM sqlite_master WHERE type='table' AND name IN ('types_conge', 'conges', 'soldes');")
    if [ "$tables" = "3" ]; then
        echo -e "  ${GREEN}✓${NC} Tables créées (3/3)"
        
        # Compter les types de congé
        count=$(sqlite3 conge.db "SELECT COUNT(*) FROM types_conge;")
        echo -e "  ${GREEN}✓${NC} Types de congé: $count"
        
        # Compter les soldes
        count=$(sqlite3 conge.db "SELECT COUNT(*) FROM soldes;")
        echo -e "  ${GREEN}✓${NC} Soldes: $count"
    else
        echo -e "  ${RED}✗${NC} Tables manquantes ($tables/3)"
    fi
else
    echo -e "  ${RED}✗${NC} Base de données manquante"
fi

echo ""
echo "📋 Résumé:"
echo "  • Modèles: 3 (Conge, TypeConge, Solde)"
echo "  • Contrôleurs: 1 nouveau (CongeController) + 1 modifié"
echo "  • Vues: 4 (dashboard, formulaire, mes_demandes, demandes_en_attente)"
echo "  • Routes: 9 nouvelles"
echo "  • Tables BD: 3"

echo ""
echo "=================================================="
echo "  ✓ Vérification terminée!"
echo "=================================================="
echo ""
echo "📚 Prochaines étapes:"
echo "  1. Importer les données de test:"
echo "     sqlite3 conge.db < seed_conges.sql"
echo ""
echo "  2. Démarrer le serveur:"
echo "     php -S localhost:8080 -t public"
echo ""
echo "  3. Accéder à l'application:"
echo "     http://localhost:8080/employee/login"
echo ""

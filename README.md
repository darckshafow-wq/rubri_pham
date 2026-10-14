# Phama Garde - Annuaire des Pharmacies de Garde (Côte d'Ivoire)

Application web développée en **PHP pur** avec une architecture **MVC** (Modèle - Vue - Contrôleur) stricte, sécurisée et modulaire.

---

## Fonctionnalités Principales

### 1. Espace Public (Clients / Visiteurs)
- **Sans inscription nécessaire.**
- **Recherche multicritères instantanée :**
  - Filtrage par **Ville** (ex : *Abidjan*, *Yamoussoukro*, *Bouaké*).
  - Filtrage dynamique par **Quartier** via API JSON (ex : *Cocody*, *Plateau*, *Yopougon*, *Morofe*).
  - Recherche textuelle par nom de pharmacie.
- **Affichage prioritaire :** Les pharmacies de garde (`is_on_guard = 1`) apparaissent automatiquement en tête de liste avec indicateur visuel dynamique et contact direct cliquable (`tel:`).
- **Fiche détaillée par pharmacie (`/pharmacy/detail?id=X` ou `/pharmacy/{id}`) :** Consultation des repères d'accès, adresse complète, bouton d'appel direct d'urgence, recommandations médicales et lien GPS.

### 2. Espace Partenaire (Pharmaciens)
- **Interface moderne Dark UI (Style Fintrixity)** avec barre latérale et cartes de statistiques.
- **Inscription autonome** avec compte en attente de validation (`is_approved = 0`).
- **Interrupteur interactif (Toggle Switch) :** Bascule instantanée du statut de garde (`is_on_guard = 1` ou `0`) avec retour visuel immédiat.
- **Gestion du profil de l'établissement :** Modification des coordonnées, ville, quartier, adresse et repères.
- **Aperçu visuel client en direct :** Visualisation exacte de la carte affichée aux patients.

### 3. Espace Super Admin
- **Tableau de bord statistique (KPIs) :**
  - Total des pharmacies enregistrées.
  - Nombre de demandes d'inscription en attente.
  - Nombre de pharmacies validées.
  - Nombre de pharmacies actuellement de garde.
- **File de validation :** Examen et approbation en un clic des nouvelles pharmacies partenaires.
- **Surveillance du réseau :** Supervision globale de l'état du réseau en temps réel avec accès aux fiches publiques.

---

## Architecture des Dossiers

```
rubri_pham/
├── config/
│   └── database.php              # Configuration de la connexion MySQL (PDO)
├── controllers/
│   ├── AdminController.php       # Dashboard admin, KPIs et approbation des partenaires
│   ├── AuthController.php        # Connexion, inscription partenaire et déconnexion
│   ├── ClientController.php      # Landing page, recherche, détail et API des quartiers
│   └── PharmacyController.php    # Dashboard pharmacien, bascule de garde et profil
├── models/
│   ├── Database.php              # Singleton PDO de connexion à MySQL
│   ├── Pharmacy.php              # Logique métier et requêtes SQL (recherche, garde, CRUD)
│   └── User.php                  # Gestion des comptes (authentification, hachage bcrypt)
├── views/
│   ├── admin/
│   │   └── dashboard.php         # Interface Super Admin (Dark Sleek + KPIs + tableau des validations)
│   ├── auth/
│   │   └── login.php             # Formulaire à onglets (Connexion & Inscription)
│   ├── client/
│   │   ├── home.php              # Page d'accueil avec barre de recherche & pharmacies de garde
│   │   ├── results.php           # Résultats de recherche filtrés par ville/quartier
│   │   └── detail.php            # Fiche détaillée de la pharmacie & contact d'urgence
│   ├── pharmacy/
│   │   └── dashboard.php         # Espace pharmacien moderne avec Toggle Switch haute fidélité
│   └── layouts/
│       ├── header.php            # En-tête HTML, navigation dynamique & chargement du CSS dédié
│       └── footer.php            # Pied de page & scripts JS
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   ├── global.css        # Styles globaux, variables et layout
│   │   │   ├── auth.css          # Style dédié à la page de connexion & inscription
│   │   │   ├── home.css          # Style dédié à la landing page & hero search
│   │   │   ├── results.css       # Style dédié à la liste des résultats de recherche
│   │   │   ├── detail.css        # Style dédié à la fiche détaillée de pharmacie
│   │   │   ├── pharmacy-dashboard.css # Style dédié à l'espace pharmacien (Fintrixity Dark)
│   │   │   └── admin-dashboard.css    # Style dédié au dashboard admin (Fintrixity Dark)
│   │   └── js/
│   │       └── script.js         # Interactions dynamiques (AJAX quartiers, auto-dismiss alertes)
│   └── index.php                 # Front Controller unique & Routeur
├── database/
│   └── schema.sql                # Schéma MySQL Merise & Données de test (Côte d'Ivoire)
├── .htaccess                     # Réécriture Apache vers public/index.php
├── ROADMAP_V2.md                 # Feuille de route et évolutions pour la Version 2.0
└── README.md
```

---

## Feuilles de Style Dédiées (Maintenabilité)

Chaque vue dispose de sa propre feuille de style CSS injectée dynamiquement via la variable `$pageCss` dans le layout principal :
- `global.css` : Thème commun (vert pharmacie, reset, navbar, alertes)
- `home.css` : Hero banner, barre de recherche et cartes des gardes actives
- `results.css` : Cartes de résultats avec bordures colorées selon le statut de garde
- `detail.css` : Fiche détaillée, grand bouton d'appel et repère cartographique
- `auth.css` : Onglets interactifs de connexion et formulaire partenaire
- `pharmacy-dashboard.css` : Tableau de bord pharmacien moderne (Dark UI + Vert néon)
- `admin-dashboard.css` : Tableau de bord super admin (Dark UI + KPIs + Tableaux foncés)

---

## Configuration & Base de Données

### Paramètres MySQL (`config/database.php`) :
- **Hôte :** `127.0.0.1`
- **Base :** `phama_garde`
- **Utilisateur :** `admin`
- **Mot de passe :** `admin`

### Exécution du script de migration :
```bash
mysql -u admin -padmin -h 127.0.0.1 phama_garde < database/schema.sql
```

---

## Identifiants des Comptes de Test

| Rôle | Nom | Email | Mot de passe | Description |
| :--- | :--- | :--- | :--- | :--- |
| **Super Admin** | Super Admin | `admin@admin.com` | `admin` | Accès complet au dashboard de gestion & validation |
| **Pharmacie** | Dr. Koffi Yao | `dr.koffi@phamagarde.ci` | `admin` | Pharmacie du Bélier (Yamoussoukro, De garde) |
| **Pharmacie** | Dr. Aminata Diallo | `dr.aminata@phamagarde.ci` | `admin` | Pharmacie des Cocotiers (Abidjan Cocody, De garde) |
| **Pharmacie** | Dr. Kouassi Jean | `dr.kouassi@phamagarde.ci` | `admin` | Pharmacie du Plateau (Abidjan Plateau, Hors garde) |
| **Pharmacie** | Dr. Konan Michel | `dr.konan@phamagarde.ci` | `admin` | Pharmacie Espoir Marcory (En attente d'approbation) |

---

## Lancement du Serveur de Développement

Depuis la racine du projet :
```bash
php -S localhost:8000 -t public
```
Puis ouvrez votre navigateur sur : [http://localhost:8000](http://localhost:8000)

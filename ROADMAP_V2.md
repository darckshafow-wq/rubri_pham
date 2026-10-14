# 📋 Phama Garde — Feuille de Route & Améliorations Futures (Version 2.0)

Ce document formalise les évolutions stratégiques, techniques et fonctionnelles prévues pour la **Version 2 (V2)** de l'application **Phama Garde**, visant à enrichir l'expérience utilisateur des citoyens et optimiser la gestion quotidienne des officines de Côte d'Ivoire.

---

## 🗺️ 1. Géolocalisation Intégrée & Cartographie Interactive

### 📍 Géolocalisation en 1 Clic ("Autour de moi")
- Détection automatique de la position GPS du patient via l'API HTML5 `navigator.geolocation`.
- Calcul de la distance réelle en kilomètres (formule de Haversine ou API de routage) par rapport aux officines de garde ouvertes.
- Tri instantané des résultats par proximité kilométrique croissante.

### 🗺️ Carte Interactive Dédiée (Leaflet / OpenStreetMap / Google Maps)
- Affichage d'une carte interactive sur la page d'accueil et les résultats.
- Marqueurs visuels différenciés :
  - **Marqueur Vert Clignotant** : Pharmacie de garde active.
  - **Marqueur Gris / Neutre** : Pharmacie en service standard de jour.
- Popups au clic avec nom, téléphone et bouton d'itinéraire direct vers Google Maps / Waze / Apple Maps.

---

## 📅 2. Gestion Avancée des Plannings & Calendriers de Garde

### ⏰ Automatisation Programmée des Gardes
- Système de calendrier récurrent permettant au pharmacien de programmer ses semaines ou nuits de garde à l'avance.
- Activation et désactivation automatisée du statut `is_on_guard = 1` à des heures précises (ex: bascule automatique à 20h00 le soir et fin à 08h00 le matin) via des tâches CRON.
- Calendrier mensuel prévisionnel consultable par le public pour savoir quelle pharmacie sera de garde le week-end prochain.

---

## 📲 3. Notifications Multi-Canal (SMS, WhatsApp & Push)

### 💬 Intégration API WhatsApp & SMS
- Bouton *"Envoyer l'ordonnance sur WhatsApp"* directement depuis la fiche détaillée de la pharmacie.
- Notification SMS / WhatsApp aux usagers abonnés à un quartier lorsqu'une pharmacie entre en garde pour le week-end ou un jour férié.
- Alertes de validation instantanées envoyées par email/SMS au pharmacien lorsque le Super Admin valide son inscription.

---

## 💊 4. Disponibilité des Médicaments & Gestion des Stocks d'Urgence

### 🔍 Signalement et Recherche de Médicaments Clés
- Recherche par nom de molécule ou produit médical d'urgence (sérum antivenimeux, insuline, antipaludiques d'urgence, oxygène médical).
- Possibilité pour le pharmacien d'indiquer en 1 clic la disponibilité d'un stock d'urgence critique.
- Signalement par les usagers des ruptures de stock fréquentes.

---

## 📱 5. Expérience Mobile PWA (Progressive Web App)

### 📲 Application Installable Sans Passer par les Stores
- Configuration d'un fichier `manifest.json` et d'un Service Worker pour permettre l'installation de Phama Garde sur l'écran d'accueil iOS et Android.
- Fonctionnement en mode **Hors-ligne partiel** (mise en cache des dernières pharmacies de garde consultées et de leurs numéros d'urgence).
- Temps de chargement quasi-instantané optimisé pour les connexions mobiles 3G/4G en Afrique de l'Ouest.

---

## 🛡️ 6. Sécurité Renforcée, Multi-Comptes & Administration V2

### 🏢 Multi-Utilisateurs par Officine
- Possibilité pour un titulaire de créer des accès secondaires pour ses préparateurs ou assistants de garde avec des permissions limitées (uniquement bascule de la garde).
- Journal d'audit (Logs) traçant avec précision l'heure, la date et l'utilisateur ayant activé ou désactivé la garde.

### 📄 Vérification Numérique des Titulaires
- Dépôt de justificatifs légaux lors de l'inscription (licence d'exploitation ou attestation de l'Ordre National des Pharmaciens de Côte d'Ivoire).
- Interface Super Admin avec prévisualisation des documents PDF avant approbation du compte.

---

## 🌐 7. API Publique RESTful & Interconnexion Institutionnelle

### 🔌 API Ouverte pour Partenaires et Samu
- Mise à disposition d'une API REST sécurisée par jeton Bearer pour les services d'urgence (SAMU de Côte d'Ivoire, pompiers militaires GSPM, cliniques privées).
- Documentation interactive Swagger / OpenAPI intégrée.
- Webhooks pour notifier des applications tierces lors du changement d'état d'une garde.

---

## 📊 8. Analytics & Statistiques d'Impact Sanitaire

- Tableau de bord décisionnel pour l'Ordre des Pharmaciens et le Ministère de la Santé :
  - Taux de couverture de garde par commune / département.
  - Nombre de recherches d'usagers par quartier pour identifier les zones en déficit d'officines de garde.
  - Analyse des pics horaires de recherche d'urgence.

---

*Document maintenu par l'équipe de développement Phama Garde.*


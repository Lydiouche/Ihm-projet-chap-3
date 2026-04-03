Ce fichier README a été généré le [2026-04-03] par [Groupe_L] d'après la mise en page du site [Recherche.data.gouv].

Dernière mise à jour le : [2026-04-03].

# Guide d'utilisation du site vitrine : "Suivi des maladies courantes"

## Introduction
Ce projet a été réalisé dans le cadre de l'UE IHM. Il s'agit d'un site vitrine développé avec React et Vite, permettant de consulter et de gérer une base de données locale de pathologies courantes.

L'objectif de ce README est de vous aidez à prendre en main au mieux le code du site "Suivi des maladies courantes". En esperant que vous trouverez toutes les réponses à vos questions vis-à-vis de son installation et du fonctionnement du code.

Ce projet utilise: 
Javascript & React
CSS
JSON

## Description générale du projet
L'application est divisée en 3 sections principales : 
- Accueil : présentation des actualités. 
- Les maladies : consultation par spécialités médicales. 
- Paramétrage : interface administrative avec ajout, modification ou suppression de maladie. 
Note : Les modifications sont persistantes grâce au localStorage. Le fichier data.json sert de base de données initiale et peut être restauré à tout moment via le bouton dédié.

## Plus de détails sur chacune des parties : 
### Sur la page d'accueil : 
Affiche les maladies "du moment" tout en donnant des conseils de prévention sanitaire.
Présence d'un "footer" pour expliquer l'objectif du site
Vitrine simple, peut être modifié tous les mois mais pour cela il faut modifier le code.

### Page Les Maladies et Parametrage : 
Ces differentes maladies sont regroupées en catégorie selon les tissus touchés. 
Pour chaque maladie on a des informations sur ses symptomes, le public affecté, les traitements, etc.

Il est possible de les supprimer, de les modifier ou encore d'en ajouter.
Pour la suppression, il y a une confirmation utilisateur et il est possible également de restaurer les données des maladies (ceux faisant partie de la base de données initiales (data.json)).
Etant un site vitre, l'ensemble de ces paramètrages se font en localstorage, il n'y a pas de modification du data.json (qui lui integre l'ensemble d'une base de maladie).


## Installation
Pour lancer le projet sur votre machine, suivez ces étapes :
- Prérequis : assurez-vous d'avoir Node.js installé sur votre ordinateur. 
- Extraction du projet : KADIRI-LEFEBVRE-TONNOIR dans le dossier de votre choix. 
- Installation : ouvrez un terminal dans le dossier où est le projet. Executez la commande npm install. 
- Lancement du serveur local : commande npm run dev. 
- Consultation : ouvrez le navigateur de votre choix avec l'adresse http://localhost:5173. 

Si vous voulez créer un projet React : 
npm create vite@latest
--> creation d'un projet react (il sera possible de le lancer plus tard par le biais de "npm run dev", a condition de respecter le chemin d'acces du projet).

## Arborescence

Le projet React possède une arborescence bien spécifique :
## Arborescence du projet

Le projet React possède une arborescence structurée comme suit :

```text
KADIRI-LEFEBVRE-TONNOIR/
├── src/
│   ├── assets/          # Fichiers statiques (logos, etc.)
│   ├── data/            # Images des spécialités (.jpg)
│   ├── App.jsx          # Composant principal (Logique de navigation)
│   ├── App.css          # Styles généraux
│   ├── Menu.css         # Styles des composants et de la grille
│   ├── data.json        # Jeu de données minimal (JSON initial)
│   └── main.jsx         # Point d'entrée React
├── index.html           # Structure HTML de base
├── package.json         # Dépendances et scripts de l'application
├── README.md            # Guide d'utilisation
└── vite.config.js       # Configuration de l'outil de build
## Utilisation
Toutes les fonctions React doivent être en PascalCase.

Choix techniques :
- Gestion des images : nous utilisons import.meta.glob pour importer dynamiquement les images du dossier src/data/. Cela permet de lier automatiquement une catégorie du JSON à son image correspondante sans imports manuels.

- Persistance : utilisation de useEffect pour synchroniser l'état de l'application avec le localStorage (index du menu, liste des maladies, et navigation interne).

- Interface : mise en page réalisée avec CSS Grid (affichage adaptatif en 4 colonnes pour les spécialités).

## Contributions
Le développement de cette vitrine React a été un travail collaboratif où chaque membre du groupe a apporté son expertise pour enrichir l'expérience utilisateur : 
- Lydia : conception de l'architecture globale de navigation avec la création du menu interactif et de la page d'Accueil. 
- Sofia : sGestion de la structure des données via le fichier JSON, affichage de la collection et implémentation des fonctions de suppression/restauration.
- Élise : Développement des fonctionnalités de mise à jour dynamique (formulaires d'ajout et d'édition des fiches maladies).

Enfin, la rédaction de cette documentation a été réalisée par l'ensemble de l'équipe.

Ce fichier README a été généré le [2026-04-02] par [Groupe_L] d'après la mise en page du site [Recherche.data.gouv].

Dernière mise à jour le : [2026-04-02].

# Guide d'utilisation du site vitrine : "Suivi des maladies courantes"

## Introduction
L'objectif de ce README est de vous aidez à prendre en main au mieux le code du site "Suivi des maladies courantes". En esperant que vous trouverez toutes les réponses à vos questions vis-à-vis de son installation et du fonctionnement du code.

Ce projet a nécessite l'utilisation de : 
Javascript & React
CSS


## Description générale du projet
Ce projet fait partie de l'UE IHM avec pour but de créer un site vitrine en React.
Nous sommes parties sur la synthèse d'un site présentant les maladies. 

Sur la page d'accueil : 
Affiche les maladies "du moment" tout en donnant des conseils de prévention sanitaire.
Présence d'un "footer" pour expliquer l'objectif du site
Vitrine simple, peut être modifié tous les mois mais pour cela il faut modifier le code.

Page Les Maladies et Parametrage : 
Ces differentes maladies sont regroupées en catégorie selon les tissus touchés. 
Pour chaque maladie on a des informations sur ses symptomes, le public affecté, les traitements, etc.

Il est possible de les supprimer, de les modifier ou encore d'en ajouter.
Pour la suppression, il y a une confirmation utilisateur et il est possible également de restaurer les données des maladies (ceux faisant partie de la base de données initiales (data.json)).
Etant un site vitre, l'ensemble de ces paramètrages se font en localstorage, il n'y a pas de modification du data.json (qui lui integre l'ensemble d'une base de maladie).


## Installation
Pour simplifier l'installation de React, nous utilisons "Node" ainsi que "npm".
Tout d'abord il est nécessaire de télécharger Node.js correspond au système d'exploitation que vous utilisez.


Dans le terminal : 
node
npm 
--> permet de vérifier leurs installation dans le système d'exploitation

npm install
--> installation de toutes les dépendaces pouvant être nécessaire au projet.

SYNTHESE NEW PROJET? COMMENT RECUP DIRECTEMENT SI PREEXISTANT ??????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????


npm create vite@latest
--> creation d'un projet react (il sera possible de le lancer plus tard par le biais de "npm run dev", a condition de respecter le chemin d'acces du projet.).


## Arborescence
Le projet React possède une arborescence bien spécifique : 
![Capture d'écran de l'arborescence du projet] (.public\data\arborescence.jpeg)
OU
suivi-maladies/
│
├── public/
│   └── data
|        └── images.jpg  # ensemble des images utilisés pour le site
│
├── src/
│   ├── App.jsx          # Composant principal de l'application
│   ├── data.json        # Base de données initiale des maladies
│   ├── Menu.css         # Styles de l'application
│   └── main.jsx         # Point d'entrée React
│
├── package.json         # Dépendances et scripts npm
├── README.md            # Documentation du projet
└── vite.config.js / configuration du projet




## Utilisation
Toutes les fonctions React doivent être en PascalCase.



## Contributions
Le développement de cette vitrine React a été un travail collaboratif où chaque membre du groupe a apporté son expertise pour enrichir l'expérience utilisateur : 
- Lydia a conçu l'architecture globale de la navigation avec la création du menu interactif et de la page d'Accueil. 
- Sofia s'est chargée de la gestion structurée des données via le fichier JSON, de la mise en valeur visuelle de la collection dans l'onglet « Les maladies », ainsi que de l'implémentation des fonctions de suppression et de restauration des données dans la section « Paramétrage » et « Les maladies ». 
- Élise a piloté les fonctionnalités de mise à jour dynamique, permettant aux utilisateurs de modifier les fiches de maladies existantes ou d'en ajouter de nouvelles à la collection. 
Enfin, la rédaction de cette documentation a été réalisée par l'ensemble de l'équipe afin de refléter fidèlement l'intégralité du projet.

### mettre ex code pour illustrer 

```javascript 
function...
``` 
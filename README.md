# Arround the corner

## Description

Ce projet est un site web qui permet aux utilisateurs de chercher et de réserver des bureaux dans des villes en France. Il utilise les frameworks Symfony et Angular pour la partie back-end et front-end, respectivement.

## Prérequis

- PHP (version 8.1.0 ou supérieure)
- Composer
- Node.js (version 14.40, 16.13 et 18.10 ou supérieure)
- npm
- MySQL 

## Installation

- Cloner le dépôt : git clone https://github.com/Nalvac/around-corner.git
- Installer les dépendances PHP : composer install
- Installer les dépendances Angular : npm install
- Configurer la base de données dans le fichier .env
- Créer la base de données : php bin/console doctrine:database:create
- Lancer les migrations : php bin/console doctrine:migrations:migrate
- Charger les données initiales : php bin/console doctrine:fixtures:load
- Compiler les assets : npm run build

## Utilisation

- Démarrer le serveur Symfony : symfony server:start
- Démarrer le serveur Angular : ng serve 
- Accéder au site dans un navigateur : http://localhost:4200

## Fonctionnalités

- Recherche de bureau par ville, date d'arrivée et date de départ
- Filtres de recherche (prix, nombre de place, type de bureau, etc.)
- Réservation d'un bureau
- Gestion des réservations pour l'administrateur du site

## Auteurs

Nadia Schwaller

### Autre membre de l'équipe

- Robin Coblentz
- Amine Fajry
- Nalvac Atinhounon
- Mohamed Djabi

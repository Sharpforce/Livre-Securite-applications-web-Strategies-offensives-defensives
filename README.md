# Livre Sécurité des Applications Web: Stratégies Offensives et Défensives

Bienvenue dans ce dépôt GitHub forké de l'application web inspirée du livre _"Sécurité des applications web : Stratégies offensives et défensives"_. Ce projet permet de déployer facilement l'application via Docker, offrant une alternative pratique à l'installation traditionnelle sur une machine virtuelle Kali Linux, pour expérimenter les concepts abordés dans le livre.

## Description

Cette application web reprend les mêmes exercices que ceux de l'application d'origine, mais elle est entièrement containerisée avec Docker. Cela facilite son installation et son exécution sur toute machine compatible avec Docker.

## Fonctionnalités

- Application web illustrant les exercices pratiques de sécurité offensive et défensive.
- Déploiement simplifié à l'aide de Docker et Docker Compose.
- Le répertoire _/exercices_ est monté pour faciliter la correction des exercices, y compris dans le conteneur de base de données, afin de permettre la réussite de l'exploitation de l'injection SQL de type "RCE".

## Pré-requis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Installation

1. Clonez ce dépôt sur votre machine locale :

```bash
git clone https://github.com/Sharpforce/Livre-Securite-applications-web-Strategies-offensives-defensives
cd Livre-Securite-applications-web-Strategies-offensives-defensives
```

2. Construisez et démarrez les conteneurs avec Docker Compose :

```bash
docker-compose up --build
```

3. L'application sera disponible à l'adresse suivante : http://localhost:8080/Livre-Securite-applications-web-Strategies-offensives-defensives/
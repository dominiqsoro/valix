# 🚀 Valix - Vente, Livraison et Expédition

## 📦 Description
Valix est une plateforme de vente en ligne intégrant un service de gestion de livraison automatisé. Elle permet aux entreprises et aux particuliers de vendre des produits et d’assurer leur expédition de manière simple et efficace.

## 🔥 Fonctionnalités

- 🛒 **Gestion des ventes** (produits, commandes, paiements)
- 🚚 **Gestion des livraisons** (colis, statut, prix, etc.)
- 👨‍✈️ **Attribution des colis aux livreurs**
- 📊 **Suivi des statuts des livraisons en temps réel**
- 📄 **Génération de rapports PDF des livraisons et ventes**
- 🎨 **Interface intuitive pour les administrateurs, vendeurs et livreurs**

## 🛠 Technologies utilisées

- **Back-end** : Laravel (PHP)
- **Front-end** : Blade, HTML, CSS, JavaScript
- **Base de données** : MySQL
- **Autres** : Bootstrap, jQuery, HTML2PDF

## 🚀 Installation

1. **Cloner le projet**

```bash
 git clone https://github.com/utilisateur/valix.git
```

2. **Accéder au dossier du projet**

```bash
 cd valix
```

3. **Installer les dépendances PHP**

```bash
 composer install
```

4. **Configurer l'environnement**

- Copier le fichier `.env.example` et le renommer en `.env`
- Configurer la connexion à la base de données

5. **Générer la clé de l'application**

```bash
 php artisan key:generate
```

6. **Exécuter les migrations et les seeders**

```bash
 php artisan migrate --seed
```

7. **Lancer le serveur**

```bash
 php artisan serve
```

## 🎯 Utilisation

- Accéder à l'interface via `http://127.0.0.1:8000`
- Se connecter avec un compte administrateur ou vendeur pour gérer les produits et les livraisons.
- Les livreurs peuvent voir leurs livraisons assignées.

## 📄 Génération de rapports PDF

Pour générer un rapport des livraisons :

- Accéder à la section "Rapports"
- Cliquer sur "Télécharger le PDF"
- Le fichier sera généré avec le nom `rapport_livraisons_NomClient_YYYY-MM-DD.pdf`

## 🤝 Contribuer

Les contributions sont les bienvenues !

1. Forker le projet 🍴
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature-nouvelle-fonction`)
3. Committer les changements (`git commit -m 'Ajout de nouvelle fonctionnalité'`)
4. Pousser sur la branche (`git push origin feature-nouvelle-fonction`)
5. Ouvrir une Pull Request 🚀

## 👤 Auteur

- **Nom du développeur** – [![GitHub](https://img.shields.io/badge/GitHub-000?logo=github&logoColor=white)](https://github.com/dominiqsoro)
- **LinkedIn** – [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?logo=linkedin&logoColor=white)](https://linkedin.com/in/dominiquesoro)
- **Twitter** – [![Twitter](https://img.shields.io/badge/Twitter-1DA1F2?logo=twitter&logoColor=white)](https://twitter.com/dominiqsoro)

## 📜 Licence

Ce projet est sous licence MIT.

💡 _Merci d'utiliser Valix !_ 🚀✨


TP LARAVEL : Gestion de projet avec Laravel où les utilisateurs peuvent créer des tâches et assigner des membres.

###Installation et Configuration

Suivez ces étapes pour cloner et exécuter le projet en local.

###Cloner le projet

Assurez-vous d'avoir **Git** installé, puis exécute la commande suivante :

git clone https://github.com/fulgence03/Laravel-Collab.git


###Installer les dépendances
Assurez-vous d'avoir PHP (>=8.1), Composer, et Node.js installés. Ensuite, exécutez:
composer install
npm install && npm run dev


###Configurer l'environnement
Copiez le fichier .env.example en .env.

Générez la clé d'application Laravel avec la commande:
php artisan key:generate

Configurez la base de données dans le fichier .env (exemple avec MySQL) :

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=collabo 
DB_USERNAME=root
DB_PASSWORD=

###Données
Importez ma base de données. Deux utilisateurs sont pré-enregistrés:
User1 (mail:user1@collab.net) et User2(mail:user2@collab.net) avec le même mot de passe : admin1234

###Lancer le serveur
Démarrez le serveur de développement Laravel :
php artisan serve

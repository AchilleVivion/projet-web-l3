# projet-web-l3

Ceci est notre projet de développement web de L3.

Nous devons développer une application qui permettra à des organisations d'organiser des évènements auxquels des personnes intéressés ou des membres de l'organisation pourront s'inscrirent.

Technologies utilisées :
  - Symfony
  - Bootstrap
  - Twig
  - Bundle Translation
  - MySQL
  - Doctrine

## Installation :

requis : 
* [composer 2](https://getcomposer.org/download/)
* mysql ```sudo apt install mysql-server```

Placez vous dans *projet-web-l3/projet/* et exécutez :

```composer dump```

```composer require symfony/dotenv```

Vérifiez que mysql est bien en train de fonctionner :
```service mysql status```

Si ce n'est pas le cas :
```service mysql start```

Ouvrez *projet-web-l3/projet/.env* et à la ligne 
```DATABASE_URL="mysql://user:password@127.0.0.1:3306/db?serverVersion=5.7"```, remplacez ```user``` par votre nom d'utilisateur mysql, ```password``` par votre mot de passe mysql et ```db``` par le nom que vous voulez donner à la base de données.

Puis exécutez : 

```php bin/console doctrine:database:create --if-not-exists```

```php bin/console doctrine:schema:update --force```

Enfin, lancez le serveur : ```php bin/console server:run```

Et voilà ! vous avez plus qu'à aller à l'url indiqué dans votre terminal et tester l'application après vous être enregistré dans la base de données.
  

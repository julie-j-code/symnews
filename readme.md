# Project Title

Symfony 5 révisions principalement pour l'utilisation de :

```
php bin/console make:user
php bin/console make:auth
```

Création d'un formulaire d'édition (FormType) + validation client et serveur

### Installing

A step by step series of examples that tell you how to get a development env running

Say what the step will be

```
Composer install
php bin/console d:d:c
php bin/console d:m:m
php bin/console d:f:l
```

### Additionnal plugins for information

What things you need to install the software and how to install them

```
composer require symfony/translation
composer require knplabs/knp-time-bundle
composer require --dev doctrine:orm-fixtures
composer require twig/string-extra
composer require apache-pack
```

## Deployment sur Heroku

Comme toujours : 
* ajouter le Procfile
* ajouter les scripts de compile dans le composer.json 
```
        "compile": [
            "php bin/console doctrine:migrations:migrate",
            "php bin/console doctrine:fixtures:load --no-interaction --env=PROD"
        ]
```

* ajouter dans require les dépendances de require-dev pour le chargement des fixtures
* autoriser dans le fichier bundles.php le chargement des fixtures quelque soit l'environnement

```
Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['all' => true]
```


J'ai ajouté les lignes suivantes pour permettre l'execution de d:m:m sur Heroku :

```
    public function isTransactional(): bool
    {
        return false;
    }
```


## Acknowledgments

* **Billie Thompson** - *Initial work*

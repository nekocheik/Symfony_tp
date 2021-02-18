# Symfony_tp

### spécificité du projet : 
le projet ne marché pas avec npm, nous avons alors utilisé yarn. 
le framwork css tailwind a était ajouté pour styliser le projet.
les exercise 1, 2 on été fait totalement mais l'exercie 3 n'a était était fait que partielment.

## Groupe 17

- Benzina Maeva
- Gordwin Alice
- Kone Cheik

### Install dependencies

```
composer i && yarn i
```

### Config your env

Check the .env file

### Setup your database

```
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

### Start Symfony

```
symfony server:start
```

### Start Webpack

```
npm run dev-server
```

## Schéma

![Schéma]()

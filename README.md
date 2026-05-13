# Guide pour lancer l'application TechMada

## 1.Générer la database:
Il faut lancer ces deux commandes dans la racine du dossier de l'application:
#### Pour créer les tables:
``` bash
php spark migrate 
```

#### Ensuite, pour inserer les données de test:
``` bash
php spark db:seed DatabaseSeeder
```

#### Après, lancer cette commande pour demarrer l'application:
``` bash
php spark serve
```
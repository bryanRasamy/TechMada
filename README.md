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

## 2.Connexion/login:
Pour se connecter à l'application, vous avez le choix de se connecter avec trois comptes de test:
- Administrateur:
    
    - email: admin@techmada.mg
    - mot de passe: `` admin123 ``


- Responsable RH:

    - email: rh@techmada.mg
    - mot de passe: `` rh123 ``


- Employé:

    - email: employe@techmada.mg
    - mot de passe: `` emp123 ``
    
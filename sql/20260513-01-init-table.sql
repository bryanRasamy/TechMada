CREATE TABLE departements(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT
);

CREATE TABLE types_conge(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL,
    jours_annuels INTEGER,
    deductible BLOB
);

CREATE TABLE employes(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL,
    departement_id INTEGER,
    date_embauche DATE,
    actif BLOB,

    FOREIGN KEY (departement_id) REFERENCES departements(id)
);

CREATE TABLE soldes(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER,
    type_conge_id INTEGER,
    annee INTEGER,
    jours_attribues INTEGER,
    jours_pris INTEGER,

    FOREIGN KEY (employe_id) REFERENCES employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id)
);

CREATE TABLE conges(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER,
    type_conge_id INTEGER,
    date_debut DATE,
    date_fin DATE,
    nb_jours INTEGER,
    motif TEXT,
    statut TEXT,
    commentaire_rh TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    traite_par INTEGER,

    FOREIGN KEY (employe_id) REFERENCES employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id),
    FOREIGN KEY (traite_par) REFERENCES employes(id)
);
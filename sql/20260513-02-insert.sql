INSERT INTO departements(nom,description) VALUES
('Informatique','Département chargé de la gestion des SI et du développement logiciel.'),
('Ressources Humaines','Département responsable de la gestion du personnel, du recrutement et des relations sociales.'),
('Production','Département responsable de la fabrication des produits, de la gestion des opérations et de la logistique.');

INSERT INTO types_conge(libelle,jours_annuels,deductible) VALUES
('Congé annuel',30,0),
('Congé maladie',20,1),
('Congé spécial',90,1);

INSERT INTO employes(nom,prenom,email,password,role,departement_id,date_embauche,actif) VALUES
('Raminiarisoa','Aina','aina@example.com','admin123','admin',1,'2023-01-15',1),
('Rakoto','Jean','jean@example.com','passwordrh123','rh',2,'2023-01-15',1),
('Rabe','Marie','marie@example.com','password456','employe',3,'2023-02-01',1),
('Andrianarivo','Paul','paul@example.com','password789','employe',3,'2023-03-01',1);

INSERT INTO soldes(employe_id,type_conge_id,annee,jours_attribues,jours_pris) VALUES
(1,1,2026,30,5),
(1,2,2026,20,2),
(1,3,2026,90,0),
(2,1,2026,30,10),
(2,2,2026,20,5),
(2,3,2026,90,0),
(3,1,2026,30,15),
(3,2,2026,20,0),
(3,3,2026,90,0),
(4,1,2026,30,0),
(4,2,2026,20,0),
(4,3,2026,90,0);

INSERT INTO conges(employe_id,type_conge_id,date_debut,date_fin,nb_jours,motif,statut) VALUES
(3,1,'2026-07-01','2026-07-15',10,'Vacances d\'été','en_attente'),
(3,2,'2026-08-05','2026-08-10',5,'Grippe','approuvée'),
(4,1,'2026-09-01','2026-09-30',20,'Voyage','en_attente');
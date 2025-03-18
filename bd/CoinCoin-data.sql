INSERT INTO `Client` (`email`, `nom`, `prenom`, `mot_de_passe`) VALUES 
('jambon@gmail.com', 'Jambon', 'Paul', password('allo')),
('AnneTremblay@gmail.com', 'Tremblay', 'Anne', password('bye')),
('BélandTorche@gmail.com', 'Torche', 'Béland', password('jambon')),
('BenoitJoe@gmail.com', 'Joe', 'Benoit', password('patate'));

INSERT INTO `Projet` (`nom`, `but_epargne`, `client_id`) VALUES
('Télévision', 600, 1),
('Motoneige', 2000, 1),
('Ordinateur portable', 1000, 2),
('Saxophone', 2000, 2),
('Trotinette électrique', 500, 3);

INSERT INTO `Budget` (`depenses_total`, `revenus_total`, `date_debut`, `date_fin`, `projet_id`) VALUES
(70, 100, '2025-03-14', '2025-04-02', 1),
(40, 200, '2025-03-10', '2025-04-08', 2),
(50, 125, '2025-03-12', '2025-04-21', 3),
(90, 130, '2025-03-11', '2025-05-12', 5);

INSERT INTO `Depense` (`nom`, `montant`, `budget_id`) VALUES
("épicerie", 100, 1),
("Abonnement Netflix", 14, 1),
("Téléphone", 30, 2),
("Assurance", 200, 2),
("Transport", 80, 3),
("Chauffage", 120, 3);

INSERT INTO `Revenu` (`nom`, `montant`, `budget_id`) VALUES
("Hôpital", 400, 1),
("Cryptomonnaie", 2000, 2),
("Professeur", 300, 3),
("Orchestre", 250, 4);

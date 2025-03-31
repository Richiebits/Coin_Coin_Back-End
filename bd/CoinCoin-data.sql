INSERT INTO `Client` (`email`, `nom`, `prenom`, `mot_de_passe`) VALUES 
('jambon@gmail.com', 'Jambon', 'Paul', password('12345678')),
('AnneTremblay@gmail.com', 'Tremblay', 'Anne', password('12345678')),
('BélandTorche@gmail.com', 'Torche', 'Béland', password('12345678')),
('BenoitJoe@gmail.com', 'Joe', 'Benoit', password('12345678'));

INSERT INTO `Projet` (`nom`, `but_epargne`, `client_id`) VALUES
('Télévision', 600, 1),
('Motoneige', 2000, 1),
('Ordinateur portable', 1000, 2),
('Saxophone', 2000, 2),
('Trotinette électrique', 500, 3);

INSERT INTO `Budget` (`retraits_total`, `depots_total`, `date_debut`, `date_fin`, `projet_id`) VALUES
(70, 100, '2025-03-14', '2025-04-02', 1),
(40, 200, '2025-03-10', '2025-04-08', 2),
(50, 125, '2025-03-12', '2025-04-21', 3),
(40, 250, '2025-03-30', '2025-06-21', 4),
(90, 130, '2025-03-11', '2025-05-12', 5);

INSERT INTO `Retrait` (`nom`, `montant`, `retrait_recurrence` , `budget_id`) VALUES
("épicerie", 100, 14 , 1),
("Abonnement Netflix", 14, 7, 1),
("Téléphone", 30, 30, 2),
("Assurance", 200, 365, 2),
("Transport", 80, 14, 3),
("Chauffage", 120, 30, 3);

INSERT INTO `Depot` (`nom`, `montant`, `depot_recurrence` , `budget_id`) VALUES
("Hôpital", 400, 14, 1),
("Cryptomonnaie", 2000, 7, 2),
("Professeur", 300, 365, 3),
("Orchestre", 250, 30, 4);

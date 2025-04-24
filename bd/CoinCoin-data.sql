INSERT INTO `Client` (`email`, `nom`, `prenom`, `mot_de_passe`, `is_admin`) VALUES 
('jambon@gmail.com', 'Jambon', 'Paul', password('12345678'), false),
('AnneTremblay@gmail.com', 'Tremblay', 'Anne', password('12345678'), false),
('BelandTorche@gmail.com', 'Torche', 'Béland', password('12345678'), false),
('BenoitJoe@gmail.com', 'Joe', 'Benoit', password('12345678'), false),
('admin@coincoin.ca', '1', 'Admin', password('admin123!'), true);

INSERT INTO `Projet` (`nom`, `but_epargne`, `client_id`) VALUES
('Télévision', 700, 1),
('Motoneige', 2000, 1),
('Ordinateur portable', 1000, 2),
('Saxophone', 2000, 2),
('Trotinette électrique', 500, 3);

INSERT INTO `Budget` (`retraits_total`, `depots_total`, `date_debut`, `date_fin`, `projet_id`) VALUES
(70, 100, '2025-04-10', '2025-05-31', 1),
(40, 200, '2025-03-10', '2025-04-08', 2),
(50, 125, '2025-03-12', '2025-04-21', 3),
(40, 250, '2025-03-30', '2025-06-21', 4),
(90, 130, '2025-03-11', '2025-05-12', 5);

INSERT INTO `Retrait` (`nom`, `montant`, `retrait_recurrence` , `budget_id`) VALUES
("épicerie", 100, 14 , 1),
("Abonnement Netflix", 14, 7, 2),
("Téléphone", 30, 14, 3),
("Assurance", 200, 30, 4),
("Transport", 80, 14, 4),
("Chauffage", 120, 30, 5);

INSERT INTO `Depot` (`nom`, `montant`, `depot_recurrence` , `budget_id`) VALUES
("Hôpital", 400, 14, 1),
("Cryptomonnaie", 2000, 7, 2),
("Professeur", 150, 7, 3),
("Orchestre", 200, 7, 4),
("Gouvernement", 150, 14, 5);

INSERT INTO `Historique` (`projet_id`, `client_id`, `date_histo`, `type`, `montant`, `recurrence`) VALUES
(1, 1, '2025-03-15', 'depot', 400, 0),
(2, 1, '2025-04-10', 'retrait', 2000, 0),
(3, 2, '2025-03-25', 'depot', 150, 7),
(4, 2, '2025-04-13', 'depot', 1000, 0),
(5, 3, '2025-04-01', 'retrait', 150, 14);


INSERT INTO `Client` (`email`, `nom`, `prenom`, `mot_de_passe`) VALUES 
('jambon@gmail.com', 'Jambon', 'Paul', '12345678'),
('AnneTremblay@gmail.com', 'Tremblay', 'Anne', '12345678'),
('BélandTorche@gmail.com', 'Torche', 'Béland', '12345678'),
('BenoitJoe@gmail.com', 'Joe', 'Benoit', '12345678');

INSERT INTO `Projet` (`nom`, `but_epargne`, `client_id`) VALUES
('Télévision', 600, 1),
('Motoneige', 2000, 1),
('Ordinateur portable', 1000, 2),
('Saxophone', 2000, 2),
('Trotinette électrique', 500, 3);
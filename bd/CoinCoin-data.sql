INSERT INTO `Client` (`email`, `nom`, `prenom`, `mot_de_passe`) VALUES 
('jambon@gmail.com', 'Jambon', 'Paul', '12345678'),
('AnneTremblay@gmail.com', 'Tremblay', 'Anne', '12345678'),
('BenoitJoe@gmail.com', 'Joe', 'Benoit', '12345678');

INSERT INTO `Projet` (`nom`, `but_epargne`, `Clientid`) VALUES
('Télévision', 600, 'jambon@gmail.com'),
('Motoneige', 2000, 'jambon@gmail.com'),
('Ordinateur portable', 1000, 'AnneTremblay@gmail.com')
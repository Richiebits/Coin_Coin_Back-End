-- SCRIPT DE CREATION DU MODELE PHYSIQUE DE DONNEES
-- AUTEUR : [VOTRE NOM]

-- --------------------------------------------
-- -- Création de la table Client
-- --------------------------------------------
CREATE TABLE Client (
    id            INT(10)        UNIQUE NOT NULL AUTO_INCREMENT,
    email         VARCHAR(255)   UNIQUE NOT NULL,
    nom           VARCHAR(255)   NOT NULL,
    prenom        VARCHAR(255)   NOT NULL,
    tel           VARCHAR(255)   NULL,
    mot_de_passe  VARCHAR(255)   NOT NULL,
    is_admin      BOOLEAN        NOT NULL DEFAULT FALSE,
    
    CONSTRAINT PK_Client PRIMARY KEY (id)
);

-- --------------------------------------------
-- -- Création de la table Projet
-- --------------------------------------------
CREATE TABLE Projet (
    id            INT(10)         NOT NULL AUTO_INCREMENT,
    nom           VARCHAR(255)    NOT NULL,
    but_epargne   INT(10)         NOT NULL,
    client_id     INT(10)         NOT NULL,
    date_creation DATE            DEFAULT CURDATE(),
    
    CONSTRAINT PK_Projet PRIMARY KEY (id),
    CONSTRAINT FK_Projet_Client FOREIGN KEY (client_id) REFERENCES Client(id) ON DELETE CASCADE
);

-- --------------------------------------------
-- -- Création de la table Budget
-- --------------------------------------------
CREATE TABLE Budget (
    id              INT(10)    NOT NULL AUTO_INCREMENT,
    retraits_total   INT(10)    NULL,
    depots_total    INT(10)    NULL,
    date_debut      DATE       DEFAULT CURDATE(),
    date_fin        DATE       NULL,
    projet_id       INT(10)    NOT NULL,
    
    CONSTRAINT PK_Budget PRIMARY KEY (id),
    CONSTRAINT FK_Budget_Projet FOREIGN KEY (projet_id) REFERENCES Projet(id) ON DELETE CASCADE
);

-- --------------------------------------------
-- -- Création de la table Depot
-- --------------------------------------------
CREATE TABLE Depot (
    id_depot  INT(10)   NOT NULL AUTO_INCREMENT,
    nom        VARCHAR(255)  NULL,
    montant    INT(10)   NOT NULL,
    depot_recurrence   INT(10)   NOT NULL,
    budget_id  INT(10)   NOT NULL,
    
    CONSTRAINT PK_Depot PRIMARY KEY (id_Depot),
    CONSTRAINT FK_Depot_Budget FOREIGN KEY (budget_id) REFERENCES Budget(id) ON DELETE CASCADE
);

-- --------------------------------------------
-- -- Création de la table Retrait
-- --------------------------------------------
CREATE TABLE Retrait (
    id_retrait  INT(10)   NOT NULL AUTO_INCREMENT,
    nom         VARCHAR(255)  NULL,
    montant     INT(10)    NOT NULL,
    retrait_recurrence INT(10)  NOT NULL,
    budget_id   INT(10)   NOT NULL,
    
    CONSTRAINT PK_Retrait PRIMARY KEY (id_retrait),
    CONSTRAINT FK_Retrait_Budget FOREIGN KEY (budget_id) REFERENCES Budget(id) ON DELETE CASCADE
);

-- --------------------------------------------
-- -- Création de la table Historique
-- --------------------------------------------
CREATE TABLE Historique (
    id         INT(10)   NOT NULL AUTO_INCREMENT,
    projet_id  INT(10)   NOT NULL,
    client_id INT(10)   NOT NULL,
    date_histo DATE          NOT NULL,
    type        ENUM('depot', 'retrait') NOT NULL,
    montant    INT(10)   NOT NULL,
    
    CONSTRAINT PK_Historique PRIMARY KEY (id),
    CONSTRAINT FK_Historique_Projet FOREIGN KEY (projet_id) REFERENCES Projet(id) ON DELETE CASCADE,
    CONSTRAINT FK_Client_id FOREIGN KEY (client_id) REFERENCES Client(id) ON DELETE CASCADE
);
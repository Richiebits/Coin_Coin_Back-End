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
    depenses_total  INT(10)    NULL,
    revenus_total   INT(10)    NULL,
    date_debut      DATE       NULL,
    date_fin        DATE       NULL,
    projet_id       INT(10)    NOT NULL,
    
    CONSTRAINT PK_Budget PRIMARY KEY (id),
    CONSTRAINT FK_Budget_Projet FOREIGN KEY (projet_id) REFERENCES Projet(id) ON DELETE CASCADE
);

-- --------------------------------------------
-- -- Création de la table Revenu
-- --------------------------------------------
CREATE TABLE Revenu (
    id_revenu  INT(10)   NOT NULL AUTO_INCREMENT,
    nom        VARCHAR(255)  NOT NULL,
    montant    INT(10)    NOT NULL,
    budget_id  INT(10)   NOT NULL,
    
    CONSTRAINT PK_Revenu PRIMARY KEY (id_revenu),
    CONSTRAINT FK_Revenu_Budget FOREIGN KEY (budget_id) REFERENCES Budget(id) ON DELETE CASCADE
);

-- --------------------------------------------
-- -- Création de la table Depense
-- --------------------------------------------
CREATE TABLE Depense (
    id_depense  INT(10)   NOT NULL AUTO_INCREMENT,
    nom         VARCHAR(255)  NOT NULL,
    montant     INT(10)    NOT NULL,
    budget_id   INT(10)   NOT NULL,
    
    CONSTRAINT PK_Depense PRIMARY KEY (id_depense),
    CONSTRAINT FK_Depense_Budget FOREIGN KEY (budget_id) REFERENCES Budget(id) ON DELETE CASCADE
);

-- --------------------------------------------
-- -- Création de la table Historique
-- --------------------------------------------
CREATE TABLE Historique (
    id         INT(10)   NOT NULL AUTO_INCREMENT,
    projet_id  INT(10)   NOT NULL,
    date_histo DATE          NOT NULL,
    type       VARCHAR(255)  NOT NULL,
    montant    INT(10)   NULL,
    
    CONSTRAINT PK_Historique PRIMARY KEY (id),
    CONSTRAINT FK_Historique_Projet FOREIGN KEY (projet_id) REFERENCES Projet(id) ON DELETE CASCADE
);
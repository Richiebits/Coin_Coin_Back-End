-- SCRIPT DE CREATION DU MODELE PHYSIQUE DE DONNEES
-- AUTEUR : [VOTRE NOM]

DROP TABLE Historique CASCADE CONSTRAINTS;
DROP TABLE Revenu CASCADE CONSTRAINTS;
DROP TABLE Depense CASCADE CONSTRAINTS;
DROP TABLE Budget CASCADE CONSTRAINTS;
DROP TABLE Projet CASCADE CONSTRAINTS;
DROP TABLE Client CASCADE CONSTRAINTS;

----------------------------------------------
---- Création de la table Client
----------------------------------------------
CREATE TABLE Client (
    id            INTEGER(10)    NOT NULL,
    nom           VARCHAR(255)   NOT NULL,
    prenom        VARCHAR(255)   NOT NULL,
    tel           VARCHAR(255)   NULL,
    email         VARCHAR(255)   NOT NULL,
    mot_de_passe  VARCHAR(255)   NOT NULL,
    
    CONSTRAINT PK_Client PRIMARY KEY (id)
);

----------------------------------------------
---- Création de la table Projet
----------------------------------------------
CREATE TABLE Projet (
    id          INTEGER(10)    NOT NULL,
    nom         VARCHAR(255)   NOT NULL,
    but_epargne INTEGER(10)    NOT NULL,
    Clientid    INTEGER(10)    NOT NULL,
    
    CONSTRAINT PK_Projet PRIMARY KEY (id),
    CONSTRAINT FK_Projet_Client FOREIGN KEY (Clientid) REFERENCES Client(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Budget
----------------------------------------------
CREATE TABLE Budget (
    id              INTEGER(10)    NOT NULL,
    nom             VARCHAR(255)   NOT NULL,
    depenses_total  INTEGER(10)    NOT NULL,
    revenus_total   INTEGER(10)    NOT NULL,
    date_debut      DATE           NOT NULL,
    date_fin        DATE           NOT NULL,
    Projetid        INTEGER(10)    NOT NULL,
    
    CONSTRAINT PK_Budget PRIMARY KEY (id),
    CONSTRAINT FK_Budget_Projet FOREIGN KEY (Projetid) REFERENCES Projet(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Revenu
----------------------------------------------
CREATE TABLE Revenu (
    id_revenu  INTEGER(10)   NOT NULL,
    nom        VARCHAR(255)  NOT NULL,
    montant    DOUBLE(10)    NOT NULL,
    Budgetid   INTEGER(10)   NOT NULL,
    
    CONSTRAINT PK_Revenu PRIMARY KEY (id_revenu),
    CONSTRAINT FK_Revenu_Budget FOREIGN KEY (Budgetid) REFERENCES Budget(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Depense
----------------------------------------------
CREATE TABLE Depense (
    id_depense  INTEGER(10)   NOT NULL,
    nom         VARCHAR(255)  NOT NULL,
    montant     DOUBLE(10)    NOT NULL,
    Budgetid    INTEGER(10)   NOT NULL,
    
    CONSTRAINT PK_Depense PRIMARY KEY (id_depense),
    CONSTRAINT FK_Depense_Budget FOREIGN KEY (Budgetid) REFERENCES Budget(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Historique
----------------------------------------------
CREATE TABLE Historique (
    id         INTEGER(10)   NOT NULL,
    Projetid   INTEGER(10)   NOT NULL,
    date       DATE          NOT NULL,
    type       VARCHAR(255)  NOT NULL,
    montant    INTEGER(10)   NULL,
    
    CONSTRAINT PK_Historique PRIMARY KEY (id),
    CONSTRAINT FK_Historique_Projet FOREIGN KEY (Projetid) REFERENCES Projet(id) ON DELETE CASCADE
);

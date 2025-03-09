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
    id            NUMBER(10)    NOT NULL,
    nom           VARCHAR2(255)   NOT NULL,
    prenom        VARCHAR2(255)   NOT NULL,
    tel           VARCHAR2(255)   NULL,
    email         VARCHAR2(255)   NOT NULL,
    mot_de_passe  VARCHAR2(255)   NOT NULL,
    
    CONSTRAINT PK_Client PRIMARY KEY (id)
);

----------------------------------------------
---- Création de la table Projet
----------------------------------------------
CREATE TABLE Projet (
    id          NUMBER(10)    NOT NULL,
    nom         VARCHAR2(255)   NOT NULL,
    but_epargne NUMBER(10)    NOT NULL,
    Clientid    NUMBER(10)    NOT NULL,
    
    CONSTRAINT PK_Projet PRIMARY KEY (id),
    CONSTRAINT FK_Projet_Client FOREIGN KEY (Clientid) REFERENCES Client(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Budget
----------------------------------------------
CREATE TABLE Budget (
    id              NUMBER(10)    NOT NULL,
    nom             VARCHAR2(255)   NOT NULL,
    depenses_total  NUMBER(10)    NOT NULL,
    revenus_total   NUMBER(10)    NOT NULL,
    date_debut      DATE           NOT NULL,
    date_fin        DATE           NOT NULL,
    Projetid        NUMBER(10)    NOT NULL,
    
    CONSTRAINT PK_Budget PRIMARY KEY (id),
    CONSTRAINT FK_Budget_Projet FOREIGN KEY (Projetid) REFERENCES Projet(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Revenu
----------------------------------------------
CREATE TABLE Revenu (
    id_revenu  NUMBER(10)   NOT NULL,
    nom        VARCHAR2(255)  NOT NULL,
    montant    NUMBER(10)    NOT NULL,
    Budgetid   NUMBER(10)   NOT NULL,
    
    CONSTRAINT PK_Revenu PRIMARY KEY (id_revenu),
    CONSTRAINT FK_Revenu_Budget FOREIGN KEY (Budgetid) REFERENCES Budget(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Depense
----------------------------------------------
CREATE TABLE Depense (
    id_depense  NUMBER(10)   NOT NULL,
    nom         VARCHAR2(255)  NOT NULL,
    montant     NUMBER(10)    NOT NULL,
    Budgetid    NUMBER(10)   NOT NULL,
    
    CONSTRAINT PK_Depense PRIMARY KEY (id_depense),
    CONSTRAINT FK_Depense_Budget FOREIGN KEY (Budgetid) REFERENCES Budget(id) ON DELETE CASCADE
);

----------------------------------------------
---- Création de la table Historique
----------------------------------------------
CREATE TABLE Historique (
    id         NUMBER(10)   NOT NULL,
    Projetid   NUMBER(10)   NOT NULL,
    date_histo DATE          NOT NULL,
    type       VARCHAR2(255)  NOT NULL,
    montant    NUMBER(10)   NULL,
    
    CONSTRAINT PK_Historique PRIMARY KEY (id),
    CONSTRAINT FK_Historique_Projet FOREIGN KEY (Projetid) REFERENCES Projet(id) ON DELETE CASCADE
);
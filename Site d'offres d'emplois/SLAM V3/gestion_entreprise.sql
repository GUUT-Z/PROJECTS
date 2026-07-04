CREATE DATABASE IF NOT EXISTS Gei_AP;
USE Gei_AP;

CREATE TABLE Entreprises(
    id_entreprise INT PRIMARY KEY AUTO_INCREMENT,
    Nom VARCHAR(100) NOT NULL UNIQUE,
    Adresse VARCHAR(100) NOT NULL,
    CP_Entreprise CHAR(5) NOT NULL,
    Region VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Tel VARCHAR(10) NOT NULL,
    Secteur VARCHAR(50) NOT NULL
);

CREATE TABLE Chef_entreprise(
    id_chef INT PRIMARY KEY AUTO_INCREMENT,
    id_entreprise INT NOT NULL UNIQUE,
    Nom VARCHAR(100) NOT NULL,
    Prenom VARCHAR(100) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Tel VARCHAR(10) NOT NULL,
    FOREIGN KEY(id_entreprise) REFERENCES Entreprises(id_entreprise)
);


INSERT INTO Entreprises(id_entreprise,Nom, Adresse, CP_Entreprise,Region, Email, Tel, Secteur) 
VALUES
(1,'KONECTA', '123 Rue de la Gare', '59000','Hauts-de-France', 'contact@konecta.fr', '0320123456', 'Services'),
(2,'SAPMER', '456 Avenue de la Mer', '75001', 'Occitanie','info@sapmer.fr', '0145678910', 'Pêche'),
(3,'MYCOPHYTO', '789 Boulevard de la Science', '69001','Île-de-France', 'hello@mycophyto.fr', '0478901234', 'Biotechnologie'),
(4,'TechNord', '321 Rue de l''Innovation', '59300','Hauts-de-France', 'tech@technord.fr', '0321234567', 'Informatique'),
(5,'Agri Solutions', '654 Chemin Rural', '62000','Bretagne', 'contact@agri.fr', '0362345678', 'Agriculture'),
(6,'DataCorp', '111 Avenue Digitale', '75002','Bretagne', 'info@datacorp.fr', '0147895623', 'Data Science'),
(7,'EnerGreen', '222 Rue Verte', '92000','Île-de-France', 'contact@energreen.fr', '0149876543', 'Énergie'),
(8,'TransLogic', '333 Boulevard Commerce', '93000','Hauts-de-France', 'logistics@translogic.fr', '0148765432', 'Transport'),
(9,'DesignHub', '444 Impasse Créative', '94000','Bretagne', 'design@designhub.fr', '0145987654', 'Design'),
(10,'PharmaPlus', '555 Rue de la Santé', '38000','hauts-de-France', 'pharma@pharmaplus.fr', '0476543210', 'Pharmaceutique');

INSERT INTO Chef_entreprise(id_entreprise, Nom, Prenom, Email, Tel)
VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@konecta.fr', '0320111111'),
(2, 'Martin', 'Marie', 'marie.martin@sapmer.fr', '0145222222'),
(3, 'Bernard', 'Pierre', 'pierre.bernard@mycophyto.fr', '0478333333'),
(4, 'Leblanc', 'Claire', 'claire.leblanc@technord.fr', '0321444444'),
(5, 'Dubois', 'Luc', 'luc.dubois@agri.fr', '0362555555'),
(6, 'Laurent', 'Anne', 'anne.laurent@datacorp.fr', '0147666666'),
(7, 'Petit', 'Michel', 'michel.petit@energreen.fr', '0149777777'),
(8, 'Moreau', 'Sophie', 'sophie.moreau@translogic.fr', '0148888888');
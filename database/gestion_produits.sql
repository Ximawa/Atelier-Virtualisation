-- PostgreSQL version 13


-- Connect to the database
\c gestion_produits;

-- Table structure for table `produits`
DROP TABLE IF EXISTS produits;
CREATE TABLE produits (
  PRO_id SERIAL PRIMARY KEY,
  PRO_lib varchar(200) NOT NULL,
  PRO_prix numeric(10,2) NOT NULL,
  PRO_description text
);

-- Dumping data for table `produits`
INSERT INTO produits (PRO_id, PRO_lib, PRO_prix, PRO_description) VALUES 
(1,'Pédales Shimano XT M8040 M/L',74.99,'Les pédales plates SHIMANO XT PD-M8040 sont destinées à un usage All Mountain/Enduro. Très solides grâce à leur axe en acier chromoly, elles se caractérisent notamment par leur plateforme concave, qui accueille 10 picots dévissables, qui favorisent le grip sous la semelle. Leur structure est également plus ouverte et dégagée, qui empêche la boue de saccumuler'),
(2,'Selle FIZIK ARIONE VERSUS Rails Kium',59.99,'Modèle confortable avant tout, la selle FIZIK Arione Versus possède un profil tout à fait plat et très long (300 mm) qui convient aux pratiquants justifiant dune excellente souplesse vertébrale. Sa surface présente un canal central évidé, caractéristique des selles de la ligne Versus, qui permet de réduire les points de pression sur la zone périnéale.'),
(3,'Chaussures VTT MAVIC CROSSMAX SL PRO THERMO Noir',164.99,'Les chaussures Cross Max SL Pro Thermo créées par la marque MAVIC plairont aux riders voulant profiter de leur vélo en hiver ! Elles offrent une protection optimale contre le froid et contre la pluie.'),
(4,'Pack GPS GARMIN EDGE 1030 + Ceinture Cardio',519.99,'Le Pack GPS Edge 1030 plus la ceinture cardio de Garmin est fait pour les compétiteurs et les adeptes de performances. Cette offre ravira les cyclistes souhaitant sentraîner efficacement pour la saison !'),
(5,'Fourche DVO SAPPHIRE 29',549.99,'Dérivée de la Diamond, la fourche DVO Sapphire 29 marque lentrée de la marque californienne dans le segment des fourches Trail / All Mountain.');

-- Table structure for table `ressources`
DROP TABLE IF EXISTS ressources;
CREATE TABLE ressources (
  RE_id SERIAL PRIMARY KEY,
  RE_type varchar(100) NOT NULL,
  RE_url varchar(1000) NOT NULL,
  RE_nom varchar(100),
  PRO_id int NOT NULL,
  CONSTRAINT ressources_produits_FK FOREIGN KEY (PRO_id) REFERENCES produits (PRO_id)
);

-- Dumping data for table `ressources`
INSERT INTO ressources (RE_id, RE_type, RE_url, RE_nom, PRO_id) VALUES 
(40,'img','uploads/3-ad201839b2ed3d2e4dae6c4f60c4b351.jpg',NULL,3),
(41,'img','uploads/3-7e147d9390a77334782851729ed8384f.jpg',NULL,3),
(42,'img','uploads/3-82fde3218e6f64fa94e8139fe80f7917.jpg',NULL,3),
(43,'img','uploads/5-19b235d023eef2281304433f0d4438b6.jpg',NULL,5),
(44,'img','uploads/5-b02cbdbc96d5c9a20526763576f56a11.jpg',NULL,5),
(45,'img','uploads/5-8e258524bf0f2aae28647a1aa8a77a8c.jpg',NULL,5),
(46,'img','uploads/4-a21d716bdfda2004d50171559c4b1b92.jpg',NULL,4),
(47,'img','uploads/4-1cb57a6c1de5c2573679654054a2b3b0.jpg',NULL,4),
(48,'img','uploads/4-438b7f4eec56d20aca694793882909ac.jpg',NULL,4),
(49,'img','uploads/1-707116622e5d4fe50dfc6391af4a5421.jpg',NULL,1),
(50,'img','uploads/1-7f8aacccd9c522281c58e5eb90cbb6a8.jpg',NULL,1),
(51,'img','uploads/1-987e17d65fb62e5fece343304d7be827.jpg',NULL,1),
(52,'img','uploads/2-e2b9f326909fe34dc9f73e515d0e5633.jpg',NULL,2),
(53,'img','uploads/2-5dfd065b9d05455732d122cdc3b64e27.jpg',NULL,2),
(54,'img','uploads/2-7e38160b643cf0e21ff445c9594e77d7.jpg',NULL,2),
(55,'img','uploads/2-2228cc7d3b9f647bfa31dd4ebf0f3885.jpg',NULL,2);

-- Table structure for table `utilisateurs`
DROP TABLE IF EXISTS utilisateurs;
CREATE TABLE utilisateurs (
  US_id SERIAL PRIMARY KEY,
  US_login varchar(100) NOT NULL,
  US_password varchar(100) NOT NULL
);

-- Dumping data for table `utilisateurs`
INSERT INTO utilisateurs (US_id, US_login, US_password) VALUES 
(1,'admin','5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8');

SELECT setval(pg_get_serial_sequence('produits', 'pro_id'), (SELECT MAX(pro_id) FROM produits) + 1);

SELECT setval(pg_get_serial_sequence('ressources', 're_id'), (SELECT MAX(re_id) FROM ressources) + 1);
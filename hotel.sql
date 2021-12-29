CREATE TABLE client(
    no_client SERIAL PRIMARY KEY,
    nom_client VARCHAR(50) NOT NULL,
    prenom_client VARCHAR(50) NOT NULL,
    date_naissance_client DATE NOT NULL,
    tel_client VARCHAR(10) NOT NULL,
    mail_client VARCHAR(50) UNIQUE,
    adresse_client VARCHAR(100) NOT NULL,
    mdp_client VARCHAR(32) NOT NULL
);

CREATE TABLE activite(
    no_activite INT PRIMARY KEY,
    nom_activite VARCHAR(20) NOT NULL,
    type_activite VARCHAR(20) NOT NULL,
    prix_activite FLOAT NOT NULL
);

CREATE TABLE hotel(
    no_hotel INT PRIMARY KEY,
    nom_hotel VARCHAR(100) NOT NULL,
    adresse_hotel  VARCHAR(200) NOT NULL, 
    tel_hotel VARCHAR(10) NOT NULL,
    classement_hotel VARCHAR(10) NOT NULL,
    courriel_hotel VARCHAR(100) NOT NULL,
    site_internet_hotel VARCHAR(200) NULL
); 

CREATE TABLE activite_hotel(
    no_hotel INT,
    no_activite INT,

    CONSTRAINT fk_hotel
    FOREIGN KEY(no_hotel)
    REFERENCES hotel(no_hotel),

    CONSTRAINT fk_activite
    FOREIGN KEY(no_activite)
    REFERENCES activite(no_activite)
); 

CREATE TABLE chambre(
    id_chambre INT PRIMARY KEY, 
    no_chambre INT NOT NULL,
    etage_chambre INT NOT NULL, 
    type_chambre VARCHAR(20)   NOT NULL, 
    capacite_chambre INT CHECK(capacite_chambre <= 4), 
    prix_chambre FLOAT NOT NULL, 
    no_hotel INT,

    CONSTRAINT fk_hotel
    FOREIGN KEY(no_hotel)
    REFERENCES hotel(no_hotel)
);

CREATE TABLE reservation(
    no_reservation SERIAL PRIMARY KEY,
    petit_dejeuner BOOLEAN NOT NULL DEFAULT FALSE, 
    spa BOOLEAN NOT NULL DEFAULT FALSE, 
    date_reservation DATE NOT NULL DEFAULT CURRENT_DATE, 
    date_arrivee_reservation DATE NOT NULL CHECK(date_arrivee_reservation >= CURRENT_DATE), 
    date_depart_reservation DATE NOT NULL CHECK(date_depart_reservation >= date_arrivee_reservation),
    prix INT NOT NULL,
    no_client INT,

    CONSTRAINT fk_client
    FOREIGN KEY(no_client)
    REFERENCES client(no_client)
);

CREATE TABLE reservation_chambre(
    no_reservation SERIAL, 
    id_chambre INT,

    CONSTRAINT fk_reservation
    FOREIGN KEY(no_reservation)
    REFERENCES reservation(no_reservation),

    CONSTRAINT fk_chambre
    FOREIGN KEY(id_chambre)
    REFERENCES chambre(id_chambre)
); 

CREATE TABLE activite_client( 
    no_client INT, 
    no_activite INT,
    no_reservation SERIAL,

    CONSTRAINT fk_client 
    FOREIGN KEY(no_client)
    REFERENCES client(no_client),

    CONSTRAINT fk_activite 
    FOREIGN KEY(no_activite)
    REFERENCES activite(no_activite),

    CONSTRAINT fk_reservation 
    FOREIGN KEY(no_reservation)
    REFERENCES reservation(no_reservation)
);

CREATE TABLE indisponibilite_chambre (
    id_chambre INT,
    date_arrivee_indispo DATE NOT NULL,
    date_depart_indispo DATE NOT NULL,

    CONSTRAINT fk_chambre
    FOREIGN KEY(id_chambre)
    REFERENCES chambre(id_chambre)
);

DROP TABLE client, activite, activite_client, hotel, activite_hotel, chambre, reservation, reservation_chambre, indisponibilite, indisponibilite_chambre;
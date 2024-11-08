#------------------------------------------------------------
# Table: GJ_roles
#------------------------------------------------------------

CREATE TABLE GJ_roles (
    code CHAR(1) NOT NULL,
    label VARCHAR(30) NOT NULL,
    CONSTRAINT GJ_roles_PK PRIMARY KEY (code)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_users
#------------------------------------------------------------

CREATE TABLE GJ_users (
    id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    telephone VARCHAR(20) NULL,
    visibilite BOOLEAN DEFAULT TRUE NOT NULL,
    can_contribute BOOLEAN DEFAULT TRUE NOT NULL,
    code CHAR(1) DEFAULT 'U' NOT NULL,
    comment VARCHAR(250) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT GJ_users_PK PRIMARY KEY (id),
    CONSTRAINT GJ_users_GJ_roles_FK FOREIGN KEY (code) REFERENCES GJ_roles(code)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_supports
#------------------------------------------------------------

CREATE TABLE GJ_supports (
    id INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(70) NOT NULL,
    description VARCHAR(50),
    date_sortie YEAR(4) NOT NULL,

    CONSTRAINT GJ_supports_PK PRIMARY KEY (id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_jeux
#------------------------------------------------------------

CREATE TABLE GJ_jeux (
    id INT AUTO_INCREMENT NOT NULL,
    titre VARCHAR(70) NOT NULL,
    description VARCHAR(300) NOT NULL,
    date_sortie YEAR(4) NOT NULL,
    fichier_couverture VARCHAR(300) NOT NULL,
    possede_par INT DEFAULT 0 NOT NULL,
    moyenne INT,
    id_GJ_SUPPORTS INT NOT NULL,

    CONSTRAINT GJ_jeux_PK PRIMARY KEY (id),
    CONSTRAINT GJ_jeux_GJ_supports_FK FOREIGN KEY (id_GJ_SUPPORTS) REFERENCES GJ_supports(id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_genres
#------------------------------------------------------------

CREATE TABLE GJ_genres (
    id INT AUTO_INCREMENT NOT NULL,
    label VARCHAR(300) NOT NULL,

    CONSTRAINT GJ_genres_PK PRIMARY KEY (id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_statut
#------------------------------------------------------------

CREATE TABLE GJ_statut (
    id INT AUTO_INCREMENT NOT NULL,
    label VARCHAR(30) NOT NULL,

    CONSTRAINT GJ_statut_PK PRIMARY KEY (id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_requetes
#------------------------------------------------------------

CREATE TABLE GJ_requetes (
    id INT AUTO_INCREMENT NOT NULL,
    motif VARCHAR(300),
    titre VARCHAR(70) NOT NULL,
    description VARCHAR(500) NOT NULL,
    date_sortie YEAR(4) NOT NULL,
    fichier_couverture VARCHAR(300) NOT NULL,
    id_GJ_USERS BIGINT UNSIGNED NOT NULL,
    id_GJ_STATUT INT NOT NULL,
    id_GJ_USERS_VALIDE BIGINT UNSIGNED,

    CONSTRAINT GJ_requetes_PK PRIMARY KEY (id),
    CONSTRAINT GJ_requetes_GJ_users_FK FOREIGN KEY (id_GJ_USERS) REFERENCES GJ_users(id),
    CONSTRAINT GJ_requetes_GJ_statut_FK FOREIGN KEY (id_GJ_STATUT) REFERENCES GJ_statut(id),
    CONSTRAINT GJ_requetes_GJ_users_valide_FK FOREIGN KEY (id_GJ_USERS_VALIDE) REFERENCES GJ_users(id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_progression
#------------------------------------------------------------

CREATE TABLE GJ_progression (
    id INT AUTO_INCREMENT NOT NULL,
    libelle VARCHAR(30) NOT NULL,

    CONSTRAINT GJ_progression_PK PRIMARY KEY (id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_collection
#------------------------------------------------------------

CREATE TABLE GJ_collection (
    id_GJ_JEUX INT NOT NULL,
    id_GJ_USERS BIGINT UNSIGNED NOT NULL,
    note FLOAT NOT NULL,
    commentaire VARCHAR(300) NOT NULL,
    id INT NOT NULL,

    CONSTRAINT GJ_collection_PK PRIMARY KEY (id_GJ_JEUX, id_GJ_USERS),
    CONSTRAINT GJ_collection_GJ_jeux_FK FOREIGN KEY (id_GJ_JEUX) REFERENCES GJ_jeux(id),
    CONSTRAINT GJ_collection_GJ_users_FK FOREIGN KEY (id_GJ_USERS) REFERENCES GJ_users(id),
    CONSTRAINT GJ_collection_GJ_progression_FK FOREIGN KEY (id) REFERENCES GJ_progression(id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: POSSEDE_SUPPORTS
#------------------------------------------------------------

CREATE TABLE POSSEDE_SUPPORTS (
    id INT NOT NULL,
    id_GJ_USERS BIGINT UNSIGNED NOT NULL,

    CONSTRAINT POSSEDE_SUPPORTS_PK PRIMARY KEY (id, id_GJ_USERS),
    CONSTRAINT POSSEDE_SUPPORTS_GJ_supports_FK FOREIGN KEY (id) REFERENCES GJ_supports(id),
    CONSTRAINT POSSEDE_SUPPORTS_GJ_users_FK FOREIGN KEY (id_GJ_USERS) REFERENCES GJ_users(id)
) ENGINE=InnoDB;


#------------------------------------------------------------
# Table: APPARTIENT
#------------------------------------------------------------

CREATE TABLE APPARTIENT (
    id INT NOT NULL,
    id_GJ_GENRES INT NOT NULL,

    CONSTRAINT APPARTIENT_PK PRIMARY KEY (id, id_GJ_GENRES),
    CONSTRAINT APPARTIENT_GJ_jeux_FK FOREIGN KEY (id) REFERENCES GJ_jeux(id),
    CONSTRAINT APPARTIENT_GJ_genres_FK FOREIGN KEY (id_GJ_GENRES) REFERENCES GJ_genres(id)
) ENGINE=InnoDB;


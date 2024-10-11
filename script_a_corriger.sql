#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: GJ_ROLES
#------------------------------------------------------------

CREATE TABLE GJ_ROLES(
        code  Char (1) NOT NULL ,
        label Varchar (30) NOT NULL
	,CONSTRAINT GJ_ROLES_PK PRIMARY KEY (code)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_USERS
#------------------------------------------------------------

CREATE TABLE GJ_USERS(
        id               Int  Auto_increment  NOT NULL ,
        pseudo           Varchar (20) NOT NULL ,
        password         Varchar (250) NOT NULL ,
        mail             Varchar (50) NOT NULL ,
        mail_verified_at TimeStamp NOT NULL ,
        telephone        Varchar (20) NOT NULL ,
        visibilite       Bool NOT NULL ,
        created_at       TimeStamp NOT NULL ,
        can_contribute   Bool NOT NULL ,
        code             Char (1) NOT NULL
	,CONSTRAINT GJ_USERS_PK PRIMARY KEY (id)

	,CONSTRAINT GJ_USERS_GJ_ROLES_FK FOREIGN KEY (code) REFERENCES GJ_ROLES(code)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_SUPPORTS
#------------------------------------------------------------

CREATE TABLE GJ_SUPPORTS(
        id          Int  Auto_increment  NOT NULL ,
        nom         Varchar (70) NOT NULL ,
        description Varchar (50) NOT NULL ,
        date        TimeStamp NOT NULL
	,CONSTRAINT GJ_SUPPORTS_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_JEUX
#------------------------------------------------------------

CREATE TABLE GJ_JEUX(
        id                 Int  Auto_increment  NOT NULL ,
        titre              Varchar (70) NOT NULL ,
        description        Varchar (300) NOT NULL ,
        date_sortie        TimeStamp NOT NULL ,
        fichier_couverture Varchar (300) NOT NULL ,
        possede_par        Int NOT NULL ,
        moyenne            Int NOT NULL ,
        id_GJ_SUPPORTS     Int NOT NULL
	,CONSTRAINT GJ_JEUX_PK PRIMARY KEY (id)

	,CONSTRAINT GJ_JEUX_GJ_SUPPORTS_FK FOREIGN KEY (id_GJ_SUPPORTS) REFERENCES GJ_SUPPORTS(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_GENRES
#------------------------------------------------------------

CREATE TABLE GJ_GENRES(
        id    Int  Auto_increment  NOT NULL ,
        label Varchar (300) NOT NULL
	,CONSTRAINT GJ_GENRES_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_STATUT
#------------------------------------------------------------

CREATE TABLE GJ_STATUT(
        id    Int  Auto_increment  NOT NULL ,
        label Varchar (30) NOT NULL
	,CONSTRAINT GJ_STATUT_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_REQUETES
#------------------------------------------------------------

CREATE TABLE GJ_REQUETES(
        id                 Int  Auto_increment  NOT NULL ,
        motif              Varchar (300) ,
        titre              Varchar (70) NOT NULL ,
        description        Varchar (500) NOT NULL ,
        date_sortie        TimeStamp NOT NULL ,
        fichier_couverture Varchar (300) NOT NULL ,
        id_GJ_USERS        Int NOT NULL ,
        id_GJ_STATUT       Int NOT NULL ,
        id_GJ_USERS_VALIDE Int
	,CONSTRAINT GJ_REQUETES_PK PRIMARY KEY (id)

	,CONSTRAINT GJ_REQUETES_GJ_USERS_FK FOREIGN KEY (id_GJ_USERS) REFERENCES GJ_USERS(id)
	,CONSTRAINT GJ_REQUETES_GJ_STATUT0_FK FOREIGN KEY (id_GJ_STATUT) REFERENCES GJ_STATUT(id)
	,CONSTRAINT GJ_REQUETES_GJ_USERS1_FK FOREIGN KEY (id_GJ_USERS_VALIDE) REFERENCES GJ_USERS(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_PROGRESSION
#------------------------------------------------------------

CREATE TABLE GJ_PROGRESSION(
        id      Int  Auto_increment  NOT NULL ,
        libelle Varchar (30) NOT NULL
	,CONSTRAINT GJ_PROGRESSION_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GJ_COLLECTION
#------------------------------------------------------------

CREATE TABLE GJ_COLLECTION(
        id_GJ_USERS Int NOT NULL ,
        id_GJ_JEUX  Int NOT NULL ,
        note        Float NOT NULL ,
        comment     Varchar (300) NOT NULL ,
        id          Int NOT NULL
	,CONSTRAINT GJ_COLLECTION_PK PRIMARY KEY (id_GJ_USERS,id_GJ_JEUX)

	,CONSTRAINT GJ_COLLECTION_GJ_USERS_FK FOREIGN KEY (id_GJ_USERS) REFERENCES GJ_USERS(id)
	,CONSTRAINT GJ_COLLECTION_GJ_JEUX0_FK FOREIGN KEY (id_GJ_JEUX) REFERENCES GJ_JEUX(id)
	,CONSTRAINT GJ_COLLECTION_GJ_PROGRESSION1_FK FOREIGN KEY (id) REFERENCES GJ_PROGRESSION(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: POSSEDE_SUPPORTS
#------------------------------------------------------------

CREATE TABLE POSSEDE_SUPPORTS(
        id          Int NOT NULL ,
        id_GJ_USERS Int NOT NULL
	,CONSTRAINT POSSEDE_SUPPORTS_PK PRIMARY KEY (id,id_GJ_USERS)

	,CONSTRAINT POSSEDE_SUPPORTS_GJ_SUPPORTS_FK FOREIGN KEY (id) REFERENCES GJ_SUPPORTS(id)
	,CONSTRAINT POSSEDE_SUPPORTS_GJ_USERS0_FK FOREIGN KEY (id_GJ_USERS) REFERENCES GJ_USERS(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: APPARTIENT
#------------------------------------------------------------

CREATE TABLE APPARTIENT(
        id           Int NOT NULL ,
        id_GJ_GENRES Int NOT NULL
	,CONSTRAINT APPARTIENT_PK PRIMARY KEY (id,id_GJ_GENRES)

	,CONSTRAINT APPARTIENT_GJ_JEUX_FK FOREIGN KEY (id) REFERENCES GJ_JEUX(id)
	,CONSTRAINT APPARTIENT_GJ_GENRES0_FK FOREIGN KEY (id_GJ_GENRES) REFERENCES GJ_GENRES(id)
)ENGINE=InnoDB;


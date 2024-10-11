#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: ROLES
#------------------------------------------------------------

CREATE TABLE ROLES(
        code  Char (1) NOT NULL ,
        label Varchar (30) NOT NULL
	,CONSTRAINT ROLES_PK PRIMARY KEY (code)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: USERS
#------------------------------------------------------------

CREATE TABLE USERS(
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
	,CONSTRAINT USERS_PK PRIMARY KEY (id)

	,CONSTRAINT USERS_ROLES_FK FOREIGN KEY (code) REFERENCES ROLES(code)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: SUPPORTS
#------------------------------------------------------------

CREATE TABLE SUPPORTS(
        id   Int  Auto_increment  NOT NULL ,
        nom  Varchar (70) NOT NULL ,
        desc Varchar (50) ,
        date TimeStamp NOT NULL
	,CONSTRAINT SUPPORTS_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: JEUX
#------------------------------------------------------------

CREATE TABLE JEUX(
        id                 Int  Auto_increment  NOT NULL ,
        titre              Varchar (70) NOT NULL ,
        desc               Varchar (300) NOT NULL ,
        date_sortie        TimeStamp NOT NULL ,
        fichier_couverture Varchar (300) NOT NULL ,
        possede_par        Int NOT NULL ,
        moyenne            Int NOT NULL ,
        id_SUPPORTS        Int NOT NULL
	,CONSTRAINT JEUX_PK PRIMARY KEY (id)

	,CONSTRAINT JEUX_SUPPORTS_FK FOREIGN KEY (id_SUPPORTS) REFERENCES SUPPORTS(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: GENRES
#------------------------------------------------------------

CREATE TABLE GENRES(
        id    Int  Auto_increment  NOT NULL ,
        label Varchar (300) NOT NULL
	,CONSTRAINT GENRES_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: STATUT
#------------------------------------------------------------

CREATE TABLE STATUT(
        id    Int  Auto_increment  NOT NULL ,
        label Varchar (30) NOT NULL
	,CONSTRAINT STATUT_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: REQUETES
#------------------------------------------------------------

CREATE TABLE REQUETES(
        id                 Int  Auto_increment  NOT NULL ,
        motif              Varchar (300) ,
        titre              Varchar (70) NOT NULL ,
        desc               Varchar (500) NOT NULL ,
        date_sortie        TimeStamp NOT NULL ,
        fichier_couverture Varchar (300) NOT NULL ,
        id_USERS           Int NOT NULL ,
        id_STATUT          Int NOT NULL ,
        id_USERS_VALIDE    Int
	,CONSTRAINT REQUETES_PK PRIMARY KEY (id)

	,CONSTRAINT REQUETES_USERS_FK FOREIGN KEY (id_USERS) REFERENCES USERS(id)
	,CONSTRAINT REQUETES_STATUT0_FK FOREIGN KEY (id_STATUT) REFERENCES STATUT(id)
	,CONSTRAINT REQUETES_USERS1_FK FOREIGN KEY (id_USERS_VALIDE) REFERENCES USERS(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: PROGRESSION
#------------------------------------------------------------

CREATE TABLE PROGRESSION(
        id      Int  Auto_increment  NOT NULL ,
        libelle Varchar (30) NOT NULL
	,CONSTRAINT PROGRESSION_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: COLLECTION
#------------------------------------------------------------

CREATE TABLE COLLECTION(
        id_USERS Int NOT NULL ,
        id_JEUX  Int NOT NULL ,
        note     Float NOT NULL ,
        comment  Varchar (300) NOT NULL ,
        id       Int NOT NULL
	,CONSTRAINT COLLECTION_PK PRIMARY KEY (id_USERS,id_JEUX)

	,CONSTRAINT COLLECTION_USERS_FK FOREIGN KEY (id_USERS) REFERENCES USERS(id)
	,CONSTRAINT COLLECTION_JEUX0_FK FOREIGN KEY (id_JEUX) REFERENCES JEUX(id)
	,CONSTRAINT COLLECTION_PROGRESSION1_FK FOREIGN KEY (id) REFERENCES PROGRESSION(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: POSSEDE_SUPPORTS
#------------------------------------------------------------

CREATE TABLE POSSEDE_SUPPORTS(
        id       Int NOT NULL ,
        id_USERS Int NOT NULL
	,CONSTRAINT POSSEDE_SUPPORTS_PK PRIMARY KEY (id,id_USERS)

	,CONSTRAINT POSSEDE_SUPPORTS_SUPPORTS_FK FOREIGN KEY (id) REFERENCES SUPPORTS(id)
	,CONSTRAINT POSSEDE_SUPPORTS_USERS0_FK FOREIGN KEY (id_USERS) REFERENCES USERS(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: APPARTIENT
#------------------------------------------------------------

CREATE TABLE APPARTIENT(
        id        Int NOT NULL ,
        id_GENRES Int NOT NULL
	,CONSTRAINT APPARTIENT_PK PRIMARY KEY (id,id_GENRES)

	,CONSTRAINT APPARTIENT_JEUX_FK FOREIGN KEY (id) REFERENCES JEUX(id)
	,CONSTRAINT APPARTIENT_GENRES0_FK FOREIGN KEY (id_GENRES) REFERENCES GENRES(id)
)ENGINE=InnoDB;


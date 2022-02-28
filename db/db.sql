create table user
(
    iduser   int auto_increment
        primary key,
    username varchar(50)                    not null,
    email    varchar(100)                   not null,
    password varchar(100)                   not null,
    typeuser enum ('lavoratore', 'azienda') not null,
    code     mediumint default 0            not null,
    constraint user_username_uindex
        unique (username),
    constraint users_email_uindex
        unique (email)
);

create table azienda
(
    idAzienda        int auto_increment
        primary key,
    nomeAzienda      varchar(255) not null,
    numeroSedi       int          not null,
    numeroDipendenti int          not null,
    luogoSedi        varchar(255) not null,
    idUser1          int          not null,
    constraint azienda_users_id_fk
        foreign key (idUser1) references user (iduser)
            on update cascade on delete cascade
);

create table ateco
(
    idCodiceATECO int          not null
        primary key,
    codiceATECO   char(7)      not null,
    settore       varchar(255) not null,
    constraint ateco_azienda_idAzienda_fk
        foreign key (idCodiceATECO) references azienda (idAzienda)
            on update cascade on delete cascade
);

create table lavoratore
(
    idlavoratore  int auto_increment
        primary key,
    nome          varchar(50)     not null,
    cognome       varchar(50)     null,
    dob           date            not null,
    sesso         enum ('M', 'F') not null,
    codicefiscale varchar(16)     not null,
    tel           varchar(10)     not null,
    idUser1       int             not null,
    constraint lavoratore_codicefiscale_uindex
        unique (codicefiscale),
    constraint lavoratore_tel_uindex
        unique (tel),
    constraint lavoratore_user_iduser_fk
        foreign key (idUser1) references user (iduser)
            on update cascade on delete cascade
);

create table curriculum
(
    idCurriculum  int auto_increment
        primary key,
    pdf_url       text not null,
    idLavoratore1 int  not null,
    constraint curriculum_lavoratore_idlavoratore_fk
        foreign key (idLavoratore1) references lavoratore (idlavoratore)
            on update cascade on delete cascade
);

create table indirizzo
(
    idIndirizzo   int auto_increment
        primary key,
    qualificatore enum ('via', 'piazza', 'largo', 'corso') not null comment '

',
    nomevia       varchar(150)                             not null,
    ncivico       int                                      not null,
    cap           int                                      null,
    comune        varchar(255)                             not null,
    provincia     varchar(255)                             not null,
    citta         varchar(255)                             not null,
    idlavoratore1 int                                      not null,
    constraint indirizzo_lavoratore_idlavoratore_fk
        foreign key (idlavoratore1) references lavoratore (idlavoratore)
            on update cascade on delete cascade
);

create table professione
(
    idprofessione     int auto_increment
        primary key,
    areaprofessionale varchar(255) not null,
    sottoarea         varchar(255) not null,
    categoria         varchar(255) not null,
    idlavoratore1     int          not null,
    constraint professione_lavoratore_idlavoratore_fk
        foreign key (idlavoratore1) references lavoratore (idlavoratore)
            on update cascade on delete cascade
);

create table user_image
(
    idImage   int auto_increment
        primary key,
    image_url text not null,
    idUser1   int  not null,
    constraint user_image_user_iduser_fk
        foreign key (idUser1) references user (iduser)
            on update cascade on delete cascade
);

create table categoriaprofessionale
(
    idprofessione int auto_increment
        primary key,
    area          varchar(150) not null,
    sotto_area    varchar(150) null,
    categoria     varchar(150) null
);

INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Analista Programmatore');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Analista software');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Programmatore .Net');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Programmatore C/C++');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Programmatore java');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Programmatore PHP');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Programmatore SQL');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'Sviluppatore di applicazioni per dispositivi mobili');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Analisi / Sviluppo Software / Web', 'UX/UI Designer');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Help Desk/ Assistenza Informatica', 'Help Desk 2nd line specialist');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Help Desk/ Assistenza Informatica', 'ICT help desk agent');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Help Desk/ Assistenza Informatica', 'ICT help desk manager ');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Infrastruttura IT/ DBA', 'Amministratore del database');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Infrastruttura IT/ DBA', 'Amministratore rete informatica');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Infrastruttura IT/ DBA', 'Cloud specialist');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Infrastruttura IT/ DBA', 'System engenieer junior');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Infrastruttura IT/ DBA', 'System engenieer senior');
INSERT INTO jobint.categoriaprofessionale (area, sotto_area, categoria) VALUES ('It e digital', 'Infrastruttura IT/ DBA', 'Responsabile della sicurezza TIC');

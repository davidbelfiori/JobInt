/*

//prova inserimento dati azienda
insert into user (email, password, typeuser, username)
values ('atto@email.com','admin','azienda','atto');
insert into azienda (nomeAzienda, numeroSedi, numeroDipendenti, luogoSedi, idUser1)
values ('atto',1,1,'io',(select iduser from user where username='atto'));
insert into ateco (idCodiceATECO, codiceATECO, settore)
values ((select idAzienda from azienda where nomeAzienda='atto'),'asdfgh','it');
 */

/* procedura di inserimento  dati lavoratore
 begin;
insert into user (username, email, password, typeuser)
values ('david_belfiori','davidjulian2003@gmail.com','admin','lavoratore');
insert into lavoratore (nome, cognome, dob, sesso, codicefiscale, tel, idUser1)
values ('david julian','belfiori','2003-10-10','m','blfddj03r10h501z','3933295303',(select iduser from user where username='david_belfiori'));
insert into indirizzo (qualificatore, nomevia, ncivico, cap, comune, provincia, citta, idlavoratore1)
values ('largo','michele unia',4,00181,'roma','rm','roma',(select idlavoratore from lavoratore where codicefiscale='blfddj03r10h501z'));
insert into professione (areaprofessionale, sottoarea, categoria, idlavoratore1)
values ('it e digital','sviluppo','programmatore java',(select idlavoratore from lavoratore where codicefiscale='blfddj03r10h501z'));
commit ;
*/
/* select informazioni lato lavoratore
select * from user,user_image,curriculum,lavoratore,professione,indirizzo
where user.username='davidbelfiori' and user.email='davidjulian2003@gmail.com'
and user.iduser=lavoratore.idUser1
and user_image.idUser1=user.iduser
and lavoratore.idlavoratore=curriculum.idLavoratore1
and indirizzo.idlavoratore1=lavoratore.idlavoratore
and professione.idlavoratore1=lavoratore.idlavoratore
 */

select * from user,azienda,ateco
where user.iduser=azienda.idUser1 and ateco.idCodiceATECO=azienda.idAzienda and username='netflix' and email='netflix@email.com'



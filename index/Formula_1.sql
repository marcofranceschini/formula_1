CREATE TABLE GP
(
  nome varchar(30) NOT NULL,
  anno int(4) NOT NULL,
  nazione varchar(20) NOT NULL,
  citta varchar(20) NOT NULL,
  pista varchar(20) NOT NULL,
  lunghezza int(6) NOT NULL,
  num_spettatori int(10) NOT NULL,
  PRIMARY KEY(nome, anno)
) ENGINE=InnoDB;

CREATE TABLE Scuderia
(
  nome varchar(30) PRIMARY KEY NOT NULL,
  anno_fondazione int(4) NOT NULL,
  fondi int(16) NOT NULL,
  incassi_sponsor int(16)
) ENGINE=InnoDB;

CREATE TABLE Motore
(
  nome varchar(20) NOT NULL,
  produttore varchar(20) NOT NULL,
  descrizione varchar(100),
  scuderia varchar(30) NOT NULL,
  PRIMARY KEY(nome, scuderia),
  FOREIGN KEY(scuderia) REFERENCES Scuderia(nome) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Reparto
(
  nome varchar(20) NOT NULL,
  descrizione varchar(100) NOT NULL,
  scuderia varchar(30) NOT NULL,
  PRIMARY KEY(nome, scuderia),
  FOREIGN KEY(scuderia) REFERENCES Scuderia(nome) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Dipendente
(
  username varchar(8) NOT NULL,
  password varchar(10) NOT NULL,
  nome varchar(20) NOT NULL,
  cognome varchar(20) NOT NULL,
  data_nascita date NOT NULL,
  telefono int(10) NOT NULL,
  nazionalita varchar(20) NOT NULL,
  indirizzo varchar(20) NOT NULL,
  stipendio int(9) NOT NULL,
  data_assunzione date NOT NULL,
  data_termine date,
  specializzazione varchar(20),
  titolo_studio varchar(20),
  reparto varchar(20) NOT NULL,
  scuderia varchar(30) NOT NULL,
  PRIMARY KEY(username, reparto, scuderia),
  FOREIGN KEY(reparto) REFERENCES Reparto(nome) ON DELETE CASCADE,
  FOREIGN KEY(scuderia) REFERENCES Reparto(scuderia) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Pilota
(
  dipendente varchar(8)NOT NULL,
  reparto varchar(20) NOT NULL,
  scuderia varchar(30) NOT NULL,
  anni_carriera int(2) NOT NULL,
  stipendio_sponsor int(16) NOT NULL,
  PRIMARY KEY(dipendente, reparto, scuderia),
  FOREIGN KEY(dipendente) REFERENCES Dipendente(username) ON DELETE CASCADE,
  FOREIGN KEY(reparto) REFERENCES Dipendente(reparto) ON DELETE CASCADE,
  FOREIGN KEY(scuderia) REFERENCES Dipendente(scuderia) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Partecipa
(
  gp varchar(30) NOT NULL,
  anno int(4) NOT NULL,
  scuderia varchar(30) NOT NULL,
  punti int(2),
  PRIMARY KEY(gp, anno, scuderia),
  CONSTRAINT FOREIGN KEY(gp, anno) REFERENCES GP(nome, anno) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(scuderia) REFERENCES Scuderia(nome) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Gareggia
(
  pilota varchar(8) NOT NULL,
  reparto varchar(20) NOT NULL,
  scuderia varchar(30) NOT NULL,
  gp varchar(30) NOT NULL,
  anno int(4) NOT NULL,
  pos_iniz int(2),
  pos_fin int(2),
  punti int(2),
  tempo_qualifica float(15),
  PRIMARY KEY(pilota, reparto, scuderia, gp, anno),
  CONSTRAINT FOREIGN KEY(pilota, reparto, scuderia) REFERENCES Pilota(dipendente, reparto, scuderia) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY(gp, anno) REFERENCES GP(nome, anno) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


DELIMITER //
CREATE PROCEDURE SetTeamPoints(IN grandprix varchar(30), IN gp_year int(4), IN team varchar(30), IN points int(2))
BEGIN
  DECLARE team_points int DEFAULT 0;
    DECLARE row_count int;
	
	SELECT COUNT(gp) INTO row_count
	FROM Partecipa
	WHERE scuderia=team AND anno=gp_year AND gp=grandprix;
	
	IF row_count > 0
	THEN
		SELECT punti INTO team_points
		FROM Partecipa
		WHERE scuderia=team AND anno=gp_year AND gp=grandprix;
		
		UPDATE Partecipa SET punti=(team_points+points) WHERE scuderia=team AND anno=gp_year AND gp=grandprix;
	ELSE
		INSERT INTO Partecipa VALUES(grandprix, gp_year, team, points);
	END IF;	
END; //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE SetTeamSponsor(IN team varchar(20))
BEGIN
    DECLARE IncSponsor int DEFAULT 0;
    SELECT incassi_sponsor INTO IncSponsor
    FROM Scuderia
    WHERE nome = team;
    SET IncSponsor=IncSponsor+(IncSponsor/20);
    UPDATE Scuderia SET incassi_sponsor=incassi_sponsor+IncSponsor  WHERE    nome=team;
END; //
DELIMITER ;


DELIMITER //
CREATE TRIGGER OnNewRaceCompleted
BEFORE INSERT ON Gareggia
FOR EACH ROW
BEGIN
    CALL SetTeamPoints(new.gp, new.anno, new.scuderia, new.punti);
    IF new.pos_fin = 1
    THEN
        CALL SetTeamSponsor( new.scuderia );
        UPDATE Pilota SET stipendio_sponsor=stipendio_sponsor+500000 WHERE dipendente=new.pilota;
    END IF;
END; //
DELIMITER ;




DELIMITER //
CREATE TRIGGER OnNewEmlpoyee
BEFORE INSERT ON Dipendente
FOR EACH ROW
BEGIN
	DECLARE pilota bit;
	DECLARE sponsor int;
	SELECT count(d.username) INTO pilota
	FROM Dipendente as d join Pilota as p on (d.username=p.dipendente)
	WHERE d.username=new.username;
	SELECT incassi_sponsor INTO sponsor
	FROM Scuderia as s
	WHERE s.nome = new.scuderia;
	IF pilota = 0
	THEN
		IF new.stipendio > sponsor/3
		THEN
			INSERT INTO Dipendente SELECT * FROM Dipendente LIMIT 1;
		ELSE
			UPDATE Scuderia SET incassi_sponsor=incassi_sponsor-new.stipendio WHERE    nome=new.scuderia;
		END IF;
	END IF;
END; //
DELIMITER ;

create view numProduzioni as select count(s.nome) as num, m.produttore
from Motore as m join Scuderia as s on (m.produttore=s.nome)
group by m.produttore;

create view polePiloti as select nome, cognome, nazionalita, count(pilota) as pole
from Gareggia join Dipendente on (pilota=username)
where pos_iniz=1
group by username;


INSERT INTO GP VALUES("Rolex Australian Grand Prix", 2015, "Australia", "Melbourne", "Albert Park", 5303, 30000);
INSERT INTO GP VALUES("Petronas Malaysia Grand Prix", 2015, "Malesia", "Kuala Lumpur", "Sepang International Circuit", 5543, 50000);
INSERT INTO GP VALUES("Chinese Grand Prix", 2015, "Cina", "Shanghai", "Shanghai Circuit", 5451, 65000);
INSERT INTO GP VALUES("Gulf Air Bahrain Grand Prix", 2015, "Bahrein", "Sakhir", "Bahrain International Circuit", 5412, 40000);
INSERT INTO GP VALUES("Gran Premio de Espana", 2015, "Spagna", "Montmeló", "Circuito de Cataluña", 4655, 45000);
INSERT INTO GP VALUES("Grand Prix de Monaco", 2015, "Monaco", "Monte Carlo", "Circuit de Monaco", 3337, 40000);

INSERT INTO GP VALUES("Rolex Australian Grand Prix", 2014, "Australia", "Melbourne", "Albert Park", 5303, 30000);
INSERT INTO GP VALUES("Petronas Malaysia Grand Prix", 2014, "Malesia", "Kuala Lumpur", "Sepang International Circuit", 5543, 50000);
INSERT INTO GP VALUES("Chinese Grand Prix", 2014, "Cina", "Shanghai", "Shanghai Circuit", 5451, 65000);
INSERT INTO GP VALUES("Grand Prix de Monaco", 2014, "Monaco", "Monte Carlo", "Circuit de Monaco", 3337, 40000);

INSERT INTO GP VALUES("Gran Premio de Espana", 2013, "Spagna", "Montmeló", "Circuito de Cataluña", 4655, 45000);
INSERT INTO GP VALUES("Grand Prix de Monaco", 2013, "Monaco", "Monte Carlo", "Circuit de Monaco", 3337, 40000);

INSERT INTO Scuderia VALUES("Scuderia Ferrari", "1929", 250000000, 30000000);
INSERT INTO Scuderia VALUES("Mercedes AMG F1", "1954", 100000000, 40000000);
INSERT INTO Scuderia VALUES("Williams Martini Racing", "1977", 6000000, 35000000);
INSERT INTO Scuderia VALUES("Sauber F1 Team", "1993", 5000000, 20000000);
INSERT INTO Scuderia VALUES("Infiniti Red Bull Racing", "2005", 8000000, 20000000);

INSERT INTO Motore VALUES("SF15-T", "Scuderia Ferrari", "Motore turbo", "Scuderia Ferrari");
INSERT INTO Motore VALUES("PU106A Hybrid", "Mercedes AMG F1", "Motore V6 turbo 1.6", "Mercedes AMG F1");
INSERT INTO Motore VALUES("PU106A Hybrid", "Mercedes AMG F1", "Motore V6 turbo 1.6", "Williams Martini Racing");
INSERT INTO Motore VALUES("SF15-T", "Scuderia Ferrari", "Motore turbo", "Sauber F1 Team");
INSERT INTO Motore VALUES("Energy F1-2015", "Renault", "Motore V6 turbo 1.6", "Infiniti Red Bull Racing");

INSERT INTO Reparto VALUES("Piloti", "Reparto dei piloti della Ferrari", "Scuderia Ferrari");
INSERT INTO Reparto VALUES("Aerodinamica", "Reparto aerodinamica della ", "Scuderia Ferrari");
INSERT INTO Reparto VALUES("Motorizzazione", "Reparto motorizzazione", "Scuderia Ferrari");
INSERT INTO Reparto VALUES("Telemetria", "Telemetria", "Scuderia Ferrari");
INSERT INTO Reparto VALUES("Sviluppo", "", "Scuderia Ferrari");
INSERT INTO Reparto VALUES("Telaio", "", "Scuderia Ferrari");
INSERT INTO Reparto VALUES("Piloti", "Reparto dei piloti della Mercedes", "Mercedes AMG F1");
INSERT INTO Reparto VALUES("Aerodinamica", "", "Mercedes AMG F1");
INSERT INTO Reparto VALUES("Motorizzazione", "", "Mercedes AMG F1");
INSERT INTO Reparto VALUES("Telemetria", "", "Mercedes AMG F1");
INSERT INTO Reparto VALUES("Sviluppo", "", "Mercedes AMG F1");
INSERT INTO Reparto VALUES("Telaio", "", "Mercedes AMG F1");
INSERT INTO Reparto VALUES("Piloti", "Reparto dei piloti della Williams", "Williams Martini Racing");
INSERT INTO Reparto VALUES("Aerodinamica", "", "Williams Martini Racing");
INSERT INTO Reparto VALUES("Motorizzazione", "", "Williams Martini Racing");
INSERT INTO Reparto VALUES("Telemetria", "", "Williams Martini Racing");
INSERT INTO Reparto VALUES("Sviluppo", "", "Williams Martini Racing");
INSERT INTO Reparto VALUES("Telaio", "", "Williams Martini Racing");
INSERT INTO Reparto VALUES("Piloti", "Reparto dei piloti della Sauber", "Sauber F1 Team");
INSERT INTO Reparto VALUES("Aerodinamica", "", "Sauber F1 Team");
INSERT INTO Reparto VALUES("Motorizzazione", "", "Sauber F1 Team");
INSERT INTO Reparto VALUES("Telemetria", "", "Sauber F1 Team");
INSERT INTO Reparto VALUES("Sviluppo", "", "Sauber F1 Team");
INSERT INTO Reparto VALUES("Telaio", "", "Sauber F1 Team");
INSERT INTO Reparto VALUES("Piloti", "Reparto dei piloti della Red Bull", "Infiniti Red Bull Racing");
INSERT INTO Reparto VALUES("Aerodinamica", "", "Infiniti Red Bull Racing");
INSERT INTO Reparto VALUES("Motorizzazione", "", "Infiniti Red Bull Racing");
INSERT INTO Reparto VALUES("Telemetria", "", "Infiniti Red Bull Racing");
INSERT INTO Reparto VALUES("Sviluppo", "", "Infiniti Red Bull Racing");
INSERT INTO Reparto VALUES("Telaio", "", "Infiniti Red Bull Racing");

INSERT INTO Dipendente VALUES("svettel", "qwerty", "Sebastian", "Vettel", "1987-07-03", 3401234567, "Germania", "Deutschsrasse 8", 2000000, "2014-11-20", NULL, NULL, NULL, "Piloti", "Scuderia Ferrari");
INSERT INTO Dipendente VALUES("kraikkon", "qwerty", "Kimi", "Raikkonen", "1979-10-17", 3401474567, "Finlandia", "Via vodka 17", 2500000, "2013-09-11", NULL, NULL, NULL, "Piloti", "Scuderia Ferrari");
INSERT INTO Dipendente VALUES("lhamilto", "qwerty", "Lewis", "Hamilton", "1985-01-07", 3405334567, "Regno Unito", "Baker Street 45", 4000000, "2012-09-28", NULL, NULL, NULL, "Piloti", "Mercedes AMG F1");
INSERT INTO Dipendente VALUES("nrosberg", "qwerty", "Nico", "Rosberg", "1985-06-27", 3405334567, "Germania", "Deutschsrasse 8", 2500000, "2009-09-20", NULL, NULL, NULL, "Piloti", "Mercedes AMG F1");
INSERT INTO Dipendente VALUES("vbottas", "qwerty", "Valtteri", "Bottas", "1989-08-28", 3405334567, "Finlandia", "Via vodaka 18", 1000000, "2013-03-17", NULL, NULL, NULL, "Piloti", "Williams Martini Racing");
INSERT INTO Dipendente VALUES("fmassa", "qwerty", "Felipe", "Massa", "1981-04-25", 3405334567, "Brasile", "Via maracana 22", 2000000, "2013-09-10", NULL, NULL, NULL, "Piloti", "Williams Martini Racing");
INSERT INTO Dipendente VALUES("fnasr", "qwerty", "Felipe", "Nasr", "1992-08-21", 3405334567, "Brasile", "Via maracana 23", 100000, "2014-10-20", NULL, NULL, NULL, "Piloti", "Sauber F1 Team");
INSERT INTO Dipendente VALUES("mericsso", "qwerty", "Marcus", "Ericsson", "1990-09-02", 3405334567, "Svezia", "Via falun 14", 100000, "2014-11-23", NULL, NULL, NULL, "Piloti", "Sauber F1 Team");
INSERT INTO Dipendente VALUES("dricciar", "qwerty", "Daniel", "Ricciardo", "1989-07-01", 3492748429, "Australia", "Perth street 34", 8000, "2010-01-10", NULL, NULL, NULL, "Piloti", "Infiniti Red Bull Racing");
INSERT INTO Dipendente VALUES("dkvyat", "qwerty", "Daniil", "Kvyat", "1989-07-01", 3492748429, "Russia", "Via Mosca 29", 8000, "2014-04-16", NULL, NULL, NULL, "Piloti", "Infiniti Red Bull Racing");

INSERT INTO Dipendente VALUES("mfrances", "qwerty", "Marco", "Franceschini", "1994-08-04", 3405334567, "Italia", "Via monte 27", 100000, "2015-01-10",  NULL, "Analisi tecnica", NULL, "Sviluppo", "Scuderia Ferrari");
INSERT INTO Dipendente VALUES("azaros", "qwerty", "Antonio", "Zaros", "1994-11-11", 3405334567, "Italia", "Via trovaso 14", 100000, "2015-01-10", NULL, "Motorizzazione", NULL, "Motorizzazione", "Mercedes AMG F1");
INSERT INTO Dipendente VALUES("kborin", "qwerty", "Kiren", "Borin", "1994-04-24", 3405334567, "Italia", "Via prega 1", 100000, "2015-01-10", NULL, NULL,  "Laurea ing. meccanica", "Motorizzazione", "Williams Martini Racing");
INSERT INTO Dipendente VALUES("ftavalli", "qwerty", "Fabiano", "Tavallini", "1994-05-12", 3405334567, "Italia", "Via caduti 7", 100000, "2015-01-10", NULL, "Dinamica fluidi", NULL, "Aerodinamica", "Sauber F1 Team");

INSERT INTO Pilota VALUES("svettel", "Piloti", "Scuderia Ferrari", 9, 1000000);
INSERT INTO Pilota VALUES("kraikkon", "Piloti", "Scuderia Ferrari", 14, 500000);
INSERT INTO Pilota VALUES("lhamilto", "Piloti", "Mercedes AMG F1", 8, 1500000);
INSERT INTO Pilota VALUES("nrosberg", "Piloti", "Mercedes AMG F1", 7, 1000000);
INSERT INTO Pilota VALUES("vbottas", "Piloti", "Williams Martini Racing", 2, 100000);
INSERT INTO Pilota VALUES("fmassa", "Piloti", "Williams Martini Racing", 13, 1500000);
INSERT INTO Pilota VALUES("fnasr", "Piloti", "Sauber F1 Team", 0, 100000);
INSERT INTO Pilota VALUES("mericsso", "Piloti", "Sauber F1 Team", 1, 100000);
INSERT INTO Pilota VALUES("dricciar", "Piloti", "Infiniti Red Bull Racing", 1, 110000);
INSERT INTO Pilota VALUES("dkvyat", "Piloti", "Infiniti Red Bull Racing", 1, 90000);

INSERT INTO Gareggia VALUES("svettel", "Piloti", "Scuderia Ferrari", "Rolex Australian Grand Prix", 2015, 4, 3, 15, 0127.757);
INSERT INTO Gareggia VALUES("kraikkon", "Piloti", "Scuderia Ferrari", "Rolex Australian Grand Prix", 2015, 5, 7, 0, 0127.790);
INSERT INTO Gareggia VALUES("lhamilto", "Piloti", "Mercedes AMG F1", "Rolex Australian Grand Prix", 2015, 1, 1, 25, 0126.327);
INSERT INTO Gareggia VALUES("nrosberg", "Piloti", "Mercedes AMG F1", "Rolex Australian Grand Prix", 2015, 2, 2, 18, 0126.921);
INSERT INTO Gareggia VALUES("vbottas", "Piloti", "Williams Martini Racing", "Rolex Australian Grand Prix", 2015, 6, 0, 0, 0128.087);
INSERT INTO Gareggia VALUES("fmassa", "Piloti", "Williams Martini Racing", "Rolex Australian Grand Prix", 2015, 3, 4, 12, 0127.718);
INSERT INTO Gareggia VALUES("fnasr", "Piloti", "Sauber F1 Team", "Rolex Australian Grand Prix", 2015, 10, 5, 10, 0128.800);
INSERT INTO Gareggia VALUES("mericsso", "Piloti", "Sauber F1 Team", "Rolex Australian Grand Prix", 2015, 15, 8, 5, 0131.736);
INSERT INTO Gareggia VALUES("svettel", "Piloti", "Scuderia Ferrari", "Petronas Malaysia Grand Prix", 2015, 2, 1, 25, 0142.908);
INSERT INTO Gareggia VALUES("kraikkon", "Piloti", "Scuderia Ferrari", "Petronas Malaysia Grand Prix", 2015, 11, 4, 12, 0142.173);
INSERT INTO Gareggia VALUES("lhamilto", "Piloti", "Mercedes AMG F1", "Petronas Malaysia Grand Prix", 2015, 1, 2, 18, 0149.834);
INSERT INTO Gareggia VALUES("nrosberg", "Piloti", "Mercedes AMG F1", "Petronas Malaysia Grand Prix", 2015, 3, 3, 15, 0150.299);
INSERT INTO Gareggia VALUES("vbottas", "Piloti", "Williams Martini Racing", "Petronas Malaysia Grand Prix", 2015, 8, 5, 10, 0153.179);
INSERT INTO Gareggia VALUES("fmassa", "Piloti", "Williams Martini Racing", "Petronas Malaysia Grand Prix", 2015, 7, 6, 8, 0152.473);
INSERT INTO Gareggia VALUES("fnasr", "Piloti", "Sauber F1 Team", "Petronas Malaysia Grand Prix", 2015, 10, 5, 10, 0128.800);
INSERT INTO Gareggia VALUES("mericsso", "Piloti", "Sauber F1 Team", "Petronas Malaysia Grand Prix", 2015, 15, 8, 5, 0131.736);

drop trigger OnNewRaceCompleted;

DELIMITER //
CREATE TRIGGER OnNewRaceCompleted
BEFORE UPDATE ON Gareggia
FOR EACH ROW
BEGIN
    CALL SetTeamPoints(new.gp, new.anno, new.scuderia, new.punti);
    IF new.pos_fin = 1
    THEN
        CALL SetTeamSponsor( new.scuderia );
        UPDATE Pilota SET stipendio_sponsor=stipendio_sponsor+500000 WHERE dipendente=new.pilota;
    END IF;
END; //
DELIMITER ;

<?php

//NUR VERWENDEN/EINKOMMENTIEREN, WENN EINMALIG EINE ANDERE DATENBANK VERWENDET WERDEN SOLL
//ANSONSTEN KONFIGURATION IN ../inc/baseconfig.inc.php ANPASSEN!
//define('MYSQL_HOST', '');
//define('MYSQL_USER', '');
//define('MYSQL_PASSWORD', '');
//define('MYSQL_DATABASE', '');

include_once '../inc1/baseconfig.inc.php';

//Treffpunkt des Seminars
define('SEMINAR_TREFFPUNKT', 'robna kuća IKEA Zagreb, na ulazu kraj info-pulta');

//Kontakt-Telefon
define('SEMINAR_TELEFON', '--BROJ TELEFONA--');

//Kontakt-E-Mail
define('SEMINAR_EMAIL', 'information.hr@IKEA.com');

//Name des Seminars, wird verwendet in <title>, Überschrift und Bestätigungsmail
define('SEMINAR_NAME', 'Probaj napraviti slatke božićne ukrase đumbira - radionica za djecu');

define('SEMINAR_DESCRIPTION', 'Proslava Svete Lucije važan je dio švedskih običaja. Sveta Lucija je u švedskoj kulturi ona koja donosi svjetlost, kao suprotnost tami i hladnoći, karakterističnoj za to doba godine u Švedskoj. Mališanima će običaje vezane uz proslavu Svete Lucije približiti veleposlanik Švedske u Hrvatskoj, a pomoći će im i pri izradi omiljenih jestivih kućica - kućica od đumbira.');

//Überschrift des Bestätigungsmails
define('CONFIRMATION_SUBJECT', 'Probna kuća IKEA: potvrda o registraciji za radionicu za djecu - Probaj napraviti slatke božićne ukrase đumbira - radionica za djecu 13.12.2016.');

//email text
define('CONFIRMATION_TEXT', 'Hvala ti na prijavi!
Radujemo se druženju s tobom. Nadamo se kako će se tvom mališanu svidjeti IKEA FAMILY radionica za djecu "Probaj napraviti slatke božićne ukrase đumbira". Radionica će trajati otprilike 2 sata.

Potvrđen datum i vrijeme radionice: 13/12/2016 u 18:00 sati u Probnoj kući IKEA Zagreb (Ilica 42) u "Kutku za djecu".

Za otkazivanje sudjelovanja na ovoj radionici molimo te da nas kontaktiraš na IKEAFAMILY.radionice@IKEA.com,

IKEA Family tim');

// shows the option for begleitperson
define('SHOW_BEGLEITUNG', 'YES'); // YES or anything else

define('GROUP_NAME', 'hr161213');


//Event-Codes dieses Seminars (wenn es mehrere Termine gibt: beliebig viele Elemente zum Array hinzufügen)
$eventCodes = array( 'hr161213' );

//Wenn die Anmeldung zur Warteliste möglich sein soll, hier einen Wert eintragen. Ansonsten auf null setzen
//$codeWarteliste = null;
$codeWarteliste = 'gr1604_x';
?>
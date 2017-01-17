<?php

//NUR VERWENDEN/EINKOMMENTIEREN, WENN EINMALIG EINE ANDERE DATENBANK VERWENDET WERDEN SOLL
//ANSONSTEN KONFIGURATION IN ../inc/baseconfig.inc.php ANPASSEN!
//define('MYSQL_HOST', '');
//define('MYSQL_USER', '');
//define('MYSQL_PASSWORD', '');
//define('MYSQL_DATABASE', '');

include_once '../inc/baseconfig.inc.php';

//Treffpunkt des Seminars
define('SEMINAR_TREFFPUNKT', 'robna kuća IKEA Zagreb, na ulazu kraj info-pulta');

//Kontakt-Telefon
define('SEMINAR_TELEFON', '--BROJ TELEFONA--');

//Kontakt-E-Mail
define('SEMINAR_EMAIL', 'information.hr@IKEA.com');

//Name des Seminars, wird verwendet in <title>, Überschrift und Bestätigungsmail
define('SEMINAR_NAME', '');

define('SEMINAR_DESCRIPTION', '');

//Überschrift des Bestätigungsmails
define('CONFIRMATION_SUBJECT', '');

//email text
define('CONFIRMATION_TEXT', '');

// shows the option for begleitperson
define('SHOW_BEGLEITUNG', 'YES'); // YES or anything else

define('GROUP_NAME', 'hr161201_1');


//Event-Codes dieses Seminars (wenn es mehrere Termine gibt: beliebig viele Elemente zum Array hinzufügen)
$eventCodes = array( 'hr161201_1' );

//Wenn die Anmeldung zur Warteliste möglich sein soll, hier einen Wert eintragen. Ansonsten auf null setzen
//$codeWarteliste = null;
$codeWarteliste = 'gr1604_x';

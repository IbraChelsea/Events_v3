<?php

//NUR VERWENDEN/EINKOMMENTIEREN, WENN EINMALIG EINE ANDERE DATENBANK VERWENDET WERDEN SOLL
//ANSONSTEN KONFIGURATION IN ../inc/baseconfig.inc.php ANPASSEN!
//define('MYSQL_HOST', '');
//define('MYSQL_USER', '');
//define('MYSQL_PASSWORD', '');
//define('MYSQL_DATABASE', '');

include_once '../inc/baseconfig.inc.php';

//Kontakt-Telefon
define('SEMINAR_TELEFON', '0800 081 100');

//Kontakt-E-Mail
#define('SEMINAR_EMAIL', 'marketing.klagenfurt@ikea.com');
define('SEMINAR_EMAIL', 'ikea.austria@IKEA.com ');

//Überschrift des Bestätigungsmails
define('CONFIRMATION_SUBJECT', 'Deine Anmeldebestätigung für das IKEA Event.');

//Event-Codes dieses Seminars (wenn es mehrere Termine gibt: beliebig viele Elemente zum Array hinzufügen)
define('logpath','./eventlog.log');

//Name des Seminars, wird verwendet in <title>, Überschrift und Bestätigungsmail
define('SEMINAR_NAME', 'Haid Kochworkshop');

$eventGroups = array(
    array(
		'title' => 'Kochworkshop', // header (html encoded)
		'subtitle' => 'IKEA Einrichtungshaus Haid',
		'description' => 'Lass dich bei unserem Kochworkshop mit neuen Ideen inspirieren.', 
		'treffpunkt' => 'IKEA Einrichtungshaus Wien Nord, in der Abteilung Schlafzimmer Aufbewahrung im 1.Stock', 
		'codes' => array('hd161215','hd161215_1'),
		'codeWaitingList' => 'gr151002_x', // optional, Zeile ggf. auskommentieren/löschen
    )/*,
    array(
        'title' => 'Einrichtungsseminar Küchenplanung', // header (html-encoded)
         'subtitle' => 'im IKEA Einrichtungshaus Klagenfurt',
        'description' => "  Für die meisten von uns ist die Küche mehr als nur der Ort, an dem Speisen zubereitet werden. Und es gibt genauso viele unterschiedliche Küchen, wie es Menschen gibt.<br>
        Wir bei IKEA sind Experten für diesen Bereich und würden uns freuen, unsere Kenntnisse mit dir zu teilen.", // optional, html-encoded
        'treffpunkt' => 'In der Küchenabteilung',
        'codes' => array(
            'termin3',
			      'termin4',
        ),
        'codeWaitingList' => 'termin2_x', // optional, Zeile ggf. auskommentieren/löschen
    )*/
);
?>
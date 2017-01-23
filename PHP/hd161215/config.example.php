<?php

//NUR VERWENDEN/EINKOMMENTIEREN, WENN EINMALIG EINE ANDERE DATENBANK VERWENDET WERDEN SOLL
//ANSONSTEN KONFIGURATION IN ../inc/baseconfig.inc.php ANPASSEN!
//define('MYSQL_HOST', '');
//define('MYSQL_USER', '');
//define('MYSQL_PASSWORD', '');
//define('MYSQL_DATABASE', '');

include_once '../inc/baseconfig.inc.php';

//Name des Seminars, wird verwendet in <title>, Überschrift und Bestätigungsmail
define('SEMINAR_NAME', 'Einrichtungsseminare in Klagenfurt');

//Kontakt-Telefon
define('SEMINAR_TELEFON', '0810 081 081');

//Kontakt-E-Mail
#define('SEMINAR_EMAIL', 'marketing.klagenfurt@ikea.com');
define('SEMINAR_EMAIL', 'support@itando.net');

//Überschrift des Bestätigungsmails
define('CONFIRMATION_SUBJECT', 'Deine Anmeldebestätigung für das IKEA Event.');

define('logpath','var/log/familyEvent.log');
//Event-Codes dieses Seminars (wenn es mehrere Termine gibt: beliebig viele Elemente zum Array hinzufügen)
$eventGroups = array(
    array(
        'title' => 'Einrichtungsseminar zum Thema Bad', // header (html-encoded)
        'subtitle' => 'im IKEA Einrichtungshaus Klagenfurt',
        'description' => "  Das Badezimmer ist meist ein relativ kleiner Bereich bei uns zu Hause, aber auf der anderen Seite ist es doch ein sehr zentraler Bereich in dem wir jeden Morgen in den Tag starten und
          Abends unseren Tag beenden.<br>
          Wenn du also dein Bad zu einer Wohlfühl-Oase machen möchtest, dann hole dir Information und Inspiration bei unserem Seminar.", // optional, html-encoded
        'treffpunkt' => 'Badplanung in der Badezimmerabteilung',
        'codes' => array(
            'termin1',
			      'termin2',
        ),
        'codeWaitingList' => 'termin1_x', // optional, Zeile ggf. auskommentieren/löschen
    ),
    array(
        'title' => 'Einrichtungsseminar Küchenplanung', // header (html-encoded)
         'subtitle' => 'im IKEA Einrichtungshaus Klagenfurt',
        'description' => "  Für die meisten von uns ist die Küche mehr als nur der Ort, an dem Speisen zubereitet werden. Und es gibt genauso viele unterschiedliche Küchen, wie es Menschen gibt.<br>
        Wir bei IKEA sind Experten für diesen Bereich und würden uns freuen, unsere Kenntnisse mit dir zu teilen.", // optional, html-encoded
        'treffpunkt' => 'Küchenplanung in der Küchenabteilung',
        'codes' => array(
            'termin3',
			      'termin4',
        ),
        'codeWaitingList' => 'termin2_x', // optional, Zeile ggf. auskommentieren/löschen
    )
);

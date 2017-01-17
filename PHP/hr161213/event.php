<?php
error_reporting(E_ALL);

include_once 'config.php';
include_once '../inc/base.inc.php';



$termine = getEventTermine($eventCodes);

$termineVerfuegbar = false;
$bereitsAngemeldet = false;
foreach ($termine as $termin) {
    if ($termin['anmeldungmoeglich']) {
        $termineVerfuegbar = true;
    }
    
    if (hasGetValue('familynummer') AND !$bereitsAngemeldet) {
        $anmeldung = getAnmeldungByFamilynummerAndEventCode(getValueFromGet('familynummer'), $termin['code']);
        if ($anmeldung !== false) {
            $bereitsAngemeldet = true;
        }
    }
    
}

$personId = '';
if (array_key_exists('personid', $_GET) AND $_GET['personid'] != '') {
    $personId = (int) $_GET['personid'];
}

include_once('page.php');
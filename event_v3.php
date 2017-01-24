<?php
error_reporting(E_ALL);

$layout = "";

// TESTING
$layout = "v1";


if ($layout == "v2") {

    // *************************************
    // default v2 (AT - hd, wn, voe, gr)

    include_once 'config_v2.php';
    include_once 'inc/base.inc_v2.php';

    $eventGroups = getEventTermine($eventGroups);

    $termineVerfuegbar = false;
    $bereitsAngemeldet = false;
    $terminCount = 0;
    foreach ($eventGroups as $eventGroup) {
        foreach ($eventGroup['termine'] as $termin) {
            $terminCount++;
            
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
    }

    $personId = '';
    if (array_key_exists('personid', $_GET) AND $_GET['personid'] != '') {
        $personId = (int) $_GET['personid'];
    }
    include_once('layout.php');

} else {
    // *************************************
    // default v1 (hr, ro)
    include_once 'config_v1.php';
    include_once 'inc/base.inc_v1.php';



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

}

if ($layout == "v2") {
    include_once('page_v2.php');
} else {
    include_once('page_v1.php');
}


<?php
error_reporting(E_ALL);
include_once 'config.php';
include_once '../inc/base.inc.php';

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
?>
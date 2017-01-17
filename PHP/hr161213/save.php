<?php
error_reporting(E_ALL);

header('Content-Type: application/json');

include_once 'config.php';
include_once '../inc/base.inc.php';


$termine = getEventTermine($eventCodes);

$termineVerfuegbar = false;
foreach ($termine as $termin) {
    if ($termin['anmeldungmoeglich']) {
        $termineVerfuegbar = true;
    }
}

$data = saveTerminAnmeldung(array(
    'eventid' => getPostValue('termin'),
    'warteliste' => hasPostValue('warteliste'),
    'warteliste_code' => $codeWarteliste,
    'familynummer' => getPostValue('familynummer'),
    'vorname' => getPostValue('vorname'),
    'nachname' => getPostValue('nachname'),
    'email' => getPostValue('email'),
    'telefon' => getPostValue('telefon'),
    'begleitung' => getPostValue('begleitung'),
    'personid' => getPostValue('personid'),
    'geburtsdatum' => getPostValue('geburtsdatum'),
    'groupeventid' => getPostValue('groupeventid'),
));

if ($data['status'] != 'ok') {
    $data['termineVerfuegbar'] = $termineVerfuegbar;
    if ($termineVerfuegbar AND !is_null($data['event']) AND $data['event']['anzahlteilnehmer'] == ($data['event']['teilnehmerlimit'] - (getPostValue('begleitung') - 1)) AND getPostValue('begleitung') > 1) {
        $data['begleitungError'] = true;
    }
} else if ($data['status'] == 'ok' AND !hasPostValue('warteliste')) {
    sendConfirmationMail($data);
}

echo json_encode($data);
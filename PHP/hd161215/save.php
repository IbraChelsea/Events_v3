<?php
error_reporting(E_ALL);

header('Content-Type: application/json');

include_once 'config.php';
include_once '../inc/base.inc.php';

$results = array();

foreach($_POST as $key=>$rez){
	if($key == 'warteliste'){
		$results['warteliste_code'] = $rez;
	}else{
		$results[$key]=$rez;
	}		
	}
if($results['warteliste_code']){
	$results['warteliste'] = true;
}else{
	$results['warteliste'] = false;
}	

$data = saveTerminAnmeldung($results);


foreach($data['event'] as $key=>$events){
	if ($events['status'] != 'ok') {
    if ($events['anmeldungmoeglich'] AND $events['anzahlteilnehmer'] == ($events['teilnehmerlimit'] - (getPostValue('begleitung') - 1)) AND getPostValue('begleitung') > 1) {
        $data['event'][$key]['begleitungError'] = true;
    }
} else if ($events['status'] == 'ok' AND $events['anmeldung']['warteliste'] == '0') {
    sendConfirmationMail($events,$data);
}

}

echo json_encode($data);

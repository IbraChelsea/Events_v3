<?php

/**
 * DB-Adapter
 */
function getAdapter()
{
    static $pdo;
    if (is_null($pdo)) {
        $pdo = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DATABASE . ';charset=utf8', MYSQL_USER, MYSQL_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}


function writeToLog($eventType, $message)
{
    file_put_contents('eventlog.log', date('r') . "\t" . $eventType . "\t" . $message . "\r\n", FILE_APPEND);
}

/**
 * Events zu einer Liste von Event-Codes laden
 */
function getEventTermine(array $eventCodes)
{
    
    $termine = array();   
    $sql = "SELECT eventid, code, anmeldungvon, anmeldungbis, teilnehmerlimit, anzahlteilnehmer, eventdatum, status FROM event WHERE code=:code";
    $stmt = getAdapter()->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    foreach ($eventCodes as $eventCode) {
        $stmt->execute(array(':code' => $eventCode));
        $row = $stmt->fetch();

        if (!is_array($row)) {
            trigger_error('Unbekannter Event-Code: "' . $eventCode . '"', E_USER_ERROR);
        }
        
        $row['anmeldungmoeglich'] = (($row['teilnehmerlimit'] - $row['anzahlteilnehmer']) > 0) && (strtotime($row['anmeldungvon']) <= time()) && (strtotime($row['anmeldungbis']) > time()) && $row['status'] == '1';
        
        if (!(($row['teilnehmerlimit'] - $row['anzahlteilnehmer']) > 0)) {
            $row['anmeldestatus'] = 'full';
        }
        
        if (!(strtotime($row['anmeldungvon']) <= time())) {
            $row['anmeldestatus'] = 'notready';
        }
        
        if (!(strtotime($row['anmeldungbis']) > time())) {
            $row['anmeldestatus'] = 'expired';
        }
        
        if (!($row['status'] == '1')) {
            $row['anmeldestatus'] = 'disabled';
        }
        
        $termine[] = $row;
    }
    
    return $termine;
}

/**
 * Daten zu einem bestimmten Event laden
 */
function getEventByEventId($eventId, $neededSlots = 1)
{
    $sql = "SELECT eventid, code, anmeldungvon, anmeldungbis, teilnehmerlimit, anzahlteilnehmer, eventdatum, status FROM event WHERE eventid=:eventid";
    $stmt = getAdapter()->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute(array(':eventid' => $eventId));
    $termin = $stmt->fetch();
    if (!is_array($termin)) {
        trigger_error('Unbekannte Event-ID: "' . $eventId . '"', E_USER_ERROR);
    }
    
    $termin['anmeldungmoeglich'] = (($termin['teilnehmerlimit'] - $termin['anzahlteilnehmer']) > $neededSlots - 1) && (strtotime($termin['anmeldungvon']) <= time()) && (strtotime($termin['anmeldungbis']) > time()) && $termin['status'] == '1';

    if (!(($termin['teilnehmerlimit'] - $termin['anzahlteilnehmer']) > $neededSlots - 1)) {
        $termin['anmeldestatus'] = 'full';
    }
    
    if (!(strtotime($termin['anmeldungvon']) <= time())) {
        $termin['anmeldestatus'] = 'notready';
    }
    
    if (!(strtotime($termin['anmeldungbis']) > time())) {
        $termin['anmeldestatus'] = 'expired';
    }
    
    if (!($termin['status'] == '1')) {
        $termin['anmeldestatus'] = 'disabled';
    }

    return $termin;
}


/**
 * Wert für <input value="x"> auslesen (mit HTML-Escape)
 */
function getFormValueFromGet($name, $default = '')
{
    if (array_key_exists($name, $_GET)) {
		if (preg_match('/(?i)msie/',$_SERVER['HTTP_USER_AGENT'])) {
			//MW encoded UTF-8 URLs nicht korrekt - IE mag das nicht
			return htmlspecialchars(utf8_encode($_GET[$name]));
		} else {
			return htmlspecialchars($_GET[$name]);
		}
        
    }
    return $default;
}

function hasGetValue($name)
{
    return array_key_exists($name, $_GET);
}

function getValueFromGet($name)
{
    if (array_key_exists($name, $_GET)) {
        return $_GET[$name];
    }
    return '';
}

function hasPostValue($name)
{
    return array_key_exists($name, $_POST);
}

function getPostValue($name)
{
    if (hasPostValue($name)) {
        return trim($_POST[$name]);
    }
    
    return '';
}

/**
 * Feld ist read-only wenn per GET ein Wert übergeben wurde
 */
function isFieldReadOnly($name)
{
    if (!array_key_exists($name, $_GET)) {
        return '';
    }
    
    if (trim($_GET[$name]) == '') {
        return '';
    }
    
    return 'readonly';
}

/**
 * Anmeldung zu einem Termin (oder Warteliste) mit Standardfeldern speichern.
 * @returns array(
        'status' => 'ok' | 'full' | 'expired' | 'notready' | 'disabled' | 'duplicate' | 'error',
        'event' => NULL | array(
            'eventid', 'code', 'anmeldungvon', 'anmeldungbis', 'teilnehmerlimit', 'anzahlteilnehmer', 'eventdatum', 'status' |
        ),
        'anmeldung' => NULL | array(
            'anmeldungid', 'eventid', 'code', 'warteliste', 'familynummer', 'personid', 'vorname', 'nachname', 'email', 'telefon', 'anmeldedatum', 'ip'
        )
   )
 */
function saveTerminAnmeldung(array $data)
{
    //die('seronja');
    $result = array(
        'status' => 'error',
        'event' => null,
        'anmeldung' => null,
    );
    //die('2');
    $db = getAdapter();
    $db->beginTransaction();
    try {
        //die('krepaj');
			$eventId = null;
            $db->exec('LOCK TABLES event WRITE, anmeldung WRITE');
            $event = getEventByEventId($data['eventid']);
            $result['event'] = $event;
            $eventId = $event['eventid'];
            $code = $event['code'];
        $anmeldungOld = getAnmeldungByFamilynummerAndGroupEventCode($data['familynummer'], $data['groupeventid']);
        //die(print_r($data, 1));
        if (($data['warteliste'] || $event['anmeldungmoeglich']) AND $anmeldungOld === false) {
            //you're in!
            
            $stmt = $db->prepare('INSERT INTO anmeldung (eventid, code, warteliste, familynummer, personid, vorname, nachname, geburtsdatum, email, telefon, begleitung, anmeldedatum, ip) VALUES (:eventid, :code, :warteliste, :familynummer, :personid, :vorname, :nachname, :geburtsdatum, :email, :telefon, :begleitung, NOW(), :ip)');
            $stmt->execute(
                array(
                    ':eventid' => $eventId,
                    ':code' => $code,
                    ':warteliste' => $data['warteliste'],
                    ':familynummer' => $data['familynummer'],
                    ':personid' => (array_key_exists('personid', $data) AND $data['personid'] != '') ? $data['personid'] : null,
                    ':vorname' => $data['vorname'],
                    ':nachname' => $data['nachname'],
                    ':geburtsdatum' => (array_key_exists('geburtsdatum', $data) && strlen($data['geburtsdatum']) > 0 ? $data['geburtsdatum'] : null),
                    ':email' => $data['email'],
                    ':telefon' => $data['telefon'],
                    ':begleitung' => $data['begleitung'],
                    ':ip' => $_SERVER['REMOTE_ADDR'],
                )
            );
            
            $anmeldungId = $db->lastInsertId();
            
            if (!$data['warteliste']) {
                //teilnehmerzahl erhöhen
                $stmt = $db->prepare('UPDATE event SET anzahlteilnehmer=CASE WHEN anzahlteilnehmer + :begleitung > teilnehmerlimit THEN teilnehmerlimit ELSE anzahlteilnehmer + :begleitung END WHERE eventid=:eventid');
                $stmt->execute(array(':begleitung' => $data['begleitung'], ':eventid' => $eventId));
            }
            
            $stmt = $db->prepare('SELECT * FROM anmeldung WHERE anmeldungid=:anmeldungid');
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute(array(':anmeldungid' => $anmeldungId));
            
            $result['anmeldung'] = $stmt->fetch();
            $result['status'] = 'ok';
            writeToLog('INFO', 'Saved regstration for ' . $data['familynummer'] . ' for event ' . $code);
        } else {
            if (array_key_exists('anmeldestatus', $event)) {
                $result['status'] = $event['anmeldestatus'];
            } else {
                $result['status'] = 'duplicate';
                $result['anmeldung'] = $anmeldungOld;
            }
            writeToLog('INFO', 'Registration blocked for ' . $data['familynummer'] . ' for event ' . $code);
        }
        $db->exec('UNLOCK TABLES');
        $db->commit();

    } catch (PDOException $e) {
        $db->rollBack();
        $db->exec('UNLOCK TABLES');
        $result['status'] = 'error';
        writeToLog('ERROR', 'Error saving regstration for ' . $data['familynummer'] . ' for event ' . $code . ': ' . $e->getMessage());
    }
    
    return $result;
}

function getAnmeldungByFamilynummerAndEventCode($familynummer, $eventCode)
{
    $sql = "SELECT anmeldung.*, event.eventdatum FROM anmeldung LEFT JOIN event ON event.eventid=anmeldung.eventid WHERE anmeldung.familynummer=:familynummer AND anmeldung.code=:eventcode";
    $stmt = getAdapter()->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute(array(':familynummer' => $familynummer, ':eventcode' => $eventCode));
    $anmeldung = $stmt->fetch();
    return $anmeldung;
}
function getAnmeldungByFamilynummerAndGroupEventCode($familynummer, $groupCode)
{
    $sql = "SELECT anmeldung.*, event.eventdatum FROM anmeldung LEFT JOIN event ON event.eventid=anmeldung.eventid WHERE anmeldung.familynummer='".$familynummer."' AND event.eventgroupcode='".$groupCode."'";
    $stmt = getAdapter()->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $anmeldung = $stmt->fetch();
    return $anmeldung;
}

function sendConfirmationMail(array $data)
{
    require_once '../inc/Swift/swift_required.php';
    
    if (APPLICATION_ENV == 'development') {
        $transport = Swift_SmtpTransport::newInstance('192.168.5.11', 25);
    } else {
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
    }
    
    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance(CONFIRMATION_SUBJECT);
    $message->setFrom(array('noreply@ikea-family.net' => 'IKEA FAMILY Hrvatska'));
    $message->setTo(array($data['anmeldung']['email'] => $data['anmeldung']['vorname'] . ' ' . $data['anmeldung']['nachname']));
    
    $termin = date('d.m.Y', strtotime($data['event']['eventdatum'])) . ' u ' . date('H:i', strtotime($data['event']['eventdatum']));
    
    ob_start();
    include 'email_confirmation_html.php';
    $body = ob_get_contents();
    ob_end_clean();
    
    ob_start();
    include 'email_confirmation_text.php';
    $text = ob_get_contents();
    ob_end_clean();
    
    $message->addPart($body, 'text/html');
    $message->addPart($text, 'text/plain');
    
    $result = $mailer->send($message);
    if ($result) {
        writeToLog('INFO', 'Sent confirmation mail to ' . $data['anmeldung']['email']);
    } else {
        writeToLog('WARN', 'Cannot send mail to ' . $data['anmeldung']['email']);
    }
    
}

function handleRuntimeError($errno, $errstr, $errfile, $errline) {
    if ($_SERVER['SCRIPT_NAME'] == 'save.php') {
        echo json_encode(array('status' => 'error'));
    }
    writeToLog('ERROR', $errstr . ' in ' . $errfile . ' on line ' . $errline);
    die();
}

function handleException($e)
{
    handleRuntimeError(null, $e->getMessage(), $e->getFile(), $e->getLine());
}

set_error_handler('handleRuntimeError');
set_exception_handler('handleException');


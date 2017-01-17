<?
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
$select_query = "select concat(\"'\",familynummer) familynummer, vorname, nachname, email, concat(\"'\",telefon) telefon, begleitung,
    case
      when warteliste = 0 then 'nein'
      when warteliste = 1 then 'ja'
    end warteliste,
    anmeldedatum
from `anmeldung`
where eventid IN (select eventid from event where code = :code)";

include_once('./config.php');
include_once '../inc/base.inc.php';
?>
<html>
<body>
  <?

      foreach($eventCodes as $code){
          echo "<div>Teilnehmerliste für das Event $code</div>";
          echo "<div>&nbsp;</div>";
        $stmt = getAdapter()->prepare($select_query);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute(array(':code' => $code));
  ?>
  <table>
    <tr>
      <th>Familynummer</th>
      <th>Vorname</th>
      <th>Namename</th>
      <th>Email</th>
      <th>Telefon</th>
      <th>Begleitung</th>
      <th>Warteliste</th>
      <th>Anmeldedatum</th>
    </tr>
  <?
        while($anmeldung = $stmt->fetch()){
          echo "<tr>";
          foreach($anmeldung as $person){
            echo "<td>";
            echo $person;
            echo "</td>";
          }
          echo "</tr>";
        } ?>

  </table>
  <?
    }
?>
</body>
</html>

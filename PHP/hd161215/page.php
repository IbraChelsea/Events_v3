<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>
            IKEA <?= SEMINAR_NAME; ?>
        </title>
        <script src="../js/dojo/dojo/dojo.js" data-dojo-config="async: false"></script>
        <script type="text/javascript">
            var termineVerfuegbar = <?= $termineVerfuegbar ? 'true' : 'false'; ?>;
            var personId = '<?= $personId; ?>';
            var bereitsAngemeldet = <?= $bereitsAngemeldet ? 'true' : 'false'; ?>;
        </script>
        <script src="../js/default.js"></script>
        <link rel="stylesheet" href="../js/dojo/dijit/themes/claro/claro.css" media="screen">
        <link rel="stylesheet" type="text/css" href="../css/default.css" />
        <link rel="stylesheet" type="text/css" href="css/custom.css" />

    </head>
    <body class="claro">
        <center>
            <div id="wrap">
                <div id="header">
                    <div id="familylogo">
                        <a href="http://www.ikea.at/family" target="_blank" style="border:none; outline:none; text-decoration:none;">
                            <img id="familylogo" class="familylogo" src="images/ikea_family_logo.gif" border="0" style="border:none;">
                        </a>
                    </div>
                    <div id="ikealogo">
                        <a href="http://www.ikea.com/at/de/" target="_blank" style="border:none; outline:none; text-decoration:none;">
                            <img id="ikealogo" src="images/ikea_logo.gif" border="0" style="border:none;">
                        </a>
                    </div>
                    <div id="headline">
                        <h1>Anmeldung</h1>
                    </div>
                    <div id="introtext">
                        <h2><?= SEMINAR_NAME; ?><br />Begrenzte Teilnehmeranzahl.</h2>
                        <p>*Deine Daten werden NICHT an Dritte weitergegeben und nur intern genutzt.</p>
                    </div>
                </div>
                <form id="form" action="" onsubmit="return sendForm();">
                    <div data-dojo-type="dijit/form/Form" id="content">
                        <div id="termine_wrapper" class="labelSpacing">
                            <div style="display: none; opacity: 0; margin: 0px 30px 10px 30px; border: 1px solid #FF7E28; padding: 6px;" class="anmeldungError errorMarker" id="error_anderertermin">
                                Leider sind hier schon alle Plätze vergeben. Es sind noch Anmeldungen zu einem anderen Termin möglich.
                            </div>
                            <div style="display: none; opacity: 0; margin: 0px 30px 10px 30px; border: 1px solid #FF7E28; padding: 6px;" class="anmeldungError errorMarker" id="error_alleterminevoll">
                                Leider wurden in der Zwischenzeit schon alle Plätze vergeben.
                            </div>
<?php
if (!$termineVerfuegbar):
?>
                            <div style="margin: 0px 30px 10px 30px; border: 1px solid #FF7E28; padding: 6px;" class="anmeldungError errorMarker" id="error_alleterminevoll">
                                Leider sind schon alle Plätze vergeben.
                            </div>
<?php
endif;

foreach ($eventGroups as $eventGroup):

?>
                            <div class="event_thema">
                                <h2>
                                    <?= $eventGroup['title']; ?>
                                </h2>
                                <p>
                                    <?= $eventGroup['description']; ?>
                                </p>
                                <div class="termine">
    <?php
    $i = 0;
    foreach ($eventGroup['termine'] as $termin):
        $i++;
    ?>
                                    <div class="termin" style="float: left;">
                                        <input data-dojo-type="dijit/form/RadioButton" type="radio" onclick="checkDates('<?= date('d.m.Y H:i', strtotime($termin['eventdatum'])); ?>','termin-<?=$termin['eventid'];?>');" style="vertical-align:top;height:18px;" required name="termin_<?= $eventGroup['title']; ?>" class="popRadio" id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>"id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>" <?= ($terminCount == 1 AND $termin['anmeldungmoeglich']) ? 'checked ' : ''; ?><?= !$termin['anmeldungmoeglich'] ? 'disabled="disabled" title="Anmeldung nicht mehr möglich"' : ''; ?> />
                                        <span id="sdtermin-<?= $termin['eventid']; ?>" style="padding-right:10px;font-weight:bold;line-height:22px;<?= $termin['anmeldungmoeglich'] ? '' : 'text-decoration: line-through;'; ?>">
                                            <label for="termin-<?= $termin['eventid']; ?>" id="termin-<?= $termin['eventid']; ?>">
                                                <?= date('d.m.Y H:i', strtotime($termin['eventdatum'])); ?>
                                            </label>
                                        </span>
                                        <span style="padding-right:15px;line-height:22px;margin-top:3px;">
                                            <span id="stermin-<?= $termin['eventid']; ?>" style="color:<?= $termin['anmeldungmoeglich'] ? 'green' : 'red'; ?>; font-weight:bold;">
                                                <?= $termin['teilnehmerlimit'] - $termin['anzahlteilnehmer']; ?> Plätze frei
                                            </span> 
                                            von <?= $termin['teilnehmerlimit']; ?>
                                        </span>
                                    </div>
                                    
                                    <div class="labelSpacing wartelisteboxclass tergr_<?= $eventGroup['title']; ?>" style="clear: both; margin-left: 30px; margin-top: 5px; margin-bottom: 5px; <?php if($termin['teilnehmerlimit'] - $termin['anzahlteilnehmer'] != 0){echo 'display:none;';} ?>" id="warteliste_box_<?=$i; ?>">
                                    <input data-dojo-type="dijit/form/CheckBox" type="checkbox" name="interesse[]" id="interesse_<?= $eventGroup['codeWaitingList']."_".$i; ?>" class="popCheck interesse" value="termin_<?= $termin['eventid']; ?>" />
                                      <label for="interesse_<?= $eventGroup['codeWaitingList']; ?>">Bitte setzt mich auf die Warteliste</label>
                                     </div>
                                     <br/><br/>
       <?php 
    endforeach;
    ?>
                                </div>
                                
                            </div>
<?php
endforeach;
?>
                        </div>
                        <div class="labelSpacing">
                            <label for="perknr">IKEA FAMILY Mitgliedsnummer*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required data-dojo-props="regExp:'627598021(\\d){10}', invalidMessage:'Deine Family-Nummer ist ungültig. Bitte überprüfe deine Eingabe!', missingMessage:'Bitte gib deine Family-Nummer ein!'" type="text" name="familynummer" id="familynummer" maxlength="50" size="20" class="popInput" value="<?= getFormValueFromGet('familynummer'); ?>" <?= isFieldReadOnly('familynummer'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label class="labelSpacing" for="vorname">Vorname*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required type="text" data-dojo-props="propercase: true" name="vorname" id="vorname" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('vorname'); ?>" <?= isFieldReadOnly('vorname'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label for="nachname">Name*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required type="text" data-dojo-props="propercase: true" name="nachname" id="nachname" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('nachname'); ?>" <?= isFieldReadOnly('nachname'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label for="email">E-Mail-Adresse*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required data-dojo-props="lowercase: true, regExp:'[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?', invalidMessage:'Deine E-Mail-Adresse ist ungültig. Bitte überprüfe deine Eingabe!', missingMessage:'Bitte gib deine E-Mail-Adresse ein!'" type="text" name="email" id="email" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('email'); ?>" <?= isFieldReadOnly('email'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label for="telefon">Telefonnummer*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required type="text" name="telefon" id="telefon" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('telefon'); ?>"/>
                        </div>
                        <div class="labelSpacing">
                            <label>Ich komme mit Begleitung:*</label>
                            <input data-dojo-type="dijit/form/RadioButton" required type="radio" name="begleitung" id="begleitung-2" class="popRadio" style="vertical-align:top;height:18px;" value="2" /> <label for="begleitung-2" style="padding-right:15px; line-height:22px;">Ja</label>
                            <input data-dojo-type="dijit/form/RadioButton" required type="radio" name="begleitung" id="begleitung-1" class="popRadio" style="vertical-align:top;height:18px;" value="1" checked /> <label for="begleitung-1" style="line-height:22px;">Nein</label>
                        </div>
                    </div>
                    <div id="buttonline">
                        <input class="button" type="image" src="images/btn_absenden.gif" width="166" height="22" alt="Anmeldung absenden" />
                    </div>
                </form>
                <div id="success_message" style="display: none; opacity: 0; margin: 50px;">
                   
                </div>
                <div id="success_warteliste_message" style="display: none; opacity: 0; margin: 50px;">
                  
                </div>
                <div id="anmeldung_info" style="display: none; opacity: 0; margin: 50px;">
                    <strong>Wir haben schon deine Anmeldung für dieses Event erhalten!
                    <br /><br />
                    Du bist zu folgendem Termin angemeldet:
<?php
if (isset($anmeldung) AND is_array($anmeldung)):
?>
                    <?= date('d.m.Y H:i', strtotime($anmeldung['eventdatum'])); ?>
<?php
endif;
?>
                Uhr<strong></div>
                <div id="bereits_angemeldet" style="display: none; opacity: 0; margin: 50px;">
                   
                    <br /><br />
                 <!--    Du bist bereits zu folgendem Termin angemeldet: <span id="bereits_angemeldet_termin"> Uhr</span><strong> --> 
                </div>
            </div>
        </center>
    </body>
</html>
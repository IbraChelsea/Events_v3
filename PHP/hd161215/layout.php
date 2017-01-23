<?php

include_once 'config.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title> IKEA <?= SEMINAR_NAME; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/dojo/dojo/dojo.js" data-dojo-config="async: false"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <script type="text/javascript" src ="../js/jquery.js"></script>
<script type="text/javascript">
var termineVerfuegbar = <?= $termineVerfuegbar ? 'true' : 'false'; ?>;
var personId = '<?= $personId; ?>';
var bereitsAngemeldet = <?= $bereitsAngemeldet ? 'true' : 'false'; ?>;
</script>
        <script type="text/javascript" src ="../js/jquery-validator.js"></script>
    </head>
    <body>
        <div class="ws_form">
            <div class="container">
                <div class="header" style="height:60px;margin-top:15px;margin-bottom:15px;">
                  <a href="http://link.ikea-austria.at/p1187"><img src="images/ikea_family.jpg" class="family" alt="IKEA FAMILY" width="130" height="54" border="0" style="display:block;float:left;padding-left:10px;" /></a>
                  <img src="images/ikea_logo.jpg" class="ikea" alt="IKEA" width="160" height="55" border="0" style="display:block;float:right;padding-right:10px;" />
                </div>
                <!--<?include 'header.php'?>-->
                <h1 style="clear:both;"><?=SEMINAR_NAME?></h1>
                                    <form name="form" method="POST" id="form" onsubmit="return sendForm();">
                            <div id="termine_wrapper" class="labelSpacing"></div>
                            <div style="display: none;" class="anmeldungError errorMarker" id="error_anderertermin">
                                Leider sind hier schon alle Plätze vergeben. Es sind noch Anmeldungen zu einem anderen Termin möglich.
                            </div>
                            <div style="display: none" class="anmeldungError errorMarker" id="error_alleterminevoll">
                                Leider wurden in der Zwischenzeit schon alle Plätze vergeben.
                            </div>
<?php
if (!$termineVerfuegbar):
?>
                                <div class="anmeldungError errorMarker" id="error_alleterminevoll">
                                Leider sind schon alle Plätze vergeben.
                            </div>
<?php
endif;
foreach ($eventGroups as $eventGroup):

    
?>
                <div class="ws_wrapper">
                    <h2><?= $eventGroup['title']; ?></h2>
                    <h3><?= $eventGroup['subtitle']; ?></h3>
                    <div class="ws_teaser">
                    <?= $eventGroup['description']; ?>
                    </div>
<?php
$i = 0;
foreach ($eventGroup['termine'] as $termin):
    $i++;
?>
                    <div class="ws_events_container">
                        <div class="ws_event">

                          <input type="radio" name="termin_<?= $eventGroup['title']; ?>" onclick="checkDates('<?= date('d.m.Y H:i', strtotime($termin['eventdatum'])); ?>','termin-<?=$termin['eventid'];?>');" id="rtermin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>" <?= ($terminCount == 1 AND $termin['anmeldungmoeglich']) ? 'checked ' : ''; ?><?= !$termin['anmeldungmoeglich'] ? 'disabled="disabled" title="Anmeldung nicht mehr möglich"' : ''; ?> >

                          <span class="small" id="sdtermin-<?= $termin['eventid']; ?>" style="<?= $termin['anmeldungmoeglich'] ? '' : 'text-decoration: line-through;'; ?>">
                              <label for="termin-<?= $termin['eventid']; ?>" id="termin-<?= $termin['eventid']; ?>">
                                <?= date('d.m.Y H:i', strtotime($termin['eventdatum'])); ?>
                              </label>
                          </span>
                          <div class="break">
                            <span class="bold_paddingleft sold small" id="stermin-<?= $termin['eventid']; ?>" style="color:<?= $termin['anmeldungmoeglich'] ? 'green' : 'red'; ?>; font-weight:bold;">
                              <?= $termin['teilnehmerlimit'] - $termin['anzahlteilnehmer']; ?> Plätze frei
                            </span>
                            <span class="small">
                              von <?= $termin['teilnehmerlimit']; ?>
                            </span>
                          </div>

                        </div>
                        <div class="ws_event wl tergr_<?= $eventGroup['title']; ?>" style="<?php if($termin['teilnehmerlimit'] - $termin['anzahlteilnehmer'] != 0){echo 'display:none;';} ?>" id="warteliste_box_<?=$i; ?>">
                            <input type="checkbox" name="interesse[]" id="wtermin_<?= $termin['eventid']; ?>" class="popCheck interesse" value="termin_<?= $termin['eventid']; ?>">
                             Bitte setzt mich auf die Warteliste
                        </div>
                    </div>
<?php 
endforeach;
?>
                </div>
<?php
endforeach;
?>

                <div class="ws_wrapper_form">
                    <div class="ws_error"></div>
                    <div class="left margin">Mitgliedsnummer *</div>    <div class="right margin"><input type="text" value="<?=isset($_GET['familynummer'])?$_GET['familynummer']:''?>" name="familynummer" id="familynummer" <?=isset($_GET['familynummer'])?'readonly':''?>></div>
                        <div class="left margin">Vorname *</div>            <div class="right margin"><input type="text" value="<?=isset($_GET['vorname'])?$_GET['vorname']:''?>" name="vorname" id="vorname" <?=isset($_GET['vorname'])?'readonly':''?>></div>
                        <div class="left margin">Nachname *</div>           <div class="right margin"><input type="text" value="<?=isset($_GET['nachname'])?$_GET['nachname']:'"'?>" name="nachname"  id="nachname" <?=isset($_GET['nachname'])?'readonly':''?>></div>
                        <div class="left margin">E-Mail-Adresse *</div>     <div class="right margin"><input type="text" value="<?=isset($_GET['email'])?$_GET['email']:''?>" name="email"  id="email" <?=isset($_GET['email'])?'readonly':''?>></div>
                        <input type="hidden" value="<?=isset($_GET['personid'])?$_GET['personid']:''?>" name="personid"  id="personid" readonly/>
                        <div class="left margin">Telefonnummer *</div>      <div class="right margin"><input type="text" value="" name="telefon" id="telefon"></div>
                        <div style="clear:both;">&nbsp;</div>
                        <!--<div class="full margin">Ich komme mit Begleitung: * <span class="inp"><input type="radio" name="begleitung" id="begleitung-2" value="2" checked> Ja, ich komme mit einer Begleitperson <input type="radio" name="begleitung" id="begleitung-1" value="1"> Nein, ich komme allein </span></div>-->
                        <div class="left margin">Ich komme mit Begleitung: *</div>
                        <div>
                          <span>
                            <input type="radio" name="begleitung" id="begleitung-2" value="2" > Ja, ich komme mit einer Begleitperson<div class="break"></div>
                            <input type="radio" name="begleitung" id="begleitung-1" value="1" checked> Nein, ich komme allein
                          </span>
                        </div>


                        <div class="full margin sub"><input type ="button" value="Anmeldung absenden" class="btn" onclick = "validate()"></div>
                        <div class="full margin small">* Pflichtfeld</div>
                </div>
                    </form>
                                         </div>
                                        </div>
                <!--</div>
        </div>      -->
    </body>
</html>

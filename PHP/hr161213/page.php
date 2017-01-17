<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title><?= SEMINAR_NAME; ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="../js/dojo/dojo/dojo.js" data-dojo-config="async: false, locale: 'hr'"></script>
        <script type="text/javascript">
            var termineVerfuegbar = <?= $termineVerfuegbar ? 'true' : 'false'; ?>;
            var personId = '<?= $personId; ?>';
            var bereitsAngemeldet = <?= $bereitsAngemeldet ? 'true' : 'false'; ?>;
        </script>
        <script src="../js/default.js?v6"></script>
        <link rel="stylesheet" href="../js/dojo/dijit/themes/claro/claro.css" media="screen">
        <link rel="stylesheet" type="text/css" href="../css/default.css" />
        <link rel="stylesheet" type="text/css" href="css/custom.css" />
    </head>
	
	<!-- xxx -->

    <body class="claro">
        <center>
            <div id="wrap">
                <div id="header">
                    <div id="familylogo">
                        <a href="http://www.ikea.com/ms/hr_HR/ikea_family/index2.html" target="_blank" style="border:none; outline:none; text-decoration:none;">
                            <img id="familylogo" class="familylogo" src="images/ikea_family_logo.gif" border="0" style="border:none;">
                        </a>
                    </div>
                    <div id="ikealogo">
                        <a href="http://www.ikea.com/hr/hr/" target="_blank" style="border:none; outline:none; text-decoration:none;">
                            <img id="ikealogo" src="images/ikea_logo.gif" border="0" style="border:none;">
                        </a>
                    </div>
                    <div id="headline">
                        <h1>Registracija</h1>
                    </div>
                    <div id="introtext">
                        <h2><?= SEMINAR_NAME; ?></h2>
                        <p><?= SEMINAR_DESCRIPTION; ?></p>
                        <p>*Osobni se podaci neće dijeliti s trećim stranama. Koristit će se isključivo za interne potrebe tvrtke IKEA Hrvatska d.o.o. za trgovinu.</p>
                    </div>
                </div>
                <form id="form" action="" onsubmit="return sendForm();">
                    <div data-dojo-type="dijit/form/Form" id="content">
                        <div id="termine_wrapper" class="labelSpacing">
                            <div style="display: none; opacity: 0; margin: 0px 30px 10px 30px; border: 1px solid #FF7E28; padding: 6px;" class="anmeldungError errorMarker" id="error_anderertermin">
                                Termin je popunjen. Registrirajte se za drugi termin.
                            </div>
                            <div style="display: none; opacity: 0; margin: 0px 30px 10px 30px; border: 1px solid #FF7E28; padding: 6px;" class="anmeldungError errorMarker" id="error_alleterminevoll">
                                Nažalost, završile su prijave za radionice.
                            </div>
<?php
if (!$termineVerfuegbar):
?>
                            <div style="margin: 0px 30px 10px 30px; border: 1px solid #FF7E28; padding: 6px;" class="anmeldungError errorMarker" id="error_alleterminevoll">
                                Nažalost, završile su prijave za radionice.
                            </div>
<?php
endif;
?>



                            <label><?= count($termine) > 1 ? 'Datum' : 'Datum'; ?>*</label><br />
<?php
$i = 0;
foreach ($termine as $termin):
$i++;
?>
                            <input data-dojo-type="dijit/form/RadioButton" style="vertical-align:top;height:18px;" type="radio" required name="termin" class="popRadio" id="termin-<?= $termin['eventid']; ?>" value="<?= $termin['eventid']; ?>" <?= (count($termine) == 1 AND $termin['anmeldungmoeglich']) ? 'checked ' : ''; ?><?= !$termin['anmeldungmoeglich'] ? 'disabled="disabled" title="Nu te mai poti înregistra"' : ''; ?> />
                            <span style="padding-right:10px;font-weight:bold;line-height:22px;<?= $termin['anmeldungmoeglich'] ? '' : 'text-decoration: line-through;'; ?>">
                                <label for="termin-<?= $termin['eventid']; ?>">
                                    <?= date('d.m.Y', strtotime($termin['eventdatum'])); ?> od <?= date('H:i', strtotime($termin['eventdatum'])); ?>
                                </label>
                            </span>
                            <span style="padding-right:15px;line-height:22px;margin-top:3px;">
                                <span style="color:<?= $termin['anmeldungmoeglich'] ? 'green' : 'red'; ?>; font-weight:bold;">
								, slobodno <?= $termin['teilnehmerlimit'] - $termin['anzahlteilnehmer']; ?> mjesta od ukupno
                                </span><?= $termin['teilnehmerlimit']; ?>
                            </span>
                            <br />
<?php
endforeach;
?>
                        <!--<div class="labelSpacing" style="margin-left: 30px; margin-top: 5px; margin-bottom: 5px;" id="warteliste_box">
                            <input data-dojo-type="dijit/form/CheckBox" type="checkbox" name="interesse" id="interesse" class="popCheck" value="1" />
                              <label for="interesse">&nbsp;Toate locurile sunt ocupate? Aş dori să primesc informaţii despre următorul <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;workshop de mobilare şi decorare a casei.</label>
                        </div>-->
                        <input type="hidden" name="interesse" value="1" />
						<input type="hidden" id="groupeventid" name="groupeventid" value="<?= GROUP_NAME; ?>" />
                        </div>

                        <div class="labelSpacing">
                            <label for="perknr">Broj IKEA FAMILY kartice*</label><br />
                            <input maxlength="19" data-dojo-type="dijit/form/ValidationTextBox" required data-dojo-props="regExp:'627598047(\\d){10}', invalidMessage:'Unesi posljednjih 10 znamenki tvoje IKEA FAMILY kartice.', missingMessage:'Unesite broj IKEA FAMILY kartice!'" type="text" name="familynummer" id="familynummer" maxlength="50" size="20" class="popInput" value="<?= getFormValueFromGet('familynummer', '627598047'); ?>" <?= isFieldReadOnly('familynummer'); ?>/>
                        </div>

                        <div class="labelSpacing">
                            <label class="labelSpacing" for="vorname">Ime*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required type="text" data-dojo-props="propercase: true" name="vorname" id="vorname" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('vorname'); ?>" <?= isFieldReadOnly('vorname'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label for="nachname">Prezime*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required type="text" data-dojo-props="propercase: true" name="nachname" id="nachname" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('nachname'); ?>" <?= isFieldReadOnly('nachname'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label for="nachname">Datum rođenja*</label><br />
                            <input data-dojo-type="dijit/form/DateTextBox" required placeholder="DD.MM.GGGG" type="text" name="geburtsdatum" id="geburtsdatum" value="<?= getFormValueFromGet('geburtsdatum'); ?>" <?= isFieldReadOnly('geburtsdatum'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label for="email">Adresa e-pošte*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required data-dojo-props="lowercase: true, regExp:'[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?', invalidMessage:'Email adresa nije važeća!', missingMessage:'Potrebna je ova vrijednost!'" type="text" name="email" id="email" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('email'); ?>" <?= isFieldReadOnly('email'); ?> />
                        </div>
                        <div class="labelSpacing">
                            <label for="telefon">Broj mobitela*</label><br />
                            <input data-dojo-type="dijit/form/ValidationTextBox" required type="text" name="telefon" id="telefon" maxlength="50" size="30" class="popInput" value="<?= getFormValueFromGet('telefon'); ?>"/>
                        </div>
			<?php if(SHOW_BEGLEITUNG == 'YES') { ?>
                        <div class="labelSpacing">
                            <label>Dolaziš li s više djece:*</label>
                            <input data-dojo-type="dijit/form/RadioButton" required type="radio" name="begleitung" id="begleitung-2" class="popRadio" style="vertical-align:top;height:18px;" value="2" /> <label for="begleitung-2" style="padding-right:15px; line-height:22px;">Da</label>
                            <input data-dojo-type="dijit/form/RadioButton" required type="radio" name="begleitung" id="begleitung-1" class="popRadio" style="vertical-align:top;height:18px;" value="1" checked /> <label for="begleitung-1" style=" line-height:22px;">Ne</label>
                        </div>
			<?php } ?>
                    </div>
                    <div id="buttonline">
                        <input class="button" type="image" src="images/btn_absenden.gif" width="166" height="22" alt="Înregistrare" />
                    </div>
                </form>
                <div id="success_message" style="display: none; opacity: 0; margin: 50px;">
                    <strong>Registracija uspješno obavljena. Veselimo se susretu! <br>IKEA Family tim</strong>
                </div>
                <div id="success_warteliste_message" style="display: none; opacity: 0; margin: 50px;">
                    <strong>Hvala Vam. Zahtjev za registraciju je zaprimljen.</strong>
                </div>
                <div id="anmeldung_info" style="display: none; opacity: 0; margin: 50px;">
  <strong>Već si registriran za ovu IKEA FAMILY radionicu.
                    <br /><br />
					Za promjenu tremina, pošalji nam poruku e-pošte na IKEAFAMILY.radionice@IKEA.com.
                    <br /><br />
					IKEA Family tim
                <strong></div>
                <div id="bereits_angemeldet" style="display: none; opacity: 0; margin: 50px;">
                      <strong>Već si registriran za ovu IKEA FAMILY radionicu.
                    <br /><br />
					Za promjenu tremina, pošalji nam poruku e-pošte na IKEAFAMILY.radionice@IKEA.com.
                    <br /><br />
					IKEA Family tim
                <strong>
                </div>
            </div>
        </center>
    </body>
</html>

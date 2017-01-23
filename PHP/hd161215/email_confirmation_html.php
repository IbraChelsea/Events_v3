<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?= CONFIRMATION_SUBJECT; ?></title>
    </head>
    <body>
		<br>
        Vielen Dank für deine Anmeldung.
        <br>
        Wir freuen uns auf deinen Besuch und hoffen, dass dir das Seminar <?= $name; ?> gefallen wird.
        <br>
        <br>
        Terminbestätigung: <?= $termin; ?> Uhr
        <br><br>
        Treffpunkt: <?= $treffpunkt; ?>
        <br>
        <br>
        Solltest du unerwartet keine Zeit haben, dann gib uns bitte telefonisch oder per E-Mail Bescheid:
        <br>
        Tel.: <?= SEMINAR_TELEFON; ?>
        <br>
        E-Mail: <?= SEMINAR_EMAIL; ?>
        <br>
        <br>
        Dein IKEA FAMILY Team
    </body>
</html>
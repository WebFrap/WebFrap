<h1>Caches</h1>

<p>
Da die Möglichkeit besteht, Daten aus Browsercaches auszulesen, und es genug Spionagetools gibt
die davon regen Gebraucht machen, ist penibel darauf zu achten, dass bei sensiblen Daten
entsprechende No-Cache und No-Proxy Header gesetzt werden. <br />
Letztere sollten eigenlich überflüssig sein wenn wie gefordert eine sichere End-to-End 
Verschlüsselung implementiert wurde, aber es schadet nichts.
</p>

<img src="./images/buiz_guidance/sec/browser_cache.png" alt="Browser Cache" />

<p>Setzen der korrekten Header</p>

<?php start_highlight(); ?>
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Datum in der Vergangenheit
<?php display_highlight( 'php' ); ?>

<p>Setzen der Meta Tags</p>
<?php start_highlight(); ?>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<?php display_highlight( 'xml' ); ?>

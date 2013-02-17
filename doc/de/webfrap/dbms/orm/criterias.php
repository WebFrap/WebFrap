<h1>Criterias</h1>

<p>
Criterias haben primär die Aufgabe das Zusammenbauen von dynamischen
Queries zu vereinfachen.<br />
Ander als bei anderen ORM Implementierungen wird gar nicht erst versucht eine
DBMS Abstraktion ausschlieslich über die Criterias zu erreichen.<br />
Zu diesem Zwecke gibt es die Query Klassen, die dies weitaus besser ermöglichen
als eine automatisierter nur schwer zu beeinflussender Ansatz.
</p>

<p>Im Gegensatz zu den Criterias können über die Queryklassen sogar komplett 
andere Datenquellen wie Webservices, NoSQL, XML über XPath oder sonstige denkbare
Datenquellen angesprochen werden.</p>

<p>
Die Architektur sieht vor Criterias nur in Queryklassen zu verwenden. Bei simplen
Queries ohne relevante dynamische Anteile kann auch direkt auf SQL in den Queryklassen
zurückgegriffen werden.
</p>

<h3>Hier wäre ein super Platz für ein Codebeispiel</h3>
<?php start_highlight(); ?>
<_..._>
</_..._>
<?php display_highlight( 'xml' ); ?>
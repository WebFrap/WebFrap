<h1>Commit Guidelines</h1>

<label>Generelle Richtlinien für Commits:</label>
<p></p>

<label>Variante 1: Mit Bezug auf ein Ticket</label>

<ul>
	<li><span>Welche Komponente?</span></li>
	<li><span>Trenner: Semikolon</span></li>
	<li><span>Was wurde genau gemacht?</span></li>
	<li><span>Trenner: Punkt</span></li>
	<li><span>Die ID des Tickets</span></li>>
	<li><span>Trenner: Bindestrich</span></li>
	<li><span>Name des Tickets</span></li>
	<li><span>Abschluss: Punkt</span></li>
</ul>

<pre>
"Core: Cache Adapter hinzugefügt. Fixed|Implemented #1337 - Cache Adapter erstellen"
(WO): _________ (WAS) __________ .      #(TICKED_ID)      - _____(TICKED_NAME)______  
</pre>

<p>Längere Texte und Motivationen sind in den Tickets zu hinterlegen, das muss nicht unbedingt in die Commits.</p>

<label>Variante 2: Es existiert kein Ticket:</label>

<p>Ist es eine größere Änderung bei der auch die Motivation fest gehalten werden sollte um
später zu verstehen warum das gemacht wurd? Wenn Ja Ticket anlegen und weiter bei 1.</p>

<p>Bei kleinere Änderungen wie Rechtschreibfehlern, Doku Erweiterungen oder kleineren kosmetischen Refactoring Aktionen
kann auf ein Ticket verzichtet werden.</p>

<p>
Hier haben wir folgendes Format:
</p>

<ul>
	<li><span>Welche Komponente?</span></li>
	<li><span>Trenner: Semikolon</span></li>
	<li><span>Was wurde genau gemacht?</span></li>
	<li><span>Abschluss: Punkt</span></li>
</ul>

<pre>
"Core: Cache Adapter Doku verbessert. "
(WO): ___________ (WAS) ____________ . 
</pre>


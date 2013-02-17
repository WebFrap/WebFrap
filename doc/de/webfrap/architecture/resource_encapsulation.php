<h1>Resource Encapsulation</h1>

<p>
Beim lesen des Codes fällt schnell auf, dass es keine direkten Zugriff
auf die Superglobalen Variablen wie $_GET, $_POST, $_SESSION etc. gibt.
</p>

Hat guten Grund
Direkter Zugriff auf Superglobales ist Kündigungsgrund! Kein Witz...

Wir benötigt für Dependency Inheritance. 
Ermöglicht die Kontrolle was wann wohin kommt. 

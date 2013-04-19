<h1>Mandatory Access Control</h1>

<p>
Über die Mandatory Access Control werden die Zugriffsrechte auf Basis
des User-Levels definiert.
Die jeweiligen Zugriffsrechte sind für jede Security-Area separat zu definieren.
</p>

<p>
Standardmäßig sind alle Levelanforderungen auf dem Maximum, das heißt nur
User mit dem Maximalen Zugriffslevel erhalten Berechtigungen über die Levels.
</p>

<p>Im folgenden eine Maske zum konfigurieren der MAC für eine Security-Area:</p>

<img 
  src="./images/buiz_guidance/acl/area_access_level.png" 
  class="block" 
  alt="Area Access Level" />

<p>
Zur Erklärung: für das <span class="key_word" >Access-Level</span> <span class="access_level" >listing</span> 
benötigt der User für diese Area mindestens das <span class="key_word" >User-Level</span> 
<span class="user_level" >user_access</span> oder höher.<br />
Für <span class="access_level" >delete</span> ist bereits das höchste <span class="key_word" >User-Level</span>
<span class="user_level" >head</span> nötig.
</p>

<p>
Über die Mandatory Access Control kann immer nur der Zugriff auf komplette Management Knoten oder
Entities geregelt werden. Für Feingranularere Zugriffsrechte auf Datensatzebene muss auf die ACLs zurückgegriffen werden.
</p>
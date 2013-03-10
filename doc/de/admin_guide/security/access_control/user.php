<h1>System User</h1>

<p>
Für jede natürliche Person gibt kann es mehrere Benutzer in dem System geben, welche jedoch
alle auf den Datensatz der Person verweisen müssen.
Technisch ist es möglich die meisten Szenarios mit nur einem User Pro Person abzubilden,
der Pflegeaufwand der Berechtigungen bei Umfassenden Änderungen im Profil: z.B. 
"der User war bisher Mitarbeiter verlässt nun das Unternehmen bleibt aber als Kunde bestehen"
übertrifft den Aufwand der Pflege mehrerer Profile, zumal sich die Anzahl der Profile
in der Regel auf maximal 2 beschränken wird, z.B Kunde und Mitarbeiter.
</p>

<p>
Prinzipiell stellt der Benutzerdatensatz jedoch einen eindeutigen Verweis auf eine Person dar, 
und wird dazu verwendet um über Relative Beziehungen zu Datensätzen z.B Berechtigungen
oder Interessengruppen abzubilden.
</p>

<label>User-Levels</label>

<p>
Jeder Benutzer bekommt Standardmäßig ein Zugriffslevel. Diese Level wird bei der einfachen
"Mandatory Access Control" Prüfung verwendet.
Es ist wichtig das Level des Benutzers nicht zu Hoch zu setzen, da mit steigenden Level 
schnell umfangreiche Berechtigungen zugewiesen werden. 
</p>

<p>Welche Berechtigungen genau erteilt werden wird in den Security Areas definiert.</p>

<ul class="doc_tree" >
  <li><span class="key_word" >public_edit</span> (<span class="key_word" >0</span>)</li>
  <li><span class="key_word" >public_access</span> (<span class="key_word" >10</span>)</li>
  <li><span class="key_word" >user</span> (<span class="key_word" >20</span>)</li>
  <li><span class="key_word" >ident</span> (<span class="key_word" >30</span>)</li>
  <li><span class="key_word" >employee</span> (<span class="key_word" >40</span>)</li>
  <li><span class="key_word" >superior</span> (<span class="key_word" >50</span>)</li>
  <li><span class="key_word" >l4_manager</span> (<span class="key_word" >60</span>)</li>
  <li><span class="key_word" >l3_manager</span> (<span class="key_word" >70</span>)</li>
  <li><span class="key_word" >l2_manager</span> (<span class="key_word" >80</span>)</li>
  <li><span class="key_word" >l1_manager</span> (<span class="key_word" >90</span>)</li>
  <li><span class="key_word" >system</span> (<span class="key_word" >100</span>)</li>
</ul>



<label>User Types</label>

<p>
Ein Benutzer muss nicht zwigend eine Natürliche Person sein, es gibt noch eine
Reihe andere Benutzertypen:
</p>

<ul class="doc_tree" >
  <li><span class="key_word" >user</span> Eine natürliche Person</li>
  <li><span class="key_word" >organization</span> Sammelnutzer für mehrere Personen aus einer Organisierten Gruppe, z.B Firmen Accounts</li>
  <li><span class="key_word" >wbf_node</span> Eine andere WebFrap Installation</li>
  <li><span class="key_word" >bot</span> Ein Bot / irgend eine technisches System welches Zugriff auf bestimmte Webservices erhält</li>
  <li><span class="key_word" >spider</span> Ein Spezieller Bot von dritten welcher zugelassen wurde bestimmte Inhalte zu indizieren</li>
  <li><span class="key_word" >system</span> Das System selbst. Kann nicht vergeben werden, existiert nur einmal.</li>
</ul>
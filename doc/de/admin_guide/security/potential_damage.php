<h1>Schaden Szenarios</h1>

<p>Es gibt recht unterschiedliche Schadenszenarios als Folge von Angriffen</p>


<h2>Denial of Service Angriffe</h2>

<p>
Ziel ist es durch möglichst viele, möglichst Resourcen intensive Anfragen
ein Zielsystem in die Knie zu zwingen. Das Primäre Ziel dabei ist, das System 
vom ausführen seiner eigentlichen Arbeit durch eine Überlastung abzuhalten.
</p>

<p>
Hier hilft nur (wenn überhaupt) qualifiziertes Personal, dass in der Lage ist die Art des
Angriffs zu erkennen und wirksame Gegenmaßnamen einzuleiten.
</p>

<h2>Daten Spionage</h2>

<p>
Wie der Name es schon erahnen lässt handelt es sich hierbei um Angriffe deren
primäres ziel das Auslesen von nicht öffentlichen / geheimen Daten ist.
</p>

<p>
Solchen Angriffen kann nur präventiv begegnet werden, da der eigentliche Angriff
oft zu schnell durchgeführt werden kann um durch irgend eine Menschliche Reaktion den Angriff zu unterbinden.
</p>

<ul class="doc_tree" >
  <li>Sichere Programmierung</li>
  <li>Sauber und strikt implementierte Zugriffs und Authentifizierungssysteme</li>
  <li>Kritische Updates zeitnah einspielen</li>
  <li>Geschultes Personal (Social Engineering)</li>
  <li>IDS Systeme soweit sinnvoll möglich</li>
  <li>Durchgehende End zu End Verschlüsselung</li>
  <li>Datenverwaltende Systeme dürfen nur von Vertrauenswürdigen Client IP Bereichen connected werden</li>
  <li>... to be continued</li>
</ul>

<p>
Ebenfalls wichtig, ist es dass wenn solche Angriffe doch gelingen, diese zumindest
Nachträglich bemerkt werden können müssen, idealerweiße so, dass man Kunden benachrichtigen kann
bevor sie es aus den Medien selbst erfahren.
</p>

<ul class="doc_tree" >
  <li>Logging</li>
  <li>Zugriffs Protokolle</li>
  <li>... to be continued</li>
</ul>

<h2>Daten Sabotage</h2>

<p>
Angriffe die Primär darauf ausgerichtet sind daten auf dem System teilweise
oder komplett zu manipulieren oder gar zu löschen.
</p>

<p>
Dabei ist zu unterscheiden, ob versucht wird die Daten so zu manipulieren, dass
sie das System als korrekte Daten akzeptiert, und der Anwender davon nicht merkt, 
oder die Daten real zu zerstören.
</p>

<p>
Auch hier helfen nur präventieve Maßnahmen, zum einen die bei Sabotage breits
aufgelisteten Punkte, allerdings gibt es hier die Möglichkeit nach erfolgreichen Angriffen
die Daten wieder herzustellen, und den Umfang des Schadens zu bestimmen.
</p>

<ul class="doc_tree" >
  <li>Backups zum wiederherstellen der Daten (Hier muss sicher gestellt werden, dass diese nicht ebenfalls manipuliert wurden)</li>
  <li>Checksummen zum validieren der Daten (Hierfür können auch Daten in den Backups verwendet werden)</li>
</ul>

<h2>Übernahme des Systems</h2>

<p>
Gerade im Web komm es häufiger vor, das Angreifer die Kontrolle über Systeme
übernehmen um diese als Resource zu missbrauchen.
Dabei werden entweder Inhalte auf dem Webserver abgelegt die der Angreifer aus
gutem Grund nicht bei seinen eigenen Servern ablegen möchte, oder Dienste
wie Gameserver / Chatserver / Botnetzwerke installiert, welche im Bestenfall
nur zusätzliche Sicherheitslücken aufreisen und Resourcen verbraten, im unangenehmeren 
Fall teil einer Illegalen Operation sind und mögliche rechtliche konsequenzen
für den Betreiber nach sich ziehen.
</p>

<p>
Gegen eine zumindest längerfristige Systemübernahme schützt nur kompetentes Personal
und eine Monitoring der Server.
</p>


<h1>HTML Markup</h1>

<p>
Bezüglich des HTML Markups gehen wir soweit möglich / nötig einen eigenen einfachen
aber konsistenten Weg.
</p>

<p>
Die wichtigste Regel: Das generierte Markup hat IMMER, IMMER, IMMER! technisch valides XML zu sein.
Nocheinmal technisch valides XML! nach Möglichkeit auch valides HTML, die größte
Priorität liegt jedoch auf validem XML. 
</p>

<p>
Da das bisschen Semantik im HTML Markup mit Witz noch gnädig beschrieben ist
sind alle pseudosemantischen Tags im Markup zu ignorieren.<br /> 
Wir verwenden von HTML nur einen sinnvollen Core, alle sonstigen Elemente sind <br /> 
nachdrücklich in den Templates verboten.
</p>

<p>
Der Hintergrund dazu ist einfach erklärt. Wir legen Wert darauf, dass der Inhalt
mit einer einheitlichen Methode semantisch anotiert werden kann.<br />
HTML bietet jedoch nur ein nichteinmal ansatzweise Minimal nötiges Set an 
semantischen Tags. Die Situation verschlimmert sich aktuell auch eher als das 
Besserung in Sicht wäre. Darüber hinaus gibt mehrer Ansätze wie z.B. Microformats
um die Schmerzen zumindest etwas zu lindern.<br />
Würde man nun versuchen mit diesem Flickenteppich saubere semantische Inhalte
auf eine Webseite zu repräsentieren, hätte man x verschiedene Formate, welche trotzdem
nicht ansatzweise alle nötigen Informationen repräsentieren können.<br />
Daher wird Semantik über CSS Klassen auf <span class="html_tag" >span</span> oder <span class="html_tag" >a</span> tags
abgebildet.<br />
</p>

<p>
Daraus ergeben sich mehrer entscheidente Vorteile:<br />
<ul>
  <li>Es ist einfach zu verstehen und einfach zu implementieren</li>
  <li>Jede Art von Struktur kann in einem einheitlichen Format abgebildet werden</li>
  <li>Es ist über CSS Dateien einfach zu beschreiben und zu erweitern</li>
  <li>Über den Class Selector können wir das Markup bei Bedarf vor dem ausliefern trotzdem leicht
  in ein infantileres Markup transferieren, wenn wir uns beim Client dadurch Vorteile versprechen.<br />
  </li>
  <li>
    Wir bekommen eine Versionssicherheit für das Markup, da wir es eben auch
    für unterschiedliche Clients bzw. Markup Versionen anpassen können.
  </li>
  <li>
    Es ist sehr einfach dadurch auch valides Markup zu erstellen, da wir uns keine
    Gedanken machen müssen ob Tag / Feature XY überhaupt unterstüzt wird.
  </li>
</ul>
</p>

<label>Liste der erlaubten Tags:</label>
<ul>
  <li><span>Layout</span>
    <ul>
      <li>div</li>
      <li>span</li>
      <li>p</li>
      <li>a</li>
      <li>fieldset</li>
      <li>legend</li>
    </ul>
  </li>
  <li><span>Listen</span>
    <ul>
      <li>ul</li>
      <li>ol</li>
      <li>li</li>
    </ul>
  </li>
  <li><span>Tabellen</span>
    <ul>
      <li>table</li>
      <li>label</li>
      <li>thead</li>
      <li>tbody</li>
      <li>tr</li>
      <li>td</li>
      <li>th</li>
    </ul>
  </li>
  <li><span>Forms &amp; Controls</span>
    <ul>
      <li>form</li>
      <li>input</li>
      <li>select</li>
      <li>option</li>
      <li>button</li>
    </ul>
  </li>
  <li><span>Logik</span>
    <ul>
      <li>script</li>
      <li>style</li>
      <li>var</li>
    </ul>
  </li>
</ul>



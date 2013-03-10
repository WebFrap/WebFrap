# Abstraktionsvermögen

Webfrap ist eine Platform für Projekte die zum großen Teil mit Daten
aus vielen verschiedenen Quellen arbeitet. 

Des weiteren gibt es eine ganze Reihe von technischen Anforderungen
die eine vernünftige Abstraktion unabdingbar machen, wenn uns das ganze nicht
eines Tages um die Ohren fliegen soll und unwartbar werden soll.

Wir wollen nicht den Fehler machen und unwartbaren Code hinter yet another
Layer verstecken, deshalb ist es wichtig Komponenten und Layer so sauber
zu definieren, dass diese Erweiterbar oder sogar austauschbar sind ohne
die anderen Komponenten im System anpassen zu müssen.

Abstraktion betrifft allerdings nicht nur die technische Struktur des Codes
sondern auch solche einfachen Dinge wie die Wahl des richigen Bezeichners für ein
Codeelement.

Also bevor du etwas umsetzt überleg dir wo es eigentlich hin gehört,
definiere Schnittstellen und achte auf folgende einfach zu vermeidenten Probleme:

## Falsche Bezeichner 

Die Semantische Bedeutung umfasst in der Bedeutung mehr oder weniger als das
was im Code ausgedrückt werden soll.

Beispiel:

Wir suchen einen Namen für eine Klasse die einen PKW abbilden soll.

Beispiele für eine zu hohe Abstrakt

- **<del>Fahrzeug / 4RadFahrzeug</del>** Ok PWK sind zwar Fahrzeuge aber nichtmal zwansgweise 4Rad Fahrzeuge und schon gar nicht sind
alle Fahrzeuge PWK.
- **<del>Fortbewegungsmittel</del>** Schiffe und Flugzeuge sind auch Fortbewegungsmittel.


### Mehrfachbedeutungen

Bei PKW is das noch einfach zu verstehen und zu entscheiden.
Es gibt jedoch oft auch Situationen wenn schon der Bezeichner aleine mehrere verschiedene
Bedeutungen haben kann. 

Bsp:

- Artikel(Pronomen) / Artikel(Shop) / Artikel(In einer Zeitung) mehrere Bedeutungen für ein einziges Wort
- Spam(Mail) / Spam(Lebensmittel) Bezeichnung oder ein Markenname

Hier ist es wichtig den Kontext mit in den Bezeichnern (oder dem Namespace) zu haben, da sonst die Bedeutung
beim Lesen aus dem Kontext abgeleitet werden müsste.
Code wird komplex genug, da sollten wir uns ersparen auch noch erraten zu müssen
was denn nun eigentlich gemeint war.

So lassen lässt sich auch das Risiko von Namenskonflikte mit einfachen Mitteln auf ein Minimum reduzieren.

## Redundante Datenstrukturen

Dieses Problem betrifft vor allem (aber nicht nur) das Datenmodell bzw. die Datenbank.

Wie derartige Probleme zu vermeiden sind wird mit den Normalformen 3 bis 5 http://de.wikipedia.org/wiki/Normalisierung_%28Datenbank%29
sehr gut definiert und sollte daher auch tunlichst umgesetzt werden.

### Abgrenzung zu Vorverdichtung / Vorrendering / Caching




## zu große Datenknoten ( duzende attribute )

## spezielle eigenschaften in allgemeinen datenknoten

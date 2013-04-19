#Index

Postgres kennt mehrere Arten von Indizes, die ihre Stärken und Schwächen haben. Am gebräuchlichsten ist dabei der B-Tree Index, welcher
grob gesagt, aus einem B-Baum mit angehängter, doppeltverketteter Liste besteht. Erst auf der untersten Ebene, sprich auf Ebene der verketteten Liste
wird die Verbindung zwischen gesuchtem Ausdruck und den Daten in der jeweiligen Tabelle hergestellt. Dabei wichtig zu wissen ist, dass lediglich
der Zugriff auf den Baum in konstanter Zeit erfolgt und es bei der Liste zu deutlich längerern Laufzeiten kommen kann.


## Codebeispiel
<?php start_highlight(); ?>
<_..._>
</_..._>
<?php display_highlight( 'xml' ); ?>
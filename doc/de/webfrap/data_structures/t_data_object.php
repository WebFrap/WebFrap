<h1>TDataObject</h1>

<p>Das Data Object bietet ähnliche Funktionen wie Entities für generische
 key Value paare.</p>

<p>Es wird vor allem in Templates als Datencontainer eingesetzt, die
<span class="var" >$VAR</span>,<span class="var" >$ELEMENT</span>
und sonstiten Template Variablen sind z.B. vom Type <span class="class" >TDataObject</span>
</p>

<h3>Benutzung</h3>
<?php start_highlight(); ?>

$dObj = new TDataObject(array
(
  'some_money' => 22.33,
  'some_date' => '2001-03-12',
  'some_value' => 'Chellas' 
));

echo $dObj->some_money.NL;
echo $dObj->getMoney('some_money').NL;

echo $dObj->some_date.NL;
echo $dObj->getDate('some_date').NL;
echo $dObj->getTimestamp('some_date').NL;


echo $dObj->some_value.NL;
echo $dObj->getHtml('some_value');

<?php display_highlight( 'php' ); ?>
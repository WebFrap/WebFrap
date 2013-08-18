<?php 

$dateStart = new DateTime( '1970-01-01' );
$dateEnd = new DateTime( '2038-01-01'   );
$interval = new DateInterval('P1D');

$period = new DatePeriod( $dateStart, $interval , $dateEnd );


// fillup
echo "<pre>";
foreach( $period as $perPos )
{

  echo <<<SQL
insert into wbfsys_period_day ( p_day ) value ('{$perPos->format('Y-m-d')}');

SQL;

}
echo "</pre>";


?>


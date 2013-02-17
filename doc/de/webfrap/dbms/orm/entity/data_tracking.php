
<h1>Data Tracking</h1>

<p>Es ist einfach möglich automatisch Änderungen auf einem oder mehreren zusammengefassten
Feldern zu tracken.</p>

<label>Hier wäre ein super Platz für ein Codebeispiel</label>
<?php start_highlight(); ?>
class TrackerEntity
  extends Entity
{
  
  public static $track = array
  (
    'NameOfTheTrackingEntity' => array
    (
      'fields' => array
      (
        'field_name' => array(  ),
        'field_name2' => array(  ),
      )
    ),
    'AnotherTrackingEntity' => array
    (
      'fields' => array
      (
        'field_name4' => array(  ),
        'field_name5' => array(  ),
      )
    )
  );

}

<?php display_highlight( 'php' ); ?>
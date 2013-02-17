
<h1>Entity Index</h1>

<p>Hier könnte ihre Dokumentation stehen... Wenn sie endlich jemand schreiben würde...</p>

<label>Aufbau der Entity</label>
<?php start_highlight(); ?>
class IndexEntity
  extends Entity
{
  
   /**
    * Flag, dass der Index für diese Entity aktiviert ist.
    * Wenn diese Flag existiert und auf True ist werden alle in den
    * Index-Listen enthaltenenen felder in den wbfsys_data_index geschrieben
    * 
    * @var boolean
    */
    public static $index = true;
     
   /**
    * Liste der Felder für das Namensfeld
    * Optimalerweise nur ein Feld
    * 
    * @var array
    */
    public static $indexNameFields = array
    (
    );
     
   /**
    * Liste der Felder für das Titelfeld
    * Solle ein Titel oder eine passenden Kurzbeschreibung sein
    * Optimalerweise etwas das kurz aber effektif beschreibt worum es sich
    * bei dem Datensatz handelt
    * 
    * @var array
    */
    public static $indexTitleFields = array
    (
    );
     
   /**
    * Liste der Felder für das Titelfeld
    * Solle ein Titel oder eine passenden Kurzbeschreibung sein
    * Optimalerweise etwas das kurz aber effektif beschreibt worum es sich
    * bei dem Datensatz handelt
    * 
    * @var array
    */
    public static $indexKeyFields = array
    (
    );
     
   /**
    * Liste den den Felder die zu einer Beschreibung des Datensatzes nötig sind
    * Der Inhalt wird automatisch auf maximal 250 Zeichen reduziert, daher macht
    * es keinen Sinn hier unnötig viele Daten reinzupacken
    * @var array
    */
    public static $indexDescriptionFields = array
    (
    );
  
}

<?php display_highlight( 'php' ); ?>
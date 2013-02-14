<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
* 
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/


/**
 * @package WebFrapUnit
 * @subpackage tech_core
 */
class LibTestSpeedBench
{

 /** Gesamt Anzahl aller Klassen, Public Counter um Sessions zu vermeiden
  *
  */
  public static $anzClass = 0;

 /** Gesamt Anzahl aller Methoden in allen Klassen,
  * Public Counter um Sessions zu vermeiden
  */
  public static $anzMethodes = 0;

 /** Die id in der Datenbank des aktuellen Benchmarks
  *
  */
  public static $idTestRun = null;


 /** Wann wurde eine bestimmte Methode gestartet
  * Array mit allen MethodenStarts
  */
  public $methodStart = array();

 /** Wann wurde eine bestimmte Methode gestopt
  * Array mit allen MethodenStops
  */
  public $methodStop = array();

 /** Gesammtlaufzeit der Methoden
  * Array mit allen MethodenStops
  */
  public $methodFullDuration = array();

 /** Durschnittliche Laufzeit einer Wiederholung
  * Array mit allen MethodenStops
  */
  public $methodSingleDuration = array();

 /** Wenn keine Repeats für eine Funktion definiert sind wie oft soll die
  * die Schleife laufen Default 100000 mal
  */
  protected $_defaultRepeat = 100000;

 /** Zuordnung von Wiederholungen zu Methoden
  */
  protected $_runRepeats = array();

 /** Datenbank Objekt
  */
  protected $_dbCon = null;

 /** SystemController
  */
  protected $_sysController = null;


  public function __construct( )
  {
    $log = Log::factoryGet( 'unitlog' );

    ++ self::$anzClass;
    $this->_dbCon = UnitDbcon::getInstance();
    $this->_sysController = UnitWebfrap::getInstance();

  }// Ende public member __construct( )

  public function runTests($PackageId , $ClassFromDB )
  {
    $log = Log::factoryGet( 'unitlog' );


    $ClassName =  get_class ($this );
    $Methodes = get_class_methods ($ClassName );

    if (!isset($ClassFromDB['classid']) )
    {
      $ClassId = $this->_createClass($PackageId, $ClassName );
    } else {
      $ClassId =  $ClassFromDB['classid'];
    }

    // Einfügen des Klassennamens
    $ClassData['classname'] = $ClassName;
    $ClassData['classid'] = $ClassId;

    foreach($Methodes as $Method ){

      // MethodData zurücksetzten
      $MethodData = array();
      if ( strtoupper(substr($Method  , 0 , 4)) == 'PERF' )
      {
        if (!isset($ClassFromDB['methodes'][$Method]) )
        {
          $MethodId = $this->_createMethode($ClassId , $Method );
        }else
        {
          $MethodId = $ClassFromDB['methodes'][$Method];
        }
        ++self::$anzMethodes ;

        if ( isset($this->_runRepeats[$Method]  ) )
        {
          $Repeats = $this->_runRepeats[$Method];
        }
        else
        {
          $Repeats = $this->_defaultRepeat;
        }

        $MethodStart = microtime( true );
        for($Nam = 0 ; $Nam < $Repeats ; ++$Nam   )
        {
          $this->$Method( );
        }
        $MethodEnd = microtime( true );

        $Duration = $MethodEnd - $MethodStart;
        $SingleDuration = $Duration / $Repeats;

//         echo 'Duration: '.$Duration.'<br />';

        // Speichern des Ergebnisses in die Datenbank
        $this->_saveResult($MethodId ,
                            $Duration ,
                            $SingleDuration,
                            $Repeats
                          );

        $MethodData['name']           = $Method;
        $MethodData['duration']       = $Duration;
        $MethodData['singleduration'] = $SingleDuration * 1000; // Millisekunden
        $MethodData['repeats']        = $Repeats;

        // Hinzufügen der Methoden Daten
        $ClassData['methodes'][] = $MethodData;
      }// Ende If
    }// Ende Foreach

    return $ClassData;

  }// Ende public function RunTests

  public function runGivenMethodes($PackageId , $ClassFromDB , $Methodes )
  {

    $log = Log::factoryGet( 'unitlog' );


    $ClassName =  get_class ($this );

    if (!isset($ClassFromDB['classid']) )
    {
      $ClassId = $this->_createClass($PackageId, $ClassName );
    } else {
      $ClassId =  $ClassFromDB['classid'];
    }

    // Einfügen des Klassennamens
    $ClassData['classname'] = $ClassName;
    $ClassData['classid'] = $ClassId;

    // Die SetupMethode
    $this->setUp();

    foreach($Methodes as $Method )
    {

      // Dass sollte nie passieren
      // Prüfen ob auch alle Methoden da sind
      if (! method_exists ($this, $Method ))
      {
        // Wenn nicht dann wieder von Vorne anfangen
        continue;
      }

      // MethodData zurücksetzten
      $MethodData = array();
      if ( strtoupper(substr($Method  , 0 , 4)) == 'PERF' )
      {
        if (!isset($ClassFromDB['methodes'][$Method]) )
        {
          $MethodId = $this->_createMethode($ClassId , $Method );
        }else
        {
          $MethodId = $ClassFromDB['methodes'][$Method];
        }
        ++self::$anzMethodes ;

        if ( isset($this->_runRepeats[$Method]  ) )
        {
          $Repeats = $this->_runRepeats[$Method];
        }
        else
        {
          $Repeats = $this->_defaultRepeat;
        }

        $MethodStart = microtime( true );
        for($Nam = 0 ; $Nam < $Repeats ; ++$Nam   )
        {
          $this->$Method( );
        }
        $MethodEnd = microtime( true );

        $Duration = $MethodEnd - $MethodStart;
        $SingleDuration = $Duration / $Repeats;

//         echo 'Duration: '.$Duration.'<br />';

        // Speichern des Ergebnisses in die Datenbank
        $this->_saveResult($MethodId ,
                            $Duration ,
                            $SingleDuration,
                            $Repeats
                          );

        $MethodData['name']           = $Method;
        $MethodData['duration']       = $Duration;
        $MethodData['singleduration'] = $SingleDuration * 1000; // Millisekunden
        $MethodData['repeats']        = $Repeats;

        // Hinzufügen der Methoden Daten
        $ClassData['methodes'][] = $MethodData;
      }// Ende If
    }// Ende Foreach

    // Die TearDown Methode als Destruktor
    $this->tearDown();

    return $ClassData;

  }// Ende public function RunTests

  // Muss in den Tests Implementiert werden
  public function setUp()
  {
    $log = Log::factoryGet( 'unitlog' );

    $do = 'nothing';
  }

  // Muss in den Tests Implementiert werden
  public function tearDown()
  {
    $log = Log::factoryGet( 'unitlog' );

    $do = 'nothing';
  }

  protected function _createClass($PackageId, $ClassName )
  {
    $log = Log::factoryGet( 'unitlog' );

    $Sql = 'INSERT INTO perfclasses ( idperfpackage , classname  ) '
      .' VALUES ( '.$PackageId.' , \''.$ClassName.'\' ) ';

    return $this->_dbCon->insert($Sql , 'perfclasses' , 'idperfclasses'  );
  }

  protected function _createMethode($ClassId , $ClassName  )
  {
    $log = Log::factoryGet( 'unitlog' );

    $Sql = 'INSERT INTO perffunctions ( idperfclasses , methodename  ) '
      .' VALUES ( '.$ClassId.' , \''.$ClassName.'\' ) ';

    return $this->_dbCon->insert($Sql, 'perffunctions', 'idperffunctions' );
  }

  protected function _saveResult
  (
    $MethodId ,
    $Duration ,
    $SingleDuration,
    $Repeats
  )
  {
    $log = Log::factoryGet( 'unitlog' );

    $Sql = 'INSERT INTO perftest '
      .'( idperftestrun, idperffunctions, '
      .'duration, singleduration, repeats  ) VALUES '
      .'( '.self::$idTestRun.', '.$MethodId .', '
      .round ($Duration , 9).', '.round(($SingleDuration * 1000),9)
      .', '.$Repeats.'  ) ';

    return $this->_dbCon->insert($Sql, 'perftest', 'idperftest' );
  }


} // Ende UnitSpeedBench


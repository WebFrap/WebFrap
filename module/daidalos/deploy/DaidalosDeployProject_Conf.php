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
 * @package WebFrap
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosDeployProject_Conf extends TFlag
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Type des deployments
   * 
   * full: löschen aller daten und komplettes neu schreiben
   *   Das system wir dazu in einen Maintenance Modus versetzt und zeit nur noch
   *  die Maintenance Seite
   *  Im Gegensatz zu fast gibt es hier keine moduswahl, da das system 
   *  auf jeden fall erst wieder benutzbar ist, wenn das deployment
   *  fertig ist
   *  
   * fast: Das vorhandene System wir einfach überschrieben, Dateien welche
   *   im Repository gelöscht wurden verbleiben im Livesystem
   *   System kann in den Readonly modus versetzt werden, muss aber nicht
   * 
   * @var TFlag
   */
  public $type = 'full';
  
  /**
   * Flags was genau mit dem cache passieren soll
   *   
   *   full=true: einfach den kompletten cache löschen
   *   
   *   style=true: den css cache löschen
   *  theme=true: den theme cache löschen
   *  wgt=true: den js cache löschen
   *  autoload=true: den autoload cache löschen
   *  data: den datei / daten cache löschen
   *    full=true: einfach alles löschen
   *    dbms=true: den cache für die datenbank abfragen löschen
   *    request=true: cache für vorgerenderte requests löschen
   *    page=true: cache für cms seiten löschen
   *    report=true: cache für reports löschen
   *    document=true: cache für documente löschen
   *    
   * 
   * @var TFlag
   */
  public $cache = null;
  
  /**
   * Flags zum thema backup
   *   
   *   full=true: backup für alles anlegen
   *   
   *   uploads=true sicherung der uploads erstellen
   *  dbms=true sicherung der datenbank erstellen
   *    
   * 
   * @var TFlag
   */
  public $backup = null;
  
  /**
   * Flag ob die sessions gelöscht werden sollen
   * @var boolean
   */
  public $dropSession = true;
  
/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   *
   * @param array $content
   */
  public function __construct( $content = array() )
  {

    if( $anz = func_num_args() )
    {
      if( $anz == 1 and is_array(func_get_arg(0)) )
      {
        $this->content = func_get_arg(0);
      }
      else
      {
        // hier kommt auf jeden fall ein Array
        $this->content = func_get_args();
      }
    }
    
    $this->load();

  } // end public function __construct */
  
  
  /**
   * laden der konfiguration
   */
  public function load()
  {
    
    $this->cache = new TFlag();
    
    $this->cache->data = new TFlag();
    
    $this->backup = new TFlag();
    
  }//end public function load */

}//end class DaidalosDeployProject_Conf


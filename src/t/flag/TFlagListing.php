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
 * de:
 * {
 *  Diese Klasse wird zum emulieren von benamten parametern verwendet.
 *
 *  Dazu werden __get und __set implementiert.
 *  __get gibt entweder den passenden wert für einen key oder null zurück
 * }
 *
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class TFlagListing
{
  
  /**
   * startpunkt des pfades für die acls
   * 
   * url param: 'a_root',  Validator::CKEY 
   * 
   * @var string
   */
  public $aclRoot = null;
  
  /**
   * Die Rootmaske des Datensatzes
   * 
   * url param: 'm_root',  Validator::TEXT 
   * 
   * @var string
   */
  public $maskRoot = null;
  
  /**
   * die id des Datensatzes von dem aus der Pfad gestartet wurde
   * 
   * url param: 'a_root_id', Validator::INT 
   * 
   * @var int
   */
  public $aclRootId = null;
  
  /**
   * Der type der Liste, z.B. Table, Treetable, Selection
   * @var string
   */
  public $ltype = null;
  
  /**
   * Mit dem append flag wird gesteuer ob listenelemente mit ihrem push
   * den Body ersetzen oder etwas an ihn anhängen
   * @var boolean
   */
  public $append = null;

  /**
   * Liste der Suchwerte aus der Col Search
   * @var array / null wenn leer
   */
  public $colConditions = null;
  
  /**
   * Variable für Sortierinformationen
   * @var array / null wenn leer
   */
  public $order = null;
  
  /**
   * Eine List mit Filtern
   * @var TFlag
   */
  public $filter = null;
  
////////////////////////////////////////////////////////////////////////////////
// Protected data
////////////////////////////////////////////////////////////////////////////////

  /**
   * de:
   * {
   *   Container zum speichern der key / value paare.
   * }
   * @var array
   */
  protected $content = array();

////////////////////////////////////////////////////////////////////////////////
// Magic Functions
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   */
  public function __construct( $request )
  {

    $this->filter = new TFlag();
    
    $filters = $request->param( 'filter', Validator::BOOLEAN );
    
    if( $filters )
    {
      foreach( $filters as $key => $value  )
      {
        $this->filter->$key = $value;
      }
    }

    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $this->ltype    = $ltype;

    if( $append = $request->param( 'append', Validator::BOOLEAN ) )
      $this->append    = $append;

  } // end public function __construct */

  /**
   * virtual __set
   * @see http://www.php.net/manual/de/language.oop5.overloading.php
   *
   * @param string $key
   * @param string $value
   */
  public function __set( $key , $value )
  {
    $this->content[$key] = $value;
  }// end public function __set */

  /**
   * virtual __get
   * @see http://www.php.net/manual/de/language.oop5.overloading.php
   *
   * @param string $key
   * @return string
   */
  public function __get( $key )
  {
    return isset($this->content[$key])
      ? $this->content[$key]
      : null;
  }// end public function __get */

  /**
   * de:
   * {
   *   wenn geprüft werden muss ob ein key tatsächlich existiert, unabhäng davon
   *   ob der wert null ist, kann das mit exists getan werden
   *
   *   @example
   *   <code>
   *   if( $params->existingButNull )
   *     echo "will not be reached when key exists but ist null" // false;
   *
   *   if( $params->exists('existingButNull') )
   *      echo "will be reached when key exists but ist null" // true;
   *
   *   </code>
   * }
   * @param string $key
   */
  public function exists( $key )
  {
    return array_key_exists( $key , $this->content );
  }//end public function exists */

} // end class TFlagListing

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
class TFlag
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
   * die id des Datensatzes von dem aus der Pfad gestartet wurde
   * 
   * url param: 'a_root_id', Validator::INT 
   * 
   * @var int
   */
  public $aclRootId = null;
  
/*


    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;

    // der neue knoten
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;
      
*/
  
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
   *
   * @param array $content
   */
  public function __construct( $content = array() )
  {

    $this->content = $content;

  }// end public function __construct */

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

} // end class TFlag


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
class Context
{
  
  /**
   * a container with the acl informations in this context
   * @var LibAclPermission
   */
  public $access = null;
  
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
  public $aclRootId  = null;

  public $aclKey     = null;

  public $aclLevel   = null;

  public $aclNode    = null;
      

  
  /**
   * de:
   * {
   *   Container zum speichern der key / value paare.
   * }
   * @var array
   */
  protected $content = array();
  
  /**
   * @var string
   */
  protected $urlExt = null;
  
  /**
   * @var string
   */
  protected $actionExt = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibRequestHttp $request
   */
  public function __construct( $request = null )
  {

    if( $request )
      $this->interpretRequest( $request );
    
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
   * @param LibRequestHttp $request
   */
  public function interpretRequest( $request )
  {

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $this->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $this->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $this->aclKey    = $aclKey;

    // der name des knotens
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $this->aclNode    = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $this->aclLevel  = $aclLevel;

  }//end public function interpretRequest */
  
  
  /**
   * @param Context $context
   */
  public function importAcl( $context )
  {

    // startpunkt des pfades für die acls
    $this->aclRoot   = $context->aclRoot;
    $this->aclRootId = $context->aclRootId;
    $this->aclKey    = $context->aclKey;
    $this->aclNode   = $context->aclNode;
    $this->aclLevel   = $context->aclLevel;

  }//end public function importAcl */

  
  /**
   * @return string
   */
  public function toUrlExt()
  {
    
    if( $this->urlExt )
      return $this->urlExt;
    
    if( $this->aclRoot )
      $this->urlExt .= '&amp;a_root='.$this->aclRoot;
    
    if( $this->aclRootId )
      $this->urlExt .= '&amp;a_root_id='.$this->aclRootId;
    
    if( $this->aclKey )
      $this->urlExt .= '&amp;a_key='.$this->aclKey;
    
    if( $this->aclNode )
      $this->urlExt .= '&amp;a_node='.$this->aclNode;
    
    if( $this->aclLevel )
      $this->urlExt .= '&amp;a_level='.$this->aclLevel;

    return $this->urlExt;
      
  }//end public function toUrlExt */
  
  /**
   * @return string
   */
  public function toActionExt()
  {
    
    if( $this->actionExt )
      return $this->actionExt;
    
    if( $this->aclRoot )
      $this->actionExt .= '&a_root='.$this->aclRoot;
    
    if( $this->aclRootId )
      $this->actionExt .= '&a_root_id='.$this->aclRootId;
    
    if( $this->aclKey )
      $this->actionExt .= '&a_key='.$this->aclKey;
    
    if( $this->aclNode )
      $this->actionExt .= '&a_node='.$this->aclNode;
    
    if( $this->aclLevel )
      $this->actionExt .= '&a_level='.$this->aclLevel;

    return $this->actionExt;
    
  }//end public function toActionExt */

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

} // end class Context


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
class ContextFilter
{

  /**
   * de:
   * {
   *   Container zum speichern der key / value paare.
   * }
   * @var array
   */
  protected $content = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * virtual __set
   * @see http://www.php.net/manual/de/language.oop5.overloading.php
   *
   * @param string $key
   * @param string $value
   */
  public function __set($key , $value )
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
  public function __get($key )
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
   *   if ($params->existingButNull )
   *     echo "will not be reached when key exists but ist null" // false;
   *
   *   if ($params->exists('existingButNull') )
   *      echo "will be reached when key exists but ist null" // true;
   *
   *   </code>
   * }
   * @param string $key
   */
  public function exists($key )
  {
    return array_key_exists($key , $this->content );
  }//end public function exists */

} // end class Context


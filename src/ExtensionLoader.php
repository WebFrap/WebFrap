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
  * Klasse zum laden von Extensions
  * @package WebFrap
  * @subpackage tech_core
  */
class ExtensionLoader
  implements Iterator, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $extensions = array();

  /**
   * @var string
   */
  protected $extPath = null;

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $name
   */
  public function __construct($name, $extPath = null)
  {

    if (is_null($extPath))
      $this->extPath = PATH_GW.'conf/extensions/';
    else
      $this->extPath = PATH_GW.$extPath; // kann nur relativ zum gw sein

    $this->load($name);

  }//end public function __construct */

  /**
   * @param string $name
   */
  protected function load($name)
  {

    ///TODO find a solution how to add a hirachie

    $tmp = array();

    if (is_dir($this->extPath.$name)  ) {
      $extPath = opendir($this->extPath.$name);

      if ($extPath) {
         while ($ext = readdir($extPath)) {
            if ($ext[0] == '.')
              continue;

            // prio wird über : angehängt
            $parts = explode(':', $ext  );

            if (!isset($parts[1]))
              $parts[1] = 50;

            $tmp[$parts[1]][] = $parts[0];

         }

         rsort($tmp);

         foreach ($tmp as $exts) {
           foreach ($exts as $ext) {
             $this->extensions[] = $ext;
           }
         }

         // close the directory
         closedir($extPath);
      }
    }

  }//end protected function load */

  /**
   * @param string $key
   */
  public function add($key)
  {
    $this->extensions[] = $key;
  }//end public function add */

  /**
   * @param string $ext
   * @return boolean
   */
  public function exists($ext)
  {
    return in_array($ext, $this->extensions);
  }//end public function exists */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Iterator::current
   */
  public function current ()
  {
    return current($this->extensions);
  }//end public function current */

  /**
   * @see Iterator::key
   */
  public function key ()
  {
    return key($this->extensions);
  }//end public function key */

  /**
   * @see Iterator::next
   */
  public function next ()
  {
    return next($this->extensions);
  }//end public function next */

  /**
   * @see Iterator::rewind
   */
  public function rewind ()
  {
    reset($this->extensions);
  }//end public function rewind */

  /**
   * @see Iterator::valid
   */
  public function valid ()
  {
    return current($this->extensions)? true:false;
  }//end public function valid */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Countable::count
   */
  public function count()
  {
    return count($this->extensions);
  }//end public function count */

}//end class ExtensionLoader


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
 * class Controller
 * Extention zum verwalten und erstellen von neuen Menus in der Applikation
 * @package WebFrap
 * @subpackage wgt
 */
abstract class WgtDesktop extends Base
{

  /*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * sub Modul Extention
   * @var array
   */
  protected $models = array();

  /*//////////////////////////////////////////////////////////////////////////////
// Constructor and other Magics
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * request the default action of the ControllerClass
   * @return Model
   */
  protected function loadModel ($modelName, $key = null)
  {

    if (! $key)
      $key = $modelName;

    $modelName = 'Model' . $modelName;
    if (! isset($this->models[$key])) {
      if (Webfrap::classLoadable($modelName)) {
        $this->models[$key] = new $modelName();
      } else {
        throw new Controller_Exception('Internal Error', 'Failed to load Submodul: ' . $modelName);
      }
    }

    return $this->models[$key];

  } //end protected function loadModel */

  /**
   *
   * @param $key
   * @return Model
   */
  protected function getModel ($key)
  {

    if (isset($this->models[$key]))
      return $this->models[$key];
    else
      return null;

  } //public function protected */

  /**
   * Function for reinitializing after wakeup. Is Neccesary caus we can't use
   * the normal __wakeup function without getting race conditions
   * @param array $data
   * @return void
   */
  public function init ($data = array())
  {

    $this->initDesktop($data);

  } // end public function init */

  /**
   * methode for shutting down extention, we use this instead of __sleep
   *
   * @return void
   */
  public function shutdown ()
  {

    $this->shutdownDesktop();

  } // end public function shutdownDesktop */

  /**
   *
   * Enter description here ...
   */
  protected function initDesktop ($data = array())
  {

    foreach ($data as $name => $value)
      $this->$name = $value;

    $this->initDesktop();

    return true;
  }

  /**
   *
   * Enter description here ...
   */
  protected function shutdownDesktop ()
  {

  }

} // end abstract class WgtDesktop


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
 * @subpackage tech_core
 *
 */
class LibAction_Runner extends Pbase
{


  /**
   * @param string $string
   */
  public function executeByString($string, array $params = array())
  {
    
    $action = json_decode($string);
    return $this->execute($action, $params);

  }//end public function executeByString */

  /**
   * @param stdClass $action
   * @throws LibAction_Exception
   */
  public function execute($action, array $params = array())
  {

    $className = $action->class;
    $method = $action->method;

    if (!Webfrap::classExists($className)) {
      throw new LibAction_Exception('Class '.$className.' does not exist.');
    }

    $actionObj = new $className($this);

    if(!method_exists($actionObj, $method)){
      throw new LibAction_Exception('Class '.$className.' does not exist.');
    }

    return $actionObj->$method($params);

  }//end public function execute */


}


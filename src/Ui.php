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
  * Das Ausgabemodul für die Seite
  * @package WebFrap
  * @subpackage tech_core
  * 
  * @deprecated use MvcUi instead
  */
class Ui extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var Model
   */
  protected $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Model $model
   */
  public function setModel($model )
  {
    $this->model = $model;
  }//end public function setModel */

  
  /**
   * @param Base $env
   */
  public function __construct($env = null )
  {

    if (!$env )
      $env = Webfrap::getActive();
      
    $this->env = $env;

  }//end public function __construct */


}//end class Ui


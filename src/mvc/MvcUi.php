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
  * A ui block with the configuration of one ore more ui elements
  * Is used to configurate list elements or form masks
  *
  * Is a subclass of the view
  *
  * @package WebFrap
  * @subpackage Mvc
  */
class MvcUi extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Normaly only one model is required,
   * if you need more add it in your extending class
   *
   * @var MvcModel
   */
  protected $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param MvcModel $model
   */
  public function setModel($model)
  {
    $this->model = $model;
  }//end public function setModel */

  /**
   * @param Base $env
   */
  public function __construct($env = null, $view = null)
  {

    if (!$env)
      $env = Webfrap::getActive();

    $this->env = $env;

    if ($view)
      $this->view = $view;
    else {
      if ($env instanceof LibTemplate  )
        $this->view = $env;
      else
        $this->view = $env->getTpl();
    }

  }//end public function __construct */

}//end class MvcUi


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
 * class ModContent
 * @package WebFrap
 * @subpackage ModuleDeveloper
 */
class Developer_Module extends Module
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string the default Extention to load
   */
  protected $defaultControllerName = 'Base';

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

    /**
   * Main function
   *
   * @return void
   */
  public function main( )
  {

    $view = View::getActive();
    $view->setTitle('WebFrap Developer');

    if ($view->isType( View::HTML ) )
    {
      $menu = $view->newItem ( 'mainMenu' ,'MenuSimplebar'  );
      $menu->setData( DaoMenu::get('gateway/navigation') );
    }

    $this->runController( );

  }//end public function main */

} // end class Developer_Module


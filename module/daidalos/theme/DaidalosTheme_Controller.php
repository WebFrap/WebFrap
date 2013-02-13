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
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosTheme_Controller
  extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * list with all callable methodes in this subcontroller
   *
   * @var array
   */
  protected $callAble = array
  (
    'form'
  );



/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function form( )
  {

    if(!$view = $response->loadView('daidalos-theme-form', 'DaidalosTheme' ))
      return false;

    Session::setStatus('web.theme', WEB_ROOT.'WebFrap_Theme_Default/themes/default/' );
    Session::setStatus('web.images', WEB_ROOT.'WebFrap_Theme_Default/themes/default/images/' );

    Session::setStatus('path.theme', WEB_ROOT.'WebFrap_Theme_Default/themes/default/' );



    $view->display( $this->getRequest(),$this->getFlags()  );


  }//end public function form */


}//end class DaidalosTheme_Controller


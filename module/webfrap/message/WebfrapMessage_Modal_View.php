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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Modal_View
  extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayMessageForm( $menuName , $params)
  {

    $this->setStatus('Explorer');
    $this->setTitle('Explorer');

    $this->setTemplate( 'webfrap/modmenu'  );

    $modMenu = $this->newItem( 'modMenu', 'MenuFolder' );
    $modMenu->setData( DaoFoldermenu::get( 'webfrap/root',true ) );


  }//end public function display */



}//end class WebfrapMessage_Modal_View


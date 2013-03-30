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
class WebfrapContact_New_Modal_View extends WgtModal
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  public $width = 800;
  
  public $height = 600;
  
  /**
   * @param string $menuName
   * @return void
   */
  public function displayNew($params)
  {

    $this->setStatus('Create Contact');
    $this->setTitle('Create Contact');

    $this->setTemplate('webfrap/contact/modal/form_new', true  );


  }//end public function displayNew */

}//end class WebfrapContact_New_Modal_View


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
 */
class WgtItemLogedInAs
  extends WgtItemAbstract
{


  /**
   * Dummybuildr
   *
   * @return

   */
  public function build( )
  {

    $user  = User::getActive();

    $html = '<div class="wgt-text emphasized">';

    if($user->getLogedIn())
    {
    $html .= 'Eingeloggt als:<br /><span>';
    $html .= $user->getData('name').'</span>';
    }
    else
    {
      $html .= 'Sie sind nicht eingeloggt';
    }
    $html .= '</div>';

    return $html;

  } // end of member function build

} // end of WgtItemForm



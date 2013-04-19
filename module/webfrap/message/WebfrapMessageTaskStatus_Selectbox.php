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


class WebfrapMessageTaskStatus_Selectbox extends WgtSelectboxEnum
{
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Laden der Daten
   * @return void
   */
  public function init()
  {

    $this->data = EMessageTaskStatus::$labels;

  }//end function init */

}// end class WebfrapMessageTaskStatus_Selectbox

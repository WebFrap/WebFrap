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
 *
 * @package WebFrap
 * @subpackage Modprofiles
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class MyMessage_Widget_Table_Ajax_View
  extends LibTemplateAjaxView
{
 /**
  * de:
  * Einfache insert methode.
  * Es wird ein neuer eintrag für das listenelement erstellt und über
  * das ajax interface in die liste gepusht
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayInsert( $params )
  {

    $ui = $this->loadUi( 'MyMessage_Widget_Table' );
    $ui->setModel( $this->model );

    $ui->listEntry( $params->access, $params, true );

    // kein fehler? alles bestens
    return null;

  }//end public function displayInsert */

 /**
  * de:
  * Einfache insert methode.
  * Es wird ein neuer eintrag für das listenelement erstellt und über
  * das ajax interface in die liste gepusht
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayUpdate( $params )
  {

    $ui = $this->loadUi( 'MyMessage_Widget_Table' );
    $ui->setModel( $this->model );

    $ui->listEntry( $params->access, $params, false );

    // kein fehler? alles bestens
    return null;

  }//end public function displayUpdate */

}// end class WbfsysMessage_Widget_Table_Ajax_View


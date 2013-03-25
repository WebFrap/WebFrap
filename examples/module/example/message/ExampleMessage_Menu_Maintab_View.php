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
 * @subpackage ModExample
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class ExampleMessage_Menu_Maintab_View extends WgtMaintab
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * @param TFlag $params
  * @return null
  */
  public function displayMenu($params)
  {

    // set the window title
    $this->setTitle('Example Message Menu');
    $this->setLabel('Example Message Menu');

    // set the form template
    $this->setTemplate('example/message/menu');

    $this->addVar('entries', array(
      'helloworld' => 'Hello World Message',
      'sendUser'   => 'Send User',
      'sendGroup'  => 'Send Group',
      'sendGroupArea'  => 'Send Group Area',
      'sendGroupDataset'  => 'Send Group Dataset',
    ));

    return null;

  }//end public function displayMenu */

}//end class ExampleMessage_Menu_Maintab_View


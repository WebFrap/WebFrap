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
  * Php Backend für die Internationalisierungsklasse
  * @package WebFrap
  * @subpackage tech_core
  */
class LibHttpError405
{

  /**
   *
   * Enter description here ...
   * @param LibTemplate $view
   */
  public function publish($view)
  {

    $view->addVar('title','405 Method Not Allowed');
    $view->addVar('code','405');
    $view->addVar
    (
      'content',
      'Hi, looks like you tried to access one of our services with a not supported HTTP Method.
      Please have a closer look to the documentation wich methods are supported for this service.
      '
    );

    $view->setTemplate('error/http/405');

  }//end public function publish */

} // end class LibHttpError405


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
 * Dummy class for Extentions
 * This class will be loaded if the System requests for an Extention that
 * doesn't exist
 * @package WebFrap
 * @subpackage Core
 */
class ExampleAjax_Subwindow_View extends WgtWindowDefault
{
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   * @param TArray $params
   */
  public function displayExample($params)
  {

    // in den view objekten wird das template mit this gesetz
    // eine view ist eigentlich eine erweiterung der template engine
    // du spezialisiert quasi direkt die ausgabe
    // bindet: templates/default/content/example/ajax_requests.tpl ein
    // egal in welchem projekt das ist, hauptsache der pfad in dem das tpl liegt
    // ist in Webfrap::$templatePath vorhanden
    $this->setTemplate('example/ajax_requests');


    // das the Window Title
    $this->setTitle('Example Ajax');


  }//end public function displayExample */

  /**
   *
   * @param TArray $params
   */
  public function displayLayout($params)
  {

    $this->setTemplate('example/layout_elements');
    $this->setTitle('Example Layout');

  }//end public function displayLayout */

  /**
   *
   * @param TArray $params
   */
  public function displayForm($params)
  {

    $this->setTemplate('example/forms_overview');
    $this->setTitle('Example Forms');

  }//end public function displayForm */

} // end class ExampleAjax_Subwindow_View

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
 * @subpackage tech_core
 */
class ControllerDummy extends Controller
{

  /**
   * the controll function sends an error message to the user
   *
   * @param string $aktion
   * @return void
   */
  public function run ($aktion = null)
  {

    $this->view->setTemplate('webfrap/error');
    
    $this->view->addVar(array(
      'errorTitle' => 'Wrong Extention', 'errorMessage' => 'Wrong Extention'
    ));
  
  } //end public function run


} // end class ControllerDummy

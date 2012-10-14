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
class Error_Controller
  extends Controller
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

/**
   * Enter description here...
   *
   * @var String
   */
  protected $errorTitle = null;

  /**
   * Enter description here...
   *
   * @var String
   */
  protected $errorMessage = null;

////////////////////////////////////////////////////////////////////////////////
// Run Method
////////////////////////////////////////////////////////////////////////////////

  /**
   * the controll function sends an error message to the user
   *
   * @param string $aktion
   * @return void
   */
  public function run( $aktion = null )
  {

    $view = $response->loadView('error-message', 'Error');

    $view->display( $this->errorTitle, $this->errorMessage  );

    /*
    $this->view->setTemplate( 'error/message' );

    $this->view->addVar
    (array
    (
      'errorTitle'   => $this->errorTitle,
      'errorMessage' => $this->errorMessage
    ));
    */

  }//end public function run */

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter Method
////////////////////////////////////////////////////////////////////////////////

  /**
   * Setter for title
   *
   * @param string $title
   */
  public function setErrorTitle( $title )
  {

    $this->errorTitle = $title;
  }//end public function setErrorTitle */

  /**
   * setter for message
   *
   * @param string $message
   */
  public function setErrorMessage( $message )
  {
    $this->errorMessage = $message;
  }//end public function setErrorMessage */

  /**
   *
   * @param unknown_type $message
   * @return void
   */
  public function displayError( $type, $data = array()  )
  {

    $this->$type( $data );

  }

  /**
   *
   * Enter description here ...
   * @param unknown_type $data
   */
  public function displayException( $data = array() )
  {

    $view = $response->loadView( 'error-message', 'Error','displayException', View::SUBWINDOW );
    $view->displayException($data[0]);

  }//end public function displayException */

  /**
   *
   * Enter description here ...
   * @param unknown_type $data
   */
  public function displayEnduserError( $data = array() )
  {

    $view = $response->loadView('error-message', 'Error' );
    $view->displayEnduserError($data[0]);

  }//end public function displayEnduserError */

} // end class Error_Controller

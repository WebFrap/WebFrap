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
 * @subpackage Core
 */
class WebfrapTutorial_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Parent Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  protected $defaultAction = 'index';

  protected $callAble = array
  (
  'index',
  'show'
  );

/*//////////////////////////////////////////////////////////////////////////////
// Der Controller
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $action
   */
  public function run($action = null)
  {

    $this->show();

  }//end public function run($action = null)

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function show()
  {

    $request = $this->getRequest();

    if (!$template = $request->param('page' , Validator::CNAME)) {
      $template = 'start';
    }

    View::$sendBody  = true;

    $this->view->addVar('page' , $template  );
    $this->view->setTemplate('index' , 'tutorial');

  } // end public function show()

} // end class MexWebfrapBase


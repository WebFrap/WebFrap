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
 * @subpackage ModDeveloper
 */
class DeveloperRequest_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the default Action this action will be called there is noch
   * action in the request
   * @var string
   */
  protected $defaultAction = 'ajaxping';

  protected $callAble = array
  (
    'ajaxping'
  );


/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return void
   */
  public function ajaxPing( )
  {

    Message::addMessage('ping was sucessfull');

  } // end public function allStats


} // end class MexDeveloperStatus


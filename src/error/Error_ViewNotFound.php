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
 * @subpackage tech_core
 */
class Error_ViewNotFound
  extends Error_Node
{

  /**
   * @see Error_Node::$errorMessage
   */
  public $errorMessage = null;

  /**
   * @see Error_Node::$errorCode
   */
  public $errorCode = Response::NOT_IMPLEMENTED;

  /**
   * @param string $key
   */
  public function __construct( $key )
  {

    $this->errorMessage = 'The Requested View '.$key.' is not implemented';

  }//end public function __construct */

} // end class Error_ViewNotFound

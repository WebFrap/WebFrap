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
 * Exception die im Controller geworfen wird um das bearbeiten einer Anfrage
 * des Benutzers entgültig ab zu brechen
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class InternalError_Exception
  extends WebfrapUser_Exception
{
  
  /**
   * @param string $message
   * @param string $debugMessage
   */
  public function __construct( $message, $debugMessage = 'Internal Error' )
  {
    
    // passenden Fehlermeldung anhängen
    $message .=" due to an internal error. Please try again. If the problem persists please report this issue via Menu / Support / Bug";
    
    // wenn keine genaue Angabe der Fehler, dann wenigstens die standard Message nehmen
    if( 'Internal Error' == $debugMessage )
      $debugMessage = $message;

    parent::__construct
    (
      $message, 
      $debugMessage, 
      Response::INTERNAL_ERROR 
    );

  }//end public function __construct */
  
}




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
 * class WgtItemMessages
 * Object zum ausgeben der Fehlermeldungen
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtItemMessages
  extends WgtItemAbstract
{


  /**
   *
   * @return
   */
  public function build( )
  {

    $messageObject = Message::getActive();

    $html = '';

    // Gibet Fehlermeldungen? Wenn ja dann Raus mit
    if( $errors = $messageObject->getErrors() )
    {
      $html .= '<div id="wgt-box-error" class="wgt-box error">'.NL;

      foreach( $errors as $error )
        $html .= $error.'<br />'.NL;

      $html .= '</div>';
    }
    else
    {
      $html .= '<div style="display:none;" id="wgt-box-error" class="wgt-box error"></div>'.NL;
    }


    // Gibet Systemmeldungen? Wenn ja dann Raus mit
    if( $warnings = $messageObject->getWarnings() )
    {
      $html .= '<div  id="wgt-box-warning" class="wgt-box warning">'.NL;

      foreach( $warnings as $warn )
        $html .= $warn."<br />".NL;

      $html .= '</div>';
    }
    else
    {
      $html .= '<div style="display:none;" id="wgt-box-warning" class="wgt-box warning"></div>'.NL;
    }

    // Gibet Systemmeldungen? Wenn ja dann Raus mit
    if( $messages = $messageObject->getMessages() )
    {
      $html .= '<div id="wgt-box-message" class="wgt-box message" >'.NL;

      foreach( $messages as $message )
        $html .= $message."<br />".NL;

      $html .= '</div>';
    }
    else
    {
      $html .= '<div style="display:none;" id="wgt-box-message" class="wgt-box message"></div>'.NL;
    }

    // Meldungen zurückgeben
    return $html;

  } // end public function build( )


} // end of WgtItemMessages



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
 * class WgtItemDummy
 * Fehlerobjekt
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtItemDummy
{

  /**
   * Die Breite des Elements
   */
  public $message = null;


  /**
   * Den Constructor
   * @param string $Message Die Fehlermeldung
   *
   * @return void
   */
  public function __construct( $Message )
  {


    $this->message = $Message;

  } // end of member function __construct

  /** Parserfunktion
   *
   * @return String
   */
  public function build( )
  {

    return $this->message;
  } // end of member function build


} // end of WgtItemDummy



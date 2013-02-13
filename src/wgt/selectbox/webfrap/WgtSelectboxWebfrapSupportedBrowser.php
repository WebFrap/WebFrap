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
 * @subpackage tech_core
 */
class WgtSelectboxWebfrapSupportedBrowser
  extends WgtSelectboxHardcoded
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   */
  public function load()
  {

    /**
     *
     */
    $this->firstFree = ' ';

    /**
     * Enter description here...
     *
     * @var array
     */
    $this->data =  array
    (
    ECoreSupportedBrowser::IE_6       =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::IE_6] ),
    ECoreSupportedBrowser::IE_7       =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::IE_7] ),
    ECoreSupportedBrowser::IE_8       =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::IE_8] ),
    ECoreSupportedBrowser::FF_1_5     =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::FF_1_5] ),
    ECoreSupportedBrowser::FF_2       =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::FF_2] ),
    ECoreSupportedBrowser::FF_3       =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::FF_3] ),
    ECoreSupportedBrowser::OPERA_8    =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::OPERA_8] ),
    ECoreSupportedBrowser::OPERA_9    =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::OPERA_9] ),
    ECoreSupportedBrowser::OPERA_9_5  =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::OPERA_9_5] ),
    ECoreSupportedBrowser::SAFARI_2   =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::SAFARI_2] ),
    ECoreSupportedBrowser::SAFARI_3   =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::SAFARI_3] ),
    ECoreSupportedBrowser::SAFARI_4   =>
      array( 'value' => ECoreSupportedBrowser::$text[ECoreSupportedBrowser::SAFARI_4] ),
    );


  }//end public function load()


} // end class WgtSelectboxCoreSupportedBrowser



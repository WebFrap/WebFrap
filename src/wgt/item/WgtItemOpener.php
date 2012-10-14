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
 * class WgtItemInput
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtItemOpener
  extends WgtItemAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  protected $openIcon  = 'templates/default/icons/xsmall/core/open.png';

  protected $closeIcon = 'templates/default/icons/xsmall/core/close.png';

  protected $idTofold  = null;

  protected $id        = null;

  protected $isOpen    = true;

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
////////////////////////////////////////////////////////////////////////////////

  public function setOpenIcon( $icon )
  {
     $this->openIcon  = 'templates/default/icons/xsmall/'.$icon;
  }//end public function setOpenIcon( $icon )

  public function setCloseIcon( $icon )
  {
    $this->closeIcon = 'templates/default/icons/xsmall/'.$icon;
  }//end public function setCloseIcon( $icon )

  public function setOpenId( $idToFold )
  {
     $this->idTofold  = $idToFold;
  }//end public function setOpenId( $idToFold )

  /**
   * Enter description here...
   *
   * @param boolean $open
   */
  public function setOpen( $open = true )
  {
    $this->isOpen = $open;

  }//end public function setOpen( $open = true )

////////////////////////////////////////////////////////////////////////////////
// Parser
////////////////////////////////////////////////////////////////////////////////

  /**
   * Parser for the input field
   *
   * @return String
   */
  public function build( )
  {

    $attributes = $this->asmAttributes();
    $this->id = 'wgtOpener'.$this->name;

    $onclick = "wgtMainWindow.wgtFoldBox( '".$this->id."', '".$this->idTofold."', "
      ." '".$this->openIcon."' , '".$this->closeIcon."' )";

    if($this->isOpen)
    {
      $src = $this->closeIcon;
    }
    else
    {
      $src = $this->openIcon;
    }

    $html = '<img src="'.$src.'" id="'.$this->id.'" onclick="'.$onclick.'" '.$attributes.' />';

    return $html;

  }// end public function build( )

}// end class WgtItemOpener



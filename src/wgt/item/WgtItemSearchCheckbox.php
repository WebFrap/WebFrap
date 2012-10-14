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
class WgtItemSearchCheckbox
  extends WgtItemAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string
   * @deprecated
   */
  public function setChecked( $activ )
  {

    if( $activ )
    {
      $this->attributes['checked'] = "checked";
    }
    else
    {
      if(isset($this->attributes['checked']))
      {
        unset($this->attributes['checked']);
      }
    }

  }//end public function setChecked

  /**
   * @param string
   */
  public function setActiv( $activ = true )
  {

    if( $activ )
    {
      $this->attributes['checked'] = "checked";
    }
    else
    {
      if(isset($this->attributes['checked']))
      {
        unset($this->attributes['checked']);
      }
    }

  }//end public function setActiv( $activ = true )

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Dummybuildr
   *
   * @return string
   */
  public function build( )
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__ , __method__ );

    if( isset( $this->attributes['type'] ) )
    {
      unset($this->attributes['type']);
    }

    $attributes = $this->asmAttributes();

    return
      'yes <input type="radio" value="1" '.$attributes.' />'.NL
      .'no <input type="radio" value="0" '.$attributes.' />'.NL;

  } // end public function build( )

  /**
   * Dummybuildr
   *
   * @return string
   */
  public function buildAjaxArea( )
  {


    if( isset( $this->attributes['type'] ) )
    {
      unset($this->attributes['type']);
    }

    return '<input '.$this->asmAttributes().' />';

  } // end public function buildAjaxArea( )


} // end class WgtItemCheckbox



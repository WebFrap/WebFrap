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
 * class WgtItemHidden
 * a hidden field
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputHidden extends WgtInput
{

  /**
   */
  public function build($attributes = array() )
  {

    if ($attributes) $this->attributes = array_merge($this->attributes,$attributes);

    if ( isset($this->attributes['type'] ) )
    {
      unset($this->attributes['type']);
    }

    $html = '<input type="hidden" '.$this->asmAttributes().' />'.NL;

    return $html;

  } // end public function build( )

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjax()
   */
  public function buildAjax( )
  {

    if (!isset($this->attributes['id']))
      return '';

    if (!isset($this->attributes['value']) )
      $this->attributes['value'] = '';

    $html = '<htmlArea selector="input#'.$this->attributes['id'].'" action="value" ><![CDATA['
      .$this->attributes['value'].']]></htmlArea>'.NL;

    return $html;

  } // end public function buildAjax( )



} // end class WgtItemHidden



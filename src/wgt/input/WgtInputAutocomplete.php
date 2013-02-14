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
 * class WgtItemAutocomplete
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputAutocomplete extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $type = null;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $loadUrl = null;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter method for the url
   * @param string $url the url from witch the selectbos tries to load the data
   */
  public function setUrl($url )
  {
    $this->loadUrl = $url;
  }//end blic function setUrl */

  /**
   * setter method for the url
   * @param string $type
   */
  public function setType($type )
  {
    $this->type = $type;
  }//end blic function setType */

  /**
   * Enter description here...
   *
   * @param string $service
   * @param string $action
   */
  public function setLoadParam($service , $action )
  {
    $this->loadUrl = 'json.php?serv='.$service.'&amp;action=Autocomplete'.$action;
  }//end public function setLoadParam  */

/*//////////////////////////////////////////////////////////////////////////////
// Parser Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Parser for the input field
   *
   * @return String
   */
  public function build($attributes = array() )
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    if (!isset($this->attributes['id']) )
      $this->attributes['id'] = 'wgtid_item-'.Webfrap::uniqid();

    if ( isset($this->attributes['class']) )
      $this->attributes['class'] .= ' wcm wcm_ui_autocomplete';
    else
      $this->attributes['class'] = 'wcm wcm_ui_autocomplete';

    $attributes = $this->asmAttributes();

    $id = $this->attributes['id'];

    $helpIcon = $this->renderDocu($id );

    $required = $this->required?'<span class="wgt-required">*</span>':'';

    $html = '<div id="wgt_box_'.$this->attributes['id'].'" >
      <div class="wgt-label" ><label  for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>'.$helpIcon.'</div>
      <div class="wgt-input '.$this->width.'" ><input '.$attributes.' /><a class="meta" href="'.$this->loadUrl.'" ></a></div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>'.NL;

    return $html;

  } // end public function build( )

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function buildAjax()
  {

    $html = '<input '.$this->asmAttributes().' />'.NL;

    return $html;

  }//end public function buildAjax()

} // end class WgtItemAutocomplete



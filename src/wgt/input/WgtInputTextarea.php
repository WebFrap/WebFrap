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
class WgtInputTextarea extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// Magic Funktions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param $name
   * @return unknown_type
   */
  public function __construct($name )
  {
    parent::__construct($name );
    $this->attributes = array( 'cols' => '' , 'rows' => '' );

  }//end public function __construct */

  /**
   *
   * @var boolean
   */
  public $full = false;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#setData()
   */
  public function setData($data , $value = null  )
  {
    $this->data = $data;
  }// end public function setData */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#addData()
   */
  public function addData($data , $value = null  )
  {
    $this->data = $data;
  }//end public function addData */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#getData()
   */
  public function getData($key = null  )
  {
    return $this->data;
  }//end public function getData */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/


 /**
  * @return void
  */
  public function element( )
  {
    return '<textarea '.$this->asmAttributes().' >'.$this->data.'</textarea>';
  }// end public function element */

  /**
   *
   * @return unknown_type
   */
  public function build($attributes = array() )
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);


    $attributes = $this->asmAttributes();
    $required = $this->required?'<span class="wgt-required">*</span>':'';

    $docu = $this->renderDocu($this->attributes['id']);

    $html = '<div class="wgt-box input" id="wgt-box-'.$this->attributes['id'].'" >
      <div class="wgt-label" >
        <label  for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>
        '.$docu.'
       </div>
      <div class="wgt-input '.$this->width.'" >'.$this->element().'</div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>'.NL;

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


  } // end public function buildAjax */



} // end class WgtFormTextarea


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
 * class WgtItemWysiwyg
 * Objekt zum generieren einer Textarea
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputWysiwyg extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der Modus des WYSIWYG Editors
   * vorhandene Modi sind:
   * - simple
   * - rich_text
   * - cms
   * - full
   * @var string
   */
  public $mode = null;

  /**
   * @param string $name
   * @return string
   */
  public function __construct($name )
  {
    parent::__construct($name );

    $this->attributes = array( 'cols' => '' , 'rows' => '' );

  }//end public function __construct($name )


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
  }// end public function setData($data )

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#addData()
   */
  public function addData($data , $value = null  )
  {
    $this->data = $data;
  }//end public function addData($data )

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#getData()
   */
  public function getData($key = null  )
  {
    return $this->data;
  }//end public function getData($data )

  /**
   * @param string $mode
   */
  public function setMode($mode  )
  {
    $this->mode = $mode;
  }//end public function setMode */

/*//////////////////////////////////////////////////////////////////////////////
// Parser Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return array
   */
  public function build($attributes = array() )
  {

    if ($attributes )
      $this->attributes = array_merge($this->attributes,$attributes);

    if ($this->full )
    {
      $class = 'full';
      $style = 'height:325px;';
    } else {
      $class = 'newline';
      $style = 'height:325px;';
    }

    if (isset($this->attributes['class']))
      $this->attributes['class'] .= ' wcm wcm_ui_wysiwyg';
    else
      $this->attributes['class'] = 'wcm wcm_ui_wysiwyg large-height';

    $attributes = $this->asmAttributes();
    $required = $this->required?'<span class="wgt-required" >*</span>':'';

    $htmlMode = (
      $this->mode
        ? "<var id=\"".$this->attributes['id']."-cfg-wysiwyg\" >{\"mode\":\"{$this->mode}\"}</var>"
        : ''
      );


    $docu = $this->renderDocu($this->attributes['id']);


    $html = '<div class="wgt-box input" id="wgt-box-'.$this->attributes['id'].'" >
      <div class="wgt-label" >
        <label for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>
        '.$docu.'
      </div>
      <div class="wgt-input '.$class.'" style="'.$style.'" >
        <textarea '.$attributes.' >'.$this->data.'</textarea>'.$htmlMode.'
      </div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>'.NL;

    return $html;

  } // end public function build */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjax()
   */
  public function buildAjax( )
  {

    if (isset($this->attributes['class']))
    {
      $this->attributes['class'] .= ' wcm wcm_ui_wysiwyg';
    } else {
      $this->attributes['class'] = ' wcm wcm_ui_wysiwyg';
    }

    $html = '<textarea  '.$this->asmAttributes().' ><![CDATA[';
    $html .= $this->data;
    $html .= ']]></textarea>'.NL;

    return $html;

  } // end public function buildAjax */

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjax()
   */
  public function element( )
  {

    if (isset($this->attributes['class']))
      $this->attributes['class'] .= ' wcm wcm_ui_wysiwyg';
    else
      $this->attributes['class'] = 'wcm wcm_ui_wysiwyg large-height';

    $attributes = $this->asmAttributes();

    return "<textarea {$attributes} >{$this->data}</textarea>".(
      $this->mode
        ? "<var id=\"".$this->attributes['id']."-cfg-wysiwyg\" >{\"mode\":\"{$this->mode}\"}</var>"
        : ''
      );

  } // end public function element */

} // end class WgtFormWysiwyg


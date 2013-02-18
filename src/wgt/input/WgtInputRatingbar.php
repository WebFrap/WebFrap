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
class WgtInputRatingbar extends WgtInput
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  protected $data = array
  (
    '0.5' => '0.5',
    '1' => '1',
    '1.5' => '1.5',
    '2' => '2',
    '2.5' => '2.5',
    '3' => '3',
    '3.5' => '3.5',
    '4' => '4',
    '4.5' => '4.5',
    '5' => '5',
  );
  
  public $starParts = '2';

/*//////////////////////////////////////////////////////////////////////////////
// getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setzen der Elemente welche angezeigt werden sollen
   * @param $data
   */
  public function setElements($data )
  {
    $this->data = $data;
  }//end public function setElements */

  /**
   * Setzen der Elemente welche angezeigt werden sollen
   * @param int $parts
   */
  public function setStarParts($parts )
  {
    $this->starParts = $parts;
  }//end public function setStarParts */

  /**
   *
   * @param $data
   */
  public function setData($activ , $value = null )
  {
    $this->activ = $activ;
  }//end public function setData */

  /**
   * 
   * @param boolean $activ
   */
  public function setActive($activ = true )
  {
    $this->activ = $activ;
  }//end public function setData */
  
  /**
   * @param int $min
   * @param int $max
   * @param float $setSize
   */
  public function setDataProfile($min, $max, $setSize = 0.5 )
  {
    
    if ($min >= $max )
    {
      Debug::console( "Ratingbar: Max is not bigger than min! min:{$min} max:{$max} size:{$setSize}" );
      $min = 0;
      $max = 5;
    }
    
    if (!$setSize )
    {
      Debug::console( "Stepsize is null or 0, i set it to 1" );
      $setSize = 0.5;
    }
    
    $value = (float)$min+(float)$setSize;
    $max   = (float)$max;
    
    $this->starParts = (int)( 1 / $setSize );
    
    $this->data = array();
    
    for($value; $value <= $max; $value += $setSize )
    {
      $this->data[(string)$value] = (string)$value;
    }
    
  }//end public function setDataProfile */
  
  /**
   * @return void
   */
  public function setDefaultDataProfile()
  {
    
    $this->data = array
    (
      '0.5' => '0.5',
      '1' => '1',
      '1.5' => '1.5',
      '2' => '2',
      '2.5' => '2.5',
      '3' => '3',
      '3.5' => '3.5',
      '4' => '4',
      '4.5' => '4.5',
      '5' => '5',
    );
    
  }//end public function setDefaultDataProfile */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @return string
   */
  public function element( )
  {

    $id = $this->getId();

    /*
    $this->jsCode = <<<JS_CODE
\$S(function(){ // wait for document to load
var activ = null;
\$S('#wgt_box_{$id}  input.wgt_start_rating').rating({
focus: function(value, link){\$S('#{$id}_text').html( link.title );},
blur: function(value, link){\$S('#{$id}_text').html( activ  || '&nbsp;' );},
callback: function(value, link){activ = link.title;\$S('#h{$id}_text').html( link.title );}
});});
JS_CODE;
*/
    
  if (!isset($this->attributes['class'] ) )
  {
    $this->attributes['class'] = $id;
  } else {
    $this->attributes['class'] =  $this->attributes['class'].' '.$id;
  }
    
  

  $html = '<div id="'.$id.'" class="wcm wcm_ui_star_rating" >';
  
  $activTitle = '&nbsp;';
  
  $splitClass = '';
  $splitKey   = 'false';
  if ( 1 < (int)$this->starParts )
  {
    $splitClass = "{split:{$this->starParts}}";
    $splitKey = "true";
  }

  foreach($this->data as $value => $title )
  {
    
    if ($this->activ == $value )
    {
      $checked     = ' checked="checked" ';
      $activTitle  = $title;
    } else {
      $checked     = '';
    }
    
    $html .= '<input title="'.$title.'" id="'.$id.'-'.$value.'" onclick="$S(\'div#'.$id.'_text\').text(\''.$title.'\');"'
      .' value="'.$value.'" class="'.$this->attributes['class'].' wgt_start_rating wgt_ignore '.$splitClass.'"  '
      .$checked.' name="'.$this->attributes['name'].'" type="radio"  />'.NL;
  }

  $html .= <<<HTML
    <var id="{$id}-cfg-rating" >{"half":"{$splitKey}"}</var>
    <span id="{$id}_text" class="wgt_rating_text" style="white-space:nowrap;" >{$activTitle}</span>
    <input type="hidden" id="{$id}" class="{$this->assignedForm} wgt_value"  name="_{$this->attributes['name']}" value="{$this->activ}" />
  </div>
  
HTML;

    return $html;

  }//end public function build */

  /**
   *
   * @param $attributes
   * @return string
   */
  public function build($attributes = array() )
  {

    if ($attributes ) 
      $this->attributes = array_merge($this->attributes,$attributes);

    $bigClass = $this->bigLabel ? ' large':'';

    $required = $this->required?'<span class="wgt-required">*</span>':'';
    $id = $this->getId();

    $html = '<div class="wgt-box input" id="wgt-box-'.$id.'" >
      <label class="wgt-label" for="'.$id.'" >'.$this->label.' '.$required.'</label>
      <div class="wgt-input '.$this->width.'" >'.$this->element().'</div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>'.NL;

    return $html;

  }//end public function build */

}//end class WgtInputRatingbar


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
class WgtItemRatingbar
  extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/



/*//////////////////////////////////////////////////////////////////////////////
// constructors and magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct( $name = null )
  {
    parent::__construct($name);
  }//end public function __construct( $name = null )

/*//////////////////////////////////////////////////////////////////////////////
// getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  public function setContent( $data )
  {

  }

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @return string
   */
  public function build()
  {

     $activ = array();
     for( $nam = 0 ; $nam < 5 ; ++$nam )
     {
       $activ[$nam] = '';
     }

     if($this->activ)
     {
       $activ[$this->activ] = ' checked="checked" ';
     }
     else
     {
       $activ[0] = ' checked="checked" ';
     }

     if(isset($this->attributes['type']))
     {
       unset($this->attributes['type']);
     }
     if(isset($this->attributes['value']))
     {
       unset($this->attributes['value']);
     }
     $attributes = $this->asmAttributes();

  $html = <<<HTML
     <table style="width:250px;text-align:left;">
     <thead>
        <tr>
          <th style="width:20%" >bad</th>
          <th style="width:20%" >average</th>
          <th style="width:20%" >good</th>
          <th style="width:20%" >excellent</th>
          <th style="width:20%" >n/a</th>
        </tr>
     </thead>
     <tbody>

HTML;

     $html .= '<td><input type="radio" title="bad"      '.$attributes.' value="4" '.$activ[4].' /></td>';
     $html .= '<td><input type="radio" title="average"  '.$attributes.' value="3" '.$activ[3].' /></td>';
     $html .= '<td><input type="radio" title="good"     '.$attributes.' value="2" '.$activ[2].' /></td>';
     $html .= '<td><input type="radio" title="excellent" '.$attributes.' value="1" '.$activ[1].' /></td>';
     $html .= '<td><input type="radio" title="n/a"      '.$attributes.' value="0" '.$activ[0].' /></td>';
     $html .= '</tbody>';
     $html .= '</table>';

    return $html;

  }//end public function build()

}//end class WgtItemRadio


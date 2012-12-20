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
 * @lang de
 *
 * Basisklasse für Selectboxen
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtSelectbox
  extends WgtInput
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * should their be a first "empty/message" entry in the selectbox
   *
   * @var string
   */
  public $firstFree = ' ';

  /**
   * the url where to redirect on change
   * if this value is not null, the selectbox will redirect onChange to this url
   * and append the id as parameter
   * @var string
   */
  public $redirect  = null;

  /**
   * Selectboxen kann JavaScript code injiziert werden
   * @var string
   */
  public $jsCode    = null;

  /**
   * Die Url über welche die Datenquelle der Selectbox verwaltet werden kann
   * @var string
   */
  public $editUrl   = null;

  /**
   * Der aktive Wert der selectbox
   * @var string
   */
  public $activValue = null;
  
  /**
   * In case of filtering selectboxes, it can happen, that the active
   * value is filtered out, but should be displayed
   * Can happen in archive szenarios eg.
   * 
   * To solve that issue a closure can be set here that can load the missing entry
   * or entries in case of type multi
   * 
   * @var closure
   */
  public $loadActive = null;

////////////////////////////////////////////////////////////////////////////////
// Getter Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Setter for readonly
   * Readonly means, the user can't change it in the ui but the 
   * value will be saved / sended to the system
   * 
   * Happens, when the value is set by javascript.
   * If the value should not be send to the system use disable
   * 
   * @param boolean $readOnly
   */
  public function setReadOnly( $readOnly = true )
  {

    $this->readOnly = $readOnly;

    if( $readOnly )
    {
      $this->attributes['readonly'] = 'readonly';
    }
    else
    {
      if( isset($this->attributes['readonly']) )
        unset($this->attributes['readonly']);
    }
  }//end public function setReadOnly */

  /**
   * request the assembled js code for the selestbox
   *
   * @return string
   */
  public function getJsCode()
  {

    if( !$this->assembled )
    {
      $this->build();
    }

    return $this->jsCode;

  }//end public function getJsCode */

  /**
   * should the first entry be emtpy
   * @param boolean $firstFree
   */
  public function setFirstfree( $firstFree = true )
  {

    if( is_string($this->firstFree) )
    {
      $this->firstFree = $firstFree;
    }
    else if( !is_null($firstFree) )
    {
      $this->firstFree = $firstFree;
    }
    else 
    {
      $this->firstFree = null;
    }

  } // end public function setFirstfree */

  /**
   * request if the first option ist empty
   *
   * @return boolean/mixed
   */
  public function getFirstfree( )
  {
    return $this->firstFree;
  } // end public function getFirstfree  */

  /**
   * Redirect leitet on change auf die übergebene Url um
   * Der Wert des selectierten Eintrags wird angehängt
   * @param string $url
   */
  public function setRedirect( $url )
  {
    $this->redirect = $url;
  }//end public function setRedirect  */

  /**
   * Enter description here...
   *
   * @param string $field
   */
  public function setIdField( $field )
  {
    $this->idField = $field;
  }//end public function setIdField */

  /**
   * Selectbox auf multiple umschalten
   * @param boolean $multiple
   */
  public function setMultiple( $multiple = true )
  {

    if( $multiple )
    {
      $this->attributes['multiple'] = 'multiple';
    }
    else
    {
      if(isset($this->attributes['multiple']))unset($this->attributes['multiple']);
    }

  }//end public function setMultiple  */

  /**
   * Set the nnmber of entries / the size of the selectbox
   * @param int $size
   */
  public function setSize( $size  )
  {

    if( !isset($this->attributes['multiple']) )
    {
      $this->attributes['multiple'] = 'multiple';
    }

    $this->attributes['size'] = $size;

  }//end public function setSize  */

  /**
   *
   * @param array $show
   */
  public function setShow( $show )
  {

    $this->showEntry = array_merge( $this->showEntry , array_flip($show)  );

  }//end public function setShow  */

 /**
  * @param string $data
  * @param string $value
  * @return void
  */
  public function setData( $data , $value = null )
  {
    
    $this->data = $data;

    Debug::console( "Set Data " , $data);
    
  }// end public function setData */


  /**
   * @param boolean $active
   */
  public function setActive( $active = true )
  {
    $this->activ = $active;

  }//end public function setActive */

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////



  /**
   * @return string
   */
  public function buildAjax()
  {

    if(!isset($this->attributes['id']))
      return '';

    if( !isset($this->attributes['value']) )
      $this->attributes['value'] = '';

    $this->editUrl = null;

    if( $this->serializeElement )
    {

      $html = '<htmlArea selector="select#'.$this->attributes['id'].'" action="thml" ><![CDATA['
        .$this->element().']]></htmlArea>'.NL;
    }
    else
    {
      $html = '<htmlArea selector="select#'.$this->attributes['id'].'" action="value" ><![CDATA['
        .$this->activ.']]></htmlArea>'.NL;
    }

    return $html;

  }//end public function buildAjax */
  

  /**
   * @return string
   */
  public function buildJson()
  {
    
    $html = '';
    
    if( $this->firstFree )
      $dataStack = array( '{"i":"","v":"'.$this->firstFree.'"}' );
    else 
      $dataStack = array( );
    
    if( is_array( $this->data ) )
    {
      foreach( $this->data as $data )
      {
        $value  = $data['value'];
        $id     = $data['id'];
  
        $dataStack[] = '{"i":"'.$id.'","v":'.json_encode($value).'}';
      }
    }

    return '['.implode( ','.NL, $dataStack ).']';

  }//end public function buildJson */

  /**
   * @return string
   */
  public function element()
  {

    if( $this->redirect )
    {
      if( !isset($this->attributes['id']) )
      {
        Error::addError( 'got no id to redirect' );
      }
      else
      {
        $id   = $this->attributes['id'];
        $url  = $this->redirect;

        $this->attributes['onChange'] = "\$R.selectboxRedirect( '#".$this->attributes['id']."', '$url' )";
      }
    }

    if( isset( $this->attributes['size'] ) )
    {
      if( isset($this->attributes['class']) )
      {
        $this->attributes['class'] .= ' multi';
      }
      else
      {
        $this->attributes['class'] = 'multi';
      }
    }



    $codeOptions = '';
      
    $errorMissingActive = 'The previous selected dataset not exists anymore. Select a new entry to fix that issue!';
    
    if( $this->data )
    {

      if( !isset( $this->attributes['multiple'] ) )
      {

        foreach( $this->data as $data )
        {
          
          $value  = $data['value'];
          $id     = $data['id'];

          if( $this->activ == $id  )
          {
            $codeOptions .= '<option selected="selected" value="'.$id.'" >'.$value.'</option>'.NL;
            $this->activValue = $value;
          }
          else
          {
            $codeOptions .= '<option value="'.$id.'" >'.$value.'</option>'.NL;
          }

        }
        
        if( !is_null($this->activ) && is_null($this->activValue) )
        {
          
          if( $this->loadActive )
          {
            
            $cl = $this->loadActive;
            
            $activeData = $cl( $this->activ );
            
            if( $activeData )
            {
              $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
              $this->activValue = $activeData['value'];
            }
            else
            {
              $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
              $this->activValue = '**Invalid target**';
              
              $this->attributes['title'] = $errorMissingActive;
            }
          }
          else 
          {
            $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
            $this->activValue = '**Invalid target**';
            
            $this->attributes['title'] = $errorMissingActive;
          }
        }
                
      }
      else
      {

        foreach( $this->data as $data )
        {
          $value  = $data['value'];
          $id     = $data['id'];

          if( is_array($this->activ) && in_array($id,$this->activ) )
          {
            $codeOptions .= '<option selected="selected" value="'.$id.'" >'.$value.'</option>'.NL;
            $this->activValue = $value;
          }
          else
          {
            $codeOptions .= '<option value="'.$id.'" >'.$value.'</option>'.NL;
          }

        }
        
        if( !is_null($this->activ) && is_null($this->activValue) )
        {
          
          if( $this->loadActive )
          {
            
            $cl = $this->loadActive;
            $activeData = $cl( $this->activ );
            
            if( $activeData )
            {
              $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
              $this->activValue = $activeData['value'];
            }
            else
            {
              $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
              $this->activValue = '**Invalid target**';
              
              $this->attributes['title'] = $errorMissingActive;
            }
          }
          else 
          {
            $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
            $this->activValue = '**Invalid target**';
            
            $this->attributes['title'] = $errorMissingActive;
          }
        }
        
      }
    }
    else
    {
      
      if( !is_null($this->activ) && is_null($this->activValue) )
      {
        
        if( $this->loadActive )
        {
          
          $cl = $this->loadActive;
          $activeData = $cl( $this->activ );
          
          if( $activeData )
          {
            $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
            $this->activValue = $activeData['value'];
          }
          else
          {
            $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
            $this->activValue = '**Invalid target**';
            
            $this->attributes['title'] = $errorMissingActive;
          }
        }
        else 
        {
          $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
          $this->activValue = '**Invalid target**';
          
          $this->attributes['title'] = $errorMissingActive;
        }
      }

    }
    
    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;

    if( !is_null($this->firstFree) )
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;
    
    $select .= $codeOptions;
    
    
    if( $this->firstFree && !$this->activValue )
      $this->activValue = $this->firstFree;

    $select .= '</select>'.NL;


    return $select;

  }//end public function element  */

  /**
   * @param string $id
   * @param string $name
   * @param string $active
   */
  public function listElement( $id, $name, $active = null )
  {

    $this->attributes['id'] = $id;
    $this->attributes['name'] = $name;

    if( isset( $this->attributes['size'] ) )
    {
      if( isset($this->attributes['class']) )
      {
        $this->attributes['class'] .= ' multi';
      }
      else
      {
        $this->attributes['class'] = 'multi';
      }
    }

    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;

    if( !is_null($this->firstFree) )
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;


    if( !isset( $this->attributes['multiple'] ) )
    {
      foreach( $this->data as $data )
      {
        $value  = $data['value'];
        $id     = $data['id'];

        if( $active == $id  )
        {
          $select .= '<option selected="selected" value="'.$id.'" >'.$value.'</option>'.NL;
          $this->activValue = $value;
        }
        else
        {
          $select .= '<option value="'.$id.'" >'.$value.'</option>'.NL;
        }

      }
    }
    else
    {
      foreach( $this->data as $data )
      {
        $value  = $data['value'];
        $id     = $data['id'];

        if( is_array($active) && in_array($id,$active) )
        {
          $select .= '<option selected="selected" value="'.$id.'" >'.$value.'</option>'.NL;
          $this->activValue = $value;
        }
        else
        {
          $select .= '<option value="'.$id.'" >'.$value.'</option>'.NL;
        }

      }
    }

    if( $this->firstFree && !$this->activValue )
      $this->activValue = $this->firstFree;

    $select .= '</select>'.NL;


    return $select;

  }//end public function listElement  */

  /**
   * @param array $attributes
   * @return string
   */
  public function niceElement( $attributes = array() )
  {

    if( $attributes )
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type'] = 'text';
    $value = null;

    if( isset( $this->attributes['value'] ) )
    {
      $value = $this->attributes['value'];
    }

    $id       = $this->getId();

    $fName    = $this->attributes['name'];

    $required = $this->required?'<span class="wgt-required">*</span>':'';

    if( $this->editUrl )
    {
      //$select .= '<a href="'.$this->editUrl.'" class="wcm wcm_req_ajax" >'
      //  .Wgt::icon('control/edit.png','xsmall',array('alt'=>'edit')).'</a>'.NL;
    }


    $this->attributes['class'] = isset($this->attributes['class'])
      ? $this->attributes['class'].' wcm wcm_widget_selectbox'
      : 'wcm wcm_widget_selectbox';


    if( $this->readOnly )
    {
      $attrRo       = 'wgt-readonly';
    }
    else
    {
      $attrRo = '';
    }
    
    $element = $this->element();


    return $element;

  } // end public function niceElement */

  /**
   * @param array $attributes
   * @return string
   */
  public function build( $attributes = array() )
  {

    if( $attributes )
      $this->attributes = array_merge( $this->attributes, $attributes );

    // ist immer ein text attribute
    $this->attributes['type'] = 'text';
    $value = null;

    if( isset( $this->attributes['value'] ) )
    {
      $value = $this->attributes['value'];
    }

    /*
    if($this->link)
      $this->texts->afterInput = '<p><a href="'.$this->link.'" target="new_download" >'.$value.'</a></p>';
    */

    $id       = $this->getId();

    $fName    = $this->attributes['name'];

    $required = $this->required?'<span class="wgt-required">*</span>':'';

    if( $this->editUrl )
    {
      //$select .= '<a href="'.$this->editUrl.'" class="wcm wcm_req_ajax" >'
      //  .Wgt::icon('control/edit.png','xsmall',array('alt'=>'edit')).'</a>'.NL;
    }

    if( isset( $this->attributes['multiple'] ) )
    {

      $html = <<<HTML
    <div class="wgt-box input" id="wgt-box{$id}" >
      {$this->texts->topBox}
      <label class="wgt-label {$this->labelSize}" for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}</label>
      {$this->texts->middleBox}
      <div class="wgt-input {$this->width}" >{$this->element()}{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

HTML;

    }
    else
    {

      $this->attributes['class'] = isset($this->attributes['class'])
        ? $this->attributes['class'].' wcm wcm_widget_selectbox'
        : 'wcm wcm_widget_selectbox';

      if( $this->required )
      {
        $this->attributes['class'] .=' wcm_valid_required';
      }
        
      if( $this->readOnly )
      {
        $classRo = ' wgt-readonly';
      }
      else
      {
        $classRo = '';
      }

      $element = $this->element();

      $html = <<<HTML
    <div class="wgt-box input" id="wgt-box-{$id}" >
      {$this->texts->topBox}
      <label class="wgt-label {$this->labelSize}" for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}</label>
      {$this->texts->middleBox}
      <div class="wgt-input {$this->width}" >{$element}{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

HTML;
    }

    return $html;

  } // end public function build */

}//end class WgtItemSelectbox


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
class WgtSelectboxEnum extends WgtSelectbox
{

  /**
   * Firstfree ist hier ein String kein boolean
   * @var string
   */
  public $firstFree = null;

  /**
   * @var boolean
   */
  public $checkIcons = false;

  /**
   * Eine Klasse um die Semantic der selectbox zu beschreiben,
   * z.B. priority
   * Wird benötigt wenn zb Hintergrundbilder in die Options gelegt werden sollen
   * @var string
   */
  public $semanticClass = null;

  /**
   * Layouts
   * @var array
   */
  public $layouts = array();

  /**
   * @var string
   */
  public $width = 'medium';

  /**
   * @param string $name
   */
  public function __construct($name = null)
  {

    parent::__construct($name);
    $this->init();

  }//end public function __construct($name)

  /**
   */
  public function init()
  {

  }//end public function init */

  /**
   * @type getter
   * @param string $key
   * {
   *   @default null only for compatibility to <class>WgtInput</class>
   * }
   */
  public function getData($key = null)
  {

    if (!isset($this->data[$key])) {
      return null;
    }

    return $this->data[$key];

  }//end public function getData */
  
  /**
   * @type getter
   * @param string $key
   * {
   *   @default null only for compatibility to <class>WgtInput</class>
   * }
   */
  public function getListData()
  {

    return $this->data;
  
  }//end public function getListData */

  /**
   * Checken ob für den Status ein Icon hinterlegt wurde
   * @param string $key
   * @return string
   */
  public function getIcon($key = null)
  {

    if (!isset($this->layouts[$key]['icon'])) {
      return null;
    }

    return $this->layouts[$key]['icon'];

  }//end public function getIcon */

  /**
   * Checken ob für den Status ein Icon hinterlegt wurde
   * @param string $key
   * @return string
   */
  public function getBg($key = null)
  {

    if (!isset($this->layouts[$key]['bg'])) {
      return null;
    }

    return $this->layouts[$key]['bg'];

  }//end public function getBg */

  /**
   * Checken ob für den Status ein Icon hinterlegt wurde
   * @param string $key
   * @return string
   */
  public function getLabel($key = null)
  {

    if (!isset($this->data[$key])) {
      return null;
    }

    return $this->data[$key];

  }//end public function getLabel */

  /**
   * @return int
   */
  public function getDataSize()
  {
    return count($this->data);
  }//end public function getDataSize */

  /**
   * (non-PHPdoc)
   * @see wgt/WgtInput#build($attributes)
   */
  public function build($attributes = array())
  {

    $id = $this->getId();

    if ($this->redirect) {
      if (!isset($this->attributes['id'])) {
        throw new Wgt_Exception('Missing required ID in Selectbox '.$this->debugData());
      } else {
        $id   = $this->attributes['id'];
        $url  = $this->redirect;

        $this->attributes['onChange'] = "redirectFromSelectbox('$url', '$id')";
      }
    }

    if ($this->semanticClass) {
      if (isset($this->attributes['class'])) {
        $this->attributes['class'] .= ' '.$this->semanticClass;
      } else {
        $this->attributes['class'] = $this->semanticClass;
      }
    }


    $this->attributes['class'] = isset($this->attributes['class'])
      ? $this->attributes['class'].' wcm wcm_widget_selectbox '.$this->width
      : 'wcm wcm_widget_selectbox '.$this->width;

    $attributes = $this->asmAttributes();
    $required   = $this->required?'<span class="wgt-required">*</span>':'';

    $select = '<select '.$attributes.' >'.NL;

    if ($this->firstFree)
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;

    $helpIcon = $this->renderDocu($id);

    if (is_array($this->activ)  ) {

      foreach ($this->data as $id => $value) {

        $optClass  = '';

        // wenn activ vohanden ist wird darauf gegrüft
        // ansonsten wird auf den default checked value aus den daten geprüft
        // isset genügt, das heißt der parameter ist optional in den daten

        $selected = '';

        if ($this->activ) {
          $selected = (in_array($id , $this->activ)) ? 'selected="selected"' : '';
        }

        if ($this->checkIcons && isset($this->layouts[$id])) {
          $optClass = ' class="'.$this->layouts[$id]['class'].'" ';
        }

        $select .= '<option '.$selected.$optClass.' value="'.$id.'" >'.$value.'</option>'.NL;
      }

    } else {

      if(!is_array($this->data)){
        Debug::console("Enum had no array data");
        $this->data = array();
      }

      foreach ($this->data as $id => $value) {

        $optClass  = '';

        if ($this->activ) {
          $selected = ($this->activ == $id)
            ? 'selected="selected"'
            : '';
        } else {
          $selected = '';
        }

        if ($this->checkIcons && isset(static::$layouts[$id])) {
          $optClass = ' class="'.static::$layouts[$id]['class'].'" ';
        }

        $select .= '<option '.$selected.$optClass.' value="'.$id.'" >'.$value.'</option>'.NL;
      }
    }

    $select .= '</select>'.NL;

    $html = '<div id="wgt_box_'.$this->attributes['id'].'" >
      <div class="wgt-label" ><label  for="'.$this->attributes['id'].'" >'.$this->label.' '.$required.'</label>'.$helpIcon.'</div>
      <div class="wgt-input" >'.$select.'</div>
    </div>'.NL;

    return $html;

  }//end public function build

  /**
   * @return string
   */
  public function element()
  {

    if ($this->redirect) {
      if (!isset($this->attributes['id'])) {
        throw new Wgt_Exception('Missing required ID in Selectbox '.$this->debugData());
      } else {
        $id   = $this->attributes['id'];
        $url  = $this->redirect;

        $this->attributes['onChange'] = "redirectFromSelectbox('$url', '$id')";
      }
    }

    if ($this->semanticClass) {
      if (isset($this->attributes['class'])) {
        $this->attributes['class'] .= ' '.$this->semanticClass;
      } else {
        $this->attributes['class'] = $this->semanticClass;
      }
    }

    $this->attributes['class'] = isset($this->attributes['class'])
      ? $this->attributes['class'].' wcm wcm_widget_selectbox '.$this->width
      : 'wcm wcm_widget_selectbox '.$this->width;

    $attributes = $this->asmAttributes();
    $required = $this->required?'<span class="wgt-required" >*</span>':'';

    $select = '<select '.$attributes.' >'.NL;

    if ($this->firstFree)
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;

     $selected = '';

    if (is_array($this->activ) ) {

      foreach ($this->data as $id => $value) {

        $optClass  = '';

        if ($this->activ) {
          $selected = (in_array($id , $this->activ))
            ? 'selected="selected"'
            : '';
        }

        if ($this->checkIcons && isset($this->layouts[$id])) {
          $optClass = ' class="'.$this->layouts[$id]['class'].'" ';
        }

        $select .= '<option '.$selected.$optClass.' value="'.$id.'" >'.$value.'</option>'.NL;
      }

    } else {

      foreach ($this->data as $id => $value) {

        $optClass = '';

        if ($this->activ) {
          $selected = ($this->activ == $id)
            ? 'selected="selected"'
            : '';
        }

        if ($this->checkIcons && isset($this->layouts[$id])) {
          $optClass = ' class="'.$this->layouts[$id]['class'].'" ';
        }

        $select .= '<option '.$selected.$optClass.' value="'.$id.'" >'.$value.'</option>'.NL;
      }
    }

    $select .= '</select><var>{"width":"'.$this->width.'"}</var>'.NL;

    return $select;

  }//end public function build */

} // end class WgtSelectboxEnum

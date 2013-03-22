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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtDynSelectbox extends WgtSelectbox
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Selectbox wird gefiltert
   * @var string
   */
  public $isFilteredBy = null;

  /**
   * Der Filter Key
   * @var string
   */
  public $activeFilter = null;

  /**
   * Die Selectbox ist ein filter
   * @var boolean
   */
  public $isFilter = false;

  /**
   * @var boolean
   */
  public $activeKey = false;

  /**
   * Liste der Filter keys
   * @var array
   */
  public $filterKeys = array();

/*//////////////////////////////////////////////////////////////////////////////
// Render Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function element()
  {

    $filterKey   = '';
    $codeOptions = '';

    if (isset($this->attributes['type']))
      unset($this->attributes['type']);

    if (isset($this->attributes['size'])) {
      if (isset($this->attributes['class'])) {
        $this->attributes['class'] .= ' multi';
      } else {
        $this->attributes['class'] = 'multi';
      }
    }

    /*
    if (!is_null($this->firstFree))
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;
    */

    $errorMissingActive = 'The previous selected dataset not exists anymore. Select a new entry to fix that issue!';

    if ($this->data) {

      if (!isset($this->attributes['multiple'])) {

        foreach ($this->data as $data) {

          if ($this->isFilteredBy) {
            if ($data['filter']) {
              $lowFilter = strtolower($data['filter']);

              $this->filterKeys[$data['filter_id']] = $lowFilter;
              $filter = 'filter_'.$lowFilter;
            } else {
              $filter = 'no_filter';
            }
          } else {
            $filter = '';
          }

          if (isset($data['filter_key']))
            $filterKey = ' filter_key="'.strtolower($data['filter_key']).'" ';
          else
            $filterKey = '';

          $value  = $data['value'];
          $id     = $data['id'];

          if ($this->activ == $id) {
            $codeOptions .= '<option class="'.$filter.'" '
              .$filterKey.' selected="selected" value="'
              .$id.'" >'.$value.'</option>'.NL;
            $this->activValue = $value;

            if (isset($data['filter']))
              $this->activeKey  = strtolower($data['filter']);
          } else {
            $codeOptions .= '<option class="'.$filter.'" '
              .$filterKey.' value="'.$id.'" >'
              .$value.'</option>'.NL;
          }

        }

        if (!is_null($this->activ) && is_null($this->activValue)) {

          if ($this->loadActive) {

            $cl = $this->loadActive;

            $activeData = $cl($this->activ);

            if ($activeData) {
              $codeOptions = '<option selected="selected" class="no_filter inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
              $this->activValue = $activeData['value'];
            } else {
              $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
              $this->activValue = '**Invalid target**';

              $this->attributes['title'] = $errorMissingActive;
            }
          } else {
            $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
            $this->activValue = '**Invalid target**';

            $this->attributes['title'] = $errorMissingActive;
          }
        }

      } else {

        $this->activeKey = array();

        foreach ($this->data as $data) {

          if ($this->isFilteredBy) {
            if ($data['filter']) {
              $filter = 'filter_'.strtolower($data['filter']);
              $this->filterKeys[$data['filter_id']] = strtolower($data['filter']);
            } else {
              $filter = 'no_filter';
            }
          } else {
            $filter = '';
          }

          if (isset($data['filter_key']))
            $filterKey = ' filter_key="'.strtolower($data['filter_key']).'" ';
          else
            $filterKey = '';

          $value  = $data['value'];
          $id     = $data['id'];

          if (is_array($this->activ) && in_array($id,$this->activ)) {
            $codeOptions .= '<option class="'.$filter.'" '
              .$filterKey.' selected="selected"  value="'
              .$id.'" >'.$value.'</option>'.NL;
            $this->activValue = $value;

            if (isset($data['filter']))
              $this->activeKey[] = strtolower($data['filter']);
          } else {
            $codeOptions .= '<option class="'.$filter.'" '
              .$filterKey.' value="'.$id.'" >'
              .$value.'</option>'.NL;
          }

        }

        if (!is_null($this->activ) && is_null($this->activValue)) {

          if ($this->loadActive) {

            $cl = $this->loadActive;
            $activeData = $cl($this->activ);

            if ($activeData) {
              $codeOptions = '<option selected="selected" class="no_filter inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
              $this->activValue = $activeData['value'];
            } else {
              $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
              $this->activValue = '**Invalid target**';

              $this->attributes['title'] = $errorMissingActive;
            }
          } else {
            $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
            $this->activValue = '**Invalid target**';

            $this->attributes['title'] = $errorMissingActive;
          }
        }

      }
    } else {

      if (!is_null($this->activ) && is_null($this->activValue)) {

        if ($this->loadActive) {

          $cl = $this->loadActive;
          $activeData = $cl($this->activ);

          if ($activeData) {
            $codeOptions = '<option selected="selected" class="no_filter inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
            $this->activValue = $activeData['value'];
          } else {
            $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
            $this->activValue = '**Invalid target**';

            $this->attributes['title'] = $errorMissingActive;
          }
        } else {
          $codeOptions = '<option selected="selected" class="missing" value="'.$this->activ.'" >**Invalid target**</option>'.NL.$codeOptions;
          $this->activValue = '**Invalid target**';

          $this->attributes['title'] = $errorMissingActive;
        }
      }

    }

    if ($this->firstFree && !$this->activValue)
      $this->activValue = $this->firstFree;

    if (($this->isFilter || $this->isFilteredBy) && false !== strpos($this->attributes['class'], 'wcm '))
      $this->attributes['class'] .= ' wcm';

    if ($this->isFilter)
      $this->attributes['class'] .= ' wcm_ui_selectbox_filter wcm_widget_selectbox';

    if ($this->isFilteredBy)
      $this->attributes['class'] .= ' wcm_ui_selectbox_filtered wgt-filter-select-'.$this->isFilteredBy;

    //Debug::console('Active filter ', $this->activeFilter);

    if ($this->activeFilter && isset($this->filterKeys[(string) $this->activeFilter])) {
      $this->attributes['wgt_filter'] = 'filter_'.$this->filterKeys[(string) $this->activeFilter];
    }

    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;
    $select .= $codeOptions;
    $select .= '</select>'.NL;

    return $select;

  }//end public function element  */

  /**
   * @param array $attributes
   * @return string
   */
  public function niceElement($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes,$attributes);

    // ist immer ein text attribute
    $this->attributes['type'] = 'text';
    $value = null;

    if (isset($this->attributes['value'])) {
      $value = $this->attributes['value'];
    }

    $id       = $this->getId();

    $fName    = $this->attributes['name'];

    $required = $this->required?'<span class="wgt-required">*</span>':'';

    if ($this->editUrl) {
      //$select .= '<a href="'.$this->editUrl.'" class="wcm wcm_req_ajax" >'
      //  .Wgt::icon('control/edit.png','xsmall',array('alt'=>'edit')).'</a>'.NL;
    }

    /*
    $this->attributes['class'] = isset($this->attributes['class'])
      ? $this->attributes['class'].' wcm wcm_widget_selectbox'
      : 'wcm wcm_widget_selectbox';
    */

    if ($this->readOnly) {
      $attrRo       = 'wgt-readonly';
    } else {
      $attrRo = '';
    }

    $element = $this->element();

    return $this->element();

  } // end public function niceElement */

  /**
   * @param array $attributes
   * @return string
   */
  public function build($attributes = array())
  {

    if ($attributes)
      $this->attributes = array_merge($this->attributes, $attributes);

    // ist immer ein text attribute
    $this->attributes['type'] = 'text';
    $value = null;

    if (isset($this->attributes['value'])) {
      $value = $this->attributes['value'];
    }

    /*
    if ($this->link)
      $this->texts->afterInput = '<p><a href="'.$this->link.'" target="new_download" >'.$value.'</a></p>';
    */

    $id       = $this->getId();

    $fName    = $this->attributes['name'];

    $required = $this->required?'<span class="wgt-required">*</span>':'';

    if ($this->editUrl) {
      //$select .= '<a href="'.$this->editUrl.'" class="wcm wcm_req_ajax" >'
      //  .Wgt::icon('control/edit.png','xsmall',array('alt'=>'edit')).'</a>'.NL;
    }

    if (isset($this->attributes['multiple'])) {

      $html = <<<HTML
    <div class="wgt-box input" id="wgt-box{$id}" >
      {$this->texts->topBox}
      <label class="wgt-label" for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}</label>
      {$this->texts->middleBox}
      <div class="wgt-input {$this->width}" >{$this->element()}{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

HTML;

    } else {

      /*
      $this->attributes['class'] = isset($this->attributes['class'])
        ? $this->attributes['class'].' wcm wcm_widget_selectbox'
        : 'wcm wcm_widget_selectbox';
      */

      if ($this->readOnly) {
        $classRo = ' wgt-readonly';
      } else {
        $classRo = '';
      }

      $element = $this->element();

      $html = <<<HTML
    <div class="wgt-box input" id="wgt-box-{$id}" >
      {$this->texts->topBox}
      <label class="wgt-label" for="{$id}" >{$this->texts->beforeLabel}{$this->label}{$this->texts->afterLabel} {$required}{$this->texts->endLabel}</label>
      {$this->texts->middleBox}
      <div class="wgt-input {$this->width}" >{$element}{$this->texts->afterInput}</div>
      {$this->texts->bottomBox}
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

HTML;
    }

    return $html;

  } // end public function build */

} // end class WgtDynSelectbox


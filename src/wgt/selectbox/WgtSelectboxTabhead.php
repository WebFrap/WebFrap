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
 * @subpackage wgt
 */
class WgtSelectboxTabhead extends WgtSelectbox
{

  /**
   * @return string
   */
  public function element()
  {

    if ($this->redirect) {
      if (!isset($this->attributes['id'])) {
        Error::addError('got no id to redirect');
      } else {
        $id   = $this->attributes['id'];
        $url  = $this->redirect;

        $this->attributes['onChange'] = "\$R.selectboxRedirect('#".$this->attributes['id']."', '{$url}')";
      }
    }

    if (isset($this->attributes['size'])) {
      if (isset($this->attributes['class'])) {
        $this->attributes['class'] .= ' multi';
      } else {
        $this->attributes['class'] = 'multi';
      }
    }



    $codeOptions = '';

    $errorMissingActive = 'The previous selected dataset not exists anymore. Select a new entry to fix that issue!';

    if ($this->data) {

      if (!isset($this->attributes['multiple'])) {

        foreach ($this->data as $data) {

          $value  = $data['value'];
          $id     = $data['id'];
          $key    = isset($data['key'])? ' key="'.trim($data['key']).'" ':'' ;

          if ($this->activ == $id) {
            $codeOptions .= '<option selected="selected" value="'.$id.'" wgt_tab="'.$id.'" '.$key.' >'.$value.'</option>'.NL;
            $this->activValue = $value;
          } else {
            $codeOptions .= '<option value="'.$id.'" wgt_tab="'.$id.'" '.$key.' >'.$value.'</option>'.NL;
          }

        }

        if (!is_null($this->activ) && is_null($this->activValue)) {

          if ($this->loadActive) {

            $cl = $this->loadActive;

            $activeData = $cl($this->activ);

            if ($activeData) {
              $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
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

        foreach ($this->data as $data) {
          $value  = $data['value'];
          $id     = $data['id'];
          $key    = isset($data['key'])? ' key="'.trim($data['key']).'" ':'' ;

          if (is_array($this->activ) && in_array($id,$this->activ)) {
            $codeOptions .= '<option selected="selected" value="'.$id.'" wgt_tab="'.$id.'" '.$key.' >'.$value.'</option>'.NL;
            $this->activValue = $value;
          } else {
            $codeOptions .= '<option value="'.$id.'" wgt_tab="'.$id.'" '.$key.' >'.$value.'</option>'.NL;
          }

        }

        if (!is_null($this->activ) && is_null($this->activValue)) {

          if ($this->loadActive) {

            $cl = $this->loadActive;
            $activeData = $cl($this->activ);

            if ($activeData) {
              $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
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
            $codeOptions = '<option selected="selected" class="inactive" value="'.$activeData['id'].'" >'.$activeData['value'].'</option>'.NL.$codeOptions;
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

    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;

    if (!is_null($this->firstFree))
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;

    $select .= $codeOptions;


    if ($this->firstFree && !$this->activValue)
      $this->activValue = $this->firstFree;

    $select .= '</select>'.NL;

    return $select;

  }//end public function element  */

  /**
   * @param string $id
   * @param string $name
   * @param string $active
   */
  public function listElement($id, $name, $active = null)
  {

    $this->attributes['id'] = $id;
    $this->attributes['name'] = $name;

    if (isset($this->attributes['size'])) {
      if (isset($this->attributes['class'])) {
        $this->attributes['class'] .= ' multi';
      } else {
        $this->attributes['class'] = 'multi';
      }
    }

    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;

    if (!is_null($this->firstFree))
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;


    if (!isset($this->attributes['multiple'])) {
    	foreach ($this->data as $data) {

    		$value  = $data['value'];
    		$idKey  = $data['id'];
    		$key    = isset($data['key'])? ' key="'.trim($data['key']).'" ':'' ;

    		if ($active === $idKey) {
    			$select .= '<option selected="selected" value="'.$idKey.'" wgt_tab="'.$idKey.'" '.$key.' >'.$value.'</option>'.NL;
    			$this->activValue = $value;
    		} else {
    			$select .= '<option value="'.$idKey.'" wgt_tab="'.$idKey.'" '.$key.' >'.$value.'</option>'.NL;
    		}

    	}
    } else {
      foreach ($this->data as $data) {
        $value  = $data['value'];
        $idKey     = $data['id'];
        $key    = isset($data['key'])? ' key="'.trim($data['key']).'" ':'' ;

        if (is_array($active) && in_array($idKey,$active)) {
          $select .= '<option selected="selected" value="'.$idKey.'" wgt_tab="'.$idKey.'" '.$key.' >'.$value.'</option>'.NL;
          $this->activValue = $value;
        } else {
          $select .= '<option value="'.$idKey.'" wgt_tab="'.$idKey.'" '.$key.' >'.$value.'</option>'.NL;
        }

      }
    }

    if ($this->firstFree && !$this->activValue)
      $this->activValue = $this->firstFree;

    $select .= '</select>'.NL;

    return $select;

  }//end public function listElement  */


}//end class WgtSelectboxTabhead


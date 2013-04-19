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
class WgtSelectboxAbstract extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /** should their be a first "empty/message" entry in the selectbox
   */
  public $firstFree = ' ';

  /**
   * the url where to redirect on change
   * if this value is not null, the selectbox will redirect onChange to this url
   * and append the id as parameter
   * @var string
   */
  public $redirect = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Default Constructor for a selectbox Item
   * @param string Name Der Name der Selectbox
   * @param boolean
   * @return void
   */
  public function __construct($name , $firstFree = null)
  {
    parent::__construct($name , __class__);

    if (is_string($this->firstFree)) {
       $this->firstFree = $firstFree;
    } elseif (!is_null($firstFree)) {
      $this->firstFree = $firstFree;
    }

  } // end of member function __construct

/*//////////////////////////////////////////////////////////////////////////////
// Getter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param boolean $readOnly
   */
  public function setReadOnly($readOnly = true)
  {

    if ($readOnly) {
      $this->attributes['readonly'] = 'readonly';
    } else {
      if (isset($this->attributes['readonly'])) {
        unset($this->attributes['readonly']);
      }
    }

  }//end public function setReadOnly */

  /**
   * request the assembled js code for the selestbox
   *
   * @return string
   */
  public function getJsCode()
  {

    if (!$this->assembled) {
      $this->build();
    }

    return $this->jsCode;

  }//end public function getJsCode()

  /**
   * should the first entry be emtpy
   * @param boolean $firstFree
   * @return void
   */
  public function setFirstfree($firstFree = true)
  {

    if (is_string($this->firstFree)) {
       $this->firstFree = $firstFree;
    } elseif (!is_null($firstFree)) {
      $this->firstFree = $firstFree;
    }

  } // end public function setFirstfree */

  /**
   * request if the first option ist empty
   *
   * @return boolean/mixed
   */
  public function getFirstfree()
  {
    return $this->firstFree;
  } // end public function getFirstfree */

  /**
   * @param string $url
   */
  public function setRedirect($url)
  {
    $this->redirect = $url;
  }//end public function setRedirect */

  /**
   * @param string $field
   */
  public function setIdField($field)
  {
    $this->idField = $field;
  }//end public function setIdField($field)

  /**
   * @param string $multiple
   */
  public function setMultiple($multiple = true)
  {

    if ($multiple) {
      $this->attributes['multiple'] = 'multiple';
    } else {
      if (isset($this->attributes['multiple']))
        unset($this->attributes['multiple']);
    }

  }//end public function setMultiple($multiple = true)

  /**
   * @param string $size
   */
  public function setSize($size  )
  {

    if ($size) {
      $this->attributes['size'] = $size;
    } else {
      if (isset($this->attributes['size']))
        unset($this->attributes['size']);
    }

  }//end public function setSize($size  )

  /**
   * @param array $show
   */
  public function setShow($show)
  {

    $this->showEntry = array_merge($this->showEntry , array_flip($show)  );

  }//end public function setShow */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function build()
  {

    if ($this->redirect) {
      if (!isset($this->attributes['id'])) {
        Error::addError
        (
        'got no id to redirect'
        );
      } else {
        $id = $this->attributes['id'];
        $url = $this->redirect;

        $this->attributes['onChange'] = "\$S('#$id')selectboxRedirect('$url')";
      }
    }

    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;

    if (!is_null($this->firstFree)) {
      $select .= '<option value=" ">'.$this->firstFree.'</option>'.NL;
    }

    if (is_array($this->activ)  ) {
      foreach ($this->data as $data) {
        $value  = $data['value'];
        $id     =   $data['id'];

        $selected = (in_array($id,$this->activ))? 'selected="selected"' : '';
        $select .= '<option '.$selected.' value="'.$id.'">'.$value.'</option>'.NL;
      }
    } else {
      foreach ($this->data as $data) {
        $value  = $data['value'];
        $id     =   $data['id'];

        $selected = ($this->activ == $id)? 'selected="selected"' : '';
        $select .= '<option '.$selected.' value="'.$id.'">'.$value.'</option>'.NL;
      }
    }

    $select .= '</select>'.NL;

    return $select;

  }//end public function build()

} // end class WgtItemSelectbox


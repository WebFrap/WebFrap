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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class AclMgmt_Selectbox_Access extends WgtSelectbox
{

  /**
   *
   */
  public function element()
  {

    $attributes = $this->asmAttributes();

    $select = '<select '.$attributes.' >'.NL;

    if (!is_null($this->firstFree) )
      $select .= '<option value=" " >'.$this->firstFree.'</option>'.NL;

    foreach (Acl::$accessLevels as $value => $id) {

      if ($this->activ == $id) {
        $select .= '<option selected="selected" value="'.$id.'" >'.$value.'</option>'.NL;
        $this->activValue = $value;
      } else {
        $select .= '<option value="'.$id.'" >'.$value.'</option>'.NL;
      }

    }

    if ($this->firstFree && !$this->activValue )
      $this->activValue = $this->firstFree;

    $select .= '</select>'.NL;

    return $select;

  }//end public function element  */

}// end class AclMgmt_Selectbox_Access */


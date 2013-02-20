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
 * Input element for Intvalues
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputInt extends WgtInput
{

 /**
  * @return string
  */
  public function element( )
  {

    $this->classes['ar'] = 'ar';

    return '<input '.$this->asmAttributes().' />';

  }// end public function element */

} // end class WgtInputInt


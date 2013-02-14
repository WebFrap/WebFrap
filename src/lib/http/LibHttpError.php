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
  * Php Backend für die Internationalisierungsklasse
  * @package WebFrap
  * @subpackage tech_core
  */
class LibHttpError
{
  
  public $data = null;
  
  public function __construct($data )
  {
    $this->data = $data;
  }
  
  
} // end class LibHttpError


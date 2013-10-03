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
 * Static Interface to get the activ configuration object
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Manager extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// pool logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param PBase $env
   */
  public function __construct($env = null)
  {

  	if(!$env)
  		$env = Webfrap::$env;

    $this->env = $env;

  } //end public function __construct */


}// end class Manager

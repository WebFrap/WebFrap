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
 *
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class ContextForm
  extends Context
{

  public $publish       = null;

  public $targetId      = null;

  public $target        = null;

  public $targetMask    = null;

  public $refId         = null;

  public $ltype         = null;

  /**
   *
   * Die Rootarea des Pfades über den wir gerade in den rechten wandeln
   * @var string $aclRoot
   */
  public $aclRoot       = null;

  public $aclRootId     = null;

  public $aclKey        = null;

  public $aclLevel      = null;

  public $aclNode       = null;


} // end class TFlagForm


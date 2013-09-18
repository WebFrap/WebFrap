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
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibAclContainer_DomainDataset extends LibAclContainer_Dataset
{

  /**
   * @var DomainNode
   */
  public $domainNode = null;

  /**
   * @lang:de
   * Einfacher Konstruktor,
   * Der Konstruktor stell sicher, dass die minimal notwendigen daten vorhanden sind.
   *
   * @param Base $env
   * @param DomainNode $domainNode
   * @param int   $level das zugriffslevel
   * @param array $level array as named parameter access_level,partial
   * {
   *    @see LibAclPermission::$level
   * }
   *
   * @param int $refLevel
   * {
   *   @see LibAclPermission::$refBaseLevel
   * }
   */
  public function __construct(
    $env,
    $domainNode,
    $level = null,
    $refBaseLevel = null
  ) {

    $this->env = $env;

    $this->domainNode = $domainNode;
    $this->aclKey = $domainNode->aclBaseKey;
    $this->aclPath = $domainNode->domainAcl;

    $this->levels = Acl::$accessLevels;

    if (!is_null($level))
      $this->setPermission($level, $refBaseLevel);

  }//end public function __construct */


}//end class LibAclContainer_DomainDataset


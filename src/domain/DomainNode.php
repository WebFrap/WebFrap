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
 *
 * @author domnik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class DomainNode
{

  /**
   * @example Product Project
   * @var string
   */
  public $label = null;

  /**
   * @example Product Projects
   * @var string
   */
  public $pLabel = null;

  /**
   * @example ProjectActivity
   * @var string
   */
  public $srcKey = null;

  /**
   * @example project_activity
   * @var string
   */
  public $srcName = null;

  /**
   * @example project/activity
   * @var string
   */
  public $srcPath = null;

  /**
   * @example Project.Activity
   * @var string
   */
  public $srcUrl = null;

  /**
   * @var project.activity.
   * @var string
   */
  public $srcI18n = null;

  /**
   * @example Project
   * @var string
   */
  public $modName = null;

  /**
   * @example mod-project
   * @var string
   */
  public $modAclKey = null;

  /**
   * @example ProjectActivityMaskProduct
   * @var string
   */
  public $domainKey = null;

  /**
   * @example project_activity_mask_product
   * @var string
   */
  public $domainName = null;

  /**
   * @example project/activity_mask_product
   * @var string
   */
  public $domainPath = null;

  /**
   * @example Project.ActivityMaskProduct
   * @var string
   */
  public $domainUrl = null;

  /**
   * @example mgmt-project_activity
   * @var string
   */
  public $aclKey = null;

  /**
   * @example mgmt-project_activity
   * @var string
   */
  public $aclBaseKey = null;

  /**
   * @example mgmt-project_activity
   * @var string
   */
  public $aclMaskKey = null;

  /**
   * @example project_activity
   * @var string
   */
  public $aclDomainKey = null;

  /**
   * @example mod-project>mgmt-project_activity
   * @var string
   */
  public $domainAcl = null;

  /**
   * @example Project.Activity_Acl
   * @var string
   */
  public $domainAclUrl = null;

  /**
   * @example ProjectActivity_Acl
   * @var string
   */
  public $domainAclMask = null;

  /**
   * @var string UPPER('mod-project'), UPPER('mgmt-project_activity')
   */
  public $domainAclQuery = null;

  /**
   * @example project.activity_mask_product.
   * @var string
   */
  public $domainI18n = null;

  /**
   * @var [DomainNode]
   */
  private static $pool = array();

  /**
   * @param string $key
   * @return DomainNode
   */
  public static function getNode($key )
  {

    if (!array_key_exists($key, self::$pool ) ) {

      $className = SParserString::subToCamelCase($key).'_Domain';

      if (!Webfrap::classLoadable($className)) {
        self::$pool[$key] = null;

        return null;
      }

      self::$pool[$key] = new $className;
    }

    return self::$pool[$key];

  }//end public static function getNode */

}//end class DomainNode

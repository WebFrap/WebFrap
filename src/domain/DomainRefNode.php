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
class DomainRefNode
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
  public $mgmtName = null;

  /**
   * @example project_activity
   * @var string
   */
  public $srcName = null;

  /**
   * @example project_activity
   * @var string
   */
  public $connectionName = null;

  /**
   * @example project_activity
   * @var string
   */
  public $targetName = null;

  /**
   * @example Project
   * @var string
   */
  public $modName = null;

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
   * @var [DomainNode]
   */
  private static $pool = array();

  /**
   * @param string $key
   * @return DomainNode
   */
  public static function getNode($key)
  {

    if (!array_key_exists($key, self::$pool)) {

    	$keys = explode(':',$key);
    	
      $className = SParserString::subToCamelCase($keys[0]).'_Ref_'.SParserString::subToCamelCase($keys[1]).'_Domain';

      if (!Webfrap::classLoadable($className)) {
        self::$pool[$key] = null;

        return null;
      }

      self::$pool[$key] = new $className;
    }

    return self::$pool[$key];

  }//end public static function getNode */

}//end class DomainRefNode

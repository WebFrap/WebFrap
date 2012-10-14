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
 * @lang de:
 * Klasse zum erstellen von speziellen Filtern die in eine Criteria injected
 * werden können
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibSqlFilter
  extends Base
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var string
   */
  public $fieldName = null;
  
  /**
   * @var array
   */
  public $roles = array();
  
////////////////////////////////////////////////////////////////////////////////
// constructor
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param array $roles
   * @param string $fieldName
   */
  public function __construct( $roles = null, $fieldName = null )
  {
    
    $this->roles     = $roles;
    $this->fieldName = $fieldName;
    
  }//end public function __construct */
  
////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibSqlCriteria $criteria
   * @param TFlowFlag $params
   * @return LibSqlCriteria
   */
  public function inject( $criteria, $params )
  {


    return $criteria;

  }//end public function inject */
  
  
  /**
   * @param LibSqlCriteria $criteria
   * @param int $pos
   * @return LibSqlCriteria
   */
  public function filter( $criteria, $pos )
  {


    return $criteria;

  }//end public function filter */


}//end class LibSqlFilter


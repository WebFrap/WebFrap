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
 * @subpackage Validator
 */
class ValidSearchBuilder
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Die aktuell supporteten Such typen
   * @var array
   */
  public $supportedTypes = array(
    'boolean',
    'date',
    'id',
    'numeric',
    'text',
    'text_strict'
  );
  
  /**
   * @var LibDbConnection
   */
  public $db = null;
  
  /**
   * @var LibI18nPhp
   */
  public $i18n = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibDbConnection $db
   * @param LibI18nPhp $i18n
   */
  public function __construct($db = null, $i18n = null)
  {
    
    if (!$db)
      $db = Webfrap::$env->getDb();
      
    if (!$i18n)
      $i18n = Webfrap::$env->getI18n();
    
    $this->db = $db;
    $this->i18n = $i18n;
    
  }//end public function __construct */
  
/*//////////////////////////////////////////////////////////////////////////////
// Validator methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
	 * @param array $searchCol
	 * @param array $fieldData
	 * 
	 * @return array|null Gib null im Fehlerfall zurück
   */
  public function validate($searchCol, $fieldData)
  {
    
    $type = $fieldData[$searchCol['field']][1];
    
    $searchCol['con'] = (boolean)$searchCol['con'];
    $searchCol['not'] = (boolean)$searchCol['not'];

    return $this->{"validate_".$type}($searchCol);
    
  }//end public function validate */
  
  /**
   * @param array $searchCol
	 * @return array|null Gib null im Fehlerfall zurück
   */
  protected function validate_boolean($searchCol)
  {
    
    
    
    
  }//end protected function validate_boolean */
  
  /**
   * @param array $searchCol
	 * @return array|null Gib null im Fehlerfall zurück
   */
  protected function validate_date($searchCol)
  {
    
  }//end protected function validate_date */
  
  /**
   * @param array $searchCol
	 * @return array|null Gib null im Fehlerfall zurück
   */
  protected function validate_id($searchCol)
  {
    
  }//end protected function validate_id */
  
  /**
   * @param array $searchCol
	 * @return array|null Gib null im Fehlerfall zurück
   */
  protected function validate_numeric($searchCol)
  {
    
  }//end protected function validate_numeric */
  
  /**
   * @param array $searchCol
	 * @return array|null Gib null im Fehlerfall zurück
   */
  protected function validate_text($searchCol)
  {
    
  }//end protected function validate_text */
  
  /**
   * @param array $searchCol
	 * @return array|null Gib null im Fehlerfall zurück
   */
  protected function validate_text_strict($searchCol)
  {
    
  }//end protected function validate_text_strict */

} // end class ValidSearchBuilder


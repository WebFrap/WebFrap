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
 * Collection to fetch result and bundle them
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibSqlConditions
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * <ul>
   * 	<li>con</li>
   * 	<li>field</li>
   * 	<li>not</li>
   * 	<li>cs</li>
   * 	<li>cond</li>
   * 	<li>value</li>
   * </ul>
   * 
   * 
   * @var array
   */
  protected $conditions = array();

  /**
   * @var array
   */
  protected $fields = array();
  
  /**
   * @var LibDbConnection
   */
  protected $db = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Logic
///////////////////////////////////////s//////////////////////////////////////*/

  /**
   * @var LibDbConnection $db
   */
  public function __construct( $db )
  {
    $this->db = $db;
  }//end public function __construct */
  
/*//////////////////////////////////////////////////////////////////////////////
// Logic
///////////////////////////////////////s//////////////////////////////////////*/
 
  /**
   * @param array $conditions
   */
  public function setConditions( $conditions )
  {
    
    $this->conditions = $conditions;
    
  }//end public function setConditions */

  /**
   * @param LibSqlCriteria $criteria
   * @param array $fields
   * @param array $conditions
   * @param TFlowFlag $env
   */
  public function inject($criteria, $fields, $conditions = array())
  {
    
    if ($conditions)
      $this->conditions = $conditions;
    
    $this->fields = $fields;

    
    $sql = '';
    $first = null;
    
    foreach ($this->conditions as $cond) {
      
      if( !isset($cond->field) ) {
        Debug::console('wrong field type ',$cond);
        continue;
      }
      
      if( !isset($this->fields[$cond->field]) ) {
        Debug::console('missing field '.$cond->field);
        continue;
      }
      
      Debug::console('in field '.$cond->field);
      
      $fieldData = $this->fields[$cond->field];
      
      
      $method = 'handleCondition_'.ucfirst($fieldData[1]);
      
      if (is_null($first)) {
        
        $first  = $cond->con;
        $sql .= $this->{$method}($cond);
        
        if (isset($cond->sub)) {
          $sql .= $this->renderSubCondition( $cond->sub );
        }
        
      } else {
        
        $sql .= ($cond->con?' AND ':' OR ').$this->{$method}($cond);
        
        if (isset($cond->sub)) {
          $sql .= $this->renderSubCondition( $cond->sub );
        }
        
      }
      
      
    }
    
    // inject into the criteria
    $criteria->where( $sql, ($first?'AND':'OR') );
    
    Debug::console('ext search '.$sql);

  }//end public function inject */

  
  /**
   * @param array $conditions
   */
  protected function renderSubCondition( $conditions )
  {
    
    $sql = '';
    
    $firstNode = current($conditions);
    $first = true;
    
    $sql .= ($firstNode->con?' AND ':' OR ');
    
    $sql .= '(';
    
    foreach ($conditions as $condition) {
      
      $fieldData = $this->fields[$condition->field];
      $method = 'handleCondition_'.ucfirst($fieldData[1]);
      
      if ($first) {

        $sql .= $this->{$method}($condition);
        $first = false;
        
      } else {
        
        $sql .= ($condition->con?' AND ':' OR ').$this->{$method}($condition);
      }
      
      if (isset($condition->sub)) {
        
        $sql .= $this->renderSubCondition($condition->sub);
      }
      
    }
    
    $sql .= ')';
    
    return $sql;
    
  }//end protected function renderSubCondition */

  /**
   * @param array $cond
   * @return array
   */
  protected function handleCondition_Boolean($cond)
  {
    
    $sql = '';
    
    $fieldName = $this->fields[$cond->field];
    
    if ($cond->not) {
      $sql .= ' NOT ';
    }
    
    switch ($cond->cond) {
      
      case ESearchBoolean::IS_FALSE: {
        
        $sql .= ' '.$fieldName[2].' = false ';
        break;
      }
      case ESearchBoolean::IS_TRUE: {
        
        $sql .= ' '.$fieldName[2].' = true ';
        break;
      }
      case ESearchBoolean::IS_NULL: {
        
        $sql .= ' '.$fieldName[2].' IS NULL ';
        break;
      }
      default:{
        
        Debug::console('invalid check type');
        
      }
      
    }
    
    if (isset($cond->sub)) {
      $sql .= $this->renderSubCondition( $cond );
    }
    
    
    return $sql;

  }//end public function handleCondition_Boolean */

  /**
   * @param array $cond
   * @return array
   */
  protected function handleCondition_Date($cond)
  {

    $sql = '';
    
    $fieldName = $this->fields[$cond->field];
    
    if ($cond->not) {
      $sql .= ' NOT ';
    }
    
    switch ($cond->cond) {
      
      case ESearchDate::AFTER: {
        
        $sql .= ' '.$fieldName[2]." > '".$cond->value."'";
        break;
      }
      case ESearchDate::AFTER_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." >= '".$cond->value."'";
        break;
      }
      case ESearchDate::BEFORE: {
        
        $sql .= ' '.$fieldName[2]." < '".$cond->value."'";
        break;
      }
      case ESearchDate::BEFORE_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." <= '".$cond->value."'";
        break;
      }
      case ESearchDate::EQUALS: {
        
        $sql .= ' '.$fieldName[2]." = '".$cond->value."'";
        break;
      }
      case ESearchDate::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond->cond);
        
      }
      
    }
    
    return $sql;

  }//end public function handleCondition_Date */
  
  /**
   * @param array $cond
   * @return array
   */
  protected function handleCondition_Id($cond)
  {

    $sql = '';
    
    $fieldName = $this->fields[$cond->field];
    
    if ($cond->not) {
      $sql .= ' NOT ';
    }
    
    switch ($cond->cond) {
      
      case ESearchId::EQUALS: {
        
        $sql .= ' '.$fieldName[2]." ".$cond->value;
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond->cond);
        
      }
      
    }
    
    return $sql;

  }//end public function handleCondition_Id */
  
  /**
   * @param array $cond
   * @return array
   */
  protected function handleCondition_Numeric($cond)
  {

    $sql = '';
    
    $fieldName = $this->fields[$cond->field];
    
    if ($cond->not) {
      $sql .= ' NOT ';
    }
    
    switch ($cond->cond) {
      
      case ESearchNumeric::BIGGER: {
        
        $sql .= ' '.$fieldName[2]." < ".$cond->value;
        break;
      }
      case ESearchNumeric::BIGGER_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." <= ".$cond->value;
        break;
      }
      case ESearchNumeric::EQUALS: {
        
        $sql .= ' '.$fieldName[2]." = ".$cond->value;
        break;
      }
      case ESearchNumeric::SMALLER: {
        
        $sql .= ' '.$fieldName[2]." > ".$cond->value;
        break;
      }
      case ESearchNumeric::SMALLER_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." >= ".$cond->value;
        break;
      }
      case ESearchNumeric::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond->cond);
        
      }
      
    }
    
    return $sql;

  }//end public function handleCondition_Numeric */

  /**
   * @param array $cond
   * @return array
   */
  protected function handleCondition_Text($cond)
  {

    $sql = '';
    
    $fieldName = $this->fields[$cond->field];
    
    if ($cond->not) {
      $sql .= ' NOT ';
    }
    
    switch ($cond->cond) {
      
      case ESearchText::EQUALS: {
        
        if($cond->cs)
          $sql .= ' '.$fieldName[2]." = '".$this->db->addSlashes($cond->value)."'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") = UPPER('".$this->db->addSlashes($cond->value)."')";
          
        break;
      }
      case ESearchText::START_WITH: {
        
        if($cond->cs)
          $sql .= ' '.$fieldName[2]." like '".$this->db->addSlashes($cond->value)."%'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") like UPPER('".$this->db->addSlashes($cond->value)."%')";
          
        break;
      }
      case ESearchText::END_WITH: {
        
        if($cond->cs)
          $sql .= ' '.$fieldName[2]." like '%".$this->db->addSlashes($cond->value)."'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") like UPPER('%".$this->db->addSlashes($cond->value)."')";
          
        break;
      }
      case ESearchText::CONTAINS: {
        
        if($cond->cs)
          $sql .= ' '.$fieldName[2]." like '%".$this->db->addSlashes($cond->value)."%'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") like UPPER('%".$this->db->addSlashes($cond->value)."%')";
        break;
      }
      case ESearchText::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond->cond);
        
      }
      
    }
    
    return $sql;

  }//end public function handleCondition_Text */


  /**
   * @param array $cond
   * @return array
   */
  protected function handleCondition_TextStrict($cond)
  {

    $sql = '';
    
    $fieldName = $this->fields[$cond->field];
    
    if ($cond->not) {
      $sql .= ' NOT ';
    }
    
    switch ($cond->cond) {
      
      case ESearchTextStrict::EQUALS: {
        
        if($cond->cs)
          $sql .= ' '.$fieldName[2]." = '".$this->db->addSlashes($cond->value)."'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") = UPPER('".$this->db->addSlashes($cond->value)."')";
          
        break;
      }
      case ESearchTextStrict::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond->cond);
        
      }
      
    }
    
    return $sql;

  }//end public function handleCondition_TextStrict */
  
}//end class LibSqlConditions

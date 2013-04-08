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
   * @param array $conditions
   */
  public function setConditions( $conditions )
  {
    
    foreach ( $conditions as $pos => $cond ) {
      
      if (isset($cond['parent'])) {
        
        if (!isset($this->conditions[(int)$cond['parent']]['sub']))
          $this->conditions[(int)$cond['parent']]['sub'] = array();
          
        $this->conditions[(int)$cond['parent']]['sub'][] = $cond;
        
      } else {
        
        $this->conditions[(int)$pos] = $cond;
      }
      
    }
    
  }//end public function setConditions */

  /**
   * @param TFlowFlag $criteria
   * @param array $fields
   * @param array $conditions
   * @param TFlowFlag $env
   */
  public function inject($criteria, $fields, $conditions = array(), $env = null)
  {
    
    if ($conditions)
      $this->setConditions($conditions);
      
    foreach ($fields as $searchFields) {
      foreach ($searchFields as $sKey => $sData) {
        $this->fields[$sKey] = $sData;
      }
    }
    
    foreach ($this->conditions as $cond) {
      
      if( !isset($fields[$cond]) ){
        continue;
      }
      
    }


  }//end public function inject */

  
  /**
   * 
   */
  protected function renderSubCondition( $conditions )
  {
    
    $sql = '';
    
    foreach( $conditions as $condition ){
      
      if( isset( $condition['sub'] ) ){
        
        $firstNode = current($condition['sub']);
        
        $sql .= '(';
        
        $sql .= $this->renderSubCondition( $condition['sub'] );
        
        $sql .= ')';
        
      }
      
    }
    
  }//end protected function renderSubCondition */

  /**
   * @param array $cond
   * @return array
   */
  protected function handleCondition_Boolean($cond)
  {
    
    $sql = '';
    
    $fieldName = $this->fields[$cond['cond']['field']];
    
    if ($cond['cond']['not']) {
      $sql .= ' NOT ';
    }
    
    switch ($cond['cond']) {
      
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
    
    if( isset( $cond['sub'] ) ){
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
    
    $fieldName = $this->fields[$cond['cond']['field']];
    
    if ($cond['cond']['not']) {
      $sql .= ' NOT ';
    }
    
    switch ($cond['cond']) {
      
      case ESearchDate::AFTER: {
        
        $sql .= ' '.$fieldName[2]." > '".$cond['cond']['value']."'";
        break;
      }
      case ESearchDate::AFTER_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." >= '".$cond['cond']['value']."'";
        break;
      }
      case ESearchDate::BEFORE: {
        
        $sql .= ' '.$fieldName[2]." < '".$cond['cond']['value']."'";
        break;
      }
      case ESearchDate::BEFORE_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." <= '".$cond['cond']['value']."'";
        break;
      }
      case ESearchDate::EQUALS: {
        
        $sql .= ' '.$fieldName[2]." = '".$cond['cond']['value']."'";
        break;
      }
      case ESearchDate::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond['cond']);
        
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
    
    $fieldName = $this->fields[$cond['cond']['field']];
    
    if ($cond['cond']['not']) {
      $sql .= ' NOT ';
    }
    
    switch ($cond['cond']) {
      
      case ESearchId::EQUALS: {
        
        $sql .= ' '.$fieldName[2]." ".$cond['cond']['value'];
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond['cond']);
        
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
    
    $fieldName = $this->fields[$cond['cond']['field']];
    
    if ($cond['cond']['not']) {
      $sql .= ' NOT ';
    }
    
    switch ($cond['cond']) {
      
      case ESearchNumeric::BIGGER: {
        
        $sql .= ' '.$fieldName[2]." < ".$cond['cond']['value'];
        break;
      }
      case ESearchNumeric::BIGGER_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." <= ".$cond['cond']['value'];
        break;
      }
      case ESearchNumeric::EQUALS: {
        
        $sql .= ' '.$fieldName[2]." = ".$cond['cond']['value'];
        break;
      }
      case ESearchNumeric::SMALLER: {
        
        $sql .= ' '.$fieldName[2]." > ".$cond['cond']['value'];
        break;
      }
      case ESearchNumeric::SMALLER_EQUAL: {
        
        $sql .= ' '.$fieldName[2]." >= ".$cond['cond']['value'];
        break;
      }
      case ESearchNumeric::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond['cond']);
        
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
    
    $fieldName = $this->fields[$cond['cond']['field']];
    
    if ($cond['cond']['not']) {
      $sql .= ' NOT ';
    }
    
    switch ($cond['cond']) {
      
      case ESearchText::EQUALS: {
        
        if($cond['cs'])
          $sql .= ' '.$fieldName[2]." = '".$this->db->addSlashes($cond['cond']['value'])."'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") = UPPER('".$this->db->addSlashes($cond['cond']['value'])."')";
          
        break;
      }
      case ESearchText::START_WITH: {
        
        if($cond['cs'])
          $sql .= ' '.$fieldName[2]." like '".$this->db->addSlashes($cond['cond']['value'])."%'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") like UPPER('".$this->db->addSlashes($cond['cond']['value'])."%')";
          
        break;
      }
      case ESearchText::END_WITH: {
        
        if($cond['cs'])
          $sql .= ' '.$fieldName[2]." like '%".$this->db->addSlashes($cond['cond']['value'])."'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") like UPPER('%".$this->db->addSlashes($cond['cond']['value'])."')";
          
        break;
      }
      case ESearchText::CONTAINS: {
        
        if($cond['cs'])
          $sql .= ' '.$fieldName[2]." like '%".$this->db->addSlashes($cond['cond']['value'])."%'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") like UPPER('%".$this->db->addSlashes($cond['cond']['value'])."%')";
        break;
      }
      case ESearchText::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond['cond']);
        
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
    
    $fieldName = $this->fields[$cond['cond']['field']];
    
    if ($cond['cond']['not']) {
      $sql .= ' NOT ';
    }
    
    switch ($cond['cond']) {
      
      case ESearchTextStrict::EQUALS: {
        
        if($cond['cs'])
          $sql .= ' '.$fieldName[2]." = '".$this->db->addSlashes($cond['cond']['value'])."'";
        else 
          $sql .= ' UPPER('.$fieldName[2].") = UPPER('".$this->db->addSlashes($cond['cond']['value'])."')";
          
        break;
      }
      case ESearchTextStrict::IS_NULL: {
        
        $sql .= ' '.$fieldName[2]." is null";
        break;
      }
      default:{
        
        Debug::console('invalid check type '.$cond['cond']);
        
      }
      
    }
    
    return $sql;

  }//end public function handleCondition_TextStrict */
  
}//end class LibSqlConditions

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
 * @subpackage tech_core
 */
class LibSpreadsheetExcelTab 
{

  /**
   * @var string
   */
  public $title;
  
  /**
   * @var array
   */
  public $structure = array();
  
  /**
   * @var array
   */
  public $data;
  
  /**
   * @var array
   */
  public $vSumFields = array();
  
  /**
   * @var array
   */
  public $hSumFields = array();
  
  /**
   * Aktuelle Position des Schreibzeigers auf dem Tab
   * @todo prüfen ob wir mit a-z nicht zuwenig spalten haben, no joke! you never no
   * @var int
   */
  public $posX = 'A';
  
  /**
   * Aktuelle Position des Schreibzeigers auf dem Tab
   * @var int
   */
  public $posXConstr = 'A';
  
  /**
   * Aktuelle Position des Schreibzeigers auf dem Tab
   * @var int
   */
  public $posY = 1;
  
  /**
   * Aktuelle Position des Schreibzeigers auf dem Tab
   * @var int
   */
  public $posYConstr = 1;
  
  /**
   * Das Render Objekt für den Tab
   * @var int
   */
  public $renderer = 1;
  
  /**
   * @param string $title
   * @param array $data
   * @param array $vSumFields
   * @param array $hSumFields
   */
  public function __construct( $title, $data = null, $vSumFields = array(), $hSumFields )
  {
    
    $this->title = $title;
    
    if( $data )
      $this->data  = $data;
      
    if( $vSumFields )
      $this->vSumFields = $vSumFields;
    
    if( $hSumFields ) 
      $this->hSumFields = $hSumFields;
    
  }//end public function __construct */
    
  /**
   * Zeiger wieder auf Anfang
   */
  public function resetX()
  {
    
    $this->posX = $this->posXConstr;
    
  }//end public function resetX */
  
  
}
    
    
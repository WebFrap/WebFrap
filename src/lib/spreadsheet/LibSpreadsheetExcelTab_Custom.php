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
 * @subpackage Spreadsheet
 */
class LibSpreadsheetExcelTab_Custom extends LibSpreadsheetExcelTab
{
    
  /**
   * @param string $title
   * @param array $data
   */
  public function __construct($document, $title, $data = null, $styleObj = null )
  {
    
    $this->title = $title;
    
    if ($data )
      $this->data  = $data;
      
    if (!$styleObj )
    {
      $this->styleObj = new LibSpreadsheetExcelStyle_Default();
    } else {
      $this->styleObj = $styleObj;
    }
      
    parent::__construct($document, mb_substr($title, 0,31, 'UTF-8')  );
    
    //$this->setTitle($this->title );
    $this->getSheetView()->setZoomScale(85);
    
  }//end public function __construct */
    
  /**
   * Den Header schreiben
   * @return void
   */
  public function writeHead()
  {

      
    $styleTableHead    =  $this->styleObj->getHeaderStyle();

    $margins = $this->getPageMargins();
    $margins->setTop( 1 );
    $margins->setRight( 0.75 );
    $margins->setLeft( 0.75 );
    $margins->setBottom( 1 );
    
    $cPos = ($this->posX.$this->posY);
    
    $this->setCellValueExplicit($cPos, $data[self::LABEL], PHPExcel_Cell_DataType::TYPE_STRING  ); 
      
    if ( isset($data[self::WIDTH] ) )
      $this->getColumnDimension($this->posX)->setWidth($data[self::WIDTH] );
    
    $this->posX++;
    
    //$this->freezePane('A1');  
    $this->freezePane('A2');  
    $this->freezePane('A3');  
  
    $this->decX();

    //styling des headers anpassen
    $this->getStyle( "A{$this->posY}:".$this->posX.$this->posY )->applyFromArray($styleTableHead );
    $this->posY ++;
    
    
    $this->setAutoFilter("A{$this->posY}:".$this->posX.$this->posY );
    $this->posY ++;
    
    $this->resetX();
    
  }//end public function writeHead */
  
  /**
   * Rendern des Databody
   */
  public function writeDataBody()
  {

    $rowStyle1    =  $this->styleObj->getRowStyle( 1 );
    $rowStyle2    =  $this->styleObj->getRowStyle( 2 );
    $styleListBorders  =  $this->styleObj->getAllBorders(  );

    $listStructure = array();
      
    if ( is_object($this->data ) && $this->data->structure )
      $listStructure = $this->data->structure;
    else 
      $listStructure = $this->structure;
      
    //Add Data
    foreach($this->data as $rowIdx => $rowData  )
    {

      //here comes the data
      $this->resetX();
      
      foreach($listStructure as $cellKey => $cellStruct )
      {
        
        if ( isset($cellStruct[$cellKey][self::TYPE] ) )
          $type = $cellStruct[$cellKey][self::TYPE];
        else 
          $type = 'text';
        
        $cPos = ($this->posX.$this->posY);
        
        if ( "text" === $type )
        {
          $this->setCellValueExplicit($cPos, $rowData[$cellKey], PHPExcel_Cell_DataType::TYPE_STRING ); 
        }
        elseif ($type === "numeric" )
        {
          $this->SetCellValue($cPos, $rowData[$cellKey] );
          $this->getStyle($cPos)->getNumberFormat()->setFormatCode('#,##0.00');
        }
        elseif ($type === "date" )
        {
          $this->SetCellValue($cPos, $rowData[$cellKey] );
          $this->getStyle($cPos)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2 );
        }
        elseif ($type === "time" )
        {
          $this->SetCellValue($cPos, $rowData[$cellKey] );
          $this->getStyle($cPos)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4 );
        }
        elseif ($type === "timestamp" )
        {
          $this->SetCellValue($cPos, $rowData[$cellKey] );
          $this->getStyle($cPos)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TIMESTAMP );
        }
        elseif ($type === "money" )
        {
          $this->SetCellValue($cPos, $rowData[$cellKey] );
          $this->getStyle($cPos)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE );
        }
        else
        {
          $this->SetCellValue($cPos, $rowData[$cellKey] );
        }
        
        if ( isset($cellStruct[self::ACTION_URL] ) )
        {
          if ( isset($rowData[self::ACTION_URL] ) && '' !== trim(  $rowData[self::ACTION_URL] ) )
            $this->getCell($cPos)->getHyperlink()->setUrl($rowData[self::ACTION_URL] );
          
        }
        
        $this->posX++;
      }
      
      if ( ($rowIdx % 2) === 1 )
      {
        $style = $rowStyle1; 
      } else {
        $style = $rowStyle2;   
      }
      
      $this->getStyle( "A{$this->posY}:{$cPos}" )->applyFromArray($style );
      
      $this->posY++;
      
    }//end foreach
    
    $this->decX();
    
    $this->getStyle("A1:".$this->posX.($this->posY-1))->applyFromArray($styleListBorders);
    
  }//end public function writeDataBody */
  
  
  /**
   * Zeiger wieder auf Anfang
   */
  public function resetX()
  {
    
    $this->posX = $this->posXConstr;
    
  }//end public function resetX */
  
  /**
   * Bei X einen Schritt zurück
   */
  public function decX()
  {
    
    $this->posX = chr(ord($this->posX)-1);
    
  }//end public function decX
  
  
}//end class LibSpreadsheetExcelTab
    
    
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
class LibSpreadsheetExcel 
  extends LibTemplateDocument 
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * @var [LibSpreadsheetExcelTab]
   */
  protected $sheets   = array();
  
  /**
   * Die Instanz des Dokuments
   * @var PHPExcel
   */
  protected $document   = null;
  
  /**
   * @var string
   */
  public $booktitle;
  
  /**
   * Der für das generierte Dokument
   * @var string
   */
  public $fileName = null;
  
  /**
   * Ersteller des Dokuments
   * @var string
   */
  public $creator = null;
  
  /**
   * Der Titel des Dokuments
   * @var string
   */
  public $title = null;
  
  /**
   * Das Subject des Dokuments
   * @var string
   */
  public $subject = null;
  
  /**
   * Die Description des Dokuments
   * @var string
   */
  public $description = null;

  
  /**
   * Name des Style Objektes
   * @var string
   */
  public $styleName = 'default';
  
  /**
   * Das aktuelle Style Objekt
   * @var unknown_type
   */
  public $styleObj = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
    
  /**
   * @return [LibSpreadsheetExcelTab]
   */
  public function getSheets()
  {
    
    return $this->sheets;
    
  }//end public function getSheets */
    
  /**
   * @param int $position
   * @return LibSpreadsheetExcelTab
   */
  public function getSheet( $position = 0 )
  {
    
    if( exists( $this->sheets[$position] ) )
    {
      return $this->sheets[$position];
    }
    else 
      return null;
    
  }//end public function getSheet */
    
  
  /**
   * @param [LibSpreadsheetExcelTab] $sheets
   */
  public function setSheets( array $sheets )
  {
    
    if( is_array($sheets) )
    {
      $this->sheets = $sheets;
    }
    
  }//end public function setSheets */
    
  
  /**
   * @param int $position
   * @param LibSpreadsheetExcelTab $sheet
   */
  public function setSheet( LibSpreadsheetExcelTab $sheet, $position = 0 )
  {
    
    $this->sheets[$position] = $sheet;
    
  }//end public function setSheet */
    
  /**
   * @param string $title
   */
  public function setBooktitle( $title )
  {
    
    $this->booktitle = trim($title);
    
  }//end public function setBooktitle */
    
  /**
   * @param LibSpreadsheetExcelTab $sheet
   */
  public function addSheet( LibSpreadsheetExcelTab $sheet )
  {
    
    $this->sheets[]   = $sheet;
    
  }//end public function addSheet */
    
  
  /**
   * Ein vorhandenen Sheet löschen
   * @param int $position
   */
  public function removeSheet( $position = 0 )
  {
    $this->sheets[$position]   = null;
  }//end public function removeSheet */
  
  /**
   * Einen neuen tab hinzufügen
   * 
   * @param string $title
   * @return LibSpreadsheetExcelTab 
   */
  public function newSheet( $title  )
  {
    
    $sheet = new LibSpreadsheetExcelTab( $title );
    
    $this->sheets[] = $sheet;
    
    return $sheet;
    
  }//end public function newSheet */
  
  /**
   * 
   * @return LibSpreadsheetExcelStyle
   */
  public function getStyleNode()
  {
    
    if( !$this->styleObj )
    {
      $styleClass = 'LibSpreadsheetExcelStyle_'.SParserString::subToCamelCase($this->styleName);
      if( !Webfrap::classLoadable($styleClass) )
      {
        $styleClass = 'LibSpreadsheetExcelStyle_Default';
      }
      
      $this->styleObj = new $styleClass();
    }
    
    return $this->styleObj;
    
  }//end public function getStyleNode */
  
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////
     
  /**
   * @param string $style
   */
  public function __construct( $style = null )
  {
    
    if( $style )
      $this->styleName = $style;

    $this->env = Webfrap::$env;
  
  }//end public function __construct */
    
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * Initialisieren des Dokuments
   */
  public function initDocument(  )
  {
    
    $this->document = LibVendorPhpexcel::newDocument();
    $styleObject = $this->getStyleNode();
    
    $user = $this->getUser();
    
    if( !$this->creator )
    {
      $this->creator = $user->getFullName();
    }

    
       
    // Set properties
    $this->document->getProperties()->setCreator( $this->creator );
    $this->document->getProperties()->setLastModifiedBy( $this->creator );
    $this->document->getProperties()->setTitle( $this->title );
    $this->document->getProperties()->setSubject( $this->subject );
    $this->document->getProperties()->setDescription( $this->description );
    
    // Set Default Style Values
    $this->document->getDefaultStyle()->getFont()->setName( $styleObject->fontName );
    $this->document->getDefaultStyle()->getFont()->setSize( $styleObject->fontSize );
    
  }//end public function initDocument */
    
  /**
   * Rendern des Dokuments
   */
  public function renderDocument()
  {
    
    if( !count( $this->sheets ) )
    {
      Debug::console( 'There are no sheets to render' );
    }
    
    
    $db    = $this->getDb();
    $user  = $this->getUser()->getFullName();
      
    
    $no_sheets   = count($this->sheets);

      
    $styleObject       =  $this->getStyleNode();

    $styleListRow1    =  $styleObject->getTableRowsStyle(false);
    $styleListRow2    =  $styleObject->getTableRowsStyle(true);
      
    $styleListBorders  =  $styleObject->getAllBorders(true);

      
    foreach( $this->sheets as $key => $sheetNode )
    {
      
      $activeSheet  = $this->createSheet( $key, $sheetNode, $styleObject );

      //Add Data
      foreach( $activeSheet->data as $rowIdx => $rowData  )
      {

        //here comes the data
        $activeSheet->resetX();
        
        foreach( $rowData as $cellIdx => $cellData )
        {
          $name = $columns[$j];
          $type = $datatypes[$j];
          
          if( "text" === $activeSheet->structur[$cellIdx]['type'] )
          {
            $activeSheet->getCell( ($activeSheet->posX.$activeSheet->posV) )
              ->setValueExplicit( $row[$name], PHPExcel_Cell_DataType::TYPE_STRING ); 
          }
          elseif($type=="numeric")
          {
            $activeSheet->SetCellValue(($activeSheet->posX.$activeSheet->posV), $row[$name]);
            $activeSheet->getStyle(($activeSheet->posX.$activeSheet->posV))->getNumberFormat()->setFormatCode('#,##0.00');
          }
          else
          {
            $activeSheet->SetCellValue(($activeSheet->posX.$activeSheet->posV), $row[$name]);
          }
          
          $activeSheet->posX++;
        }
        
        
        if( ($rowIdx % 2) ==1 )
        {
          $style = $styleListRow1; 
        }
        else
        {
          $style = $styleListRow2;   
        }
        
        $activeSheet->getStyle( "A$activeSheet->posV:".$activeSheet->posX.$activeSheet->posV )
          ->applyFromArray( $style );
          
        $activeSheet->posV++;
      }
      
      
      //check for sum line
      /*
      if( $sheetNode->getSum() )
      {
        $activeSheet->posX = 'A';
        for($j=0;$j<$no_columns;$j++){
          
          $type = $datatypes[$j];
          
          if($type=="numeric"){
            $activeSheet->SetCellValue(($activeSheet->posX.$activeSheet->posV), '=SUBTOTAL(9,'.$activeSheet->posX.'2:'.$activeSheet->posX.($activeSheet->posV-1).')');
            $activeSheet->getStyle(($activeSheet->posX.$activeSheet->posV))->getNumberFormat()->setFormatCode('#,##0.00');
          }
          
          if($j<($no_columns-1)){
            $activeSheet->posX++;
          }
        }
  
        $activeSheet->getStyle("A$activeSheet->posV:".$activeSheet->posX.$activeSheet->posV)->applyFromArray($styleTableHead);
      }
      */
    
    
      //autosizing
      /*
      $activeSheet->posX = "A";
        for($j=0;$j<$no_columns;$j++){
        $activeSheet->getColumnDimension($activeSheet->posX)->setAutoSize(true);
          
        if($j<($no_columns-1)){
          $activeSheet->posX++;
        }
      }
      */
    
    
      //rahmen setzen
      $activeSheet->getStyle("A1:".$activeSheet->posX.($activeSheet->posV-1))->applyFromArray($styleListBorders);
        


    }
    
  }//end public function renderDocument */
  
  /**
   * Ein neues Sheet erstellen und den Header schreiben
   * Es wird angenommen das korrekte structure angaben hinterlegt wurden
   * 
   * @var string $sheetKey
   * @var LibSpreadsheetExcelTab $sheetData
   * @var LibSpreadsheetExcelStyle $styleObject
   */
  public function createSheet( $sheetKey, $sheetData, $styleObject )
  {
    
    $title  = $sheetData->getTitle();
    $sheetData->render = $this->document->createSheet( $key );
    
    
    $styleTableHead    =  $styleObject->getHeaderStyle();
      
    $activeSheet  = $this->document->createSheet( $key );
    $activeSheet->setTitle( $title );
    $activeSheet->getSheetView()->setZoomScale(85);

    if( count($sheetData->structure) === 0 )
    {
      $activeSheet->SetCellValue( 'A1', "No Data found for $title" );
      return null;
    }
  
    //Add Columns
    $activeSheet->posX   = 'A';
    $activeSheet->posV   = 1;
    
    foreach( $sheetData->structure as $data )
    {
      
      $activeSheet->getCell( ($activeSheet->posX.$activeSheet->posV) )
        ->setValueExplicit
        (
          $data['label'], 
          PHPExcel_Cell_DataType::TYPE_STRING
        ); 
        
      if( isset( $data['width'] ) )
        $activeSheet->getColumnDimension($activeSheet->posX)->setWidth( $data['width'] );
      
      $activeSheet->posX++;
      
    }
      
    //styling des headers anpassen
    $activeSheet->getStyle( "A$activeSheet->posV:".$activeSheet->posX.$activeSheet->posV )
      ->applyFromArray( $styleTableHead );
      
    // autofilter für alle spalten aktivieren
    $activeSheet->setAutoFilter('A1:'.$activeSheet->posX.'1');
    
    $activeSheet->posV ++;
    $activeSheet->resetX();
    
  }//end public function createSheet */
  
  
  /**
   * Render des Databodies des sheets
   */
  public function renderSheetDataBody()
  {
    
  }//end public function renderSheetDataBody */

  /**
   * rendering des Dokuments ausführen
   */
  public function executeRenderer()
  {
    
    $title = '_';
    if( $this->booktitle != '' )
    {
      $title = $this->booktitle;
    }
    
    $fileName = "Reporting_".$title."_".date('dmY').".xlsx";
    
    $fileKey = Webfrap::uniqid();
    
    // tell the view that it has to send a file, and no parsed content
    $file    = $this->parent->sendFile();
    
    // file is temporay so the view deletes after sending
    $file->tmp     = true;
    // set the filename
    $file->name    = $fileName;
    // where is the file to find
    $file->path    = PATH_GW.'tmp/'.$fileKey;
    // the mimetype for the file
    $file->type    = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    
    $writer = LibVendorPhpexcel::getExcelWriter2007( $this->document );
    $writer->setPreCalculateFormulas(false);
    $writer->setOffice2003Compatibility(true);
    
    if( !file_exists( PATH_GW.'tmp/' ) )
      SFilesystem::mkdir( PATH_GW.'tmp/' );
    
    $writer->save( $file->path );

  }//end public function executeRenderer 
  
  /**
   * schliesen des aktuellen dokuments
   */
  public function close()
  {
    
    $this->document->disconnectWorksheets();
    $this->document = null;
    
    $this->sheets = array();
    
  }//end public function close */
  
}

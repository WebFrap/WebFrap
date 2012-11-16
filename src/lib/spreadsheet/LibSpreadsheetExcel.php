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
  public $booktitle = null;
  
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
   * @var LibSpreadsheetExcelStyle
   */
  public $styleObj = null;

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////
     
  /**
   * @param Base $env
   * @param string $defTitle
   * @param string $style
   */
  public function __construct( $env, $defTitle = null, $style = null )
  {
    
    $this->env    = $env;
    $this->parent = $env->getTpl();
    
    if( $style )
      $this->styleName = $style;
      
    $this->document = LibVendorPhpexcelFactory::newDocument( $defTitle, 'LibSpreadsheetExcelTab' );

    $this->sheets[] = $this->document->getSheet();

  }//end public function __construct */
  
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
    
    if( isset( $this->sheets[$position] ) )
    {
      return $this->sheets[$position];
    }
    else 
      return null;
    
  }//end public function getSheet */

    
  
  /**
   * @param int $position
   * @param LibSpreadsheetExcelTab $sheet
   */
  public function setSheet( LibSpreadsheetExcelTab $sheet, $position = 0 )
  {
    
    $this->sheets[$position] = $sheet;
    $this->document->addSheet( $sheet, $position );
    
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
    $this->document->addSheet( $sheet );
    
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
  public function newSheet( $title, $data = null )
  {
    
    $sheet = new LibSpreadsheetExcelTab
    ( 
      $this->document, 
      $title, 
      $data, 
      $this->styleObj 
    );
    
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
   * Initialisieren des Dokuments
   */
  public function initDocument(  )
  {
    
    $styleObject = $this->getStyleNode();
    
    $user = $this->getUser();
    
    if( !$this->creator )
    {
      $this->creator = $user->getFullName();
    }
    
    foreach( $this->sheets as /* @var LibSpreadsheetExcelStyle */ $sheet )
    {
      $sheet->styleObj = $styleObject;
    }

    // Set properties
    $this->document->getProperties()->setCreator( $this->creator );
    $this->document->getProperties()->setLastModifiedBy( $this->creator );
    $this->document->getProperties()->setTitle( mb_substr($this->title, 0,31, 'UTF-8')  );
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
      return;
    }
    
    
    $db    = $this->getDb();
    $user  = $this->getUser()->getFullName();

      
    foreach( $this->sheets as $key => /* @var $sheetNode LibSpreadsheetExcelTab  */ $sheetNode )
    {
      
      $sheetNode->writeHead();
      $sheetNode->writeDataBody();
      
      
      
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
      //$activeSheet->getStyle("A1:".$activeSheet->posX.($activeSheet->posV-1))->applyFromArray($styleListBorders);
        
    }
    
  }//end public function renderDocument */

  /**
   * rendering des Dokuments ausführen
   */
  public function executeRenderer()
  {
    
    $this->initDocument();
    $this->renderDocument();
    
    if( !$this->fileName )
      $this->fileName = $this->booktitle."_".date('dmY').".xlsx";
    
    $fileKey = Webfrap::uniqid();
    
    // tell the view that it has to send a file, and no parsed content
    $file    = $this->env->getTpl()->sendFile();
    
    // file is temporay so the view deletes after sending
    $file->tmp     = true;
    // set the filename
    $file->name    = $this->fileName;
    // where is the file to find
    $file->path    = PATH_GW.'tmp/documents/'.$fileKey;
    // the mimetype for the file
    
    //$file->type    = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    $file->type    = 'text/plain';
    
    $factory = LibVendorPhpexcelFactory::getDefault();
    
    $writer = $factory->getExcelWriter2007( $this->document );
    $writer->setPreCalculateFormulas( false );
    $writer->setOffice2003Compatibility( true );
    
    if( !file_exists( PATH_GW.'tmp/documents/' ) )
      SFilesystem::mkdir( PATH_GW.'tmp/documents/' );
    
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

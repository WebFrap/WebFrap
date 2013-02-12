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
class LibSpreadsheetExcelStyle_Default
  extends LibSpreadsheetExcelStyle
{
  
  /**
   * Standard Schrift Familie
   * @var string
   */
  public $fontName = 'Calibri';
 
  /**
   * Standard Schriftgröße
   * @var string
   */
  public $fontSize = 11;

  /**
   * Color Schemes für die Cols
   */
  public $rowColorScheme = array
  (
    //key       font        bg color
    1 => array( '00000000', 'FFDBE5F1' ),
    2 => array( '00000000', 'FFB8CCE4' ),
  );

  /**
   * @var string
   */
  public $borderColor      =  '00000000';
  
  /**
   * @param int $key
   * @return array
   */
  public function getRowStyle( $key )
  {
    
    if( isset( $this->rowColorScheme[$key] ) )
      $color = $this->rowColorScheme[$key];
    else 
      $color = $this->rowColorScheme[1];

    return $this->styleArray( $color[1], $color[0], false, 'right' );
    
  }//end public function getRowStyle */



}//end LibSpreadsheetExcelStyle_Default */

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
class LibSpreadsheetExcelStyle
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

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
  
  public $white            =  'FFFFFFFF';
  
  public $black            =  '00000000';
  
  public $headColumnColor      =  'FFF79646';
  
  public $headDataColor        =  'FFFCD5B4';
  
  public $tableHeadColor        =  'FF4F81BD';
  
  public $tableRowColor1        =  'FFDBE5F1';
  
  public $tableRowColor2        =  'FFB8CCE4';
  
  public $project_basic_head_color    =   'FF1F497D';
  public $project_year_head_color    =   'FF75923C';
  public $project_rate_head_color    =   'FF60497B';
  public $project_cost_head_color    =   'FF31849B';
  public $project_variance_head_color  =   'FF7F7F7F';
  public $project_error_head_color    =   'FFC0504D';
  
  public $projectBasicDataColor1  =  'FFDBE5F1';
  public $projectBasicDataColor2  =  'FF8DB4E3';
  
  public $project_year_data_color1    =  'FFC2D69A';
  public $project_year_data_color2    =  'FF9BBB59';
  
  public $project_rate_data_color1    =  'FFCCC0DA';
  public $project_rate_data_color2    =  'FFB2A1C7';
  
  public $project_cost_data_color1    =  'FFB6DDE8';
  public $project_cost_data_color2    =  'FF93CDDD';
  
  public $project_variance_data_color1    =  'FFD8D8D8';
  public $project_variance_data_color2    =  'FFBFBFBF';
  
  public $project_error_data_color1    =  'FFE6B9B8';
  public $project_error_data_color2    =  'FFD99795';
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  public function __construct(){}
  
  /**
   * @param string $color
   * @param string $font
   * @param boolean $bold
   * @param string $border
   */
  public function styleArray( $color, $font, $bold = false, $border = null  )
  {
    
    $style = array
    (  
      'fill'   =>   array
      (
        'type'    => PHPExcel_Style_Fill::FILL_SOLID,
        'color'    => array( 'argb' => $color )
      ),
      'font' =>   array
      (
        'color'    => array( 'argb' => $font ),
        'bold'    => $bold
      ),
      'borders' => array
      (
        $border => array
        (
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => $this->black)
        )
      )
    );
      
    return $style;
    
  }//end public function styleArray */
  
  /**
   * 
   */
  public function getHeadStyle( $data )
  {
    
    if( $data )
    {
      $color = $this->headDataColor;
    }
    else
    {
      $color = $this->headColumnColor;
    }
    
    $style = $this->styleArray( $color, $this->black, true, 'allborders' );
      
    return $style;
    
  }//end public function getHeadStyle */
  
  /**
   * @return array
   */
  public function getHeaderStyle()
  {

    return $this->styleArray( $this->tableHeadColor, $this->white, true, 'allborders' );
    
  }//end public function getHeaderStyle */
  
  
  
  public function getYearRowsStyle( $switch )
  {
    if( $switch )
    {
      $color = $this->project_year_data_color1;
    }
    else
    {
      $color = $this->project_year_data_color2;
    }
    
    $style = $this->styleArray($color, $this->black, false, 'right');
    
    return $style;
  }
    

  public function getTableRowsStyle( $switch )
  {
    if( $switch )
    {
      $color = $this->tableRowColor1;
    }
    else
    {
      $color = $this->tableRowColor2;
    }
    
    $style = $this->styleArray($color, $this->black, false, 'right');
    
    return $style;
  }
  
    
    
    
  public function getRateRowsStyle( $switch )
  {
    if( $switch )
    {
      $color = $this->project_rate_data_color1;
    }
    else
    {
      $color = $this->project_rate_data_color2;
    }
    
    $style = $this->styleArray($color, $this->black, false, 'right');
    
    return $style;
  }
  
  
  public function getCostRowsStyle( $switch )
  {
    if( $switch )
    {
      $color = $this->project_cost_data_color1;
    }
    else
    {
      $color = $this->project_cost_data_color2;
    }
    
    $style = $this->styleArray($color, $this->black, false, 'right');
    
    return $style;
  }
  
  
  public function getVarianceRowsStyle( $switch )
  {
    if( $switch )
    {
      $color = $this->project_variance_data_color1;
    }
    else
    {
      $color = $this->project_variance_data_color2;
    }
    
    $style = $this->styleArray($color, $this->black, false, 'right');
    
    return $style;
  }
  
  
  public function getErrorRowsStyle( $switch )
  {
    if( $switch )
    {
      $color = $this->project_error_data_color1;
    }
    else
    {
      $color = $this->project_error_data_color2;
    }
    
    $style = $this->styleArray($color, $this->black, false, 'right');
    
    return $style;
  }
  
  
  
  public function getDataHeader( $part )
  {
    switch ($part)
    {
      case 1: 
        $color = $this->project_basic_head_color;
        break;
      case 2:
        $color = $this->project_year_head_color;
        break;
      case 3:
        $color = $this->project_rate_head_color;
        break;
      case 4:
        $color = $this->project_cost_head_color;
        break;
      case 5:
        $color = $this->project_variance_head_color;
        break;
      case 6:
        $color = $this->project_error_head_color;
        break;
      default:
        $color = $this->project_basic_head_color;
    }
    

    $style = $this->styleArray($color, $this->white, true, 'allborders');
    
    return $style;
  }
  
  /**
   * @return array
   */
  public function getBottomBorder()
  {
    
    $style = array
    (  
      'borders' => array
      (
        'bottom' => array
        (
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array( 'argb' => $this->black )
        )
      )
    );
      
    return $style;
    
  }//end public function getBottomBorder */
  
  /**
   * 
   */
  public function getLeftBorder()
  {
    
    $style = array
    (  
      'borders' => array
      (
        'left' => array
        (
          'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('argb' => $this->black)
        )
      )
    );
      
    return $style;
    
  }//end public function getLeftBorder */
  
  /**
   * @return array
   */
  public function getCellStyle()
  {
    
    $style = array
    (
			'font' => array
      (
       'bold' => true,
       'size' => 18,
       'color' => array
        (
        	'argb' => $this->project_basic_head_color
        )
      ),
      'alignment' => array
      (
      	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
      ) ,
    );
          
    return $style;
    
  }//end public function getCellStyle */
  
  /**
   * @return multitype:multitype:multitype:string multitype:string
   */
  public function getAllBorders()
  {
    
    $style = array
    (  
			'borders' => array
      (
				'allborders' => array
        (
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => $this->black)
        )
      )
    );
      
    return $style;
    
  }//end public function getAllBorders */

}

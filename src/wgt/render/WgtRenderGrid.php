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

/** Form Class
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtRenderGrid
{
/*//////////////////////////////////////////////////////////////////////////////
// public interface attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Id des Formulars
   * @var string $keyName
   */
  public $id   = null;
  
  public $head = array();
  
  public $data = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $id
   */
  public function __construct($id, $headCols = array(), $data = array() )
  {
    
    $this->id = $id;
    
  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $code
   */
  public function out($code )
  {
    
    if ($this->cout )
      echo $code;
      
    return $code;
    
  }//end public function out */

/*//////////////////////////////////////////////////////////////////////////////
// Some Static help Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * 
   */
  public function form(  )
  {
    
    $code = <<<CODE
<form method="{$this->method}" action="{$this->action}" id="{$this->id}" ></form>
CODE;

    return $this->out($code );
    
  }//end public static function form */
  
  /**
   * @param array $head
   */
  public function head($headCols  )
  {
    
    $code = '<thead><tr>';
    
    foreach($headCols as $headCol )
    {
      
    }
    
    $code .= '</tr></thead>';

    return $this->out($code );
    
  }//end public function head */
  
  

}//end class WgtFormBuilder



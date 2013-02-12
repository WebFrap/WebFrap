<?php
/*******************************************************************************
*
* @author      : Tobias Schmidt-Tudl <tobias.schmidt-tudl@webfrap.net>
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
 * @author Tobias Schmidt-Tudl <tobias.schmidt-tudl@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class LibDocumentDocu
  extends LibVendorFpdf
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/
  
  
  public $pathDocu = null;
  
  public $menuFile = null;
  
  public $renderKey = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   */
  public function buildDocument()
  {
    
    $menu = "<html>".file_get_contents($this->pathDocu.'/'.$this->menuFile)."</html>";
    $menuTree = simplexml_load_string($menu);
    
    
    

  }//end public function buildDocument */
  
  /**
   * @param SimpleXMLElement $menuTree
   */
  protected function handleMenu( $menuTree )
  {
    
    foreach( $menuTree->children() as $type => $menuNode )
    {
      if(  'a' == $type  )
      {
        $this->handleLink( $menuNode );
      }
    }
    
  }//end protected function handleMenu */

  /**
   * @param SimpleXMLElement $menuNode
   */
  protected function handleLink( $menuNode )
  {
    
    if( !isset( $menuNode['class'] ) )
      return;
      
    $classes = explode(' ', trim($menuNode['class']));
    
    if( !in_array( $this->renderKey , $classes) )
      return;
      
    $src = explode( 'page=' , trim( $menuNode['src'] )) ;
    $src = str_replace( '.', str_replace( '.', '/', $src[1] ) ).'.php';
      
    $this->includeFile( $src );
    
    
  }//end protected function handleMenu */
  
}//end class LibDocumentBillSimple


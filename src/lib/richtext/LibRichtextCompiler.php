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
 *
 */
class LibRichtextCompiler
  extends BaseChild
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @var LibRichtextParser
   */
  public $parser = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////
  
  /**
   * @param BaseChild $env
   */
  public function __construct( $env )
  {
    
    $this->env = $env;
    
  }//end public function __construct */

  /**
   * @param string $rawText
   */
  public function compile( $rawText )
  {
    
    if( !$this->parser )
      $this->parser = new LibRichtextParser( $this );
      
    $this->parser->parse( $rawText );
    $compiled = $rawText;
    
    foreach( $this->parser->nodes as /* @var $node LibRichtextNode  */ $node )
    {
      $compiled = $node->replaceNode( $compiled );
    }
    
    return $compiled;
    
  }//end public function compile */

  

}//end class LibRichtextCompiler



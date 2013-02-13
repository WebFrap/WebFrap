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
abstract class LibFilereader
  implements Iterator
{
//////////////////////////////////////////////////////////////////////////////*/  
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var string
   */
  protected $filename;
  
  /**
   * @var string
   */
  protected $resource;
  
//////////////////////////////////////////////////////////////////////////////*/  
// comment
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param string $filename
   */
  public function __construct( $filename = null )
  {
    $this->filename = $filename;
    
    if( $filename )
     $this->load( $filename );
    
  }//end public function __construct */
  
  /**
   * 
   */
  public function __destruct()
  {
    $this->close();
  }//end public function __destruct */
  
  /**
   * 
   * @param string $filename
   */
  abstract public function load( $filename );
  
  /**
   * 
   * @param string $filename
   */
  abstract public function close( );

//////////////////////////////////////////////////////////////////////////////*/  
// Interface Iterator
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @see Iterator::current
   */
  public function current (){}

  /**
   * @see Iterator::key
   */
  public function key (){}

  /**
   * @see Iterator::next
   */
  public function next (){}

  /**
   * @see Iterator::rewind
   */
  public function rewind (){}

  /**
   * @see Iterator::valid
   */
  public function valid (){}


} // end class LibFilereader



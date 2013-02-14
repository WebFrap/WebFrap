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
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author Dominik Donsch <dominik.bonsch@webfrap.net>
 *
 */
class LibProcessSlice_Rating extends LibProcessSlice
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// check methodes
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @return WgtProcessFormSlice_Rating
   */
  public function getRenderer()
  {
    
    return new WgtProcessFormSlice_Rating($this );
  }//end public function getRenderer */
  
/*//////////////////////////////////////////////////////////////////////////////
// Debug Data
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Methode zum bereitstellen notwendiger Debugdaten
   * Sinn ist es möglichst effizient den aufgetretenen Fehler lokalisieren zu 
   * können.
   * Daher sollte beim implementieren dieser Methode auch wirklich nachgedacht
   * werden.
   * Eine schlechte debugData Methode ist tendenziell eher schädlich.
   * 
   * @return string
   */
  public function debugData()
  {
    
    return 'Slice Rating';
    
  }//end public function debugData */

}//end class LibProcessSlice_Rating




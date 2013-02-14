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
 */
class LibImageThumbSystemImagemagick extends LibImageThumbAdapter
{


  /**
   * Enter description here...
   *
   */
  public function genThumb( )
  {

    system( "convert $this->origName -resize ".$this->maxWidth."x".$this->maxHeight." $this->thumbName" );

  }//end public function genThumb


}// end class LibImageThumbSystemImagemagick

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
  * Download Klasse für WebFrap
  * @package WebFrap
  * @subpackage tech_core
  */
class LibDownload
{

/*//////////////////////////////////////////////////////////////////////////////
// Singleton Pattern
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibDownloadAdapter
   */
  public static function getDownload()
  {

    $request = Request::getActive();

    if (!$type = $request->param('type')) {
      throw new Io_Exception('Invalid Download Type');
    }

    $classname = 'LibDownload'.ucfirst($type);

    if (WebFrap::classExists($classname) &&  $classname != 'LibDownloadAdapter') {
      $download = new $classname();
    } else {
      throw new Io_Exception('Invalid Download Type');
    }

    return $download;

  }//end public function getDownload

} // end class LibDownload


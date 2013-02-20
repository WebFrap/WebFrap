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
class LibFilewriterCsv extends LibFilewriter
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $delimiter = ';';

  /**
   *
   * @var string
   */
  public $enclosure = '"';

  /**
   *
   * @var string
   */
  public $escape    = '\\';

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $filename
   */
  public function open($filename )
  {

    SFilesystem::touchFolder( dirname($filename) );

    if (!$this->resource = fopen($filename , 'a+' )) {
      throw new Io_Exception('failed to open csv resource: '.$filename);
    }

  }//end public function open */

  public function close()
  {
    if ( is_resource($this->resource) )
     fclose($this->resource);
  }//end public function close

/*//////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
//////////////////////////////////////////////////////////////////////////////*/

  public function write ($data  )
  {

    fseek($this->resource, SEEK_END  );
    $this->actual = fputcsv($this->resource, $data, $this->delimiter, $this->enclosure );

  }//end public function next */

} // end class LibFilesystemFile


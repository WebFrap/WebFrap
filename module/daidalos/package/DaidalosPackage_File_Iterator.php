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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosPackage_File_Iterator
  extends IoFileIterator
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $fileName = null;

  /**
   * Den Targetfolder um den Key sauber zurück zu geben
   * @var string
   */
  protected $targetFolder = null;

  /**
   * @param string $folder
   * @param string $targetFolder
   * @param int $mode
   * @param boolean $recursive
   * @param string $filter
   */
  public function __construct
  (
    $folder,
    $targetFolder,
    $mode = IoFileIterator::RELATIVE,
    $recursive = true,
    $filter = null
  )
  {

    $this->folder     = str_replace('//', '/', $folder);
    $this->mode       = IoFileIterator::RELATIVE;
    $this->recursive  = $recursive;
    $this->targetFolder = $targetFolder;

    if( $filter )
      $this->filter     = explode( ',', $filter );

    if ( is_dir($folder) ) {
      $this->fRes = opendir( $folder );
      $this->next();
    } else {
      Debug::console( 'Tried to open nonexisting Folder: '.$folder );
    }

  }// public function __construct

////////////////////////////////////////////////////////////////////////////////
// Interface: Iterator
////////////////////////////////////////////////////////////////////////////////

  /**
   * @see Iterator::next
   */
  public function next ()
  {

    $repeat   = true;
    $current  = null;

    while ($repeat) {

      if ($this->subFolder) {
        $nextSub = $this->subFolder->current();
        $key     = $this->subFolder->key();

        if ($nextSub) {
          $this->subFolder->next();
          $this->current = $nextSub;
          $this->key     = $key;

          return $this->current;
        } else {
          $this->subFolder = null;
          $this->current   = null;
          $this->key       = null;
          continue;
        }
      }

      $current = readdir( $this->fRes );

      // dirty.... so what?
      if( '.' == $current  )
        continue;

      if( '..' == $current )
        continue;

      if ($current) {
        if ( is_dir( $this->folder.'/'.$current )  ) {

          if( !$this->recursive )
            continue;

          // wenn current ein ordner ist wird ers über ihn iteriert bevor
          // das nächste element des aktuellen ordners ausgelesen wird
          $this->subFolder = new DaidalosPackage_File_Iterator
          (
            $this->folder.'/'.$current.'/',
            $this->targetFolder,
            $this->mode,
            $this->recursive,
            $this->filter
          );

          $current  = $this->subFolder->current();

          if (!$current) {
            $this->subFolder = null;
            $this->current   = null;
            $this->key       = null;
            continue;
          } else {
            $this->key       = $this->subFolder->key();
            $this->current   = $current;
            $this->subFolder->next();

            return $this->current;
          }

        } else {

          // auf eine dateiendung prüfen
          if ($this->filter) {

            $info = pathinfo(str_replace( '//', '/', $this->folder.'/'.$current ));

            if( !in_array( strtolower('.'.$info['extension']), $this->filter  )  )
              continue;

          }

          // den rückgabe modus auswerten
          if( $this->fileMode != IoFileIterator::FILE_ONLY )
            $current = str_replace( '//', '/', $this->folder.'/'.$current );

        }

      } else {
        $this->current = null;

        return null;
      }

      $repeat = false;
    }

    // sicher stellen, dass die pfade korrekt sind
    if( $current )
      $this->current = $current;
    else
      $this->current = null;

    $this->key = $this->targetFolder.'/'.SParserString::shiftXTokens(str_replace( array('../','//'), array('/','/'), $current ), '/', 2);

    return $this->current;

  }//end public function next */

}//end class DaidalosPackage_File_Iterator */

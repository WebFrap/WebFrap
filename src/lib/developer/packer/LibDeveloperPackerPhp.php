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
 * @subpackage ModDeveloper
 */
class LibCodePackerPhp
{
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @var string
   */
  public $fileName = 'WebFrapCore';

  /**
   * Enter description here...
   *
   * @var array
   */
  public $files = array();

////////////////////////////////////////////////////////////////////////////////
// Protected Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $commentOpen = false;

  /**
   *
   * @var unknown_type
   */
  protected $ignoreSecCheck = false;

  /**
   * Enter description here...
   *
   * @var resource
   */
  protected $writer = null;

  /**
   * Enter description here...
   *
   * @var resource
   */
  protected $reader = null;

  /**
   *
   * @var unknown_type
   */
  protected $allreadPacked = array();

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @param filename $fileName
   * @param files $files
   */
  public function pack( $fileName = null, $files = array() )
  {
    //return;

    if (!$fileName) {
      $fileName = $this->fileName ;
    }

    if (!$files) {
      $files = $this->files;
    }

    $this->writer = fopen( $fileName , 'w' );

    fwrite( $this->writer , '<?php'.NL , strlen('<?php'.NL) );

    foreach ($files as $file) {
      $this->packFromFile( $file );
      fwrite( $this->writer , NL , strlen(NL) );
    }

    fwrite( $this->writer , '?>'.NL , strlen('?>'.NL) );
    fclose( $this->writer );

  }//end public function pack */

  /**
   * Enter description here...
   *
   * @param string $files
   */
  public function setFilesAsClasses( $files )
  {

    $classIndex = array();

    $plainClasses = array();
    $childClasses = array();
    $interfaces = array();

    $dependecies = array();

    foreach ($files as $class) {
      $reflector = new LibReflectorClass($class);
      $classIndex[$class] =  $reflector->getFilename();

      if ( $reflector->isInterface() ) {
        $interfaces[] =  $reflector->getFileName();
      } elseif ( $parentClass = $reflector->getParentClass() ) {
        $childClasses[$class] =  $reflector->getFilename();
        $dependecies[] = array( $class , $parentClass->getName() );
      } else {
        $plainClasses[] =  $reflector->getFilename();
      }

    }

    $resolver = new LibDependency( $dependecies );
    $resolver->solveDependencies();

    $resolvedDeps = array();
    foreach ( $resolver->getCombined() as $dep ) {
      $resolvedDeps[] = $classIndex[$dep];
    }

    $fileIndex = array();

    foreach ($interfaces as $file) {
      $fileIndex[] = $file;
    }

    foreach ($plainClasses as $file) {
      $fileIndex[] = $file;
    }

    foreach ($resolvedDeps as $file) {
      if ( !in_array( $file , $fileIndex  ) ) {
        $fileIndex[] = $file;
      }
    }

    $this->files = $fileIndex;

  }//end  public function setFilesAsClasses */

  /**
   * Enter description here...
   *
   * @param string $filename
   */
  protected function packFromFile( $filename )
  {

    if (!$read = fopen( $filename , 'r'  )) {
      Controller::addWarning( 'Failed to open: '.$filename );

      return;
    }

    $rows = array();

    while ( !feof($read) ) {
      $row = fgets($read, 4096);
      if ( !$this->isComment($row) ) {
        if ( !$this->ignore( $row ) ) {
          $rows[] = $row;
        }
      }
    }

    /*
    while ( !feof($read) ) {
      $row = fgets($read, 4096);
      if ( !$this->isComment($row) ) {
        $rows[] = $row;
      }
    }*/

    // hope to remove <?php and ? >
    array_pop($rows);
    array_shift($rows);

    foreach ($rows as $row) {
      fwrite( $this->writer , $row , strlen($row) );
    }

    fclose($read);

  }//end protected function packFromFile */

  /**
   *
   */
  protected function isComment( $row )
  {

    $row = trim($row);
    $lenght = strlen($row);

    if ($this->commentOpen) {
      if (  substr( $row , -2  ) == '*/' ) {
        $this->commentOpen = false;
      }

      return true;
    } elseif ($lenght == 0) {
      // ignore whitespace
      return true;
    } elseif ( $row[0] ==  '#' || $row[0] ==  '*' || substr( $row , 0 , 2  ) == '//' ) {
      // must be a comment
      return true;
    } elseif ( substr( $row , 0 , 2  ) == '/*' ) {
      // start a multiline comment
      $this->commentOpen = true;

      return true;
    }

    // everything else is no comment
    return false;

  }//end protected function isComment */

  /**
   * Enter description here...
   *
   * @param unknown_type $row
   * @return unknown
   */
  protected function ignore( $row )
  {

    $row = str_replace( ' ' , '', trim($row) );

    if ( $row == 'Debug::addLoc(__line__+1);' || $row == 'Debug::addLoc(__line__+1);' ) {
      return true;
    }

    return false;

  }//end protected function ignore */

} // end class LibCodePacker

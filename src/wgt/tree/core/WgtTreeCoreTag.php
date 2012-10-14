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
 * class WgtItemTree
 * @package WebFrap
 * @subpackage ModDms
 */
class WgtTreeCoreTag
  extends WgtTreeAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $folders = array();

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $files = array();

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function load()
  {

    $daoFolder = DaoDmsFolder::getInstance();
    $daoFile   = DaoDmsFile::getInstance();

    foreach( $daoFolder->getAll( array('rowid','name','id_parent') , false ) as $entry )
    {
      $parent = trim($entry['id_parent']) != '' ? $entry['id_parent']:'0';
      $this->folders[$parent][] = $entry;
    }

    foreach( $daoFile->getAll(array('rowid','name','id_folder') , false) as $entry )
    {
      $file = trim($entry['id_folder']) != '' ? $entry['id_folder']:'0';
      $this->files[$file][] = $entry;
    }

    return true;


  }//end public function load

  /** Parser zum generieren eines Treemenus
   *
   * @return
   */
  public function build( )
  {


    $this->load();

    $view = Controller::getModul('VIEW');

    $this->html = $this->genTree();

    return $this->html;

  }//end public function build

  /**
  * Hauptfunktion zum generieren des Baums
  *
  * Diese Funktion generiert die Rootordner und Rootbookmarks der kompletten
  * Bookmarkstruktur.
  * @return void
  */
  public function genTree()
  {

    $html = '<div class="wgtTree" ><ul>';
    $html .= $this->genFolderTree( '0' );
    $html .= $this->genFileTree( '0' );
    $html .= '</ul></div>';

    return $html;

  } //end public function genTree

  /**
  * Funktion zum rekursiven generieren von Menueinträgen
  *
  * Durch Rekursives aufrufen dieser Funktion werden alle Menüpunkte generiert
  *
  * @param Int Lang Die Id des Vaterordners
  * @param Int Pos Die Id des Vaterordners
  * @return void
  */
  public function genFolderTree( $pos )
  {


    $view = View::getActive();

    $html = '';

    if( isset($this->folders[$pos]) )
    {
      foreach( $this->folders[$pos] as $entry )
      {
        $id        =  $entry['rowid'];
        $name      =  $entry['name'];

      $linkNew = '<a href="'.TUrl::asUrl
        (
          'index.php',
          array
          (
          'mod'=>'Dms',
          'mex'=>'Folder',
          'do'=>'formDmsFolder',
          'parent'=>$id
          ),
          'DmsFolder erstellen'
        ).'">'
        .$view->createIcon( 'dms/folder_add.png' , 'xsmall' , 'Ordner anlegen' )
        .'</a>';

      $linkWorkon = '<a href="'.TUrl::asUrl
        (
        'index.php',
        array
        (
        'mod'=>'Dms',
        'mex'=>'Folder',
        'do'=>'setdmsfolderactiv',
        'dmsfolder'=>$id
        ),
        'DmsFolder bearbeiten'
        ).'">'
        .$view->createIcon( 'dms/folder_edit.png' , 'xsmall' , 'Ordner bearbeiten' )
        .'</a>';

      $linkDelete = '<a href="'.TUrl::asUrl
        (
        'index.php',
        array
        (
        'mod'=>'Dms',
        'mex'=>'Folder',
        'do'=>'deleteDmsFolder'
        ,'delId'=>$id
        ),
        'DmsFolder löschen'
        ).'">'
        .$view->createIcon( 'dms/folder_delete.png' , 'xsmall' , 'Ordner löschen' )
        .'</a>';

      $linkNewFile = '<a href="'.TUrl::asUrl
        (
          'index.php',
          array
          (
          'mod'=>'Dms',
          'mex'=>'File',
          'do'=>'formDmsFile',
          'dmsfolder'=>$id
          ),
          'Datei erstellen'
        ).'">'
        .$view->createIcon( 'dms/file_add.png' , 'xsmall' , 'File anlegen' )
        .'</a>';


        $html .= '<li>'
          .'<span ><a name="wgtTree'.$this->name.'File'.$id.'"></a>
            <img   src="./templates/default/icons/xsmall/dms/folder.png"
                  alt="Folder" />'
          .'&nbsp;&nbsp;'.$name .'<span style="margin-left:50px;">'.$linkNew.$linkWorkon.$linkDelete.$linkNewFile.'</span>'
          .'</span>';

        $html .= "<ul>\n";
        $html .= $this->genFolderTree( $id );
        $html .= $this->genFileTree( $id );
        $html .= "</ul>\n";

        $html .= "</li>\n";

      }// End Foreach

    } // Ende IF

    return $html;

  }//end public function genSubTree

    /**
  * Funktion zum rekursiven generieren von Menueinträgen
  *
  * Durch Rekursives aufrufen dieser Funktion werden alle Menüpunkte generiert
  *
  * @param Int Lang Die Id des Vaterordners
  * @param Int Pos Die Id des Vaterordners
  * @return void
  */
  public function genFileTree( $pos )
  {


    $html = '';
    $view = Controller::getSysmodul('VIEW');

    if( isset($this->files[$pos]) )
    {

      foreach( $this->files[$pos] as $entry )
      {

        $id        =  $entry['rowid'];
        $name      =  $entry['name'];



      $linkWorkon = '<a href="'.TUrl::asUrl
        (
        'index.php',
        array
        (
        'mod'=>'Dms',
        'mex'=>'File',
        'do'=>'setdmsfileactiv',
        'dmsfile'=>$id
        ),
        'Datei bearbeiten'
        ).'">'
        .$view->createIcon( 'dms/file_edit.png' , 'xsmall' , 'File bearbeiten' )
        .'</a>';

      $linkDelete = '<a href="'.TUrl::asUrl
        (
        'index.php',
        array
        (
        'mod'=>'Dms',
        'mex'=>'File',
        'do'=>'deleteDmsFile'
        ,'delId'=>$id
        ),
        'Datei löschen'
        ).'">'
        .$view->createIcon( 'dms/file_delete.png' , 'xsmall' , 'File löschen' )
        .'</a>';

        $html .= '
          <li><span><a name="wgtTree'.$this->name.'File'.$id.'" ></a>
            <img  src="./templates/default/icons/xsmall/dms/file.png"
                  alt="File" />'
          .'&nbsp;&nbsp;'.$name .'<span style="margin-left:50px;">'.$linkWorkon.$linkDelete.'</span>
          </span>';

        $html .= '</li>'.NL;

      }// End Foreach

    } // Ende IF

    return $html;

  }//end public function genSubTree

}// end of WgtTreeDmsFoldertree


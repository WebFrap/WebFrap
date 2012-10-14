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
 * class WgtTreeCoreMot
 * @package WebFrap
 * @subpackage ModDms
 */
class WgtTreeCoreMot
  extends WgtTreeAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function load()
  {


    $collection = new CollectionCoreTree();

    $this->data = $collection->getRoot();

  }//end public function load()

  /** Parser zum generieren eines Treemenus
   *
   * @return
   */
  public function build( )
  {


    $this->load();

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


    $html = '<div class="wgtTree" ><ul>'.NL;
    $html .= $this->genFolderTree( '0' );
    $html .= $this->genFileTree( '0' );
    $html .= '</ul></div>'.NL;

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

    $view = Controller::getSysmodul('VIEW');

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
        .Wgt::icon( 'dms/folder_add.gif' , 'xsmall' , 'Ordner anlegen' )
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
        .$view->createIcon( 'dms/folder_edit.gif' , 'xsmall' , 'Ordner bearbeiten' )
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
        .Wgt::icon( 'dms/folder_delete.gif' , 'xsmall' , 'Ordner löschen' )
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
        .Wgt::icon( 'dms/file_add.gif' , 'xsmall' , 'File anlegen' )
        .'</a>';


        $html .= '<li>'
          .'<span ><a name="wgtTree'.$this->name.'File'.$id.'"></a>
            <img  src="./templates/default/icons/xsmall/dms/folder.gif"
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
    $view = View::getActive();

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
        .Wgt::icon( 'dms/file_edit.gif' , 'xsmall' , 'File bearbeiten' )
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
        .Wgt::icon( 'dms/file_delete.gif' , 'xsmall' , 'File löschen' )
        .'</a>';

        $html .= '
          <li><span><a name="wgtTree'.$this->name.'File'.$id.'" ></a>
            <img  src="./templates/default/icons/xsmall/dms/file.gif"
                  alt="File" />'
          .'&nbsp;&nbsp;'.$name .'<span style="margin-left:50px;">'.$linkWorkon.$linkDelete.'</span>
          </span>';

        $html .= '</li>'.NL;

      }// End Foreach

    } // Ende IF

    return $html;

  }//end public function genSubTree


}// end of WgtTreeDmsFoldertree


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
 * class WgtItemFoldertree
 * Objekt zum generieren eines Datei
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtItemFoldertree extends WgtItemAbstract
{

  /** Vorsortierter Array mit Daten des Ordnerbaums
   *
   */
  private $__folders = null;

  /** Vorsortierter Array mit den Dateidaten
   *
   */
  private $__files = null;

  /**
   *
   * @param string Name Name der Textarea
   * @return

   */
  public function __construct($Name)
  {
    parent::__construct($Name , __class__);
  } // end of member function __construct

  /** Hinzufügen der Benötigten Daten zum generieren des Folders
   *
   * @param array Folders Der Ordnerbaum
   * @param array Files Die Dateidaten
   * @return

   */
  public function addData($Folders , $Files)
  {
    $this->__folders = null;
    $this->__files = null;

  } // end of member function addData

  /** Parser zum generieren eines Treemenus
   *
   * @return

   */
  public function build()
  {

    $this->genMenuroot();

    return $this->_html;
  } // end of member function Parse

  /**
  * Hauptfunktion zum generieren des Baums
  *
  * Diese Funktion generiert die Rootordner und Rootbookmarks der kompletten
  * Bookmarkstruktur.
  * @return void
  */
  public function genMenuroot()
  {

    $idlang = $this->SYS->getSysStatus("idlang");

    $this->_html .= "<ul>\n
                    <li>\n";
    $this->genSubmenu($idlang , 0);
    $this->_html .= "</li>\n
                    </ul>\n";

  } // Ende function  genMenuroot()

  /**
  * Funktion zum rekursiven Generieren von Menueinträgen
  *
  * Durch Rekursives aufrufen dieser Funktion werden alle Menüpunkte generiert
  *
  * @param Int Lang Die Id des Vaterordners
  * @param Int Pos Die Id des Vaterordners
  * @return void
  */
  public function genSubmenu($Lang , $Pos)
  {

    if (isset($this->_data[$Lang][$Pos])) {
      $Data = $this->_data[$Lang][$Pos];
        asort($Data);
        $this->_html .= "<ul>\n";
        foreach ($Data as $obj) {
          if (is_object($obj)) {

          $id = $obj->getId();
          $titel = " title=\"Id: $id Titel: ". $obj->getData("menutext")."\" " ;

          $src = trim($obj->getData("menuicon"));
          if ($src != "") {
            $icon = "<img src=\"".$obj->getData("menuicon")."\" alt=\"".
              $obj->getData("menuiconalt")."\" class=\"xsmall\" />";
          } else {
            $icon = "";
          }

          $url = trim($obj->getData("menulink"));
          if ($url != "") {
            $text = "<a href=\"".$obj->getData($url)."\">".
              $obj->getData("menutext")."</a>";
          }
          $text = "<a $titel href=\"".$obj->getData($url)."\">".
            $obj->getData("menutext")."$icon</a>";

          $workon = "<a title=\"Eintrag bearbeiten\" href=\"./sys,action-".
            "WorkonMenu-identry-$id,Eintrag-bearbeiten.html\">workon</a>";

          $delete = "<a title=\"Eintrag löschen\" href=\"./sys,action-".
            "DeleteEntry-identry-$id,Eintrag-loeschen.html\">delete</a>";

          $this->_html .= "<li>\n";
          $this->_html .= "$text \n $workon \n $delete \n";

          $this->genSubmenu($Lang , $obj->getId());
          $this->_html .= "</li>\n";
          }
        } // Ende Foreach
        $this->_html .= "</ul>\n";
    }

  } // Ende  function Submenu($id)

} // end of ObjViewScobjMainmenu


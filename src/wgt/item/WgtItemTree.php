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
class WgtItemTree
  extends WgtItemAbstract
{

  /** Parser zum generieren eines Treemenus
   *
   * @return string
   */
  public function build( )
  {
    if( Log::$levelDebug )
      Log::start( __file__ , __line__ , __method__ );

    $this->genMenuroot();
    return $this->html;

  } // end public function build( )

  /**
  * Hauptfunktion zum generieren des Baums
  *
  * Diese Funktion generiert die Rootordner und Rootbookmarks der kompletten
  * Bookmarkstruktur.
  * @return void
  */
  public function genMenuroot()
  {
    if( Log::$levelDebug )
      Log::start( __file__ , __line__ , __method__ );

    $this->html .= '<ul>'.NL.'<li>'.NL;
    $this->genSubmenu( 0 );
    $this->html .= '</li>'.NL.'</ul>'.NL;

  } // Ende function genMenuroot()

  /**
  * Funktion zum rekursiven generieren von Menueinträgen
  *
  * Durch Rekursives aufrufen dieser Funktion werden alle Menüpunkte generiert
  *
  * @param Int Lang Die Id des Vaterordners
  * @param Int Pos Die Id des Vaterordners
  * @return void
  */
  public function genSubmenu( $pos )
  {
    if( Log::$levelDebug )
      Log::start( __file__ , __line__ , __method__ , array($pos) );

    if( isset($this->data[$pos]) )
    {
      $data = $this->data[$pos];
      asort($data);
      $this->html .= '<ul>'.NL;

      foreach( $data as $obj )
      {
        if( is_object($obj))
        {

        $id = $obj->getId();
        $titel = " title=\"Id: $id Titel: ". $obj->getData("menutext")."\" " ;

        $src = trim($obj->getData("menuicon"));
        if( $src != '' )
        {
          $icon = "<img src=\"".$obj->getData("menuicon")."\" alt=\"".
            $obj->getData("menuiconalt")."\" class=\"xsmall\" />";
        }
        else
        {
          $icon = "";
        }

        $url = trim($obj->getData("menulink"));
        if( $url != '' )
        {
          $text = "<a href=\"".$obj->getData($url)."\">".
            $obj->getData("menutext")."</a>";
        }

        ///TODO Fix this that it is independent
        $text = "<a $titel href=\"".$obj->getData($url)."\">".
          $obj->getData("menutext")."$icon</a>";

        $workon = "<a title=\"Eintrag bearbeiten\" href=\"./sys,action-".
          "WorkonMenu-identry-$id,Eintrag-bearbeiten.html\">workon</a>";

        $delete = "<a title=\"Eintrag löschen\" href=\"./sys,action-".
          "DeleteEntry-identry-$id,Eintrag-loeschen.html\">delete</a>";


        $this->html .= '<li>'.NL;
        $this->html .= "$text \n $workon \n $delete \n";

        $this->genSubmenu( $obj->getId() );
        $this->html .= '</li>'.NL;
        }
      } // Ende Foreach
      $this->html .= '</ul>'.NL;

    }

  }//end public function genSubmenu( $pos )

} // end class WgtItemTree


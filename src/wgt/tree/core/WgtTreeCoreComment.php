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
 * @subpackage tech_core
 */
class WgtTreeCoreComment
  extends WgtTreeAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function load()
  {

    foreach( DaoCoreComment::getInstance()->getDboWhere( $this->where ) as $node )
    {
      $this->data[$node['id_parent']] = $node;
    }

  }//end public function load */

  /** Parser zum generieren eines Treemenus
   *
   * @return
   */
  public function build( )
  {

    $this->load();

    $this->html = $this->genTree();

    return $this->html;

  }//end public function build */

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
    $html .= $this->genSubTree( '0' );
    $html .= '</ul></div>';

    return $html;

  } //end public function genTree */

  /**
  * Funktion zum rekursiven generieren der Knoten
  *
  * @param int $pos Die Id des Vaterordners
  * @return void
  */
  public function genSubTree( $pos )
  {

    $view = View::getActive();

    if( !isset($this->data[$pos]) )
    {
      return '';
    } // Ende IF

    $html = '';

    foreach( $this->data[$pos] as $entry )
    {

      $html .= '<li>'
        .'<span >'.Wgt::icon('webfrap/comment.png','xsmall')
        .'&nbsp;&nbsp;'.$entry['name'].'</span>';

      $html .= "<ul>".NL;
      $html .= $this->genSubTree( $entry['id_parent'] );
      $html .= "</ul>".NL;

      $html .= "</li>".NL;

    }// End Foreach

    return $html;

  }//end public function genSubTree */



}// end class WgtTreeCoreComment


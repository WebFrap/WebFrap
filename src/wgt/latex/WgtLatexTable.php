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
class WgtLatexTable
  extends WgtTable
{

  /**
   *
   * @var unknown_type
   */
  public $caption = null;

  /**
   *
   * @var unknown_type
   */
  public $bodySize = null;

  /**
   *
   * @var unknown_type
   */
  public $noHead   = null;

  /**
   *
   * @var unknown_type
   */
  public $vertical   = false;

////////////////////////////////////////////////////////////////////////////////
// Table Navigation
////////////////////////////////////////////////////////////////////////////////

  /**
   * build the table
   *
   * @return String
   */
  public function build( )
  {

    if( $this->html )

      return $this->html;

    $keys = array_keys( $this->rows );

    // Creating the Head
    $head = '{';

    foreach( $this->rows as $row )
      $head .= '|l';

    $head .= '|}';

    if( $this->caption )
      $head .= '\\caption{'.$this->caption.'}\\\\';

    if (!$this->noHead) {
      $head .= '\\hline'.NL;

      $tmp = '';
      foreach( $this->rows as $row )
        $tmp .= str_replace( '_' , ' ' , $row ).' & ';

      $head .= substr($tmp,0,-2).'\\\\'.NL;
      $head .= '\\hline'.NL;
      $head .= '\\hline'.NL;
    } else {
      $head .= NL;
    }

    //\ Creating the Head

    if ($this->bodySize) {
      $body = array();
    } else {
      // Generieren des Bodys
      $body = ''.NL;
    }

    // Welcher Rowtyp soll ausgegeben werden
    if ($this->bodySize) {

      $pos = 0;

      $tmpBody = '';

      foreach ($this->data as $line => $row) {

        $tmp = '';

        foreach( $keys as $key )
          $tmp .= $row[$key] .' & ';

        $tmp = substr($tmp,0,-2);

        $tmp .= '\\\\'.NL;
        $tmp .= '\\hline'.NL;

        $tmpBody .= $tmp;

        $pos ++;

        if ($this->bodySize == $pos) {
          $body[] = $tmpBody;
          $tmpBody = '';
          $pos = 0;
        }

      } // ENDE FOREACH

      // wenn noch was übrig ist neue tabelle erstellen
      if( $tmpBody != '' )
        $body[] = $tmpBody;

    } else {
      foreach ($this->data as $line => $row) {

        $tmp = '';

        foreach( $keys as $key )
          $tmp .= $row[$key] .'&';

        $body .= substr($tmp,0,-1);

        $body .= '\\\\'.NL;
        $body .= '\\hline'.NL;

      } // ENDE FOREACH
    }

    //\ Create the table body

    $this->html = '';

    if ($this->bodySize) {
      foreach ($body as $bod) {

        if( $this->vertical )
          $this->html .= '\begin{sideways}'.NL;

        $this->html .= '\begin{tabular}';
        $this->html .= $head;
        $this->html .= $bod;
        $this->html .= '\end{tabular}'.NL;

        if( $this->vertical )
          $this->html .= '\end{sideways}'.NL;

      }

    } else {
      $this->html .= '\begin{longtable}';
      $this->html .= $head;
      $this->html .= $body;
      $this->html .= '\end{longtable}'.NL;
    }

    return $this->html;

  }//end public function build */

}//end class WgtTable

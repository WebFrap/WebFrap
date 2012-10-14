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
class WgtItemTable
  extends WgtItemAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Das Template nach dem die Tabelle generiert wird
   */
  protected $tableTemplate = "";

  /**
   *
   */
  protected $colOrder      = array();

  /**
   * Die Attribute die der Tabelle mit übergeben werden
   */
  protected $attributes    = "";

  /**
   * Der Foot der Tabelle
   */
  protected $tableFoot     = array();

  /**
   *
   */
  protected $where         = null ;

  /**
   * Komplette Anzahl der Einträge die für diese Auswahl angezeigt werden können
   * wird zum paging benötigt
   */
  protected $tableSize     = null;

  /**
   *
   */
  protected $anzMenuNumbers = 5;

  /**
   *
   */
  protected $stepSize      = Wgt::LIST_SIZE_CHUNK;

  /**
   *
   */
  protected $numOfColors   = 2;

  /**
   * @var string
   */
  protected $linkTarget     = 'area-Admin-ext-Groups-action-tableGroups';

  /**
   * @var string
   */
  protected $linkTitle      = 'List-Groups';

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $anzMenuNumbers
   */
  public function setMenuNumbers( $anzMenuNumbers )
  {
    $this->anzMenuNumbers = $anzMenuNumbers;
  }//end public function setMenuNumbers */

  /**
   * @param int $stepSize
   */
  public function setStepSize( $stepSize )
  {
    $this->stepSize = $stepSize;
  }//end public function setStepSize */

  /** Hinzufügen von Daten zur Tabelle
   *
   * @param array Row Die Daten der Tabelle in einem Array
   * @deprecated
   * @return
   */
  public function addRows( $row )
  {
    if( is_array($row) and isset( $row[0] )  )
    {
      $this->data = array_merge( $this->data , $row );
    }
    elseif( is_array($row) )
    {
      $this->data[] = $row;
    }
    else
    {
      return false;
    }

  } // end public function addRows */

  /**
   * @param array $row
   */
  public function addData( $row )
  {
    if( is_array($row) and isset( $row[0] )  )
    {
      $this->data = array_merge( $this->data , $row );
    }
    elseif( is_array($row) )
    {
      $this->data[] = $row;
    }
    else
    {
      return false;
    }

  }//end public function addData */

  /**
   * Abfragen der vorhandenen Reihen
   *
   * @return array
   * @deprecated
   */
  public function getRows( )
  {
    return $this->data;

  }//end public function getRows */

  /**
   *
   * @param array $Foot , Reihe mit den Daten für den Footer
   * @return
   */
  public function addFoot( $Foot )
  {
    $this->tableFoot = $Foot;

  }//end public function addFoot */

  /**
   * Abfragen der Vorhandenen Attribute
   *
   * @return array
   */
  public function getFoot( )
  {
    return $this->tableFoot;
  }//end public function getFoot */

  /**
   * @param string $where
   */
  public function setWhere( $where )
  {
    $this->where = $where;
  }//end public function setWhere */

  /** Setzen des Templates für die Tabellen
   *
   * @param array $template Das Template nach dem die Tabellen geneneriert werden
   * @param array $colOrder
   * @return void
   */
  public function setTemplate( $template , $colOrder = array() )
  {

    $this->tableTemplate  = $template;
    $this->colOrder       = $colOrder;

  }//end public function setTemplate */

  /**
   * @param int $numOfColors
   */
  public function setNumOfColors( $numOfColors )
  {

    $this->numOfColors = $numOfColors;
  }//end public function setNumOfColors */

  /**
   * @return string
   */
  public function build()
  {
    
    if( !$this->tableTemplate )
    {
      return $this->buildNotemp( 'Bright' );
    }
    elseif( is_array($this->tableTemplate) )
    {
    }
    elseif($xml = simplexml_load_string( $this->tableTemplate ))
    {
      return $this->buildWithXmlTemplate( 'Bright' );
    }
    else
    {
      return $this->buildNotemp( 'Bright' );
    }
    
  }//end public function build */

 /**
   * Parsen von Tablesdaten
   *
   * @param string Template Das zu bearbeitende Template
   * @return
   */
  public function buildWithXmlTemplate( $type = null  )
  {

    $this->html = "\n<table id=\"table_".$this->name."\" class=\"Table".
      $xml["type"]."\" >\n";

    $NumOfColors = $xml["num"];

    $head = "<thead>\n";
    $head .= "<tr>";
    foreach( $xml->thead->td as $inhalt )
    {
      $head .= "<th width=\"".$inhalt["width"]."\" valign=\"top\" >$inhalt</th>";
    }
    $head .= "</tr>\n";
    $head .= "</thead>\n";

    $anz = count($xml->thead->td);
    // Generieren des Bodys
    $body = "<tbody>\n";

    // Welcher Rowtyp soll ausgegeben werden
    $num = 1;
    $nam = 0;

    foreach( $this->data as $row   )
    {
      $rowid = $this->name."_row_${nam}";

      $body .= "<tr class=\"row$num\" id=\"$rowid\" >";

      for( $nem = 0 ; $nem < $anz ; $nem ++  )
      {
        $body .= "<td valign=\"top\">";
        $colname = trim($xml->thead->td[$nem]["name"]);
        $body .= $row[$colname];
        $body .= "</td>";
      } // ENDE FOR

      $body .= "</tr>\n";
      $num ++;
      $nam ++;
      if ( $num > $this->NumOfColors )
      {
        $num = 1;
      }

    } // ENDE FOREACH

    $body .= "</tbody>\n";

    // Erstellen des Foods falls vorhanden
    $Foot = "";
    if( $this->tableFoot )
    {

      $Foot .= "<tfoot>\n<tr>\n";
      for( $nem = 0 ; $nem < $anz ; $nem ++  )
      {
        $Foot .= "<td valign=\"top\">";
        $colname = trim($xml->thead->td[$nem]["name"]);
        $Foot .= $this->tableFoot[$colname];
        $Foot .= "</td>";
      } // ENDE FOR
      $Foot .= "</tr>\n</tfoot>\n";

    } // Ende If

    $this->html .= $head;
    $this->html .= $body;
    $this->html .= $Foot;
    $this->html .= "</table>\n";

    return $this->html;

  } // end of member function Parse

  /**
   *
   */
  public function buildWithArrayTemplate( $type = null )
  {

    $this->html = "\n<table id=\"table_".$this->name."\" class=\"Table".
      $xml["type"]."\" >\n";

    $head = "<thead>\n";
    $head .= "<tr>";
    foreach( $this->template as $hrow )
    {
      $head .= '<th width="'.$hrow['width'].'" title="'.$hrow['title'].'" '
        .' valign="top" >'.$hrow['content'].'</th>';
    }
    $head .= "</tr>\n";
    $head .= "</thead>\n";


    // Generieren des Bodys
    $body = "<tbody>\n";

    // Welcher Rowtyp soll ausgegeben werden
    $num = 1;

    // Is there a mapping oder for the cols
    if( $this->colOrder )
    {
      $anz = count( $this->colOrder );
      foreach( $this->data as $row   )
      {
        $rowid = $this->name.'_row_'.$nam;

        $body .= "<tr class=\"row$num\" id=\"$rowid\" >";

        for( $nam = 0 ; $nam <  $anz; ++$nam )
        {
          $body .= '<td valign="top">'.$row[$this->colOrder[$nam]]."</td>\n";
        } // ENDE FOR

        $body .= "</tr>\n";
        $num ++;
        if ( $num > $this->NumOfColors )
        {
          $num = 1;
        }

      } // ENDE FOREACH
    }
    else
    {// else take everthing like you get it
      foreach( $this->data as $row   )
      {
        $rowid = $this->name.'_row_'.$nam;

        $body .= "<tr class=\"row$num\" id=\"$rowid\" >";

        foreach( $row as $col )
        {
          $body .= '<td valign="top">'.$col."</td>\n";
        } // ENDE FOR

        $body .= "</tr>\n";
        $num ++;
        if ( $num > $this->NumOfColors )
        {
          $num = 1;
        }

      } // ENDE FOREACH
    }

    $body .= "</tbody>\n";

    $this->html .= $head;
    $this->html .= $body;
    $this->html .= "</table>\n";

    return $this->html;

  } // end of member function Parse

 /**
   * Generieren einer Tabelle ohne Template
   *
   * @param string $Class Der Datenbanktype
   * @return
   */
  public function buildNotemp( $Class = null )
  {

    if($this->data)
    {

      $this->html = "\n<table id=\"table_".$this->name."\" class=\"wgt-table\" >\n";

      $tabs = array_keys( $this->data[0] );

      $head = "<thead>\n";
      $head .= "<tr>";

      foreach( $tabs as $inhalt )
      {
        $head .= "<td>$inhalt</td>";
      }
      $head .= "</tr>\n";
      $head .= "</thead>\n";

      // Generieren des Bodys
      $body = "<tbody>\n";

      // Welcher Rowtyp soll ausgegeben werden
      $num = 1;
      $nam = 0;

      foreach( $this->data as $row   )
      {
        $rowid = $this->name."_row_${nam}";

        $body .= "<tr class=\"row$num\" id=\"$rowid\" >";

        foreach( $row as $Col )
        {
          $body .= "<td valign=\"top\" >".$Col."</td>\n";
        }// Ende Foreach

        $body .= "</tr>\n";
        $num ++;
        $nam ++;
        if ( $num > $NumOfColors )
        {
          $num = 1;
        }

      } // ENDE FOREACH

      $body .= "</tbody>\n";

      // Erstellen des Foods falls vorhanden
      $Foot = "";
      if( $this->tableFoot )
      {

        $Foot .= "<tfoot>\n<tr>\n";
        foreach( $this->tableFoot  as $Col )
        {
          $Foot .= '<td valign="top" >'.$Col."</td>\n";
        }// Ende Foreach
        $Foot .= "</tr>\n</tfoot>\n";

      } // Ende If


      $this->html .= $head;
      $this->html .= $body;
      $this->html .= $Foot;
      $this->html .= "</table>\n";
    }

    return $this->html;

  } // end of member function buildNotemp

} // end class WgtItemTable



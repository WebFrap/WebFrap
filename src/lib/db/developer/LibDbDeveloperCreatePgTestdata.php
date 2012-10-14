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
 * Klasse zum erstellen von generischen Tesdaten in einer PG Datenbank
 * 
 * @package WebFrap
 * @subpackage tech_core
 */
class LibDbDeveloperCreatePgTestdata
{
////////////////////////////////////////////////////////////////////////////////
// public Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Das Schema für die Testdaten
   * @var string
   */
  public $schema = null;

////////////////////////////////////////////////////////////////////////////////
// protected Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der aktuelle SQL String
   * @var string
   */
  protected $ddl = null;

  /**
   * Das Modell das zum erstellen der Testdaten verarbeitet wird
   * @var string
   */
  protected $metaModell = null;

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * Setter für das Schema
   * @param string $schema
   */
  public function setSchema( $schema )
  {
    $this->schema = $schema;
  }//end public function setSchema */

  /**
   * Getter für das Datenbank Schema
   * @return string
   */
  public function getSchema()
  {
    return $this->schema;
  }//end public function getSchema */

  /**
   * Die aktuelle Query abrufen
   * @return string
   */
  public function getDdl()
  {
    return $this->ddl;
  }//end public function getDdl */

  /**
   * Setter Metamodell
   *
   * @param string $metaModell
   */
  public function setMetaModell( $metaModell )
  {
    $this->metaModell = $metaModell;
  }//end public function setMetaModell */

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Erstellen des SQL Testdaten Dumps
   * 
   * @param string $metaModel
   */
  public function generateSqlScript( $metaModel = null )
  {

    if(!$metaModel)
    {
      $metaModel = $this->metaModell;
    }

    $xml = LibXml::load($metaModel);

    $this->ddl = 'SET SEARCH_PATH TO '.$this->schema.';'.NL;

    foreach( $xml->tables->table as $table )
    {

      $name = $table['name'];
      
      for( $i=1; $i<=100; $i++ )
      {
        $rowNames   = array();
        $rowValues  = array();

        foreach($table->row as $row)
        {
          $rowName = $row['name'];
          if($rowName == WBF_DB_KEY )
          {
            continue;
          }

          $rowNames[] = $rowName;
          $rowSize = $row['size'];
          $rowType = $row['type'];

          switch($rowType)
          {

            case 'int':
            {
              if( $rowName == 'm_role_create' )
              {
                $rowValues[] = ( $i % 10+1 );
              }
              elseif( $rowName == 'm_version' )
              {
                $rowValues[] = rand(0,10);
              }
              else
              {
                if( !strstr( $rowName, 'm_' ))
                {
                  $rowValues[] = $i;
                }
                else
                {
                  $rowValues[] = "null";
                }
              }
              break;
            }

            /*
            case 'numeric':
            {
              $rowValues[] = "${i}";
              break;
            }
            */

            case 'varchar':
            {
              $rowValues[] = "'".substr($rowName, 0, $rowSize - 5)."_".$i."'";
              break;
            }

            case 'char':
            {
              $rowValues[] =  "'".($i%2)."'";
              break;
            }

            case 'timestamp':
            {

              if( $rowName == 'm_deleted' )
              {
                // jedes 10te ist gelöscht
                $rowValues[] = ( $i % 10 ) ? 'null' : "'".date("Y-m-d h:i:s", mktime(0,0,0,1,1,2000))."'";
              }
              else if( !strstr($rowName, "m_" ))
              {
                $rowValues[] = "'".date("Y-m-d h:i:s", mktime(0,0,0,1,1,2000) + (3600 * 24 * 7 * $i))."'";
              }
              else
              {
                $rowValues[] = 'null';
              }
              break;
            }

            case 'date':
            {
              if(!strstr($rowName, "m_"))
              {
                $rowValues[] = "'".date("Y-m-d", mktime(0,0,0,1,1,2000) + (3600 * 24 * 7 * $i))."'";
              }
              else
              {
               $rowValues[] = 'null';
              }
              break;
            }

            case 'text':
            {
              $rowValues[] = "'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam'";
              break;
            }

            default:
            {
              $rowValues[] = 'null';
            }

          }//end switch
        }//end foreach

        $this->ddl .= "INSERT INTO ".$name." (".implode(",", $rowNames).") VALUES (".implode(",", $rowValues).");".NL;
      }
    }

  }//end public function generateSqlScript( $metaModel )

}//end class LibDbDeveloperCreatePgTestdata


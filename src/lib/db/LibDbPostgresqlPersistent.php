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
class LibDbPostgresqlPersistent
  extends LibDbPostgresql
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Holen der Daten als Assoziativer Array
   */
  const fetchAssoc      = PGSQL_ASSOC;

  /**
   * Holen der Daten als Numerischer Array
   */
  const fetchNum        = PGSQL_NUM;

  /**
   * Holen der Daten als Doppelter Assoziativer und Numerischer Array
   */
  const fetchBoth       = PGSQL_BOTH;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Erstellen einer Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return
   */
  protected function connect()
  {


    $pgsql_con_string = 'host='.$this->conf['dbhost']
      .' port='.$this->conf['dbport']
      .' dbname='.$this->conf['dbname']
      .' user='.$this->conf['dbuser']
      .' password='.$this->conf['dbpwd'];

    $this->dbUrl  = $this->conf['dbhost'];
    $this->dbPort = $this->conf['dbport'];
    $this->databaseName = $this->conf['dbname'];
    $this->dbUser = $this->conf['dbuser'];
    $this->dbPwd  = $this->conf['dbpwd'];
    
    
    if(DEBUG)
    {
      $pgsql_con_debug = 'host='.$this->conf['dbhost']
        .' port='.$this->conf['dbport']
        .' dbname='.$this->conf['dbname']
        .' user='.$this->conf['dbuser']
        .' password=******************';
      
      Debug::console( 'PG: Constring '.$pgsql_con_debug );
    }

    if(Log::$levelConfig)
      Log::config( 'DbVerbindungsparameter: '. $pgsql_con_string );

    if( !$this->connectionRead = pg_pconnect( $pgsql_con_string ))
    {

      throw new LibDb_Exception
      (
        'Konnte Die Datenbank Verbindung nicht herstellen :'.pg_last_error(),
        $pgsql_con_string
      );

    }

    $this->connectionWrite = $this->connectionRead;

    if( $this->schema  )
    {
      $this->setSearchPath( $this->schema );
    }
    else if( isset( $this->conf['dbschema'] ) )
    {
      $this->schema = $this->conf['dbschema'];
      $this->setSearchPath( $this->conf['dbschema'] );
    }
    else
    {
      $this->schema = 'public';
    }

  } // end protected function connect */

  /**
   * Schliesen der Datenbankverbindung
   *
   * @param res Sql Ein Select Object
   * @return

   */
  protected function dissconnect()
  {

    if( is_resource(  $this->connectionRead ) )
    {
      pg_close( $this->connectionRead );
    }

    if( is_resource(  $this->connectionWrite ) )
    {
      pg_close( $this->connectionWrite );
    }

  } // end protected function dissconnect()



} //end class LibDbPostgresqlPersistent


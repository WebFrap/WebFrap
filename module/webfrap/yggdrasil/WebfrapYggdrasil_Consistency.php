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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapYggdrasil_Consistency
  extends DataContainer
{
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function run(  )
  {

    $db      = $this->getDb();

    $conf    = Conf::get( 'db', 'connection' );
    $defCon  = $conf['default'];

    $revision = $db->select( 'select max(revision) as max_ref from wbfsys_module' )->getField('max_ref');

    $this->cleanModules( $db, $revision );
    $this->cleanEntities( $db, $revision );
    $this->cleanManagements( $db, $revision );
    $this->cleanWidgets( $db, $revision );
    $this->cleanProcess( $db, $revision );

  }//end public function run */

  /**
   * @param LibDbPostgresql $db
   * @param int $revision
   */
  public function cleanModules( $db, $revision )
  {

    $delDeprecated = <<<SQL
DELETE from wbfsys_module where revision is null or revision < {$revision};

SQL;

    $db->delete( $delDeprecated );

  }//end public function cleanModules */

   /**
   * @param LibDbPostgresql $db
   * @param int $revision
   */
  public function cleanEntities( $db, $revision )
  {

    $delDeprecatedEnt = <<<SQL
DELETE from wbfsys_entity where revision is null or revision < {$revision};

SQL;

    $db->delete( $delDeprecatedEnt );

    $delDeprecatedAttr = <<<SQL
DELETE from wbfsys_entity_attribute where revision is null or revision < {$revision};

SQL;

    $db->delete( $delDeprecatedAttr );

    $delDeprecatedRef = <<<SQL
DELETE from wbfsys_entity_reference where revision is null or revision < {$revision};

SQL;

    $db->delete( $delDeprecatedRef );

  }//end public function cleanEntities */

   /**
   * @param LibDbPostgresql $db
   * @param int $revision
   */
  public function cleanManagements( $db, $revision )
  {

    $delDeprecated = <<<SQL
DELETE from wbfsys_management where revision is null or revision < {$revision};

SQL;

    $db->delete( $delDeprecated );

  }//end public function cleanManagements */

   /**
   * @param LibDbPostgresql $db
   * @param int $revision
   */
  public function cleanWidgets( $db, $revision )
  {

    $delDeprecated = <<<SQL
DELETE from wbfsys_widget where revision is null or revision < {$revision};

SQL;

    $db->delete( $delDeprecated );

  }//end public function cleanWidgets */

   /**
   * @param LibDbPostgresql $db
   * @param int $revision
   */
  public function cleanProcess( $db, $revision )
  {

    // process
    $delProcess = <<<SQL
DELETE from wbfsys_process where revision is null or revision < {$revision};

SQL;

    $db->delete( $delProcess );

    // process node
    $delProcessNode = <<<SQL
DELETE from wbfsys_process_node where revision is null or revision < {$revision};

SQL;

    $db->delete( $delProcessNode );

    // process phase
    $delProcessPhase = <<<SQL
DELETE from wbfsys_process_phase where revision is null or revision < {$revision};

SQL;

    $db->delete( $delProcessPhase );

  }//end public function cleanWidgets */

}//end class WebfrapSetup_Container

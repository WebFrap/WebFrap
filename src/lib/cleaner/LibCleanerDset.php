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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class LibCleanerDset
{

  /**
   * Löschen aller möglicherweise vorhandenen vid links
   *
   * @param LibDbConnection $db
   * @param int $id
   */
  public function cleanDefault( $db, $id )
  {

    $sql = array();

    // bookmarks
    $sql[] = <<<SQL
DELETE FROM wbfsys_bookmark where vid = {$id};
SQL;

    // calendar refs
    $sql[] = <<<SQL
DELETE FROM wbfsys_calendar_vref where vid = {$id};
SQL;

    // comments
    $sql[] = <<<SQL
DELETE FROM wbfsys_comment where vid = {$id};
SQL;

    // faq
    $sql[] = <<<SQL
DELETE FROM wbfsys_faq where vid = {$id};
SQL;

    $sql[] = <<<SQL
DELETE FROM wbfsys_bookmark where vid = {$id};
SQL;

    $db->multiDelete( $sql );

  }//end public function cleanDefault */


} // end class LibCleanerDb


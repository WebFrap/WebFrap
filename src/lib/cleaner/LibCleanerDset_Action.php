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
 * @subpackage core/data/consistency
 */
class LibCleanerDset_Action extends Action
{

  /**
   * Löschen aller möglicherweise vorhandenen vid links
   *
   * @param LibDbConnection $db
   * @param int $id
   */
  public function cleanDefault($id)
  {

    $db = $this->getDb();

    if (is_object($id) && $id instanceof Entity)
      $id = $id->getId();

    if (!ctype_digit($id) || ! (int) $id > 0) {

      $devMsg = <<<ERRMSG
Tried to clean the Dataset resources with an empty ID.
That should not happen. You need to check if you got a valid ID before you
use it to clean reference datasets.
ERRMSG;

      throw new WebfrapSys_Exception
      (
        $devMsg,
        Error::INTERNAL_ERROR_MSG,
        Response::INTERNAL_ERROR,
        true,
        null,
        $id
      );
    }

    $sql = array();

    // bookmarks
    $sql[] = <<<SQL
DELETE FROM wbfsys_bookmark where vid = {$id};
SQL;

    //// Calendar
    // calendar refs
    $sql[] = <<<SQL
DELETE FROM wbfsys_calendar_vref where vid = {$id};
SQL;

    // Appointment mit dem Bezug auf diesen Datensatz
    /*
    $sql[] = <<<SQL
DELETE FROM wbfsys_appointment_vref where vid = {$id};
SQL;
    */

    //// TAGGING löschen

    // Tags auf einen Datensatz
    $sql[] = <<<SQL
DELETE FROM wbfsys_tag_reference where vid = {$id};
SQL;

    //// COMMENT daten löschen

    // comment ratings löschen
    $sql[] = <<<SQL
DELETE FROM wbfsys_comment_rating where id_comment IN(
  SELECT rowid from wbfsys_comment where vid =  {$id}
);
SQL;

    // comments
    $sql[] = <<<SQL
DELETE FROM wbfsys_comment where vid = {$id};
SQL;

    //// PROZESS bezogenen Daten löschen
    // Prozess history leeren
    $sql[] = <<<SQL
DELETE FROM wbfsys_process_step where id_process_instance IN(
  SELECT rowid from wbfsys_process_status where vid =  {$id}
);
SQL;

    // Prozess status leeren
    $sql[] = <<<SQL
DELETE FROM wbfsys_process_status where vid = {$id};
SQL;

    //// ACCESS / GROUP USERS
    // Group Users mit der VID löschen
    $sql[] = <<<SQL
DELETE FROM wbfsys_group_users where vid = {$id};
SQL;

    //// INDEX
    // links auf Datensätze löschen
    $sql[] = <<<SQL
DELETE FROM wbfsys_data_link where id_link = {$id};
SQL;
    // Datensätze aus dem Index Löschen
    $sql[] = <<<SQL
DELETE FROM wbfsys_data_index where vid = {$id};
SQL;

    $db->multiDelete($sql);

  }//end public function cleanDefault */

  /**
   * Calendar und alle darauf verweisenden Appointments usw löschen
   */
  public function cleanCalendar()
  {

  }//end public function cleanCalendar */

} // end class LibCleanerDb


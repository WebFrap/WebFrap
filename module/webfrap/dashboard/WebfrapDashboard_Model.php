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
class WebfrapDashboard_Model
  extends Model
{

  /**
   * Laden der Quicklinks für das aktuell geladenen profil
   * @return ArrayIterator
   */
  public function loadProfileQuickLinks()
  {

    $db = $this->getDb();
    $profileKey = $this->getUser()->getProfileName();

    $sql = <<<SQL
SELECT
  ql.rowid as id,
  ql.http_url as url,
  ql.label as label
FROM
  wbfsys_profile_quicklink ql
JOIN
  wbfsys_profile profile
    ON profile.rowid = ql.id_profile
WHERE
  UPPER(profile.access_key) = UPPER('{$profileKey}')
ORDER BY
  ql.label;

SQL;

    return $db->select($sql)->getAll();


  }//end public function loadProfileQuickLinks */


  /**
   * Laden der Quicklinks für das aktuell geladenen profil
   * @return ArrayIterator
   */
  public function loadLastVisited()
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL
SELECT
  ac.vid as vid,
  ac.label as label,
  mask.access_url as url,
  ac.m_time_created as visited
FROM
  wbfsys_protocol_access ac
JOIN
  wbfsys_mask mask
  ON mask.rowid = ac.id_mask
WHERE
  ac.m_role_create = {$user->getId()}
ORDER BY
  ac.m_time_created desc
LIMIT 10;

SQL;


    $tmp = $db->select($sql)->getAll();

    $data = array();
    foreach ($tmp as $entry) {
      $innerTmp = array();

      $date = DateTime::createFromFormat('Y-m-d H:i:s', $entry['visited']);

      $innerTmp['label']     = $entry['label'].' ('.$date->format('Y-m-d').') ';

      if( $entry['vid'] )
        $innerTmp['url']   = 'maintab.php?c='.$entry['url'].'&amp;objid='.$entry['vid'];
      else
        $innerTmp['url']   = 'maintab.php?c='.$entry['url'];

      $data[] = $innerTmp;
    }

    return $data;

  }//end public function loadLastVisited */

  /**
   * Laden der Quicklinks für das aktuell geladenen profil
   * @return ArrayIterator
   */
  public function loadMostVisited()
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL
SELECT
  ac.vid as vid,
  ac.label as label,
  mask.access_url as url,
  ac.counter as counter
FROM
  wbfsys_protocol_access ac
JOIN
  wbfsys_mask mask
  ON mask.rowid = ac.id_mask
WHERE
  ac.m_role_create = {$user->getId()}
ORDER BY
  ac.counter desc
LIMIT 10;

SQL;


    $tmp = $db->select($sql)->getAll();

    $data = array();
    foreach ($tmp as $entry) {
      $innerTmp = array();

      $innerTmp['label']     = $entry['label'].' ('.$entry['counter'].' times) ';

      if( $entry['vid'] )
        $innerTmp['url']   = 'maintab.php?c='.$entry['url'].'&amp;objid='.$entry['vid'];
      else
        $innerTmp['url']   = 'maintab.php?c='.$entry['url'];

      $data[] = $innerTmp;
    }

    return $data;

  }//end public function loadMostVisited */

  /**
   * Laden der Bookmarks
   * @return ArrayIterator
   */
  public function loadBookmarks()
  {

    $db = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL
SELECT
  title as label,
  url
FROM
  wbfsys_bookmark
WHERE
  id_role = {$user->getId()}
ORDER BY
  m_time_created desc

SQL;


    $tmp = $db->select($sql)->getAll();

    /*
    $data = array();
    foreach ($tmp as $entry) {
      $innerTmp = array();

      $innerTmp['label']     = $entry['label'].' ('.$entry['counter'].' times) ';

      if( $entry['vid'] )
        $innerTmp['url']   = 'maintab.php?c='.$entry['url'].'&amp;objid='.$entry['vid'];
      else
        $innerTmp['url']   = 'maintab.php?c='.$entry['url'];

      $data[] = $innerTmp;
    }
    */

    return $tmp;

  }//end public function loadMostVisited */


  /**
   * Laden der System Announcements
   * @return ArrayIterator
   */
  public function loadNews()
  {

    $db   = $this->getDb();
    $user = $this->getUser();

    $sql = <<<SQL
SELECT
  ann.rowid as rowid,
  ann.title,
  ann.message as content,
  ann.date_start,
  ann.id_type,
  ann.importance,
  ann.m_time_created as created,
  person.fullname as creator
FROM
  wbfsys_announcement ann
JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = ann.m_role_create
JOIN
    wbfsys_announcement_channel chan
        ON chan.rowid = ann.id_channel

WHERE
    UPPER(chan.access_key) = UPPER('wbf_global')

ORDER BY
  ann.m_time_created desc

limit 10;

SQL;

    return $db->select($sql)->getAll();

  }//end public function loadNews */

} // end class WebfrapDesktop_Model

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
 * @licence BSD
 */
class WebfrapContactItemType_Checklist_Query extends LibSqlQuery
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// Query Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Fetch method for the WbfsysAddressItemType Selectbox
   * @return void
   */
  public function fetch()
  {

    $db = $this->getDb();

    if (!$this->criteria)
      $criteria = $db->orm->newCriteria();
    else
      $criteria = $this->criteria;

    $criteria->select(array
    (
      'DISTINCT wbfsys_address_item_type.access_key as value',
      'wbfsys_address_item_type.name as label'
     ));
      $criteria->selectAlso('wbfsys_address_item_type.name as "wbfsys_address_item_type-m_order-order"');

    $criteria->from('wbfsys_address_item_type');
    $criteria->where('flag_msg_supported = true');
    $criteria->orderBy('wbfsys_address_item_type.name ');

    $this->result = $db->orm->select($criteria);

  }//end public function fetch */

  /**
   * Laden einer einzelnen Zeile,
   * Wird benötigt wenn der aktive Wert durch die Filter gerutscht ist.
   * Kann in archive Szenarien passieren.
   * In diesem Fall soll der Eintrag trotzdem noch angezeigt werden, daher
   * wird er explizit geladen
   *
   * @param int $entryId
   * @return void
   */
  public function fetchEntry($entryId)
  {

    // wenn keine korrekte id > 0 übergeben wurde müssen wir gar nicht erst
    // nach einträgen suchen
    if (!$entryId)
      return array();

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select(array
    (
      'DISTINCT wbfsys_address_item_type.access_key as value',
      'wbfsys_address_item_type.name as label'
     ));
    $criteria->from('wbfsys_address_item_type');

    $criteria->where("wbfsys_address_item_type.access_key = '{$entryId}'"  );

    return $db->orm->select($criteria)->get();

  }//end public function fetchEntry */

  /**
   * Laden einer definierten Liste von Werten
   * Wird benötigt wenn die Selectbox mit der option multi
   * verwendet wird und einige der aktiven Werte durch die Filter gerutscht sind.
   * siehe auch self::fetchSelectboxEntry
   *
   * @param int $entryId
   * @return void
   */
  public function fetchEntries($entryIds)
  {

    // wenn der array leer ist müssen wir nicht weiter prüfen
    if (!$entryIds)
      return array();

    $db = $this->getDb();

    $criteria = $db->orm->newCriteria();

    $criteria->select(array
    (
      'DISTINCT wbfsys_address_item_type.access_key as value',
      'wbfsys_address_item_type.name as label'
     ));

    $criteria->from('wbfsys_address_item_type');
    $criteria->where('flag_msg_supported = true');
    $criteria->orderBy('wbfsys_address_item_type.name ');

    $criteria->where("wbfsys_address_item_type.access_key IN ('".implode("', '", $entryIds)."')"  );

    return $db->orm->select($criteria)->getAll();

  }//end public function fetchEntries */

}//end class WebfrapContactItemType_Checklist_Query


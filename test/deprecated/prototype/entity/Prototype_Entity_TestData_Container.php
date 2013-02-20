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
 * @package WebFrapUnit
 * @subpackage WebFrap
 */
class Prototype_Entity_TestData_Container extends LibTestDataContainer
{
/*//////////////////////////////////////////////////////////////////////////////
// access checks
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Befüllen der Datenbank mit Testdaten
   */
  public function populateDatabase()
  {

    $orm = $this->db->getOrm();

    // erste mal den Cache leeren um sicher zu stellen, dass keine unerwarteten
    // Daten in die Datenbank kommen
    $orm->clearCache();

    // Leeren der Ziel Tabelle. Ist nötig da gleich ein Datenpaket importiert
    // wird und der Test abweichungen davon als Fehler deklarieren würde
    $orm->cleanResource( 'WbfsysRoleGroup' );

    // nach dem löschen vorsichtshalber nochmal den cache leeren
    $orm->clearCache();

    // Reference Container zum befüllen der Referenz Datensätze
    $refContainers = array();

    if ( Webfrap::classLoadable( 'WbfsysRoleGroupType_TestData_Container' ) ) {
      $refContainers['wbfsys_role_group_type'] = new WbfsysRoleGroupType_TestData_Container();
    } else {
      $refContainers['wbfsys_role_group_type'] = new LibTestData_Fallback_Container();
    }

    foreach ($refContainers as $container) {
      $refContainers->populateAsReference();
    }

    // global
    $orm->import
    (
      'WbfsysRoleGroup',
      array
      (
        array
        (
          'name'         => 'name_1',
          'access_key'   => 'access_key_1',
          'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisici elit,
sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit
esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt
mollit anim id est laborum.'
        ),
      )
    );

  }//end protected function populateDatabase */

  /**
   *
   */
  public function populateAsReference()
  {

    $orm = $this->db->getOrm();

    // Reference Container zum befüllen der Referenz Datensätze
    $refContainers = array();

    // Sicher stelle, das keine unerwarteten Daten in der Tabelle sind
    $orm->cleanResource( 'WbfsysRoleGroup' );

    // Leeren des Caches
    $orm->clearCache();

    // global
    $orm->import
    (
      'WbfsysRoleGroup',
      array
      (
        array
        (
          'name'         => 'name_1',
          'access_key'   => 'access_key_1',
          'description'   => 'Lorem ipsum dolor sit amet, consectetur adipisici elit,
sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit
esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt
mollit anim id est laborum.'
        ),
      )
    );

  }//end protected function populateAsReference */

} //end class Prototype_Entity_Test


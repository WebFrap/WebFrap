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
class WbfsysRoleUser_Table_TestData_Container extends LibTestDataContainer
{
  /**
   * Befüllen der Datenbank mit Testdaten
   */
  public function load()
  {

    // importieren der daten
    $this->data = array
    (
        array
        (

          'wbfsys_role_user_name' => 'name_1', // ft: text
          'wbfsys_role_user_id_person' =>  '2', // changed
          'core_person_lastname' => 'id_person_1', // ft: Text
          'wbfsys_role_user_id_employee' =>  '3', // changed
          'enterprise_employee_empl_number' => 'id_employee_1', // ft: Text
          'wbfsys_role_user_rowid' => 1, // ft: guess
          'embed_person_lastname' => 'lastname_1', // ft: text
          'embed_person_firstname' => 'firstname_1', // ft: text
          'wbfsys_profile_name' => 'name_1', // ft: text
          'wbfsys_role_user_profile' =>  '8', // changed
          'wbfsys_profile_name' => 'profile_1', // ft: Text
          'wbfsys_role_user_m_time_created' => LibTestDataContainer::getActualDate(1), // ft: date
          'wbfsys_role_user_inactive' => true, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => null, // ft: text
          'wbfsys_role_user_id_person' =>  '4', // changed
          'core_person_lastname' => null, // ft: Text
          'wbfsys_role_user_id_employee' =>  '6', // changed
          'enterprise_employee_empl_number' => null, // ft: Text
          'wbfsys_role_user_rowid' => 2, // ft: guess
          'embed_person_lastname' => null, // ft: text
          'embed_person_firstname' => null, // ft: text
          'wbfsys_profile_name' => null, // ft: text
          'wbfsys_role_user_profile' =>  '16', // changed
          'wbfsys_profile_name' => null, // ft: Text
          'wbfsys_role_user_m_time_created' => null, // ft: date
          'wbfsys_role_user_inactive' => null, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => 'name_3', // ft: text
          'wbfsys_role_user_id_person' =>  '6', // changed
          'core_person_lastname' => 'id_person_3', // ft: Text
          'wbfsys_role_user_id_employee' =>  '9', // changed
          'enterprise_employee_empl_number' => 'id_employee_3', // ft: Text
          'wbfsys_role_user_rowid' => 3, // ft: guess
          'embed_person_lastname' => 'lastname_3', // ft: text
          'embed_person_firstname' => 'firstname_3', // ft: text
          'wbfsys_profile_name' => 'name_3', // ft: text
          'wbfsys_role_user_profile' =>  '24', // changed
          'wbfsys_profile_name' => 'profile_3', // ft: Text
          'wbfsys_role_user_m_time_created' => LibTestDataContainer::getActualDate(3), // ft: date
          'wbfsys_role_user_inactive' => true, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => null, // ft: text
          'wbfsys_role_user_id_person' =>  '8', // changed
          'core_person_lastname' => null, // ft: Text
          'wbfsys_role_user_id_employee' =>  '12', // changed
          'enterprise_employee_empl_number' => null, // ft: Text
          'wbfsys_role_user_rowid' => 4, // ft: guess
          'embed_person_lastname' => null, // ft: text
          'embed_person_firstname' => null, // ft: text
          'wbfsys_profile_name' => null, // ft: text
          'wbfsys_role_user_profile' =>  '32', // changed
          'wbfsys_profile_name' => null, // ft: Text
          'wbfsys_role_user_m_time_created' => null, // ft: date
          'wbfsys_role_user_inactive' => null, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => 'name_5', // ft: text
          'wbfsys_role_user_id_person' =>  '10', // changed
          'core_person_lastname' => 'id_person_5', // ft: Text
          'wbfsys_role_user_id_employee' =>  '15', // changed
          'enterprise_employee_empl_number' => 'id_employee_5', // ft: Text
          'wbfsys_role_user_rowid' => 5, // ft: guess
          'embed_person_lastname' => 'lastname_5', // ft: text
          'embed_person_firstname' => 'firstname_5', // ft: text
          'wbfsys_profile_name' => 'name_5', // ft: text
          'wbfsys_role_user_profile' =>  '40', // changed
          'wbfsys_profile_name' => 'profile_5', // ft: Text
          'wbfsys_role_user_m_time_created' => LibTestDataContainer::getActualDate(5), // ft: date
          'wbfsys_role_user_inactive' => true, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => null, // ft: text
          'wbfsys_role_user_id_person' =>  '12', // changed
          'core_person_lastname' => null, // ft: Text
          'wbfsys_role_user_id_employee' =>  '18', // changed
          'enterprise_employee_empl_number' => null, // ft: Text
          'wbfsys_role_user_rowid' => 6, // ft: guess
          'embed_person_lastname' => null, // ft: text
          'embed_person_firstname' => null, // ft: text
          'wbfsys_profile_name' => null, // ft: text
          'wbfsys_role_user_profile' =>  '48', // changed
          'wbfsys_profile_name' => null, // ft: Text
          'wbfsys_role_user_m_time_created' => null, // ft: date
          'wbfsys_role_user_inactive' => null, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => 'name_7', // ft: text
          'wbfsys_role_user_id_person' =>  '14', // changed
          'core_person_lastname' => 'id_person_7', // ft: Text
          'wbfsys_role_user_id_employee' =>  '21', // changed
          'enterprise_employee_empl_number' => 'id_employee_7', // ft: Text
          'wbfsys_role_user_rowid' => 7, // ft: guess
          'embed_person_lastname' => 'lastname_7', // ft: text
          'embed_person_firstname' => 'firstname_7', // ft: text
          'wbfsys_profile_name' => 'name_7', // ft: text
          'wbfsys_role_user_profile' =>  '56', // changed
          'wbfsys_profile_name' => 'profile_7', // ft: Text
          'wbfsys_role_user_m_time_created' => LibTestDataContainer::getActualDate(7), // ft: date
          'wbfsys_role_user_inactive' => true, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => null, // ft: text
          'wbfsys_role_user_id_person' =>  '16', // changed
          'core_person_lastname' => null, // ft: Text
          'wbfsys_role_user_id_employee' =>  '24', // changed
          'enterprise_employee_empl_number' => null, // ft: Text
          'wbfsys_role_user_rowid' => 8, // ft: guess
          'embed_person_lastname' => null, // ft: text
          'embed_person_firstname' => null, // ft: text
          'wbfsys_profile_name' => null, // ft: text
          'wbfsys_role_user_profile' =>  '64', // changed
          'wbfsys_profile_name' => null, // ft: Text
          'wbfsys_role_user_m_time_created' => null, // ft: date
          'wbfsys_role_user_inactive' => null, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => 'name_9', // ft: text
          'wbfsys_role_user_id_person' =>  '18', // changed
          'core_person_lastname' => 'id_person_9', // ft: Text
          'wbfsys_role_user_id_employee' =>  '27', // changed
          'enterprise_employee_empl_number' => 'id_employee_9', // ft: Text
          'wbfsys_role_user_rowid' => 9, // ft: guess
          'embed_person_lastname' => 'lastname_9', // ft: text
          'embed_person_firstname' => 'firstname_9', // ft: text
          'wbfsys_profile_name' => 'name_9', // ft: text
          'wbfsys_role_user_profile' =>  '72', // changed
          'wbfsys_profile_name' => 'profile_9', // ft: Text
          'wbfsys_role_user_m_time_created' => LibTestDataContainer::getActualDate(9), // ft: date
          'wbfsys_role_user_inactive' => true, // ft: checkbox
        ),

        array
        (

          'wbfsys_role_user_name' => null, // ft: text
          'wbfsys_role_user_id_person' =>  '20', // changed
          'core_person_lastname' => null, // ft: Text
          'wbfsys_role_user_id_employee' =>  '30', // changed
          'enterprise_employee_empl_number' => null, // ft: Text
          'wbfsys_role_user_rowid' => 10, // ft: guess
          'embed_person_lastname' => null, // ft: text
          'embed_person_firstname' => null, // ft: text
          'wbfsys_profile_name' => null, // ft: text
          'wbfsys_role_user_profile' =>  '80', // changed
          'wbfsys_profile_name' => null, // ft: Text
          'wbfsys_role_user_m_time_created' => null, // ft: date
          'wbfsys_role_user_inactive' => null, // ft: checkbox
        ),

    );

  }//end protected function load */

}//end class WbfsysRoleUser_Table_TestData_Container */

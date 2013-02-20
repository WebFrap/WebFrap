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
 *
 * @package WebFrap
 * @subpackage tech_core
 *
 * @author Dominik Bonsch
 *
 */
class EntityTestTable extends Entity
{

  public static $table = 'test_table';

  public static $tablePk = 'rowid';

  /*
  rowid int  DEFAULT nextval('webfrap_0_3_test.test_table_rowid_seq') ,
  id_people int ,
  id_company int ,
  date_from date ,
  date_till date ,
  def_hourly_rate numeric(30,6) ,
  empl_number varchar(25) ,
  room_number varchar(50) ,
  m_created timestamp ,
  m_creator int ,
  m_deleted timestamp ,
  m_destroyer int ,
  m_version int ,
  m_inactiv char(1) ,
  */

}//end class EntityTestTable


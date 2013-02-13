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
 * @subpackage tech_coreTest
 *
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *
 */
class EntityTest
  extends Entity
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * the name of the sql table for the entity
  * @var string $table
  */
  public static $table = 'core_people';

 /**
  * the name of primary key field in the sql table
  * mostly will be rowid
  * @var string $tablePk
  */
  public static $tablePk = WBF_DB_KEY;

 /**
  * the default url to show an entry of this dataset
  * @var string $tablePk
  */
  public static $toUrl = 'index.php?c=Core.People.show';

 /**
  * all keynames for fields that will be displayed in the textvalue of the entity
  * @var array $textKeys
  */
  public static $textKeys = array();

 /**
  * the name of the entity in the System
  * @var string $entityName
  */
  public static $entityName = 'CorePeople';

 /**
  *
  * @var array
  */
  public static $cols = array
  (
    WBF_DB_KEY => array( WBF_DB_KEY,  false,  null,  null,false, false ),
    'gender' => array( 'boolean',  false,  null,  null,true, false ),
    'title' => array( 'text',  false,  null,  null,true, false ),
    'firstname' => array( 'text',  false,  null,  null,true, false ),
    'lastname' => array( 'text',  false,  null,  null,true, false ),
    'birthday' => array( 'date',  false,  null,  null,true, false ),
    'id_preflang' => array( 'int',  false,  null,  null,false, false ),
    'birth_city' => array( 'text',  false,  null,  null,true, false ),
    'email' => array( 'text',  false,  null,  null,true, false ),
    'phone1' => array( 'text',  false,  null,  null,true, false ),
    'phone2' => array( 'text',  false,  null,  null,true, false ),
    'email1' => array( 'text',  false,  null,  null,true, false ),
    'email2' => array( 'text',  false,  null,  null,true, false ),
    'mobile1' => array( 'text',  false,  null,  null,true, false ),
    'mobile2' => array( 'text',  false,  null,  null,true, false ),
    'street' => array( 'text',  false,  null,  null,true, false ),
    'postalcode' => array( 'text',  false,  null,  null,true, false ),
    'city' => array( 'text',  false,  null,  null,true, false ),
    'id_country' => array( 'int',  false,  null,  null,false, false ),
    'id_nationality' => array( 'int',  false,  null,  null,false, false ),
    'tax_number' => array( 'text',  false,  null,  null,true, false ),
    'icq' => array( 'text',  false,  null,  null,true, false ),
    'xmpp' => array( 'text',  false,  null,  null,true, false ),
    'skype' => array( 'text',  false,  null,  null,true, false ),
    'msn' => array( 'text',  false,  null,  null,true, false ),
    'sip' => array( 'text',  false,  null,  null,true, false ),
    'm_created' => array( 'timestamp',  false,  null,  null,true, false ),
    'm_creator' => array( WBF_DB_KEY,  false,  null,  null,false, false ),
    'm_deleted' => array( 'timestamp',  false,  null,  null,true, false ),
    'm_destroyer' => array( WBF_DB_KEY,  false,  null,  null,false, false ),
    'm_version' => array( WBF_DB_KEY,  false,  null,  null,false, false ),
    'm_system' => array( 'boolean',  false,  null,  null,true, false ),
  );

  public static $references = array
  (
  );

 /**
  *
  * @var array
  */
  public static $messages = array
  (

  WBF_DB_KEY => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgRowid',
  'wrong' => 'core.people.msg.EntityWrongMsgRowid',
  'max' => 'core.people.msg.EntityMaxMsgRowid',
  'min' => 'core.people.msg.EntityMinMsgRowid',
  ),

  'gender' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgGender',
  'wrong' => 'core.people.msg.EntityWrongMsgGender',
  'max' => 'core.people.msg.EntityMaxMsgGender',
  'min' => 'core.people.msg.EntityMinMsgGender',
  ),

  'title' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgTitle',
  'wrong' => 'core.people.msg.EntityWrongMsgTitle',
  'max' => 'core.people.msg.EntityMaxMsgTitle',
  'min' => 'core.people.msg.EntityMinMsgTitle',
  ),

  'firstname' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgFirstname',
  'wrong' => 'core.people.msg.EntityWrongMsgFirstname',
  'max' => 'core.people.msg.EntityMaxMsgFirstname',
  'min' => 'core.people.msg.EntityMinMsgFirstname',
  ),

  'lastname' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgLastname',
  'wrong' => 'core.people.msg.EntityWrongMsgLastname',
  'max' => 'core.people.msg.EntityMaxMsgLastname',
  'min' => 'core.people.msg.EntityMinMsgLastname',
  ),

  'birthday' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgBirthday',
  'wrong' => 'core.people.msg.EntityWrongMsgBirthday',
  'max' => 'core.people.msg.EntityMaxMsgBirthday',
  'min' => 'core.people.msg.EntityMinMsgBirthday',
  ),

  'id_preflang' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgIdPreflang',
  'wrong' => 'core.people.msg.EntityWrongMsgIdPreflang',
  'max' => 'core.people.msg.EntityMaxMsgIdPreflang',
  'min' => 'core.people.msg.EntityMinMsgIdPreflang',
  ),

  'birth_city' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgBirthCity',
  'wrong' => 'core.people.msg.EntityWrongMsgBirthCity',
  'max' => 'core.people.msg.EntityMaxMsgBirthCity',
  'min' => 'core.people.msg.EntityMinMsgBirthCity',
  ),

  'email' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgEmail',
  'wrong' => 'core.people.msg.EntityWrongMsgEmail',
  'max' => 'core.people.msg.EntityMaxMsgEmail',
  'min' => 'core.people.msg.EntityMinMsgEmail',
  ),

  'phone1' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgPhone1',
  'wrong' => 'core.people.msg.EntityWrongMsgPhone1',
  'max' => 'core.people.msg.EntityMaxMsgPhone1',
  'min' => 'core.people.msg.EntityMinMsgPhone1',
  ),

  'phone2' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgPhone2',
  'wrong' => 'core.people.msg.EntityWrongMsgPhone2',
  'max' => 'core.people.msg.EntityMaxMsgPhone2',
  'min' => 'core.people.msg.EntityMinMsgPhone2',
  ),

  'email1' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgEmail1',
  'wrong' => 'core.people.msg.EntityWrongMsgEmail1',
  'max' => 'core.people.msg.EntityMaxMsgEmail1',
  'min' => 'core.people.msg.EntityMinMsgEmail1',
  ),

  'email2' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgEmail2',
  'wrong' => 'core.people.msg.EntityWrongMsgEmail2',
  'max' => 'core.people.msg.EntityMaxMsgEmail2',
  'min' => 'core.people.msg.EntityMinMsgEmail2',
  ),

  'mobile1' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgMobile1',
  'wrong' => 'core.people.msg.EntityWrongMsgMobile1',
  'max' => 'core.people.msg.EntityMaxMsgMobile1',
  'min' => 'core.people.msg.EntityMinMsgMobile1',
  ),

  'mobile2' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgMobile2',
  'wrong' => 'core.people.msg.EntityWrongMsgMobile2',
  'max' => 'core.people.msg.EntityMaxMsgMobile2',
  'min' => 'core.people.msg.EntityMinMsgMobile2',
  ),

  'street' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgStreet',
  'wrong' => 'core.people.msg.EntityWrongMsgStreet',
  'max' => 'core.people.msg.EntityMaxMsgStreet',
  'min' => 'core.people.msg.EntityMinMsgStreet',
  ),

  'postalcode' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgPostalcode',
  'wrong' => 'core.people.msg.EntityWrongMsgPostalcode',
  'max' => 'core.people.msg.EntityMaxMsgPostalcode',
  'min' => 'core.people.msg.EntityMinMsgPostalcode',
  ),

  'city' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgCity',
  'wrong' => 'core.people.msg.EntityWrongMsgCity',
  'max' => 'core.people.msg.EntityMaxMsgCity',
  'min' => 'core.people.msg.EntityMinMsgCity',
  ),

  'id_country' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgIdCountry',
  'wrong' => 'core.people.msg.EntityWrongMsgIdCountry',
  'max' => 'core.people.msg.EntityMaxMsgIdCountry',
  'min' => 'core.people.msg.EntityMinMsgIdCountry',
  ),

  'id_nationality' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgIdNationality',
  'wrong' => 'core.people.msg.EntityWrongMsgIdNationality',
  'max' => 'core.people.msg.EntityMaxMsgIdNationality',
  'min' => 'core.people.msg.EntityMinMsgIdNationality',
  ),

  'tax_number' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgTaxNumber',
  'wrong' => 'core.people.msg.EntityWrongMsgTaxNumber',
  'max' => 'core.people.msg.EntityMaxMsgTaxNumber',
  'min' => 'core.people.msg.EntityMinMsgTaxNumber',
  ),

  'icq' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgIcq',
  'wrong' => 'core.people.msg.EntityWrongMsgIcq',
  'max' => 'core.people.msg.EntityMaxMsgIcq',
  'min' => 'core.people.msg.EntityMinMsgIcq',
  ),

  'xmpp' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgXmpp',
  'wrong' => 'core.people.msg.EntityWrongMsgXmpp',
  'max' => 'core.people.msg.EntityMaxMsgXmpp',
  'min' => 'core.people.msg.EntityMinMsgXmpp',
  ),

  'skype' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgSkype',
  'wrong' => 'core.people.msg.EntityWrongMsgSkype',
  'max' => 'core.people.msg.EntityMaxMsgSkype',
  'min' => 'core.people.msg.EntityMinMsgSkype',
  ),

  'msn' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgMsn',
  'wrong' => 'core.people.msg.EntityWrongMsgMsn',
  'max' => 'core.people.msg.EntityMaxMsgMsn',
  'min' => 'core.people.msg.EntityMinMsgMsn',
  ),

  'sip' => array
  (
  'default' => 'core.people.msg.EntityDefaulMsgSip',
  'wrong' => 'core.people.msg.EntityWrongMsgSip',
  'max' => 'core.people.msg.EntityMaxMsgSip',
  'min' => 'core.people.msg.EntityMinMsgSip',
  ),
  );



}//end class EntityTestTable


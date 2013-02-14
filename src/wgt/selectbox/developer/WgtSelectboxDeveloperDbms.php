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
 * @subpackage ModExample
 */
class WgtSelectboxDeveloperDbms extends WgtSelectboxHardcoded
{


  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $size = '4';

  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  protected $multiple = true;



  /**
   *
   */
  protected $data = array
  (
    'Db2'         =>  array( 'value' => 'DB2' ),
    'Firebird'    =>  array( 'value' => 'Firebird' ),
    'Informix'    =>  array( 'value' => 'Informix' ),
    'Ingres'      =>  array( 'value' => 'Ingres' ),
    'Maxdb'       =>  array( 'value' => 'MaxDB' ),
    'Mysql'       =>  array( 'value' => 'Mysql' ),
    'Mssql'       =>  array( 'value' => 'Mssql' ),
    'Oracle'      =>  array( 'value' => 'Oracle' ),
    'Postgresql'  =>  array( 'value' => 'Postgresql' ),
    'Sybase'      =>  array( 'value' => 'Sybase' ),
  );


} // end class WgtSelectboxDeveloperDbms



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
 * @subpackage tech_core
 */
class LibDbPdoMysqlResult
  extends LibDbPdoResult
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Holen der Daten als Assoziativer Array
   */
  const fetchAssoc  = PDO::FETCH_ASSOC;

  /**
   * Holen der Daten als Numerischer Array
   */
  const fetchNum    = PDO::FETCH_NUM;

  /**
   * Holen der Daten als Doppelter Assoziativer und Numerischer Array
   */
  const fetchBoth   = PDO::FETCH_BOTH;


/*//////////////////////////////////////////////////////////////////////////////
// Special Queries
//////////////////////////////////////////////////////////////////////////////*/



} //end class LibDbPdoMysqlResult


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
 * @lang de:
 * Exception welche geworfen wird wenn technische Probleme beim zugriff auf 
 * die ACL Datenquellen auftreten.
 * Diese Exception wird nicht geworfen wenn eine Person nur keinen Zugriff hat,
 * dieser Fall soll über Rückgaben der aufgerufenen Methoden abgehandelt werden!
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibAcl_Exception extends Lib_Exception
{
}




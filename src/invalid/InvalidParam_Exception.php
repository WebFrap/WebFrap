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
 * Eine Komponente hat Parameter bekommen mit der sie nichts anfangen kann
 * Das hätte vorher abgefangen werden müssen
 * 
 * Daher ganz klar ein Programmierfehler
 * 
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class InvalidParam_Exception extends WebfrapSys_Exception
{
}




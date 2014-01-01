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
 *
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *
 * @property $objid
 *
 */
class ContextDset extends Context
{


  /**
   * Interpret the Userinput Flags
   *
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {

    $this->request = $request;

    $this->objid = $this->getOID();

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $this->aclRoot = $aclRoot;

    // die maske des root startpunktes
    if ($maskRoot = $request->param('m_root', Validator::TEXT))
      $this->maskRoot = $maskRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $this->aclRootId = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $this->aclKey = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $this->aclLevel = $aclLevel;

    // der neue knoten
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $this->aclNode = $aclNode;

    $this->interpretCustom($request);

  }//end public function interpretRequest */

} // end class ContextDset


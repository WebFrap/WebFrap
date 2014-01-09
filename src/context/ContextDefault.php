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
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *            
 */
class ContextDefault extends Context
{

    /**
     * Interpret the Userinput Flags
     *
     * @param LibRequestHttp $request            
     */
    public function interpretRequest($request)
    {
        
        // if of the target element, can be a table, a tree or whatever
        if ($targetId = $request->param('target_id', Validator::CKEY))
            $this->targetId = $targetId;
            
            // callback for a target function in thr browser
        if ($target = $request->param('target', Validator::CNAME))
            $this->target = $target;
            
            // id of the target window
        if ($viewId = $request->param('view_id', Validator::CKEY))
            $this->viewId = $viewId;
            
            // startpunkt des pfades für die acls
        if ($aclRoot = $request->param('a_root', Validator::CKEY))
            $this->aclRoot = $aclRoot;
            
            // die root maske
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
            
            // der neue knoten
        if ($dkey = $request->param('dkey', Validator::CKEY))
            $this->dkey = $dkey;
        
        if ($parentMask = $request->param('pmsk', Validator::TEXT))
            $this->parentMask = $parentMask;
            
            // per default
        $this->categories = array();
    } // end public function interpretRequest */
    
} // end class ContextDefault


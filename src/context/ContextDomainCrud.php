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
 * @author dominik bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *            
 */
class ContextDomainCrud extends Context
{

    /**
     * Interpret the Userinput Flags
     *
     * @param LibRequestHttp $request            
     */
    public function interpretRequest($request)
    {
        
        // startpunkt des pfades für die acls
        if ($aclRoot = $request->param('a_root', Validator::CKEY))
            $this->aclRoot = $aclRoot;
            
            // die id des Datensatzes von dem aus der Pfad gestartet wurde
        if ($aclRootId = $request->param('a_root_id', Validator::INT))
            $this->aclRootId = $aclRootId;
            
            // der key des knotens auf dem wir uns im pfad gerade befinden
        if ($aclKey = $request->param('a_key', Validator::CKEY))
            $this->aclKey = $aclKey;
            
            // der name des knotens
        if ($aclNode = $request->param('a_node', Validator::CKEY))
            $this->aclNode = $aclNode;
            
            // an welchem punkt des pfades befinden wir uns?
        if ($aclLevel = $request->param('a_level', Validator::INT))
            $this->aclLevel = $aclLevel;
            
            // listing type
        if ($ltype = $request->param('ltype', Validator::CNAME))
            $this->ltype = $ltype;
            
            // Der Domainkey
        if ($dkey = $request->param('dkey', Validator::CKEY))
            $this->dKey = $dkey;
            
            // ??? deprecated ???
        if ($context = $request->param('context', Validator::CNAME))
            $this->context = $context;
            
            // if of the target element, can be a table, a tree or whatever
        if ($targetId = $request->param('target_id', Validator::CKEY))
            $this->targetId = $targetId;
            
            // callback for a target function in thr browser
        if ($target = $request->param('target', Validator::CNAME))
            $this->target = $target;
            
            // key der maske
        if ($mask = $request->param('mask', Validator::CNAME))
            $this->mask = $mask;
        
        if ($parentMask = $request->param('pmsk', Validator::TEXT))
            $this->parentMask = $parentMask;
            
            // mask key
        if ($viewId = $request->param('view_id', Validator::CKEY))
            $this->viewId = $viewId;
            
            // refid
        if ($refid = $request->param('refid', Validator::INT))
            $this->refId = $refid;
            
            // per default
        $this->categories = array();
    } // end public function interpretRequest */
} // end class ContextDomainCrud


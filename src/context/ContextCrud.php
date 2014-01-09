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
 * @property $aclRoot
 * @property $aclRootId
 * @property $aclKey
 * @property $aclNode
 * @property $aclLevel
 *          
 * @property string $subTab Key zum öffnen eines Subtabs
 *          
 */
class ContextCrud extends Context
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
            
            // der neue knoten
        if ($aclNode = $request->param('a_node', Validator::CKEY))
            $this->aclNode = $aclNode;
            
            // an welchem punkt des pfades befinden wir uns?
        if ($aclLevel = $request->param('a_level', Validator::INT))
            $this->aclLevel = $aclLevel;
            
            // request elemet type, bei back to top ist es relevant zu wissen woher der
            // aufruf kam (in diesem fall von einem input)
            // könnte bei referenzen auch interessant werden
            // values: inp | ref
        if ($requestedBy = $request->param('rqtby', Validator::TEXT))
            $this->requestedBy = $requestedBy;
            
            // sprungpunkt für back to top
        if ($maskRoot = $request->param('m_root', Validator::TEXT))
            $this->maskRoot = $maskRoot;
        
        if ($parentMask = $request->param('pmsk', Validator::TEXT))
            $this->parentMask = $parentMask;
            
            // the publish type, like selectbox, tree, table..
        if ($publish = $request->param('publish', Validator::CNAME))
            $this->publish = $publish;
            
            // if of the target element, can be a table, a tree or whatever
        if ($targetId = $request->param('target_id', Validator::CKEY))
            $this->targetId = $targetId;
            
            // callback for a target function in thr browser
        if ($target = $request->param('target', Validator::CKEY))
            $this->target = $target;
            
            // target mask key
        if ($targetMask = $request->param('target_mask', Validator::CNAME))
            $this->targetMask = $targetMask;
            
            // target mask
        if ($mask = $request->param('mask', Validator::CNAME))
            $this->mask = $mask;
            
            // mask key
        if ($viewId = $request->param('view_id', Validator::CKEY))
            $this->viewId = $viewId;
            
            // mask key
        if ($viewType = $request->param('view', Validator::CNAME))
            $this->viewType = $viewType;
            
            // soll die maske neu geladen werden?
        if ($reload = $request->param('reload', Validator::BOOLEAN))
            $this->reload = $reload;
            
            // target mask key
        if ($refId = $request->param('refid', Validator::INT))
            $this->refId = $refId;
            
            // listing type
        if ($ltype = $request->param('ltype', Validator::CNAME))
            $this->ltype = $ltype;
            
            // context
        if ($context = $request->param('context', Validator::CNAME))
            $this->context = $context;
            
            // parameter zum fixieren des Contexts
            // wird verwendet um zwischen "unterschiedliche" Masken mit dem gleichen
            // viewnamen zu switchen
        if ($cntk = $request->param('cntk', Validator::CKEY))
            $this->contextKey = $cntk;
            
            // mask switcher key
            // wird nur in der view gesetzt wenn der mask switcher vorhanden ist
        if ($cntms = $request->param('cntms', Validator::CNAME))
            $this->contextMaskSwt = $cntms;
            
            // setzen des tabs welchen man aktiv setzen möchte
        if ($sbt = $request->param('sbt', Validator::CNAME))
            $this->subTab = $sbt;
            
            // per default
        $this->categories = array();
    } // end public function interpretRequest */
    
    /**
     *
     * @return string
     */
    public function toUrlExt()
    {
        if ($this->urlExt)
            return $this->urlExt;
        
        if ($this->aclRoot)
            $this->urlExt .= '&amp;a_root='.$this->aclRoot;
        
        if ($this->aclRootId)
            $this->urlExt .= '&amp;a_root_id='.$this->aclRootId;
        
        if ($this->aclKey)
            $this->urlExt .= '&amp;a_key='.$this->aclKey;
        
        if ($this->aclNode)
            $this->urlExt .= '&amp;a_node='.$this->aclNode;
        
        if ($this->aclLevel)
            $this->urlExt .= '&amp;a_level='.$this->aclLevel;
        
        if ($this->refId)
            $this->urlExt .= '&amp;refid='.$this->refId;
        
        if ($this->requestedBy)
            $this->urlExt .= '&amp;rqtby='.$this->requestedBy;
        
        if ($this->parentMask)
            $this->urlExt .= '&amp;pmsk='.$this->parentMask;
        
        if ($this->ltype)
            $this->urlExt .= '&amp;ltype='.$this->ltype;
        
        if ($this->contextKey)
            $this->urlExt .= '&amp;cntk='.$this->contextKey;
        
        if ($this->maskRoot)
            $this->urlExt .= '&amp;m_root='.$this->maskRoot;
        
        if ($this->publish)
            $this->urlExt .= '&amp;publish='.$this->publish;
        
        if ($this->targetId)
            $this->urlExt .= '&amp;target_id='.$this->targetId;
        
        if ($this->target)
            $this->urlExt .= '&amp;target='.$this->target;
        
        if ($this->targetMask)
            $this->urlExt .= '&amp;target_mask='.$this->targetMask;
        
        if ($this->viewId)
            $this->urlExt .= '&amp;view_id='.$this->viewId;
        
        if ($this->contextMaskSwt)
            $this->urlExt .= '&amp;cntms='.$this->contextMaskSwt;
        
        return $this->urlExt;
    } // end public function toUrlExt */
    
    /**
     *
     * @return string
     */
    public function toActionExt()
    {
        if ($this->actionExt)
            return $this->actionExt;
        
        if ($this->aclRoot)
            $this->actionExt .= '&a_root='.$this->aclRoot;
        
        if ($this->aclRootId)
            $this->actionExt .= '&a_root_id='.$this->aclRootId;
        
        if ($this->aclKey)
            $this->actionExt .= '&a_key='.$this->aclKey;
        
        if ($this->aclNode)
            $this->actionExt .= '&a_node='.$this->aclNode;
        
        if ($this->aclLevel)
            $this->actionExt .= '&a_level='.$this->aclLevel;
        
        if ($this->refId)
            $this->actionExt .= '&refid='.$this->refId;
        
        if ($this->requestedBy)
            $this->actionExt .= '&rqtby='.$this->requestedBy;
        
        if ($this->parentMask)
            $this->actionExt .= '&pmsk='.$this->parentMask;
        
        if ($this->ltype)
            $this->actionExt .= '&ltype='.$this->ltype;
        
        if ($this->contextKey)
            $this->actionExt .= '&cntk='.$this->contextKey;
        
        if ($this->maskRoot)
            $this->actionExt .= '&m_root='.$this->maskRoot;
        
        if ($this->publish)
            $this->actionExt .= '&publish='.$this->publish;
        
        if ($this->targetId)
            $this->actionExt .= '&target_id='.$this->targetId;
        
        if ($this->target)
            $this->actionExt .= '&target='.$this->target;
        
        if ($this->targetMask)
            $this->actionExt .= '&target_mask='.$this->targetMask;
        
        if ($this->viewId)
            $this->actionExt .= '&view_id='.$this->viewId;
        
        if ($this->contextMaskSwt)
            $this->actionExt .= '&cntms='.$this->contextMaskSwt;
        
        return $this->actionExt;
    } // end public function toActionExt */
    
} // end class ContextCrud


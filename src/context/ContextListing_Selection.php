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
class ContextListing_Selection extends ContextListing
{


  /**
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
  
    if ($this->targetMask)
      $this->urlExt .= '&amp;target_mask='.$this->targetMask;
  
    if ($this->refId)
      $this->urlExt .= '&amp;refid='.$this->refId;
  
    if ($this->pRefId)
      $this->urlExt .= '&amp;prefid='.$this->pRefId;
  
    if ($this->adfs)
      $this->urlExt .= '&amp;adfs[]='.implode('&amp;adfs[]=',$this->adfs);
  
    return $this->urlExt;
  
  }//end public function toUrlExt */
  
  /**
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
  
    if ($this->targetMask)
      $this->actionExt .= '&target_mask='.$this->targetMask;
    
    if ($this->refId)
      $this->actionExt .= '&refid='.$this->refId;
    
    if ($this->pRefId)
      $this->actionExt .= '&prefid='.$this->pRefId;
    
    if ($this->adfs)
      $this->actionExt .= '&adfs[]='.implode('&adfs[]=',$this->adfs);
  
    return $this->actionExt;
  
  }//end public function toActionExt */
  
  
  /**
   * method to set the form data
   * @param TFlag $param
   */
  public function injectSearchFormData($view, $subkey = null)
  {
  
    $formAction = $this->searchFormAction;
  
    // the id of the html table where the new entry has to be added
    if ($this->targetId)
      $formAction .= '&amp;target_id='.$this->targetId;
  
    // flag if the new entry should be added with connection action or CRUD actions
    if ($this->publish)
      $formAction .= '&amp;publish='.$this->publish;
  
    // target is a pointer to a js function that has to be called
    if ($this->target)
      $formAction .= '&amp;target='.$this->target;
  
    if ($this->ltype)
      $formAction .= '&amp;ltype='.$this->ltype;
  
    // target is a pointer to a js function that has to be called
    if ($this->input)
      $formAction .= '&amp;input='.$this->input;
  
    // suffix is used to prevent namecolisions in form objects for the same
    // entity, on the same mask but diffrent datasets
    // suffix is normaly the objid, "search" oder "create"
    // it has to be transported during selection / filter requests, else the
    // data method is not able to target the correct input elements
    if ($this->suffix)
      $formAction .= '&amp;suffix='.$this->suffix;
  
    // they keyname is used to prevent naming colissions in forms
    if ($this->keyName)
      $formAction .= '&amp;key_name='.$this->keyName;
  
    // they keyname is used to prevent naming colissions in forms
    if ($this->fullLoad)
      $formAction .= '&amp;full_load=true';
  
    // check if there are things to exclude
    if ($this->exclude)
      $formAction .= '&amp;exclude='.$this->exclude;
  
    // which view type was used, important to close the ui element eg.
    if ($this->viewType)
      $formAction .= '&amp;view='.$this->viewType;
  
    // which view type was used, important to close the ui element eg.
    if ($this->viewId)
      $formAction .= '&amp;view_id='.$this->viewId;
  
    // append objid
    if ($this->objid)
      $formAction .= '&amp;objid='.$this->objid;
  
    if ($this->refIds) {
      foreach ($this->refIds as $key => $value) {
        $formAction .= '&amp;refids['.$key.']='.$value;
      }
    }
  
    if ($this->dynFilters) {
      foreach ($this->dynFilters as $value) {
        $formAction .= '&amp;dynfilter[]='.$value;
      }
    }
    
    if ($this->refId)
      $formAction .= '&amp;refid='.$this->refId;
    
    if ($this->pRefId)
      $formAction .= '&amp;prefid='.$this->pRefId;
    
    if ($this->adfs)
      $formAction .= '&amp;adfs[]='.implode('&amp;adfs[]=',$this->adfs);
  
    // ACLS
  
    // startpunkt des pfades für die acls
    if ($this->aclRoot)
      $formAction .= '&amp;a_root='.$this->aclRoot;
  
    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($this->aclRootId)
      $formAction .= '&amp;a_root_id='.$this->aclRootId;
  
    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclKey)
      $formAction .= '&amp;a_key='.$this->aclKey;
  
    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclLevel)
      $formAction .= '&amp;a_level='.$this->aclLevel;
  
    // der neue knoten
    if ($this->aclNode)
      $formAction .= '&amp;a_node='.$this->aclNode;
  
    // add the action to the form
    $view->addVar('searchFormAction'.$subkey, $formAction);
  
    // check if there is a specific class for the crudform, if not use wcm wcm_req_ajax
    if (!$this->searchFormClass)
      $this->searchFormClass = 'wcm wcm_req_ajax';
  
    // add the class to the form
    $view->addVar('searchFormClass'.$subkey, $this->searchFormClass);
  
    // formId
    $view->addVar('searchFormId'.$subkey, $this->searchFormId);
  
  }//end public function injectSearchFormData */
  
  /**
   * method to set the form data
   * @param TFlag $param
   */
  public function buildSearchFormAction($formAction)
  {
  
    // the id of the html table where the new entry has to be added
    if ($this->targetId)
      $formAction .= '&amp;target_id='.$this->targetId;
  
    // flag if the new entry should be added with connection action or CRUD actions
    if ($this->publish)
      $formAction .= '&amp;publish='.$this->publish;
  
    // target is a pointer to a js function that has to be called
    if ($this->target)
      $formAction .= '&amp;target='.$this->target;
  
    // target is a pointer to a js function that has to be called
    if ($this->input)
      $formAction .= '&amp;input='.$this->input;
  
    // they keyname is used to prevent naming colissions in forms
    if ($this->keyName)
      $formAction .= '&amp;key_name='.$this->keyName;
  
    // suffix is used to prevent namecolisions in form objects for the same
    // entity, on the same mask but diffrent datasets
    // suffix is normaly the objid, "search" oder "create"
    // it has to be transported during selection / filter requests, else the
    // data method is not able to target the correct input elements
    if ($this->suffix)
      $formAction .= '&amp;suffix='.$this->suffix;
  
    if ($this->fullLoad)
      $formAction .= '&amp;full_load=true';
  
    // check if there are things to exclude
    if ($this->exclude)
      $formAction .= '&amp;exclude='.$this->exclude;
  
    // which view type was used, important to close the ui element eg.
    if ($this->viewType)
      $formAction .= '&amp;view='.$this->viewType;
  
    // which view type was used, important to close the ui element eg.
    if ($this->viewId)
      $formAction .= '&amp;view_id='.$this->viewId;
  
    // append objid
    if ($this->objid)
      $formAction .= '&amp;objid='.$this->objid;
  
    if ($this->refIds) {
      foreach ($this->refIds as $key => $value) {
        $formAction .= '&amp;refids['.$key.']='.$value;
      }
    }
  
    if ($this->dynFilters) {
      foreach ($this->dynFilters as $value) {
        $formAction .= '&amp;dynfilter[]='.$value;
      }
    }
    
    if ($this->refId)
      $formAction .= '&amp;refid='.$this->refId;
    
    if ($this->pRefId)
      $formAction .= '&amp;prefid='.$this->pRefId;
    
    if ($this->adfs)
      $formAction .= '&amp;adfs[]='.implode('&amp;adfs[]=',$this->adfs);
  
    // ACLS
  
    // startpunkt des pfades für die acls
    if ($this->aclRoot)
      $formAction .= '&amp;a_root='.$this->aclRoot;
  
    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($this->aclRootId)
      $formAction .= '&amp;a_root_id='.$this->aclRootId;
  
    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclKey)
      $formAction .= '&amp;a_key='.$this->aclKey;
  
    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($this->aclLevel)
      $formAction .= '&amp;a_level='.$this->aclLevel;
  
    // der neue knoten
    if ($this->aclNode)
      $formAction .= '&amp;a_node='.$this->aclNode;
  
    return $formAction;
  
  }//end public function setFormAction */
  
} // end class ContextListing_Selection

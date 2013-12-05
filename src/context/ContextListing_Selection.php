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
  
} // end class ContextListing_Selection

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
 * @subpackage core_item\attachment
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapAttachment_Ajax_View
  extends LibTemplatePlain
{
////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param WebfrapAttachment_Context $context
   * @param Entity $attachNode
   */
  public function renderAddEntry( $context, $entry )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-attachment-'.$context->element.'-table>tbody';
    $pageFragment->action = 'prepend';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->setId( $context->element );
    $attachmentElement->refId = $context->refId;
    
    $attachmentElement->maskFilter = $context->maskFilter;
    $attachmentElement->typeFilter = $context->typeFilter;
    $attachmentElement->refMask = $context->refMask;
    $attachmentElement->refField = $context->refField;
    $attachmentElement->preRenderUrl();
    
    $paramMaskFilter = '';
    
    if( $context->maskFilter )
    {
       $paramMaskFilter = '&amp;mask_filter='.$context->maskFilter;
    }
    else if( $context->typeFilter )
    {
      $paramMaskFilter = '&amp;type_filter[]='.implode( '&amp;type_filter[]=', $context->typeFilter  );
    }

    $pageFragment->setContent( $attachmentElement->renderAjaxEntry( $context->element, $entry, $paramMaskFilter ) );
    
    $tpl->setArea( 'attachment', $pageFragment );

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$context->element}-table').grid('renderRowLayout').grid('incEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderAddEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param WebfrapAttachment_Context $context
   * @param array $entry
   */
  public function renderUpdateEntry( $objid, $context, $entry  )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$context->element.'_row_'.$entry['attach_id'];
    $pageFragment->action   = 'replace';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->refId = $objid;
    $attachmentElement->setId( $context->element );
    
    $attachmentElement->maskFilter = $context->maskFilter;
    $attachmentElement->typeFilter = $context->typeFilter;
    $attachmentElement->refMask = $context->refMask;
    $attachmentElement->refField = $context->refField;
    $attachmentElement->preRenderUrl();
    
    $paramMaskFilter = '';
    
    if( $context->maskFilter )
    {
       $paramMaskFilter = '&amp;mask_filter='.$context->maskFilter;
    }
    else if( $context->typeFilter )
    {
      $paramMaskFilter = '&amp;type_filter[]='.implode( '&amp;type_filter[]=', $context->typeFilter  );
    }

    $pageFragment->setContent( $attachmentElement->renderAjaxEntry( $context->element, $entry, $paramMaskFilter ) );
    
    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$context->element}-table').grid('renderRowLayout');

WGTJS;
    

  }//end public function renderUpdateEntry */
  
  /**
   * @param int $attachId
   * @param WebfrapAttachment_Context $context
   */
  public function renderRemoveEntry(  $attachId, $context )
  {
    
    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$context->element.'_row_'.$attachId;
    $pageFragment->action = 'remove';

    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$context->element}-table').grid('renderRowLayout').grid('decEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderRemoveEntry */
  
  /**
   * Render des Suchergebnisses und übergabe in die ajax response
	 * @param WebfrapAttachment_Context $context
   * @param array $data
   */
  public function renderSearch( $context, $data )
  {

    $tpl = $this->getTplEngine();
    
    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-attachment-'.$context->element.'-table>tbody';
    $pageFragment->action   = 'html';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->idKey = $context->element;
    $attachmentElement->refId = $context->refId;
    $attachmentElement->setData( $data );
    
    $attachmentElement->maskFilter = $context->maskFilter;
    $attachmentElement->typeFilter = $context->typeFilter;
    $attachmentElement->refMask = $context->refMask;
    $attachmentElement->refField = $context->refField;
    $attachmentElement->preRenderUrl();

    $pageFragment->setContent( $attachmentElement->renderAjaxBody( $context->element, $data ) );
    
    $tpl->setArea( 'attachment', $pageFragment );
    
    $numElem = count($data);
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$context->element}-table').grid('renderRowLayout').grid('setNumEntries','{$numElem}');

WGTJS;

    $tpl->addJsCode( $jsCode );
    

  }//end public function renderSearch */
  
////////////////////////////////////////////////////////////////////////////////
// Storage
////////////////////////////////////////////////////////////////////////////////

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param WebfrapAttachment_Context $context
   * @param array $entry
   */
  public function renderAddStorageEntry( $context, $entry )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-attachment-'.$context->element.'-storage-table>tbody';
    $pageFragment->action = 'prepend';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->setId( $context->element );
    $attachmentElement->refId = $context->refId;
    $attachmentElement->refMask = $context->refMask;
    $attachmentElement->refField = $context->refField;
    $attachmentElement->preRenderUrl();
    

    $pageFragment->setContent( $attachmentElement->renderAjaxStorageEntry( $context->element, $entry ) );
    
    $tpl->setArea( 'attachment', $pageFragment );

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$context->element}-storage-table').grid('renderRowLayout').grid('incEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderAddStorageEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param WebfrapAttachment_Context $context
   * @param string $storageId
   * @param array $entry
   */
  public function renderUpdateStorageEntry( $context, $storageId,  $entry  )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$context->element.'-storage_row_'.$entry['storage_id'];
    $pageFragment->action   = 'replace';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->setId( $context->element );
    $attachmentElement->refId = $context->refId;
    $attachmentElement->refMask = $context->refMask;
    $attachmentElement->refField = $context->refField;
    $attachmentElement->preRenderUrl();

    $pageFragment->setContent( $attachmentElement->renderAjaxStorageEntry( $context->element, $entry ) );
    
    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$context->element}-storage-table').grid('renderRowLayout');

WGTJS;
    

  }//end public function renderUpdateStorageEntry */
  
  /**
   * @param int $storageId
   * @param WebfrapAttachment_Context $context
   */
  public function renderRemoveStorageEntry(  $storageId, $context )
  {
    
    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$context->element.'-storage_row_'.$storageId;
    $pageFragment->action = 'remove';

    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$context->element}-storage-table').grid('renderRowLayout').grid('decEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderRemoveStorageEntry */

} // end class WebfrapAttachment_Ajax_View */


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
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapContactItem_Ajax_View
  extends LibTemplatePlain
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $refId
   * @param string $elementId
   * @param Entity $attachNode
   */
  public function renderAddEntry( $refId, $elementId, $entry )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-attachment-'.$elementId.'-table>tbody';
    $pageFragment->action = 'prepend';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->setId( $elementId );

    $pageFragment->setContent( $attachmentElement->renderAjaxEntry( $elementId, $entry ) );
    
    $tpl->setArea( 'attachment', $pageFragment );

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$elementId}-table').grid('renderRowLayout').grid('incEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderAddEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function renderUpdateEntry( $refId, $elementId, $entry  )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$elementId.'_row_'.$entry['attach_id'];
    $pageFragment->action   = 'replace';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->refId = $refId;
    $attachmentElement->setId( $elementId );

    $pageFragment->setContent( $attachmentElement->renderAjaxEntry( $elementId, $entry ) );
    
    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$elementId}-table').grid('renderRowLayout');

WGTJS;
    

  }//end public function renderUpdateEntry */
  
  /**
   * @param int $refId
   * @param string $elementId
   * @param int $attachId
   */
  public function renderRemoveEntry(  $refId, $elementId, $attachId )
  {
    
    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$elementId.'_row_'.$attachId;
    $pageFragment->action = 'remove';

    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$elementId}-table').grid('renderRowLayout').grid('decEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderRemoveEntry */
  
  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param int $refId
   * @param string $elementId
   * @param array $data
   */
  public function renderSearch( $refId, $elementId, $data )
  {

    $tpl = $this->getTplEngine();
    
    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-attachment-'.$elementId.'-table>tbody';
    $pageFragment->action   = 'html';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->idKey = $elementId;
    $attachmentElement->refId = $refId;
    $attachmentElement->setData( $data );

    $pageFragment->setContent( $attachmentElement->renderAjaxBody( $elementId, $data ) );
    
    $tpl->setArea( 'attachment', $pageFragment );
    
    $numElem = count($data);
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$elementId}-table').grid('renderRowLayout').grid('setNumEntries','{$numElem}');

WGTJS;

    $tpl->addJsCode( $jsCode );
    

  }//end public function renderSearch */
  
/*//////////////////////////////////////////////////////////////////////////////
// Storage
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $refId
   * @param string $elementId
   * @param Entity $attachNode
   */
  public function renderAddStorageEntry( $refId, $elementId, $entry )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-attachment-'.$elementId.'-storage-table>tbody';
    $pageFragment->action = 'prepend';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->setId( $elementId );

    $pageFragment->setContent( $attachmentElement->renderAjaxStorageEntry( $elementId, $entry ) );
    
    $tpl->setArea( 'attachment', $pageFragment );

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$elementId}-storage-table').grid('renderRowLayout').grid('incEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderAddStorageEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $storageId
   * @param string $elementId
   * @param array $entry
   */
  public function renderUpdateStorageEntry( $storageId, $elementId, $entry  )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$elementId.'-storage_row_'.$entry['storage_id'];
    $pageFragment->action   = 'replace';
    
    $attachmentElement = new WgtElementAttachmentList();
    $attachmentElement->setId( $elementId );

    $pageFragment->setContent( $attachmentElement->renderAjaxStorageEntry( $elementId, $entry ) );
    
    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$elementId}-storage-table').grid('renderRowLayout');

WGTJS;
    

  }//end public function renderUpdateStorageEntry */
  
  /**
   * @param int $storageId
   * @param string $elementId
   */
  public function renderRemoveStorageEntry(  $storageId, $elementId )
  {
    
    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-attachment-'.$elementId.'-storage_row_'.$storageId;
    $pageFragment->action = 'remove';

    $tpl->setArea( 'attachment', $pageFragment );
    
    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-attachment-{$elementId}-storage-table').grid('renderRowLayout').grid('decEntries');

WGTJS;

    $tpl->addJsCode( $jsCode );
    
  }//end public function renderRemoveStorageEntry */

} // end class WebfrapAttachment_Ajax_View */


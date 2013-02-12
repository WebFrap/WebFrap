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
class WebfrapAttachment_Storage_Modal_View
  extends WgtModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width   = 630 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height   = 280 ;

////////////////////////////////////////////////////////////////////////////////
// Display Methodes
////////////////////////////////////////////////////////////////////////////////

 /**
  * the default edit form
  * @param WebfrapAttachment_Context $context
  * @return void
  */
  public function displayForm( $context )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Add Storage';

    // set the window title
    $this->setTitle( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/attachment/modal/form_add_storage', true );

    $this->addVars( array(
      'elementKey' => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayForm */

 /**
  * the default edit form
  * @param WbfsysFileStorage_Entity $fileNode
  * @param WebfrapAttachment_Context $context
  * @return void
  */
  public function displayEdit( $storageNode, $context )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Edit Storage';

    // set the window title
    $this->setTitle( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/attachment/modal/form_edit_storage', true );

    $this->addVars( array(
      'storage'       => $storageNode,
      'elementKey'    => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayEdit */

}//end class WebfrapAttachment_Storage_Modal_View

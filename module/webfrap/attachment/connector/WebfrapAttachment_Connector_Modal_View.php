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
class WebfrapAttachment_Connector_Modal_View extends WgtModal
{

  /**
   * Die Breite des Modal Elements
   * @var int in px
   */
  public $width   = 600 ;

  /**
   * Die Höhe des Modal Elements
   * @var int in px
   */
  public $height   = 300 ;

/*//////////////////////////////////////////////////////////////////////////////
// Display Methodes
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * the default edit form
  * @param WebfrapAttachment_Context $context
  * @return void
  */
  public function displayCreate($context)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Attachment';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('webfrap/attachment/connector/modal/form_new', true);

    $this->addVars(array(
      'refId' => $context->refId,
      'elementKey' => $context->element,
      'refMask' => $context->refMask,
      'preUrl' => $context->toUrlExt(),
    ));

  }//end public function displayCreate */

}//end class WebfrapAttachment_Connector_Modal_View


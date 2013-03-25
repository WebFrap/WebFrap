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
 * @copyright webfrap.net <contact@webfrap.net>
 * @licence BSD
 */
class WebfrapMediathek_Document_Modal_View extends WgtModal
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
  * Die create form
  * @param int $mediaId
  * @param string $elementId
  * @param TFlag $params
  * @return void
  */
  public function displayAdd($mediaId, $elementId, $params = null)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Add Document';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('webfrap/mediathek/modal/form_document_add');

    $this->addVars(array(
      'mediaId'    => $mediaId,
      'elementKey' => $elementId,
    ));

  }//end public function displayAdd */

 /**
  * the default edit form
  * @param string $documentId
  * @param string $mediaId
  * @param string $elementId
  * @param WbfsysImage_Entity $fileNode
  * @param TFlag $params
  * @return void
  */
  public function displayEdit($documentId, $mediaId, $elementId, $fileNode, $params = null)
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Edit Document';

    // set the window title
    $this->setTitle($i18nText);

    // set the from template
    $this->setTemplate('webfrap/mediathek/modal/form_document_edit');

    $this->addVars(array(
      'documentId' => $documentId,
      'mediaId'    => $mediaId,
      'elementId'  => $elementId,
      'document'   => $fileNode,
    ));

  }//end public function displayEdit */

}//end class WebfrapMediathek_Document_Modal_View


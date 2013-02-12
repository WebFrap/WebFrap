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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapAttachment_Video_Modal_View
  extends WgtModal
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

////////////////////////////////////////////////////////////////////////////////
// Display Methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * the default edit form
  * @param int $refId
  * @param TFlag $params
  * @return void
  */
  public function displayForm( $refId, $elementId, $params = null )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Upload Files';

    // set the window title
    $this->setTitle( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/attachment/modal/form_upload_files' );
    
    $this->addVars( array(
      'refId' => $refId,
      'elementKey' => $elementId,
    ));

  }//end public function displayForm */
  
 /**
  * the default edit form
  * @param int $attachId
  * @param int $refId
  * @param WbfsysFile_Entity $fileNode
  * @param string $elementId
  * @return void
  */
  public function displayEdit( $attachId, $refId, $fileNode, $elementId )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Edit File';

    // set the window title
    $this->setTitle( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/attachment/modal/form_edit_file' );
    
    $this->addVars( array(
      'attachmentId'   => $attachId,
      'refId'      => $refId,
      'file'       => $fileNode,
      'elementKey' => $elementId,
    ));

  }//end public function displayEdit */


}//end class WebfrapAttachment_File_Modal_View


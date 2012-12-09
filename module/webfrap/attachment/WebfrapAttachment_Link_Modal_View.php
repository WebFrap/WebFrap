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
class WebfrapAttachment_Link_Modal_View
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
  * @param int $refId
  * @param string $elementId
  * @param TFlag $params
  * @return void
  */
  public function displayForm( $refId, $elementId, $params = null )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Add Link';

    // set the window title
    $this->setTitle( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/attachment/modal/form_add_link', true );
    
    if( $this->model->maskFilter )
    {
       $this->addVar( 'typeFilter', $this->model->maskFilter );
       $this->addVar( 'paramTypeFilter', '&amp;mask_filter='.$this->model->maskFilter );
    }
    else if( $this->model->typeFilter )
    {
      $this->addVar( 'typeFilter', $this->model->typeFilter );
      $this->addVar( 'paramTypeFilter', '&amp;type_filter[]='.implode( '&amp;type_filter[]=', $this->model->typeFilter )  );
    }

    $this->addVars( array(
      'refId' => $refId,
      'elementKey' => $elementId,
      'refMask' => $this->model->refMask,
      'preUrl' => $this->model->getUrlExt( ),
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
    $i18nText = 'Edit Link';

    // set the window title
    $this->setTitle( $i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/attachment/modal/form_edit_link', true );
    
    if( $this->model->maskFilter )
    {
       $this->addVar( 'typeFilter', $this->model->maskFilter );
    }
    else if( $this->model->typeFilter )
    {
      $this->addVar( 'typeFilter', $this->model->typeFilter );
    }

    $this->addVars( array(
      'attachmentId'   => $attachId,
      'refId'   => $refId,
      'link'       => $fileNode,
      'elementKey' => $elementId,
      'refMask' => $this->model->refMask,
      'preUrl' => $this->model->getUrlExt( ),
    ));


  }//end public function displayEdit */

}//end class WebfrapAttachment_Link_Modal_View


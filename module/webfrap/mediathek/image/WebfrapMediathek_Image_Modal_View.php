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
 * @licence BSD
 */
class WebfrapMediathek_Image_Modal_View extends WgtModal
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
  * @param int $mediaId
  * @param string $elementId
  * @param TFlag $params
  * @return void
  */
  public function displayAdd($mediaId, $elementId, $params = null )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Add Image';

    // set the window title
    $this->setTitle($i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/mediathek/modal/form_image_add' );
    
    $this->addVars( array(
      'mediaId'    => $mediaId,
      'elementKey' => $elementId,
    ));

  }//end public function displayAdd */
  
 /**
  * the default edit form
  * @param string $imageId
  * @param string $mediaId
  * @param string $elementId
  * @param WbfsysImage_Entity $imageNode
  * @param TFlag $params
  * @return void
  */
  public function displayEdit($imageId, $mediaId, $elementId, $imageNode, $params = null )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = 'Edit Image';

    // set the window title
    $this->setTitle($i18nText );

    // set the from template
    $this->setTemplate( 'webfrap/mediathek/modal/form_image_edit' );
    
    $this->addVars( array(
      'imageId'    => $imageId,
      'mediaId'    => $mediaId,
      'elementId'  => $elementId,
      'image'      => $imageNode,
    ));

  }//end public function displayEdit */


}//end class WebfrapMediathek_Image_Modal_View


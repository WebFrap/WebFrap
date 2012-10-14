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
class CmsFront_Html_View
  extends LibTemplatePage
{


  
  /**
   * @var CmsFront_Model
   */
  public $model = null;

////////////////////////////////////////////////////////////////////////////////
// 
////////////////////////////////////////////////////////////////////////////////
  
 /**
  *
  * @param TFlowFlag $params named parameters
  * @return boolean
  */
  public function displayPage( $key, $params )
  {

    $this->tplEngine->keyCss    = 'front';
    $this->tplEngine->keyJs     = 'front';
    $this->tplEngine->keyTheme  = 'front';
    
    $this->tplEngine->debugConsole = false;

    $page = $this->model->getPage( $key );

    $tplNode = $this->model->getTemplate( $page );

    $this->texts->addData( $this->model->getTexts( $tplNode ) );
    $this->menus->addData( $this->model->getMenus( $tplNode ) );
    $this->areas->addData( $this->model->getAreas( $tplNode ) );

    //$this->setIndex();
    $this->setIndex( 'cms/default' );
    $this->setTemplate( 'cms/'.$tplNode->access_key );

    $this->tplEngine->setTitle( $page->title );
    $this->addVar( 'page', $page->parsed_content );

  }//end public function displayPage */
  
 /**
  *
  * @param TFlowFlag $params named parameters
  * @return boolean
  */
  public function displayPreview( $key, $params )
  {

    $this->tplEngine->keyCss    = 'front';
    $this->tplEngine->keyJs     = 'front';
    $this->tplEngine->keyTheme  = 'front';
    
    $this->tplEngine->debugConsole = false;

    $page = $this->model->getPage( $key );

    $tplNode = $this->model->getTemplate( $page );

    $this->texts->addData( $this->model->getTexts( $tplNode ) );
    $this->menus->addData( $this->model->getMenus( $tplNode ) );
    $this->areas->addData( $this->model->getAreas( $tplNode ) );

    //$this->setIndex();
    $this->setIndex( 'cms/default' );
    $this->setTemplate( 'cms/'.$tplNode->access_key );

    $this->tplEngine->setTitle( $page->title );
    $this->addVar( 'page', $page->parsed_content );

  }//end public function displayPreview */

  /**
   *
   * Enter description here ...
   * @param string $key
   */
  public function getMenu( $key )
  {
    return isset( $this->menus[$key] )?$this->menus[$key]:array();
  }//end public function getMenu */

  /**
   * @param string $key
   */
  public function getText( $key )
  {
    return isset( $this->texts[$key] )?$this->texts[$key]:'';
  }//end public function getText */

  /**
   * @param string $key
   */
  public function getArea( $key )
  {
    return isset( $this->areas[$key] )?$this->areas[$key]:'';
  }//end public function getText */
  
  /**
   * @param string $key
   */
  public function getBuilder( $key )
  {
    $className = "WgtBuilder".$key;
    return new $className();
  }//end public function getBuilder */

} // end class CmsFront_View


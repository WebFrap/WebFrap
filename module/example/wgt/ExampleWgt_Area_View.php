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
 * @subpackage ModEnterprise
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class ExampleWgt_Area_View extends LibTemplateAreaView
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $menuName
   * @return void
   */
  public function displayArea($areaKey  )
  {

    $this->setTemplate('example/wgt/tpl/'.str_replace('.', '/', $areaKey)  , true  );

    $this->position = '#wgt-area-example-content';
    $this->action = 'html';

  }//end public function displayTree */
  
  /**
   * @param LibRequestHttp $request
   * @return void
   */
  public function displayConsole($request)
  {

    $this->position = '#wgt-area-tech-example-rqtdata';
    $this->action = 'html';
    
    $content = "<h2>GET</h2>";
    $content .= Debug::dumpToString($request->param(),true);
    $content .= "<h2>POST</h2>";
    $content .= Debug::dumpToString($request->data(),true);
    
    $this->setContent($content);

  }//end public function displayConsole */

}//end class WebfrapNavigation_Maintab


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
 * Dummy class for Extentions
 * This class will be loaded if the System requests for an Extention that
 * doesn't exist
 * @package WebFrap
 * @subpackage Core
 */
class ExampleAjax_Ajax_View extends LibTemplateAjaxView
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/



/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   * @param TArray $params
   */
  public function displayData1($params)
  {

    $area = $this->newArea('newArea');

    // replace the inner html
    $area->action = 'html';

    // ein jquery selector
    $area->position = '#wgt-box-data1';

    // ein jquery selector
    $area->setContent('The new content of the box. <span style="color:#ff0011;" >bunt und in farbe<span>');

    $this->getResponse()->addMessage('fubar');


  }//end public function displayData1 */


  /**
   *
   * @param TArray $params
   */
  public function displayNewClass($params)
  {

    $area = $this->newArea('newArea');

    // replace the inner html
    $area->action = 'addClass';

    // ein jquery selector
    $area->position = '#wgt-box-data1';

    // ein jquery selector
    $area->setContent('wgt-border');

  }//end public function displayNewClass */

  /**
   *
   * @param TArray $params
   */
  public function displayToggleClass($params)
  {

    $jsCode =<<<JS

  \$S('#wgt-box-data1').toggleClass('wgt-border');

JS;

    $this->addJsCode($jsCode);

  }//end public function displayToggleClass */

} // end class ExampleAjax_Ajax_View

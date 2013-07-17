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
 * @subpackage wgt
 */
class WgtSimpleTabContainer
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var Template
   */
  public $view = null;

  /**
   * @var string
   */
  public $id = null;

  /**
   * @var {key:string,content:string}
   */
  public $data = array();

  public $classes = array();

/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var LibTemplate $view
   */
  public function __construct($view = null, $id= null)
  {

    if (!$view)
      $view = Webfrap::$env->getTpl();

    $this->view = $view;

    $this->id = $id;

  }//end public function __construct */


  /**
   * @var LibTemplate $view
   */
  public function render()
  {

  	$entries = array();

  	foreach ($this->data as $data) {

  		$entries[] = <<<HTML
  <div
    class="container"
    style="display:none;"
    wgt_key="{$data['id']}"
    id="{$this->id}-{$data['id']}" >
{$data['content']}
  </div>
HTML;

  	}

  	return '<div id="'.$this->id.'" class="wgt-content-box'.implode(' ',$this->classes).'" >'.implode(NL,$entries).'</div>';


  }//end public function render */

}//end class WgtSimpleTabContainer


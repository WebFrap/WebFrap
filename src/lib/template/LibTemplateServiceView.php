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
 * empty implementation
 * @package WebFrap
 * @subpackage tech_core
 */
class LibTemplateServiceView extends LibTemplate
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * what type of view ist this object, html, ajax, document...
   * @var string
   */
  public $type         = 'service';

  /**
   * serialized json data
   * @var string
   */
  public $jsonData      = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  public function __construct($tpl)
  {
    $this->tplEngine = $tpl;
    $this->tpl = $tpl;
  }

  /**
   * @param string $jsonData
   */
  public function setDataBody($jsonData)
  {

    $this->tpl->setDataBody($jsonData);

  }//end public function setDataBody */

  /**
   *
   */
  public function setIndex($index = 'default')
  {

    $this->tpl->setIndex($index);

  }//end public function setIndex */

  /**
   * @param string $template
   * @param boolean $inCode
   */
  public function setTemplate($template, $inCode = false)
  {

    $this->tpl->setTemplate($template, $inCode);

  }//end public function setTemplate */

  /**
   * @param string $key
   * @param mixed $data
   */
  public function addVar($key, $data = null)
  {

    $this->tpl->addVar($key, $data);

  }//end public function addVar */

  /**
   * @param array $vars
   */
  public function addVars($vars)
  {

    $this->tpl->addVars($vars);

  }//end public function addVars */

  /**
   *
   * @return void
   */
  public function compile() {}

  /**
   *
   * @return void
   */
  public function publish() {}

  /**
   *
   */
  protected function buildMessages() {}

} // end class LibTemplateServiceView


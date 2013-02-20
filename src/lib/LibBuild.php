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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class LibBuild
{
/*//////////////////////////////////////////////////////////////////////////////
// constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var unknown_type
   */
  const ACTION = 0;

  /**
   *
   * @var unknown_type
   */
  const PARAMS = 1;

/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string
   */
  protected $buildConf  = null;

  /**
   * @param string
   */
  protected $build      = array();

/*//////////////////////////////////////////////////////////////////////////////
// nethodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function __construct($buildConf = null )
  {

    $this->buildConf = $buildConf;

  }//end public function __construct */

  /**
   *
   */
  public function build()
  {

    $this->load();

    $actions = array();

    foreach ($this->build as $buildNode) {

      $action = $buildNode[LibBuild::ACTION];
      $params = $buildNode[LibBuild::PARAMS];

      $className = 'LibBuild'.ucfirst($action);

      if (!WebFrap::classLoadable($className) ) {
        Error::addError('Tried to call nonexisting build action '.$action);

        return false;
      }

      $actions[] = new $className($params );

    }

    foreach ($actions as $action) {
      if (!$action->execute())
        break;
    }

    return true;

  }//end public function build */

  /**
   *
   */
  protected function load($buildConf = null )
  {

    if (!$buildConf)
      $buildConf = $this->buildConf;

    if (!file_exists($this->buildConf)) {
      Error::addError('Got invalid Build File: '.$this->buildConf.'. Please check the Buildpath you have given.');

      return;
    }

    include $this->buildConf;

  }//end public function build */

} // end class LibGenfBuild


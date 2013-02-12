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
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 *
 */
class ControllerExport
  extends Controller
{

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getExportFlags( $request = null )
  {

    if( !$request )
      $request = Webfrap::$env->getRequest();

    return new ContextExport($request);

  }//end protected function getExportFlags */

} // end class ControllerExport

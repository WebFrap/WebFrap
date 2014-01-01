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
 * Routing Controller mit dessen Hilfe Anfragen je nach Eigenschaft
 * eines Datensatzen auf einen jeweils passenden Controller
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 *
 */
class ControllerRouter extends ControllerCrud
{

  /**
   * @param string $action
   */
  public function getRouteName ($action)
  {
    return null;

  } //end public function getRouteName */

  /**
   * die vom request angeforderte methode auf rufen
   *
   * @param string $action
   * @return boolean
   */
  public function run ($action = null)
  {

    $controllerName = $this->getRouteName($action);

    if (! $controllerName) {
      $this->errorPage("Found no Route for your request", Response::NOT_FOUND);

      return false;
    }

    $className = $controllerName . '_Controller';

    if (WebFrap::classExists($className)) {
      $controller = new $className();
    } else {

      $this->errorPage("Invalid Route, the target " . $controllerName . ' not exists.', Response::INTERNAL_ERROR);

      return false;
    }

    try {

      // Initialisieren der Extention
      if (! $controller->initController())
        throw new Webfrap_Exception('Failed to initialize Controller');

   // Run the mainpart
      $controller->run($action);

      // shout down the extension
      $controller->shutdownController();

    } catch (Exception $exc) {

      $type = get_class($exc);

      if (Log::$levelDebug) {
        // Create a Error Page
        $this->errorPage($exc->getMessage(), Response::INTERNAL_ERROR, $exc);

      } else {
        switch ($type) {
          case 'Security_Exception' :{
            $this->errorPage($response->i18n->l('Access Denied', 'wbf.message'), Error::NOT_AUTHORIZED);

            break;
          }
          default :{

            Debug::console($exc->getMessage());
            $this->errorPage($response->i18n->l('Sorry Internal Error', 'wbf.message'), Response::INTERNAL_ERROR);

            break;
          } //end default

        } //end switch

      } //end else

    } //end catch

    return true;

  } //end public function run */

} // end class ControllerRouter

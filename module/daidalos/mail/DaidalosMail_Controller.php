<?php
/*******************************************************************************
*
* @author      : Malte Schirmacher <malte.schirmacher@webfrap.net>
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
 * @subpackage Daidalos
 * @author Malte Schirmacher <malte.schirmacher@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosMail_Controller extends Controller
{
  //////////////////////////////////////////////////////////////////////////////*/
  // Attributes
  //////////////////////////////////////////////////////////////////////////////*/

  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   *
   * method: Der Service kann nur mit den im Array vorhandenen HTTP Methoden
   * aufgerufen werden. Wenn eine falsche Methode verwendet wird, gibt das
   * System automatisch eine "Method not Allowed" Fehlermeldung zurück
   *
   * views: Die Viewtypen die erlaubt sind. Wenn mit einem nicht definierten
   * Viewtype auf einen Service zugegriffen wird, gibt das System automatisch
   * eine "Invalid Request" Fehlerseite mit einer Detailierten Meldung, und der
   * Information welche Services Viewtypen valide sind, zurück
   *
   * public: boolean wert, ob der Service auch ohne Login aufgerufen werden darf
   * wenn nicht vorhanden ist die Seite per default nur mit Login zu erreichen
   *
   * @var array
   */
  protected $options = array ( 'form' => array ( 'method' => array ( 'GET' ), 'views' => array ( 'maintab' ) ),

      'login' => array ( 'method' => array ( 'POST', 'GET' ), 'views' => array ( 'maintab' ) ) );

  //////////////////////////////////////////////////////////////////////////////*/
  // Backup & Restore
  //////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_form ($request, $response )
  {
    $params = $this->getFlags ($request);

    $key = $request->param ( 'key', Validator::CKEY );

    if ( isset ($_SESSION['imap_connector'] ) ) {
      $view = $response->loadView ( 'daidalos_mail-form', 'DaidalosMail', 'displayForm', View::MAINTAB );

      $model = $this->loadModel ( 'DaidalosMail' );
      $view->setModel ($model );

      try {
        $view->addVar ( 'mailboxes', $_SESSION['imap_connector']->getAllMailboxes ( ) );
      } catch ( ezcMailTransportException $e ) {
        $_SESSION['imap_connector'] = null;
        $this->service_login ($request, $response );
      }

      $view->displayForm ($params );
    } else {
      $this->service_login ($request, $response );
    }

  } //end public function service_form */

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_login ($request, $response )
  {
    $params = $this->getFlags ($request);

    $key = $request->param ( 'key', Validator::CKEY );

    if ($request->method ( ) === 'GET' ) {
      if ( isset ($_SESSION['imap_config'] ) ) {
        $_SESSION['imap_connector'] = LibMailConnector::createStandardConnector ($_SESSION['imap_config'] );

        return $this->service_form ($request, $response );
      }

      $view = $response->loadView ( 'daidalos_mail-login', 'DaidalosMail', 'displayLoginForm', View::MAINTAB );
      $view->displayLoginForm ($params );
    } else
      if ($request->method ( ) === 'POST' ) {
        $mailConf = new LibMailConnection_Information ( );
        $mailConf->username = $request->post ( 'imap_user', 'TEXT' );
        $mailConf->email = $request->post ( 'imap_user', 'TEXT' );
        $mailConf->password = $request->post ( 'imap_password', 'TEXT' );
        $_SESSION['imap_config'] = $mailConf;
        $_SESSION['imap_connector'] = LibMailConnector::createStandardConnector ($mailConf );

        $this->service_form ($request, $response );
      }
  }

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_mbox ($request, $response )
  {
    $mbox = $request->get ( 'mbox', 'TEXT' );
    $params = $this->getFlags ($request);

    $conf = $_SESSION['imap_config'];
    $oldMbox = $conf->currentMailbox;
    $conf->currentMailbox = $mbox;

    try {
      $con = LibMailConnector::createStandardConnector ($conf );
      $view = $response->loadView ( 'daidalos_mail-mbox', 'DaidalosMail', 'displayMailbox', View::AJAX );
      $view->setConnection ($con );
      $view->displayMailbox ($params );
    } catch ( Exception $e ) {
      $conf->currentMailbox = $oldMbox;
      throw $e;
    }
  }

  /**
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_displayMail ($request, $response )
  {
    $mailId = $request->get ( 'mid', 'INT' );
    $params = $this->getFlags ($request);

    $conf = $_SESSION['imap_config'];

    $con = LibMailConnector::createStandardConnector ($conf );
    $view = $response->loadView ( 'daidalos_mail-mbox', 'DaidalosMail', 'displayMail', View::AJAX );
    $view->setConnection ($con );
    $view->displayMail ($mailId );
  }
} // end class DaidalosMail_Controller


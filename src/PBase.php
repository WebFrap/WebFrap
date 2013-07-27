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
 * Base class for controller, model, module and view
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class Pbase
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de
   *  das acl objekt
   *
   * @var LibAclAdapter
   */
  public $acl = null;

  /**
   * @var LibAclContainer
   */
  public $access = null;

  /**
   * Die Haupt Datenbank Verbindung, wir gehen davon aus, das in der Regel nur
   * eine Datenbank Verbindung benötigt wird.
   * Wenn mehr als eine benötigt wird, muss per definition mindestes für eine
   * Davon ein Key vorliegen um diese identifizieren und ansprechen zu können.
   * @var LibDbConnection
   */
  public $db = null;

  /**
   * de:
   * Das Cache Objekt
   * @var LibCacheAdapter
   */
  public $cache = null;

  /**
   *
   * Enter description here ...
   * @var LibConf
   */
  public $conf = null;

  /**
   *
   * Enter description here ...
   * @var unknown_type
   */
  public $i18n = null;

  /**
   *
   * Enter description here ...
   * @var LibPhpRequest
   */
  public $request = null;

  /**
   *
   * Enter description here ...
   * @var Registry
   */
  public $registry = null;

  /**
   *
   * Enter description here ...
   * @var LibSessionPhp
   */
  public $session = null;

  /**
   * @notYetImplemented
   * @var Transaction
   */
  public $transaction = null;

  /**
   * de:
   * {
   *  das aktive User objekt.
   *  Enthält alle relevanten daten über en aktuell eingeloggten benutzer,
   *  vor allem die rowid aus seinen wbfsys_role_user datensatz
   * }
   * @var User
   */
  public $user = null;

  /**
   * Das Nachrichtensystem
   * @var LibMessagePool
   */
  public $message = null;

  /**
   * de:
   * {
   *  Objekt zum behandeln der Anfrage.
   *  Je nach interface (HTTP/CLI) wird hier die rückgabe der daten an den
   *  browser / client gehandelt
   * }
   * @var Response
   */
  public $response = null;

  /**
   * de:
   * {
   *   Das Hauptobjekt der Template Engine.
   *   Über tpl werden am Ende des request alle Templates und daten
   *   in alle vorhandenen, der templateengine zugewiesenen views gerendet
   *   und ausgegeben
   * }
   * @var LibTemplate
   */
  public $tpl = null;

  /**
   * @deprecated use $tpl
   * @var LibTemplate
   */
  public $tplEngine  = null;

  /**
   * de:
   * {
   *   Die aktive View.
   *   Das kann das Standard Template
   * }
   * @var LibTemplate
   */
  public $view = null;
  
  /**
   * Eine liste von Datenquellen / providern
   * @var []
   */
  public $providers = array();

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter PBase::$acl LibAclAdapter
   * @param LibAclAdapter $acl
   */
  public function setAcl($acl)
  {
    $this->acl = $acl;
  }//end public function setAcl */

  /**
   * @getter PBase::$acl LibAclAdapter
   * @return LibAclDb
   */
  public function getAcl()
  {

    if (!$this->acl)
      $this->acl = Acl::getActive();

    return $this->acl;
  }//end public function getAcl */

  /**
   *
   * @param LibAclContainer $access
   */
  public function setAccess($access)
  {

    $this->access = $access;

  }//end public function setAccess */

  /**
   * @return LibAclContainer
   */
  public function getAccess()
  {
    return $this->access;

  }//end public function getAccess */

  /**
   *
   * @param LibConf $conf
   */
  public function setConf($conf)
  {
    $this->conf = $conf;
  }//end public function setConf */

  /**
   *
   * @return LibConf
   */
  public function getConf()
  {

    if (!$this->conf)
      $this->conf = Conf::getActive();

    return $this->conf;
  }//end public function getConf */

  /**
   *
   * Enter description here ...
   * @param LibDb $db
   */
  public function setDb($db)
  {
    $this->db = $db;
  }//end public function setDb */

  /**
   * @return LibDbConnection
   */
  public function getDb()
  {

    if (!$this->db)
      $this->db = Db::getActive();

    return $this->db;
  }

  /**
   * @return LibDbOrm
   */
  public function getOrm()
  {

    if (!$this->db)
      $this->db = Db::getActive();

    return $this->db->getOrm();
  }

  /**
   * @param User $user
   */
  public function setUser($user)
  {
    $this->user = $user;
  }//end public function setUser */

  /**
   * @getter <User> public $user;
   * @return User
   */
  public function getUser()
  {
    if (!$this->user)
      $this->user = User::getActive();

    return $this->user;
  }//end public function getUser */

  /**
   * @setter <LibI18nPhp> public $i18n;
   * @param LibI18nPhp $i18n
   */
  public function setI18n($i18n)
  {
    $this->i18n = $i18n;
  }//end public function setI18n */

  /**
   * @getter <LibI18nPhp> public $i18n;
   * @return LibI18nPhp
   */
  public function getI18n()
  {
    if (!$this->i18n)
      $this->i18n = I18n::getActive();

    return $this->i18n;
  }//end public function getI18n */

  /**
   *
   * @param LibRequestPhp $request
   */
  public function setRequest($request)
  {
    $this->request = $request;
  }//end public function setRequest */

  /**
   *
   * @return LibRequestPhp
   */
  public function getRequest()
  {
    if (!$this->request)
      $this->request = Request::getActive();

    return $this->request;
  }//end public function getRequest */

  /**
   *
   * @param Response $response
   */
  public function setResponse($response)
  {
    $this->response = $response;
  }//end public function setResponse */

  /**
   *
   * @return Response
   */
  public function getResponse()
  {
    if (!$this->response)
      $this->response = Response::getActive();

    return $this->response;
  }//end public function getResponse */

  /**
   *
   * Enter description here ...
   * @param Registry $registry
   */
  public function setRegistry($registry)
  {
    $this->registry = $registry;
  }//end public function setRegistry */

  /**
   * @return Registry
   */
  public function getRegistry()
  {
    if (!$this->registry)
      $this->registry = Registry::getActive();

    return $this->registry;
  }//end public function getRegistry */

  /**
   *
   * Enter description here ...
   * @param LibSession $session
   */
  public function setSession($session)
  {
    $this->session = $session;
  }

  /**
   * @return LibSessionPhp
   */
  public function getSession()
  {
    if (!$this->session)
      $this->session = Session::getActive();

    return $this->session;
  }//end public function getSession */

  public function setCache($cache)
  {
    $this->cache = $cache;
  }

  /**
   * @return LibCacheAdapter
   */
  public function getCache()
  {

    if (!$this->cache)
      $this->cache = Cache::getActive();

    return $this->cache;

  }//end public function getCache

  /**
   * @notYetImplemented
   * @param Transaction $transaction
   */
  public function setTransaction($transaction)
  {
    $this->transaction = $transaction;
  }//end public function setTransaction

  /**
   * @notYetImplemented
   * @return Transaction
   */
  public function getTransaction()
  {

    if (!$this->transaction)
      $this->transaction = Transaction::getActive();

    return $this->transaction;

  }//end public function getTransaction

  /**
   *
   * @param LibTemplate $tplEngine
   */
  public function setTplEngine($tplEngine)
  {

    $this->tpl = $tplEngine;
    $this->tplEngine = $tplEngine;

  }//end public function setTplEngine

  /**
   * @return LibTemplate
   */
  public function getTplEngine()
  {

    if (!$this->tpl) {
      $this->tpl = View::engine();
      $this->tplEngine = $this->tpl;
    }

    return $this->tpl;

  }//end public function getTplEngine

  /**
   *
   * @param LibTemplate $tplEngine
   */
  public function setTpl($tplEngine)
  {

    $this->tpl = $tplEngine;
    $this->tplEngine = $tplEngine;

  }//end public function setTpl

  /**
   * @return LibTemplate
   */
  public function getTpl()
  {

    if (!$this->tpl) {
      $this->tpl = View::engine();
      $this->tplEngine = $this->tpl;
    }

    return $this->tpl;

  }//end public function getTpl

  /**
   *
   * @param LibTemplate $view
   */
  public function setView($view)
  {
    $this->view = $view;
  }//end public function setView

  /**
   * @return LibTemplate
   */
  public function getView()
  {

    if (!$this->view)
      $this->view = $this->getTplEngine();

    return $this->view;

  }//end public function getView

  /**
   * @param LibMessagePool $message
   */
  public function setMessage($message)
  {

    $this->message = $message;

  }//end public function setMessage */

  /**
   * @return LibMessagePool
   */
  public function getMessage()
  {

    if (!$this->message)
      $this->message = Message::getActive();

    return $this->message;

  }//end public function getMessage */
  
  /**
   * @return Provider
   */
  public function getProvider($key, $class = null)
  {
  
    if (!isset($this->providers[$key])){
      
      if(!$class)
        $class = $key;
      
      $cn = $class.'_Provider';

      if(!Webfrap::classExists($cn)){
        return null;
      }
      
      $this->providers[$key] = new $cn($this);
    }

    return $this->providers[$key];
  
  }//end public function getProvider */
  
  /**
   * @param string $key
   * @param Provider $obj
   */
  public function setProvider($key, $obj)
  {

    $this->providers[$key] = $obj;
  
  }//end public function getProvider */

}//end abstract class Pbase


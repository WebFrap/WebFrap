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
 * de:
 * Basis Klasse zum implementieren einer einfachen form der dependency Injection
 *
 * Es gibt noch eine 2te Basis Klasse mit nur Public Attributen PBase
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class Base
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  const DB = 'Db';

  const CACHE = 'Cache';

  const REQUEST = 'Request';

  const RESPONSE = 'Response';

  const USER = 'User';

  const ACL = 'Acl';

  const INFO = 'Info';

  const CONF = 'Conf';

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der aktive ACL Adapter
   * @var LibAclAdapter
   */
  protected $acl          = null;

  /**
   * Der dem Objekt zugewiesene Access Container
   * @var LibAclContainer
   */
  protected $access       = null;

  /**
   * Die Haupt Datenbank Verbindung, wir gehen davon aus, das in der Regel nur
   * eine Datenbank Verbindung benötigt wird.
   * Wenn mehr als eine benötigt wird, muss per definition mindestes für eine
   * Davon ein Key vorliegen um diese identifizieren und ansprechen zu können.
   * @var LibDbConnection
   */
  protected $db           = null;

  /**
   * Der Haupt Cache Adapter
   * Regel alle Caching Level
   * @var LibCacheAdapter
   */
  protected $cache        = null;

  /**
   * Das Standard Konfigurations Objekt
   * @var LibConf
   */
  protected $conf         = null;

  /**
   * Das Haupt Internationalisierungs Element
   * @var LibI18nPhp
   */
  protected $i18n         = null;

  /**
   * Das aktive Request Objekt mit dem der Aufruf des Scriptes / Services getriggert
   * wurde
   * @var LibRequestPhp
   */
  protected $request      = null;

  /**
   * Das Response Objekt, welches automatisch in den Kanal Schreib über welchen
   * auch der Aufruf kam
   * @var LibResponseHttp
   */
  public $response      = null;

  /**
   * @deprecated die Registry soll nichtmehr verwendet werden
   * @var Registry
   */
  protected $registry     = null;

  /**
   * Das Session Objekt
   * @var LibSessionPhp
   */
  protected $session      = null;

  /**
   * @notYetImplemented Kommt noch
   * @var Transaction
   */
  protected $transaction  = null;

  /**
   * Das Userobjekt mit den Informationen über den aktuell angemeldeten Benutzer
   * @var User
   */
  protected $user         = null;

  /**
   *
   * Enter description here ...
   * @var LibTemplate
   */
  protected $view         = null;

  /**
   *
   * Enter description here ...
   * @var Message
   */
  protected $message      = null;

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
  protected $tpl    = null;

  /**
   * @deprecated use $tpl
   * @var LibTemplate
   */
  protected $tplEngine    = null;


/*//////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibAclAdapter $acl
   */
  public function setAcl( $acl )
  {

    $this->acl = $acl;

  }//end public function setAcl */

  /**
   * @return LibAclAdapter
   */
  public function getAcl( )
  {

    if(!$this->acl)
      $this->acl = Acl::getActive();

    return $this->acl;

  }//end public function getAcl */

  /**
   *
   * @param LibAclContainer $access
   */
  public function setAccess( $access )
  {

    $this->access = $access;

  }//end public function setAccess */

  /**
   * @return LibAclContainer
   */
  public function getAccess( )
  {

    return $this->access;

  }//end public function getAccess */

  /**
   *
   * @param LibConf $conf
   */
  public function setConf( $conf )
  {

    $this->conf = $conf;

  }//end public function setConf */

  /**
   *
   * @return LibConf
   */
  public function getConf( )
  {

    if (!$this->conf )
      $this->conf = Conf::getActive();

    return $this->conf;

  }//end public function getConf */

  /**
   * @param LibDbConnection $db
   */
  public function setDb( $db )
  {

    $this->db = $db;

  }//end public function setDb */

  /**
   * @return LibDbConnection
   */
  public function getDb(  )
  {

    if(!$this->db)
      $this->db = Db::getActive();

    return $this->db;

  }//end public function getDb */

  /**
   * @return LibDbOrm
   */
  public function getOrm(  )
  {

    if(!$this->db)
      $this->db = Db::getActive();

    return $this->db->getOrm();

  }//end public function getOrm */

  /**
   * @param User $user
   */
  public function setUser( $user )
  {

    $this->user = $user;

  }//end public function setUser */

  /**
   * @return User
   */
  public function getUser(  )
  {

    if (!$this->user )
      $this->user = User::getActive();

    return $this->user;

  }//end public function getUser */

  /**
   *
   * Enter description here ...
   * @param LibI18nPhp $i18n
   */
  public function setI18n( $i18n )
  {

    $this->i18n = $i18n;

  }//end public function setI18n */

  /**
   * @return LibI18nPhp
   */
  public function getI18n(  )
  {

    if(!$this->i18n)
      $this->i18n = I18n::getDefault();

    return $this->i18n;

  }//end public function getI18n */

  /**
   *
   * @param LibRequestPhp $request
   */
  public function setRequest( $request )
  {

    $this->request = $request;

  }//end public function setRequest */

  /**
   *
   * @return LibRequestPhp
   */
  public function getRequest(  )
  {

    if(!$this->request)
      $this->request = Request::getActive();

    return $this->request;

  }//end public function getRequest */

  /**
   *
   * @param Response $response
   */
  public function setResponse( $response )
  {

    $this->response = $response;

  }//end public function setResponse */

  /**
   *
   * @return LibResponse
   */
  public function getResponse(  )
  {

    if(!$this->response)
      $this->response = Response::getActive();

    return $this->response;

  }//end public function getResponse */

  /**
   *
   * Enter description here ...
   * @param unknown_type $registry
   */
  public function setRegistry( $registry )
  {

    $this->registry = $registry;

  }

  /**
   * @return Registry
   */
  public function getRegistry(  )
  {

    if(!$this->registry)
      $this->registry = Registry::getActive();

    return $this->registry;

  }//end public function getRegistry */

/*//////////////////////////////////////////////////////////////////////////////
// Session
//////////////////////////////////////////////////////////////////////////////*/

  public function setSession( $session )
  {
    $this->session = $session;
  }

  public function getSession(  )
  {
    if(!$this->session)
      $this->session = Session::getActive();

    return $this->session;
  }

/*//////////////////////////////////////////////////////////////////////////////
// Cache
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter Base::$cache LibCacheAdapter $cache
   * @param LibCacheAdapter $cache
   */
  public function setCache( $cache )
  {
    $this->cache = $cache;
  }//end public function setCache */

  /**
   * @getter Base::$cache LibCacheAdapter
   * @return LibCacheAdapter
   */
  public function getCache(  )
  {

    if(!$this->cache)
      $this->cache = Cache::getActive();

    return $this->cache;

  }//end public function getCache

  /**
   * @getter Base::$cache LibCacheAdapter
   * @return LibCacheAdapter
   */
  public function getL1Cache(  )
  {

    if(!$this->cache)
      $this->cache = Cache::getActive();

    return $this->cache->getLevel1();

  }//end public function getL1Cache

  /**
   * @getter Base::$cache LibCacheAdapter
   * @return LibCacheAdapter
   */
  public function getL2Cache(  )
  {

    if(!$this->cache)
      $this->cache = Cache::getActive();

    return $this->cache->getLevel2();

  }//end public function getL2Cache

/*//////////////////////////////////////////////////////////////////////////////
// Transaction
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @notYetImplemented
   * @param Transaction $transaction
   */
  public function setTransaction( $transaction )
  {
    $this->transaction = $transaction;
  }//end public function setTransaction

  /**
   * @notYetImplemented
   * @return Transaction
   */
  public function getTransaction(  )
  {
    if(!$this->transaction)
      $this->transaction = Transaction::getActive();

    return $this->transaction;
  }//end public function getTransaction

/*//////////////////////////////////////////////////////////////////////////////
// View / Template
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibTemplate $tplEngine
   */
  public function setTplEngine( $tplEngine )
  {

    $this->tpl = $tplEngine;
    $this->tplEngine = $tplEngine;

  }//end public function setTplEngine

  /**
   * @return LibTemplate
   */
  public function getTplEngine(  )
  {

    if(!$this->tpl)
    {
      $this->tpl = View::engine();
      $this->tplEngine = $this->tpl;
    }

    return $this->tpl;

  }//end public function getTplEngine

  /**
   *
   * @param LibTemplate $tplEngine
   */
  public function setTpl( $tplEngine )
  {

    $this->tpl = $tplEngine;
    $this->tplEngine = $tplEngine;

  }//end public function setTpl

  /**
   * @return LibTemplate
   */
  public function getTpl(  )
  {

    if(!$this->tpl)
    {
      $this->tpl = View::engine();
      $this->tplEngine = $this->tpl;
    }

    return $this->tpl;

  }//end public function getTpl

  /**
   *
   * @param LibTemplate $view
   */
  public function setView( $view )
  {
    $this->view = $view;
  }//end public function setView

  /**
   * @return LibTemplate
   */
  public function getView(  )
  {
    if(!$this->view)
      $this->view = $this->getTplEngine(  );

    return $this->view;
  }//end public function getView

/*//////////////////////////////////////////////////////////////////////////////
// message
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibMessagePool $message
   */
  public function setMessage( $message )
  {
    $this->message = $message;
  }//end public function setMessage

  /**
   * @return LibMessagePool
   */
  public function getMessage(  )
  {

    if(!$this->message)
      $this->message = Message::getActive();

    return $this->message;

  }//end public function getMessage

} // end abstract class Base



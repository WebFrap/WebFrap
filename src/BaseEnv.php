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
abstract class BaseEnv
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var Base
   */
  public $env = null;

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Ein Environment setzen
   * @param Base $env
   */
  public function setEnv($env)
  {
    $this->env = $env;
  }//end public function setEnv */

  /**
   *
   * @param LibAclAdapter $acl
   */
  public function setAcl($acl)
  {

    throw WebfrapSys_Exception('set acl is not applicable on BaseEnv');

  }//end public function setAcl */

  /**
   * @return LibAclAdapter_Db
   */
  public function getAcl()
  {

    return $this->env->getAcl();

  }//end public function getAcl */

  /**
   *
   * @param LibAclContainer $access
   */
  public function setAccess($access)
  {

    throw WebfrapSys_Exception('set access is not applicable on BaseEnv');

  }//end public function setAccess */

  /**
   * @return LibAclContainer
   */
  public function getAccess()
  {

    return $this->env->getAccess();

  }//end public function getAccess */

  /**
   *
   * @param LibConf $conf
   */
  public function setConf($conf)
  {

    throw WebfrapSys_Exception('set conf is not applicable on BaseEnv');

  }//end public function setConf */

  /**
   *
   * @return LibConf
   */
  public function getConf()
  {

    if (!$this->conf)
      $this->conf = $this->env->getConf();

    return $this->conf;

  }//end public function getConf */

  /**
   * @param LibDbConnection $db
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
      $this->db = $this->env->getDb();

    return $this->db;

  }//end public function getDb */

  /**
   * @return LibDbOrm
   */
  public function getOrm()
  {

    if (!$this->db)
      $this->db = $this->env->getDb();

    return $this->db->getOrm();

  }//end public function getOrm */

  /**
   * @param User $user
   */
  public function setUser($user)
  {

    $this->user = $user;

  }//end public function setUser */

  /**
   * @return User
   */
  public function getUser()
  {

    if (!$this->user) {
      $this->user = $this->env->getUser();
    }

    return $this->user;

  }//end public function getUser */

  /**
   *
   * Enter description here ...
   * @param LibI18nPhp $i18n
   */
  public function setI18n($i18n)
  {

    $this->i18n = $i18n;

  }//end public function setI18n */

  /**
   * @return LibI18nPhp
   */
  public function getI18n()
  {

    if (!$this->i18n)
      $this->i18n = $this->env->getI18n();

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
      $this->request = $this->env->getRequest();

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
   * @return LibResponseHttp
   */
  public function getResponse()
  {

    if (!$this->response)
      $this->response = $this->env->getResponse();

    return $this->response;

  }//end public function getResponse */

  /**
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
      $this->registry = $this->env->getRegistry();

    return $this->registry;

  }//end public function getRegistry */

/*//////////////////////////////////////////////////////////////////////////////
// Session
//////////////////////////////////////////////////////////////////////////////*/

  public function setSession($session)
  {
    $this->session = $session;
  }

  public function getSession()
  {
    if (!$this->session)
      $this->session = $this->env->getSession();

    return $this->session;
  }

/*//////////////////////////////////////////////////////////////////////////////
// Cache
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @setter Base::$cache LibCacheAdapter $cache
   * @param LibCacheAdapter $cache
   */
  public function setCache($cache)
  {
    $this->cache = $cache;
  }//end public function setCache */

  /**
   * @getter Base::$cache LibCacheAdapter
   * @return LibCacheAdapter
   */
  public function getCache()
  {

    if (!$this->cache)
      $this->cache = $this->env->getCache();

    return $this->cache;

  }//end public function getCache

  /**
   * @getter Base::$cache LibCacheAdapter
   * @return LibCacheAdapter
   */
  public function getL1Cache()
  {

    if ($this->cacheL1)
      return $this->cacheL1;

    if (!$this->cache)
      $this->cache = $this->env->getCache();

    $this->cacheL1 = $this->cache->getLevel1();

    return $this->cacheL1;

  }//end public function getL1Cache

  /**
   * @getter Base::$cache LibCacheAdapter
   * @return LibCacheAdapter
   */
  public function getL2Cache()
  {

    if ($this->cacheL2)
      return $this->cacheL2;

    if (!$this->cache)
      $this->cache = $this->env->getCache();

    $this->cacheL2 = $this->cache->getLevel2();

    return $this->cacheL2;

  }//end public function getL2Cache

  /**
   * @getter Base::$cache LibCacheAdapter
   * @return LibCacheAdapter
   */
  public function getL3Cache()
  {

    if ($this->cacheL3)
      return $this->cacheL3;

    if (!$this->cache)
      $this->cache = $this->env->getCache();

    $this->cacheL3 = $this->cache->getLevel3();

    return $this->cacheL3;

  }//end public function getL1Cache

  /**
   * @setter Base::$cache LibCacheAdapter $cache
   * @param LibCacheAdapter $cache
   */
  public function setL1Cache($cache)
  {
    $this->cacheL1 = $cache;
  }//end public function setL1Cache */

  /**
   * @setter Base::$cache LibCacheAdapter $cache
   * @param LibCacheAdapter $cache
   */
  public function setL2Cache($cache)
  {
    $this->cacheL2 = $cache;
  }//end public function setL1Cache */

  /**
   * @setter Base::$cache LibCacheAdapter $cache
   * @param LibCacheAdapter $cache
   */
  public function setL3Cache($cache)
  {
    $this->cacheL3 = $cache;
  }//end public function setL1Cache */

/*//////////////////////////////////////////////////////////////////////////////
// Transaction
//////////////////////////////////////////////////////////////////////////////*/

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
      $this->transaction = $this->env->getTransaction();

    return $this->transaction;
  }//end public function getTransaction

/*//////////////////////////////////////////////////////////////////////////////
// View / Template
//////////////////////////////////////////////////////////////////////////////*/

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
      $this->tpl = $this->env->getTplEngine();
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
      $this->tpl = $this->env->getTpl();
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
      $this->view = $this->env->getTpl();

    return $this->view;

  }//end public function getView

/*//////////////////////////////////////////////////////////////////////////////
// message
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param LibMessagePool $message
   */
  public function setMessage($message)
  {
    $this->message = $message;
  }//end public function setMessage

  /**
   * @return LibMessagePool
   */
  public function getMessage()
  {

    if (!$this->message)
      $this->message = $this->env->getMessage();

    return $this->message;

  }//end public function getMessage

  /**
   * @return Provider
   */
  public function getProvider($key, $class = null)
  {

    if (!isset($this->providers[$key])) {
      $this->providers[$key] = $this->env->getProvider($key, $class);
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

} // end abstract class BaseChild


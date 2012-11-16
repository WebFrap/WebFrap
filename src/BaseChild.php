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
abstract class BaseChild
{  
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der aktive ACL Adapter
   * @var LibAclAdapter_Db
   */
  public $acl          = null;
  
  /**
   * Der dem Objekt zugewiesene Access Container
   * @var LibAclContainer
   */
  public $access       = null;

  /**
   * Die Haupt Datenbank Verbindung, wir gehen davon aus, das in der Regel nur
   * eine Datenbank Verbindung benötigt wird.
   * Wenn mehr als eine benötigt wird, muss per definition mindestes für eine
   * Davon ein Key vorliegen um diese identifizieren und ansprechen zu können.
   * @var LibDbConnection
   */
  public $db           = null;

  /**
   * Der Haupt Cache Adapter
   * Regel alle Caching Level
   * @var LibCacheAdapter
   */
  public $cache        = null;

  /**
   * Das Standard Konfigurations Objekt
   * @var LibConf
   */
  public $conf         = null;

  /**
   * Das Haupt Internationalisierungs Element
   * @var LibI18nPhp
   */
  public $i18n         = null;

  /**
   * Das aktive Request Objekt mit dem der Aufruf des Scriptes / Services getriggert
   * wurde
   * @var LibRequestPhp
   */
  public $request      = null;

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
  public $registry     = null;

  /**
   * Das Session Objekt
   * @var LibSessionPhp
   */
  public $session      = null;

  /**
   * @notYetImplemented Kommt noch
   * @var Transaction
   */
  public $transaction  = null;

  /**
   * Das Userobjekt mit den Informationen über den aktuell angemeldeten Benutzer
   * @var User
   */
  public $user         = null;

  /**
   *
   * Enter description here ...
   * @var LibTemplate
   */
  public $view         = null;

  /**
   *
   * Enter description here ...
   * @var Message
   */
  public $message      = null;

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
  public $tpl    = null;

  /**
   * @deprecated use $tpl
   * @var LibTemplate
   */
  public $tplEngine    = null;


  /**
   * @var Base
   */
  public $env       = null;
  
  /**
   * @var TFlag
   */
  public $params       = null;
  
  
////////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Ein Environment setzen
   * @param Base $env
   */
  public function setEnv( $env )
  {
    $this->env = $env;
  }//end public function setEnv */

  /**
   *
   * @param LibAclAdapter $acl
   */
  public function setAcl( $acl )
  {

    $this->acl = $acl;

  }//end public function setAcl */

  /**
   * @return LibAclAdapter_Db
   */
  public function getAcl( )
  {

    if( !$this->acl )
      $this->acl = $this->env->getAcl();

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
    
    if( !$this->access )
      $this->access = $this->env->getAccess();
    
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

    if( !$this->conf )
      $this->conf = $this->env->getConf();

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

    if( !$this->db )
      $this->db = $this->env->getDb();

    return $this->db;

  }//end public function getDb */

  /**
   * @return LibDbOrm
   */
  public function getOrm(  )
  {

    if( !$this->db )
      $this->db = $this->env->getDb();

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

    if( !$this->user )
    {
      $this->user = $this->env->getUser();
    }

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

    if( !$this->i18n )
      $this->i18n = $this->env->getI18n();

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

    if( !$this->request )
      $this->request = $this->env->getRequest(); 

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
      $this->response = $this->env->getResponse(); 

    return $this->response;

  }//end public function getResponse */

  /**
   *
   * Enter description here ...
   * @param Registry $registry
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

    if( !$this->registry )
      $this->registry = $this->env->getRegistry(); 

    return $this->registry;

  }//end public function getRegistry */

////////////////////////////////////////////////////////////////////////////////
// Session
////////////////////////////////////////////////////////////////////////////////
  
  public function setSession( $session )
  {
    $this->session = $session;
  }

  public function getSession(  )
  {
    if(!$this->session)
      $this->session = $this->env->getSession(); 

    return $this->session;
  }

////////////////////////////////////////////////////////////////////////////////
// Cache
////////////////////////////////////////////////////////////////////////////////
  
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
      $this->cache = $this->env->getCache(); 

    return $this->cache;
    
  }//end public function getCache
  
////////////////////////////////////////////////////////////////////////////////
// Transaction
////////////////////////////////////////////////////////////////////////////////

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
      $this->transaction = $this->env->getTransaction(); 

    return $this->transaction;
  }//end public function getTransaction

////////////////////////////////////////////////////////////////////////////////
// View / Template
////////////////////////////////////////////////////////////////////////////////
  
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
      $this->tpl = $this->env->getTplEngine(); 
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
      $this->tpl = $this->env->getTpl();
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
    
    if( !$this->view )
      $this->view = $this->env->getTpl();

    return $this->view;
    
  }//end public function getView

////////////////////////////////////////////////////////////////////////////////
// message
////////////////////////////////////////////////////////////////////////////////

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
      $this->message = $this->env->getMessage();

    return $this->message;
    
  }//end public function getMessage

} // end abstract class BaseChild



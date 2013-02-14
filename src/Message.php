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
 * Das Messaging System
 * Statische Wrapperklasse für einen einfachen Zugriff auf den Messagepool
 *
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class Message
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Nachricht wird als Mail verschickt
   * @var string
   */
  const CHANNEL_MAIL = 'mail';

  /**
   * Es wird ein Neuer Task angelegt
   * @var string
   */
  const CHANNEL_TASK = 'task';

  /**
   * Die Nachricht wird als Wallmessage angelegt
   * @var string
   */
  const CHANNEL_WALL = 'wallmessage';

  /**
   * Console Channel, Nachricht wird in die Konsole ausgegeben
   * @var string
   */
  const CHANNEL_CONSOLE = 'console';

  /**
   * Die Nachricht wird an das Logsystem übergeben
   * @var string
   */
  const CHANNEL_LOG = 'log';

  /**
   * Es wird ein neuer Protokoll Eintrag erzeugt
   * @var string
   */
  const CHANNEL_PROTOCOL = 'protocol';

  /**
   * Die Nachricht wird in einen in der Nachricht näher spezifizierten
   * Kanal geschickt.
   *
   * Generic ist nicht kompatibel mit den anderen Kanälen, welche allesammt
   * parallel verwendet werden können, insofern das Sinn macht
   * @var string
   */
  const CHANNEL_GENERIC = 'generic';

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * singleton instance
   * @var LibMessagePool
   */
  protected static $instance   = null;

  /**
   * Init Methode für das Messaging System
   * Je nach Konfiguration wird eine spezifische Poolklasse geladen
   * um die Messages zu handeln
   *
   */
  public static function init()
  {
    
    if ( self::$instance )
      return;

    if ( defined( 'WBF_MESSAGE_ADAPTER' ) )
    {
      $className = 'LibMessage'.WBF_MESSAGE_ADAPTER;
      self::$instance = new $className();
    } else {
      self::$instance = new LibMessagePool();
    }

  }//end public static function init */

  /**
   * Interface für das Gateway Singleton
   *
   * @return LibMessagePool
   */
  public static function getInstance()
  {
    if (!self::$instance )
      self::init();

    return self::$instance;
  }//end public static function getInstance */
  
  /**
   * Interface für das Gateway Singleton
   *
   * @return LibMessagePool
   */
  public static function getActive()
  {
    
    if (!self::$instance )
      self::init();

    return self::$instance;
    
  }//end public static function getActive */
  

/*//////////////////////////////////////////////////////////////////////////////
// Messaging System
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Eine neue Fehlermeldung in einen Channel schreiben
   * @param string $error die fehlermeldung
   * @param string $channel der channel in den die meldung soll
   * @return void
   */
  public static function addI18nError($error, $channel = 'stdout' )
  {
    self::$instance->addError( I18n::s($error), $channel = 'stdout' );
  }//end public static function addI18nError */

  /**
   * Eine neue Fehlermeldung in einen Channel schreiben
   * @param string $error die fehlermeldung
   * @param string $channel der channel in den die meldung soll
   * @return void
   */
  public static function addError($error, $channel = 'stdout' )
  {
    self::$instance->addError($error, $channel = 'stdout' );
  }//end public static function addError */

  /**
   * löschen aller Fehlermeldungen im Channel
   * @param $channel name des Channels standard stdout
   * @return void
   */
  public static function resetErrors($channel = 'stdout' )
  {
    self::$instance->resetErrors($channel );
  }//end public static function resetErrors */

  /**
   * prüfen ob es Fehlermeldungen in einem bestimmten Channel gibt
   * @param $channel name des Channels standard stdout
   * @return boolean
   */
  public static function hasErrors($channel = 'stdout' )
  {
    return self::$instance->hasErrors($channel );
  }//end public static function hasErrors */

  /**
   * prüfen ob es Fehlermeldungen in einem bestimmten Channel gibt
   * @param $channel name des Channels standard stdout
   * @return boolean
   */
  public static function cleanErrors($channel = 'stdout' )
  {
    return self::$instance->cleanErrors($channel );
  }//end public static function cleanErrors */

  /**
   * alle Fehlermeldungen aus einem channel abfragen
   * @param $channel name des Channels standard stdout
   * @return array
   */
  public static function getErrors($channel = 'stdout' )
  {
    return self::$instance->getErrors($channel );
  }//end public static function getErrors */

  /**
   * eine Nachricht in einen Channels schreiben
   * @param $message die neue Nachricht
   * @param $channel name des Channels standard stdout
   * @return void
   */
  public static function addI18nMessage($message  , $channel = 'stdout' )
  {
    self::$instance->addMessage( I18n::s($message), $channel );
  }//end public static function addI18nMessage */

  /**
   * eine Nachricht in einen Channels schreiben
   * @param $message die neue Nachricht
   * @param $channel name des Channels standard stdout
   * @return void
   */
  public static function addMessage($message  , $channel = 'stdout' )
  {
    self::$instance->addMessage($message, $channel );
  }//end public static function addMessage */

  /**
   * Alle Nachrichten aus eine Channel entfernen
   * @param $channel name des Channels standard stdout
   * @return void
   */
  public static function resetMessages($channel = 'stdout' )
  {
    self::$instance->resetMessages($channel);
  }//end public static function resetMessages */


  /**
   * Fragen ob Nachrichten in einem Channel vorhanden sind
   * @param $channel name des Channels standard stdout
   * @return boolean
   */
  public static function hasMessages($channel = 'stdout')
  {
    return self::$instance->hasMessages($channel);
  }//end public static function hasMessages */

  /**
   * Alle Nachrichten aus einem Channel auslesen
   * @param $channel name des Channels standard stdout
   * @return array Array mit allen vorhandenen Nachrichten
   */
  public static function getMessages($channel = 'stdout')
  {
    return self::$instance->getMessages($channel);
  }//end public static function getMessages */

  /**
   * Eine neue Warnung in einen Chanel schreiben
   * @param $warning
   * @param $channel name des Channels standard stdout
   * @return void
   */
  public static function addI18nWarning($warning  , $channel = 'stdout' )
  {
    self::$instance->addWarning( I18n::s($warning) , $channel);
  }//end public static function addWarning */

  /**
   * Eine neue Warnung in einen Chanel schreiben
   * @param $warning
   * @param $channel name des Channels standard stdout
   * @return void
   */
  public static function addWarning($warning  , $channel = 'stdout' )
  {
    self::$instance->addWarning($warning, $channel);
  }//end public static function addWarning */

  /**
   * Alle Warnungen aus einem Channel löschen
   * @param $channel name des Channels standard stdout
   * @return void
   */
  public static function resetWarnings($channel = 'stdout' )
  {
    self::$instance->resetWarnings($channel);
  }//end public static function resetWarnings */

  /**
   * prüfen ob Warnungen in einem Bestimmten Channel vorhanden sind
   * @param $channel name des Channels standard stdout
   * @return boolean true wenn Warnungen vorhanden sind
   */
  public static function hasWarnings($channel = 'stdout')
  {
    return self::$instance->hasWarnings($channel);
  }//end public static function hasWarnings */

  /**
   * Alle vorhandenen Warnungen eines Channels erfragen
   * @param $channel name des Channels standard stdout
   * @return array alle vorhandenen Warnungen in einem Channel
   */
  public static function getWarnings($channel = 'stdout')
  {
    return self::$instance->getWarnings($channel);
  }//end public static function getWarnings */

} // end class Message

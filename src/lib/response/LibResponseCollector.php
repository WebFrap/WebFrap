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
 * Sammlet Nachrichten aus verschiedenen Quellen. Mögliche Typen sind allgemeine Nachrichten,
 * Warnungen, Fehler und ein Protokoll mit dem Nachrichten in einen Kontext, bzw. mit einer Entität
 * in Verbindung gebracht werden können.
 * 
 * @package WebFrap
 * @subpackage tech_core
 */
class LibResponseCollector extends LibResponse
{

  /**
   * Puffer für ankommende Nachrichten
   * @var array
   */
  public $message = array();

  /**
   * Puffer für ankommende Warnungen
   * @var array
   */
  public $warning = array();

  /**
   * Puffer für ankommende Fehler
   * @var array
   */
  public $error = array();

  /**
   * Puffer für alle Ereignisse die protokolliert werden
   * @var array
   */
  public $protocol = array();
  
  public $counter = 0;

  /**
   * Fügt eine neue Nachricht zu den Nachrichten hinzu
   * @param string $message
   */
  public function addMessage ($message)
  {
    $this->counter ++;
    $this->message[] = "Action " . $this->counter . " " . $message;
  }

  /**
   * Fügt eine neue Warnung zu den Warnungen hinzu
   * @param string $warning
   */
  public function addWarning ($warning)
  {
    $this->counter ++;
    $this->warning[] = "Action " . $this->counter . " " . $warning;
  }

  /**
   * Fügt einen neuen Fehler zu den Fehlern hinzu
   * @param string $error
   */
  public function addError ($error)
  {
    $this->counter ++;
    $this->error[] = "Action " . $this->counter . " " . $error;
  }

  /**
   * Globale Protokollierung der Nachrichten.
   * 
   * @param string $message
   * @param string $context
   * @param Entity $entity
   * @param string $mask
   */
  public function protocol ($message, $context, $entity = null, $mask = null)
  {

    $protocol = array(
        $message, 
        $context,
        $entity,
        $mask
    );
    
    $this->protocol[] = $protocol;
  }
}
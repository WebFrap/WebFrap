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
 * Basisklasse für System Nachrichten
 *
 * Diese Klasse enthält nur die nötigsten Information welche zum versenden
 * einer Nachricht benötigt werden.
 *
 * Alle andere Informationen sind direkt im Versandweg oder dem Message Provider
 * zu entnehmen
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessageEnvelop
{

  /**
   * Die Person welche die Nachricht geschickt hat
   *
   * @var WbfsysRoleUser_Entity
   */
  public $sender = null;

  /**
   * Die Adresse für den Empfänger, abhängig vom Channel type
   * @var string
   */
  public $receiver = null;

  /**
   * Das Subjekt der Nachricht
   * @var string
   */
  public $subject = null;

  /**
   * Pfad zum Master Template der Nachricht
   * @var string
   */
  public $htmlContent = null;

  /**
   * Pfad zum Template für die Nachricht
   * @var string
   */
  public $textContent = null;

  /**
   * PGP Keyfile wenn vorhanden
   * @var int
   */
  public $keyFile = null;

  /**
   * Stackid zum zusammenfassen einer Message
   * @var LibMessageStack $msgStack
   */
  public $stack = null;

/*//////////////////////////////////////////////////////////////////////////////
// Construct
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibMessageStack $msgStack
   */
  public function __construct( $msgStack )
  {

    $this->stack = $msgStack;

  }//end public function __construct */



} // end class LibMessageEnvelop


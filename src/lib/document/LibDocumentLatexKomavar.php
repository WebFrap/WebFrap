<?php
/*******************************************************************************
*
* @author      : Tobias Schmidt-Tudl <tobias.schmidt-tudl@webfrap.net>
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
 * Latex Komavar Container
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author Tobias Schmidt-Tudl <tobias.schmidt-tudl@webfrap.net>
 */
abstract class LibDocumentLatexKomavar
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Rücksendeadresse für Fensterbriefumschläge
   * @example 030-123-4568
   * @var string
   */
  public $backaddress = null;

  /**
   * Geschäftszeilenfeld »Kundennummer«
   *
   * @var string
   */
  public $customer = null;

  /**
   * Dokument Datum
   *
   * @var string
   */
  public $date = null;

  /**
   * Trennzeichen zwischen E-Mail-Bezeichner und E-Mail-Adresse
   *
   * @var string
   */
  public $emailseparator = null;

  /**
   * Trennzeichen zwischen Anlagetitel und Anlagen
   *
   * @var string
   */
  public $enclseparator = null;

  /**
   * Seitenfuß des Briefbogens
   *
   * @var string
   */
  public $firstfoot = null;

  /**
   * Kopf des Briefbogens
   *
   * @var string
   */
  public $firsthead = null;

  /**
   * Trennzeichen zwischen Faxbezeichner und Faxnummer
   *
   * @var string
   */
  public $faxseparator = null;

  /**
   * Absenderadresse ohne Absendername
   *
   * @var string
   */
  public $fromaddress = null;

  /**
   * Bankverbindung des Absenders
   *
   * @var string
   */
  public $frombank = null;

  /**
   * E-Mail-Adresse des Absenders
   *
   * @var string
   */
  public $fromemail = null;

  /**
   * Faxnummer des Absenders
   *
   * @var string
   */
  public $fromfax = null;

  /**
   * Anweisungen zum Setzen des Absenderlogos
   *
   * @var string
   */
  public $fromlogo = null;

  /**
   * vollständiger Absendername
   *
   * @var string
   */
  public $fromname = null;

  /**
   * Telefonnummer des Absenders
   *
   * @var string
   */
  public $fromphone = null;

  /**
   * eine URL des Absenders
   *
   * @var string
   */
  public $fromurl = null;

  /**
   * Postleitzahl des Absenders für den Port-Payé-Kopf bei addrfield=PP
   *
   * @var string
   */
  public $fromzipcode = null;

  /**
   * Geschäftszeilenfeld »Rechnungsnummer«
   *
   * @var string
   */
  public $invoice = null;

  /**
   * erweiterte Absenderangabe
   *
   * @var string
   */
  public $location = null;

  /**
   * Geschäftszeilenfeld »Mein Zeichen«
   *
   * @var string
   */
  public $myref = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Ausgabe der Komavar
   *
   * @param string $varName
   * @param string $defVaule
   * @return null
   */
  public function display($varName , $defVaule = null)
  {

    if (isset($this->{$varName}) && !is_null($this->{$varName})) {
      return '\\setkomavar{'.$varName.'}{'.$this->{$varName}.'}'.NL;
    } elseif (!is_null($defVaule)) {
      return '\\setkomavar{'.$varName.'}{'.$defVaule.'}'.NL;
    } else {
      return null;
    }

  }//end public function display */

} // end class LibDocumentLatexKomavar


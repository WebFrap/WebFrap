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
 * Basisklasse für Briefe / Geschäftsbriefe
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author Tobias Schmidt-Tudl <tobias.schmidt-tudl@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class LibDocumentLetter
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Absender des Briefes
   * @var LibDocumentContact
   */
  public $sender      = null;

  /**
   * Empfänger des Briefes
   * @var LibDocumentContact
   */
  public $reciever    = null;

  /**
   * Betreff des Briefes
   * @var string
   */
  public $subject    = null;

  /**
   * Das Datum des Briefes
   * @var string
   */
  public $date    = null;

}//end class LibDocumentLetter


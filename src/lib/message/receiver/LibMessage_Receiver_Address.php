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
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibMessage_Receiver_Address implements IReceiver
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * keys:
   * nickname:   Nickname
   * firstname: Vorname
   * lastname:   Nachname
   * titel:     Anrede
   *
   * @var array<key:value>
   */
  public $name = null;

  /**
   * @var array
   */
  public $address = null;

  /**
   * @var string
   */
  public $type = 'address';

  /**
   * @var array<IReceiver>
   */
  public $else = array();

/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string / array $name
   * @param array<string type: string address> $address
   */
  public function __construct($name, array $address)
  {

    if (is_string($name)) {
      $this->name = array('nickname' => $name);
    } elseif (is_array($name)) {
      $this->name = $name;
    }

    $this->address = $address;

  }//end public function __construct */

} // end LibMessage_Receiver_Address


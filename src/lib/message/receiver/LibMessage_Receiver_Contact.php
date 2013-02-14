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
class LibMessage_Receiver_Contact
  implements IReceiver 
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var WbfsysUserContact_Entity
   */
  public $contact = null;
  
  /**
   * @var id
   */
  public $id = null;
  
  /**
   * @var string
   */
  public $type = 'contact';
  
  /**
   * @var array<IReceiver>
   */
  public $else = array();

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param mixed $contact
   */
  public function __construct($contact )
  {
    
    if ( is_object($contact ) )
    {
      $this->contact = $contact;
    } else {
      $this->id = $contact;
    }
    
  }//end public function __construct */

} // end LibMessage_Receiver_Contact


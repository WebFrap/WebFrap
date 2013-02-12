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
 * This Class was generated with a Cartridge based on the WebFrap GenF Framework
 * This is the final Version of this class.
 * It's not expected that somebody change the Code via Hand.
 *
 * You are allowed to change this code, but be warned, that you'll loose
 * all guarantees that where given for this project, for ALL Modules that
 * somehow interact with this file.
 * To regain guarantees for the code please contact the developer for a code-review
 * and a change of the security-hash.
 *
 * The developer of this Code has checksums to proof the integrity of this file.
 * This is a security feature, to check if there where any malicious damages
 * from attackers against your installation.
 *
 *
 * @package WebFrap
 * @subpackage ModShop
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebRegister_Frontend_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enthält die IDs der Artikel welche im  Warenkorb gelandet sind
   * @var array
   */
  private $basket = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param Base $env
   */
  public function __construct( $env = null )
  {
    parent::__construct( $env );
    
    if( isset($_SESSION['shop_basket_data']) )
      $this->basket = $_SESSION['shop_basket_data'];
    else 
    {
      $this->basket = array();
      $_SESSION['shop_basket_data'] = array();
    }

  }//end public function __construct */
  
  /**
   * Einen neuen Artikel zum Warenkorb hinzufügen
   * @param int $artId
   * @param int $numArt
   */
  public function addArticle( $artId, $numArt = 1 )  
  {
    
    $this->basket[$artId] = $numArt;
    
  }//end public function addArticle */
  
  /**
   * Alle Artikel im Warenkorb updaten
   * @param array $articles
   */
  public function updateArticles( $articles )  
  {
    
    $this->basket = $articles;
    
  }//end public function addArticle */
  
  /**
   * Einen Artikel aus dem Warenkorb entfernen
   * @param int $artId
   */
  public function removeArticle( $artId )  
  {
    
    if( isset( $this->basket[$artId] ) )
      unset( $this->basket[$artId] );
    
  }//end public function removeArticle */
  
  /**
   * Speichern des Warenkorbs in der Session
   */
  public function save(  )  
  {
    
    $_SESSION['shop_basket_data'] = $this->basket;
    
  }//end public function save */


}//end class ShopBasket_Model


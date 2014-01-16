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
 * @package WebFrap
 * @subpackage taskplanner
 */
class EUserRelation
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Gehört zu uns
   * @var int
   */
  const INTERNAL = 1;
  
  /**
   * Gehört zu einerm unserer Partner
   * @var int
   */
  const PARTNER = 2;
  
  /**
   * Ist uns bekannt (z.B ein guter Kunde)
   * @var int
   */
  const CUSTOMER = 3;
  
  /**
   * Jemand der sich angemeldet hat (z.B ein Bewerber)
   * @var int
   */
  const EXTERN = 4;
  

/*//////////////////////////////////////////////////////////////////////////////
// Labels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::INTERNAL => 'Internal',
    self::PARTNER => 'Partner',
    self::CUSTOMER => 'Customer',
    self::EXTERN => 'Extern'
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : ''; // sollte nicht passieren, sowas vertrauen wir nicht

  }//end public static function label */


}//end class EUserRelation


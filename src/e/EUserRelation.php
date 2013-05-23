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
   * Account eines externen users dem wir allerdings trusten
   * @var int
   */
  const TRUSTED = 3;
  
  /**
   * Ist uns bekannt (z.B ein guter Kunde)
   * @var int
   */
  const KNOWN = 4;
  
  /**
   * Jemand der sich angemeldet hat (z.B ein Bewerber)
   * @var int
   */
  const EXTERN = 5;
  
  /**
   * Jemand der sich annonym angemeldet hat, z.B Forum, oder ein Spider Bot
   * @var int
   */
  const ANNON = 6;
  
  /**
   * Ein Account dessen User wir nicht trauen, den wir stark einschränken möchten
   * den wir aus welchen Gründen auch immer nicht sperren wollen / können
   * @var int
   */
  const UNTRUSTED = 7;

/*//////////////////////////////////////////////////////////////////////////////
// Labels
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public static $labels = array(
    self::INTERNAL     => 'Internal',
    self::PARTNER      => 'Partner',
    self::TRUSTED  => 'Trusted',
    self::KNOWN  => 'Known',
    self::EXTERN    => 'Extern',
    self::ANNON    => 'Annonym',
    self::UNTRUSTED    => 'Un trusted',
  );

  /**
   * @param string $key
   * @return string
   */
  public static function label($key)
  {
    
    return isset(self::$labels[$key])
      ? self::$labels[$key]
      : self::UNTRUSTED; // sollte nicht passieren, sowas vertrauen wir nicht

  }//end public static function label */


}//end class EUserRelation


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
 * Objekt zum generieren einer Inputbox
 * @package WebFrap
 * @subpackage tech_core
 */
class WgtInputPriority
  extends WgtSelectboxHardcoded
{

  /**
   * Keinen leere Eintrag erlauben
   * @var string
   */
  public $firstFree = null;

  /**
   * @param boolean
   */
  public $checkIcons = true;

  /**
   * Die Values
   * @var array
   */
  protected static $labels = array
  (
    //0   => 'Minor' ,
    10  => 'Very Low',
    20  => 'Low',
    30  => 'Normal',
    40  => 'High',
    50  => 'Very High',
    //60  => 'Max'
  );

  /**
   * @var array
   */
  public static $layouts = array
  (
    //60     =>  array( 'class' => '', 'name' => 'max' ),
    50     =>  array( 'class' => 'max', 'icon' => 'priority/max.png', 'bg' => '#FFC0C0' ),
    40     =>  array( 'class' => 'high', 'icon' => 'priority/high.png', 'bg' => '#FFDCA8' ),
    30     =>  array( 'class' => 'normal', 'icon' => 'priority/normal.png', 'bg' => '#E0F0FC' ),
    20     =>  array( 'class' => 'low', 'icon' => 'priority/low.png', 'bg' => '#FFFFC0' ),
    10     =>  array( 'class' => 'min', 'icon' => 'priority/min.png', 'bg' => '#D3FFD3' ),
    //0      =>  array( 'class' => '', 'value' => 'minor' ),
  );

  /**
   * Eine Klasse um die Semantic der selectbox zu beschreiben,
   * z.B. priority
   * Wird benötigt wenn zb Hintergrundbilder in die Options gelegt werden sollen
   * @var string
   */
  public $semanticClass = 'priority';

  /**
   * @var array
   */
  protected $data = array
  (
    //60     =>  array( 'value' => 'max' ),
    50     =>  array( 'value' => 'very high' ),
    40     =>  array( 'value' => 'high' ),
    30     =>  array( 'value' => 'normal', 'checked' => true ),
    20     =>  array( 'value' => 'low' ),
    10     =>  array( 'value' => 'very low' ),
    //0      =>  array( 'value' => 'minor' ),
  );

  /**
   * @param int $activ
   */
  public function setContent( $activ )
  {
    $this->activ = $activ;
  }//end public function setContent */

  /**
   *
   * Enter description here ...
   * @param string $key
   */
  public static function getKeyLabel( $key )
  {
    return isset( self::$labels[$key] ) ? self::$labels[$key]: 'No Prio defined';
  }//end public static function getKeyLabel */

  /**
   *
   * @param string $key
   */
  public static function getKeyIcon( $key )
  {
    return isset( self::$layouts[$key] ) ? self::$layouts[$key]['icon']: null;
  }//end public static function getKeyIcon */

  /**
   *
   * @param string $key
   */
  public static function getKeyBg( $key )
  {
    return isset( self::$layouts[$key] ) ? self::$layouts[$key]['bg']: null;
  }//end public static function getKeyBg */

} // end class WgtInputPriority

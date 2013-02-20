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
 * @subpackage tech_core
 */
class WgtLayout
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  public $webGw     = WEB_GW;

  /**
   *
   * @var string
   */
  public $webWgt    = WEB_WGT;

  /**
   *
   * @var string
   */
  public $webStyle  = WEB_THEME;

  /**
   *
   * @var string
   */
  public $pathImage  = null;

  /**
   *
   * @var string
   */
  public $pathIcon   = null;

  /**
   *
   * @var WgtColorscheme
   */
  public $color     = null;

  /**
   * default text size as int
   * @var int
   */
  public $textSize  = null;

  /**
   * the width of the page content
   * @var int
   */
  public $pageWidth  = null;

  /**
   * some variables
   * @var TArray
   */
  public $var  = null;

  /**
   *
   * @var array
   */
  protected $styles = array();

  /**
   *
   * @var string
   */
  protected $type   = null;

  /**
   *
   * @var array
   */
  protected $sizeFactor = array
  (
    'xxsmall'   => -3,
    'xsmall'    => -2,
    'smaller'   => -2,
    'small'     => -1,
    'medium'    => 1,
    'large'     => 2,
    'xlarge'    => 4,
    'xxlarge'   => 6,
  );

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $type
   */
  public function __construct($type )
  {
    $this->type = $type;
    $this->var  = new TArray();
  }//end public function __construct */

  /**
   * @param string $key
   */
  public function __get($key )
  {

    if (!isset($this->styles[$key] )) {
      $this->styles[$key] = new WgtStyle();
    }

    return $this->styles[$key];

  }//end public function __get */

  /**
   * @param string $key
   * @param WgtStyle $object
   */
  public function __set($key , $object )
  {

    if ( is_object($object) && $object instanceof WgtStyle )
      $this->styles[$key] = clone $object;

  }//end public function __get */

  /**
   * @param string $faktor
   */
  public function textSize($faktor = null )
  {

    if ($faktor )
      return $this->textSize + (isset($this->sizeFactor[$faktor])?$this->sizeFactor[$faktor]:1);

  }//end public function textSize */

} // end class WgtLayout


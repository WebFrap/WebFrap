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
 * class WgtMenu
 * abstract Factory class
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class WgtMenu
{

  /**
   * @var int
   */
  const ID      = 0;

  /**
   * @var int
   */
  const TYPE    = 1;

  /**
   * @var int
   */
  const TEXT    = 2;

  /**
   * @var int
   */
  const TITLE   = 3;

  /**
   * @var int
   */
  const ACTION  = 4;

  /**
   * @var int
   */
  const ICON    = 5;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the data array
   *
   * @var array
   */
  protected $data     = array();

  /**
   * is the menu already assembled
   *
   * @var boolean
   */
  protected $assembled   = false;

  /**
   *
   * @var string
   */
  protected $html     = null;

  /**
   * id of the Menu
   *
   * @var string
   */
  protected $name     = null;

  /**
   * id of the Menu
   *
   * @var string
   */
  protected $source   = null;

  /**
   * xml/html id of the menu
   *
   * @var string
   */
  protected $id       = null;

  /**
   *
   * @var boolean
   */
  public $refresh     = false;

  /**
   *
   * @var boolean
   */
  public $sort     = true;

  /**
   *
   * @var boolean
   */
  public $firstEntry  = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * constructor
   * @param string $name
   * @param string $source
   * @return string
   */
  public function __construct($name , $source = null )
  {
    $this->name = $name;

    if ($source)
      $this->source = $source;

    $this->id = 'wgt_menu_'.$name;

  }//end public function __construct */

  /**
   * the to string method
   *
   * @return string
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * setter for the menu id
   *
   * @param string $id
   */
  public function setId($id )
  {
    $this->menuId = $id;
  }//end public function setId */

  /**
   * @param array $data
   */
  public function setData($data )
  {
    $this->data = $data;
  }//end public function setData */

  /**
   * build the menu to html
   * @return string
   */
  public function toHtml()
  {
    if ($this->assembled) {
      return $this->html;
    } else {
      return $this->build( );
    }
  }//end public function toHtml */

  /**
   * set the number of Menupoints in one row
   * @param string $source
   * @param boolean $loadAll
   * @return void
   */
  public function setSource($source, $loadAll = false )
  {
    $this->source   = $source;
    $this->loadAll  = $loadAll;
  }//end public function setSource */

  /**
   * Enter description here...
   *
   */
  public function load( )
  {

    if (!$this->source )
      $name = $this->name;
    else
      $name = $this->source;

    foreach (Conf::$confPath as $path) {

      $menuPath = $path.'/menu/'.$name.'/';

      if (!file_exists($menuPath))
        continue;

      $folder = new LibFilesystemFolder($menuPath );

      $files = $folder->getFiles();

      Debug::console( 'files' , $files );

      foreach($files as $file )
        include $file->getName(true);

       // break after found data
       if (!$this->loadAll)
        break;
    }

  }//end public function load */

  /**
   * @return string
   */
  abstract public function build();

} // end class WgtMenu


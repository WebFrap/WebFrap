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
 * Data Access Object zum laden des Menüs aus den conf Dateien
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class DaoFoldermenu
  extends Dao
{
/*//////////////////////////////////////////////////////////////////////////////
//  Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der erste anzugeigenden Eintrag des Menüs
   * @var array
   */
  public $firstEntry  = null;

  /**
   * Einträge die als Ordner angezeigt werden, öffnen in der Regel ein neues
   * Menü
   * @var array
   */
  public $folders     = array();

  /**
   * Einträge die als Datei / Entity angezeigt werden, verweisen in der Regel
   * auf eine Maske
   * @var array
   */
  public $files       = array();

  /**
   * Crumbs für die Adresszeile im Menü
   * @var array
   */
  public $crumbs      = array();

  /**
   * @var array
   */
  public $sort        = true;

  /**
   * Das Viewobjekt in dem das Menü verwendet wird
   * @var array
   */
  public $view        = null;

  /**
   * @var string
   */
  public $interface   = 'maintab.php';

  /**
   * @var string
   */
  public $title   = null;
  
  /**
   * @var string
   */
  public $label   = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Static Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   * @var array
   */
  protected static $pool = array();


/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $files
   */
  public function __construct( $files, $interface = 'maintab.php' )
  {

    $this->interface = $interface;

    $this->view = View::getActive();

    $acl        = Acl::getActive();
    $view       = $this->view;
    $user       = User::getActive();

    $title = null;
    $label = null;
    
    foreach( $files as $file )
      include $file->getName( true );

    if( $title )
      $this->title = $title;
      
    if( $label )
      $this->label = $label;
      
  }//end public function __construct */

  /**
   * Zusammenführen von bereits geladenen und neuen menüdaten
   */
  public function merge( $data )
  {

    if( $data->firstEntry )
      $this->firstEntry = $data->firstEntry;

    if($data->folders)
    {
      $this->folders = array_merge( $this->folders, $data->folders );
    }

    if($data->files)
    {
      $this->files = array_merge( $this->files, $data->files );
    }

    if($data->crumbs)
    {
      $this->crumbs = $data->crumbs;
    }
    
    if( $data->title )
      $this->title = $data->title;
      
    if( $data->label )
      $this->label = $data->label;

  }//end public function merge */


/*//////////////////////////////////////////////////////////////////////////////
// Static Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param string $mapName
   * @param boolean $all
   * @return DaoFoldermenu
   */
  public static function get( $menuName, $all = false  )
  {

    if(DEBUG)
      Debug::console('menu name '.$menuName);

    if(isset(self::$pool[$menuName]))
      return self::$pool[$menuName];
    else
      return self::load($menuName, $all);

  }//end public static function get */

  /**
   *
   * @param string $menuName the search path for the menu entries
   * @param boolean $all should the system search in every conf folder or use the first menu it finds
   * @return array
   */
  public static function load( $menuName , $all = false )
  {

    //self::$pool[$menuName] = array();

    foreach( Conf::$confPath as $path )
    {

      $menuPath = $path.'/menu/'.$menuName.'/';

      if( !file_exists( $menuPath ) )
        continue;

      $folder   = new LibFilesystemFolder( $menuPath );
      $menuData = new DaoFoldermenu( $folder->getFiles() );

      if(DEBUG)
        Debug::console( 'load menu '.$menuName.' from '.$menuPath ,$menuData );

      if( isset( self::$pool[$menuName] ) )
        self::$pool[$menuName]->merge( $menuData );
      else
        self::$pool[$menuName] = $menuData ;

       // break after found data
       if( !$all )
        break;
    }

    return isset(self::$pool[$menuName])
      ? self::$pool[$menuName]
      : array();

  }//end public static function load */


}//end class DaoFoldermenu


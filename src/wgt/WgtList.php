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
 * de:
 * Die Basisklasse für alle listenenelemente
 *
 * @package WebFrap
 * @subpackage tech_core
 */
abstract class WgtList
  extends WgtAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @lang de:
   * Anzahl der Einträge die für das Paging angezeigt werden sollen
   * @var int
   */
  public $anzMenuNumbers  = 5;

  /**
   * the selected table size of showing number of entries.
   * don't need to match with the total number of shown entries
   * this var is used to set the number of entries menu correct
   * @var int
   */
  public $stepSize        = Wgt::LIST_SIZE_CHUNK;

  /**
   * die anzahl der einträge die sich in dem buildr befinden
   * @var int
   */
  public $dataSize        = null;

  /**
   * Variable wird bei Ajax Request benötigt
   * darin wird angegen ob neue Elemente erstellt werden sollen oder vorhanden
   * angepasst werden sollen
   *
   * @var boolean
   */
  public $insertMode      = true;

  /**
   * @lang de:
   * Appendmode sagt aus, dass Datensätze bei Ajax Requests nicht den Body
   * ersetzen sodern am Ende einfach angehängt werden
   *
   * @var boolean
   */
  public $appendMode      = false;

  /**
   * @var int
   */
  public $numOfColors     = 2;

  /**
   *
   * @var int
   */
  public $start           = 1;

  /**
   * the actions that should be shown in the table
   *
   * @var array
   */
  public $actions         = array() ;

  /**
   * the actions that should be shown in the table
   *
   * @var array
   */
  public $url             = array() ;

  /**
   * die id des forms das für das paging verwendet werden soll
   * @var string
   */
  public $searchForm      = null;

  /**
   * @lang de:
   * Die HTML Id des Formulars welches zum speichern für editable
   * Listelemente verwendet wird
   *
   * @var boolean
   */
  public $editForm        = false;

  /**
   * reference id, is used to adress ui elements in reference tabs
   * @var int
   */
  public $refId           = null;

  /**
   * is the actionmenu on the right side of the table enabled or not
   * @var boolean
   */
  public $enableNav       = true;


  /**
   * de:
   * Container mit den Zugriffsrechten
   *
   * @var LibAclPermission
   */
  public $access = null;
  
  /**
   * Das Konfigurationsobjekt
   * @var LibConfPhp
   */
  public $conf = null;

  /**
   * 
   * @var string
   */
  public $accessPath = null;
  
  /**
   * Liste mit Selecboxen die im Listenelement benötigt werden
   * @var array
   */
  public $selectboxes = array();

////////////////////////////////////////////////////////////////////////////////
// Protected Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der Datenbody der in der Liste gerendert werden soll
   * @var array
   */
  protected $data         = array();

  /**
   * data provider for reference data
   * @var LibSqlQuery
   */
  protected $refData      = null;

  /**
   * Array mit Buttons,
   * Werden pro Datensatz in der Navspalte angezeigt
   * 
   * @var string
   */
  protected $buttons  = array();

  /**
   * @var TArray
   */
  protected $params       = null;

////////////////////////////////////////////////////////////////////////////////
// builder attributes
////////////////////////////////////////////////////////////////////////////////


  /**
   * @lang de:
   * Panel Builder Objekt
   * Wie verwendet um ein Panel über dem Listenelement zu plazieren
   * Es genügt wenn das Objekt der übergeben wird buildable ist.
   *
   * @var WgtPanel
   */
  public $panel           = null;

  /**
   * @lang de:
   * Das Menu builder Objekt
   *
   * @var WgtMenuBuilder
   */
  public $menuBuilder  = null;

////////////////////////////////////////////////////////////////////////////////
// Magic methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * default constructor
   *
   * @param string $name the name of the wgt object
   */
  public function __construct( $name = null )
  {

    $this->name     = $name;
    $this->stepSize = Wgt::$defListSize;

  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param WbtMenuBuilder $menuBuilder
   */
  public function setMenuBuilder( $menuBuilder )
  {
    $this->menuBuilder = $menuBuilder;
  }//end public function setMenuBuilder */

  /**
   * Setter für das Panel Objekt
   * @param WgtPanel $panel
   */
  public function setPanel( $panel )
  {
    $this->panel = $panel;
  }//end public function setPanel */

  /**
   * @lang de:
   * Den Access Container für die Datenquellen bezogenene Reche übergeben
   *
   * @param LibAclContainer $access
   */
  public function setAccess( $access )
  {
    $this->access = $access;
  }//end public function setAccess */
  
  /**
   * @lang de:
   * Den Access Container für die Datenquellen bezogenene Reche übergeben
   *
   * @param LibConfPhp $conf
   */
  public function setConf( $conf )
  {
    $this->conf = $conf;
  }//end public function setConf */
  
  /**
   * @return LibConfPhp
   */
  public function getConf()
  {
    
    if( !$this->conf )
      $this->conf = Webfrap::$env->getConf();
      
    return $this->conf;
    
  }//end public function getConf */

  /**
   * @param TFlag $params
   * @param string $parentKey
   * @param string $nodeKey
   * @param string $nextKey
   */
  public function setAccessPath( $params, $parentKey, $nodeKey, $nextKey = null )
  {

    /*
      &amp;a_root=<?php
        echo \$VAR->params->aclRoot;
      ?>&amp;a_root_id=<?php
        echo \$VAR->params->aclRootId;
      ?>&amp;a_key=<?php
        echo \$VAR->params->aclParentKey;
      ?>&amp;a_level=<?php
        echo (1+\$VAR->params->aclLevel);
      ?>
     */

    $this->accessPath = "&amp;a_root={$params->aclRoot}"
      ."&amp;a_root_id={$params->aclRootId}"
      ."&amp;a_level=".$params->aclLevel
      ."&amp;a_key=".$parentKey
      .'&amp;a_node='.$nodeKey;

    if( $nextKey )
      $this->accessPath .= '&amp;a_next='.$nextKey;

  }//end public function setAccessPath */


  /**
   * @param int $anz
   */
  public function setMenuNumbers( $anz )
  {
    $this->anzMenuNumbers = $anz;
  }//end public function setMenuNumbers */

  /**
   * @param int $numOfColors
   */
  public function setNumOfColors( $numOfColors )
  {
    $this->numOfColors = $numOfColors;
  }//end  public function setNumOfColors */

  /**
   * @param int $stepSize
   */
  public function setStepSize( $stepSize )
  {
    $this->stepSize = $stepSize;
  }//end public function setStepSize */

  /**
   * @lang de:
   * Setzen der tatsächlichen anzahl datensätze in der Datenbank
   * bei größeren mengen werden nicht alle Datensätze angezeigt sondern nu
   * eine bestimmte auswahl
   * dataSize wird für ein Paging in den Datensätzen benötigt
   *
   * @param int $size
   */
  public function setSize( $size )
  {
    $this->dataSize = $size;
  }//end public function setSize */

  /**
   * @lang de:
   * Appendmode sagt aus, dass Datensätze bei Ajax Requests nicht den Body
   * ersetzen sodern am Ende einfach angehängt werden
   *
   * @param boolean $append
   * @return void
   */
  public function setAppendMode( $append )
  {

    if( $append )
      $this->insertMode = false;

    $this->appendMode = $append;

  }//end public function setAppendMode */

   /**
   * set a default anchor for the url
   * @param TArray $params
   */
  public function setParams( $params )
  {
    $this->params = $params;
  }//end public function setParams */


  /**
   * 
   * @param string $saveForm
   * @return void
   */
  public function setSaveForm( $saveForm )
  {

    $this->editForm = 'asgd-'.$saveForm;
    
  }//end public function setSaveForm */

  /**
   * @param string $refId
   */
  public function setRefId( $refId )
  {
    $this->refId = $refId;
  }//end public function setRefId */

   /**
   * set a default anchor for the url
   *
   * @param string $id
   * @return void
   */
  public function setId( $id )
  {
    $this->id = $id;
  }//end public function setId */

  /**
   * set a default anchor for the url
   *
   * @return int
   */
  public function getId( )
  {
    return $this->id;
  }//end public function getId */

  /**
   *
   * @param string $key
   * @param string $data
   * @return void
   */
  public function addUrl( $key , $data = null )
  {

    if( is_array( $key ) )
      $this->url = array_merge( $this->url, $key );

    else
      $this->url[$key] = $data;

  } // end function addUrl */
  
  /**
   *
   * @param string $key
   * @return string
   */
  public function getUrl( $key )
  {

    if( isset( $this->url[$key] ) )
      return $this->url[$key];
    else
      return null;

  } // end function getUrl */
  
  /**
   * Hinzufügen eines Selectbox Elements
   *
   * @param string $key
   * @param WgtSelectbox $selectbox
   * 
   * @return void
   */
  public function addSelectbox( $key , $selectbox )
  {

    $this->selectboxes[$key] = $selectbox;

  } // end function addSelectbox */

  /**
   * @param LibSqlQuery $refData
   * @return void
   */
  public function setRefData( $refData )
  {
    $this->refData = $refData;
  }//end public function setRefData */

  /**
   * set the table data
   * @param array $data
   * @param string $value
   * @return void
   */
  public function setData( $data , $value = null )
  {

    if( !$data )
      return;

    if( is_object( $data )   )
    {
      if( $data instanceof LibSqlQuery )
      {
        $this->data      = $data;
        $this->dataSize  = $data->getSourceSize();
        $this->refData   = $data;
      }
      elseif( $data instanceof Dao )
      {
        $this->data       = $data->getData();
        $this->dataSize   = count($this->data);
      }
      else
      {
        throw new Wgt_Exception
        (
          "Tried to add an invalid Datasource to a listelement ".get_class($data)
        );
      }
    }
    else if( is_array( $data ) and is_array( current( $data ) ) )
    {
      $this->data = $data;
    }
    else if( is_array( $data ) )
    {
      $this->data = array( $data );
    }
    else
    {
      throw new Wgt_Exception
      (
        "Tried to add an invalid Datasource to a listelement ".gettype($data)
      );
    }

  }//end public function setData */

  /**
   * 
   * @param array $row
   * @param mixed $value
   * @param boolean $multi
   * 
   * @return void
   */
  public function addData( $data, $value = null, $multi = true )
  {

    if( is_object($data) && $data instanceof LibSqlQuery )
    {
      $this->data       = array_merge( $this->data, $data->getAll() ) ;
      $this->dataSize  = $data->getSourceSize();
    }
    elseif( is_numeric($data) and is_array($value) )
    {
      $this->data[$data] =  $value;
    }
    elseif( is_array($data) and is_array( current( $data ) ) )
    {
      $this->data = array_merge( $this->data , $data );
    }
    elseif( is_array($data) )
    {
      if( $value )
        $this->data = array_merge($this->data,$data) ;

      else
        $this->data[] = $data;
    }
    else
    {
      return false;
    }

  } // end public function addData */

  /**
   * Anfragen der in der Tabelle anzuzeigenden Rohdaten
   * @return array
   */
  public function getData( )
  {
    return $this->data;
  } // end public function getData */

  /**
   *
   * @param string $action
   * @return void
   */
  public function setActions( $action )
  {
    $this->actions = $action;
  }//end public function setActions */

  /**
   *
   * @param string $action
   * @return void
   */
  public function addActions( $action )
  {
    if( is_array( $action ) )
      $this->actions = array_merge( $this->actions , $action );
      
  }//end public function setActions */

  /**
   *
   * @param string $formId
   * @return void
   */
  public function setPagingId( $formId )
  {
    $this->searchForm = $formId;
  }//end protected function setPagingId */

  /**
   * @return string
   */
  public function getPagingId(  )
  {
    return $this->searchForm;
  }//end protected function getPagingId */


/*//////////////////////////////////////////////////////////////////////////////
// rowmenu
//////////////////////////////////////////////////////////////////////////////*/
  
  
  /**
   * Laden des Menubuilders
   */
  protected function loadMenuBuilder()
  {
    
    $conf = $this->getConf();
    if( !$mType = $conf->getStatus( 'grid.controls' ) )
    {
      $mType = 'ButtonSet';
    }
    $classname = 'WgtMenuBuilder_'.$mType;
    
    $this->menuBuilder = new $classname( $this->view, $this->url, $this->actions );

    $this->menuBuilder->parentId    = $this->id;
    $this->menuBuilder->refId       = $this->refId;
    $this->menuBuilder->params      = $this->params;
    $this->menuBuilder->access      = $this->access;
    $this->menuBuilder->accessPath  = $this->accessPath;
    $this->menuBuilder->jsAccessPath  = str_replace( '&amp;', '&', $this->accessPath );
    
  }//end protected function loadMenuBuilder */
  
  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param string $id
   * @param array $row
   * @param string $value
   * @param function $accessFunc
   * 
   * @return string
   */
  public function getAccessPath( )
  {

    // wenn der builder noch nicht existiert erstellen wir hier einfach
    // schnell beim ersten aufruf ein default objekt
    if( !$this->menuBuilder )
      $this->loadMenuBuilder();

    return $this->menuBuilder->getAccessPath( );

  }//end public function getAccessPath */
  
  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param string $id
   * @param array $row
   * @param string $value
   * @param function $accessFunc
   * 
   * @return string
   */
  public function getJsAccessPath( )
  {

    // wenn der builder noch nicht existiert erstellen wir hier einfach
    // schnell beim ersten aufruf ein default objekt
    if( !$this->menuBuilder )
      $this->loadMenuBuilder();

    return $this->menuBuilder->getJsAccessPath( );

  }//end public function getJsAccessPath */


  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param string $id
   * @param array $row
   * @param string $value
   * @param function $accessFunc
   * 
   * @return string
   */
  public function rowMenu( $id, $row, $value = null, $accessFunc = null )
  {

    // wenn der builder noch nicht existiert erstellen wir hier einfach
    // schnell beim ersten aufruf ein default objekt
    if( !$this->menuBuilder )
      $this->loadMenuBuilder();
    
    if( !is_null($accessFunc) && !$accessFunc( $row, $id, $value, $this->access ) )
      return null;

    return $this->menuBuilder->buildRowMenu( $row, $id, $value );

  }//end public function rowMenu */
  
  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param string $id
   * @param array $row
   * @param string $value
   * @param function $accessFunc
   * 
   * @return string
   */
  public function getActionUrl( $id, $row )
  {

    // wenn der builder noch nicht existiert erstellen wir hier einfach
    // schnell beim ersten aufruf ein default objekt
    if( !$this->menuBuilder )
      $this->loadMenuBuilder();

    return $this->menuBuilder->getActionUrl( $id, $row );

  }//end public function getActionUrl */
  
  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param string $id
   * @param array $row
   * @param string $value
   * @param function $accessFunc
   * 
   * @return string
   */
  public function buildContextMenu( )
  {

    // wenn der builder noch nicht existiert erstellen wir hier einfach
    // schnell beim ersten aufruf ein default objekt
    if( !$this->menuBuilder )
      $this->loadMenuBuilder();

    return $this->menuBuilder->buildContextMenu(  );

  }//end public function buildContextMenu */
  
  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param string $id
   * @param array $row
   * @param string $value
   * @param function $accessFunc
   * 
   * @return string
   */
  public function getRowActions( $id, $row, $value = null, $accessFunc = null )
  {

    // wenn der builder noch nicht existiert erstellen wir hier einfach
    // schnell beim ersten aufruf ein default objekt
    if( !$this->menuBuilder )
      $this->loadMenuBuilder();
    
    if( !is_null($accessFunc) && !$accessFunc( $row, $id, $value, $this->access ) )
      return null;

    return $this->menuBuilder->getRowActions( $row, $id, $value );

  }//end public function getRowActions */
  
  
  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param string $id
   * @param array $row
   * @param string $value
   * @param function $accessFunc
   * 
   * @return string
   */
  public function hasEditRights( $row )
  {

    // prüfen ob zeilenbasierte rechte vorhanden sind
    if( isset( $row['acl-level']  ) )
    {

      if( $row['acl-level']  >=  Acl::UPDATE )
      {
        return true;
      }
      
    }
    // prüfen auf globale rechte
    elseif( $this->access  )
    {
      
      if( $this->access->level  >=  Acl::UPDATE )
      {
        return true;
      }
      
    }
    
    return false;
    
  }//end public function hasEditRights */
  
  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @return string
   */
  public function buildContextLogic( )
  {

    // wenn der builder noch nicht existiert erstellen wir hier einfach
    // schnell beim ersten aufruf ein default objekt
    if( !$this->menuBuilder )
      $this->loadMenuBuilder();

    return $this->menuBuilder->buildContextLogic( );

  }//end public function buildContextLogic */


  /**
   *
   * @param $id
   * @param $row
   * 
   * @return string
   * @deprecated
   */
  protected function buildActions( $id  , $value = null )
  {

    return $this->rowMenu($id,$value);

  }//end protected function buildActions */


  /**
   * @param string $key
   * @param string $buttonData
   */
  public function addButton( $key, $buttonData )
  {
    $this->buttons[$key] = $buttonData;
  }//end public function addButton */


  /**
   *
   * @return string
   */
  protected function buildButtons(  )
  {

    $html = '';

    foreach( $this->buttons as $button  )
    {

      if( is_object($button) )
      {
        
        $html .= $button->render().NL;
        
      }
      elseif( is_string($button) )
      {
        $html .= $button.NL;
      }
      else if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_URL )
      {
        $html .= Wgt::urlTag
        (
          $button[Wgt::BUTTON_ACTION],
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ),
          array(
            'class'=> $button[Wgt::BUTTON_PROP],
            'title'=> $this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N])
          )
        ).NL;
      }
      else if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET )
      {
        $html .= Wgt::urlTag
        (
          $button[Wgt::BUTTON_ACTION],
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ),
          array(
            'class'=> $button[Wgt::BUTTON_PROP],
            'title'=> $this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N])
          )
        ).NL;
      }
      else if(  $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET )
      {

        $url = $button[Wgt::BUTTON_ACTION];

        $html .= '<button '
          .' onclick="$R.get(\''.$url.'\');return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
            Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
          .'</button>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      }
      else if(  $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS )
      {

        $html .= '<button '
          .' onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'"  '
          .' title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'
            .Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).$button[Wgt::BUTTON_LABEL]
          .'</button>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      }
      else if(  $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP )
      {
        $html .= '&nbsp;|&nbsp;';
      }
      else
      {
        $html .= '<button onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" class="'.$button[Wgt::BUTTON_PROP].'" title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).'</button>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    }

    return $html;

  }//end protected function buildButtons */

  /**
   * method for creating custom buttons
   * @param array $buttons
   * @param array $actions
   * @param string $id
   * @param string $value
   * @param function $accessFunc
   */
  protected function buildCustomButtons
  ( 
    $buttons, 
    $actions, 
    $id         = null, 
    $value      = null,
    $accessFunc = null,
    $row = array()
  )
  {
    
    if( !is_null($accessFunc) && !$accessFunc( array(), $id, $value, $this->access ) )
      return null;

    $html = '';

    foreach( $actions as $action )
    {
      if( isset($buttons[$action]) )
        $html .= $this->buildButton( $buttons[$action], $id, $value, $accessFunc );
    }

    return $html;

  }//end protected function buildCustomButtons */

  /**
   * @param array $button
   * @param string $id
   * @param string $value
   * @param function $accessFunc
   * @return string
   */
  protected function buildButton( $button, $id = null, $value = null, $accessFunc = null )
  {
    
    if( !is_null($accessFunc) && !$accessFunc( array(), $id, $value, $this->access ) )
      return null;

    $html = '';

    if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET )
    {
      $html .= Wgt::urlTag
      (
        $button[Wgt::BUTTON_ACTION].$id.'&amp;target_id='.$this->id.($this->refId?'&amp;refid='.$this->refId:null),
        Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ),
        array(
          'class'=> $button[Wgt::BUTTON_PROP],
          'title'=> $this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N])
        )
      );
    }
    else if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_DELETE )
    {

      $url = $button[Wgt::BUTTON_ACTION].$id.'&amp;target_id='.$this->id.($this->refId?'&amp;refid='.$this->refId:null);

      $html .= '<button '
        .' onclick="$R.del(\''.$url.'\',{confirm:\'Please confirm to delete this entry.\'});return false;" '
        .' class="'.$button[Wgt::BUTTON_PROP].'" '
        .' title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
        .'</button>'; //' '.$button[Wgt::BUTTON_LABEL].

    }
    else if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET )
    {

      $url = $button[Wgt::BUTTON_ACTION].$id.'&amp;target_id='.$this->id.($this->refId?'&amp;refid='.$this->refId:null);
    
      $confirm = '';
      if( isset( $button[Wgt::BUTTON_CONFIRM] ) )
      {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }
      
      $html .= '<button '
        .' onclick="$R.get(\''.$url.'\''.$confirm.');return false;" '
        .' class="'.$button[Wgt::BUTTON_PROP].'" '
        .' title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
        .'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].

    }
    else if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS )
    {

      //$url = .$id.'&amp;target_id='.$this->id.($this->refId?'&amp;refid='.$this->refId:null);
      //$button[Wgt::BUTTON_ACTION]
      // $S(this).parentX(\'table\').parent().data(\''.$button[Wgt::BUTTON_ACTION].'\')

      if( $id )
      {
        
        $onClick = str_replace( array( '{$parentId}', '{$id}' ), array( $this->refId, $id ),  $button[Wgt::BUTTON_ACTION] );
        
        $html .= '<button onclick="'.$onClick.';return false;" class="'.$button[Wgt::BUTTON_PROP].'" title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      }
      else
      {
        
        $onClick = str_replace( array( '{$parentId}' ), array( $this->refId ),  $button[Wgt::BUTTON_ACTION] );
        
        $html .= '<button onclick="'.$onClick.';return false;" class="'.$button[Wgt::BUTTON_PROP].'" title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    }
    else if(  $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_CHECKBOX )
    {
      $html .= '<input class="wgt-no-save" value="'.$id.'" />';
    }
    else if(  $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP )
    {
      $html .= '&nbsp;|&nbsp;';
    }
    else
    {
      
      if( $id )
      {
        
        $onClick = str_replace( array( '{$parentId}', '{$id}' ), array( $this->refId, $id ),  $button[Wgt::BUTTON_ACTION] );
        
        $html .= '<button onclick="'.$onClick.';return false;" class="'.$button[Wgt::BUTTON_PROP].'" title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      }
      else
      {
        
        $onClick = str_replace( array( '{$parentId}' ), array( $this->refId ),  $button[Wgt::BUTTON_ACTION] );
        
        $html .= '<button onclick="'.$onClick.';return false;" class="'.$button[Wgt::BUTTON_PROP].'" title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      }

      $html .= '<button  '
        .' onclick="'.$onClick.';return false;" '
        .' class="'.$button[Wgt::BUTTON_PROP].'" '
        .' title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).' '.$button[Wgt::BUTTON_LABEL]
        .'</button>';
    }


    return $html;

  }//end protected function buildButton */
  
////////////////////////////////////////////////////////////////////////////////
// load methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * laden der urls + actions
   */
  public function loadUrl()
  {
    
  }//end public function loadUrl */
  
////////////////////////////////////////////////////////////////////////////////
// Table Navigation
////////////////////////////////////////////////////////////////////////////////

  /**
   * Methode zum render des Itemspezifschen JavaScripts
   * 
   * Durch dieses Methode wird sicher gestellt, dass das JavaScript immer am
   * Ende des Markups steht. 
   * @see http://developer.yahoo.com/performance/rules.html#js_bottom
   * 
   * Des weiteren sollte hier nur Code stehen, welcher sich schwer auslagern lässt
   * Kommentare sind auserhalb des Javascripts im PHP Code abzulegen, so dass
   * kein unnötiger Content ausgeliefert wird
   * 
   * @return string
   */
  protected function buildJavascript()
  {
    return '';
  }//end protected function buildJavascript */


  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjaxArea()
   */
  public function buildAjaxArea()
  {

    $this->refresh = true;

    if($this->xml)
      return $this->xml;

    if( $this->appendMode )
    {
      $html = '<htmlArea selector="#'.$this->id.'-table>tbody" action="append" ><![CDATA[';
      $html .= $this->build();
      $html .= ']]></htmlArea>'.NL;
    }
    else
    {
      $html = '<htmlArea selector="#'.$this->id.'-table>tbody" action="replace" ><![CDATA[';
      $html .= $this->build();
      $html .= ']]></htmlArea>'.NL;
    }

    $this->xml = $html;

    return $html;

  }//end public function buildAjaxArea */


}//end class WgtList


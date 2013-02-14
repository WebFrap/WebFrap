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
class WgtSubPanel
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $buttons = null;
  
  /**
   * @var string
   */
  public $rightButtons = null;

  /**
   * @var BaseChild
   */
  public $env = null;

  /**
   * Container mit den Rechten
   * @var LibAclPermission
   */
  public $access = null;
  
  /**
   * Sub Panel
   * @var array
   */
  public $subPannel = array();
  
  /**
   * @var string
   */
  public $formId = null;
  
  /**
   * @var string
   */
  public $searchKey = null;
  
  /**
   * Der Status des Filters
   * @var TFlag
   */
  public $filterStatus = null;
  
  public $numFilterActive = null;
  
  public $numFilter = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param BaseChild $env
   */
  public function __construct( $env )
  {
    $this->env = $env;
  }//end public function __construct */
  
/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibI18nPhp
   */
  public function getI18n()
  {
    return $this->env->getI18n();
  }//end public function getI18n */
  
  /**
   * @return User
   */
  public function getUser()
  {
    return $this->env->getUser();
  }//end public function getUser */
  
  /**
   * @return LibDbConnection
   */
  public function getDb()
  {
    return $this->env->getDb();

  }//end public function getDb */
  
  /**
   * @return LibAclAdapter
   */
  public function getAcl()
  {
    return $this->env->getAcl();

  }//end public function getAcl */
  
  /**
   * @param LibAclPermission $access
   */
  public function setAccess( $access )
  {
    
    $this->access = $access;
    
  }//public function setAccess  */

  
  /**
   * @param string $formId
   */
  public function setSearchForm( $formId )
  {
    
    $this->formId = $formId;
    
  }//public function setSearchForm  */
  
  /**
   * 
   * @param TFlag $filterStatus
   */
  public function setFilterStatus( $filterStatus )
  {
    
    $this->filterStatus = $filterStatus;
    
  }//public function setSearchForm  */
  
  /**
   * @lang de:
   *
   * Hinzufügen eines Buttons
   * First add, first display
   *
   * @param string $key
   * @param array $buttonData
   * {
   *   0 => int, Button Type @see Wgt:: ACTION Constantes
   *   1 => string, Label des Buttons
   *   2 => string, URL oder Javascript Code, je nach Button Type
   *   3 => string, Icon
   *   4 => string, css classes ( optional )
   *   5 => string, i18n key für das label ( optional )
   *   6 => int,  das benötigtes zugriffslevel @see Acl::$accessLevels
   *   7 => int,  maximales zugriffslevel @see Acl::$accessLevels
   * }
   *
   */
  public function addControl( $key, $controllData )
  {
    
    $this->buttons[$key] = $controllData;
    
  }//end public function addControl */
  
  /**
   * @lang de:
   *
   * Hinzufügen eines Buttons auf der rechten seite
   * First add, first display
   *
   * @param string $key
   * @param array $buttonData
   * {
   *   0 => int, Button Type @see Wgt:: ACTION Constantes
   *   1 => string, Label des Buttons
   *   2 => string, URL oder Javascript Code, je nach Button Type
   *   3 => string, Icon
   *   4 => string, css classes ( optional )
   *   5 => string, i18n key für das label ( optional )
   *   6 => int,  das benötigtes zugriffslevel @see Acl::$accessLevels
   *   7 => int,  maximales zugriffslevel @see Acl::$accessLevels
   * }
   *
   */
  public function addRightControl( $key, $controllData )
  {
    
    $this->rightButtons[$key] = $controllData;
    
  }//end public function addControl */
  
  /**
   * @param string $key
   * @param WgtSubPanel $subPanel
   */
  public function addSubPanel( $key, WgtSubPanel $subPanel )
  {
    
    $this->subPannel[$key] = $subPanel;
    
  }//end public function addSubPanel */

/*//////////////////////////////////////////////////////////////////////////////
// build method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function render()
  {

    $html = '';

    $html .= $this->panelButtons();

    return $html;

  }//end public function render */

  /**
   * @param string $key
   * @param string $value
   * 
   * @return boolean
   */
  public function display( $key, $value = null )
  {
    
    if( is_null($value) )
    {
      return isset( $this->display[$key] )
        ? $this->display[$key]
        : false;
    } else {
      $this->display[$key] = $value;
    }
    
  }//end public function display */
  
/*//////////////////////////////////////////////////////////////////////////////
// panel methodes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * @return string
   */
  public function panelButtons()
  {

    $html = '';

    if( $this->buttons || $this->rightButtons )
    {
      
      if( $this->buttons )
      {
        
        if( $this->rightButtons )
        {
          $html .= '<div class="wgt-panel" >';
          $html .= '<div class="left inner" >'.$this->buildButtons( $this->buttons ).'</div>';
          $html .= '<div class="right inner" >'.$this->buildButtons( $this->rightButtons ).'</div>';
          $html .= '</div>';
        }
        else 
        {
          $html .= '<div class="wgt-panel" >';
          $html .= $this->buildButtons();
          $html .= '</div>';
        }
      } else {
        $html .= '<div class="wgt-panel" >';
        $html .= '<div class="right inner" >'.$this->buildButtons( $this->rightButtons ).'</div>';
        $html .= '</div>';
      }
      

    }

    if( $this->subPannel )
    {
      foreach( $this->subPannel as $subPanel )
      {
        $html .= $subPanel->display();
      }
    }
    
    return $html;

  }//end public function panelButtons */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $name
   * @param string $alt
   * @param string $size
   * @return string
   */
  protected function icon( $name, $alt, $size = 'xsmall' )
  {
    return Wgt::icon( $name, $size, array('alt'=>$alt) );
    
  }//end public function icon */

  /**
   * render Methode zum erstellen der Panel buttons
   * @param array $buttons
   * @return string
   */
  protected function buildButtons( $buttons = null  )
  {

    $i18n = $this->getI18n();
    
    if( is_null( $buttons ) )
      $buttons = $this->buttons;

    $html = '';

    foreach( $buttons as $button  )
    {
      
      if( is_object($button) )
      {
        
        $html .= $button->render();
        
      }
      else if( $button[0] == Wgt::ACTION_AJAX_GET )
      {
        
        $html .= Wgt::urlTag
        (
          $button[2],
          Wgt::icon
          ( 
            $button[3] ,
            'xsmall', 
            $button[1] 
          ).' '.$button[1],
          array
          (
            'class'  => $button[4],
            'title'  => $i18n->l( $button[1], $button[5] )
          )
        );
      
      }
      else if(  $button[0] == Wgt::ACTION_BUTTON_GET )
      {

        $url = $button[2];

        $html .= '<button '
          .' onclick="$R.get(\''.$url.'\');return false;" '
          .' class="'.$button[4].'" '
          .' title="'.$i18n->l($button[1],$button[5]).'" >'
          .Wgt::icon( $button[3] ,'xsmall', $button[1] ).' '
          .$button[1].'</button>'; // ' '.$button[1].

      }
      else if(  $button[0] == Wgt::ACTION_JS )
      {

        $html .= '<button onclick="'.$button[2].';return false;" class="'.$button[4].'" title="'.$i18n->l($button[1],$button[5]).'" >'.
          Wgt::icon( $button[3] ,'xsmall', $button[1] )
          .' '.$button[1].'</button>'; // ' '.$button[1].

      }
      else
      {
        
        $html .= '<button onclick="'.$button[2].';return false;" '
          .' class="'.$button[4].'" '
          .' title="'.$i18n->l($button[1],$button[5]).'" >'
          .Wgt::icon( $button[3] ,'xsmall', $button[1] )
          .' '.$button[1].'</button>'; // ' '.$button[1].
      }

    }

    return $html;

  }//end protected function buildButtons */

} // end class WgtSubPanel



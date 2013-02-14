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
class WgtPanel
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $title = null;

  /**
   * @var string
   */
  public $buttons = null;

  /**
   * @var LibI18nPhp
   */
  public $i18n = null;

  /**
   * @var User
   */
  public $user = null;
  
  /**
   * @var LibAclAdapter
   */
  public $acl = null;
  
  /**
   * @var LibDbConnection
   */
  public $db = null;

  /**
   * flag mit display element
   * @var array
   */
  public $display = array();
  
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
  
/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibI18nPhp
   */
  public function getI18n()
  {
    
    if (!$this->i18n )
      $this->i18n = I18n::getActive();

    return $this->i18n;

  }//end public function getI18n */
  
  /**
   * @return User
   */
  public function getUser()
  {
    if (!$this->user )
      $this->user = User::getActive();

    return $this->user;

  }//end public function getUser */
  
  /**
   * @return LibDbConnection
   */
  public function getDb()
  {
    if (!$this->db )
      $this->db = Db::getActive();

    return $this->db;

  }//end public function getDb */
  
  /**
   * @return LibAclAdapter
   */
  public function getAcl()
  {
    if (!$this->acl )
      $this->acl = Acl::getActive();

    return $this->acl;

  }//end public function getAcl */
  
  /**
   * @param LibAclPermission $access
   */
  public function setAccess( $access )
  {
    
    $this->access = $access;
    
  }//public function setAccess  */

  /**
   *
   * @param string $title
   */
  public function setTitle( $title )
  {
    
    $this->title = $title;
    
  }//end public function setTitle */

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
  public function addButton( $key, $buttonData )
  {
    $this->buttons[$key] = $buttonData;
  }//end public function addButton */
  
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
   * @param string $key
   * @param WgtSubPanel $subPanel
   */
  public function addSubPanel( $key, WgtSubPanel $subPanel )
  {
    
    $this->subPannel[$key] = $subPanel;
    
  }//end public function addSubPanel */

  /**
   * @param string $key
   * @param string $subPanel
   */
  public function addSubPanelCode( $key, $subPanelCode )
  {
    
    $this->subPannel[$key] = $subPanelCode;
    
  }//end public function addSubPanelCode */

/*//////////////////////////////////////////////////////////////////////////////
// build method
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function build()
  {

    $html = '';

    $html .= $this->panelTitle();
    $html .= $this->panelButtons();

    return $html;

  }//end public function build */

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
  public function panelTitle()
  {

    $html = '';

    if( $this->title )
    {
      $html .= '<div class="wgt-panel title left" style="width:100%;" >';
      $html .= '<h2>'.$this->title.'</h2>';
      $html .= '</div>';
    }

    return $html;

  }//end public function panelTitle */


  /**
   * @return string
   */
  public function panelButtons()
  {

    $html = '';

    if( $this->buttons )
    {
      $html .= '<div class="wgt-panel left" style="width:100%;" >';
      $html .= $this->buildButtons();
      $html .= '</div>';
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
        
        $html .= '<div class="inline" style="margin-right:6px;">'.$button->render().'</div>'.NL;
        
      }
      elseif( is_string($button) )
      {
        $html .= '<div class="inline" style="margin-right:6px;">'.$button.'</div>'.NL;
      }
      else if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_URL )
      {
        
        $html .= '<div class="inline" style="margin-right:6px;padding-top:5px;">'.Wgt::urlTag
        (
          $button[Wgt::BUTTON_ACTION],
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).' '.$button[Wgt::BUTTON_LABEL],
          array(
            'class'  => $button[Wgt::BUTTON_PROP],
            'title'  => $i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]),
            'target' => '__new' 
          )
        ).'</div>'.NL;
        
      }
      else if( $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET )
      {
        
        $html .= '<div class="inline" style="margin-right:6px;">'.Wgt::urlTag
        (
          $button[Wgt::BUTTON_ACTION],
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).' '.$button[Wgt::BUTTON_LABEL],
          array(
            'class'=> $button[Wgt::BUTTON_PROP],
            'title'=> $i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N])
          )
        ).'</div>'.NL;
        
      }
      else if(  $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET )
      {

        $url = $button[Wgt::BUTTON_ACTION];

        $html .= '<div class="inline" style="margin-right:6px;"><button '
          .' onclick="$R.get(\''.$url.'\');return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'
          .Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).' '
          .$button[Wgt::BUTTON_LABEL].'</button></div>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      }
      else if(  $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS )
      {

        $html .= '<div class="inline" style="margin-right:6px;"><button onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" class="'.$button[Wgt::BUTTON_PROP].'" title="'.$i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
          .' '.$button[Wgt::BUTTON_LABEL].'</button></div>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      }
      else
      {
        
        $html .= '<div class="inline" style="margin-right:6px;"><button onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'
          .Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
          .' '.$button[Wgt::BUTTON_LABEL].'</button></div>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    }

    return $html;

  }//end protected function buildButtons */

} // end class WgtPanel



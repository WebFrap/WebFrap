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
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class WgtMenuBuilder
{

  /**
   * @lang de:
   * View Objekt wird benötigt für das i18n im menü
   * Da der WgtMenuBuilder ein Teil der View ist muss auch über das i18n
   * Objekt in der aktiven View internationalisiert werden
   *
   * @var LibTemplate
   */
  public $view = null;

  /**
   * Liste mit den Buttons die gerendert werden sollen
   * sowie die reihenfolge in welcher sie gerendert werden sollen
   * @var array
   */
  public $actions = array();

  /**
   * Liste mit allen vorhandenen Buttons
   * @var array
   */
  public $buttons = array();

  /**
   * @lang de:
   * Container mit den Zugriffsrechten
   *
   * @var LibAclPermission
   */
  public $access = null;

  /**
   * Url componente für den Access pfad
   * @var string
   */
  public $accessPath = null;

  /**
   * Url componente für den Access pfad
   * @var string
   */
  public $jsAccessPath = null;

  /**
   * Die HTML Id des Listenelements (table,treetable)
   * @var string
   */
  public $parentId = null;

  /**
   * Die Refid, wird benötigt wenn das Listenelement Eintäge in Relation
   * zu einem Gruppierungselement darstellt.
   * Auf deutsch alle tasks von Projekt X => refId = Project Id
   * @var int
   */
  public $refId    = null;

  /**
   * Flag ob die Labels mitgerendert werden sollen
   * @var boolean
   */
  public $renderLabel = false;

  /**
   * Die Controlflags
   * @var TFlag
   */
  public $params    = null;

  /**
   * @param LibTemplate $view
   * @param array $buttons
   * @param array $actions
   */
  public function __construct($view, $buttons = array(), $actions = array() )
  {

    $this->view = $view;

    if ($buttons )
     $this->buttons = $buttons;

    if ($actions )
     $this->actions = $actions;

  }//end public function __construct */

  /**
   * @param string $key der key über welchen der Button addresiert werden kann
   * @param array|string|WgtButton $buttonData der Button
   */
  public function addButton($key, $buttonData )
  {
    $this->buttons[$key] = $buttonData;
  }//end public function addButton */

  /**
   * @return string
   */
  public function getAccessPath()
  {
     return '&amp;target_id='.$this->parentId
      .$this->accessPath
      .($this->refId?'&amp;refid='.$this->refId:null);

  }//end public function getAccessPath */

  /**
   * @return string
   */
  public function getJsAccessPath()
  {
     return '&target_id='.$this->parentId
      .$this->jsAccessPath
      .($this->refId?'&refid='.$this->refId:null);

  }//end public function getJsAccessPath */

  /**
   * @param int $objid
   * @param array $row
   * @return string
   */
  public function getActionUrl($id, $row )
  {

    $urlExt = '&amp;target_id='.$this->parentId
      .$this->accessPath
      .($this->refId?'&amp;refid='.$this->refId:null);

    $actions = array( 'edit', 'show' );

    foreach ($actions as $action) {
      if (!isset($this->buttons[$action] ) )
        continue;

      $button = $this->buttons[$action];

      // prüfen ob dem Button eine Check Function mitgegeben wurde
      if ( isset($button[Wgt::BUTTON_CHECK] ) ) {
        if ( !$button[Wgt::BUTTON_CHECK]($row, $id, $value, $this->access ) ) {
          continue;
        }
      }

      // prüfen ob alle nötigen daten für die acls vorhanden sind
      if ( isset($button[Wgt::BUTTON_ACCESS]) ) {
        // prüfen ob zeilenbasierte rechte vorhanden sind
        if ( isset($row['acl-level']  ) ) {

          if ($row['acl-level']  <  $button[Wgt::BUTTON_ACCESS]) {
            continue;
          }
          if ( isset($button[Wgt::BUTTON_MAX_ACCESS]) && $row['acl-level'] >= $button[Wgt::BUTTON_MAX_ACCESS] ) {
            continue;
          }

          return $this->buttons[$action][2].$id.$urlExt;

        }
        // prüfen auf globale rechte
        elseif ($this->access) {

          if ($this->access->level  <  $button[Wgt::BUTTON_ACCESS]) {
            continue;
          }
          if ( isset($button[Wgt::BUTTON_MAX_ACCESS]) && $this->access->level >= $button[Wgt::BUTTON_MAX_ACCESS] ) {
            continue;
          }

          return $this->buttons[$action][2].$id.$urlExt;
        }
      } else {
        // ok keine rechte dann bauen wir das menü einfach so und gehen
        // davon aus, dass keine rechte benötigt werden oder die
        // beim setzen der actions schon geprüft wurden
        return $this->buttons[$action][2].$id.$urlExt;
      }

    }

    return null;

  }//end public function getActionUrl */

  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param array $row
   * @param string $id
   * @param string $value
   * @return string
   */
  public function buildRowMenu($row, $id = null, $value = null  )
  {
    $html = '';

    foreach ($this->actions as $action) {

      if ( isset($this->buttons[$action] ) ) {
        $button = $this->buttons[$action];

        // prüfen ob dem Button eine Check Function mitgegeben wurde
        if ( isset($button[Wgt::BUTTON_CHECK] ) ) {
          if ( !$button[Wgt::BUTTON_CHECK]($row, $id, $value, $this->access ) ) {
            continue;
          }
        }

        // prüfen ob alle nötigen daten für die acls vorhanden sind
        if ( isset($button[Wgt::BUTTON_ACCESS]) ) {
          // prüfen ob zeilenbasierte rechte vorhanden sind
          if ( isset($row['acl-level']  ) ) {

            if ($row['acl-level']  <  $button[Wgt::BUTTON_ACCESS]) {
              continue;
            }
            if ( isset($button[Wgt::BUTTON_MAX_ACCESS]) && $row['acl-level'] >= $button[Wgt::BUTTON_MAX_ACCESS] ) {
              continue;
            }

            $html .= $this->buildButton($button, $row, $id, $value );

          }
          // prüfen auf globale rechte
          elseif ($this->access) {

            if ($this->access->level  <  $button[Wgt::BUTTON_ACCESS]) {
              continue;
            }
            if ( isset($button[Wgt::BUTTON_MAX_ACCESS]) && $this->access->level >= $button[Wgt::BUTTON_MAX_ACCESS] ) {
              continue;
            }

            $html .= $this->buildButton($button, $row, $id, $value );
          } else {
            Debug::console( "NO ACCESS DATA! ".$action ) ;
          }
        } else {

          // ok keine rechte dann bauen wir das menü einfach so und gehen
          // davon aus, dass keine rechte benötigt werden oder die
          // beim setzen der actions schon geprüft wurden
          $html .= $this->buildButton($button, $row, $id, $value );
        }

      } else {
        Debug::console( "MISSING ACTION ".$action );
      }

    }

    return $html;

  }//end public function buildRowMenu */

  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @return string
   */
  public function buildContextMenu(  )
  {

    $html = '<ul id="'.$this->parentId.'-cmenu" class="wgt_context_menu" style="display:none;" >'.NL;

    foreach ($this->actions as $action) {

      if ( isset($this->buttons[$action] ) ) {
        $button = $this->buttons[$action];

        $html .= $this->renderContextEntry($action, $button );

      } else {
        Debug::console( "MISSING ACTION ".$action );
      }

    }

    $html .= '</ul>';

    return $html;

  }//end public function buildContextMenu */

  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @return string
   */
  public function buildContextLogic(  )
  {

    $entries = array();

    foreach ($this->actions as $action) {

      if ( isset($this->buttons[$action] ) ) {
        $button = $this->buttons[$action];

        if ($entry = $this->remderContextLogic($action, $button ) )
          $entries[] = $entry;

      } else {
        Debug::console( "MISSING ACTION ".$action );
      }

    }

    $htmlEntries = implode( ','.NL, $entries );

    $html = <<<HTML
      \$S('#{$this->parentId}-cmenu').data('wgt-context-action',{
        {$htmlEntries}
      });
HTML;

    return $html;

  }//end public function buildContextLogic */

  /**
   * @lang de:
   * Builder Methode für das Menü
   *
   * @param array $row
   * @param string $id
   * @param string $value
   * @return string
   */
  public function getRowActions($row, $id = null, $value = null  )
  {
    $actions = array();

    foreach ($this->actions as $action) {

      if ( isset($this->buttons[$action] ) ) {
        $button = $this->buttons[$action];

        // prüfen ob dem Button eine Check Function mitgegeben wurde
        if ( isset($button[Wgt::BUTTON_CHECK] ) ) {
          if ( !$button[Wgt::BUTTON_CHECK]($row, $id, $value, $this->access ) ) {
            continue;
          }
        }

        // prüfen ob alle nötigen daten für die acls vorhanden sind
        if ( isset($button[Wgt::BUTTON_ACCESS]) ) {
          // prüfen ob zeilenbasierte rechte vorhanden sind
          if ( isset($row['acl-level']  ) ) {

            if ($row['acl-level']  <  $button[Wgt::BUTTON_ACCESS]) {
              continue;
            }
            if ( isset($button[Wgt::BUTTON_MAX_ACCESS]) && $row['acl-level'] >= $button[Wgt::BUTTON_MAX_ACCESS] ) {
              continue;
            }

            $actions[] = $action;

          }
          // prüfen auf globale rechte
          elseif ($this->access) {

            if ($this->access->level  <  $button[Wgt::BUTTON_ACCESS]) {
              continue;
            }
            if ( isset($button[Wgt::BUTTON_MAX_ACCESS]) && $this->access->level >= $button[Wgt::BUTTON_MAX_ACCESS] ) {
              continue;
            }

            $actions[] = $action;
          } else {
            Debug::console( "NO ACCESS DATA! ".$action ) ;
          }
        } else {

          // ok keine rechte dann bauen wir das menü einfach so und gehen
          // davon aus, dass keine rechte benötigt werden oder die
          // beim setzen der actions schon geprüft wurden
          $actions[] = $action;
        }

      } else {
        Debug::console( "MISSING ACTION ".$action );
      }

    }

    return $actions;

  }//end public function getRowActions */

  /**
   *
   * @return string
   */
  protected function buildButtons(  )
  {

    $html = '';

    foreach ($this->buttons as $button) {


      if ( is_object($button) ) {

        $html .= $button->render().NL;

      } elseif ( is_string($button) ) {
        $html .= $button.NL;
      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET) {
        $html .= Wgt::urlTag
        (
          $button[Wgt::BUTTON_ACTION],
          Wgt::icon($button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ),
          array(
            'class'=> $button[Wgt::BUTTON_PROP],
            'title'=> $this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N])
          )
        ).NL;
      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_URL) {

        $url = $button[Wgt::BUTTON_ACTION];

        $html .= '<a '
          .' href="'.$url.'" '
          .' target="_blank" '
          .' class="wgt-button '.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
            Wgt::icon($button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
          .'</a>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET) {

        $url = $button[Wgt::BUTTON_ACTION];

        $confirm = '';
        if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
          $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
        }

        $html .= '<button '
          .' onclick="$R.get(\''.$url.'\''.$confirm.');return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
            Wgt::icon($button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
          .'</button>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS) {

        $html .= '<button '
          .' onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
            Wgt::icon
            (
              $button[Wgt::BUTTON_ICON],
              'xsmall',
              $button[Wgt::BUTTON_LABEL]
            ).$button[Wgt::BUTTON_LABEL]
          .'</button>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP) {
        $html .= '&nbsp;|&nbsp;';
      } else {

        $html .= '<button '
          .' onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
            Wgt::icon
            (
              $button[Wgt::BUTTON_ICON],
              'xsmall',
              $button[Wgt::BUTTON_LABEL]
            ).$button[Wgt::BUTTON_LABEL]
          .'</button>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    }

    return $html;

  }//end protected function buildButtons */

  /**
   * method for creating custom buttons
   * @param array $buttons
   * @param array $actions
   * @param int $id
   * @param int $value
   */
  public function buildCustomButtons
  (
    $buttons,
    $actions,
    $id = null,
    $value = null,
    $accessFunc = null,
    $row = array()
  )
  {

    $html = '';

    foreach ($actions as $action) {

      if (!isset($buttons[$action]) )
        continue;

      $button = $buttons[$action];

      // prüfen ob dem Button eine Check Function mitgegeben wurde
      if ( isset($button[Wgt::BUTTON_CHECK] ) ) {
        if ( !$button[Wgt::BUTTON_CHECK]($row, $id, $value, $this->params ) ) {
          continue;
        }
      }

      $html .= $this->buildButton($button, array(), $id, $value );
    }

    return $html;

  }//end public function buildCustomButtons */

  /**
   * @param array $button
   * @param array $row
   * @param int $id
   * @return string
   */
  public function buildButton($button, $row = array(), $id = null, $value = null, $addClass = null, $menuType = 'buttons' )
  {

    $html = '';

    $urlExt = '&amp;target_id='.$this->parentId
      .$this->accessPath
      .($this->refId?'&amp;refid='.$this->refId:null);

    if ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET) {

      $html .= Wgt::urlTag
      (
        $button[Wgt::BUTTON_ACTION].$id.$urlExt,
        Wgt::icon
        (
          $button[Wgt::BUTTON_ICON],
          'xsmall',
          $button[Wgt::BUTTON_LABEL]
        ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' ),
        array
        (
          'class'=> $button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ),
          'title'=> $this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          )
        )
      );

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_URL) {

      $html .= Wgt::urlTag
      (
        $button[Wgt::BUTTON_ACTION].$id,
        Wgt::icon
        (
          $button[Wgt::BUTTON_ICON],
          'xsmall',
          $button[Wgt::BUTTON_LABEL]
        ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' ),
        array
        (
          'class'  => 'wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ),
          'target' => '_blank',
          'title'  => $this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          )
        )
      );

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_DELETE) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = htmlentities($button[Wgt::BUTTON_CONFIRM]);
      } else {
        $confirm = 'Please confirm to delete this entry.';
      }

      $html .= '<button '
        .' onclick="$R.del(\''.$url.'\',{confirm:\''.$confirm.'\'});return false;" '
        .' class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' )
        .'</button>'; //' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $html .= '<button '
        .' onclick="$R.get(\''.$url.'\''.$confirm.');return false;" '
        .' class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' )
        .'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_POST) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $buttonParams = array();

      $bParams = isset($button[Wgt::BUTTON_PARAMS])
        ? $button[Wgt::BUTTON_PARAMS]
        : array();

      if ($bParams) {
        foreach ($bParams as $pName => $pValueKey) {
          $buttonParams[] = "'".$pName."':'".addslashes($row[$pValueKey])."'";
        }
        $bParamsBody = implode( ',', $buttonParams );
      } else {
        $bParamsBody = '';
      }

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $html .= '<button '
        .' onclick="$R.post(\''.$url.'\',{'.$bParamsBody.'}'.$confirm.');return false;" '
        .' class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' )
        .'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_PUT) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $buttonParams = array();

      $bParams = isset($button[Wgt::BUTTON_PARAMS])
        ? $button[Wgt::BUTTON_PARAMS]
        : array();

      if ($bParams) {
        foreach ($bParams as $pName => $pValueKey) {
          $buttonParams[] = "'".$pName."':'".addslashes($row[$pValueKey])."'";
        }
        $bParamsBody = implode( ',', $buttonParams );
      } else {
        $bParamsBody = '';
      }

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $html .= '<button '
        .' onclick="$R.put(\''.$url.'\',{'.$bParamsBody.'}'.$confirm.');return false;" '
        .' class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' )
        .'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS) {

      //$url = .$id.'&amp;target_id='.$this->parentId.($this->refId?'&amp;refid='.$this->refId:null);
      //$button[Wgt::BUTTON_ACTION]
      // $S(this).parentX(\'table\').parent().data(\''.$button[Wgt::BUTTON_ACTION].'\')

      $onClick = str_replace( array( '{$parentId}', '{$id}' ), array($this->parentId, $id ),  $button[Wgt::BUTTON_ACTION] );

      if ($id) {
        $html .= '<button '
          .'onclick="'.$onClick.';return false;" '
          .'class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
          .'title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon($button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      } else {
        $html .= '<button '
          .'onclick="'.$button[Wgt::BUTTON_ACTION].'();return false;" '
          .'class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
          .'title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_CHECKBOX) {
      $html .= '<input class="wgt-no-save" value="'.$id.'" />';
    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP) {

      if ( 'dropdown' == $menuType )
        $html .= '<li class="seperator" ></li>';
      else
        $html .= '&nbsp;|&nbsp;';

    } else {
      if ($id) {
        $html .= '<button  '
          .' onclick="'.$button[Wgt::BUTTON_ACTION]."('".$id."');".'" '
          .' class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
          .' title="'.$this->view->i18n->l
            (
              $button[Wgt::BUTTON_LABEL],
              $button[Wgt::BUTTON_I18N]
            ).'" >'.
            Wgt::icon
            (
              $button[Wgt::BUTTON_ICON],
              'xsmall',
              $button[Wgt::BUTTON_LABEL]
            ).' '.$button[Wgt::BUTTON_LABEL]
          .'</button>';
      } else {
        $html .= '<button  '
          .' onclick="'.$button[Wgt::BUTTON_ACTION]."();".'" '
          .' class="wgt-button '.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" tabindex="-1" '
          .' title="'.$this->view->i18n->l
            (
              $button[Wgt::BUTTON_LABEL],
              $button[Wgt::BUTTON_I18N]
            ).'" >'.
            Wgt::icon
            (
              $button[Wgt::BUTTON_ICON],
              'xsmall',
              $button[Wgt::BUTTON_LABEL]
            ).' '.$button[Wgt::BUTTON_LABEL]
          .'</button>';
      }
    }

    return $html;

  }//end public function buildButton */

  /**
   * @param string $action
   * @param array $button
   * @param array $row
   * @param int $id
   * @return string
   */
  public function renderContextAction($action, $button, $row = array(), $id = null, $value = null )
  {

    $html = '';

    $urlExt = '&amp;target_id='.$this->parentId
      .$this->accessPath
      .($this->refId?'&amp;refid='.$this->refId:null);

    if ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET) {

      $html .= Wgt::urlTag
      (
        $button[Wgt::BUTTON_ACTION].$id.$urlExt,
        Wgt::icon
        (
          $button[Wgt::BUTTON_ICON],
          'xsmall',
          $button[Wgt::BUTTON_LABEL]
        ),
        array
        (
          'class'=> $button[Wgt::BUTTON_PROP],
          'title'=> $this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          )
        )
      );

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_URL) {

      $html .= Wgt::urlTag
      (
        $button[Wgt::BUTTON_ACTION].$id,
        Wgt::icon
        (
          $button[Wgt::BUTTON_ICON],
          'xsmall',
          $button[Wgt::BUTTON_LABEL]
        ),
        array
        (
          'class'  => 'wgt-button '.$button[Wgt::BUTTON_PROP],
          'target' => '_blank',
          'title'  => $this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          )
        )
      );

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_DELETE) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = htmlentities($button[Wgt::BUTTON_CONFIRM]);
      } else {
        $confirm = 'Please confirm to delete this entry.';
      }

      $html .= '<button '
        .' onclick="$R.del(\''.$url.'\',{confirm:\''.$confirm.'\'});return false;" tabindex="-1" '
        .' class="'.$button[Wgt::BUTTON_PROP].'" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          )
        .'</button>'; //' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $html .= '<button '
        .' onclick="$R.get(\''.$url.'\''.$confirm.');return false;" tabindex="-1" '
        .' class="'.$button[Wgt::BUTTON_PROP].'" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          )
        .'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_POST) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $buttonParams = array();

      $bParams = isset($button[Wgt::BUTTON_PARAMS])
        ? $button[Wgt::BUTTON_PARAMS]
        : array();

      if ($bParams) {
        foreach ($bParams as $pName => $pValueKey) {
          $buttonParams[] = "'".$pName."':'".addslashes($row[$pValueKey])."'";
        }
        $bParamsBody = implode( ',', $buttonParams );
      } else {
        $bParamsBody = '';
      }

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $html .= '<button '
        .' onclick="$R.post(\''.$url.'\',{'.$bParamsBody.'}'.$confirm.');return false;" tabindex="-1" '
        .' class="'.$button[Wgt::BUTTON_PROP].'" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          )
        .'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_PUT) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $buttonParams = array();

      $bParams = isset($button[Wgt::BUTTON_PARAMS])
        ? $button[Wgt::BUTTON_PARAMS]
        : array();

      if ($bParams) {
        foreach ($bParams as $pName => $pValueKey) {
          $buttonParams[] = "'".$pName."':'".addslashes($row[$pValueKey])."'";
        }
        $bParamsBody = implode( ',', $buttonParams );
      } else {
        $bParamsBody = '';
      }

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $html .= '<button '
        .' onclick="$R.put(\''.$url.'\',{'.$bParamsBody.'}'.$confirm.');return false;" tabindex="-1" '
        .' class="'.$button[Wgt::BUTTON_PROP].'" '
        .' title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          )
        .'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS) {

      //$url = .$id.'&amp;target_id='.$this->parentId.($this->refId?'&amp;refid='.$this->refId:null);
      //$button[Wgt::BUTTON_ACTION]
      // $S(this).parentX(\'table\').parent().data(\''.$button[Wgt::BUTTON_ACTION].'\')

      $onClick = str_replace( array( '{$parentId}', '{$id}' ), array($this->parentId, $id ),  $button[Wgt::BUTTON_ACTION] );

      if ($id) {
        $html .= '<button '
          .'onclick="'.$onClick.';return false;" tabindex="-1" '
          .'class="'.$button[Wgt::BUTTON_PROP].'" '
          .'title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon($button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      } else {
        $html .= '<button '
          .'onclick="'.$button[Wgt::BUTTON_ACTION].'();return false;" tabindex="-1" '
          .'class="'.$button[Wgt::BUTTON_PROP].'" '
          .'title="'.$this->view->i18n->l
          (
            $button[Wgt::BUTTON_LABEL],
            $button[Wgt::BUTTON_I18N]
          ).'" >'.
          Wgt::icon
          (
            $button[Wgt::BUTTON_ICON],
            'xsmall',
            $button[Wgt::BUTTON_LABEL]
          ).'</button>'; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_CHECKBOX) {
      $html .= '<input class="wgt-no-save" value="'.$id.'" />';
    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP) {
      $html .= '&nbsp;|&nbsp;';
    } else {
      if ($id) {
        $html .= '<button  '
          .' onclick="'.$button[Wgt::BUTTON_ACTION]."('".$id."');".'" tabindex="-1" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$this->view->i18n->l
            (
              $button[Wgt::BUTTON_LABEL],
              $button[Wgt::BUTTON_I18N]
            ).'" >'.
            Wgt::icon
            (
              $button[Wgt::BUTTON_ICON],
              'xsmall',
              $button[Wgt::BUTTON_LABEL]
            ).' '.$button[Wgt::BUTTON_LABEL]
          .'</button>';
      } else {
        $html .= '<button  '
          .' onclick="'.$button[Wgt::BUTTON_ACTION]."();".'" tabindex="-1" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$this->view->i18n->l
            (
              $button[Wgt::BUTTON_LABEL],
              $button[Wgt::BUTTON_I18N]
            ).'" >'.
            Wgt::icon
            (
              $button[Wgt::BUTTON_ICON],
              'xsmall',
              $button[Wgt::BUTTON_LABEL]
            ).' '.$button[Wgt::BUTTON_LABEL]
          .'</button>';
      }
    }

    return $html;

  }//end public function buildButton */

  /**
   * @param string $action
   * @param array $button
   *
   * @return string
   */
  public function remderContextLogic($action, $button  )
  {

    $html = '';

    $urlExt = '&amp;target_id='.$this->parentId
      .$this->accessPath
      .($this->refId?'&amp;refid='.$this->refId:null);

    if
    (
      $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET
        || $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET
    )
    {

      // $button[Wgt::BUTTON_ACTION].$id.$urlExt,

      $html  = <<<HTML
      {$action}: function( el, pos, id ){
        \$R.get( '{$button[Wgt::BUTTON_ACTION]}'+id+'{$urlExt}' );

        return false;
      }
HTML;

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_URL) {

      $html  = <<<HTML
      {$action}: function( el, pos, id ){
        window.open( '{$button[Wgt::BUTTON_ACTION]}'+id, '_blank' );

        return false;
      }
HTML;

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_DELETE) {

      $url = $button[Wgt::BUTTON_ACTION]."'+id+'".$urlExt;

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = htmlentities($button[Wgt::BUTTON_CONFIRM]);
      } else {
        $confirm = 'Please confirm to delete this entry.';
      }

      $html  = <<<HTML
      {$action}: function( el, pos, id ){
        \$R.del('{$url}',{confirm:'{$confirm}'});

        return false;
      }
HTML;


    } else if
    (
      $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_POST
        || $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_PUT
    )
    {

      $url = $button[Wgt::BUTTON_ACTION]."'+id+'".$urlExt;

      $buttonParams = array();

      $bParams = isset($button[Wgt::BUTTON_PARAMS])
        ? $button[Wgt::BUTTON_PARAMS]
        : array();

      if ($bParams) {
        foreach ($bParams as $pName => $pValueKey) {
          $buttonParams[] = "'".$pName."':'{\${$pName}}'";
        }
        $bParamsBody = implode( ',', $buttonParams );
      } else {
        $bParamsBody = '';
      }

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $rqType = $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_PUT
        ? 'put'
        : 'post';

      $html  = <<<HTML
      {$action}: function( el, pos, id ){
        \$R.{$rqType}('{$url}',{$bParamsBody}{$confirm});

        return false;
      }
HTML;

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS) {

      $onClick = str_replace( array( '{$parentId}', '{$id}' ), array($this->parentId, "'+id+'" ),  $button[Wgt::BUTTON_ACTION] );

      $html  = <<<HTML
      {$action}: function( el, pos, id ) {$onClick};

        return false;
      }
HTML;

    } else if
    (
      $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_CHECKBOX
        || $button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP
    )
    {
      $html = null;
    } else {

      $onClick = str_replace( array( '{$parentId}', '{$id}' ), array($this->parentId, "'+id+'" ),  $button[Wgt::BUTTON_ACTION] );

      $html  = <<<HTML
      {$action}: function( el, pos, id ){ 
        {$onClick};
        return false;
      }
HTML;

    }

    return $html;

  }//end public function remderContextLogic */

  /**
   * @param string $action
   * @param array $button
   * @return string
   */
  public function renderContextEntry($action, $button )
  {

    if (Wgt::ACTION_SEP == $button[Wgt::BUTTON_TYPE]) {
      return '</ul><ul>'.NL;
    }

    if ( isset($button[Wgt::BUTTON_ICON]) ) {
      $icon = Wgt::icon
      (
        $button[Wgt::BUTTON_ICON],
        'xsmall',
        $button[Wgt::BUTTON_LABEL]
      );
    } else {
      $icon = '';
    }

    //class="wgt-bgi '.$action.'"
    return '<li>'.$icon.'<a href="#'.$action.'">'.$button[Wgt::BUTTON_LABEL].'</a></li>'.NL;

  }//end public function renderContextEntry */

}//end class WgtMenuBuilder

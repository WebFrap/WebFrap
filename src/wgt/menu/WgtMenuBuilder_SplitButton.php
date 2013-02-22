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
class WgtMenuBuilder_SplitButton extends WgtMenuBuilder
{

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

    $this->renderLabel = true;

    $first = true;

    $search = array
    (
      '&',
      '=',
      '+',
      '-',
      '.',
      ','
    );

    $replace = array
    (
      '-',
      '_',
      '_',
      '_',
      '_',
      '_'
    );

    // sicher stellen, dass das eine valide html id ist
    $menuId = $this->parentId.'-row-spbutton-'.preg_replace('/[^a-zA-Z0-9_-]/', '', $id );

    //$menuId  = $this->parentId.'-row-spbutton-'.str_replace($search, $replace, $id );

    $realActions = array();

    foreach ($this->actions as $action) {

      if ( isset($this->buttons[$action] ) ) {
        $button = $this->buttons[$action];

        // prüfen ob dem Button eine Check Function mitgegeben wurde
        if ( isset($button[Wgt::BUTTON_CHECK] ) ) {
          if (!$button[Wgt::BUTTON_CHECK]($row, $id, $value, $this->access ) ) {
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

            $realActions[] = $button;

          }
          // prüfen auf globale rechte
          elseif ($this->access) {

            if ($this->access->level  <  $button[Wgt::BUTTON_ACCESS]) {
              continue;
            }
            if ( isset($button[Wgt::BUTTON_MAX_ACCESS]) && $this->access->level >= $button[Wgt::BUTTON_MAX_ACCESS] ) {
              continue;
            }

            $realActions[] = $button;
          } else {
            Debug::console( "NO ACCESS DATA! ".$action ) ;
          }
        } else {

          $realActions[] = $button;
        }

      } else {
        Debug::console( "MISSING ACTION ".$action );
      }

    }

    if (!$realActions )
      return '';

    if ( 1 == count($realActions ) ) {
      return parent::buildButton( current($realActions), $row, $id, $value );
    }

    if ( is_array($row ) )
      $accessLevel = isset($row['acl-level'] ) ? $row['acl-level']: $this->access->level;
    else if ($this->access )
      $accessLevel = $this->access->level;
    else {
      $user = Webfrap::$env->getUser();

      $userLevel = $user->getLevel();

      if ($userLevel > User::LEVEL_L1_MANAGER )
        $accessLevel = Acl::ADMIN;
      elseif ($user->hasRole( 'developer' )  )
        $accessLevel = Acl::ADMIN;
      else
        $accessLevel = Acl::ACCESS;
    }

    $icon = 'icon-lock';

    if ($accessLevel >= Acl::ACCESS )
      $icon = 'icon-file';

    if ($accessLevel >= Acl::UPDATE )
      $icon = 'icon-wrench';

    if ($accessLevel >= Acl::DELETE )
      $icon = 'icon-cog';

    if ($accessLevel >= Acl::ADMIN )
      $icon = 'icon-star-empty';

    $html = '<div id="'.$menuId.'" class="wgt-grid_menu" >';
    $html .= '<button class="wcm wcm_control_dropmenu wgt-button ui-state-default" tabindex="-1" '
      .' id="'.$menuId.'-cntrl" '
      .' style="width:40px;" wgt_drop_box="'.$menuId.'-menu" >'
      .'<i class="'.$icon.'" ></i> <i class="icon-angle-down" ></i></button></div>
  <div class="wgt-dropdownbox al_right" id="'.$menuId.'-menu" >
    <ul>'.NL;

    foreach ($realActions as $button) {

      if ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP) {
        $html .= "</ul><ul>";
      } else {
        $html .= '<li>'.$this->buildButton($button, $row, $id, $value, null, 'dropdown' );

        if ( isset($button[Wgt::BUTTON_SUB] ) ) {
          $html .= $this->buildSubMenu($button[Wgt::BUTTON_SUB], $row, $id, $value );
        }
      }

      $html .= '</li>';

    }

    $html .= '</ul></div>';

    /*
      <ul>
        <li><a>test</a>
          <span>
            <ul>
              <li><a>sub 1</a></li>
              <li><a>sub 2</a></li>
              <li><a>sub 3</a>
                <span>
                  <ul>
                    <li><a>sub 3.1</a></li>
                    <li><a>sub 3.2</a></li>
                  </ul>
                </span>
              </li>
            </ul>
          </span>
        </li>
      </ul>
     */

    $html .= '<var id="'.$menuId.'-cntrl-cfg-dropmenu"  >{"align":"right","closeScroll":"true"}</var>';

    return $html;

    //"triggerEvent":"mouseover",

  }//end public function buildRowMenu */

  /**
   * @param array $subMenu
   * @return string
   */
  public function buildSubMenu($subMenu, $row, $id = null, $value = null )
  {

    $html = '<span><ul>';

    foreach ($subMenu as $button) {

      $html .= '<li>'.$this->buildButton($button, $row, $id, $value, null, 'dropdown' );

      if ( isset($button[Wgt::BUTTON_SUB] ) ) {
        $html .= $this->buildSubMenu($button[Wgt::BUTTON_SUB], $row, $id, $value );
      }

      $html .= '</li>';

    }

    $html .= '</ul></span>';

    return $html;

  }//end public function buildSubMenu */

  /**
   * @param array $button
   * @param array $row
   * @param int $id
   * @param string $value
   * @param string $addClass
   * @param string $menuType
   * @return string
   */
  public function buildButton
  (
    $button,
    $row = array(),
    $id = null,
    $value = null,
    $addClass = null,
    $menuType = 'buttons'
  ) {

    $html = '';

    $urlExt = '&amp;target_id='.$this->parentId
      .$this->accessPath
      .($this->refId?'&amp;refid='.$this->refId:null);

    if ( isset($button[Wgt::BUTTON_SUB] ) ) {
      if ($addClass )
        $addClass .= ' deeplink';
      else
        $addClass = 'deeplink';
    }

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
          'class'  => ''.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ),
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

      $html .= '<a '
        .' onclick="$R.del(\''.$url.'\',{confirm:\''.$confirm.'\'});return false;" '
        .' class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
        .'</a>'; //' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET) {

      $url = $button[Wgt::BUTTON_ACTION].$id.$urlExt;

      $confirm = '';
      if ( isset($button[Wgt::BUTTON_CONFIRM] ) ) {
        $confirm = ',{confirm:\''.htmlentities($button[Wgt::BUTTON_CONFIRM]).'\'}';
      }

      $html .= '<a '
        .' onclick="$R.get(\''.$url.'\''.$confirm.');return false;" '
        .' class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
        .'</a>'; // ' '.$button[Wgt::BUTTON_LABEL].

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

      $html .= '<a '
        .' onclick="$R.post(\''.$url.'\',{'.$bParamsBody.'}'.$confirm.');return false;" '
        .' class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
        .'</a>'; // ' '.$button[Wgt::BUTTON_LABEL].

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

      $html .= '<a '
        .' onclick="$R.put(\''.$url.'\',{'.$bParamsBody.'}'.$confirm.');return false;" '
        .' class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
        .'</a>'; // ' '.$button[Wgt::BUTTON_LABEL].

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS) {

      //$url = .$id.'&amp;target_id='.$this->parentId.($this->refId?'&amp;refid='.$this->refId:null);
      //$button[Wgt::BUTTON_ACTION]
      // $S(this).parentX(\'table\').parent().data(\''.$button[Wgt::BUTTON_ACTION].'\')

      $onClick = str_replace( array( '{$parentId}', '{$id}' ), array($this->parentId, $id ),  $button[Wgt::BUTTON_ACTION] );

      if ($id) {
        $html .= '<a '
          .'onclick="'.$onClick.';return false;" '
          .'class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
          .'title="'.$this->view->i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon($button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' ).'</a>'; // ' '.$button[Wgt::BUTTON_LABEL].
      } else {
        $html .= '<a '
          .'onclick="'.$button[Wgt::BUTTON_ACTION].'();return false;" '
          .'class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
          ).($this->renderLabel ? ' '.$button[Wgt::BUTTON_LABEL]:'' ).'</a>'; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_CHECKBOX) {
      $html .= '<input class="wgt-no-save" value="'.$id.'" />';
    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_SEP) {

      if ( 'dropdown' == $menuType )
        $html .= '</ul><ul>';
      else
        $html .= '&nbsp;|&nbsp;';

    } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JUST_LABEL) {
      $html .= '<a  '
        .' class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
        .'</a>';
    } else {
      if ($id) {
        $html .= '<a  '
          .' onclick="'.$button[Wgt::BUTTON_ACTION]."('".$id."');".'" '
          .' class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
          .'</a>';
      } else {
        $html .= '<a  '
          .' onclick="'.$button[Wgt::BUTTON_ACTION]."();".'" '
          .' class="'.$button[Wgt::BUTTON_PROP].($addClass? ' '.$addClass:'' ).'" '
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
          .'</a>';
      }
    }

    return $html;

  }//end public function buildButton */

}//end class WgtMenuBuilder_SplitButton


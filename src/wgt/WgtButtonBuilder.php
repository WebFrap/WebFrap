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
 * @subpackage wgt
 * @author dominik bonsch <dominik.bonsch@webfrap.net>
 */
class WgtButtonBuilder
{

  private static $default;

  /**
   *
   * Enter description here ...
   */
  public static function getDefault()
  {

    if( !self::$default )
      self::$default = new WgtButtonBuilder( );

    return self::$default;

  }//end public static function getDefault */

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
   * @param LibTemplate $view
   * @param array $buttons
   * @param array $actions
   */
  public function __construct(  )
  {

    $this->view = Webfrap::$env->getTpl();

  }//end public function __construct */

  /**
   * render Methode zum erstellen der Panel buttons
   * @param array $buttons
   * @return string
   */
  public function buildButtons( $buttons )
  {

    $i18n = $this->view->i18n;

    $html = '';

    foreach ($buttons as $button) {

      if ( is_object($button) ) {

        $html .= '<div class="inline" style="margin-right:6px;">'.$button->render().'</div>'.NL;
      } elseif ( is_string($button) ) {

        $html .= '<div class="inline" style="margin-right:6px;">'.$button.'</div>'.NL;
      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_URL) {

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

      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_AJAX_GET) {

        $html .= '<div class="inline" style="margin-right:6px;">'.Wgt::urlTag
        (
          $button[Wgt::BUTTON_ACTION],
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).' '.$button[Wgt::BUTTON_LABEL],
          array(
            'class'=> $button[Wgt::BUTTON_PROP],
            'title'=> $i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N])
          )
        ).'</div>'.NL;

      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_BUTTON_GET) {

        $url = $button[Wgt::BUTTON_ACTION];

        $html .= '<div class="inline" style="margin-right:6px;"><button '
          .' onclick="$R.get(\''.$url.'\');return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'
          .Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] ).' '
          .$button[Wgt::BUTTON_LABEL].'</button></div>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      } elseif ($button[Wgt::BUTTON_TYPE] == Wgt::ACTION_JS) {

        $html .= '<div class="inline" style="margin-right:6px;"><button onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" class="'.$button[Wgt::BUTTON_PROP].'" title="'.$i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'.
          Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
          .' '.$button[Wgt::BUTTON_LABEL].'</button></div>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].

      } else {

        $html .= '<div class="inline" style="margin-right:6px;"><button onclick="'.$button[Wgt::BUTTON_ACTION].';return false;" '
          .' class="'.$button[Wgt::BUTTON_PROP].'" '
          .' title="'.$i18n->l($button[Wgt::BUTTON_LABEL],$button[Wgt::BUTTON_I18N]).'" >'
          .Wgt::icon( $button[Wgt::BUTTON_ICON] ,'xsmall', $button[Wgt::BUTTON_LABEL] )
          .' '.$button[Wgt::BUTTON_LABEL].'</button></div>'.NL; // ' '.$button[Wgt::BUTTON_LABEL].
      }

    }

    return $html;

  }//end public function buildButtons */

}//end class WgtButtonBuilder

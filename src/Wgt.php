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
 * Kleine Klasse mit nützlichen Minifunktion zum erstellen von XHTML
 * sowie Container für Metadaten für das WGT PHP Backend
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class Wgt
{
/*//////////////////////////////////////////////////////////////////////////////
// Constantes
//////////////////////////////////////////////////////////////////////////////*/

  /*
  const ACTION_EDIT     = 'edit';

  const ACTION_CREATE   = 'create';

  const ACTION_DELETE   = 'delete';

  const ACTION_READ     = 'read';

  const ACTION_ADD      = 'add';
  */

/*//////////////////////////////////////////////////////////////////////////////
// Controller Element Actions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Dieses Element enthält Daten für eine Paging Aktion
   * @var int
   */
  const ACTION_PAGING     = 1;

  /**
   * Dieses Element führt on click javascript aus.
   * Das HTML Tag ist ein Button
   * @var int
   */
  const ACTION_JS         = 2;

  /**
   * Dieses Element ist eine normale URL, kein ajax request
   * @var int
   */
  const ACTION_URL        = 3;

  /**
   * Dieses Element ist ein normaler Link, der jedoch per Javascript
   * zu einem Ajax Request umgebaut wird.
   *
   * Wenn kein Javascript aktiviert ist wird ein normaler request geschickt
   *    *
   * @var int
   */
  const ACTION_AJAX_GET   = 4;

  /**
   * Dieses Controll Element ist eine Checkbox. Auf dieser Checkbox liegen
   * Standardmäßig keine Events, können jedoch bei bedarf hinzugefügt
   * werden
   *
   * @var int
   */
  const ACTION_CHECKBOX   = 5;

  /**
   * Der Link wird als GET Request onClick auf das Button Element gelegt
   * @var int
   */
  const ACTION_BUTTON_GET = 7;

  /**
   * @var int
   */
  const ACTION_DELETE = 8;

  /**
   * Separator button
   * @var int
   */
  const ACTION_SEP = 9;

  /**
   * Der Button schickt einen POST Request mit einem Databody
   * @var int
   */
  const ACTION_BUTTON_POST = 10;

  /**
   * Der Button schickt einen PUT Request mit einem Databody
   * @var int
   */
  const ACTION_BUTTON_PUT = 11;

  /**
   * Es wird eine Action mit dem gerade aktuellen id als Parameter
   * getriggert
   * @var int
   */
  const ACTION_TRIGGER = 12;

  /**
   * Ist ein Submenu
   * @var int
   */
  const ACTION_SUBMENU = 13;

  /**
   * Nur ein Label
   * @var int
   */
  const ACTION_JUST_LABEL = 14;

/*//////////////////////////////////////////////////////////////////////////////
// Menu Types
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * de:
   * type des buttons
   * @var int
   */
  const BUTTON_TYPE = 0;

  /**
   * de:
   * label des buttons
   * @var int
   */
  const BUTTON_LABEL = 1;

  /**
   * de:
   * die action, url, js, event oder was auch immer bestimmt was genau
   * der Button später machen soll
   * @var int
   */
  const BUTTON_ACTION = 2;

  /**
   * de:
   * Das Icon des Buttons
   * @var int
   */
  const BUTTON_ICON = 3;

  /**
   * de:
   * Button Properties, also Eigenschaften des Buttons in form von
   * CSS Klassen
   * @var int
   */
  const BUTTON_PROP = 4;

  /**
   * de:
   * I18N Repo der texte auf dem button
   * @var int
   */
  const BUTTON_I18N = 5;

  /**
   * de:
   * der Access Level der nötig ist im den button anzeigen zu lassen
   * @var int
   */
  const BUTTON_ACCESS = 6;

  /**
   * Der Maximal level der vorhanden sein darf, um den eintrag an zu zeigen
   * @var int
   */
  const BUTTON_MAX_ACCESS = 7;

  /**
   * Array mit den Parametern für einen Databody
   * @var int
   */
  const BUTTON_PARAMS = 8;

  /**
   * Array mit den Parametern für einen Databody
   * @var int
   */
  const BUTTON_CONFIRM = 9;

  /**
   * Eine annonyme Checkfunction
   * Gibt die Function true zurück wird der Button gerendert
   * sonst nicht
   * @var int
   */
  const BUTTON_CHECK = 10;

  /**
   * Position für Submenü Einträge
   * @var int
   */
  const BUTTON_SUB = 11;

/*//////////////////////////////////////////////////////////////////////////////
// Menu Types
//
// Types von Menu Buttons
//////////////////////////////////////////////////////////////////////////////*/

  const URL         = 1;

  const ACTION      = 2;

  const AJAX        = 3;

  const WINDOW      = 4;

  const SUB_WINDOW  = 5;

  const MAIN_WINDOW = 6;

  const MAIN_TAB    = 7;

  const MODAL       = 8;

/*//////////////////////////////////////////////////////////////////////////////
// Classes for WGT Replacements
//////////////////////////////////////////////////////////////////////////////*/

  const CLASS_PREFIX    = 'wgt_';

  const LIST_SIZE_CHUNK = 50;

/*//////////////////////////////////////////////////////////////////////////////
// Else
//////////////////////////////////////////////////////////////////////////////*/

  const XML_HEAD = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var array
   */
  public static $wgt = array();

  /**
   *
   * @var int
   */
  public static $defListSize = 50;

  /**
   *
   * @var int
   */
  public static $maxListSize = 500;

/*//////////////////////////////////////////////////////////////////////////////
// Tags and Items
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * ein beliebiges Iem erstellen
   *
   * @param string $type
   * @param string $subtype
   * @return WgtItemAbstract
   * @throws WgtItemNotFound_Exception if item not exists
   */
  public static function item($type  )
  {
    $className = 'Wgt'.ucfirst($type);

    if (!WebFrap::loadable($className) ) {
      Error::addError
      (
        'Class '.$className.' was not found',
        'WgtItemNotFound_Exception'
      );
    } else {
      return new $className($type);
    }

  }//end public static function item */

  /**
   * @author Celine Bonsch
   * @param string $name
   * @param string $size
   * @param array $attributes
   * @param string $class
   */
  public static function icon($name, $size = 'xsmall', $attributes = array(), $class = 'icon' )
  {
    
    // wenn es mit icon- anfängt und kein Punkt vorhanden ist, dann ist es sehr
    // sicher eine icon klasse und kein url auf ein icon, dass zumindest einen punkt
    // bei der endung haben sollte
    if( 'icon-' === substr($name, 5) && !strpos($name, '.') ){
      if (is_numeric($size)){
        return '<i class="'.$name.'" ></i>';
      } else {
        return '<i class="'.$name.' icon-'.str_replace( '.', '_', $size ).'x" ></i>';
      }
    }

    if ($attributes) {
      if ( is_array($attributes) ) {
        $attr = self::asmAttributes($attributes );
      } else {
        $attr = ' alt="'.$attributes.'" ';
      }
    } else {
      $attr = '';
    }

    $src  = View::$iconsWeb.$size.'/'.$name;
    $html = '<img src="'.$src.'" '.$attr.' class="'.$class.' '.$size.'" />';

    return $html;

  }//end public static function icon */

  /**
   * @author Celine Bonsch
   * @param string $name
   * @param string $size
   */
  public static function iconUrl($name, $size = 'xsmall' )
  {
    return View::$iconsWeb.$size.'/'.$name;;

  }//end public static function iconUrl */

  /**
   * @param string $src
   * @param array $attributes
   */
  public static function image($src , $attributes = array() , $tempPath = false )
  {
    if (!isset($attributes['alt'])) {
      $attributes['alt'] = 'nondescriped image';
    }

    if ($attributes) {
      $attr = self::asmAttributes($attributes );
    } else {
      $attr = '';
    }

    if ($tempPath )
      $src = View::$themeWeb.'images/'.$src;

    $html = '<img src="'.$src.'" '.$attr.' />'.NL;

    return $html;
  }//end public static function image */

  /**
   * @param string $src
   * @param array $attributes
   */
  public static function imageSrc($src  )
  {
    return  View::$themeWeb.'images/'.$src;
  }//end public static function imageSrc */

  /**
   *
   * @param $id
   * @param $path
   * @param $thumb
   * @param $attributes
   * @return unknown_type
   */
  public static function idImage($id, $path, $thumb = true, $attributes = array() )
  {

    $idPath = SParserString::getCachePath($id);

    if ($thumb )
      $thumb = '/thumb';

    else
      $thumb = '/picture';

    $src = $path.$thumb.$idPath.$id.'.jpg';

    if (!file_exists($src)) {
      $src = View::$themeWeb.'images/wgt/not_available.png';
      $attributes['alt'] = 'This is just a placeholder, cause there is no original pic';
    }

    if (!isset($attributes['alt']))
      $attributes['alt'] = 'nondescriped image';

    if ($attributes) {
      $attr = self::asmAttributes($attributes );
    } else {
      $attr = '';
    }

    return '<img src="'.$src.'" '.$attr.' />'.NL;

  }//end public static function idImage */

  /**
   * surround with script tags
   *
   * @param string $html
   */
  public static function jsTag($html)
  {
    return '<script type="application/javascript" >'.NL.$html.'</script>'.NL;
  }//end public static function jsTag */

  /**
   * surround with style tags
   *
   * @param string $html
   */
  public static function cssTag($html)
  {
    return '<style type="text/css" >'.NL.$html.'</style>'.NL;
  }//end public static function cssTag */

  /**
   * surround with style tags
   * @param string $url
   * @param string $text
   * @param array $attribues
   * @param string $target
   *
   * @return string $html
   */
  public static function urlTag($url , $text = null, $attribues = array() ,  $target = null )
  {
    $target = $target?'target="'.$target.'"':'';

    if ( is_string($attribues) )
      $attribues = $attribues?'class="'.$attribues.'"':'';
    else
      $attribues = $attribues?self::asmAttributes($attribues):'';

    if (trim($url) == '' ) {
      return '';
    } else {

      if (is_null($text))
        $text = $url;

      return '<a '.$target.' '.$attribues.' href="'.$url.'">'.$text.'</a>'.NL;
    }

  }//end public static function urlTag */

  /**
   * surround with style tags
   * @param string $url
   * @param string $text
   * @return string $html
   */
  public static function mailTag($url, $text = null )
  {
    if (trim($url) == '' ) {
      return '';
    } else {

      if (is_null($text))
        $text = trim($url);

      return '<a href="mailto:'.trim($url).'">'.$text.'</a>'.NL;
    }
  }//end public static function mailTag */

  /**
   * @param string $data
   * @return string
   */
  public static function cdata($data )
  {
    return '<![CDATA['.$data.']]>';
  }//end public static function cdata */

  /**
   * Enter description here...
   *
   * @param string $data
   * @return string
   */
  public static function tag($data , $tagName )
  {
    return '<'.$tagName.'>'.$data.'</'.$tagName.'>';
  }//end public static function tag */

  /**
   * Enter description here...
   *
   * @param string $name
   * @return WgtSelectboxHardcoded
   */
  public static function getSelectbox($name )
  {

    $className = 'WgtSelectbox'.$name;

    if (!Webfrap::classLoadable($className )) {
      Error::addError
      (
      'Class '.$className.' is not loadable'
      );

      return null;
    }

    if ( isset( self::$wgt[$className] ) ) {
      return self::$wgt[$className];
    } else {
      $select = new $className('global');
      $select->load();
      self::$wgt[$className] = $select;

      return $select;
    }

  }//end public static function getSelectbox */

  /**
   * Get a Template Area
   * @return LibTemplateAreaView
   */
  public static function getTemplateArea($name = null )
  {

    $area = new LibTemplateAreaView();

    return $area;

  }//end public function getTemplateArea */

  /**
   * Get a Template Area
   * @return string
   */
  public static function getTemplate($file, $type = 'content' )
  {

    // Zuerst den Standard Pfad checken
    if ( file_exists( View::$themePath.'/'.$type.'/'.$file.'.tpl' ) )
      return View::$themePath.'/'.$type.'/'.$file.'.tpl';

    foreach (View::$searchPathTemplate as $path) {

      $checkPath = $path.$type.'/'.$file.'.tpl';

      if ( file_exists($checkPath ) ) {
        if (Log::$levelDebug)
          Log::debug(__file__,__line__,"found Template: ". $checkPath );

        if ( Log::$levelDebug )
          Debug::console('Found Static Template: '.$checkPath );

        return $path.$type.'/'.$file.'.tpl';
      } else {
        if ( Log::$levelDebug )
          Debug::console('Not found Static Template: '.$checkPath );
      }
    }

    return null;

  }//end public function getTemplate */

  /**
   * Get a Template Area
   * @return string
   */
  public static function getTemplateContent($file, $type = 'content' )
  {

    if (! $path = self::getTemplate($file, $type ))
      return null;

    ob_start();
    include $path;
    $data = ob_get_contents();
    ob_end_clean();

    return $data;

  }//end public function getTemplateContent */

  /**
   * @param string $string
   */
  public static function clean($string )
  {
    return htmlspecialchars(stripslashes($string),ENT_QUOTES,'UTF-8');
  }//end public static function clean */

  /**
   * @param string $string
   */
  public static function out($string )
  {
    echo nl2br(htmlspecialchars(stripslashes($string),ENT_QUOTES,'UTF-8'));
  }//end public static function out */

  /**
   * @param string $url
   */
  public static function renderUrl($url )
  {

    $start = mb_substr($url, 0, 2 );

    if ($start === '\\\\' )
      return 'file://///'.str_replace('\\\\', '\\', substr($url, 4 ));
    else
      return $url;

  }//end public static function renderUrl */

/*//////////////////////////////////////////////////////////////////////////////
// Tag Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * surround with style tags
   *
   * @param string $html
   */
  public static function checked($cond , $status )
  {
    return $cond == $status ? 'checked="checked"':'';
  }//end public static function checked  */

  /**
   * surround with style tags
   *
   * @param string $html
   */
  public static function isHidden($cond , $status )
  {
    return $cond == $status ? '':' hidden ';
  }//end public static function isHidden  */

  /**
   * surround with style tags
   *
   * @param string $html
   */
  public static function isDisabled($cond )
  {
    return $cond ? ' disabled="disabled" ':'';
  }//end public static function isDisabled  */

  /**
   * surround with style tags
   *
   * @param string $html
   */
  public static function isChecked($cond )
  {
    return $cond ? ' checked="checked" ':'';
  }//end public static function isChecked  */

/*//////////////////////////////////////////////////////////////////////////////
// protected inner logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * assemble the attributes
   * @param array $attributes
   * @return String
   */
  public static function asmAttributes($attributes )
  {

    $html = '';

    foreach($attributes as $key => $value )
      $html .= $key.'="'.$value.'" ';

    return $html;

  }// end public function asmAttributes  */

/*//////////////////////////////////////////////////////////////////////////////
// non view logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $data
   */
  public static function parsteToTabledata($data )
  {
    $tabData = array();
    foreach ($data as $tabName => $ent) {
      $tabData[$tabName.'_'.DB::KEY] = $ent->getId();

      foreach($ent->getData() as $key => $col )
        $tabData[$tabName.'_'.$key] = $col;
    }

    return $tabData;

  }// end protected function parsteToTabledata  */

}//end class Wgt


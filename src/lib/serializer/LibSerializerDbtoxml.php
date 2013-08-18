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
 * serializer to json
 * @package WebFrap
 * @subpackage core/serializer
 */
class LibSerializerDbtoxml extends LibSerializerAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// constaten
//////////////////////////////////////////////////////////////////////////////*/

  public $counter = 0;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * instance of the
   *
   * @var ObjSerializerJson
   */
  private static $instance = null;

/*//////////////////////////////////////////////////////////////////////////////
// Singleton
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return LibSerializerDbtoxml
   */
  public static function getInstance()
  {

    if (is_null(self::$instance))
      self::$instance = new LibSerializerDbtoxml();

    return self::$instance;

  }//end public static function getInstance()

/*//////////////////////////////////////////////////////////////////////////////
// serializer
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * serialize to json
   * @return string
   */
  public function serializeDb($tableName , array $data , $meta , $encoding = null)
  {

    if (!isset($data[0]))
      $data[0] = array();

    $db = Db::getActive();

    $encode =  strpos('utf8' , $encoding) ? false:true;
    $charset =  strpos('utf8' , $encoding) ? 'UTF-8':'ISO-8859-15';

    $keys = array_keys($data[0]);

    $xml = Wgt::XML_HEAD.NL;
    $xml .= '<db>'.NL;
    $xml .= '<cols>'.NL;

    foreach ($keys as $key) {
      $m = $meta[$key] == true ?'t':'f';
      $xml .= '<c t="'.$m.'" >'.$key.'</c>'.NL;
    }

    $xml .= '</cols>'.NL;

    $xml .= '<rows>'.NL;
    foreach ($data as $row) {

      $xml .= '<r>';
      $pos = 0;
      foreach ($row as $val) {

        $val = $this->clear($val , $encode); // html_entity_decode($val,ENT_QUOTES);

        /*
        if ($meta[$key] == true) {
          $xml .= '<v><![CDATA['.html_entity_decode($val,ENT_QUOTES,$charset).']]></v>';
        } else {
          $xml .= '<v>'.html_entity_decode($val,ENT_QUOTES,$charset).'</v>';
        }
        */

        ++$this->counter;

        if ($meta[$keys[$pos]]) {
          $xml .= '<v><![CDATA['.$val.']]></v>';
        } else {
          $xml .= '<v>'.$val.'</v>';
        }

        ++$pos;

      }

      $xml .= '</r>'.NL;
    }

    $xml .= '</rows>'.NL;
    $xml .= '</db>'.NL;

    $this->serialized = $xml;

    return $this->serialized;

  }//end public function serializeDb */

  /**
   *
   */
  public function serialize($data = array()) {}

  /**
   *
   */
  protected function clear($val , $encode)
  {

    //$val = html_entity_decode($val,ENT_QUOTES);
    //$val = $encode?utf8_encode($val):$val;

    $replace = array
    (
    '�?' => '',
    '&uuml;' => 'ü',
    'Ã¼' => 'ü',
    'Ã¤' => 'ä',
    'Ã¶' => 'ö',
    );

    return str_replace( array_keys($replace), array_values($replace) , $val);

  }

} // end class LibSerializerJson


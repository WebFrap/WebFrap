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
class LibXml extends SimpleXMLElement
{

  /**
   * @param
   */
  public static function nodeToString($node )
  {

    if ($node instanceof DOMNode) {
      $node = simplexml_import_dom($node);

      return $node->asXml();
    } elseif ($node instanceof SimpleXmlElement) {
      return $node->asXml();
    } else {
      return '';
    }

  }//end public static function nodeToString */

  /**
   * take a given hopefully valid xml string, convert it to a domnode and
   * append it as child to a given parent node
   *
   * if no parent is given, the string is just imported in the action tree
   * DOMDocument an returned as free addable DOMNode
   *
   * @param string $xml
   * @return DOMNode
   */
  public static function stringToNode($xml )
  {

    ///TODO add some error handling
    $tmpDoc = new DOMDocument( '1.0', 'utf-8' );
    $tmpDoc->preserveWhitespace  = false;
    $tmpDoc->formatOutput        = true;

    if (!$tmpDoc->loadXML($xml)) {
      Error::addError('Failed to load an XML String',null,htmlentities($xml));

      return null;
    }

    return $tmpDoc->childNodes->item(0);

  }//endpublic static function stringToNode */

  /**
   * Enter description here...
   *
   * @param unknown_type $filename
   * @return unknown
   */
  public static function load($filename )
  {

    if ( is_readable($filename) ) {
      if ($xml = simplexml_load_file($filename , 'LibXml' )) {
        return $xml;
      } else {
        Log::warn( __file__,__line__,'Failed to open the the xml file: '.$xml );
      }
    } else {
      Log::warn( __file__,__line__,'The xml file: '.$xml.' is not readable' );
    }

  }//end public static function load */

  /**
   *
   * @param $cName
   * @return unknown_type
   */
  public function deleteChild($cName , $where = null )
  {

    if (! isset($this->$cName ))
      return;

    if ( is_string($cName) ) {
      if (is_null($where)) {
        unset($this->$cName);
      } elseif ( is_numeric($where) ) {
        $tmp = $this->$cName;

        if ( isset($tmp[$where] ) )
          unset($tmp[$where] );
      } else {
        $tmp = explode('=',$where);

        if (!count($tmp) == 2)
          return;

        // fore delete it's nessecary to load the data in a temp array
        $tmpNode = $this->$cName;

        $key = 0;
        foreach ($tmpNode as $value) {

          if ( isset($value[$tmp[0]]) && $value[$tmp[0]] == $tmp[1] ) {
            unset($tmpNode[$key] );
            // this must be cause of the strange dynamic array inside the xml element
            //
            $this->deleteChild($cName , $where );
            break;
          }

          ++$key;
        }//end foreach

      }//end else

    }//end if ( is_string($cName) )

  }//end public function deleteChild */

} // end class LibXml


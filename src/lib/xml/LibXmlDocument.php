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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class LibXmlDocument
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  protected $fileName = null;

  /**
   * @var DOMDocument
   */
  protected $document = null;

  /**
   * @var DOMElement
   */
  protected $rootNode = null;

  /**
   * @var DOMXPath
   */
  protected $xpath = null;

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $file
   */
  public function __construct( $file )
  {

    if ( is_string( $file ) ) {
      $this->fileName = $file;

      $this->document = new DOMDocument();
      $this->document->load( $file );

      $this->xpath = new DOMXPath( $this->document );
    } else {
      $this->document = $file;
      $this->xpath = new DOMXPath( $this->document );
    }

    $this->rootNode = $this->document->documentElement;

  }//end public function __construct

  /**
   * @return string
   */
  public function xpath( $query, $node = null )
  {

    if( $node )

      return $this->xpath->evaluate( $query, $node );
    else
      return $this->xpath->evaluate( $query );

  }//end public function xpath */

////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $attrName
   * @return string
   */
  public function getAttribute( $attrName )
  {
    return $this->document->documentElement->getAttribute( $attrName );

  }//end  public function getAttribute */

  /**
   * @param string $attrName
   * @param string $value
   */
  public function setAttribute( $attrName, $value )
  {

    $this->document->documentElement->setAttribute( $attrName, $value );

  }//end public function setAttribute */

  /**
   * @param string $attrName
   */
  public function removeAttribute( $attrName  )
  {

    $this->document->documentElement->removeAttribute( $attrName );

  }//end public function removeAttribute */

////////////////////////////////////////////////////////////////////////////////
// node logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $path
   * @return DOMElement
   */
  public function getNodeByPath( $path )
  {

    $node = $this->xpath( $path );

    if( $node->length )

      return $node->item( 0 );

    return null;

  }//end public function getNodeByPath */

////////////////////////////////////////////////////////////////////////////////
// FCK DOM!
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $tagName
   */
  public function getNode( $tagName )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if( $node->length )

      return $node->item(0);

    return null;

  }//end public function getNode */

  /**
   * @param string $path
   */
  public function getNodes( $path )
  {
    $list = $this->xpath( './'.$path, $this->rootNode );

    return $list;

  }//end public function getNodes */

  /**
   * @param string $path
   * @param string $position
   */
  public function createPath( $path, $position = null )
  {

    if ($position) {
      $dom = $this->getNode( './'.$position, $this->rootNode  );
    } else {
      $dom = $this->rootNode;
    }

    $pos = strpos( $path, '/'  );

    if ($pos) {
      $nodeName = substr( $path, 0, $pos );

      if( $position )
        $position = $position.'/'.$nodeName;
      else
        $position = $nodeName;

      $nextPath = substr( $path, $pos+1, strlen($path) );
    } else {
      $nodeName = $path;
      $nextPath = null;
    }

    $node = $this->xpath( './'.$nodeName, $dom );

    if ($node->length) {
      if ($nextPath) {
        return $this->createPath( $nextPath, $position );
      }
    } else {
      $newNode = $this->document->createElement( $nodeName, '' );
      $dom->appendChild( $newNode );

      if ($nextPath) {
        return $this->createPath( $nextPath, $position );
      }
    }

    return $newNode;

  }//end public function createPath */

  /**
   * @param string $tagName
   * @param string $value
   * @param array $attributes
   * @param DOMElement $parent
   */
  public function addNode( $tagName, $value, $attributes = array(), $parent = null )
  {

    if( !$parent )
      $parent  = $this->rootNode;

    $newNode = $this->document->createElement( $tagName, $value );

    if ($attributes) {
      foreach ($attributes as $key => $valAttr) {
        $newNode->setAttribute( $key, $valAttr );
      }
    }

    return  $parent->appendChild( $newNode );

  }//end public function addNode */

  /**
   * @param string $tagName
   * @param string $value
   * @param string $cData
   */
  public function setNodeValue( $tagName, $value, $cData = true )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if ($node->length) {
      $node->item(0)->nodeValue = $value;
    } else {
      $newNode = $this->document->createElement( $tagName, $value );
      $this->rootNode->appendChild( $newNode );
    }

  }//end public function setNodeValue */

  /**
   * @param string $tagName
   */
  public function getNodeValue( $tagName )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if( $node->length )

      return $node->item(0)->textContent;
    else
      return null;

  }//end public function setNodeValue */

  /**
   * @param string $tagName
   * @param string $attrName
   * @return string
   */
  public function getNodeAttr( $tagName, $attrName )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if( $node->length )

      return $node->item(0)->getAttribute( $attrName );
    else
      return null;

  }//end  public function getNodeAttr

  /**
   * @param string $tagName
   * @param string $attrName
   * @param string $value
   */
  public function setNodeAttr( $tagName, $attrName, $value )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if ($node->length) {
      $node->item(0)->setAttribute( $attrName, $value );
    } else {
      $newNode = $this->document->createElement( $tagName, '' );
      $newNode->setAttribute( $attrName, $value );
      $this->rootNode->appendChild( $newNode );
    }

  }//end public function setNodeAttr */

  /**
   * @param string $tagName
   * @param string $attrName
   */
  public function removeNodeAttr( $tagName, $attrName  )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if ($node->length) {
      $node->item(0)->removeAttribute( $attrName );
    }

  }//end public function removeNodeAttr */

  /**
   * @param string $attrName
   */
  public function removeAttr( $attrName )
  {

    if( $this->rootNode->hasAttribute( $attrName ) )
      $this->rootNode->removeAttribute( $attrName );

  }//end public function removeAttr */

  /**
   * @param string $tagName
   */
  public function touchNode( $tagName )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if ($node->length) {
      return $node->item(0);
    } else {

      if ( strpos( $tagName, '/' ) ) {
        return $this->createPath( $tagName );
      }

      $newNode = $this->document->createElement( $tagName, '' );

      return $this->rootNode->appendChild( $newNode );
    }

  }//end public function touchNode */

  /**
   * @param string $tagName
   */
  public function removeNode( $tagName )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if ($node->length) {
      $node = $node->item(0);
      $node->parentNode->removeChild( $node );
    }

  }//end public function removeNode */

  /**
   * Einen Node leeren
   */
  public function cleanNode( $tagName )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if ($node->length) {
      $node = $node->item(0);
      foreach ($node->childNodes  as $child) {
        $node->removeChild( $child );
      }
    }

  }//end public function cleanNode */

  /**
   * @param string $tagName
   */
  public function nodeExists( $tagName )
  {
    $node = $this->xpath( './'.$tagName, $this->rootNode );

    if( $node->length )

      return true;
    else
      return false;

  }//end public function nodeExists */

////////////////////////////////////////////////////////////////////////////////
// Label & Description
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $type
   * @return array
   */
  public function getTextNodes( $type )
  {

    $list = $this->xpath( './'.$type.'/text', $this->rootNode );

    $nodes = array();

    foreach ($list as $node) {
      $nodes[$node->getAttribute('lang')] = $node->textContent;
    }

    return $nodes;

  }//end public function getTextNodes */

  /**
   * @param string $type
   * @param string $lang
   * @return string
   */
  public function getTextNode( $type, $lang )
  {

    $list = $this->xpath( './'.$type.'/text[@lang="'.$lang.'"]', $this->rootNode );

    if( !$list->length )

      return '';

    return $list->item(0)->textContent;

  }//end public function getTextNode */

  /**
   * @param string $type
   * @param string $lang
   * @param string $content
   * @return array
   */
  public function setTextNode( $type, $lang, $content )
  {

    $list = $this->xpath( './'.$type.'/text[@lang="'.$lang.'"]', $this->rootNode );

    $nodes = array();

    if ($list->length) {
      $node = $list->item(0);

      $cdata = $node->ownerDocument->createCDATASection( $content  );

      if ( $node->hasChildNodes() ) {
        $node->replaceChild( $cdata, $node->childNodes->item(0) );
      } else {
        $cdata = $node->ownerDocument->createCDATASection( $content  );
        $node->appendChild( $cdata );
      }

    } else {
      $tNodeList = $this->xpath( './'.$type, $this->rootNode );

      if (!$tNodeList->length) {
        $newNode = $this->document->createElement( $type );
        $tNode = $this->rootNode->appendChild( $newNode );
      } else {
        $tNode = $tNodeList->item(0);
      }

      $newNode = $this->document->createElement( 'text' );
      $newNode->setAttribute( 'lang', $lang );
      $newNode = $tNode->appendChild( $newNode );

      $cdata = $newNode->ownerDocument->createCDATASection($content);
      $newNode->appendChild( $cdata );

    }

  }//end public function setTextNode */

  /**
   * checken ob ein textnode existiert
   * @param string $type
   * @param string $lang
   * @return boolean
   */
  public function hasTextNode( $type, $lang  )
  {

    $list = $this->xpath( './'.$type.'/text[@lang="'.$lang.'"]', $this->rootNode );

    if ($list->length) {
      return true;
    } else {
      return false;
    }

  }//end public function hasTextNode */

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return SimpleXMLElement
   */
  public function getSimple( )
  {

    if( $this->simple )

      return $this->simple;

    $this->simple = simplexml_import_dom($this->rootNode);

    return $this->simple;

  }// public function getSimple */

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Rückgabe der Debugdaten des Knotens
   */
  public function debugData()
  {
    return null;

  }//end public function debugData */

  /**
   * Nach XML Serialisieren
   */
  public function serializeXml()
  {
    return null;
  }//end public function serializeXml */

  /**
   * @return string
   */
  public function save( )
  {

    $this->document->normalizeDocument();
    $this->document->save( $this->fileName );

  }//end public function save */

  /**
   *
   * @param string $xml
   * @return DOMDocument
   */
  public function loadXML( $xml )
  {
    return $this->rootNodeDocument->loadXML( $xml );

  }//end public function loadXML

} // end class LibXmlDocument

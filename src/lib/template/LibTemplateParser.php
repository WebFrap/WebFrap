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
 *
 */
class LibTemplateParser
{
/*//////////////////////////////////////////////////////////////////////////////
// cache attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * path to the new template
   *
   * @var string
   */
  protected $fullPath       = null;

  /**
   * path to the new template
   *
   * @var string
   */
  protected $key            = null;

  /**
   * der key für den cache
   * Wenn Aktiv dann wird gecached
   *
   * @var string
   */
  protected $templateTree   = null;

  /**
   *
   * @var array
   */
  protected $templateElement = array
  (
    'echo'      => true,
    'var'       => true,
    'item'      => true,
    'widget'    => true,
    'include'   => true,
    'if'        => true,
    'elseif'    => true,
    'else'      => true,
    'foreach'   => true,
    'while'     => true,
    'for'       => true,
    'call'      => true,
  );

/*//////////////////////////////////////////////////////////////////////////////
// magic methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the contstructor
   *
   */
  public function __construct($fullPath , $key )
  {

    $this->fullPath = $fullPath;
    $this->key      = $key;

    $this->env = Webfrap::getActive();

  }// end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @return unknown_type
   */
  public function load()
  {

    $preXml = '<template>'.file_get_contents($this->fullPath).'</template>';

    $this->templateTree = new DOMDocument('1.0', 'utf-8');
    $this->templateTree->preserveWhitespace  = false;
    $this->templateTree->formatOutput        = true;

    if (!$this->templateTree->loadXML($preXml)) {
      Error::addError('Failed to build the Template: '.$this->fullPath );
    }

  }//end public function load

  /**
   *
   */
  public function build()
  {

    $this->replaceElements($this->templateTree );
    $this->createCache();

  }//end public function build */

/*//////////////////////////////////////////////////////////////////////////////
// protected methodes
//////////////////////////////////////////////////////////////////////////////*/

  protected function replaceElements($domNode )
  {

    /*
    XML_ELEMENT_NODE        Node is a DOMElement
    XML_ATTRIBUTE_NODE      Node is a DOMAttr
    XML_TEXT_NODE           Node is a DOMText
    XML_CDATA_SECTION_NODE  Node is a DOMCharacterData
    XML_ENTITY_REF_NODE     Node is a DOMEntityReference
    XML_ENTITY_NODE         Node is a DOMEntity
    XML_PI_NODE             Node is a DOMProcessingInstruction
    XML_COMMENT_NODE        Node is a DOMComment
    XML_DOCUMENT_NODE       Node is a DOMDocument
    XML_DOCUMENT_TYPE_NODE  Node is a DOMDocumentType
    XML_DOCUMENT_FRAG_NODE  Node is a DOMDocumentFragment
    XML_NOTATION_NODE       Node is a DOMNotation
     */

    foreach ($domNode->childNodes as $node) {

      switch ($node->nodeType) {
        case XML_COMMENT_NODE:
        {
          // kommentar entfernen
          $node->parentNode->removeChild($node);
          break;
        }
        case XML_ELEMENT_NODE:
        {

          $name = strtolower($node->nodeName );

          if ( isset($this->templateElement[$name] )  )
            $this->replaceTemplateElement($name,$node);

          $this->replaceElements($node );

          break;
        }

      }

    }

  }//end protected function replaceElements */

  /**
   * @param string $name
   * @param string $node
   */
  protected function replaceTemplateElement($name, $node )
  {

    switch ($name) {

      case 'if':
      case 'elseif':
      case 'else {':
        $this->replaceTplIfElse($node );
        break;
      }
      default:
      {
        $method = 'replaceTpl'.ucfirst($name );

        if ( method_exists($this,  $method ) ) {
          $this->$method($node );
        } else {
          Error::addError('Invalid Template Element: '.$name.' (this should never happen)' );
        }

      }

    }

  }//end protected function repladeTemplateElement */

  /**
   *
   */
  protected function createCache()
  {

    $cachePath = PATH_GW.'cache/template/'.$this->key.'.php';
    $cacheDir  = dirname($cachePath);

    if (!file_exists($cacheDir ) )
      SFilesystem::createFolder($cacheDir );

    $template = $this->templateTree->saveXML();

    // remove work root element
    $template = substr($template ,  10, -11 );

    if (!file_put_contents($cachePath , $template )) {
      Error::addError('Failed to cache assembled Template at: '.$cachePath  );

      return false;
    } else {
      if (Log::$levelDebug)
        Log::debug( 'Successfully createt template cache: '.$cachePath  );

      return true;

    }

  }//end protected function createCache */

/*//////////////////////////////////////////////////////////////////////////////
// template methodes
//////////////////////////////////////////////////////////////////////////////*/

  protected function replaceTplVar($node )
  {
    $nodeContent = $this->replaceVarKey($node->nodeText  );
    $replace = '<?php echo $VAR->'.$nodeContent.'; ?>';
    $this->replaceDomWithText($node,$replace);
  }

  protected function replaceTplItem($node )
  {
    $nodeContent = $this->replaceVarKey($node->nodeText  );
    $replace = '<?php echo $ITEM->'.$nodeContent.'; ?>';
    $this->replaceDomWithText($node,$replace);
  }

  protected function replaceTplInclude($node )
  {

  }

  protected function replaceTplIfElse($node )
  {

  }

  protected function replaceTplForeach($node )
  {

  }

  protected function replaceTplWhile($node )
  {

  }

  protected function replaceTplFor($node )
  {

  }

  protected function replaceTplCall($node )
  {

  }

/*//////////////////////////////////////////////////////////////////////////////
// helper methodes
//////////////////////////////////////////////////////////////////////////////*/

  protected function replaceDomWithText($node , $text )
  {

    $node->parentNode->replaceChild( new DOMText($text),$node );

  }

} // end end LibTemplateParser


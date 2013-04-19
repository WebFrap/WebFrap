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
class LibRichtextParser
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  public $nodes = array();

  /**
   * @var string
   */
  public $rawText = null;

  /**
   * @var string
   */
  public $compiler = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRichtextCompiler $compiler
   */
  public function __construct($compiler)
  {
    $this->compiler = $compiler;
  }//end public function __construct */

  /**
   * @param string $rawText
   */
  public function parse($rawText)
  {

    $this->clean();
    $this->rawText = $rawText;

    preg_match_all('/\[\[(.*)?\]\]/U', $rawText, $matches);

    if (isset($matches[1])) {

      Debug::console("got matches ", $matches[1]);

      foreach ($matches[1] as $match) {

        $tmp = explode(':', $match);

        $nodeClass = 'LibRichtextNode_'.SParserString::subToCamelCase($tmp[0]);

        if (Webfrap::classLoadable($nodeClass)) {
          $this->nodes[] = new $nodeClass($tmp[1], $this->compiler);
        } else {
          Debug::console('Missing Richtext Node: '.SParserString::subToCamelCase($tmp[0]));
          $this->nodes[] = new LibRichtextNode_Invalid($match, $this->compiler);
        }

      }

    }

  }//end public function parse */

  /**
   * @return void
   */
  public function clean()
  {

    $this->rawText = null;
    $this->nodes   = array();

  }//end public function clean */

}//end class LibRichtextParser


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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WbfpageText_Model
  extends Model
{

  /**
   *
   * @var array
   */
  protected $texts = array();

  /**
   * @return string
   */
  public function text( $key )
  {
    return isset($this->texts[$key])?$this->texts[$key]:'<!-- missing '.$key.' -->';
  }//end public function text */

  /**
   * @param array $keys
   * @return array
   */
  public function loadTexts( $keys )
  {

    $this->texts = array();

    $condKeys = "'".implode("','",$keys)."'";

    $query = <<<CODE
select access_key, content from wbfsys_text where access_key in({$condKeys});
CODE;

    $result = $this->getDb()->select($query);

    foreach ($result as $entry) {
      $this->texts[$entry['access_key']] = $entry['content'];
    }

    return $this->texts;

  }//end public function getTexts */

}//end class WbfpageText_Model

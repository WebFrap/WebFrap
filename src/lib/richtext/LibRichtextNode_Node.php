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
class LibRichtextNode_Node
  extends LibRichtextNode
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $key = 'node';

  /**
   * Sollte überschrieben werden
   * @return string
   */
  public function renderValue()
  {

    $db = $this->compiler->getDb();

    $sql = <<<SQL
SELECT
    rowid,
    title
    FROM
        wbfsys_know_how_node
  WHERE UPPER(access_key) = upper('{$db->addSlashes($this->value)}');
SQL;

    $data = $db->select($sql)->get();

    if ($data) {

    $compiled = <<<HTML
<a
    class="wcm wcm_req_ajax"
    href="maintab.php?c=Webfrap.KnowhowNode.show&amp;objid={$data['rowid']}" >{$data['title']}</a>
HTML;

    } else {
      $compiled = <<<HTML
<a
    class="wcm wcm_req_ajax not_exists"
    href="maintab.php?c=Webfrap.KnowhowNode.open&amp;node={$this->value}" >{$this->value}</a>
HTML;

    }

    return $compiled;

  }//end public function renderValue */

}//end class LibRichtextNode_Node

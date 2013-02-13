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
 * @author sono
 *
 */
class WgtTreeBuilderJson
  extends WgtTreeBuilder
{
/*//////////////////////////////////////////////////////////////////////////////
// attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var LibAclDb
   */
  public $acl = null;

/*//////////////////////////////////////////////////////////////////////////////
// method
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * (non-PHPdoc)
   * @see WgtAbstract::setData()
   */
  public function setData( $key, $value = null )
  {

    if( is_string( $key ) )
      $this->data = json_decode( $key );
    else 
      $this->data = $key;

  }//end public function setData */
  
  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {

    return $this->renderData( $this->data );

  }//end public function render */
  
  /**
   * @return string
   */
  public function renderData( $data, $idKey = null )
  {
    
    if( $this->html )
      return $this->html;
      
    if( is_string( $data ) )
      $data = json_decode( $data );

    if( $idKey )
      $htmlId = $this->getIdByKey( $idKey );
    else 
      $htmlId = $this->getId();
    
    $html = <<<HTML
    <ul id="{$this->getId()}" class="wgt-tree ui-widget" >
HTML;
    
    foreach( $data as $child => $childNode )
    {
      if( is_scalar($childNode) )
      {
        $html .= <<<HTML
			<li><label>{$child}</label> =&gt; {$childNode}</li>
HTML;
      }
      else 
      {
        $html .= <<<HTML
			<li><label>{$child}</label> =&gt; {$this->renderNode($childNode)}</li>
HTML;
      }
    }
    
    $html .= <<<HTML
    </ul>
HTML;

    $this->html = $html;
    
    return $html;

  }//end public function renderData */
  
  /**
   * @param stdClass $nodeData
   * 
   * @return string
   */
  protected function renderNode( $nodeData )
  {
    
    $html = <<<HTML
    <ul>
HTML;
    
    foreach( $nodeData as $child => $childNode )
    {
      if( is_scalar($childNode) )
      {
        $html .= <<<HTML
			<li><label>{$child}</label> =&gt; {$childNode}</li>
HTML;
      }
      else 
      {
        $html .= <<<HTML
			<li><label>{$child}</label> =&gt; {$this->renderNode($childNode)}</li>
HTML;
      }
    }
    
    $html .= <<<HTML
    </ul>
HTML;

    return $html;
    
  }//end protected function renderNode */

  /**
   *
   * @return string
   */
  public function build()
  {

    if( $this->html )
      return $this->html;

    if( count($this->data) == 0 )
    {
      $this->html .= '<ul id="'.$this->id.'" class="wgt_tree" >'.NL;
      $this->html .= '</ul>'.NL;
      return $this->html;
    }

    $html = '';

    $html .= '<ul id="'.$this->id.'" class="wgt_tree" >'.NL;


    foreach( $this->data as $id => $row )
    {

      $entry    = $this->buildTreeNode($row);

      $html .= <<<HTML
<li id="{$this->id}_{$id}" >

  {$entry}
  <ul id="{$this->id}_{$id}_tree" ></ul>

</li>

HTML;


    }

    $html .= '</ul>'.NL;


    $this->html = $html;
    return $this->html;

  }//end public function build */


  /**
   * build the table
   *
   * @return String
   */
  public function buildAjaxNode( $parentNode )
  {

    if( $this->html )
      return $this->html;

    $html = '';

    if( $this->ajaxInsert )
    {

        $html .= <<<HTML
      <htmlArea selector="ul#{$parentNode}" action="append" ><![CDATA[
HTML;

      foreach( $this->data as $id => $row )
      {

        $entry  = $this->buildTreeNode($row);

        $html .= <<<HTML
      <li id="{$this->id}_{$id}" >
        {$entry}
        <ul id="{$this->id}_{$id}_tree" ></ul>
      </li>
HTML;

      }

        $html .= <<<HTML
]]></htmlArea>
HTML;


    }//end if
    else
    {
        $html .= <<<HTML
      <htmlArea selector="ul#{$parentNode}" action="replace" ><![CDATA[
HTML;

      foreach( $this->data as $id => $row )
      {

        $entry  = $this->buildTreeNode($row);

        $html .= <<<HTML
      <li id="{$this->id}_{$id}" >
        {$entry}
        <ul id="{$this->id}_{$id}_tree" ></ul>
      </li>
HTML;

      }

        $html .= <<<HTML
]]></htmlArea>
HTML;

    }//end else

    $this->html = $html;

    return $this->html;

  }//end public function buildAjaxNode */



}//end class WgtTree

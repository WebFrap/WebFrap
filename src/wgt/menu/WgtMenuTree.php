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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 *
 */
class WgtMenuTree extends WgtMenu
{


  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtMenu#setData()
   */
  public function setData($data )
  {
    $this->data = $data;
  }//end public function setData */

  /**
   *
   *
   */
  public function build()
  {

    //$this->load();

    if ($this->html )
      return $this->html;

    if (count($this->data->folders) == 0 && count($this->data->files ) == 0  )
    {
      $this->html .= '<ul id="'.$this->id.'" class="wgt_tree" >'.NL;
      $this->html .= '</ul>'.NL;
      return $this->html;
    }

    $html = '';

    $html .= '<ul id="'.$this->id.'" class="wgt_tree" >'.NL;


    /*
  'menu_category_default'
  Wgt::SUB_WINDOW,
  I18n::s( 'default', 'accounting.category.text.labelDefault'  ),
  I18n::s( 'default', 'accounting.category.text.titleDefault'  ),
  'index.php?c=Accounting.base.categoryMenu&amp;category=default',
  'accounting/category/default',
     */

    $index = array();

    foreach($this->data->folders as $entry )
    {
      $index[$entry[2]] = $entry;
    }

    ksort($index);


    foreach($index as $row )
    {

      $id       = $row[WgtMenu::ID];
      $entry    = $this->buildMenuEntry($row);

      $html .= <<<HTML
<li id="{$this->id}_{$id}" >

  {$entry}

  <ul id="{$this->id}_{$id}_tree" ></ul>

</li>

HTML;


    }


   $fileIndex = array();

    foreach($this->data->files as $entry )
    {
      $fileIndex[$entry[2]] = $entry;
    }

    ksort($fileIndex);


    foreach($fileIndex as $row )
    {

      $id       = $row[WgtMenu::ID];
      $entry    = $this->buildMenuEntry($row);

      $html .= <<<HTML
<li id="{$this->id}_{$id}" >

  {$entry}

  <ul id="{$this->id}_{$id}_tree" ></ul>

</li>

HTML;


    }//end foreach

    $html .= '</ul>'.NL;


    $this->html = $html;
    return $this->html;

  }//end public function build */


  /**
   * build the table
   *
   * @return String
   */
  public function buildAjaxNode($parentNode )
  {

    if ($this->html )
      return $this->html;

    $html = '';


    if ($this->ajaxInsert )
    {

        $html .= <<<HTML
      <htmlArea selector="ul#{$parentNode}" action="append" ><![CDATA[
HTML;

      foreach($this->data->folders as $row )
      {

        $id       = $row[WgtMenu::ID];
        $entry    = $this->buildMenuEntry($row);

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

      foreach($this->data->folders as $row )
      {

        $id       = $row[WgtMenu::ID];
        $entry    = $this->buildMenuEntry($row);

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

  }//end public function buildAjaxRows */

  /**
   * @param $entry
   */
  protected function buildMenuEntry($entry )
  {

    if ($entry[WgtMenu::ICON] != '' || trim($entry[WgtMenu::TEXT]) != '' )
    {

      $text = trim($entry[WgtMenu::TEXT] ) != ''
        ? $entry[WgtMenu::TEXT].'<br />'
        : '';

      $iconSrc = View::$iconsWeb.'xsmall/'.$entry[WgtMenu::ICON];


      if ( Wgt::ACTION == $entry[WgtMenu::TYPE] )
      {
        return '<div style="width:200px;" >
            <img src="'.$iconSrc.'" onclick="tree'.$this->name.'.loadChildren( {id:$id}, this );" class="icon xsmall" alt="'.$entry[WgtMenu::TITLE].'" />
            <span onclick="'.$entry[WgtMenu::ACTION].'" >'.$text.'</span>
          </div>';

      }
      else if ( Wgt::URL == $entry[WgtMenu::TYPE] )
      {

        return '<div style="width:200px;" >
            <img src="'.$iconSrc.'" onclick="tree'.$this->name.'.loadChildren( {id:$id}, this );" class="icon xsmall" alt="'.$entry[WgtMenu::TITLE].'" />
            <a style="border:0px;" href="'.$entry[WgtMenu::ACTION].'" >'.$text.'</a>
          </div>';

      }
      else if ( Wgt::AJAX == $entry[WgtMenu::TYPE] )
      {

        return '<div style="width:200px;" >
            <img src="'.$iconSrc.'" onclick="tree'.$this->name.'.loadChildren( {id:$id}, this );" class="icon xsmall" alt="'.$entry[WgtMenu::TITLE].'" />
            <a class="wcm wcm_req_ajax" style="border:0px;" href="'.$entry[WgtMenu::ACTION].'" >'.$text.'</a>
          </div>';

      } else {

        return '<div style="width:200px;" >
            <img src="'.$iconSrc.'" onclick="tree'.$this->name.'.loadChildren( {id:$id}, this );" class="icon xsmall" alt="'.$entry[WgtMenu::TITLE].'" />
            <a class="wcm wcm_req_ajax" style="border:0px;" href="'.$entry[WgtMenu::ACTION].'" >'.$text.'</a>
          </div>';

      }

    } else {
      return '&nbsp;';
    }

  }//end protected function buildMenuEntry */


}//end class WgtMenuTree
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
class WgtSelectboxWebfrapTabaction
  extends WgtSelectbox
{

  /**
   * 
   */
  protected function load()
  {
    
    if(!$this->showEntry)
    {
      $this->data= array
      (
        'show'      => I18n::s( 'Show', 'wbf.label' ),
        'edit'      => I18n::s( 'Edit', 'wbf.label' ),
        'activate'  => I18n::s( 'Activate', 'wbf.label' ),
        'delete'    => I18n::s( 'Delete', 'wbf.label' ),
      );
    }
    else
    {
      if(isset($this->showEntry['show']))
      {
        $this->data['show'] = I18n::s( 'Show', 'wbf.label');
      }
      if(isset($this->showEntry['edit']))
      {
        $this->data['edit'] = I18n::s( 'Edit', 'wbf.label' );
      }
      if(isset($this->showEntry['activate']))
      {
        $this->data['activate'] = I18n::s( 'Activate', 'wbf.label' );
      }
      if(isset($this->showEntry['delete']))
      {
        $this->data['delete'] = I18n::s( 'Delete', 'wbf.label' );
      }
    }
    
  }//end protected function load */

  /**
   *
   */
  public function build()
  {


    if( $this->assembled )
    {
      return $this->html;
    }

    $this->load();

    $this->assembled = true;

    $this->jsCode = 'wgt.registry.register(\'wgttabaction_'.$this->name.'\',new WgtSelectboxCoreTabaction(\'wgtid_sel_tabaction_'.$this->name.'\',\'wgtid_table_'.$this->name.'\'));';
    $this->firstFree = I18n::s('wbf.text.selectAction');
    $this->attributes['onchange'] = 'wgt.registry.request(\'wgttabaction_'.$this->name.'\').run();';

    $select = '<select id="wgtid_sel_tabaction_'.$this->name.'" '.$this->asmAttributes().' >'.NL;

    if( $this->firstFree )
    {
      $select .= '<option value="" >'.$this->firstFree.'</option>'.NL;
    }

    foreach( $this->data as $action => $data )
    {
      $select .= '<option value="'.$action.'" >'.$data.'</option>'.NL;
    }

    $select .= '</select>'.NL;

    $this->html = $select;

    return $this->html;

  }//end public function build */


} // end class WgtSelectboxCoreTabaction



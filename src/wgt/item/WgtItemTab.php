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
 * @subpackage ModCms
 */
class WgtItemTab
  extends WgtAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the page tabs
   *
   * @var array
   */
  protected $tabs   = array();

////////////////////////////////////////////////////////////////////////////////
// Getter, Setter, Adder, Remover
////////////////////////////////////////////////////////////////////////////////


  /**
   * @param string $tabName
   * @param array $tabData
   *
   * tabData should contain:
   * <ul>
   * <li>title</li>
   * <li>icon (optional)</li>
   * <li>content</li>
   * </ul>
   *
   */
  public function addTabContent( $tabName , $tabData )
  {

    $this->tabs[$tabName] = $tabData;

  }//end public function addTabContent( $tabName , $tabData )

  /**
   * @param string $tabName
   */
  public function addTab( $tabName  )
  {

    $tabParser = new LibTemplatePhp();
    $this->tabs[$tabName] = $tabParser;

    return $tabParser;

  }//end public function addTab( $tabName )

////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#build()
   */
  public function build( )
  {

    $head = '<ul class="wgtTab menu" >'.NL;
    $body = '';

    foreach( $this->tabs as $tabname => $tab )
    {


      if( is_object($tab) )
      {
        $tabhead = $tab->getTitle();
        $name = $tab->getName();

        if( $name == $this->activ )
        {
          $hidden = '';
          $activ = ' activ';
        }
        else
        {
          $hidden = ' hidden';
          $activ = '';
        }


        $head .= '<li class="wgtTab entry'.$activ.'"
                      id="wgtid_tab_'.$this->name.'_menuentry_'.$name.'"
                      onclick="wgtTab_'.$this->name.'.openTab(\''.$name.'\',this)" >'.$tabhead.'</li>'.NL;
        $body .= '<div class="wgtTab box'.$hidden.'" id="wgtid_tab_'.$this->name.'_'.$name.'" >'.NL.$tab.NL.'</div>'.NL;
      }
      else
      {
        $tabhead = $tab['title'];
        $name = $tab['name'];

        if( $name == $this->activ )
        {
          $hidden = '';
          $activ = ' activ';
        }
        else
        {
          $hidden = ' hidden';
          $activ = '';
        }

        $head .= '<li class="wgtTab entry'.$activ.'"
                      id="wgtid_tab_'.$this->name.'_menuentry_'.$name.'"
                      onclick="wgtTab_'.$this->name.'.openTab(\''.$name.'\',this)" >'.$tabhead.'</li>'.NL;
        $body .= '<div class="wgtTab box'.$hidden.'" id="wgtid_tab_'.$this->name.'_'.$name.'"  >'.$tab['content'].'</div>'.NL;
      }

    }

    $head .= '</ul>'.NL;

    $html = '      <script type="text/javascript">
      var wgtTab_'.$this->name.' = null;
      $S(document).ready(function()
      {
        wgtTab_'.$this->name.' = new WgtItemTab(\'wgtid_tab_'.$this->name.'\');
        wgtTab_'.$this->name.'.setAtiv();
      });

      </script>'.NL;

    $html .= '<div  id="wgtid_tab_'.$this->name.'" class="full" >'.NL;
    $html .= $head.NL;
    $html .= $body.NL;
    $html .= '</div>'.NL;

    return $html;

  } // end public function build( )

  /**
   * (non-PHPdoc)
   * @see src/wgt/WgtAbstract#buildAjax()
   */
  public function buildAjax()
  {
    return '';
  }


} // end class WgtItemTab



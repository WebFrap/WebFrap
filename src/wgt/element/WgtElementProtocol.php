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
class WgtElementProtocol extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = 'Protocol';

  /**
   * Die ID des Datensatzes für welchen die History angezeigt werden soll
   * @var int
   */
  public $refId = null;

  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $domainKey = null;

  /**
   * Context Container
   * @var Context
   */
  public $context = null;

  /**
   * Breite des Comment Tree
   * @var int
   */
  public $width = 400;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param string $name
   * @param LibTemplate $view
   */
  public function __construct( $name = null, $view = null )
  {

    $this->name   = $name;
    $this->init();

    if( $view )
    {
      $view->addElement( $name, $this );
      $this->view = $view;
    }
    else
    {
      $this->view = Webfrap::$env->getView();
    }

  } // end public function __construct */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render( $params = null )
  {

    if( $this->html )
      return $this->html;

    $this->name = $this->getId( );

    $codeEntries = '';

    foreach( $this->data as $entry )
    {
      $codeEntries .= $this->renderEntry( $entry );
    }


    $html = <<<HTML
<div class="wgt-news-box" >
  <ul class="wgt-news-list thumbs" id="{$this->id}" >
    {$codeEntries}
  </ul>
</div>

HTML;

    $this->html = $html;

    return $html;

  } // end public function render */

  /**
   * @param array $entry
   * @return string
   */
  public function renderEntry( $entry )
  {

    $date = $this->view->i18n->timestamp( $entry['m_time_created'] );

    $html = <<<HTML
      <li class="entry" >
        <h3>
        	{$entry['user_name']} &lt;{$entry['person_lastname']}, {$entry['person_firstname']}&gt;
        	<span class="date">[{$date}]</span>
        </h3>
        <div class="thumb" >
        	<img
        		src="thumb.php?f=core_person-photo-{$entry['person_id']}&amp;s=xxsmall"
        		alt="{$entry['user_name']}"
        		style="max-width:48px;max-height:48px;" >
        </div>
        <div class="content" >
        	{$entry['log_content']}
        </div>
        <div class="wgt-clear" ></div>
      </li>
HTML;

    return $html;

  }//end public function renderEntry */


} // end class WgtElementProtocol



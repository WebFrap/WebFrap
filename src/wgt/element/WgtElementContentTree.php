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
class WgtElementContentTree extends WgtAbstract
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $label = 'Comments';

  /**
   * @var string
   */
  public $urlCreate = 'ajax.php?c=Base.Comment.add';

  /**
   * @var string
   */
  public $urlDisconnect = 'ajax.php?c=Base.Comment.disconnect';

  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $refId = null;

  /**
   * Die ID des Datensatzes der getaggt werden soll
   * @var int
   */
  public $domainKey = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct($name = null, $view = null)
  {

    $this->texts  = new TArray();

    $this->name   = $name;
    $this->init();

    if ($view)
      $view->addElement($name, $this);

  } // end public function __construct */

  /**
   * @param TFlag $params
   * @return string
   */
  public function render($params = null)
  {

    if ($this->html)
      return $this->html;

    $codeEntr = $this->renderEntry(0);

    $id       = $this->getId();
    $iconAdd  = $this->icon('control/add.png', 'Add');

    $html = <<<HTML

<div
  class="wcm wcm_ui_comment_tree wgt-content_box wgt-comment_tree"
  id="{$id}"
  style="width:500px;height:auto;" >

  <div class="head" >
    <h2>{$this->label}</h2>
  </div>

  <div class="content" style="height:330px;"  >
    <ul class="wgt-tree" >
    {$codeEntr}
    </ul>
  </div>

  <div class="editor" >

    <form
      method="post"
      id="wgt-form-commenttree-{$id}-{$this->refId}"
      action="{$this->urlCreate}" ></form>

    <input
      type="hidden"
      name="refid"
      value="{$this->refId}"
      class="asgd-wgt-form-commenttree-{$id}-{$this->refId}" />

    <input
      type="hidden"
      name="parent"
      class="asgd-wgt-form-commenttree-{$id}-{$this->refId}" />

    <div class="wgt_box input">
      <label class="wgt-label">Title <span class="wgt-required">*</span></label>
      <div class="wgt-input large"><input
        type="text"
        class="large asgd-wgt-form-commenttree-{$id}-{$this->refId}"
        id="wgt-input-commenttree-{$id}-title-{$this->refId}"
        name="title"
        style="width:350px;" /></div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

    <div class="wgt_box input" >
      <label class="wgt-label full">Comment <span class="wgt-required">*</span></label>
      <div class="wgt-input full" ><textarea
        class="wcm wcm_ui_wysiwyg large medium-height asgd-wgt-form-commenttree-{$id}-{$this->refId}"
        id="wgt-input-commenttree-{$id}-comment-{$this->refId}"
        name="content"
        style="width:350px;" ></textarea><var id="wgt-input-commenttree-{$id}-comment-{$this->refId}-cfg-wysiwyg" >{
        "width":"473",
        "height":"250"
        }</div>
      <div class="wgt-clear tiny" >&nbsp;</div>
    </div>

    <div class="full">
      <div class="wgt-clear small">&nbsp;</div>
      <div class="right" style="margin-right:15px;" ><button
        class="wgt-button"
         tabindex="-1"
        id="wgt-input-commenttree-{$id}-cntrl-{$this->refId}" >Submit</buttom></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>

  </div>

</div>

HTML;

    return $html;

  } // end public function render */

  /**
   * @param int $id
   * @return string
   */
  public function renderEntry($id)
  {

    $html = '';

    /*
id,
title,
rate,
content,
time_created,
parent,
firstname,
lastname,
user_name
     */

    if (isset($this->data[$id])) {

      $entries = $this->data[$id];

      foreach ($entries as $entry) {

        $date = date('Y-m-d - H:i', $entry['time_created']);

        $html .= <<<HTML
  <li>
    <div class="wgt-comment" >
      <h3>{$entry['title']}</h3>
      <p>Autor <span class="user" >({$entry['user_name']}) {$entry['lastname']}, {$entry['firstname']}</span> <span class="date" >{$date}</span></p>
      <div class="content" >{$entry['title']}</div>
      <div class="cntrl" >
        <a
      </div>
    </div>
HTML;

        $parent = (int) $this->data['parent'];

        if ($parent && isset($this->data[$parent])) {
          $html .= '<ul>';
          $html .= $this->renderEntry($parent);
          $html .= '</ul>';
        }

        $html .= '</li>';
      }

    }

    return $html;

  }//end public function renderEntry */

} // end class WgtElementContentTree


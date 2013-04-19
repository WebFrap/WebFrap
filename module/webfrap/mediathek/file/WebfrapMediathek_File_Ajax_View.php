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
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @licence BSD
 */
class WebfrapMediathek_File_Ajax_View extends LibTemplatePlain
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var WebfrapMediathek_Model
   */
  public $mediaModel = null;

  /**
   * @param WebfrapMediathek_Model $mediaModel
   */
  public function setMediaModel($mediaModel)
  {
    $this->mediaModel = $mediaModel;
  }//end public function setMediaModel */

/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $mediaId
   * @param string $elementId
   * @param array $entry
   */
  public function renderAddEntry($mediaId, $elementId, $entry)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-mediathek-'.$elementId.'-file-table>tbody';
    $pageFragment->action   = 'prepend';

    $mediathekElement = new WgtElementMediathek();
    $mediathekElement->setId($elementId);
    $mediathekElement->mediaId = $mediaId;

    $pageFragment->setContent($mediathekElement->renderFileEntry($elementId, $entry));

    $tpl->setArea('mediathek', $pageFragment);

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-mediathek-{$elementId}-file-table').grid('renderRowLayout').grid('incEntries');

WGTJS;

    $tpl->addJsCode($jsCode);

  }//end public function renderAddEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param int $imgId
   * @param int $mediaId
   * @param string $elementId
   * @param array $entry
   */
  public function renderUpdateEntry($imgId, $mediaId, $elementId, $entry  )
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-mediathek-'.$elementId.'-file_row_'.$imgId.'-2';
    $pageFragment->action   = 'remove';
    $tpl->setArea('remove_entries', $pageFragment);

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'tr#wgt-grid-mediathek-'.$elementId.'-file_row_'.$imgId.'-1';
    $pageFragment->action   = 'replace';

    $mediathekElement = new WgtElementMediathek();
    $mediathekElement->mediaId = $mediaId;
    $mediathekElement->setIdKey($elementId);

    $pageFragment->setContent($mediathekElement->renderFileEntry($elementId, $entry));

    $tpl->setArea('mediathek', $pageFragment);

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-mediathek-{$elementId}-file-table').grid('renderRowLayout');

WGTJS;


  }//end public function renderUpdateEntry */

  /**
   * @param int $refId
   * @param string $elementId
   * @param int $imageId
   */
  public function renderRemoveEntry( $mediaId, $elementId, $imageId)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-mediathek-'.$elementId.'-file-table tr.node-'.$imageId;
    $pageFragment->action = 'remove';

    $tpl->setArea('mediathek', $pageFragment);

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-mediathek-{$elementId}-file-table').grid('renderRowLayout').grid('decEntries');

WGTJS;

    $tpl->addJsCode($jsCode);

  }//end public function renderRemoveEntry */

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param int $refId
   * @param string $elementId
   * @param array $data
   */
  public function renderSearch($mediaId, $elementId, $data)
  {

    $tpl = $this->getTplEngine();

    $pageFragment = new WgtAjaxArea();
    $pageFragment->selector = 'table#wgt-grid-mediathek-'.$elementId.'-file-table>tbody';
    $pageFragment->action   = 'html';

    $mediathekElement = new WgtElementMediathek();
    $mediathekElement->idKey = $elementId;
    $mediathekElement->mediaId = $mediaId;
    $mediathekElement->dataFile = $data;

    $pageFragment->setContent($mediathekElement->renderFileSearch($elementId));

    $tpl->setArea('mediathek', $pageFragment);

    $numElem = count($data);

    $jsCode = <<<WGTJS

  \$S('table#wgt-grid-mediathek-{$elementId}-file-table').grid('renderRowLayout').grid('setNumEntries','{$numElem}');

WGTJS;

    $tpl->addJsCode($jsCode);

  }//end public function renderSearch */

} // end class WebfrapMediathek_File_Ajax_View */


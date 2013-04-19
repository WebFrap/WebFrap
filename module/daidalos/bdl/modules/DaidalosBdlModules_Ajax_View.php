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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlModules_Ajax_View extends LibTemplateAjaxView
{

  /**
   * @var DaidalosBdlModules_Model
   */
  public $model = null;

  /**
   * @var array
   */
  public $modIcons = array();

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return void
   */
  public function displayChildNode( $params)
  {

    $this->modIcons = array
    (
      'actions' => $this->view->icon('daidalos/bdl/actions.png' , 'Actions'   ),
      'charts' => $this->view->icon('daidalos/bdl/charts.png' , 'Charts'   ),
      'components' => $this->view->icon('daidalos/bdl/components.png' , 'Components'   ),
      'data' => $this->view->icon('daidalos/bdl/data.png' , 'Data'   ),
      'desktops' => $this->view->icon('daidalos/bdl/desktops.png' , 'Desktops'   ),
      'documents' => $this->view->icon('daidalos/bdl/documents.png' , 'Documents'   ),
      'docus' => $this->view->icon('daidalos/bdl/docu.png' , 'Docu'   ),
      'entities' => $this->view->icon('daidalos/bdl/entities.png' , 'Entities'   ),
      'enums' => $this->view->icon('daidalos/bdl/enums.png' , 'Enums'   ),
      'items' => $this->view->icon('daidalos/bdl/items.png' , 'Items'   ),
      'managements' => $this->view->icon('daidalos/bdl/managements.png' , 'Managements'   ),
      'menus' => $this->view->icon('daidalos/bdl/menus.png' , 'Menus'   ),
      'modules' => $this->view->icon('daidalos/bdl/modules.png' , 'Modules'   ),
      'module' => $this->view->icon('daidalos/bdl/modules.png' , 'Modules'   ),
      'processes' => $this->view->icon('daidalos/bdl/processes.png' , 'Processes'   ),
      'profiles' => $this->view->icon('daidalos/bdl/profiles.png' , 'Profiles'   ),
      'roles' => $this->view->icon('daidalos/bdl/roles.png' , 'Roles'   ),
      'users' => $this->view->icon('daidalos/bdl/roles.png' , 'Users'   ),
      'messages' => $this->view->icon('daidalos/bdl/messages.png' , 'Messages'   ),
      'services' => $this->view->icon('daidalos/bdl/services.png' , 'Services'   ),
      'widgets' => $this->view->icon('daidalos/bdl/widgets.png' , 'Widgets'   ),
    );

    $modPath = $this->model->getSubModulePath();

    $htmlNode = $this->renderChildNode($modPath, $this->model->nodeKey);

    $this->setAreaContent('childNode', <<<XML
<htmlArea selector="li#wgt-tree-module-{$this->model->key}-{$this->model->nodeKey}" action="replace" ><![CDATA[
{$htmlNode}
]]></htmlArea>
XML
    );

    $this->addJsCode("\$S('wgt-tree-module-{$this->model->key}').treeview({});");

  }//end public function displayList */

  /**
   * @param string $path
   * @return string
   */
  protected function renderChildNode($path, $innerPath)
  {

    $iconFolder = $this->view->icon('control/folder.png' , 'Folder'   );
    $iconFile   = $this->view->icon('daidalos/bdl_file.png' , 'File'   );
    $iconDelete = $this->view->icon('control/delete.png' , 'Delete'   );

    $htmlNode = '';

    $subModules = $this->model->getSubModuleFolders($path);

    foreach ($subModules as $subModule) {

      $subFoldes = $this->renderChildNode($path.'/'.$subModule, $innerPath.'/'.$subModule);

      $files = $this->model->getSubModuleFiles($path.'/'.$subModule);

      $fileHtml = '';

      foreach ($files as $file) {
        $fileHtml .= <<<HTML
      <li>
        <a
            href="maintab.php?c=Daidalos.BdlModeller.openEditor&amp;key={$this->model->key}&amp;bdl_file={$innerPath}/{$subModule}/{$file}"
            class="wcm wcm_req_ajax" >{$iconFile} {$file}</a>
        <div class="right" style="width:50px;" >
          <button
            class="wgt-button wgtac_delete_file"
            wgt_idx="{$innerPath}/{$subModule}/{$file}" >{$iconDelete}</button>
        </div>
        <div class="right bw3" ></div>
        <div class="wgt-clear tiny" >&nbsp;</div>
      </li>
HTML;
      }

      if (isset($this->modIcons[$subModule])) {
        $folderIcon = $this->modIcons[$subModule];
        $headClass  = 'wgt-head';
      } else {
        $folderIcon = $iconFolder;
        $headClass  = '';
      }

      $htmlNode .= <<<HTML
      <li style="border-bottom:1px solid silver;" >
        <p class="{$headClass}" >{$folderIcon} {$subModule}</p>
        <ul>
         {$subFoldes}
         {$fileHtml}
        </ul>
      </li>
HTML;

    }

    return $htmlNode;

  }//end protected function renderChildNode */

}//end class DaidalosBdlModules_Ajax_View


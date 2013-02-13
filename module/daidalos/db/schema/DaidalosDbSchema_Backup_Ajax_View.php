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
class DaidalosDbSchema_Backup_Ajax_View
  extends LibTemplateAjaxView
{
  
  /**
   * @var DaidalosBdlModules_Model
   */
  public $model = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param TFlag $params
   * @return void
   */
  public function displayRestore(  $params )
  {
    
    $response = $this->getResponse();
    
    $response->addMessage( 'Sucessfully restored dump' );

  }//end public function displayRestore */
  
  /**
   * @param string $dbKey
   * @param string $schemaKey
   * @param string $dumpKey
   * @param TFlag $params
   * @return void
   */
  public function displayDelete(  $dbKey, $schemaKey, $dumpKey, $params )
  {

    $fHash = md5($dumpKey);

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="tr#wgt-row-{$dbKey}-{$schemaKey}-{$fHash}" action="remove" />
XML
    );

  }//end public function displayDelete */
  
  
  /**
   * @param LibUploadFile $uplDump
   * @param string $schemaKey
   * @param string $dumpKey
   * @param TFlag $params
   * @return void
   */
  public function displayUpload( $uplDump, $dbKey, $schemaKey, $params )
  {
    
    $iconRestore = Wgt::icon( 'control/restore.png' );
    $iconDel     = Wgt::icon( 'control/delete.png' );
    
    $file = new IoFile( PATH_GW."data/backups/db/{$dbKey}/schemas/{$schemaKey}/".$uplDump->getOldname() );
    
    $fileName = $uplDump->getOldname();
    
    $fDate = date( 'Y-m-d H:i:s', $file->getTimeCreated() );
    $fSize = $file->getSize( 'mb' );
    
    $fHash = md5($fileName);

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="table#wgt-table-db_dumps-{$dbKey}-{$schemaKey}>tbody" action="append" ><![CDATA[
<tr id="wgt-row-{$dbKey}-{$schemaKey}-{$fHash}" >
  <td></td>
  <td><a href="protected?file=backups/db/{$dbKey}/schemas/{$schemaKey}/{$fileName}" >{$fileName}</a></td>
  <td>{$fDate}</td>
  <td>{$fSize} MB</td>
  <td><button 
    class="wgt-button"
    onclick="\$R.put('ajax.php?c=Daidalos.DbSchema.restoreDump&db={$dbKey}&schema={$schemaKey}&dump={$fileName}');" >{$iconRestore}</button> | <button 
    
    onclick="\$R.del('ajax.php?c=Daidalos.DbSchema.deleteDump&db={$dbKey}&schema={$schemaKey}&dump={$fileName}');"
    class="wgt-button" >{$iconDel}</button></td>
</tr>]]>
</htmlArea>
XML
    );

  }//end public function displayUpload */
  
  
  
  
 

}//end class DaidalosBdlModules_Ajax_View


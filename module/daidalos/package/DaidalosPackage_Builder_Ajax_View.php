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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosPackage_Builder_Ajax_View
  extends LibTemplateAjaxView
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

    
  /**
   * 
   * @param string $package
   * @param string $fileName
   * @param TFlag $params
   * @return void
   */
  public function displayDelete(  $package, $fileName, $params )
  {

    $fHash = md5($fileName);

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="tr#wgt-row-daidalos-package-{$package}-{$fHash}" action="remove" />
XML
    );
    
    $response = $this->getResponse();
    $response->addMessage( 'Successfully deleted package: '.$fileName );

  }//end public function displayDelete */
  
  /**
   * @param string $package
   * @param string $fileName
   * @param TFlag $params
   * @return void
   */
  public function displayBuild( $package, $fileName, $params )
  {

    $iconDel = Wgt::icon( 'control/delete.png' );
    
    $file    = new IoFile( PATH_GW."data/package/{$params->type}/{$package}/{$fileName}" );

    $fDate   = date( 'Y-m-d H:i:s', $file->getTimeCreated() );
    $fSize   = $file->getSize( 'mb' );
    
    $fHash = md5($fileName);

    $this->setAreaContent( 'childNode', <<<XML
<htmlArea selector="table#wgt-table-daidalos-package-{$package}-packages>tbody" action="append" ><![CDATA[
  <tr id="wgt-row-daidalos-package-{$package}-{$fHash}" >
    <td></td>
    <td><a href="protected.php?file=package/{$params->type}/{$package}/{$fileName}" >{$fileName}</a></td>
    <td>{$fDate}</td>
    <td>{$fSize} MB</td>
    <td><button 
      onclick="\$R.del('ajax.php?c=Daidalos.Package.deletePackage&type={$params->type}&package={$package}&file={$fileName}');"
      class="wgt-button" >{$iconDel}</button></td>
  </tr>]]>
</htmlArea>
XML
    );
    
    $response = $this->getResponse();
    $response->addMessage( 'Successfully created package: '.$fileName );

  }//end public function displayBuild */


}//end class DaidalosPackage_Builder_Ajax_View


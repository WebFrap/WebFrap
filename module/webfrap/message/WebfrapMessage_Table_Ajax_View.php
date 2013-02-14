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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Ajax_View extends LibTemplatePlain
{
/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displaySearch( $params )
  {

    $params->qsize  = 25;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;
    $params->searchFormId = 'wgt-form-groupware_message-search';


    $data = $this->model->fetchMessages( $params );

    $table = new WebfrapMessage_Table_Element( 'messageList', $this );
    $table->setId( 'wgt-table-groupware_message' );

    $table->setData( $data );
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));
    
    $table->setPagingId( $params->searchFormId );

    $actions   = array();
    $actions[] = 'show';
    $actions[] = 'respond';
    $actions[] = 'forward';
    $actions[] = 'archive';

    $table->addActions( $actions );
    
    // set refresh to true, to embed the content of this element inside
    // of the ajax.tpl index as "htmlarea"
    $table->refresh    = true;

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;
    
    if( $params->append  )
    {
      $table->setAppendMode( true );
      $table->buildAjax();

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth');
  
WGTJS;
      $view->addJsCode( $jsCode );

    }
    else
    {
      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth').grid('setNumEntries', {$table->dataSize});

WGTJS;

      $this->addJsCode( $jsCode );

      $table->buildHtml();
    }

  }//end public function displayOpen */



} // end class WebfrapMessage_Ajax_View */


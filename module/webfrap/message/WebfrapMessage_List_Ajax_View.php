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
class WebfrapMessage_List_Ajax_View
  extends LibTemplateAjaxView
{
////////////////////////////////////////////////////////////////////////////////
// display methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Render des Suchergebnisses und übergabe in die ajax response
   * @param string $elementId
   */
  public function displaySearch( $params )
  {

    // benötigte resourcen laden
    $user     = $this->getUser();
    $acl      = $this->getAcl();
    $request  = $this->getRequest();

    $params->qsize  = 50;

    // die query muss für das paging und eine korrekte anzeige
    // die anzahl der gefundenen datensätze ermitteln
    $params->loadFullSize = true;

    $params->searchFormId = 'wgt-form-message-search';

    $data = $this->model->fetchMessages( $params );

    $table = new WebfrapMessage_Table_Element( 'messageList', $this );
    $table->setId( 'wgt-table-my_message' );
    $table->access = $params->access;

    $table->setData( $data );
    $table->addAttributes(array
    (
      'style' => 'width:99%;'
    ));

    $table->setPagingId( $params->searchFormId );

    $actions   = array();
    $actions[] = 'show';
    $actions[] = 'sep';
    $actions[] = 'reply';
    $actions[] = 'forward';
    $actions[] = 'sep';
    $actions[] = 'delete';

    $table->addActions( $actions );

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    if ($params->append) {
      $table->setAppendMode( true );
      $table->buildAjax();

      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth');

WGTJS;
      $this->addJsCode( $jsCode );

    } else {
      $jsCode = <<<WGTJS

  \$S('table#{$table->id}-table').grid('renderRowLayout').grid('syncColWidth').grid('setNumEntries', {$table->dataSize});

WGTJS;

      $this->addJsCode( $jsCode );

      $table->buildHtml();
    }

    $this->setAreaContent( 'wgt-table-message', $table->buildAjaxArea() );

  }//end public function displaySearch */

} // end class WebfrapMessage_Ajax_View */

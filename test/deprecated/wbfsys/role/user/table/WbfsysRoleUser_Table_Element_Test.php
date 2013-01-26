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
 * @package WebFrapUnit
 * @subpackage WebFrap
 */
class WbfsysRoleUser_Table_Element_Test
  extends LibTestUnit
{
/*//////////////////////////////////////////////////////////////////////////////
// access checks
//////////////////////////////////////////////////////////////////////////////*/

 

  /**
   * prüen ob das Table Element valides xml erzeugt
   */
  public function test_renderDefHtml()
  {

    // Testdata und STUB View
    $view   = new LibTemplate_Stub();
    $data   = new WbfsysRoleUser_Table_TestData_Container();
    $params = new WbfsysRoleUser_Table_Params_RootHtml();
    $access = new WbfsysRoleUser_Table_Access_RootHtml();
    
    $access->load( 'default', $params );
    // end STUB code

   // Erstellen des Template Elements
    $table = new WbfsysRoleUser_Table_Element( 'tableWbfsysRoleUser', $view );

    // die daten direkt dem element übergeben
    $table->setData( $data );

    // den access container dem listenelement übergeben
    $table->setAccess( $access );
    $table->setAccessPath( $params, $params->aclKey, $params->aclNode );

    // set the offset to set the paging menu correct
    $table->start    = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if( $params->begin )
      $table->begin    = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    if( $params->targetId )
      $table->setId( $params->targetId );

    // definieren der aktions
    // die prüfung welche actions jeweils erlaubt sind passiert dann im
    // menu builder
    $actions = array();

    $actions[] = 'show';
    $actions[] = 'edit';
    $actions[] = 'delete';
    $actions[] = 'rights';

    $table->addActions( $actions );

    // Die ID des Suchformulars wir für das Paging benötigt, details, siehe apidoc
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-wbfsys_role_user-search';


    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search
    $table->setPagingId( $params->searchFormId );

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simplem Suchfeld
    $tablePanel = new WgtPanelTable( $table );

    //$tablePanel->title = $view->i18n->l( 'System User', 'wbfsys.role_user.label' );
    $tablePanel->searchKey = 'wbfsys_role_user';

    // display the toggle button for the advanced search
    $tablePanel->advancedSearch = true;

      
    $html = $table->buildHtml();
    
    $testHtml = "<html>{$html}</html>";
    
    $testDom = new DOMDocument();
    
    $loadSuccess = $testDom->loadHTML( $testHtml );
    
    if( !$loadSuccess )
    {
      $this->failed( "Failed to load the Generated HTML for Table WbfsysRoleUser_Table_Element" );
    }


  }//end public function test_renderDefHtml */
  
  
  /**
   * prüen ob das Table Element valides xml erzeugt
   * /
  public function test_renderDefAjax()
  {

    // Testdata und STUB View
    $view   = new LibTemplate_Stub();
    $data   = new Prototype_Table_TestData_Container();
    $params = new Prototype_Table_ParamsVar1();
    $access = new Prototype_Table_AccessVar1();

   // Erstellen des Template Elements
    $table = new WbfsysRoleUser_Table_Element( 'tableWbfsysRoleUser', $view );

    // die daten direkt dem element übergeben
    $table->setData( $data );

    // den access container dem listenelement übergeben
    $table->setAccess( $access );
    $table->setAccessPath( $params, $params->aclKey, $params->aclNode );

    // set the offset to set the paging menu correct
    $table->start    = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if( $params->begin )
      $table->begin    = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    if( $params->targetId )
      $table->setId( $params->targetId );

    if( !is_null( $params->listingActions ) )
    {
      $table->addActions( $params->listingActions );
    }
    else
    {

      // definieren der aktions
      // die prüfung welche actions jeweils erlaubt sind passiert dann im
      // menu builder
      $actions = array();

      // wenn editieren nicht erlaubt ist geht zumindest das anzeigen
      $actions[] = 'show';
      $actions[] = 'edit';
      $actions[] = 'delete';
      $actions[] = 'rights';

      $table->addActions( $actions );
    }

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search

    // Die ID des Suchformulars wir für das Paging benötigt, details, siehe apidoc
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-wbfsys_role_user-search';

    $table->setPagingId( $params->searchFormId );

    // Über Listenelemente können Eigene Panelcontainer gepackt werden
    // hier verwenden wir ein einfaches Standardpanel mit Titel und
    // simplem Suchfeld
    $tablePanel = new WgtPanelTable( $table );

    //$tablePanel->title = $view->i18n->l( 'System User', 'wbfsys.role_user.label' );
    $tablePanel->searchKey = 'wbfsys_role_user';

    // display the toggle button for the advanced search
    $tablePanel->advancedSearch = true;

    // set refresh to true, to embed the content of this element inside
    // of the ajax.tpl index as "htmlarea"
    $table->refresh    = true;

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    $table->buildHtml();
    
  }//end public function test_renderDefAjax */

  
  /**
   * prüen ob das Table Element valides xml erzeugt
   * /
  public function test_renderAppendAjax()
  {

    // Testdata und STUB View
    $view   = new LibTemplate_Stub();
    $data   = new Prototype_Table_TestData_Container();
    $params = new Prototype_Table_ParamsVar1();
    $access = new Prototype_Table_AccessVar1();

   // Erstellen des Template Elements
    $table = new WbfsysRoleUser_Table_Element( 'tableWbfsysRoleUser', $view );

    // die daten direkt dem element übergeben
    $table->setData( $data );

    // den access container dem listenelement übergeben
    $table->setAccess( $access );
    $table->setAccessPath( $params, $params->aclKey, $params->aclNode );

    // set the offset to set the paging menu correct
    $table->start    = $params->start;

    // set the position for the size menu
    $table->stepSize = $params->qsize;

    // check if there is a filter for the first char
    if( $params->begin )
      $table->begin    = $params->begin;

    // if there is a given tableId for the html id of the the table replace
    // the default id with it
    if( $params->targetId )
      $table->setId( $params->targetId );

    if( !is_null( $params->listingActions ) )
    {
      $table->addActions( $params->listingActions );
    }
    else
    {

      // definieren der aktions
      // die prüfung welche actions jeweils erlaubt sind passiert dann im
      // menu builder
      $actions = array();

      // wenn editieren nicht erlaubt ist geht zumindest das anzeigen
      $actions[] = 'show';
      $actions[] = 'edit';
      $actions[] = 'delete';
      $actions[] = 'rights';

      $table->addActions( $actions );
    }

    // for paging use the default search form, to enshure to keep the order
    // and to page in search results if there was any search

    // Die ID des Suchformulars wir für das Paging benötigt, details, siehe apidoc
    if( !$params->searchFormId )
      $params->searchFormId = 'wgt-form-table-wbfsys_role_user-search';

    $table->setPagingId( $params->searchFormId );

    // set refresh to true, to embed the content of this element inside
    // of the ajax.tpl index as "htmlarea"
    $table->refresh    = true;

    // the table should only replace the content inside of the container
    // but not the container itself
    $table->insertMode = false;

    $table->setAppendMode( true );
    $table->buildAjax();
    
  }//end public function test_renderAppendAjax */

} //end class Prototype_Entity_Test


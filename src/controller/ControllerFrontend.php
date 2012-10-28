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
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 *
 */
class ControllerFrontend
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * get the form flags for this management
   * @param TFlag $params
   * @return TFlag
   */
  protected function getFormFlags( $params = null )
  {

    $request = $this->getRequest();

    if( !$params )
      $params = new TFlag();

    // the publish type, like selectbox, tree, table..
    if( $publish  = $request->param( 'publish', Validator::CNAME ) )
      $params->publish   = $publish;

    // if of the target element, can be a table, a tree or whatever
    if( $targetId = $request->param( 'target_id', Validator::CKEY ) )
      $params->targetId  = $targetId;

    // callback for a target function in thr browser
    if( $target   = $request->param( 'target', Validator::CKEY ) )
      $params->target    = $target;

    // target mask key
    if( $targetMask = $request->param( 'target_mask', Validator::CNAME ) )
      $params->targetMask  = $targetMask;

    // target mask key
    if( $refId = $request->param( 'refid', Validator::INT ) )
      $params->refId  = $refId;

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $params->aclRoot    = $aclRoot;

    // die maske des root startpunktes
    if( $maskRoot = $request->param( 'm_root', Validator::TEXT ) )
      $params->maskRoot    = $maskRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $params->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;

    // der neue knoten
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;

    // per default
    $params->categories = array();

    return $params;

  }//end protected function getFormFlags */

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getCrudFlags( $params = null )
  {

    $request = $this->getRequest();

    // create named parameters object
    if( !$params )
      $params = new TFlag();

    // the publish type, like selectbox, tree, table..
    if( $publish  = $request->param( 'publish', Validator::CNAME ) )
      $params->publish   = $publish;

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

    // context
    if( $context   = $request->param( 'context', Validator::CNAME ) )
      $params->context    = $context;

    // if of the target element, can be a table, a tree or whatever
    if( $targetId = $request->param( 'target_id', Validator::CKEY ) )
      $params->targetId  = $targetId;


    // callback for a target function in thr browser
    if( $target   = $request->param( 'target', Validator::CNAME ) )
      $params->target    = $target;

    // mask key
    if( $mask = $request->param( 'mask', Validator::CNAME ) )
      $params->mask  = $mask;

    // mask key
    if( $viewType = $request->param( 'view', Validator::CNAME ) )
      $params->viewType  = $viewType;

    // mask key
    if( $viewId = $request->param( 'view_id', Validator::CKEY ) )
      $params->viewId  = $viewId;

    // soll die maske neu geladen werden?
    if( $reload = $request->param( 'reload', Validator::BOOLEAN ) )
      $params->reload  = $reload;

    // refid
    if( $refid = $request->param( 'refid', Validator::INT ) )
      $params->refId  = $refid;

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $params->aclRoot    = $aclRoot;

    // die maske des root startpunktes
    if( $maskRoot = $request->param( 'm_root', Validator::TEXT ) )
      $params->maskRoot    = $maskRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $params->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;

    // der neue knoten
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;

    // per default
    $params->categories = array();

    return $params;

  }//end protected function getCrudFlags */

 /**
  * @lang de:
  * Auslesen der Listingflags
  *
  * @get_param: cname ltype,
  *   Der Type der des Listenelements. Sollte sinnigerweise
  *   der gleich type wie das Listenelement sein, für das die Suche angestoßen wurde
  *
  * @get_param: cname view_type,
  *   Der genaue View Type, zb. Maintab, Subwindow etc.,
  *   welcher verwendet wurde den eintrag zu erstellen.
  *   Wird benötigt um im client die maske ansprechen zu können
  *
  * @get_param: cname mask,
  *   Mask ist ein key mit dem angegeben wird welche
  *   View genau verwendet werden soll. Dieser Parameter ist nötig, da es pro
  *   tabelle mehrere management sichten geben kann die jeweils eigenen
  *   listenformate haben
  *
  * @get_param: cname refid,
  *   Wird benötigt wenn dieser Datensatz in Relation
  *   zu einem Hauptdatensatz als referenz in einem Tab, bzw ManyToX Element
  *   erstellt wurde.
  *
  * @get_param: cname view_id,
  *   Die genaue ID der Maske. Wird benötigt um
  *   die Maske bei der Rückgabe adressieren zu können
  *
  * @get_param: boolean append,
  *   Flag das bei der Suche und dem Paging
  *   in listenelementen zu einsatz kommt, wenn übergeben und true
  *   werden die daten die zum client gepusht werden im listenelement
  *   im body angehängt, standard aktion wäre das überschreiben
  *   des body inhaltes
  *
  * @get_param: ckey a_root,
  *   Die Rootarea des Pfades über den wir gerade in den rechten wandeln
  *
  * @get_param: ckey a_key,
  *   Der key des knotens auf dem wir uns im pfad gerade befinden
  *
  * @get_param: int a_level,
  *   Die aktuelle position im ACL Pfad
  *
  * @param TFlag $params
  *
  * @return TFlag
  */
  protected function getListingFlags( $params = null )
  {

    $request = $this->getRequest();

    if( !$params )
      $params = new TFlag();

    // the publish type, like selectbox, tree, table..
    if( $publish  = $request->param( 'publish', Validator::CNAME ) )
      $params->publish   = $publish;

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

    // input type
    if( $input = $request->param( 'input', Validator::CKEY ) )
      $params->input    = $input;

    // input type
    if( $suffix = $request->param( 'suffix', Validator::CKEY ) )
      $params->suffix    = $suffix;

    // append ist das flag um in listenelementen die einträge
    // anhängen zu lassen anstelle den body zu pagen
    if( $append = $request->param( 'append', Validator::BOOLEAN ) )
      $params->append    = $append;

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $params->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $params->aclRootId    = $aclRootId;

    // die maske des root startpunktes
    if( $maskRoot = $request->param( 'm_root', Validator::TEXT ) )
      $params->maskRoot    = $maskRoot;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;

    // der neue knoten
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;

    // per default
    $params->categories = array();

    if( 'selectbox' === $params->publish )
    {

      // fieldname of the calling selectbox
      $params->field
        = $request->param( 'field', Validator::CNAME );

      // html id of the calling selectbox
      $params->inputId
        = $request->param( 'input_id', Validator::CKEY );

      // html id of the table
      $params->targetId
        = $request->param( 'target_id', Validator::CKEY );

      // html id of the calling selectbox
      $params->target
        = str_replace('_','.',$request->param('target',Validator::CKEY ));

    }
    else
    {

      // start position of the query and size of the table
      $params->start
        = $request->param('start', Validator::INT );

      // stepsite for query (limit) and the table
      if( !$params->qsize = $request->param('qsize', Validator::INT ) )
        $params->qsize = Wgt::$defListSize;

      // order for the multi display element
      $params->order
        = $request->param('order', Validator::CNAME );

      // target for a callback function
      $params->target
        = $request->param('target', Validator::CKEY  );

      // target for some ui element
      $params->targetId
        = $request->param('target_id', Validator::CKEY  );

      // flag for beginning seach filter
      if( $text = $request->param('begin', Validator::TEXT  ) )
      {
        // whatever is comming... take the first char
        $params->begin = $text[0];
      }

      // the model should add all inputs in the ajax request, not just the text
      // converts per default to false, thats ok here
      $params->fullLoad
        = $request->param('full_load', Validator::BOOLEAN );

      // exclude whatever
      $params->exclude
        = $request->param('exclude', Validator::CKEY  );

      // keyname to tageting ui elements
      $params->keyName
        = $request->param('key_name', Validator::CKEY  );

      // the activ id, mostly needed in exlude calls
      $params->objid
        = $request->param('objid', Validator::EID  );

    // mask key
    if( $viewId = $request->param( 'view_id', Validator::CKEY ) )
      $params->viewId  = $viewId;

    }

    return $params;

  }//end protected function getListingFlags */


  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getTabFlags( $params = null )
  {

    $request = $this->getRequest();

    if( !$params )
      $params = new TFlag();

    // per default
    $params->categories = array();

    // listing type
    if( $ltype   = $request->param( 'ltype', Validator::CNAME ) )
      $params->ltype    = $ltype;

    // context type
    if( $context = $request->param( 'context', Validator::CNAME ) )
      $params->context    = $context;

    // start position of the query and size of the table
    $params->start
      = $request->param('start', Validator::INT );

    // stepsite for query (limit) and the table
    if( !$params->qsize = $request->param('qsize', Validator::INT ) )
      $params->qsize = Wgt::$defListSize;

    // order for the multi display element
    $params->order
      = $request->param('order', Validator::CNAME );

    // target for a callback function
    $params->target
      = $request->param('target', Validator::CKEY  );

    // target for some ui element
    $params->targetId
      = $request->param('target_id', Validator::CKEY  );

    // target for some ui element
    $params->tabId
      = $request->param('tabid', Validator::CKEY  );

    // flag for beginning seach filter
    if( $text = $request->param('begin', Validator::TEXT  ) )
    {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    // exclude whatever
    $params->exclude
      = $request->param('exclude', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $params->objid
      = $request->param('objid', Validator::EID  );

     // mask key
    if( $viewId = $request->param( 'view_id', Validator::CKEY ) )
      $params->viewId  = $viewId;

    // startpunkt des pfades für die acls
    if( $aclRoot = $request->param( 'a_root', Validator::CKEY ) )
      $params->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if( $aclRootId = $request->param( 'a_root_id', Validator::INT ) )
      $params->aclRootId    = $aclRootId;

    // die maske des root startpunktes
    if( $maskRoot = $request->param( 'm_root', Validator::TEXT ) )
      $params->maskRoot    = $maskRoot;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if( $aclKey = $request->param( 'a_key', Validator::CKEY ) )
      $params->aclKey    = $aclKey;

    // an welchem punkt des pfades befinden wir uns?
    if( $aclLevel = $request->param( 'a_level', Validator::INT ) )
      $params->aclLevel  = $aclLevel;

    // der neue knoten
    if( $aclNode = $request->param( 'a_node', Validator::CKEY ) )
      $params->aclNode    = $aclNode;


    return $params;

  }//end protected function getTabFlags */

} // end class ControllerFrontend

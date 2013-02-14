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
 * @copyright webfrap.net <contact@webfrap.net>
 */
class WebfrapPeople_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Qualified User Handling
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * the default table for the management WbfsysAnnouncement
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_search($request, $response )
  {

    // load request parameters an interpret as flags
    $params = $this->getListingFlags($request);

    $user = $this->getUser();

    $access = new WebfrapPeople_Access_List_Container( null, null, $this );
    $access->load($user->getProfileName(), $params );

    // ok wenn er nichtmal lesen darf, dann ist hier direkt schluss
    if (!$access->listing )
    {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception
      (
        $response->i18n->l
        (
          'You have no permission to call this service!',
          'wbf.message'
        ),
        Response::FORBIDDEN
      );
    }

    // der Access Container des Users für die Resource wird als flag übergeben
    $params->access = $access;


    $model = $this->loadModel( 'WebfrapPeople' );

    $view   = $this->tpl->loadView( 'WebfrapPeople_Ajax' );
    $view->setModel($model );

    $searchKey  = $request->param('key', Validator::TEXT );

    $error = $view->displayAutocomplete($searchKey, $params );


    // Die Views geben eine Fehlerobjekt zurück, wenn ein Fehler aufgetreten
    // ist der so schwer war, dass die View den Job abbrechen musste
    // alle nötigen Informationen für den Enduser befinden sich in dem
    // Objekt
    // Standardmäßig entscheiden wir uns mal dafür diese dem User auch Zugänglich
    // zu machen und übergeben den Fehler der ErrorPage welche sich um die
    // korrekte Ausgabe kümmert
    if ($error )
    {
      return $error;
    }

    // wunderbar, kein fehler also melden wir einen Erfolg zurück
    return null;


  }//end public function service_loadQfdUsers */


/*//////////////////////////////////////////////////////////////////////////////
// parse flags
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getListingFlags($request)
  {

    $response  = $this->getResponse();
    
    $params = new TFlag();

    // input type
    if ($suffix = $request->param('suffix', Validator::CKEY))
      $params->suffix    = $suffix;

    // append entries
    if ($append = $request->param('append', Validator::BOOLEAN))
      $params->append    = $append;

    // startpunkt des pfades für die acls
    if ($aclRoot = $request->param('a_root', Validator::CKEY))
      $params->aclRoot    = $aclRoot;

    // die id des Datensatzes von dem aus der Pfad gestartet wurde
    if ($aclRootId = $request->param('a_root_id', Validator::INT))
      $params->aclRootId    = $aclRootId;

    // der key des knotens auf dem wir uns im pfad gerade befinden
    if ($aclKey = $request->param('a_key', Validator::CKEY))
      $params->aclKey    = $aclKey;

    // der name des knotens
    if ($aclNode = $request->param('a_node', Validator::CKEY))
      $params->aclNode    = $aclNode;

    // an welchem punkt des pfades befinden wir uns?
    if ($aclLevel = $request->param('a_level', Validator::INT))
      $params->aclLevel  = $aclLevel;


    // start position of the query and size of the table
    $params->start
      = $request->param('start', Validator::INT );

    // stepsite for query (limit) and the table
    if (!$params->qsize = $request->param('qsize', Validator::INT))
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
    if ($text = $request->param('begin', Validator::TEXT  ) )
    {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    // the model should add all inputs in the ajax request, not just the text
    // converts per default to false, thats ok here
    $params->fullLoad
      = $request->param('full_load', Validator::BOOLEAN );


    // keyname to tageting ui elements
    $params->keyName
      = $request->param('key_name', Validator::CKEY  );

    // the activ id, mostly needed in exlude calls
    $params->objid
      = $request->param('objid', Validator::EID  );


    return $params;

  }//end protected function getListingFlags */

  

} // end class WbfsysAnnouncement_Acl_Qfdu_Controller */


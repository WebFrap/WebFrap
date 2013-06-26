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
class WebfrapUnique_Controller extends Controller
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $options           = array
  (
    'check' => array(
      'method'    => array('GET'),
      'views'      => array('ajax')
    ),
  );


/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Standard Service für Autoloadelemente wie zb. Window Inputfelder
   * Über diesen Service kann analog zu dem Selection / Search Service
   * Eine gefilterte Liste angefragt werden um Zuweisungen zu vereinfachen
   *
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_check($request, $response)
  {

    // resource laden
    $user     = $this->getUser();
    $orm     = $this->getOrm();
    $db     = $this->getDb();
    $acl      = $this->getAcl();

    $dkey = $request->param('dkey',Validator::CNAME);

    $domainNode = DomainNode::getNode($dkey);

    // check the permissions
    if (!$acl->access( $domainNode->domainAcl.':listing')) {
      // ausgabe einer fehlerseite und adieu
      throw new InvalidRequest_Exception(
        $response->i18n->l(
          'You have no permission to access {@service@}',
          'wbf.message',
          array(
            'service' => $response->i18n->l('Unique Check', 'wbf.label')
          )
        ),
        Response::FORBIDDEN
      );
    }

    $fName   = $request->param('fname',Validator::CNAME);
    $chkVal  = $request->param('val',Validator::SEARCH);
    $objid  = $request->param('objid',Validator::EID);

    $domainEnt = $orm->newEntity($domainNode->srcKey);

    if (!$domainEnt->isColUnique($fName)) {
        throw new InvalidRequest_Exception(
        $response->i18n->l(
          'Invalid Fieldname',
          'wbf.message'
         ),
        Response::FORBIDDEN
      );
    }

    $extWhere = '';
    if ($objid)
      $extWhere = ' AND NOT rowid = '.$objid;

    $isUnique = $db->select(
    	"SELECT count({$fName}) as num FROM {$domainEnt->getTable()}  where {$fName} = '{$db->escape($chkVal)}' {$extWhere}"
    )->getField('num');


    // setzen des Erfolgstatus im Response objekt
    // Das ist der wert, der als HTTP Header zurückgegeben wird
    $tpl = $this->getTpl();
    $tpl->setJsonData($isUnique);

  }//end public function service_unique */


}//end class WebfrapUnique_Controller


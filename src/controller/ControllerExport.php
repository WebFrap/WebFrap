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
class ControllerExport
  extends Controller
{

  /**
   * @param TFlag $params
   * @return TFlag
   */
  protected function getExportFlags( $params = null )
  {

    if( !$params )
      $params = new TFlag();

    // per default
    $params->categories = array();

    // get the type for the export format
    $params->type
      = $this->request->param('type', Validator::CNAME );

      // start position of the query and size of the table
    $this->offset
      = $request->param('offset', Validator::INT );

    // start position of the query and size of the table
    $this->start
      = $request->param('start', Validator::INT );
      
    if( $this->offset )
    {
      if( !$this->start )
        $this->start = $this->offset;
    }

    // stepsite for query (limit) and the table
    if( !$params->qsize = $this->request->param('qsize', Validator::INT ) )
      $params->qsize = '-1';

    // order for the multi display element
    $params->order
      = $this->request->param('order', Validator::CNAME );

    // flag for beginning seach filter
    if( $text = $this->request->param('begin', Validator::TEXT  ) )
    {
      // whatever is comming... take the first char
      $params->begin = $text[0];
    }

    // the activ id, mostly needed in exlude calls
    $params->objid
      = $this->request->param('objid', Validator::EID  );

    return $params;

  }//end protected function getExportFlags */

} // end class ControllerExport

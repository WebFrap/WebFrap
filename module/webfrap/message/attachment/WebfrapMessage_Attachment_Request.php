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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Attachment_Request extends Context
{
/*//////////////////////////////////////////////////////////////////////////////
// Aspects
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var int
   */
  public $msgId = null;
  
  /**
   * @var array
   */
  public $data = array();
  
  /**
   * @var array
   */
  public $file = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {
    
    $this->file = $request->file('file');

    if (!$this->file || !is_object($this->file)) {
      throw new InvalidRequest_Exception(
        Error::INVALID_REQUEST,
        Error::INVALID_REQUEST_MSG
      );
    }
    
    $this->msgId = $request->data('msg', Validator::EID);

    $this->data['id_type'] = $request->data('type', Validator::EID);
    $this->data['flag_versioning'] = $request->data('version', Validator::BOOLEAN);
    $this->data['description']  = $request->data('description', Validator::TEXT);
    $this->data['id_confidentiality'] = $request->data('id_confidentiality', Validator::EID);

    $this->interpretRequestAcls($request);
    
  }//end public function interpretRequest */

}//end class WebfrapMessage_Attachment_Request */


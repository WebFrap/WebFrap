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
class WebfrapMessage_Checklist_Request extends Context
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
    
    parent::interpretRequest($request);
    
    $saveFields = array();
    $saveFields['checklist'][] = 'label';
    $saveFields['checklist'][] = 'flag_checked';
    $saveFields['checklist'][] = 'vid';
    $saveFields['checklist'][] = 'priority';


    try{

      // if the validation fails report
      $this->dataBody = $request->validateMultiSave(
        'WbfsysChecklistEntry',
        'checklist',
        $saveFields['checklist']
      );

      return null;

    } catch(InvalidInput_Exception $e) {
    
      return $e;
    }
    
  }//end public function interpretRequest */

}//end class WebfrapMessage_Attachment_Request */


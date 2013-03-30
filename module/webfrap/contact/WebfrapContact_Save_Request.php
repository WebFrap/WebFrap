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
class WebfrapContact_Save_Request extends Context
{
/*//////////////////////////////////////////////////////////////////////////////
// Aspects
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var true
   */
  public $hasErrors = false;

  /**
   * @var int
   */
  public $personId = null;
  /**
   * @var int
   */
  public $contactId = null;
  
  /**
   * @var int
   */
  public $person = array();
  
  /**
   * @var int
   */
  public $contact = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {
    

    $this->personId = $request->data('person_id',Validator::EID); 
    $this->contactId = $request->data('contact_id',Validator::EID); 
    
    $personFields = array(
      'firstname',
      'lastname',
      'title_before',
      'title_middle',
      'title_after',
      'photo',
      'birthday',
      'id_preflang',
      'id_nationality'
    );
    
    $contactFields = array(
      'description'
    );

    try {

      //management  project_activity source project_activity
      if ($this->personId) {
        
        $this->person = $orm->get('CorePerson',$this->personId);
        
        // if the validation fails report
        $httpRequest->validateUpdate(
          $entityPerson,
          'person',
          $personFields
        );
        
      } else {
        
        $entityPerson = $orm->newEntity('CorePerson');
        
        // if the validation fails report
        $httpRequest->validateInsert(
          $entityPerson,
          'person',
          $personFields
        );
        
      }
      
      //management  project_activity source project_activity
      if ($this->contactId) {
        
        $this->contact = $orm->get('WbfsysContact',$this->contactId);
        
        // if the validation fails report
        $httpRequest->validateUpdate(
          $this->contact,
          'contact',
          $contactFields
        );
        
      } else {
        
        $this->contact = $orm->newEntity('WbfsysContact');
        
        // if the validation fails report
        $httpRequest->validateInsert(
          $this->contact,
          'contact',
          $contactFields
        );
        
        $this->contact->id_person = $entityPerson;
        
      }

      $this->hasErrors = $this->getResponse()->hasErrors();
      
    } catch(InvalidInput_Exception $e) {
      
      return null;
    }
    
    

    $this->interpretRequestAcls($request);
    
  }//end public function interpretRequest */

}//end class WebfrapMessage_Save_Request */


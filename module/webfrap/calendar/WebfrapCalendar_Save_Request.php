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
class WebfrapCalendar_Save_Request extends Context
{
/*//////////////////////////////////////////////////////////////////////////////
// Aspects
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @var array
   */
  public $aspects = array();
  
  /**
   * @var int
   */
  public $receiverId = null;
  
  /**
   * @var boolean
   */
  public $hasTask = false;
  
  /**
   * @var int
   */
  public $taskId = null;
  
  /**
   * @var boolean
   */
  public $hasAppointment = null;
  
  /**
   * @var int
   */
  public $appointId = null;
  
  /**
   * @var int
   */
  public $receiverData = array();
  
  /**
   * @var int
   */
  public $taskData = array();
  
  /**
   * @var int
   */
  public $appointData = array();
  
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {
    
    $aspStack = $request->data('aspect', Validator::INT);
    
    foreach ($aspStack as $asp) {
      if ($asp)
        $this->aspects[] = $asp;
    }
    
    $this->aspects[] = $request->data('paspect', Validator::INT);
    
    
    $this->receiverId = $request->data('receiver_id',Validator::EID); 
    $this->receiverData['flag_participation_required'] = $request->data('receiver',Validator::BOOLEAN,'part_required'); 
    $this->receiverData['flag_action_required'] = $request->data('receiver',Validator::BOOLEAN,'action_required'); 
    
    if (in_array(EMessageAspect::APPOINTMENT, $this->aspects)) {
      $this->hasAppointment = true;
      $this->appointData['timestamp_start'] = $request->data('appointment',Validator::TIMESTAMP,'start'); 
      $this->appointData['timestamp_end'] = $request->data('appointment',Validator::TIMESTAMP,'end'); 
      $this->appointData['flag_all_day'] = $request->data('appointment',Validator::BOOLEAN,'all_day'); 
      $this->appointData['id_category'] = $request->data('appointment',Validator::INT,'category'); 
      $this->appointData['location_text'] = $request->data('appointment',Validator::TEXT,'location'); 
    }
    // wenn vorhanden ohne aspekt, löschen
    $this->appointId = $request->data('appoint_id',Validator::EID); 
    
    if (in_array(EMessageAspect::TASK, $this->aspects)) {
      $this->hasTask = true;
      $this->taskData['deadline'] = $request->data('task',Validator::TIMESTAMP,'deadline'); 
      $this->taskData['flag_urgent'] = $request->data('task',Validator::BOOLEAN,'urgent'); 
      $this->taskData['status'] = $request->data('task',Validator::INT,'status'); 
    }
    // wenn vorhanden ohne aspekt, löschen
    $this->taskId = $request->data('task_id',Validator::EID); 
    
    
    
    Debug::console('$this->aspects',$this->aspects,null,true);

    $this->interpretRequestAcls($request);
    
  }//end public function interpretRequest */

}//end class WebfrapMessage_Save_Request */


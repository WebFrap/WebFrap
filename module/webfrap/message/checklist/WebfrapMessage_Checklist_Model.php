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
 * @subpackage Groupware
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMessage_Checklist_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

    /**
   * @param WebfrapMessage_Attachment_Request $userRequest
   * @return WbfsysEntityAttachment_Entity
   */
  public function save($formData)
  {

    $orm       = $this->getOrm();
    $db        = $this->getDb();
    $user      = $this->getUser();
    $response  = $this->getResponse();
    
    $savedIds = array();

    try {
    
      // start a transaction in the database
      $db->begin();


      $entityTexts = array();

      foreach ($formData->dataBody as $entityEntry) {

        if ($entityEntry->isNew()) {

          if (!$orm->insert($entityEntry)) {
            $entityText = $entityEntry->text();

            $response->addError("Failed to create entry: {$entityText}" );

          } else {

            $entityTexts[] = $entityEntry->text();
            $savedIds[$entityEntry->getId()] = $entityEntry->tmpId;
          }

        } else {

          if (!$orm->update($entityEntry)) {
            
            $entityText = $entityEntry->text();
            $response->addError("Failed to save entry: {$entityText}" );
            
          } else {

            $entityTexts[] = $entityEntry->text();         
            $savedIds[$entityEntry->getId()] = $entityEntry->getId();
            
          }
        }
      }

      $textSaved = implode($entityTexts, ', ');
      $response->addMessage( 'Successfully saved Project: '.$textSaved);
      
      // everything ok
      $db->commit();

    } catch(LibDb_Exception $e) {

      $db->rollback();
      return $savedIds;
      
    } catch(WebfrapSys_Exception $e) {

      return $savedIds;
    }

    // check if there were any errors, if not fine
    return $savedIds;

  }//end public function save */

  
  /**
   * @param int $delId
   * @param Context $params
   */
  public function delete($delId, $params)
  {
    
    $orm = $this->getOrm();
    $attachEnt = $orm->delete("WbfsysChecklistEntry",$delId);
    
  }//end public function delete */
  
} // end class WebfrapMessage_Checklist_Model


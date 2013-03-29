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
class WebfrapMessage_Attachment_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  public $file = null;
  
  public $attachment = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

    /**
   * @param WebfrapMessage_Attachment_Request $userRequest
   * @return WbfsysEntityAttachment_Entity
   */
  public function insert($userRequest)
  {

    $orm = $this->getOrm();

    $checkSum = $userRequest->file->getChecksum();
    $fileSize = $userRequest->file->getSize();

    $fileNode = $orm->newEntity("WbfsysFile");
    $fileNode->name = $userRequest->file->getNewname();
    $fileNode->file_hash = $checkSum;
    $fileNode->file_size = $fileSize;
    $fileNode->id_type = $userRequest->data['id_type'];
    $fileNode->mimetype = $userRequest->file->getFiletype();
    $fileNode->flag_versioning = $userRequest->data['flag_versioning'];
    $fileNode->id_confidentiality = $userRequest->data['id_confidentiality'];
    $fileNode->description = $userRequest->data['description'];

    $fileNode = $orm->insert($fileNode);
    
    $this->file = $fileNode;

    if (!$fileNode)
      throw new LibUploadException('Failed to upload file');

    $fileId = $fileNode->getId();

    $filePath = PATH_GW.'data/uploads/wbfsys_file/name/'.SParserString::idToPath($fileId);
    $userRequest->file->copy($fileId, $filePath);

    $attachmentNode = $orm->newEntity("WbfsysEntityAttachment");
    $attachmentNode->vid = $userRequest->msgId;
    $attachmentNode->id_file = $fileNode;

    $attachmentNode = $orm->insert($attachmentNode);
    
    $this->attachment = $attachmentNode;

    return $attachmentNode;

  }//end public function insert */
  
} // end class WebfrapMessage_Attachment_Model


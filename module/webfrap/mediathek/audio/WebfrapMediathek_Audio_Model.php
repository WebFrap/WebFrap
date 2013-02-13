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
 * @licence BSD
 */
class WebfrapMediathek_Audio_Model
  extends Model
{

  /**
   * @param int $refId
   * @param LibUploadEntity $file
   * @param int $type
   * @param boolean $versioning
   * @param int $confidentiality
   * @param description $description
   * @return WbfsysEntityAttachment_Entity
   */
  public function uploadFile( $refId, $file, $type, $versioning, $confidentiality, $description )
  {
    
    $orm = $this->getOrm();
    
    $checkSum = $file->getChecksum();
    $fileSize = $file->getSize();
    
    $fileNode = $orm->newEntity( "WbfsysFile" );
    $fileNode->name = $file->getNewname();
    $fileNode->file_hash = $checkSum;
    $fileNode->file_size = $fileSize;
    $fileNode->mimetype = $file->getFiletype();
    $fileNode->flag_versioning = $versioning;
    $fileNode->id_confidentiality = $confidentiality;
    $fileNode->description = $description;
    
    $fileNode = $orm->insert( $fileNode );
  
    $fileId = $fileNode->getId();
    
    $filePath = PATH_GW.'data/uploads/wbfsys_file/name/'.SParserString::idToPath($fileId);
    $file->copy( $fileId, $filePath );
    
    $attachmentNode = $orm->newEntity( "WbfsysEntityAttachment" );
    $attachmentNode->vid = $refId;
    $attachmentNode->id_file = $fileNode;
    
    $attachmentNode = $orm->insert( $attachmentNode );
    
    return $attachmentNode;

  }//end public function uploadFile */
  
  
  /**
   * 
   * Enter description here ...
   * @param int $refId
   * @param string $link
   * @param int $type
   * @param int $storage
   * @param int $confidentiality
   * @param description $description
   * 
   * @return WbfsysEntityAttachment_Entity
   */
  public function addLink( $refId, $link, $type, $storage, $confidentiality, $description )
  {
    
    $orm = $this->getOrm();

    $fileNode = $orm->newEntity( "WbfsysFile" );
    $fileNode->link = $link;
    $fileNode->id_type = $type;
    $fileNode->id_storage = $storage;
    $fileNode->id_confidentiality = $confidentiality;
    $fileNode->description = $description;
    $fileNode = $orm->insert( $fileNode );

    
    $attachmentNode = $orm->newEntity( "WbfsysEntityAttachment" );
    $attachmentNode->vid = $refId;
    $attachmentNode->id_file = $fileNode;
    
    $attachmentNode = $orm->insert( $attachmentNode );
    
    return $attachmentNode;

  }//end public function addFile */
  
  /**
   * @param int $objid
   * @param LibUploadEntity $file
   * @param int $type
   * @param boolean $versioning
   * @param int $confidentiality
   * @param description $description
   * @return void
   */
  public function saveFile( $objid, $file, $type, $versioning, $confidentiality, $description )
  {
    
    $orm = $this->getOrm();
    
    $fileNode = $orm->get( "WbfsysFile", $objid );
    
    if( $file && is_object($file) )
    {
      $checkSum = $file->getChecksum();
      $fileSize = $file->getSize();
      
      $fileNode->name = $file->getNewname();
      $fileNode->file_hash = $checkSum;
      $fileNode->file_size = $fileSize;
      $fileNode->mimetype  = $file->getFiletype();
      
      $fileId = $fileNode->getId();
      
      $filePath = PATH_GW.'data/uploads/wbfsys_file/name/'.SParserString::idToPath($fileId);
      $file->copy( $fileId, $filePath );
      
    }
    
    $fileNode->flag_versioning = $versioning;
    $fileNode->description     = $description;
    $fileNode->id_confidentiality = $confidentiality;
    
    $fileNode = $orm->update( $fileNode );

  }//end public function saveFile */
  
  
  /**
   * @param int $objid
   * @param string $link
   * @param int $type
   * @param int $storage
   * @param int $confidentiality
   * @param description $description
   * 
   * @return WbfsysEntityAttachment_Entity
   */
  public function saveLink( $objid, $link, $type, $storage, $confidentiality, $description )
  {
    
    $orm = $this->getOrm();

    $fileNode = $orm->get( "WbfsysFile", $objid );
    $fileNode->link = $link;
    $fileNode->id_type = $type;
    $fileNode->id_storage = $storage;
    $fileNode->description = $description;
    $fileNode->id_confidentiality = $confidentiality;
    
    $orm->update( $fileNode );

  }//end public function saveLink */
  
  /**
   * @param int $attachmentId
   * @return WbfsysFile_Entity
   */
  public function loadFile( $attachmentId )
  {
    
    $orm = $this->getOrm();
    
    $fileNode = $orm->getWhere
    (
    	'WbfsysFile', 
    	"rowid in(select wea.id_file from wbfsys_entity_attachment wea where wea.rowid = {$attachmentId})" 
    );
    
    return $fileNode;
    
  }//end public function loadFile */

  
  /**
   * @param int $refId
   * @return int
   */
  public function cleanAttachments( $refId )
  {
    
    $orm    = $this->getOrm(  );
    $orm->deleteWhere( 'WbfsysEntityAttachment', "vid=".$refId );

  }//end public function cleanAttachments */
  
  /**
   * @param int $objid
   * @return int
   */
  public function disconnect( $objid )
  {
    
    $orm    = $this->getOrm(  );
    $orm->delete( 'WbfsysEntityAttachment', $objid );

  }//end public function disconnect */
  
  /**
   * @param int $attachId
   * @return int
   */
  public function deleteFile( $attachId )
  {
    
    $orm    = $this->getOrm(  );
    
    $fileId = $orm->getField( 'WbfsysEntityAttachment', $attachId, 'id_file' );

    // datei löschen
    $orm->delete( 'WbfsysFile', $fileId );
    
    $filePath = PATH_GW.'data/uploads/wbfsys_file/name/'.SParserString::idToPath($fileId).$fileId;
    
    // löschen des hochgeladenen files
    SFilesystem::delete( $filePath );
    
    // andere attachments löschen
    $orm->deleteWhere( 'WbfsysEntityAttachment', "id_file=".$fileId );

  }//end public function deleteFile */

  
  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   * 
   * @return LibDbPostgresqlResult
   */
  public function getAttachmentList( $refId = null, $entryId = null, $searchString = null  )
  {
    
    $db = $this->getDb();
    
    $condEntry  = '';
    $condAttach = '';
    
    if( $refId )
    {
      $condAttach = " attach.vid = {$refId}";
    }
    else if( $entryId )
    {
      $condEntry = " attach.rowid = {$entryId}";
    }
    else
    {
      return array();
    }
    
    $condSearch = '';
    if( $searchString )
    {
      
      $condSearch = <<<SQL
      and
      ( 
      	upper(file.name) like upper('%{$searchString}%') 
      		or upper(file.link) like upper('%{$searchString}%') 
      )
SQL;

    }
    

    $sql = <<<SQL
SELECT 
  attach.rowid as attach_id,
  attach.m_time_created as time_created,
  file.rowid  as file_id,
  file.name as file_name,
  file.link as file_link,
  file.file_size as file_size,
  file.mimetype as mimetype,
  file.description as description,
  file_type.name as file_type,
  file_storage.name as storage_name,
  file_storage.link as storage_link,
  confidential.access_key as confidential_level,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name,
  person.wbfsys_role_user_rowid as user_id

FROM 
  wbfsys_entity_attachment attach

JOIN 
  wbfsys_file file
    on file.rowid = attach.id_file
  
JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = attach.m_role_create
    
LEFT JOIN 
  wbfsys_file_type file_type
    on file_type.rowid = file.id_type
    
LEFT JOIN 
  wbfsys_file_storage file_storage
    on file_storage.rowid = file.id_storage
    
LEFT JOIN 
  wbfsys_confidentiality_level confidential
    on confidential.rowid = file.id_confidentiality
    
WHERE
  {$condAttach}
	{$condEntry}
	{$condSearch}
ORDER BY
  attach.m_time_created desc;
  
SQL;
    

	  if( $entryId )
	  {
	    return $db->select( $sql )->get();
	  }
	  else 
	  {
	    return $db->select( $sql )->getAll();
	  }
	
  }//end public function getAttachmentList */
  
/*//////////////////////////////////////////////////////////////////////////////
// Repository Management Logic
//////////////////////////////////////////////////////////////////////////////*/

  
  /**
   * @param int $storageId
   * @return WbfsysFileStorage_Entity
   */
  public function loadStorage( $storageId )
  {
    
    $orm = $this->getOrm();
    
    $storageNode = $orm->get
    (
    	'WbfsysFileStorage', 
    	$storageId
    );
    
    return $storageNode;
    
  }//end public function loadStorage */

  /**
   * 
   * Enter description here ...
   * @param int $refId
   * @param string $name
   * @param string $link
   * @param int $type
   * @param int $confidentiality
   * @param description $description
   * 
   * @return WbfsysEntityAttachment_Entity
   */
  public function addStorage( $refId, $name, $link, $type, $confidentiality, $description )
  {
    
    $orm = $this->getOrm();

    $storageNode = $orm->newEntity( "WbfsysFileStorage" );
    $storageNode->name = $name;
    $storageNode->link = $link;
    $storageNode->id_type = $type;
    $storageNode->id_confidentiality = $confidentiality;
    $storageNode->description = $description;
    $storageNode = $orm->insert( $storageNode );

    
    $refNode = $orm->newEntity( "WbfsysEntityFileStorage" );
    $refNode->vid = $refId;
    $refNode->id_storage = $storageNode;
    
    $refNode = $orm->insert( $refNode );
    
    return $storageNode;

  }//end public function addStorage */
  
  /**
   * @param int $objid
   * @param string $name
   * @param string $link
   * @param int $type
   * @param int $confidentiality
   * @param description $description
   * 
   * @return WbfsysEntityAttachment_Entity
   */
  public function saveStorage( $objid, $name, $link, $type, $confidentiality, $description )
  {
    
    $orm = $this->getOrm();

    $storageNode = $orm->get( "WbfsysFileStorage", $objid );
    $storageNode->name = $name;
    $storageNode->link = $link;
    $storageNode->id_type = $type;
    $storageNode->description = $description;
    $storageNode->id_confidentiality = $confidentiality;
    
    $orm->update( $storageNode );

  }//end public function saveStorage */
  
  /**
   * @param int $attachId
   * @return int
   */
  public function deleteStorage( $storageId )
  {
    
    $orm    = $this->getOrm(  );
    
    $orm->delete( 'WbfsysFileStorage', $storageId );

    // andere attachments löschen
    $orm->deleteWhere( 'WbfsysEntityFileStorage', "id_storage=".$storageId );

  }//end public function deleteStorage */
  
  
  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   * 
   * @return LibDbPostgresqlResult
   */
  public function getStorageList( $refId = null, $entryId = null, $searchString = null )
  {
    
    $db = $this->getDb();
    
    $condEntry  = '';
    $condAttach = '';
    
    if( $refId )
    {
      $condAttach = " ref.vid = {$refId}";
    }
    else if( $entryId )
    {
      $condEntry = " storage.rowid = {$entryId}";
    }
    else
    {
      return array();
    }
    
    $condSearch = '';
    if( $searchString )
    {
      
      $condSearch = <<<SQL
      and
      ( 
      	upper(storage.name) like upper('%{$searchString}%') 
      		or upper(storage.link) like upper('%{$searchString}%') 
      )
SQL;

    }
    

    $sql = <<<SQL
SELECT 
  storage.rowid as storage_id,
  storage.name  as storage_name,
  storage.link  as storage_link,
  storage.description  as storage_description,
	storage_type.name as type_name,
  confidential.access_key as confidential_level
	
FROM 
  wbfsys_file_storage storage
JOIN 
 	wbfsys_entity_file_storage ref
 		ON ref.id_storage = storage.rowid

LEFT JOIN 
  wbfsys_file_storage_type storage_type
    on storage_type.rowid = storage.id_type
 
LEFT JOIN 
  wbfsys_confidentiality_level confidential
    on confidential.rowid = storage.id_confidentiality
    
WHERE
  {$condAttach}
	{$condEntry}
	{$condSearch}
ORDER BY
  storage.name;
  
SQL;
    

	  if( $entryId )
	  {
	    return $db->select( $sql )->get();
	  }
	  else 
	  {
	    return $db->select( $sql )->getAll();
	  }
	
  }//end public function getStorageList */
  
} // end class WebfrapAttachment_Model



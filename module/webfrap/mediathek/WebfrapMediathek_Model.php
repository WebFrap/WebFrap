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
class WebfrapMediathek_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Die Rowid der mediathek
   * @var int
   */
  public $mediaId = null;
  
  /**
   * Die Rowid der mediathek
   * @var WbfsysMediathek_Entity
   */
  public $nodeMediathek = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * @param DomainNode $domainNode
   * @param Entity $dataNode
   */
  public function autoSetupMediathek($domainNode, $dataNode = null )
  {
    
    $orm = $this->getOrm();

    $appendLabel = '';
    $appendKey   = '';
    
    if ($dataNode )
    {
      $appendLabel = ' '.$dataNode->getId();
      $appendKey   = '-'.$dataNode->getId();
    }
    
    $mediathek = $orm->newEntity( 'WbfsysMediathek' );
    $mediathek->name      = $domainNode->label.$appendLabel;
    $mediathek->access_key = $domainNode->domainName.$appendKey;
    
    if ($dataNode )
      $mediathek->vid = $dataNode->getId();
    
    $mediathek->id_vid_entity = $orm->getResourceId($domainNode->srcKey );
    $mediathek->flag_system = true;
    
    $mediathek = $orm->insert($mediathek );
    
    $this->nodeMediathek = $mediathek;
    $this->mediaId      = $mediathek->getId();
    
    return $mediathek;
    
  }//end public function autoSetupMediathek */
  
  /**
   * @param stdObject $data
   */
  public function setupMediathek($data )
  {
    
  }//end public function setupMediathek */
  
  /**
   * @param DomainNode $domainNode
   * @param Entity $dataNode
   */
  public function loadMediathek($domainNode, $dataNode = null )
  {
    
    $orm = $this->getOrm();
    
    $key = $domainNode->domainName;
    
    if ($dataNode )
    {
      $key .= '-'.$dataNode->getId();
    }
    
    $mediathek = $orm->getByKey( 'WbfsysMediathek', $key );
    
    if (is_null($mediathek ) )
    {
      $mediathek = $this->autoSetupMediathek($domainNode, $dataNode );
    } else {
      $this->mediaId       = $mediathek->getId();
      $this->nodeMediathek  = $mediathek;
    }
  
    return $this->nodeMediathek;
    
  }//end public function loadMediathek */
  
  /**
   * @param int $mediaId
   */
  public function loadMediathekById($mediaId )
  {
    
    $orm = $this->getOrm();

    $mediathek = $orm->get( 'WbfsysMediathek', $mediaId );
    
    if (is_null($mediathek) )
      return $mediathek;
    
    $this->mediaId       = $mediathek->getId();
    $this->nodeMediathek  = $mediathek;
  
    return $this->nodeMediathek;
    
  }//end public function loadMediathekById */
  
/*//////////////////////////////////////////////////////////////////////////////
// getter für die daten
//////////////////////////////////////////////////////////////////////////////*/
 
  /**
   * @param int $mediaId
   * @param int $entryId
   * @param string $searchString
   * 
   * @return LibDbPostgresqlResult
   */
  public function getImageList($mediaId = null, $entryId = null, $searchString = null  )
  {
    
    $db = $this->getDb();
    
    $condEntry  = '';
    $condMedia = '';
    
    if ($mediaId )
    {
      $condMedia = " img.id_mediathek = {$mediaId}";
    }
    else if ($entryId )
    {
      $condEntry = " img.rowid = {$entryId}";
    } else {
      return array();
    }
    
    $condSearch = '';
    if ($searchString )
    {
      
      $condSearch = <<<SQL
      and
      ( 
      	upper(img.file) like upper('%{$searchString}%') 
      		or upper(img.title) like upper('%{$searchString}%') 
      )
SQL;

    }
    

    $sql = <<<SQL
SELECT 
  img.rowid  as img_id,
  img.title  as img_title,
  img.file 	 as img_file,
  img.width 	 as img_width,
  img.height 	 as img_height,
  img.file_size 	 as img_size,
  img.file_hash as img_hash,
  img.m_time_created as img_created,
  img.m_version as img_version,
  img.mimetype as img_mimetype,
  confidential.access_key as confidential_level,
  confidential.label as confidential_label,
  licence.rowid as licence_id,
  licence.name as licence_name,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name,
  person.wbfsys_role_user_rowid as user_id

FROM 
  wbfsys_image img

JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = img.m_role_create
    
LEFT JOIN 
  wbfsys_confidentiality_level confidential
    on confidential.rowid = img.id_confidentiality
    
LEFT JOIN 
  wbfsys_content_licence licence
    on licence.rowid = img.id_licence
    
WHERE
  {$condMedia}
	{$condEntry}
	{$condSearch}
ORDER BY
  img.m_time_created desc;
  
SQL;
    

	  if ($entryId )
	  {
	    return $db->select($sql )->get();
	  }
	  else 
	  {
	    return $db->select($sql )->getAll();
	  }
	
  }//end public function getImageList */
  
  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   * 
   * @return LibDbPostgresqlResult
   */
  public function getVideoList($mediaId = null, $entryId = null, $searchString = null  )
  {
    
    $db = $this->getDb();
    
    $condEntry  = '';
    $condMedia = '';
    
    if ($mediaId )
    {
      $condMedia = " video.id_mediathek = {$mediaId}";
    }
    else if ($entryId )
    {
      $condEntry = " video.rowid = {$entryId}";
    } else {
      return array();
    }
    
    $condSearch = '';
    if ($searchString )
    {
      
      $condSearch = <<<SQL
      and
      ( 
      	upper(video.file) like upper('%{$searchString}%') 
      		or upper(video.title) like upper('%{$searchString}%') 
      )
SQL;

    }
    

    $sql = <<<SQL
SELECT 
  video.rowid  as video_id,
  video.title  as video_title,
  video.file 	 as video_file,
  video.width 	 as video_width,
  video.height 	 as video_height,
  video.length 	 as video_length,
  video.m_version as video_version,
  confidential.access_key as confidential_level,
  licence.rowid as licence_id,
  licence.name as licence_name,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name,
  person.wbfsys_role_user_rowid as user_id

FROM 
  wbfsys_video video

JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = video.m_role_create
    
LEFT JOIN 
  wbfsys_confidentiality_level confidential
    on confidential.rowid = video.id_confidentiality
    
LEFT JOIN 
  wbfsys_content_licence licence
    on licence.rowid = video.id_licence
    
WHERE
  {$condMedia}
	{$condEntry}
	{$condSearch}
ORDER BY
  video.m_time_created desc;
  
SQL;
    

	  if ($entryId )
	  {
	    return $db->select($sql )->get();
	  }
	  else 
	  {
	    return $db->select($sql )->getAll();
	  }
	
  }//end public function getVideoList */
  
  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   * 
   * @return LibDbPostgresqlResult
   */
  public function getAudioList($mediaId = null, $entryId = null, $searchString = null  )
  {
    
    $db = $this->getDb();
    
    $condEntry  = '';
    $condMedia = '';
    
    if ($mediaId )
    {
      $condMedia = " audio.id_mediathek = {$mediaId}";
    }
    else if ($entryId )
    {
      $condEntry = " audio.rowid = {$entryId}";
    } else {
      return array();
    }
    
    $condSearch = '';
    if ($searchString )
    {
      
      $condSearch = <<<SQL
      and
      ( 
      	upper(audio.file) like upper('%{$searchString}%') 
      		or upper(audio.title) like upper('%{$searchString}%') 
      )
SQL;

    }
    

    $sql = <<<SQL
SELECT 
  audio.rowid  as audio_id,
  audio.title  as audio_title,
  audio.file 	 as audio_file,
  audio.length as audio_length,
  audio.m_version as audio_version,
  confidential.access_key as confidential_level,
  licence.rowid as licence_id,
  licence.name as licence_name,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name,
  person.wbfsys_role_user_rowid as user_id

FROM 
  wbfsys_audio audio

JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = audio.m_role_create
    
LEFT JOIN 
  wbfsys_confidentiality_level confidential
    on confidential.rowid = audio.id_confidentiality
    
LEFT JOIN 
  wbfsys_content_licence licence
    on licence.rowid = audio.id_licence
    
WHERE
  {$condMedia}
	{$condEntry}
	{$condSearch}
ORDER BY
  audio.m_time_created desc;
  
SQL;
    

	  if ($entryId )
	  {
	    return $db->select($sql )->get();
	  }
	  else 
	  {
	    return $db->select($sql )->getAll();
	  }
	
  }//end public function getAudioList */
  
  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   * 
   * @return LibDbPostgresqlResult
   */
  public function getDocumentList($mediaId = null, $entryId = null, $searchString = null  )
  {
    
    $db = $this->getDb();
    
    $condEntry  = '';
    $condMedia = '';
    
    if ($mediaId )
    {
      $condMedia = " document.id_mediathek = {$mediaId}";
    }
    else if ($entryId )
    {
      $condEntry = " document.rowid = {$entryId}";
    } else {
      return array();
    }
    
    $condSearch = '';
    if ($searchString )
    {
      
      $condSearch = <<<SQL
      and
      ( 
      	upper(document.file) like upper('%{$searchString}%') 
      		or upper(document.title) like upper('%{$searchString}%') 
      )
SQL;

    }
    

    $sql = <<<SQL
SELECT 
  document.rowid  as document_id,
  document.title  as document_title,
  document.file 	as document_file,
  document.m_version as document_version,
  confidential.access_key as confidential_level,
  licence.rowid as licence_id,
  licence.name as licence_name,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name,
  person.wbfsys_role_user_rowid as user_id

FROM 
  wbfsys_document document

JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = document.m_role_create
    
LEFT JOIN 
  wbfsys_confidentiality_level confidential
    on confidential.rowid = document.id_confidentiality
    
LEFT JOIN 
  wbfsys_content_licence licence
    on licence.rowid = document.id_licence
    
WHERE
  {$condMedia}
	{$condEntry}
	{$condSearch}
ORDER BY
  document.m_time_created desc;
  
SQL;
    

	  if ($entryId )
	  {
	    return $db->select($sql )->get();
	  }
	  else 
	  {
	    return $db->select($sql )->getAll();
	  }
	
  }//end public function getDocumentList */
  
  /**
   * @param int $refId
   * @param int $entryId
   * @param string $searchString
   * 
   * @return LibDbPostgresqlResult
   */
  public function getFileList($mediaId = null, $entryId = null, $searchString = null  )
  {
    
    $db = $this->getDb();
    
    $condEntry  = '';
    $condMedia = '';
    
    if ($mediaId )
    {
      $condMedia = " file.id_mediathek = {$mediaId}";
    }
    else if ($entryId )
    {
      $condEntry = " file.rowid = {$entryId}";
    } else {
      return array();
    }
    
    $condSearch = '';
    if ($searchString )
    {
      
      $condSearch = <<<SQL
      and
      ( 
      	upper(file.file) like upper('%{$searchString}%') 
      		or upper(file.title) like upper('%{$searchString}%') 
      )
SQL;

    }
    

    $sql = <<<SQL
SELECT 
  file.rowid  as file_id,
  file.name 	 as file_name,
  file.file_size 	 as file_size,
  file.file_hash as file_hash,
  file.m_time_created as file_created,
  file.m_version as file_version,
  file.mimetype as file_mimetype,
  file.description as file_description,
  confidential.access_key as confidential_level,
  confidential.label as confidential_label,
  licence.rowid as licence_id,
  licence.name as licence_name,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name,
  person.wbfsys_role_user_rowid as user_id

FROM 
  wbfsys_file file

JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = file.m_role_create
    
LEFT JOIN 
  wbfsys_confidentiality_level confidential
    on confidential.rowid = file.id_confidentiality
    
LEFT JOIN 
  wbfsys_content_licence licence
    on licence.rowid = file.id_licence
    
WHERE
  {$condMedia}
	{$condEntry}
	{$condSearch}
ORDER BY
  file.m_time_created desc;
  
SQL;
    

	  if ($entryId )
	  {
	    return $db->select($sql )->get();
	  }
	  else 
	  {
	    return $db->select($sql )->getAll();
	  }
	
  }//end public function getFileList */
  
} // end class WebfrapAttachment_Model



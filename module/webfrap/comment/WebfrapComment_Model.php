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
class WebfrapComment_Model
  extends Model
{


  /**
   * @param string $commentName
   * @param string $commentName
   * @param int $refId
   * @param int $parent
   * @return WbfsysComment_Entity
   */
  public function addComment(  $title, $comment, $refId, $parent )
  {
    
    $orm = $this->getOrm();
    
    $commentNode = $orm->newEntity( "WbfsysComment" );
    $commentNode->title   = $title;
    $commentNode->content = $comment;
    $commentNode->vid     = $refId;
    $commentNode->m_parent  = $parent;
    $commentNode = $orm->insert( $commentNode );
    return $commentNode;

  }//end public function addComment */

  
  /**
   * @param string $commentName
   * @param string $commentName
   * @param int $refId
   * @param int $parent
   * @return WbfsysComment_Entity
   */
  public function saveComment( $rowid, $title, $comment )
  {
    
    $orm = $this->getOrm();
    
    $commentNode = $orm->get( "WbfsysComment", $rowid );
    $commentNode->title   = $title;
    $commentNode->content = $comment;
    $commentNode = $orm->update( $commentNode );
    return $commentNode;

  }//end public function saveComment */
  
  /**
   * @param int $refId
   * @return int
   */
  public function cleanComments( $refId )
  {
    
    $orm    = $this->getOrm(  );
    $orm->deleteWhere( 'WbfsysComment', "vid=".$refId );

  }//end public function cleanDsetTags */
  
  /**
   * @param int $objid
   * @return int
   */
  public function delete( $objid )
  {
    
    $orm    = $this->getOrm(  );
    $orm->delete( 'WbfsysComment', $objid );

  }//end public function delete */

  
  /**
   * @param string $key
   * @param int $refId
   * 
   * @return LibDbPostgresqlResult
   */
  public function getCommentTree( $refId  )
  {
    
    $db = $this->getDb();

    $sql = <<<SQL
SELECT 
  comment.rowid as id,
  comment.title as title,
  comment.rate as rate,
  comment.content as content,
  comment.m_time_created as time_created,
  comment.m_parent as parent,
  comment.m_role_create as creator_id,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name

FROM 
  wbfsys_comment comment
  
JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = comment.m_role_create
    
WHERE
  comment.vid = {$refId}

ORDER BY
  comment.m_time_created desc;
  
SQL;
    
    $comments = array();
    
    $tmp = $db->select( $sql )->getAll();

    foreach( $tmp as $com )
    {
      $comments[(int)$com['parent']][] = $com; 
      //$comments[0][] = $com; // erst mal kein baum
    }

    return $comments;
    
  }//end public function getCommentTree */
  
  /**
   * @param int $entryId
   * 
   * @return array
   */
  public function getCommentEntry( $entryId  )
  {
    
    $db = $this->getDb();

    $sql = <<<SQL
SELECT 
  comment.rowid as id,
  comment.title as title,
  comment.rate as rate,
  comment.content as content,
  comment.m_time_created as time_created,
  comment.m_parent as parent,
  person.core_person_firstname as firstname,
  person.core_person_lastname as lastname,
  person.wbfsys_role_user_name as user_name

FROM 
  wbfsys_comment comment
  
JOIN
  view_person_role person
    ON person.wbfsys_role_user_rowid = comment.m_role_create
    
WHERE
  comment.rowid = {$entryId};
SQL;
    

    // es wird nur ein Eintrag erwartet
    return $db->select( $sql )->get();
    
  }//end public function getCommentTree */
  
  /**
   * 
   * @param WebfrapComment_Context $context
   * @param int $refId
   * 
   * @return LibAclPermission
   */
  public function loadAccessContainer( $context )
  {
    
     $domainNode = DomainNode::getNode( $context->refMask );
     
     if( !$domainNode )
       throw new InvalidRequest_Exception( 'Requested invalid mask rights' );
       
     if( !$context->refId )
       throw new InvalidRequest_Exception( 'Missing refid' );
    
     $className = SFormatStrings::subToCamelCase( $domainNode->aclDomainKey ).'_Crud_Access_Dataset';
     
     if( !Webfrap::classLoadable( $className ) )
       throw new InvalidRequest_Exception( 'Requested invalid mask rights' );
       
     $refId = $context->refId;
       
     if( $context->refField )
     {
       $orm = $this->getOrm();
       
       $entity = $orm->get( $domainNode->srcKey,  $context->refField." = '{$refId}'" );
       
       if( !$entity )
         throw new InvalidRequest_Exception( 'Requested invalid mask rights' );
         
       $refId = $entity->getId();
     }
       
     $this->access = new $className();
     $this->access->loadDefault( new TFlag(), $refId );
     
     return $this->access;
    
  }//end public function loadAccessContainer */
  
} // end class WebfrapComment_Model



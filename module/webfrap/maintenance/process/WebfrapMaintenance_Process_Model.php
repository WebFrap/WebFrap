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
 * @subpackage maintenance/process
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapMaintenance_Process_Model
  extends MvcModel_Domain
{
  
  /**
   * @var Process
   */
  public $process = null;
  
  /**
   * @var Entity
   */
  public $entity = null;
  
  public $processStatus = null;
  
  public $processNode = null;
  
  /**
   * @var DomainNode
   */
  public $domainNode  = null;
  
////////////////////////////////////////////////////////////////////////////////
// Methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function getProcesses(  )
  {
    
    $db = $this->getDb();
    
    $query = <<<SQL
SELECT
  process.rowid as id,
  process.name,
  process.access_key,
  process.id_entity,
  ent.access_key as entity_name,
  process.description
  
FROM

  wbfsys_process process
JOIN
	wbfsys_entity ent
		ON ent.rowid = process.id_entity

  ;

SQL;

    return $db->select( $query );
    
  }//end public function getProcesses */
  
  /**
   * @return WbfsysProcess_Entity
   */
  public function getProcessById( $idProcess )
  {
    
    $orm = $this->getOrm();
    
    return $orm->get( 'WbfsysProcess', $idProcess );
    
  }//end public function getProcessNodes */
  
  /**
   * @param int $idProcess
   */
  public function loadProcessById( $idProcess )
  {
    
    $orm = $this->getOrm();
    $this->process = $orm->get( 'WbfsysProcess', $idProcess );
    
  }//end public function loadProcessById */
  
  
  /**
   * @param DomainNode $domainNode
   * @param int $idStatus
   */
  public function loadStatusById( $domainNode, $idStatus )
  {
    
    $orm = $this->getOrm();
    $this->processStatus = $orm->get( 'WbfsysProcessStatus', $idStatus );
    $this->process = $orm->get( 'WbfsysProcess', $this->processStatus->id_process );
    $this->processNode = $orm->get( 'WbfsysProcessNode', $this->processStatus->id_actual_node );
    $this->entity = $orm->get( $domainNode->srcKey, $this->processStatus->vid );
    
  }//end public function loadStatusById */
  
  /**
   * @param DomainNode $domainNode
   * @param int $vid
   */
  public function loadEntityById( $domainNode, $vid )
  {
    
    if( !$vid )
      return;
    
    $orm = $this->getOrm();
    $this->entity = $orm->get( $domainNode->srcKey, $vid );
    
  }//end public function loadProcessById */

  
  /**
   * @return void
   */
  public function getProcessNodes( $idProcess )
  {
    
    $db = $this->getDb();
    
    $query = <<<SQL
SELECT
  node.label,
  node.rowid
  
FROM
  wbfsys_process process node
WHERE 
	node.id_process = {$idProcess}
ORDER BY 
	node.m_order;

SQL;

    return $db->select( $query );
    
  }//end public function getProcessNodes */
  
  /**
   * @param DomainNode $domainNode
   * @param int $idStatus
   * @param int $idNew
   * @param string $comment
   * @param boolean $closeProcess
   */
  public function changeStatus( $domainNode, $idStatus, $idNew, $comment, $closeProcess = false )
  {  
    
    ///TODO error handling für fehlende Metadaten
    
    $orm = $this->getOrm();

    $this->loadStatusById( $domainNode, $idStatus );
    
    $processClass = SFormatStrings::subToCamelCase( $this->process->access_key ).'_Process';
    $process = new $processClass();
    
    $newNode = $orm->get( 'WbfsysProcessNode', $idNew );

    $step           = $this->db->orm->newEntity( 'WbfsysProcessStep' );
    $step->id_from  = $this->processStatus->id_actual_node;
    $step->id_to    = $idNew;

    $step->id_process_instance = $this->processStatus;
    $step->comment    = $comment;

    $orm->insert( $step );

    // danach wir der aktuelle Status des Knotens upgedatet
    $this->processStatus->id_last_node    = $this->processStatus->id_actual_node;
    $this->processStatus->id_actual_node  = $newNode;
    $this->processStatus->actual_node_key = $newNode->access_key;

    if( $newNode->m_order > $this->processStatus->value_highest_node )
    {
      $this->processStatus->value_highest_node = $newNode->m_order;
    }

    if( $newNode->id_phase )
    {
      $phaseNode = $orm->get('WbfsysProcessPhase', $newNode->id_phase );
      $this->processStatus->id_phase = $phaseNode;
      $this->processStatus->phase_key = $phaseNode->access_key;
    }
    else 
    {
      // keine phase, sollte nur dann der fall sein wenn Prozesse keine
      // übergeordneten phasen haben
      $this->processStatus->id_phase  = null;
      $this->processStatus->phase_key = null;
    }
    
    // prüfen ob der Prozess geschlossen werden soll
    if( $closeProcess )
    {
      if( $newNode->is_end_node )
      {
        $this->processStatus->id_end_node  = $newNode;
      }
    }
    
    if( $process->statusAttribute )
    {
      $this->entity->{$process->statusAttribute} = $newNode;
      $orm->update( $this->entity );
    }

    $orm->update( $this->processStatus );

    
  }//end public function getStats */
  
  

  
}//end class WebfrapMaintenance_Process_Model */


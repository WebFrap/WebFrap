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
 * Das Modell für den Prozess
 *
 * Über diese Klasse können alle Prozessrelevanten Informationen aus der
 * Datenbank ausgelesen werden, bzw Änderungen gespeichert werden
 *
 * @statefull
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author Dominik Donsch <dominik.bonsch@webfrap.net>
 *
 */
class LibProcess_Model
  extends PBase
{
////////////////////////////////////////////////////////////////////////////////
// Public Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der aktuell aktive Status eines Prozesses
   * @var WbfsysProcessStatus_Entity
   */
  public $activStatus = null;

  /**
   * Die ID des aktuellen Status
   * @var int
   */
  public $activStatusId = null;

  /**
   * Node Objekt für den aktuellen Prozessstatus
   * @var WbfsysProcessNode_Entity
   */
  public $activNode = null;

  /**
   * Der Access Key des aktuell aktiven Prozesstatus
   * @var string
   */
  public $activKey = null;

  /**
   * Der Access Key des Prozesstatus in welchen der Prozess überführt werden soll
   * @var string
   */
  public $requestedEdge = null;

  /**
   * Wird aus dem request gezogen
   * @var string
   */
  public $changePState = null;

////////////////////////////////////////////////////////////////////////////////
// Protected Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Der Name des Prozesses
   * @var string
   */
  protected $name = null;

  /**
   * Das Haupt Entity Projekt das als Anker für die Prozessdaten dient
   * @var Entity
   */
  protected $entity = null;

  /**
   * Die Rowid der Prozessklasse
   * @var int
   */
  protected $processId   = null;

  /**
   * Das Process Objekt
   * @var Process
   */
  protected $process   = null;

  /**
   * Die Projektspezifischen Daten die vom Benutzer geschickt wurden
   * @var array
   */
  protected $processData   = null;

////////////////////////////////////////////////////////////////////////////////
// constructor
////////////////////////////////////////////////////////////////////////////////

  /**
   * Standad Konstruktor für das Prozess Modell
   * @param Process $process
   * @param LibDbConnection $db Die zu verwendente Datenbank Verbindung
   *
   */
  public function __construct( $process, $db )
  {

    $this->process  = $process;
    $this->db       = $db;

  }//end public function __construct */

  /**
   * Zirkuläre Referenz auflösen
   */
  public function __destruct()
  {

    $this->process = null;

  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// getter + setter methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @setter LibProcess_Model::$entity
   * @param Entity $entity
   */
  public function setEntity( $entity )
  {

    $this->entity = $entity;

  }//end public function setEntity */

////////////////////////////////////////////////////////////////////////////////
// methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * Laden des aktuellen Prozess Status
   * @param Entity $entity
   * @return void
   */
  public function loadStatus( $entity = null )
  {

    if( !$this->processId )
      $this->loadProcessId();

    if( $entity )
      $this->entity = $entity;

    // prüfen dass die entity vorhanden ist
    if ( !$this->entity || !$this->entity->getId() ) {
      throw new LibProcess_Exception( 'It\'s not possible to load a process status without a valid Entity.' );
    }

    $this->activStatus  = $this->db->orm->get
    (
      'WbfsysProcessStatus',
      "id_process={$this->processId} and vid={$this->entity}"
    );

    if (!$this->activStatus) {
      return false;
    }

    $this->activKey = $this->activStatus->actual_node_key;

    $this->process->activStatus = $this->activStatus;
    $this->process->oldKey      = $this->activKey;
    $this->process->activKey    = $this->activKey;

    $this->process->state = (int) $this->activStatus->running_state;

    if( '' !== trim($this->activStatus->state) )
      $this->process->statesData  = json_decode( $this->activStatus->state );
    else
      $this->process->statesData  = new stdClass();

    Debug::console( 'GOT RUNNING STATE '.$this->process->state );

    return true;

  }//end public function loadStatus */

  /**
   * Laden des aktuellen Prozess Status
   * @param int $statusId
   * @return void
   */
  public function loadStatusById( $statusId )
  {

    $orm = $this->getOrm();

    $this->activStatus = $orm->get
    (
      'WbfsysProcessStatus',
      $statusId
    );

    // prüfen dass die entity vorhanden ist
    if (!$this->activStatus) {
      throw new LibProcess_Exception
      (
        'Tried to load a process status by a nonexisting status id',
        'Tried to load a process status by a nonexisting status id: '.$statusId,
        Response::NOT_FOUND
      );
    }

    $this->processId = $this->activStatus->followLink( 'id_process' );

    if (!$this->processId) {
      throw new LibProcess_Exception
      (
        'Found no Process to this Status. This is a serious Error!',
        'Found no Process to the Status: "'.$statusId.'". This is a serious Error!',
        Response::INTERNAL_ERROR
      );
    }

    if (!$this->activStatus->vid) {
      throw new LibProcess_Exception
      (
        'Process Status is not connected to an entity',
        'Process Status: "'.$statusId.'". is not connected to an entity',
        Response::INTERNAL_ERROR
      );
    }

    $this->entity = $orm->get( $this->process->entityKey, $this->activStatus->vid  );
    if (!$this->entity) {
      throw new LibProcess_Exception
      (
        'Found no Entity to this Status. This is a serious Error!',
        'Found no Entity to the Status: "'.$statusId.'". This is a serious Error!',
        Response::INTERNAL_ERROR
      );
    }

    $this->process->setProcessId( $this->processId );
    $this->process->setEntity( $this->entity );

    $this->activKey = $this->activStatus->actual_node_key;

    $this->process->activStatus = $this->activStatus;
    $this->process->oldKey      = $this->activKey;
    $this->process->activKey    = $this->activKey;

    if( '' !== trim($this->activStatus->state) )
      $this->process->statesData  = json_decode( $this->activStatus->state );
    else
      $this->process->statesData  = new stdClass();

    $this->process->state = (int) $this->activStatus->running_state;

    return true;

  }//end public function loadStatusById */

  /**
   * Erstelle einer neuen Prozess Instanz
   * Init Process legt einen Status Eintrag in der Datenbank an
   *
   * @param string $startNodeName Der Name des Startnodes
   * @param TFlag $params
   *
   * @throws LibProcess_Exception
   *  Wenn die Entity keien Id hat
   *  loadProcessId wirft auch Exceptions wenn Fehler auftreten
   */
  public function initProcess( $startNodeName, $params = null )
  {

    if( !$this->processId )
      $this->loadProcessId();

    // prüfen dass die entity vorhanden ist
    if ( !$this->entity || !$this->entity->getId() ) {
      throw new LibProcess_Exception( 'It\'s not possible to initialize a Process without a valid Entity' );
    }

    $this->activStatus = $this->db->orm->newEntity( 'WbfsysProcessStatus' );

    // orm laden
    $this->activStatus->id_process  = $this->processId;
    $this->activStatus->vid         = $this->entity;

    $startNode = $this->getNodeByName( $startNodeName );

    $this->activStatus->id_start_node       = $startNode;
    $this->activStatus->id_last_node        = $startNode;
    $this->activStatus->id_actual_node      = $startNode;
    $this->activStatus->actual_node_key     = $startNode->access_key;
    $this->activStatus->value_highest_node  = $startNode->m_order;
    $this->activStatus->running_state = Process::STATE_RUNNING;
    $this->activStatus->state = '{}';

    $this->activKey = $startNodeName;

    $this->process->activStatus = $this->activStatus;
    $this->process->activKey    = $this->activKey;
    $this->process->oldKey      = $this->activKey;
    $this->process->statesData  = new stdClass();

    $this->db->orm->insert( $this->activStatus );

    if ($this->process->statusAttribute) {
      $this->entity->{$this->process->statusAttribute} = $startNode;
      $this->db->orm->save( $this->entity );
    }

    $step           = $this->db->orm->newEntity( 'WbfsysProcessStep' );
    $step->id_to    = $this->activStatus->id_actual_node;

    $step->id_process_instance = $this->activStatus;
    $step->comment  = 'Process was initialized';

    $this->db->orm->insert( $step );

  }//end public function initProcess */

  /**
   * Erstelle einer neuen Prozess Instanz
   * Init Process legt einen Status Eintrag in der Datenbank an
   *
   * @param string $startNodeName Der Name des Startnodes
   * @param TFlag $params, Kommentar zum Wechsel des Status
   *
   * @return WbfsysProcessNode_Entity den neuen Knoten zurückgeben
   */
  public function closeProcess( $closeNodeName, $params )
  {
    return $this->changeStatus( $closeNodeName, $params, true );

  }//end public function closeProcess */

  /**
   * Den Prozess löschen
   *
   */
  public function deleteProcess( )
  {

  }//end public function deleteProcess */

  /**
   * Statuswechsel im Prozess.
   * Der Status des Prozesses wird upgedated und es wird ein neuer Edge
   * Eintrag in der Datenbank hinterlegt
   *
   * @param string $newNodeName Der name des Neuen Knotens
   * @param TFlag $params
   * @param boolean $closeProcess Soll der Projekt geschlossen werden
   *
   * @return WbfsysProcessNode_Entity den neuen Knoten zurückgeben
   *
   * @throws LibProcess_Exception
   *  Wenn nötige Informationen fehlen oder nicht geladen werden können
   *  Details siehe Fehlermeldung
   */
  public function changeStatus( $newNodeName, $params, $closeProcess = false )
  {

    if( !$this->processId )
      $this->loadProcessId( );

    $orm = $this->getOrm();

    // zuerst wird der step, also der prozessschritt erstellt
    $newNode = $this->getNodeByName( $newNodeName );

    $step           = $this->db->orm->newEntity( 'WbfsysProcessStep' );
    $step->id_from  = $this->activStatus->id_actual_node;
    $step->id_to    = $newNode;

    $step->id_process_instance = $this->activStatus;
    $step->comment    = $this->getRequestComment();
    $step->rate       = $this->getRequestRating();

    $this->db->orm->insert( $step );

    // danach wir der aktuelle Status des Knotens upgedatet
    $this->activStatus->id_last_node    = $this->activStatus->id_actual_node;
    $this->activStatus->id_actual_node  = $newNode;
    $this->activStatus->actual_node_key = $newNode->access_key;

    if ($newNode->m_order > $this->activStatus->value_highest_node) {
      $this->activStatus->value_highest_node = $newNode->m_order;
    }

    if ($newNode->id_phase) {
      $phaseNode = $orm->get('WbfsysProcessPhase', $newNode->id_phase );
      $this->activStatus->id_phase = $phaseNode;
      $this->activStatus->phase_key = $phaseNode->access_key;
    } else {
      // keine phase, sollte nur dann der fall sein wenn Prozesse keine
      // übergeordneten phasen haben
      $this->activStatus->id_phase  = null;
      $this->activStatus->phase_key = null;
    }

    // prüfen ob der Prozess geschlossen werden soll
    if ($closeProcess) {
      if ($newNode->is_end_node) {
        $this->activStatus->id_end_node  = $newNode;
      }
    }

    if ($this->process->statusAttribute) {
      $this->entity->{$this->process->statusAttribute} = $newNode;
      $this->db->orm->update( $this->entity );
    }

    $this->db->orm->update( $this->activStatus );

    $this->activKey   = $newNodeName;
    $this->activNode  = $newNode;
    $this->process->activKey = $newNodeName;

    return $newNode;

  }//end public function changeStatus */

  /**
   * den running state des Prozesses anpassen
   * @param int $state
   * @throws LibProcess_Exception
   *  Wenn nötige Informationen fehlen oder nicht geladen werden können
   *  Details siehe Fehlermeldung
   */
  public function changePState( $state )
  {

    Debug::console( "in change state $state" );
    if( !$this->processId )
      $this->loadProcessId( );

    $this->activStatus->running_state = $state;

    try {
      $this->db->orm->update( $this->activStatus );
    } catch ( LibDb_Exception $e ) {
      Debug::console( $e->getMessage() );
    }

  }//end public function changePState */

  /**
   * Laden der Prozessklassen Id
   *
   * @return void
   * @throws LibProcess_Exception
   *  Wenn der Prozess fehlt
   */
  protected function loadProcessId( )
  {

    if ( !$this->process || '' == trim($this->process->name) ) {
      throw new LibProcess_Exception('Failed to load Processid, the Process / Processname is missing');
    }

    $this->processId  = $this->db->orm->getId( 'WbfsysProcess', "access_key='{$this->process->name}'" );

    if (!$this->processId) {

      // Der Prozess scheint noch nicht in der Datenbank zu sein, also rein Damit
      $this->populateDatabase();

      if (!$this->processId) {
        throw new LibProcess_Exception('Failed to load ProcessId, there is no Data for Process: '.$this->process->name );
      }

    }

    $this->process->setProcessId( $this->processId );

  }//end protected function loadProcessId */

  /**
   * Erfragen eines ProzessKnotens über den Namen
   *
   * @param string $name
   * @return WbfsysProcessNode_Entity
   */
  public function getNodeByName( $name )
  {

    $node = $this->db->orm->get
    (
      'WbfsysProcessNode',
      "access_key='{$name}' and id_process={$this->processId}"
    );

    if( !$node )
      $node = $this->createProcessNode( $name );

    return $node;

  }//end protected function getNodeByName */

  /**
   * Da netterweise alle Daten in der Projektklasse vorhanden sind
   * können wir im Fehlerfall einfach mal versuchen die Datenbank an
   * den Code anzupassen.
   *
   * Wenn das nicht klappt ist ja immenoch genug zeit zum fehler werfen
   * @throws LibDb_Exception
   *  Verbindungsfehler zur Datenbank, sonstige db fehler
   *  Wenn die Datenbank nicht den Erwartungen der hier verwedeten Struktur
   *  entspricht
   */
  protected function populateDatabase(  )
  {

    $orm = $this->getOrm();

    $processEntity = $orm->newEntity( 'WbfsysProcess' );
    $processEntity->name        = SParserString::subToName($this->process->name);
    $processEntity->access_key  = $this->process->name;
    $processEntity->description = $this->process->description;

    $orm->insert( $processEntity );

    foreach ($this->process->nodes as $key => $node) {
      $processNode = $orm->newEntity( 'WbfsysProcessNode' );
      $processNode->access_key  = $key;
      $processNode->label       = $node['label'];
      $processNode->description = isset($node['description'])?$node['description']:'';
      $processNode->m_order     = $node['order'];
      $processNode->id_process  = $processEntity;

      $orm->insert( $processNode );
    }

    $this->processId = $processEntity->getId();

  }//end protected function populateDatabase */

  /**
   * Einen Knoten erstellen, der scheins noch nicht in der Datenbank ist
   * @param string $key key für den knoten
   *
   * @throws LibDb_Exception
   *  Verbindungsfehler zur Datenbank, sonstige db fehler
   *  Wenn die Datenbank nicht den Erwartungen der hier verwedeten Struktur
   *  entspricht
   *
   * @return WbfsysProcessNode_Entity
   */
  protected function createProcessNode( $key )
  {

    $orm    = $this->getOrm();
    $node   = $this->process->nodes[$key];

    $processNode = $orm->newEntity( 'WbfsysProcessNode' );
    $processNode->access_key  = $key;
    $processNode->label       = $node['label'];
    $processNode->description = isset($node['description'])?$node['description']:'';
    $processNode->m_order     = $node['order'];
    $processNode->id_process  = $this->processId;

    $orm->insert( $processNode );

    return $processNode;

  }//end protected function populateDatabase */

////////////////////////////////////////////////////////////////////////////////
// methoden
////////////////////////////////////////////////////////////////////////////////

  /**
   * @return void
   */
  public function fetchProcessRequestData()
  {

    $request = $this->getRequest();

    $this->processData['comment'] = $request->data
    (
      $this->process->name,
      Validator::TEXT,
      'comment'
    );

    $this->requestedEdge = $request->param( 'process_edge', Validator::CNAME );

    $this->changePState = $request->param( 'process_state', Validator::INT );

  }//end public function fetchProcessRequestData */

  /**
   * @return void
   */
  public function fetchProcessServiceRequest()
  {

    $request = $this->getRequest();

    $this->processData['comment'] = $request->data
    (
      $this->process->name,
      Validator::TEXT,
      'comment'
    );

    $this->requestedEdge = $request->param( 'status', Validator::CNAME );

  }//end public function fetchProcessServiceRequest */

  /**
   * @return string
   */
  public function getRequestComment()
  {
    return isset( $this->processData['comment'] )
      ? $this->processData['comment']
      : null;

  }//end public function getRequestComment */

  /**
   * @return string
   */
  public function getRequestRating()
  {
    return isset( $this->processData['rating'] )
      ? $this->processData['rating']
      : null;

  }//end public function getRequestRating */

}//end class LibProcess_Model

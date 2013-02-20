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
 * @subpackage tech_core
 *
 */
abstract class Process extends PBase
{
/*//////////////////////////////////////////////////////////////////////////////
// Constants
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Process is Running
   * @var int
   */
  const STATE_RUNNING = 0;

  /**
   * Process is inactiv but not dead
   * @var int
   */
  const STATE_PAUSE = 1;

  /**
   * Process is terminated
   * @var int
   */
  const STATE_TERMINATED = 2;

  /**
   * Process was completed as planned
   * @var int
   */
  const STATE_COMPLETED = 3;

/*//////////////////////////////////////////////////////////////////////////////
// Public Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Der aktuell aktive Status eines Prozesses
   * @var WbfsysProcessStatus_Entity
   */
  public $activStatus = null;

  /**
   * Process state
   * @var int
   */
  public $state = 0;

  /**
   * Der key
   * @var string
   */
  public $activKey    = null;

  /**
   * Der key
   * @var string
   */
  public $oldKey    = null;

  /**
   * Der Name des Prozesses
   * Wir benötigt um die Prozessid aus der Datenbank zu laden
   *
   * @var string
   */
  public $name        = null;

  /**
   * Die Beschreibung für den Prozess
   *
   * @var string
   */
  public $description = null;

  /**
   * Alle Rollen die irgendwie mit dem Prozess in verbindung sind
   * @var array
   */
  public $roles       = array();

  /**
   * Prozess nodes
   * @var array
   */
  public $nodes       = array();

  /**
   * Phasen des Prozesses
   * @var array
   */
  public $phases       = array();

  /**
   * Mögliche Katen des Prozesses
   * @var array
   */
  public $edges       = array();

  /**
   * States Metadata
   * @var array
   */
  public $states       = null;

  /**
   * States Metadata
   * @var stdClass json data
   */
  public $statesData       = null;

  /**
   * Die Datenbank Id des Prozesses
   * @var int
   */
  public $processId   = null;

  /**
   * Der Default Node kommt dann zur Anwendung, wenn ein Datensatz zwar existiert
   * jedoch noch kein Prozess dafür existiert
   * @var string
   */
  public $defaultNode = null;

  /**
   * Der Default Node kommt dann zur Anwendung, wenn ein Datensatz zwar existiert
   * jedoch noch kein Prozess dafür existiert
   * @var string
   */
  public $closeNode = null;

  /**
   * Name des Status Attribute
   * @var string
   */
  public $statusAttribute = null;

  /**
   * Liste der User die Dafür zuständig sind den prozess weiter zu klicken
   * @var array
   */
  public $responsibles = array();

  /**
   * Name der Entity Klasse
   *
   * @var string
   */
  public $entityKey = null;

  /**
   * Controller Pfad zum ansprechen des Prozess Service interfaces
   * @var string
   */
  public $processUrl = null;

/*//////////////////////////////////////////////////////////////////////////////
// Domain & Flow Data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Entity für die Prozess Instanz.
   * Für Prozessinstanzen wird immer eine Entity und ein Prozesstype ( der Name )
   * benötigt
   *
   * @var Entity
   */
  public $entity = null;

  /**
   * Die Systen Params
   *
   * @var TFlag
   */
  public $params = null;

/*//////////////////////////////////////////////////////////////////////////////
// Protected Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die passende Security Area
   *
   * @var string
   */
  protected $area = null;

  /**
   * Die relative ID für die
   * @var int
   */
  protected $relativeId  = null;

  /**
   * Alle möglichen security areas
   * @var array
   */
  protected $areas  = array
  (
  );

  /**
   * liste mit den relativen ids
   * @var array
   */
  protected $ids  = array
  (
  );

  /**
   * Query objekt für den
   * @var LibProcess_Model
   */
  protected $model  = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Im Konstruktor werden die Edges geladen
   *
   * @param LibDbConnection $db wird benötigt um die Prozessdaten zu laden
   *
   */
  public function __construct($db = null )
  {

    if (!$db )
      $db = $this->getDb( );

    // persistenz layer zum laden und speichern von Prozess relevanten Daten
    $this->loadProcessModel($db );

    // laden des access containers soweit vorhanden
    $this->loadAccess( );

    // bauen der Responsibles
    $this->buildResponsibles( );

    // erstellen der Datenstruktur für die Phasen
    $this->buildPhases( );

    // erstellen der Datenstruktur für die States
    $this->buildStates( );

    // bauen der Nodes datenstruktur
    $this->buildNodes( );

    // bauen der Edge datenstruktur
    $this->buildEdges( );

  }//end public function __construct */

  /**
   * @return string
   */
  public function __toString()
  {
    return trim($this->processId );
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Setter mit Check auf die korrekte entity
   *
   * @param Entity $entity
   *
   */
  public function setEntity($entity )
  {

    if (!is_object($entity ) || !$entity instanceof Entity )
      throw new LibProcess_Exception( "Tried to set an invalid entity to the process ".$this->debugData() );

    $this->entity = $entity;
    $this->model->setEntity($entity );

  }//end public function setEntity */

  /**
   * @return Entity
   */
  public function getEntity( )
  {
    return $this->entity;

  }//end public function getEntity */

  /**
   * @param string $key
   * @return string
   */
  public function getAreaByKey($key )
  {
    return isset($this->areas[$key] )
      ? $this->areas[$key]
      : null;

  }//end public function getAreaByKey */

  /**
   * @param string $key
   * @return string
   */
  public function getIdByKey($key )
  {
    return isset($this->ids[$key] )
      ? $this->ids[$key]
      : null;

  }//end public function getIdByKey */

  /**
   * Setter for the user roles, are used to check if the user is allowed
   * to trigger a specific process step
   *
   * @param array $userRoles
   */
  public function setUserRoles($userRoles )
  {

    $this->userRoles = $userRoles;

  }//end public function setUserRoles */

  /**
   * @see Process::$processId
   * @param int $processId
   */
  public function setProcessId($processId )
  {
    $this->processId = $processId;
  }//end public function setProcessId */

  /**
   * @param WbfsysProcess_Entity
   */
  public function getProcessId( )
  {
    return $this->processId;

  }//end public function getProcessId */

  /**
   * @return LibProcess_Node
   */
  public function getActiveNode()
  {

    $activeKey = isset($this->nodes[$this->activKey])?$this->activKey:current(array_keys($this->nodes));

    return new LibProcess_Node($this->nodes[$activeKey], $activeKey );

  }//end public function getActiveNode */

  /**
   * @return LibProcess_Node
   */
  public function getNode($key )
  {
    return new LibProcess_Node($this->nodes[$key], $key );

  }//end public function getNode */

  /**
   * Laden der aktuell vorhandenen Edges
   *
   * @return array<LibProcess_Edge>
   */
  public function getActiveEdges()
  {

    if (!$this->activKey )
      throw new LibProcess_Exception( "Process Status not yet loaded ".$this->debugData() );

    /* @var $acl LibAclAdapter_Db */
    $acl   = $this->getAcl();
    $user  = $this->getUser();

    $profileName = $user->getProfileName();

    $edges = array();

    if (!isset($this->edges[$this->activKey] ) )
      return array();

    foreach ($this->edges[$this->activKey] as $key => $edge) {

      $edge = new LibProcess_Edge($key, $edge );

      $accessFlag = false;

      if (!$edge->hasProfile($profileName ) )
        continue;

      if (!$edge->access) {
        $accessFlag = true;
      }

      foreach ($edge->access as $access) {

        // wenn die access flag auf true ist brauchen wir nicht weiter zu machen
        if ($accessFlag )
          break;

        switch ($access['type']) {
          case Acl::OWNER:
          {
            if ($this->entity->isOwner($user ) ) {
              $accessFlag = true;
            }

            break;
          }
          case Acl::PROFILE:
          {

            if (!isset($access['profiles'] ) )
              throw new LibProcess_Exception( "Missing Profiles in Profile Check ".$this->debugData().' '.$edge->debugData() );

            if ( in_array($profileName, $access['profiles'] ) ) {
              $accessFlag = true;
            }

            break;
          }
          case Acl::ROLE:
          {

            if (!isset($access['roles'] ) )
              throw new LibProcess_Exception( "Missing Roles in Role Check ".$this->debugData().' '.$edge->debugData() );

            $roles = $access['roles'];

            $area  = ( isset($access['area'] ) && isset($this->areas[$access['area']] ) )
              ? $this->areas[$access['area']]
              : null;

            $id  = ( isset($access['id'] ) && isset($this->ids[$access['id']] ) )
              ? $this->ids[$access['id']]
              : null;

            if ($acl->hasRole($roles, $area, $id ) ) {
              $accessFlag = true;
            }

            break;
          }
          case Acl::ROLE_SOMEWHERE:
          {

            if (!isset($access['roles'] ) )
              throw new LibProcess_Exception( "Missing Roles in Role Somewhere Check ".$this->debugData().' '.$edge->debugData() );

            $roles = $access['roles'];

            $area  = isset($access['area'] ) && isset($this->areas[$access['area']])
              ? $this->areas[$access['area']]
              : null;

            if ($acl->hasRoleSomewhere($roles, $area  ) ) {
              $accessFlag = true;
            }

            break;
          }
          default:
          {
            throw new LibProcess_Exception( "Got unsupported Access Check in ".$this->debugData().' '.$edge->debugData() );
          }
        }
      }

      // so wenn die Standard Checks nicht ausreichen kann noch eine Access
      // check Object injected werde
      if (!$accessFlag && $this->access) {

        ///@todo checken wann wir ein objekt bekommen, welches dieses methode implementieren sollte
        /// es aber nicht tut
        if ( method_exists($this->access, 'checkEdgeAccess') ) {
          if (!$this->access->checkEdgeAccess($this, $edge, $this->entity ) )
            continue;
          else
            $accessFlag = true;
        } else {
          Debug::console( 'Tried to checkEdgeAccess but the method not exists on '.get_class($this->access) );
        }

      }

      if ($accessFlag) {
        $edges[] = $edge;
      }

    }

    return $edges;

  }//end public function getActiveEdges */

  /**
   * Laden der zu anzeigenden Slides im Process Dropdown
   *
   * @return array<LibProcessSlice>
   */
  public function getActiveSlices()
  {

    if (!isset($this->nodes[$this->activKey]['slices'] ) ) {
      return array();
    }

    $slices = array();
    $rawSlices = $this->nodes[$this->activKey]['slices'];

    foreach ($rawSlices as $rawSlice) {

      $className = 'LibProcessSlice_'.ucfirst($rawSlice['type']);

      if ( Webfrap::classLoadable($className) ) {
        $slices[] = new $className($this, $rawSlice );
      } else {
        Debug::console( "Missing Slice ".ucfirst($rawSlice['type']) );
        $this->getResponse()->addWarning( "Sorry an error happened, this page could not be displayed as originally planed" );
      }

    }

    return $slices;

  }//end public function getActiveSlices */

  /**
   * Laden der zu anzeigenden Slides im Process Dropdown
   *
   * @return array
   */
  public function getActiveStates()
  {

    if (!isset($this->nodes[$this->activKey]['states'] ) ) {
      return array();
    }

    $states = array();
    $stateKeys = $this->nodes[$this->activKey]['states'];

    foreach ($stateKeys as $key) {

      if ( isset($this->states[$key['name']] ) )
        $states[$key['name']] = $this->states[$key['name']];
      else
        Debug::console( "Missing phase {$key['name']}" );

    }

    return $states;

  }//end public function getActiveStates */

  /**
   * @return array<LibMessageReceiver>
   */
  public function getActiveResponsibles( )
  {

    if (!isset($this->nodes[$this->activKey]['responsible'] ) ) {
      Debug::console( "Active Key {$this->activKey} has no responsible" );

      return array( );
    }

    $message       = $this->getMessage( );
    $responsibles  = array();

    $dataResp = $this->nodes[$this->activKey]['responsible'];

    foreach ($dataResp as $resp) {

      if (!isset($resp['type']) ) {
        Debug::console( 'Missing type for responsible',  $resp );
        continue;
      }

      switch ($resp['type']) {
        case Acl::ROLE:
        {

          if (!isset($resp['roles'] ) )
            throw new LibProcess_Exception( "Missing Roles in Role Check ".$this->debugData() );

          $roles = $resp['roles'];

          $area  = isset($resp['area'] ) && isset($this->areas[$resp['area']] )
            ? $this->areas[$resp['area']]
            : null;

          $id  = isset($resp['id'] ) && isset($this->ids[$resp['id']] )
            ? $this->ids[$resp['id']]
            : null;

          $responsibles[] = new LibMessage_Receiver_Group($roles, $area, $id );

          break;
        }
        case Acl::PROFILE:
        {
          // nothing
          break;
        }
        case Acl::OWNER:
        {

          $responsibles[] = new LibMessage_Receiver_User($this->entity->owner( true ) );
          break;
        }

        /*
        case Acl::ROLE_SOMEWHERE:
        {

          if (!isset($access['roles']) )
            throw new LibProcess_Exception( "Missing Roles in Role Somewhere Check ".$this->debugData().' '.$edge->debugData() );

          $roles = $access['roles'];

          $area  = isset($access['area']) && isset($this->areas[$access['area']])
            ? $this->areas[$access['area']]
            : null;

          if ($acl->hasRoleSomewhere($roles, $area  ) ) {
            $accessFlag = true;
          }

          break;
        }
        */
        default:
        {
          throw new LibProcess_Exception
          (
            "Got unsupported Access Check in ".$this->debugData()
          );
        }
      }
    }

    Debug::console( "Load responsibles for active Key {$this->activKey} ".count($responsibles) );

    $message = $this->getMessage();

    return $message->getReceivers($responsibles, Message::CHANNEL_MAIL );

  }//end public function getActiveResponsibles */

  /**
   * @param string $key
   * @return array
   */
  public function getResponsible($key )
  {

    if ( isset($this->responsibles[$key] ) )
      return $this->responsibles[$key];

    return null;

  }//end public function getResponsible */

/*//////////////////////////////////////////////////////////////////////////////
// Check Logik die helfen soll stabilen Code zu schreiben
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * prüfen ob eine bestimmte Kante existiert
   *
   * @param string $actualNode
   * @param string $newNode
   * @return boolean true wenn existiert
   */
  public function edgeExists($actualNode, $newNode )
  {
    return isset($this->edges[$actualNode][$newNode] );

  }//end public function edgeExists */

  /**
   * Prüfen ob der aktive Benutzer zugriff auf den Status Übergang hat
   *
   * @param array $edgeRoles
   */
  public function checkUserAccess($edge  )
  {

    $access     = false;
    $edgeRoles  = array();

    if ( isset($edge['roles'] ) )
      $edgeRoles = $edge['roles'];

    foreach ($this->userRoles as $userRole) {
      if ( in_array($userRole, $edgeRoles ) ) {
        $access = true;
        break;
      }
    }

    return $access;

  }//end public function checkUserAccess */

/*//////////////////////////////////////////////////////////////////////////////
// Build Logik für die Datenstrukturen des Prozesses
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Methode zum erstellen der Edges Datenstruktur
   * Diese Methode ist nötig da sonst nicht mit klassen und selbstreferenzen
   * in der Datenstruktur gearbeitet werden kann
   */
  public function buildEdges()
  {

    /*
    $this->edges = array
    (
      'node1' => array
      (
        'node2' => array
        (
          'label'     => 'bar fu',
          'order'     => 1,
          'type'      => 'forward',
          'icon'      => '',
          'color'     => '',
          'roles'     => array( 'project_manager' ),
          'actions'   => array
          (
            'default' => 'action_node1_node2_default'
          )
        )
      )
    );
    */

  }//end public function buildEdges */

  /**
   * Methode zum erstellen der Nodes Datenstruktur
   * Diese Methode ist nötig da sonst nicht mit klassen und selbstreferenzen
   * in der Datenstruktur gearbeitet werden kann
   */
  public function buildNodes()
  {

    /*
    $this->nodes = array
    (
      'init' => array
      (
        'label'   => 'New',
        'order'   => 1,
        'icon'    => 'process/new.png',
        'color'   => 'default',
        'phase'   => 'default',
        'responsible'    => array
        (
          'test',
          'test_2',
        ),
        'description'  => 'New'
      ),
    );
    */

  }//end public function buildNodes */

  /**
   * Methode zum erstellen der Nodes Datenstruktur
   * Diese Methode ist nötig da sonst nicht mit klassen und selbstreferenzen
   * in der Datenstruktur gearbeitet werden kann
   */
  public function buildPhases()
  {

    /*
    $this->phases = array
    (
      'init' => array
      (
        'label'   => 'New',
        'order'   => 1,
        'icon'    => 'process/new.png',
        'responsible'    => array
        (
          'test',
          'test_2',
        ),
        'description'  => 'New'
      ),
    );
    */

  }//end public function buildPhases */

  /**
   * Methode zum erstellen der Nodes Datenstruktur
   * Diese Methode ist nötig da sonst nicht mit klassen und selbstreferenzen
   * in der Datenstruktur gearbeitet werden kann
   */
  public function buildStates()
  {

    /*
    $this->states = array
    (
      'some_state' => array
      (
        'label'   => 'New',
        'type'    => 'checkbox',
        'responsible'    => array
        (
          'test',
          'test_2',
        ),
        'description'  => 'New'
      ),
    );
    */

  }//end public function buildPhases */

  /**
   * bauen der Responsibles
   */
  public function buildResponsibles()
  {

  }//end public function buildResponsibles */

  /**
   * Laden des Datenmodells für den Prozess
   * @param LibDbConnection $db
   */
  public function loadProcessModel($db  )
  {

    $conType    = $db->getConnectionDbms();

    $className  = 'LibProcess_Model_'.$conType;

    if ( Webfrap::classLoadable($className ) ) {
      $this->model = $className($db );
    } else {
      // wenn kein dbms spezifisches process modell vorhanden ist
      // fallback auf das default process model
      $this->model = new LibProcess_Model($this, $db );
    }

  }//end  public function loadProcessModel */

  /**
   * Laden des access containers
   * @overwrite me if you need
   */
  protected function loadAccess()
  {

  }//end protected function loadAccess */

  /**
   * Extrahieren der Prozessbezogenen Daten aus dem User Request
   */
  public function fetchRequest(   )
  {

    /*
     * Setzt auf dem Model die Werte:
     * - requestedEdge
     * - processData['comment']
     */
    $this->model->fetchProcessRequestData();

  }//end  public function fetchRequest */

  /**
   * laden
   */
  public function fetchServiceRequest(   )
  {

    /*
     * Setzt auf dem Model die Werte:
     * - requestedEdge
     * - processData['comment']
     */
    $this->model->fetchProcessServiceRequest();

  }//end  public function fetchServiceRequest */

  /**
   * Den user Comment bekommen
   * @return string
   */
  public function getUserComment( )
  {

    $comment = $this->model->getRequestComment();
    $commentBlock = '';

    if (!$comment) {
      return '';
    } else {
      ///BAD CODE!
      $commentBlock = '<div class="comment" >';
      $commentBlock .= '<p>Please take care of the following comment(s) entered by the sender.<p>';
      $commentBlock .= '<pre>'.$comment.'</pre>';
      $commentBlock .= '</div>';
    }

    return $commentBlock;

  }//end  public function getUserComment */

/*//////////////////////////////////////////////////////////////////////////////
// process logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prozess triggern
   *
   * @param string $position
   * @param TFlag $params
   * @param boolean $changeStatus
   *
   * @return string
   */
  public function trigger($position, $params, $changeStatus = false )
  {

    if ($this->model->requestedEdge) {
      $this->newNode    = $this->model->requestedEdge;
    } else {
      $this->newNode    = $this->oldKey;
    }

    if (!isset($this->nodes[$this->newNode] )  ) {
      throw new LibProcess_Exception( 'Invalid actual node '.$this->newNode.' in '.$this->debugData() );
    }

    if (!isset($this->edges[$this->oldKey][$this->newNode] )  ) {
      // es existiert kein pfad, also muss nichts gemacht werden
      // also kann nichts fehl schlagen => alles bestens

      // schlägt auch dann fehl wenn es eine methode geben würde die
      // zum aufruf passt
      Debug::console( "no PATH this->edges[$this->oldKey][$this->newNode] " );

      return null;
    }

    /*
    if (!$this->checkUserAccess($this->edges[$this->activKey][$this->newNode]['roles'] ) ) {
      throw new LibProcess_Exception( 'User has no permission to move on' );
    }
    */

    if ( isset($this->edges[$this->oldKey][$this->newNode]['actions'][$position] ) ) {

      $action = 'action_'.SParserString::subToCamelCase($this->edges[$this->oldKey][$this->newNode]['actions'][$position]);

      Debug::console( "try to call  $action" );

      // ok das sollte nicht passieren
      if (!method_exists($this, $action ) )
        throw new LibProcess_Exception( 'Called nonexisting action! '.$action.' '.$this->debugData() );

      Debug::console( "call  $action" );

      if ($error = $this->{$action}($params ) )

        return $error;

    } else {
      $tmp1 = $this->edges[$this->oldKey];
      $tmp2 = $tmp1[$this->newNode];
      $tmp3 = $tmp2['actions'];

      if ( isset($tmp3[$position] ) )
        $tmp4 = $tmp3[$position];
      else
        $tmp4 = 'for '.$position;

      Debug::console( "no action ".$tmp4 );
    }

    if ($changeStatus )
      $this->model->changeStatus($this->newNode, $params );

    return null;

  }//end public function trigger */

  /**
   * @param string $type
   * @param string $position
   * @param Tflag $params
   */
  public function call($type, $position, $params )
  {

    $action = $type.'_'.$position;

    // müssen nicht existieren
    if (!method_exists($this, $action ) )
      return null;

    return $this->{$action}($params );

  }//end public function call */

  /**
   * Validate kann nur aufgerufen werden wenn der Prozess vorher geladen wurde
   * und wenn die Prozesselemente aus den Request bereits ausgewertet wurden, bzw
   * Pfadinformationen gesetzt wurden.
   *
   * @param Tflag $params
   * @param boolean $validateNode Soll nur der Node oder eine Edge validiert werden
   */
  public function validate($params = null, $validateNode = false )
  {

    if (!$this->model->activKey )
      throw new LibProcess_Exception( 'Process needs to be initialized to call validate!' );

    if (!$this->model->requestedEdge && $validateNode) {

      if ( isset($this->nodes[$this->model->activKey]['constraints'] )  ) {
        $constraints = $this->nodes[$this->model->activKey]['constraints'];
      } else {
        return null;
      }

    } else {

      if ( isset($this->edges[$this->oldKey][$this->model->requestedEdge]['constraints'] ) ) {
        $constraints = $this->edges[$this->oldKey][$this->model->requestedEdge]['constraints'];
      } else {
        return null;
      }

    }

    $response = $this->getResponse();

    /* @var $respContext LibResponseContext */
    $respContext = $response->createContext();

    foreach ($constraints as  $constraint) {

      $action = 'constraint_'.SParserString::subToCamelCase($constraint );

      /// TODO Error handling
      if (!method_exists($this, $action ) ) {
        Debug::console( 'Missing Constraint '.$constraint );
        continue;
      }

      $respContext = $this->$action($respContext );

    }

    if (!$respContext->hasError )
      return null;

    return $respContext;

  }//end public function validate */

  /**
   * Validate kann nur aufgerufen werden wenn der Prozess vorher geladen wurde
   * und wenn die Prozesselemente aus den Request bereits ausgewertet wurden, bzw
   * Pfadinformationen gesetzt wurden.
   *
   * @param Tflag $params
   * @param boolean $validateNode Soll nur der Node oder eine Edge validiert werden
   */
  public function injectValidationInForm($form, $mainKey )
  {

    if (!$this->model->activKey )
      throw new LibProcess_Exception( 'Process needs to be initialized to call validate!' );

    $constraints = array();

    // injecten der constraints auf dem aktuellen status
    if ( isset($this->nodes[$this->model->activKey]['constraints'] )  ) {
      $constraints = $this->nodes[$this->model->activKey]['constraints'];

      foreach ($constraints as  $constraint) {

        $action = 'injectFormConstraint_'.SParserString::subToCamelCase($constraint );

        /// TODO Error handling
        if (!method_exists($this, $action ) ) {
          Debug::console( 'Missing Constraint Injector '.$constraint );
          continue;
        }

        $this->$action($form, $mainKey );

      }

    }

    if ( isset($this->edges[$this->activKey] ) ) {

      foreach ($this->edges[$this->activKey] as $edgeKey => $edge) {

        // wenn wir constraints haben
        if ( isset($edge['constraints'] )  ) {
          $constraints = $edge['constraints'];

          Debug::console( 'GOT CONSTRAINTS '. implode( ',', $edge['constraints'] ) );

          foreach ($constraints as  $constraint) {

            $action = 'injectFormConstraint_'.SParserString::subToCamelCase($constraint );

            /// TODO Error handling
            if (!method_exists($this, $action ) ) {
              Debug::console( 'Missing Constraint Injector '.$constraint );
              continue;
            }

            $this->$action($form,  $mainKey, $edge['label'], $edge['description'] );

          }

        }

      }

    }

  }//end public function injectValidationInForm */

  /**
   * @param string $nodeKey
   * @param TFlag $params
   */
  public function move($nodeKey, $params = null )
  {
    return $this->changeStatus($nodeKey, 'change', $params, false );

  }//end public function move */

  /**
   * Prozess triggern
   *
   * @param string $nodeKey
   * @param TFlag $params
   * @param boolean $noPathRequired es wird kein Pfad benötigt
   *
   * @return string
   */
  public function changeStatus($nodeKey, $position = 'change', $params = null, $pathRequired = true )
  {

    if (is_null($params) ) {
      $params = new TFlag();
    }

    Debug::console( "Change from {$this->oldKey} to {$nodeKey} " );

    if (!isset($this->nodes[$nodeKey] )  ) {
      throw new LibProcess_Exception( 'Invalid actual node '.$nodeKey.' in Process '.$this->debugData() );
    }

    $this->newNode = $nodeKey;

    if (!isset($this->edges[$this->oldKey][$nodeKey] )  ) {
      // es existiert kein pfad, also muss nichts gemacht werden
      // also kann nichts fehl schlagen => alles bestens

      // schlägt auch dann fehl wenn es eine methode geben würde die
      // zum aufruf passt
      Debug::console( "No PATH this->edges[$this->oldKey][$nodeKey] " );
      if ($pathRequired) {
        throw new LibProcess_Exception
        (
          'Tried to change the status from '.$this->oldKey.' '.$nodeKey.' without path in Process '.$this->debugData()
        );
      }

    }

    ///TODO User Permission checken?
    /*
    if (!$this->checkUserAccess($this->edges[$this->activKey][$this->newNode]['roles'] ) ) {
      throw new LibProcess_Exception( 'User has no permission to move on' );
    }
    */

    if ( isset($this->edges[$this->oldKey][$this->newNode]['actions'][$position] ) ) {

      $action = 'action_'.SParserString::subToCamelCase($this->edges[$this->oldKey][$this->newNode]['actions'][$position]);

      //Debug::console( "try to call  $action" );

      // ok das sollte nicht passieren
      if (!method_exists($this, $action ) )
        throw new LibProcess_Exception( 'Called nonexisting action! '.$action.' in Process '. $this->debugData() );

      //Debug::console( "call  $action" );

      // wenn ein fehler objekt zurückgegeben wird, wird der schritt abgebrochen
      if ($error = $this->{$action}($params ) )

        return $error;

    } else {
      Debug::console( "No action $this->edges[$this->oldKey][$this->newNode]['actions'][$position] " );
    }

    $this->model->changeStatus($nodeKey, $params );

    return null;

  }//end public function changeStatus */

 /**
   * Den Prozess state changen
   * @param int $state
   */
  public function changePState($state = null )
  {

    if (is_null($state ) )
      $state = $this->model->changePState;

    if (is_null($state ) )
      return;

    if ($this->state === $state )
      return;

    $this->model->changePState($state );
    $this->state = $state;

    return null;

  }//end public function changePState */

 /**
   * Den Prozess state changen
   * @param stdClass $state
   */
  public function saveStates($states )
  {

    Debug::console( '$states$states', $states );

    $states = (array) $states;

    foreach ($states as $key => $state) {
      $this->statesData->{$key} = $state;
    }

    $orm = $this->getOrm();
    $this->activStatus->state = json_encode($this->statesData );

    $orm->save($this->activStatus );

    return null;

  }//end public function saveStates */

/*//////////////////////////////////////////////////////////////////////////////
// Init & Close
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Init wird dann aufgerufen wenn die Entität erstellt wird, für die der Prozess
   * definiert wurde
   *
   * @param Entity $entity
   * @param TFlag $params
   */
  public function init($entity = null, $params = null )
  {

    if ($entity )
      $this->model->setEntity($entity );

    $keys = array_keys($this->nodes );

    $this->model->initProcess($keys[0], $params );

  }//end public function init */

  /**
   * Den aktuellen Prozessstatus laden
   *
   * @param Entity $entity
   * @param TFag $params
   */
  public function load($entity, $params )
  {

    $this->params = $params;

    $this->setEntity($entity );

    if (!$this->model->loadStatus($entity ) )
      $this->model->initProcess($this->defaultNode, $params );

  }//end public function load */

  /**
   * Den aktuellen Prozessstatus mit der StatusId laden
   *
   * @param int $statusId
   * @param TFag $params
   */
  public function loadByStatus($statusId, $params )
  {

    $this->params = $params;

    $this->model->loadStatusById($statusId, $params  );

  }//end public function loadByStatus */

  /**
   * Den Prozess schliesen
   *
   * @param Entity $entity
   * @param TFlag $params
   */
  public function close($entity = null, $params = null )
  {

    if ($entity )
      $this->model->setEntity($entity );

    if (!$this->model->loadStatus(  ) )
      $this->model->initProcess($this->defaultNode, $params );

    $this->model->closeProcess($this->closeNode, $params  );

  }//end public function close */

  /**
   * Den Prozess schliesen
   *
   * @param Entity $entity
   * @param TFlag $params
   */
  public function delete($entity = null, $params = null )
  {

    if ($entity )
      $this->model->setEntity($entity );

    if (!$this->model->loadStatus(  ) )
      return;

    $this->model->deleteProcess($params  );

  }//end public function delete */

/*//////////////////////////////////////////////////////////////////////////////
// Build Address
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param array $resp
   * @return IReceiver
   */
  protected function buildReceiver($resp )
  {

    switch ($resp['type']) {
      case Acl::ROLE:
      {
        return $this->buildGroupReceiver($resp );
        break;
      }
      default:
      {
        throw new LibProcess_Exception( 'Tried to build a nonexisting receiver type: '.$resp['type'].' in Process '. $this->debugData() );
        break;
      }
    }

  }//end protected function buildReceiver */

  /**
   *
   * @param array $resp
   * @return IReceiver
   */
  protected function buildGroupReceiver($resp )
  {

    if (!isset($resp['roles'] ) )
      throw new LibProcess_Exception( "Missing Roles in Role Check ".$this->debugData() );

    $roles = $resp['roles'];

    $area  = isset($resp['area'] ) && isset($this->areas[$resp['area']] )
      ? $this->areas[$resp['area']]
      : null;

    $id  = isset($resp['id'] ) && isset($this->ids[$resp['id']] )
      ? $this->ids[$resp['id']]
      : null;

    $else = array();

    if ($resp['else']) {
      foreach ($resp['else'] as $receiver) {
        $else[] = $this->buildReceiver($receiver );
      }
    }

    return new LibMessage_Receiver_Group($roles, $area, $id, $else );

  }//end protected function buildGroupReceiver */

  public function owner()
  {
    $this->entity->owner( true );
  }

/*//////////////////////////////////////////////////////////////////////////////
// Debug Data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Methode zum bereitstellen notwendiger Debugdaten
   * Sinn ist es möglichst effizient den aufgetretenen Fehler lokalisieren zu
   * können.
   * Daher sollte beim implementieren dieser Methode auch wirklich nachgedacht
   * werden.
   * Eine schlechte debugData Methode ist tendenziell eher schädlich.
   *
   * @return string
   */
  public function debugData()
  {
    return 'Process '.get_class($this).' ID: '.$this->processId.' Activ Key: '.$this->activKey;

  }//end public function debugData */

}//end abstract class Process


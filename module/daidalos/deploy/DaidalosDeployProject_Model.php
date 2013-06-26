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
 * @subpackage ModSync
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosDeployProject_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Entity des Systemnodes in welchen deployt werden soll
   * @var DaidalosSystemNode_Entity
   */
  public $entity = null;

  /**
   * Das Verzeichniss in welches deployt werden soll
   * @var string
   */
  public $deployRoot = null;

  /**
   * Der Temporäre folder für das deployment
   * @var string
   */
  public $deployTmp = null;

  /**
   * @var DaidalosRcsNode_Envelop
   */
  public $gatewayProject = array();

  /**
   * @var DaidalosRcsNode_Envelop
   */
  public $iconProject = null;

  /**
   * @var DaidalosRcsNode_Envelop
   */
  public $themeProject = null;

  /**
   * @var DaidalosRcsNode_Envelop
   */
  public $wgtProject = null;

  /**
   * @var DaidalosRcsNode_Envelop
   */
  public $webfrapProject = null;

  /**
   * @var array<string:DaidalosRcsModule_Envelop>
   */
  public $modules = array();

  /**
   * Konfiguration für das Deployment
   * @var DaidalosDeployProject_Conf
   */
  public $deployConf = null;

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param DaidalosSystemNode_Entity $entity
   * @param DaidalosDeployProject_Conf $deployConf
   * @param TFlag $params
   * @param BaseChild $env
   */
  public function deploy($entity, $deployConf, $params, $env)
  {

    try {

      $state = $this->load($entity, $deployConf, $params, $env);
      $this->createBackups();
      SFilesystem::delete($this->deployTmp);

    } catch (Exception $e) {

      SFilesystem::delete($this->deployTmp);
    }

  }//end public function deploy */

  /**
   * @param DaidalosSystemNode_Entity $entity
   * @param DaidalosDeployProject_Conf $deployConf
   * @param TFlag $params
   * @param BaseChild $env
   */
  protected function load($entity, $deployConf, $params, $env)
  {

    $this->entity = $entity;
    $this->params = $params;
    $this->env    = $env;

    $this->deployConf = $deployConf;

    $this->tmpKey = Webfrap::tmpFolder();

    $this->deployTmp = PATH_GW.'tmp/deploy/'.$this->tmpKey.'/';
    SFilesystem::mkdir($this->deployTmp);

    $state = new State();

     $this->loadDefaultRepos($state);
     $this->loadModules($state);
     $this->checkRequired($state);

    return $state;

  }//end protected function load */

  /**
   * @param State $state
   * Laden der standard repositories
   */
  protected function loadDefaultRepos($state)
  {

    if (!$this->entity->id_gateway)
      $state->addError("Deploy requires a valid Gateway Project");

    if (!$this->entity->id_wgt)
      $state->addError("Deploy requires a valid WGT Project");

    if (!$this->entity->id_framework)
      $state->addError("Deploy requires a valid Framework Project");

    if (!$this->entity->id_theme)
      $state->addError("Deploy requires a valid Theme Project");

    if (!$this->entity->id_icon_theme)
      $state->addError("Deploy requires a valid Icon Theme Project");

    $map = array
    (
      $this->entity->id_gateway   => 'gatewayProject',
      $this->entity->id_icon_theme => 'iconProject',
      $this->entity->id_theme     => 'themeProject',
      $this->entity->id_wgt       => 'wgtProject',
      $this->entity->id_framework => 'webfrapProject'
    );

    if ($state->hasErrors())
      throw new DaidalosDeploy_Exception($state);

    $db = $this->getDb();

    $sql = <<<SQL
  SELECT
    node.rowid as "node_rowid",
    node.access_key as "node_access_key",
    node.name as "node_name",
    node.serv_url as "node_serv_url",
    node.serv_port as "node_serv_port",
    node.id_serv_protocol as "node_id_serv_protocol",
    node.serv_username as "node_serv_username",
    node.serv_passwd as "node_serv_passwd",
    node.serv_source as "node_serv_source",
    node.id_protocol as "node_id_protocol",

    master.name  as "master_name",
    master.access_key  as "master_access_key",
    master.id_rcs  as "master_id_rcs",
    master.description  as "master_description",
    master.serv_url  as "master_serv_url",
    master.serv_port  as "master_serv_port",
    master.id_serv_protocol  as "master_id_serv_protocol",
    master.serv_username  as "master_serv_username",
    master.serv_passwd  as "master_serv_passwd"

  FROM
    daidalos_rcs_node node

  JOIN
    daidalos_rcs_master master
    ON node.id_master = master.rowid

  JOIN
    daidalos_rcs_repository repo
    ON node.id_repository = repo.rowid

  where
    node.rowid in
    (
      {$this->entity->id_gateway},
      {$this->entity->id_wgt},
      {$this->entity->id_framework},
      {$this->entity->id_theme},
      {$this->entity->id_icon_theme}
    )

SQL;

    $data = $db->select($sql);

    foreach ($data as $row) {
      $this->{$map[$row['node_rowid']]} = new DaidalosRcsNode_Envelop($row);
    }

  }//end protected function loadDefaultRepos */


  /**
   * @param State $state
   * Laden der standard repositories
   */
  protected function loadModules($state)
  {


    $db = $this->getDb();

    $sqlModules = <<<SQL
  SELECT
    mod.rowid as mod_id,
    mod.name as mod_name,
    mod.access_key as mod_access_key,
    mod.deploy_tag as mod_deploy_tag,
    mod.flag_active as mod_flag_active,
    mod.priority as mod_priority,
    mod.description as mod_description

  FROM
    daidalos_system_node_module as mod

  where
    mod.id_system_node = {$this->entity}

SQL;

    $data = $db->select($sqlModules);

    $ids = array();

    foreach ($data as $row) {
      $this->modules[$row['mod_id']] = new DaidalosRcsModule_Envelop($row);
      $ids[] = $row['mod_id'];
    }

    $modIds = implode(", ", $ids);

    $sqlModules = <<<SQL
  SELECT
    repo.id_module as "repo_module",

    node.rowid as "node_rowid",
    node.access_key as "node_access_key",
    node.name as "node_name",
    node.serv_url as "node_serv_url",
    node.serv_port as "node_serv_port",
    node.id_serv_protocol as "node_id_serv_protocol",
    node.serv_username as "node_serv_username",
    node.serv_passwd as "node_serv_passwd",
    node.serv_source as "node_serv_source",
    node.id_protocol as "node_id_protocol",

    master.name  as "master_name",
    master.access_key  as "master_access_key",
    master.id_rcs  as "master_id_rcs",
    master.description  as "master_description",
    master.serv_url  as "master_serv_url",
    master.serv_port  as "master_serv_port",
    master.id_serv_protocol  as "master_id_serv_protocol",
    master.serv_username  as "master_serv_username",
    master.serv_passwd  as "master_serv_passwd"

  FROM
    daidalos_system_node_module as mod

  JOIN daidalos_system_node_repo repo
    ON repo.id_module = mod.rowid

  JOIN daidalos_rcs_node node
    ON repo.id_rcs_node = node.rowid

  JOIN daidalos_rcs_master master
    ON node.id_master = master.rowid

  JOIN daidalos_rcs_repository repo
    ON node.id_repository = repo.rowid

  where
    repo.id_module IN({$modIds});

SQL;

    $data = $db->select($sqlModules);

    foreach ($data as $row) {
      $this->modules[$row['repo_module']]->repos[] = new DaidalosRcsNode_Envelop($row);
    }

  }//end protected function loadDefaultRepos */

  /**
   *
   */
  public function fetchRepositories()
  {

    $libRepo = $this->getRcsLib($this->gatewayProject);

  }//end public function fetchRepositories */

/*//////////////////////////////////////////////////////////////////////////////
// Backup & Aufräum Funktionen
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Backups erstellen
   */
  public function createBackups()
  {

  }//end public function createBackups */

  /**
   *
   */
  public function backupUploads()
  {

  }//end public function backupUploads */

  /**
   *
   */
  public function backupDbms()
  {

  }//end public function backupDbms */

  /**
   *
   */
  public function cleanCache()
  {

    // den kompletten cache einfach löschen
    if ($this->deployConf->cache->full) {
      SFilesystem::delete($this->deployRoot.'/'.$this->gatewayProject->deployKey.'/cache');
      SFilesystem::mkdir($this->deployRoot.'/'.$this->gatewayProject->deployKey.'/cache');
    } else {

    }

  }//end public function cleanCache */

  /**
   *
   */
  public function cleanDeploymentTarget()
  {

  }//end public function cleanDeploymentTarget */

/*//////////////////////////////////////////////////////////////////////////////
// Deploy Funktionen
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function deployGateway()
  {

  }//end public function deployGateway */

/*//////////////////////////////////////////////////////////////////////////////
// Validitätsprüfungen und Fehlerbehandlung
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prüfen ob alle benötigten Daten vorhanden sind
   * @param State $state
   */
  public function checkRequired($state)
  {

    if ($this->entity->isEmpty('root_path'))
      $state->addError("Root Path for deployment is missing");

  }//end public function checkRequired */

/*//////////////////////////////////////////////////////////////////////////////
// Helper Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Prüfen ob alle benötigten Daten vorhanden sind
   * @param DaidalosRcsNode_Envelop $envelop
   */
  public function getRcsLib($envelop)
  {

  }//end public function checkRequired */

}//end class DaidalosDeployProject_Model


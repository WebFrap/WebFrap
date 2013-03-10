<h1>Die Konfigurationsdatei</h1>

<a href="./files/scripts/conf.example.txt" >Download File</a><br />

<label>Beispiel für die Konfigurationsdatei</label>
<?php start_highlight(); ?>
////////////////////////////////////////////////////////////////////////////////
// Allgemeine Angaben
////////////////////////////////////////////////////////////////////////////////

/**
 * Der Pfad im dem sich die Repository Container befinden
 * @var string
 */
$repoRoot     = '/srv/mercurial/';

/**
 * Temporärer Ordner 
 * @var string
 */
$tmpFolder    = '/srv/tmp/';

/**
 * Temporärer Ordner 
 * @var string
 */
$backupFolder    = '/srv/backup/';


/**
 * Der Pfad im dem sich die Repository Container befinden
 * @var string
 */
$universe     = 'demo';

////////////////////////////////////////////////////////////////////////////////
// Setup
////////////////////////////////////////////////////////////////////////////////

/**
 * Für das Setup der Datenbank nötige Angaben
 * @var array
 */
$setupDb = array
(
  'root_user'  => '',
  'root_pwd'   => '', 
  'scripts'    => array // liste mit scripten und dumps die immer geladen werden sollen
  (
    '' 
  ),
  'db'  => array
  (
    'WebFrap_Gw_SBiz' => array
    (
      'name'       => '',
      'owner'       => '',
      'owner_pwd'   => '',
      'schema'     => '',
      'encoding'   => '',
    )
  )
);

////////////////////////////////////////////////////////////////////////////////
// Deployment
////////////////////////////////////////////////////////////////////////////////

/**
 * Das Universum in welches deployt werden soll
 * @var string
 */
$deployPath    = '/srv/universe/'.$universe.'/';

/**
 * Systembenutzer und Gruppe welchen die Deployten Daten zugeordnet werden sollen
 * @var string
 */
$sysOwner  = 'www-data:root';

/**
 * Zugriffsberechtigungen 
 * @var string
 */
$sysAccess = '770';


/**
 * Liste der zu deployenden Repositories
 * @var array
 */
$deplGateways   = array
(  
  /* examples
  array
  ( 
    'name'  => 'WebFrap_Gw_SBiz', // Name des Projektes im Deployment Path
    'src'   => $repoRoot.'s-db/WebFrap_Gw_SBiz', 
    'rev'    => '', // definieren welche Revision verwendet werden soll
    'conf'  => 'sbd.demo' // den zu verwendenten Conf Key definieren
  ),
  array
  ( 
    'name'  => 'WebFrap_Gw_Cu4711' , 
    'src'   => $repoRoot.'WebFrap_customer/WebFrap_Gw_Cu4711', 
    'conf'  => 'prod.4711',
    'includes' => array // includes selbst definieren
    (
      'WebFrap_App_SBiz',
      'WebFrap_Core',
      'Customer_Module'
    )
  ),        
  */    
);

/**
 * Liste der Icon Projekte
 * @var array
 */
$deplIcons     = array
(  
  'Icons' => array
  (
    array
    ( 
      'src'   => $repoRoot.'webfrap_net/WebFrap_Icons_Default' 
    )
  )
);

/**
 * Liste der Theme Projekte
 * @var array
 */
$deplThemes    = array
(
  'Themes' => array
  (
    array
    (  
      'src'   => $repoRoot.'s-db/WebFrap_Theme_Default',
      'rev'   => 'rev:someref'
    ),
    array
    (  
      'src'   => $repoRoot.'WebFrap_customer/WebFrap_Theme_Customer'  
    )
  )
);

/**
 * Das Wgt Projekt
 * @var array
 */
$deplWgt       = array
(  
  'name'  => 'WebFrap_Wgt', 
  'src'   => $repoRoot.'webfrap_net/WebFrap_Wgt',
  'rev'    => ''
);

/**
 * Das Webfrap Projekt
 * @var array
 */
$deplFw     = array
(  
  'name'  => 'WebFrap', 
  'src'   => $repoRoot.'webfrap/WebFrap'         
);

/**
 * Anwendungs Module welche deployt werden sollen
 * @var array
 */
$deplRepos  = array
(
  'WebFrap_App_SBiz' => array
  (
    'WebFrap_App_SBiz' => array
    (
      'path' => $repoRoot.'s-db/',
      'rev'  => 'rev:1232124'
    ),
    'WebFrap_Sbiz_Mod_Base' => array
    (
      'path' => $repoRoot.'s-db/',
      'rev'  => 'tag:stable'
    ),
  ),
  'WebFrap_Core' => array
  (
    'WebFrap_Pontos'      => array
    (
      'path' => $repoRoot.'webfrap_net/',
      'rev'  => 'tag:stable'
    ),
    'WebFrap_Daidalos'    => array
    (
      'path' => $repoRoot.'webfrap_net/',
      'rev'  => 'tag:stable'
    ),
    'WebFrap_Enterprise'  => array
    (
      'path' => $repoRoot.'webfrap_net/',
      'rev'  => 'tag:stable'
    ),
    'WebFrap_Plutos'      => array
    (
      'path' => $repoRoot.'webfrap_net/',
      'rev'  => 'tag:stable'
    ),
  ),
);

////////////////////////////////////////////////////////////////////////////////
// Sync
////////////////////////////////////////////////////////////////////////////////

/**
 * Der Benötigte Username für den Zugriff auf die Repositories soweit
 * ein einheitlicher Access vorhanden ist
 * @var string
 */
$repoUser     = 'syncservice_user';

/**
 * Das benötigte Passwort für den Zugriff auf die Repositories soweit
 * ein einheitlicher Access vorhanden ist
 * @var string
 */
$repoPwd      = 'syncservice_pwd';

/**
 * Der Benutzer welchem das Repository zugeordnet werden soll
 * @var string
 */
$repoOwner    = 'wwwrun:root';

/**
 * Der Name welcher bei Commits für den Sync angezeigt wird
 * @var string
 */
$displayName  = 'syncservice_display';

/**
 * Die Commitmessage welche bei Auto Sync Commits angegeben wird
 * @var string
 */
$commitMessage  = '"- this is an auto commit for synchronizing the repository with the master"';

/**
 * Die Mailadresse welche in geclonten Repositories hinterlegt wird
 * @var string
 */
$contactMail    = 'contact@your_domain.de';

/**
 * Array mit alle Sync Repositories
 * @var array
 */
$syncRepos = array
(
  'demo' => array
  (
    array
    (
      'path'  => $repoRoot.'demo/',
      'repos' => array
      (
        'Demo_Mod_Core'    => array
        (
          'url'   => 'hg.webfrap-servers.de/demo/',
          'user'  => $repoUser,
          'pwd'   => $repoPwd
        ),
        'Demo_Mod_Project' => array
        (
          'url'   => 'hg.other-server.de/demo/',
          'user'  => $repoUser,
          'pwd'   => $repoPwd
        ),
        'Demo_Gw_Main' => array
        (
          'url'   => 'customer.de:8888/hg/app/',
          'user'  => $repoUser,
          'pwd'   => $repoPwd
        ),
      )
    ),
  ),
  'webfrap' => array
  (
    array
    (
      'path'  => $repoRoot.'webfrap/',
      'repos' => array
      (
        'WebFrap'    => array
        (
          'url'   => 'hg.webfrap-servers.de/webfrap/',
          'user'  => $repoUser,
          'pwd'   => $repoPwd
        ),
        'WebFrap_Wgt' => array
        (
          'url'   => 'hg.webfrap-servers.de/webfrap_net/',
          'user'  => $repoUser,
          'pwd'   => $repoPwd
        ),
      )
    ),
  ),
);
<?php display_highlight( 'php' ); ?>
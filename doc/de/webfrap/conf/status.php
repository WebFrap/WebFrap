<h1>Status Conf</h1>


<ul class="doc_tree" >
  <li><p>Sys</p>
    <ul>
      <li><span>sys.name</span></li>
      <li><span>sys.version</span></li>
      <li><span>sys.generator</span></li>
      <li><span>sys.admin.name</span></li>
      <li><span>sys.admin.mail</span></li>
      <li><span>sys.licence</span></li>
      <li><span>sys.copyright</span></li>
    </ul>
  </li>
  
  <li><p>Gateway</p>
    <ul>
      <li><span>gateway.name</span></li>
      <li><span>gateway.version</span></li>
      <li><span>gateway.licence</span></li>
    </ul>
  </li>
  
  <li><p>Tripple</p>
    <ul>
      <li><span>tripple.desktop</span></li>
      <li><span>tripple.annon</span></li>
      <li><span>tripple.user</span></li>
      
      <li><span>tripple.login</span></li>
      <li><span>tripple.setup</span></li>
    </ul>
  </li>

  <li><p>Key</p>
    <ul>
      <li><span>key.js</span></li>
      <li><span>key.style</span></li>
      <li><span>key.theme</span></li>
    </ul>
  </li>

  <li><p>Login</p>
    <ul>
      <li><span>login.forgot_pwd</span> boolean</li>
    </ul>
  </li>

  <li><p>Grid</p>
    <ul>
      <li><span>grid.context_menu.enabled</span> boolean</li>
    </ul>
  </li>
  
  <li><p>Debug</p>
    <ul>
      <li><span>debug.firephp</span></li>
      <li><span>debug.password</span></li>
    </ul>
  </li>
  
</ul>


<label>Code Beispiel</label>
<?php start_highlight(); ?>
/*
 * Standard System Status
 */
$this->status->content
(array
(

  'sys.name'        => 'WebFrap',
  'sys.version'     => '0.6',
  'sys.generator'   => 'WebFrap 0.6',
  'sys.admin.name'  => 'admin of the day',
  'sys.admin.mail'  => 'admin@webfrap.net',
  'sys.licence'     => 'GPLv3',
  'sys.copyright'   => 'S-DB http://s-db.de',

  'gateway.name'      => 'STABIntranet',
  'gateway.version'   => '0.1',
  'gateway.licence'   => 'GPLv3',

  'default.country'   => 'de',
  'default.language'  => 'de',
  'default.timezone'  => 'Europe/Berlin',
  'default.encoding'  => 'utf-8',
  'default.theme'     => 'default',
  'default.icons'     => 'default',
  'default.layout'    => 'full',

  'activ.country'     => 'de',
  'activ.language'    => 'de',
  'activ.timezone'    => 'Europe/Berlin',
  'activ.encoding'    => 'utf-8',
  'activ.theme'       => 'default',

  'key.js'            => 'default',
  'key.style'         => 'default',
  'key.theme'         => 'default',

  'path.theme'        => PATH_ROOT.'SDB_Theme_Default/themes/default/' ,
  'path.icons'        => PATH_ROOT.'WebFrap_Icons_Default/icons/default/' ,

  'web.theme'         => WEB_ROOT.'themes/themes/default/' ,
  'web.icons'         => WEB_ROOT.'icons/icons/default/' ,

  'default.title'         => 'Der Standard Title',

  'default.action.annon'  => 'Webfrap.Auth.Form',

  'tripple.desktop'     => 'webfrap.netsktop.display',
  'tripple.annon'       => 'webfrap.netsktop.display',
  'tripple.user'        => 'webfrap.netsktop.display',

  'tripple.login'       => 'Webfrap.Auth.Form',
  'tripple.setup'       => 'Webfrap.Base.Setup',

  'enable.firephp'    => false,
  //'enable.debugpwd'   => 'hanswurst', // CHANGE ME if enabled

));//end public $status = array
<?php display_highlight( 'php' ); ?>




<?php 

$iconOk = $this->icon( 'context/ok.png', 'is ok' );
$iconWarn = $this->icon( 'context/warn.png', 'warning' );
$iconBad = $this->icon( 'context/bad.png', 'not good' );

$phpModules = array
(
  'apc' => array( 'apc', "PHP opcode cache", $iconBad  ),
  'bcmath' => array( 'bcmath', "BCMath support", $iconWarn  ),
  'calendar' => array( 'calendar', "calendar support", $iconBad  ),
  'ctype' => array( 'ctype', "CType check functions", $iconBad  ),
  'curl' => array( 'curl', "curl", $iconWarn  ),
  'dom' => array( 'dom', "DOM Support", $iconBad  ),
  'filter' => array( 'filter', "filter", $iconBad  ),
  'openssl' => array( 'openssl', "Open SSL", $iconBad  ),
  'gd' => array( 'gd', "GD Image manipulation", $iconBad  ),
  'hash' => array( 'hash', "hash", $iconBad  ),
  'mbstring' => array( 'mbstring', "mbstring", $iconBad  ),
  'mcrypt' => array( 'mcrypt', "mcrypt", $iconBad  ),
  'memcache' => array( 'memcache', "memcache", $iconBad  ),
  'iconv' => array( 'iconv', "iconv", $iconWarn  ),
  'imap' => array( 'imap', "imap", $iconBad  ),
  'ldap' => array( 'ldap', "ldap", $iconWarn  ),
  'pgsql' => array( 'pgsql', "PostgreSQL support", $iconBad  ),
  'soap' => array( 'soap', "Soap Support", $iconWarn  ),
  'SimpleXML' => array( 'SimpleXML', "XML Support", $iconBad  ),
  'json' => array( 'json', "JSON Support", $iconBad  ),
  'pcre' => array( 'pcre', "RegEx Support", $iconBad  ),
  'Phar' => array( 'Phar', "Phar Support", $iconBad  ),
  'zlib' => array( 'zlib', "zlib", $iconBad  ),



  //'curl' => array( 'CURL', "CURL"  ),
);


?>



<div class="wgt-content_box inline wgt-space bw48" > 
  <div class="head" ><h2>Filesystem</h2></div>
  <div class="content" style="height:auto;" >
    <table class="wgt-table bw45"  >
    
      <thead>
        <th>Name</th>
        <th>Value</th>
        <th>Status</th>
        <th>Description</th>
      </thead>
      
      <tbody>
        <tr>
          <td>Memory</td>
          <td colspan="3" ><pre><?php echo SSystem::call('free -m') ?></pre></td>
        </tr>
        <tr>
          <td >System Space</td>
          <td colspan="3" ><pre><?php echo SSystem::call('df -m') ?></pre></td>
        </tr>
        <tr>
          <td>System Inodes</td>
          <td colspan="3" ><pre><?php echo SSystem::call('df -i') ?></pre></td>
        </tr>
      </tbody>
    
    </table>
  </div>
</div>

<div class="wgt-content_box inline wgt-space bw48" > 
  <div class="head" ><h2>Caches</h2> 
    <div class="right" >
      <a class="wcm wcm_req_del wgt-action " href="ajax.php?c=Webfrap.Cache.CleanAll" >clean all</a>
    </div>
  </div>
  <div class="content" style="height:auto;" >
    <table class="wgt-table bw45" >
      <thead>
        <tr>
          <th style="width:40px;" class="col" >Pos</th>
          <th style="width:120px;" >Name</th>
          <th>Description</th>
          <th style="width:170px;" >Stats</th>
          <th style="width:80px;" >Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach( $this->cacheModel->cacheDirs as $pos => $cDir ){ ?>
          <tr>
            <td class="pos" ><?php echo $pos ?></td>
            <td><?php echo $cDir->label ?></td>
            <td><?php echo $cDir->description ?></td>
            <td><?php echo $this->cacheMenu->renderDisplay( $cDir ) ?></td>
            <td><?php echo $this->cacheMenu->renderActions( $cDir ) ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<div class="wgt-content_box  inline wgt-space bw48" > 
  <div class="head" ><h2>PHP</h2></div>
  <div class="content" style="height:auto;" >
    <table class="wgt-table bw45"  >
    
      <thead>
        <th>Name</th>
        <th>Version</th>
        <th>Status</th>
        <th>Description</th>
      </thead>
      
      <tbody>
        <tr>
          <td>PHP Version</td>
          <td><?php echo phpversion(); ?></td>
          <td><?php echo $iconOk ?></td>
          <td>PHP</td>
        </tr>
        <?php foreach( $phpModules as $key => $modData ){ ?>
        <tr>
          <td><?php echo $modData[0] ?></td>
          <td><?php echo phpversion($key) ?></td>
          <td><?php echo extension_loaded($key)?$iconOk:$modData[2]; ?></td>
          <td><?php echo $modData[1] ?></td>
        </tr>
        <?php } ?>
      </tbody>
    
    </table>
  </div>
</div>

<div class="wgt-content_box  inline wgt-space bw48" > 
  <div class="head" ><h2>Metadata</h2>
    <div class="right" >
      <a 
        class="wcm wcm_req_del wgt-action" 
        title="Please confirm to clean the deprecated Metadata." 
        href="modal.php?c=Webfrap.Maintenance_Metadata.cleanAll" >clean all</a>
    </div>
  </div>
  <div class="content" style="height:auto;" >
    <table class="wgt-table wgt-space bw45" >
      <thead>
        <tr>
          <th style="width:40px;" class="col" >Pos</th>
          <th style="width:120px;" >Name</th>
          <th style="width:120px;" >Key</th>
          <th style="width:40px;" >Old</th>
          <th style="width:75px;" >Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach( $this->metadataModel->statsData as $pos => $table ){ ?>
          <tr>
            <td class="pos" ><?php echo $pos ?></td>
            <td><?php echo $table['label'] ?></td>
            <td><?php echo $table['access_key'] ?></td>
            <td><?php echo $table['num_old']  ?></td>
            <td><?php echo $this->metadataMenu->renderActions( $this->metadataMenu->listActions, $table ) ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>



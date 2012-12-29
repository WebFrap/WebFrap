<?php 

$iconOk = $this->icon( 'context/ok.png', 'is ok' );
$iconWarn = $this->icon( 'context/warn.png', 'warning' );
$iconBad = $this->icon( 'context/bad.png', 'not good' );

$phpModules = array
(
  'apc' => array( 'APC', "PHP opcode cache", $iconBad  ),
  'ctype' => array( 'CType', "CType check functions", $iconBad  ),
  'openssl' => array( 'Open SSL', "Open SSL", $iconBad  ),
  'pgsql' => array( 'PostgreSQL', "PostgreSQL support", $iconBad  ),
  'soap' => array( 'SOAP', "Soap Support", $iconWarn  ),
  'xml' => array( 'XML', "XML Support", $iconBad  ),
  'json' => array( 'JSON', "JSON Support", $iconBad  ),
  'pcre' => array( 'PCRE', "RegEx Support", $iconBad  ),
  //'curl' => array( 'CURL', "CURL"  ),
);

?>

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

<div class="wgt-content_box left wgt-space bw48" > 
  <div class="head" ><h2>Caches</h2> 
    <div class="right" >
    <a class="wcm wcm_req_del wgt-action " href="ajax.php?c=Webfrap.Cache.CleanAll" >clean all</a>
    </div>
  </div>
  <div class="content" style="height:auto;" >
    <table class="wgt-grid simple wgt-space" >
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
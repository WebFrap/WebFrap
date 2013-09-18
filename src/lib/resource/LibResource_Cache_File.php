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
 */
class LibResource_Cache_File implements LibResource_CacheAdapter
{

  /**
   * @var array
   */
  protected $loadedModules = array();

  /**
   * @var array
   */
  protected $areaIds = array();

  /**
   * @var array
   */
  protected $groupIds = null;

  /**
   * @param string $areaKey
   */
  public function getAreaId($areaKey)
  {

    if(!isset($this->areaIds[$areaKey])){
      $modKey = $this->extractKey($areaKey);
      $this->loadAreaCache($modKey);
    }

    return isset($this->areaIds[$areaKey])?$this->areaIds[$areaKey]:null;

  }//end public function getAreaId */


  /**
   * @param array $areaKeys
   */
  public function addAreaId($key, $id)
  {
    $this->areaIds[$key] = $id;

    $self = $this;
    Webfrap::$env->registerShutdownFunction(
      'cache_resource_areaids',
      function() use ($self){
        /*@var LibResource_Cache_File $self */
        $self->writeAreaCache();
      }
    );

  }//end public function addAreaId */

  /**
   * Extract the module name from the the key
   * @param string $areaKey
   * @return string
   */
  protected function extractKey($areaKey)
  {
    
    Debug::console('extract area resource key '.$areaKey);
    
    $modKey = explode('-',$areaKey,2);
    $modKey = explode('_',$modKey[1],2);
    return $modKey[0];
  }//end protected function extractKey */

  /**
   * Laden eines gecachten modules
   */
  protected function loadAreaCache($modKey)
  {

    if (isset($this->loadedModules[$modKey])) {
      return;
    }

    if (file_exists(PATH_CACHE.'resource/area-'.$modKey.'-ids.php')){
      include PATH_CACHE.'resource/area-'.$modKey.'-ids.php';
    }

    $this->loadedModules[$modKey] = true;

  }//end protected function loadAreaCache */

  /**
   * Write the area cache
   *
   * could have race conditions
   * in theory it's possible that in the beginning some allready cached areas
   * are overwritten or removed
   * how ever this is not really a big issue
   */
  public function writeAreaCache()
  {

    $mods = array();

    foreach ($this->areaIds as $key => $id) {
      $mods[$this->getAreaId($key)][$key] = $id;
    }

    foreach( $mods as $modKey => $modData ){

      $cacheData = '';
      foreach ($modData as $modKey => $modId) {
        $cacheData .= "'{$modKey}' => '{$modId}',";
      }

      $cData = <<<CACHE
<?php
\$this->areaIds = array_merge(\$this->areaIds, array(
{$cacheData}
));
CACHE;

      SFiles::write(PATH_CACHE.'resource/area-'.$modKey.'-ids.php', $cData);

    }

  }//end public function writeAreaCache */

  /**
   * @param string $groupKey
   * @return int
   */
  public function getGroupId($groupKey)
  {

    if (!$this->groupIds)
      $this->loadGroupCache();

    return isset($this->groupIds[$groupKey])
      ? $this->groupIds[$groupKey]
      : null;

  }//end public function getGroupId */


  /**
   * @param array $key
   */
  public function addGroupId($key, $id)
  {
    $this->groupIds[$key] = $id;

    $self = $this;
    Webfrap::$env->registerShutdownFunction(
      'cache_resource_groupids',
      function() use ($self){
        /*@var LibResource_Cache_File $self */
        $self->writeGroupCache();
      }
    );

  }//end public function addAreaId */

  /**
   * Laden des Group Caches
   */
  public function loadGroupCache()
  {

    if (file_exists(PATH_CACHE.'resource/group_ids.php')){
      include PATH_CACHE.'resource/group_ids.php';
    } else {
      $this->groupIds = array();
    }

  }//end public function loadGroupCache */

  /**
   * Write the group cache
   *
   * could have race conditions
   * in theory it's possible that in the beginning some values get lost
   * how ever this is not really a big issue
   */
  public function writeGroupCache()
  {

    $cacheData = '';

    foreach ($this->groupIds as $key => $id) {
      $cacheData .= "'{$key}' => '{$id}',";
    }

    $cData = <<<CACHE
<?php
\$this->groupIds = array(
{$cacheData}
);
CACHE;

    SFiles::write(PATH_CACHE.'resource/group_ids.php', $cData);

  }//end public function writeGroupCache */

} // end class LibResource_Cache_File


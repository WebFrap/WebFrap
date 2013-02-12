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
 */
class DaidalosCodeRepository_Model
  extends Model
{

  protected $dataSource = null;

  /**
   * @return array
   */
  public function getRepositories()
  {

    $xml = $this->getDataSource();

    $projects = array();

    foreach( $xml->body->workspace->project as $project )
    {
      $projects[] = trim($project['name']);
    }

    return $projects;

  }//end public function getProjects */

  /**
   * @return array
   */
  public function getGalaxies()
  {

    $xml = $this->getDataSource();

    $galaxies = array();

    foreach( $xml->body->galaxies->galaxy as $galaxy )
    {
      $galaxies[] = trim($galaxy['name']);
    }

    return $galaxies;

  }//end public function getGalaxies */

  /**
   * @return array
   */
  public function getSelectGalaxies()
  {

    $xml = $this->getDataSource();

    $galaxies = array();

    foreach( $xml->body->galaxies->galaxy as $galaxy )
    {
      $galaxies[] = array( 'id'=>trim($galaxy['name']),'value'=>trim($galaxy['name']) ) ;
    }

    return $galaxies;

  }//end public function getSelectGalaxies */

  /**
   * @return array
   */
  public function getRepoProjects()
  {

    $xml = $this->getDataSource();

    $projects = array();

    foreach( $xml->body->workspace->project as $project )
    {
      $projects[] = trim($project['name']);
    }

    return $projects;

  }//end public function getProjects */


  /**
   * @return array
   */
  public function getDataSource()
  {

    if(!$this->dataSource)
      $this->dataSource = simplexml_load_file( PATH_GW.'/data/bdl/repositories/index.xml' );

    return $this->dataSource;

  }//end public function getDataSource */

}//end class ModelDaidalosCodeRepository


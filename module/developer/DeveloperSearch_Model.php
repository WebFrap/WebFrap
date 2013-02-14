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
class DeveloperSearch_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var string
   */
  protected $pattern = null;

  /**
   *
   * @var string
   */
  protected $data = null;

  /**
   * @return string
   */
  public function getPattern()
  {
    return $this->pattern;
  }//end public function getPattern */

  /**
   * @return array
   */
  public function getSearchResults()
  {
    return $this->data;
  }//end public function getSearchResults */


  /**
   * @return array
   */
  public function getProjects()
  {

    $xml = simplexml_load_file( PATH_GW.'/data/bdl/workspace/projects.xml' );

    $projects = array();

    foreach($xml->body->workspace->project as $project )
    {
      $projects[] = trim($project['name']);
    }

    return $projects;

  }//end public function getProjects */

  /**
   * @return void
   */
  public function search($folder, $pattern, $endings  )
  {

    $this->pattern = $pattern;

    $search = new LibSearchFile();
    $this->data = $search->search($folder, $pattern, $endings,true);

  } // end public function search */


}//end class DeveloperSearch_Model


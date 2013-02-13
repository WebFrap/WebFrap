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
 * @subpackage Daidalos
 */
class DaidalosGen_Model
  extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Project BDL
   * @var SimpleXMLElement
   */
  public $projectNode = null;

  /**
   * Pfad zum Project BDL
   * @var string
   */
  public $projectPath = null;
  
  /**
   * Pfad hinzufügen
   * @var string
   */
  public $targetPath = null;
  
  /**
   * Vorhandener Code soll überschrieben werden
   * @var boolen
   */
  public $forceOverwrite = false;
  
  /**
   * Modellpfad
   * @var string
   */
  public $modelPath = null;
  
  /**
   * Das Builder Object
   * @var LibGenfSkeletonBuilder
   */
  public $builder = null;
  
/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $path
   * @param string $bdlPath
   * @param string $genTarget
   * @throws Io_Exception
   */
  public function loadProject( $path, $bdlPath, $genTarget )
  {
    
    if( !file_exists($path) )
      throw new Io_Exception( "Missing requested BDL project file ".$path );

    $this->modelPath = $bdlPath;
    $this->targetPath = $genTarget;

    $this->projectPath = $path;
    $this->projectNode = simplexml_load_file( $path );
    
    $this->builder = new LibGenfSkeletonBuilder();
    $this->builder->forceOverwrite = $this->forceOverwrite;
    $this->builder->loadSkeletonProject( $this->projectNode, $genTarget );
    $this->builder->loadInterpreter();

  }//end public function loadProject */
  
  /**
   * Bauen des Codes
   * @param string $bdlPath
   * @param string $genTarget
   */
  public function buildSkeleton( $bdlPath, $genTarget )
  {

    $this->builder->buildSkeletonTree( $bdlPath );
    $this->builder->buildSkeleton( $genTarget );
  
  }//end public function buildSkeleton */

  /**
   * @return SimpleXMLElement
   */
  public function getProject()
  {
    
    return $this->projectNode;
    
  }//end public function getProject */

}//end class DaidalosGen_Model


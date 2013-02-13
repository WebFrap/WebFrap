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
  * A Class to resolve Dependencies
  * @package WebFrap
  * @subpackage tech_core
  */
class LibDependency
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * temporary data to create the dependencies from
   *
   * @var array
   */
  protected $tempTree     = array();

  /**
   * the dependencies
   *
   * @var array
   */
  protected $sorted       = array();

  /**
   * the depth
   *
   * @var int
   */
  protected $runs         = 0;

  /**
   * should the depedency table revertet?
   *
   * @var boolean
   */
  protected $reorganize   = true;

  /**
   * some keyname only needed for better error messages but not really nessesary
   *
   * @var string
   */
  protected $keyName      = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Format:
   *
   * <p>
   * array
   * (
   * array('child1','father1'),
   * array('child1','father2'),
   * array('child2','father1'),
   * array('father','grand father'),
   * )
   * </p>
   *
   * @param array $data the array to resolve
   * @param boolean $reorganize should be the dependecies from top down?
   * @param string $keyName the keyname
   *
   */
  public function __construct($data , $reorganize = true, $keyName = null )
  {

    $this->keyName     = $keyName;
    $this->setDependencys($data , $reorganize);

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * set the dependency data to solve:
   *
   * Format:
   *
   * <p>
   * array
   * (
   * array('child1','father1'),
   * array('child1','father2'),
   * array('child2','father1'),
   * array('father','grand father'),
   * )
   * </p>
   *
   * @param array $data the array to resolve
   * @param boolean $reorganize should be the dependecies from top down?
   */
  public function setDependencys($data , $reorganize = true)
  {
     $this->reorganize = $reorganize;
     $this->buildPreTree($data);
  }//end public function setDependencys */

  /**
   * get the resolved dependencies
   *
   * @return array
   */
  public function getResloved()
  {
    return $this->sorted;
  }//end public function getResloved */

/*//////////////////////////////////////////////////////////////////////////////
// Logig
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * cut the leafes from the tree
   *
   * @return boolean
   * @throws Lib_Exception
   */
  protected function cutLeafs( )
  {

    $cutted = 0;

    foreach( $this->tempTree as $father => $childs )
    {

      if( count($childs) == 0 )
      {
        unset($this->tempTree[$father]);
        $this->removeChild($father);
        ++$cutted;

        $this->sorted[$this->runs][$father] = $father;
      }

    }

    ++ $this->runs;

    if( count($this->tempTree) == 0 )
    {
      // if the tree is complete cleaned it's done
      return true;
    }
    else if( $cutted == 0 )
    {
      // tree still not empty bud we could not resolv any dependency? that's bad
      // the dependency is not resolvable
      Debug::console('broken dependency in '. $this->keyName, array($this->tempTree) );
      throw new Lib_Exception( 'broken dependency : '.$this->keyName );
    }
    else
    {
      // ok everthing fine but we are not yet finished
      return false;
    }

  }//end public function cutLeafs */

  /**
   * Enter description here...
   *
   */
  public function solveDependencies()
  {

    try
    {
      while( !$this->cutLeafs() ){}
    }
    catch( Lib_Exception $e )
    {
      Message::addError($e->getMessage());
      Debug::console('broken dependency '.$e->getMessage());
    }

    if( $this->reorganize )
    {
      $this->reorganize();
    }

    return $this->sorted;

  }//end public function solveDependencies */

  /**
   * build the dependency tree
   *
   * @param array $data
   * @return void
   */
  protected function buildPreTree( $data )
  {

    foreach( $data as $pos => $tmp )
    {
      $child   = trim($tmp[0]);
      $father  = trim($tmp[1]);

      if(!isset($this->tempTree[$father]))
      {
        $this->tempTree[$father]= array();
      }

      if(!isset($this->tempTree[$child]))
      {
        $this->tempTree[$child]= array();
      }

      $this->tempTree[$father][$child] = $child;


    }

  }//end function buildPreTree */

  /**
   * remove a child from the temptree
   *
   * @param string $child
   */
  protected function removeChild( $child )
  {

    foreach( $this->tempTree as $pos => $tree )
    {
      if( isset($tree[$child]) )
      {
        unset($this->tempTree[$pos][$child]);
      }
    }

  }//end protected function removeChild */

  /**
   * Enter description here...
   * Return an the dependencies in reverse order
   */
  protected function reorganize()
  {
    /*
    $data = array();

    $size = count($this->sorted)-1;

    for( $nam = $size ; $nam >= 0 ; --$nam )
    {
      $data[] = $this->sorted[$nam];
    }

    $this->sorted = $data;
    */

    $this->sorted = array_reverse( $this->sorted );

  }//end protected function reorganize */

  /**
   *
   * @return array
   */
  public function getCombined()
  {

    $comb = array();

    foreach( $this->sorted as $toSort )
    {
      foreach( $toSort as $pos )
      {
        $comb[] = $pos;
      }
    }

    return $comb;

  }//end public function getCombined */


}//end class LibDependencies



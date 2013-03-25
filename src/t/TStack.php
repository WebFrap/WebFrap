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
class TStack
{

  /**
   *
   * @var int
   */
  protected $size   = array();

  /**
   *
   * @var array
   */
  protected $stacks  = array();

  /**
   * pointer to the actual stack for iterators
   * @var int
   */
  protected $pointer = 0;

  /**
   *
   * @var int
   */
  protected $smallest = null;

  /**
   *
   * @var int
   */
  protected $next     = null;

  /**
   *
   * @var int
   */
  protected $biggest  = null;

  /**
   * pointer to the smallest stack
   * @var int
   */
  protected $pointerSmallest = null;

/*//////////////////////////////////////////////////////////////////////////////
// Magic Functions
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @param int $size
   * @return unknown_type
   */
  public function __construct($size)
  {

    // if size is an array we have named stacks else simple numerized stacks
    if (is_array($size)) {
      foreach ($size as $stackName) {
         $this->stacks[$stackName] = array();
      }
    } else { // initialize empty stacks
      for ($num = 0; $num < $size ; ++$num) {
        $this->stacks[] = array();
      }
    }

  }//end public function __construct

/*//////////////////////////////////////////////////////////////////////////////
// logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string/int $position
   */
  public function getStack($position)
  {
    return $this->stacks[$position];
  }//end public function getStack */

  /**
   *
   * @param string/int $position
   * @param typeless $value
   * @return void
   */
  public function append($position , $value)
  {
    /// TODO error handling
    $this->stacks[$position] = $value;

  }//end public function append */

  /**
   * @param string/int $position
   */
  public function shift($position)
  {
    /// TODO error handling
    return array_shift($this->stacks[$position]);
  }//end public function shift */

  /**
   * @param string/int $position
   */
  public function pop($position)
  {
    /// TODO error handling
    return array_pop($this->stacks[$position]);
  }//end public function pop */

  /**
   *
   * @param typeless $entry
   * @return void
   */
  public function appendSmallest($entry)
  {

    $this->stacks[$this->pointerSmallest][] = array();
    ++ $this->$this->smallest;

    // check if the smallest is not the smalles anymore
    if ($this->smallest > $this->next) {
      // if not recalculate te balance
      $this->checkStackBalance();
    }

  }//end public function appendSmallest */

  /**
   * check the balance in the Stack
   * @return void
   */
  protected function checkStackBalance()
  {

    // set vars back to initial value
    $this->smallest         = 100000;
    $this->next             = null;
    $this->biggest          = 0;
    $this->pointerSmallest  = null;

    foreach ($this->stacks as $stackName => $stack) {
      $size = count($stack);

      // bigger than biggest is new biggest
      if ($size > $this->biggest) {
        $this->biggest = $size;

        // like a ugly init
        if (is_null($this->next))
          $this->next = $size;

      }

      // smaller than smallest must be new smallest
      if ($size < $this->smallest) {
        $this->smallest = $size;
      }

      // smaller the next but bigger or equal than smallest is new next
      if ($size < $this->next && $size >= $this->smallest) {
        $this->next = $size;
      }

    }//end foreach($autoLayout as $layout)

    // fillup the list for the smallest nodes
    foreach ($this->stacks as $stackName => $stack) {

      $size = count($stack);

      if ($size == $stack->smallest) {
        $stack->pointerSmallest = $stackName;
        break; // end here
      }
    }//end foreach

  }//end protected function checkStackBalance

}//end class TStack


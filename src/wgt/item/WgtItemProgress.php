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
class WgtItemProgress
  extends WgtSelectboxHardcoded
{

  /**
   * Enter description here...
   *
   * @var string
   */
  public $firstFree = null;

  /**
   * Enter description here...
   *
   * @var array
   */
  protected $data = array
  (
  0      =>  array( 'value' => '0   %' ),
  10     =>  array( 'value' => '10  %' ),
  20     =>  array( 'value' => '20  %' ),
  30     =>  array( 'value' => '30  %' ),
  40     =>  array( 'value' => '40  %' ),
  50     =>  array( 'value' => '50  %' ),
  60     =>  array( 'value' => '60  %' ),
  70     =>  array( 'value' => '70  %' ),
  80     =>  array( 'value' => '80  %' ),
  90     =>  array( 'value' => '90  %' ),
  100    =>  array( 'value' => '100 %' ),
  );


  public function setContent( $activ )
  {
    $this->activ = $activ;
  }

} // end class WgtItemProgress



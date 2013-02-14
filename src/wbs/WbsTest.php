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
 * Webservice for Table stoa_user
 * the user table
 * @package WebFrap
 * @subpackage tech_core Test
 * @author Dominik Bonsch
 * @copyright Dominik Bonsch
 */
class WbsTest extends Webservice
{

  /**
   * load StoaUser
   * @return void
   */
  public function loadTest()
  {

    $this->data[] = array('id_1','eckbert');
    $this->data[] = array('id_2','ugly');

    //$this->data = array('eckbert','ugly','harry');

  }//end public function loadTest()

  /**
   * load StoaUser
   * @return void
   */
  public function loadTestMulti()
  {

    $this->data[] = 'hugo';
    $this->data[] = array('id_1','id_2');
    $this->data[] = array('eckbert','ugly');

  }//end public function loadTest()

}//end class WbsTest



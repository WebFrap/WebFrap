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
abstract class LibVerificationAdapter
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var
   */
  protected $dataSource = null;

  /**
   *
   * @var User
   */
  protected $user       = null;

  /**
   *
   * @var LibMessagePool
   */
  protected $message    = null;

  /**
   * flag to mark if it is necessary to check the password, or if it is ok
   * if the user just exists
   * Makes sense with ssl / cert logins
   * @var boolean
   */
  protected $nopwd      = false;

////////////////////////////////////////////////////////////////////////////////
// setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * set a datasource
   * @param mixed
   * @return void
   */
  public function setDatasource( $datasource )
  {
    $this->dataSource = $datasource;
  }//end public function setDatasource */

  /**
   * set a user object
   * @param User $user
   * @return void
   */
  public function setUser( $user )
  {
    $this->user = $user;
  }//end public function setUser */

  /**
   * set the flag if the password is required or not
   * @param boolean $nopwd
   * @return void
   */
  public function passwordNotRequired( $nopwd = true )
  {
    $this->nopwd = $nopwd;
  }//end public function passwordNotRequired */

  /**
   * @setter self::$message
   * @param LibMessagePool $message
   */
  public function setMessage( LibMessagePool $message )
  {

    $this->message = $message;

  }//end public function setMessage */

  /**
   * @getter self::$message
   * @return LibMessagePool
   */
  public function getMessage( )
  {

    if( !$this->message )
      $this->message = Message::getActive();

    return $this->message;

  }//end public function getMessage */

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param string $login
   * @param string $pwd
   * @return boolean
   */
  abstract public function verificate( $login , $pwd = null );

} // end class LibVerificationAdapter

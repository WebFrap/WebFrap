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
class LibAuth
  extends BaseChild
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var string
   */
  protected $authType           = 'Httppost';

  /**
   *
   * @var string
   */
  protected $verificationType   = 'Sql';

  /**
   *
   * @var string
   */
  public $username           = null;

  /**
   *
   * @var string
   */
  public $password           = null;

  /**
   * flag if a password is required for login
   * @var boolean
   */
  public $noPasswd           = false;

////////////////////////////////////////////////////////////////////////////////
// getter + setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $username
   */
  public function setUsername( $username )
  {
    $this->username = $username;
  }//end public function getUsername */

  /**
   * @param string $password
   */
  public function setPassword( $password )
  {
    $this->password = $password;
  }//end public function getPassword */

  /**
   *
   * Enter description here ...
   * @param unknown_type $noPasswd
   */
  public function setNoPasswd( $noPasswd = true )
  {
    $this->noPasswd = $noPasswd;
  }

  /**
   *
   * @return string
   */
  public function getUsername()
  {
    return $this->username;
  }//end public function getUsername */

  /**
   *
   * @return string
   */
  public function getPassword()
  {
    return $this->password;
  }//end public function getPassword */

////////////////////////////////////////////////////////////////////////////////
// methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function __construct( $env, $aType = null, $vType = null )
  {

    $this->env = $env;

    if( $aType )
      $this->authType = $aType;

    if( $vType )
      $this->verificationType = $vType;

  }//end public function __construct */

  /**
   * @param string $username
   * @param string $password
   */
  public function login( $username = null, $password = null )
  {

    $conf = $this->getConf();

    if ( is_null($username) ) {

      if( !$this->authType )
        if( !$this->authType = $conf->getStatus( 'interface.auth' ) )
          $this->authType = 'Httppost';

      $authClass = 'LibAuth'.$this->authType;
      if ( !WebFrap::classLoadable( $authClass ) ) {
        Error::report( 'Authmodule: '.$authClass.' not exists. Please check your Configuration, or your Modulepath.' );

        return false;
      }

      $auth         = new $authClass( $this );

      if( !$auth->fetchLoginData( $this ) )

        return false;
    } else {
      $this->username = $username;
      $this->password = $password;
    }

    if( !$this->verificationType )
      if( !$this->verificationType = $conf->getStatus( 'interface.verification' ) )
        $this->verificationType = 'Sql';

    $verificationClass = 'LibVerification'.$this->verificationType;
    if ( !WebFrap::classLoadable( $verificationClass ) ) {
      Error::report( 'Verification: '.$verificationClass.' not exists. Please check your Configuration, or your Modulepath.' );

      return false;
    }
    $verification = new $verificationClass();

    if( $this->noPasswd )
      $verification->passwordNotRequired(true);

    return $verification->verificate( $this->username , $this->password );

  }//end public function login */

  /**
   *
   */
  public function verificate( $username, $password, $noPasswd = false )
  {

    $conf = Conf::getActive();

    if( !$verificationType = $conf->getStatus( 'interface.verification' ) )
      $verificationType = 'Sql';

    $verificationClass = 'LibVerification'.$verificationType;
    if ( !WebFrap::classLoadable( $verificationClass ) ) {
      Error::report( 'Verification: '.$verificationType.' not exists. Please check your Configuration, or your Modulepath.' );

      return false;
    }

    $verification = new $verificationClass();

    if( $noPasswd )
      $verification->passwordNotRequired();

    return $verification->verificate( $username , $password );

  }//end public function verificate */

  /**
   * @param string $pwd
   */
  public function changePasswd( $pwd )
  {

    $orm = $this->getOrm();

    return $orm->update
    (
      'WbfsysRoleUser',
      self::id(),
      array
      (
        'password'    =>  SEncrypt::passwordHash($pwd),
        'change_pwd'  =>  ''
      )
    );

  }//end public static function changePasswd */

} // end class LibAuth

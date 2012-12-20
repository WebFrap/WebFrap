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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapAuth_Controller
  extends Controller
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Jeder darf daraf zugreifen,
   * Wäre auch doof wenn nur eingeloggte user sich einloggen dürfen
   * @var boolean
   */
  protected $fullAccess = true;
  
  /**
   * Mit den Options wird der zugriff auf die Service Methoden konfiguriert
   * 
   * @var array
   */
  protected $options = array
  (
    'form' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab', 'html' )
    ),
    'login' => array
    (
      'method'    => array( 'POST' ),
      'views'      => array( 'ajax', 'html' )
    ),
    'logout' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'ajax', 'maintab', 'html' )
    ),
    'formresetpasswd' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab', 'html' )
    ),
    'resetpasswd' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax', 'html' )
    ),
    'formchangepasswd' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab', 'html' )
    ),
    'changepasswd' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax', 'html' )
    ),
    'formforgotpasswd' => array
    (
      'method'    => array( 'GET' ),
      'views'      => array( 'maintab', 'html' )
    ),
    'forgotpasswd' => array
    (
      'method'    => array( 'PUT', 'POST' ),
      'views'      => array( 'ajax', 'html' )
    ),
  );

////////////////////////////////////////////////////////////////////////////////
// Login
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_form( $request, $response )
  {

    if( $this->view->isType( View::AJAX ) )
      View::$sendBody = true;

    View::$sendMenu = false;


    $this->view->setTitle( Conf::status( 'default.title' ).' Login' );
    $this->view->setIndex( 'login'  );
    $this->view->setTemplate( 'webfrap/auth/form_login', true  );

    $inputLoginname = $this->view->newInput( 'inputLoginname' , 'Input' );
    $inputLoginname->addAttributes
    (array
    (
      'name'  => 'name',
      'type'  => 'text',
      'class' => 'medium'
    ));

    $inputPasswd = $this->view->newInput( 'inputPasswd' , 'Input' );
    $inputPasswd->addAttributes
    (array
    (
      'name'  => 'password',
      'type'  => 'password',
      'class' => 'medium'
    ));

    $inputSubmit = $this->view->newInput( 'inputSubmit' , 'Input' );
    $inputSubmit->addAttributes
    (array
    (
      'type'  => 'submit',
      'class' => 'wgtButton submit',
      'value' => 'Login'
    ));

  }//end public function service_form */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_login( $request, $response )
  {

    $auth     = new LibAuth( $this );
    $response = $this->getResponse();
    $orm      = $this->getOrm();

    /* @var $model WebfrapAuth_Model */
    $model = $this->loadModel( 'WebfrapAuth' );
    
    if( $auth->login() )
    {

      $user = $this->getUser();
      $user->setDb( $this->getDb() );

      $userName = $auth->getUsername();
      
      try
      {
        if( !$authRole = $orm->get( 'WbfsysRoleUser', "UPPER(name) = UPPER('{$userName}')" ) )
        {
          $response->addError( 'User '.$userName.' not exists' );
          return false;
        }
      }
      catch( LibDb_Exception $exc )
      {
        $response->addError( 'Error in the query to fetch the data for user: '.$userName );
        return false;
      }

      if
      ( 
        defined('WBF_AUTH_TYPE') 
          && 2 == WBF_AUTH_TYPE && ( $userName != 'admin' ) 
          && !$authRole->non_cert_login 
      )
      {
        $response->addError
        ( 
          'Login Via Password is not permitted, you need a valid X509 SSO Certificate' 
         );
        $this->service_form($request, $response);
        return;
      }

      if( $user->login( $authRole ) )
      {

        if( $this->view->isType( View::AJAX ) )
          View::$sendIndex = true;
          
        $model->protocolLogin( $user );

        $conf = Conf::get('view');
        $this->view->setHtmlHead( $conf['head.user'] );

        Webfrap::getInstance()->redirectToDefault();
        return true;

      }
      else
      {

        $conf = Conf::get('view');

        $this->view->setIndex( $conf['index.login'] );
        $this->view->setHtmlHead( $conf['head.login'] );

        $this->view->message->addError('Failed to login');
      }
    }
    else
    {
      $conf = Conf::get('view');
      $this->view->setIndex( $conf['index.login'] );
      $this->view->setHtmlHead( $conf['head.login'] );
      $this->view->message->addError('Login Failed');
      $this->service_form($request, $response);
    }

  }// end public function service_login */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_reload( $request, $response )
  {

    $auth = new LibAuth( $this );

    $user = $this->getUser();
    $user->reload();

  }// end public function service_reload */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_formResetPasswd( $request, $response )
  {

    $this->tplEngine->setHtmlHead( 'public' );
    $this->tplEngine->setIndex( 'public/default' );

    $this->view->setTemplate( 'webfrap/auth/form_reset_pwd', true  );

  }//end public function service_formResetPasswd */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_formChangePasswd( $request, $response )
  {

    $this->tplEngine->setHtmlHead( 'public' );
    $this->tplEngine->setIndex( 'public/default' );

    $this->view->setTemplate( 'webfrap/auth/form_change_pwd', true  );

  }//end public function service_formChangePasswd */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return boolean
   */
  public function service_formForgotPasswd( $request, $response )
  {

    $this->tplEngine->setHtmlHead( 'public' );
    $this->tplEngine->setIndex( 'public/plain' );

    $this->view->setTemplate( 'webfrap/auth/form_forgot_pwd', true  );

  }//end public function service_formForgotPasswd */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_resetPasswd( $request, $response )
  {

    $response = $this->getResponse();
    $request  = $this->getRequest();
    $user     = $this->getUser();

    $auth = new LibAuth( $this );

    $oldPwd     = $request->data( 'password_old' , Validator::PASSWORD );
    $pwdNew     = $request->data( 'password_new' , Validator::TEXT );
    $pwdCheck   = $request->data( 'password_check' , Validator::TEXT );

    $i18n = $this->getI18n();

    if( $auth->verificate( $user->getData('name'), $oldPwd ) )
    {
      if( $pwdNew ==  $pwdCheck )
      {

        $user->changePasswd($pwdNew);
        $response->addMessage
        (
          $response->i18n->l('Successfully changed password!','wbf.message')
        );
      }
      else
      {
        $response->addError
        (
          $response->i18n->l('The both passwords are not equal!','wbf.message')
        );
      }
    }
    else
    {
      $response->addError
      (
        $response->i18n->l('The old password is wrong!','wbf.message')
      );
    }

  }// end public function service_resetPasswd */

  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_changePasswd( $request, $response )
  {

    $response = $this->getResponse();
    $request  = $this->getRequest();
    $user     = $this->getUser();

    $auth = new LibAuth( $this );

    $oldPwd     = $request->data( 'password_old' , Validator::PASSWORD );
    $pwdNew     = $request->data( 'password_new' , Validator::TEXT );
    $pwdCheck   = $request->data( 'password_check' , Validator::TEXT );

    $i18n = $this->getI18n();

    if( $auth->verificate( $user->getData('name'), $oldPwd ) )
    {
      if( $pwdNew ==  $pwdCheck )
      {

        $user->changePasswd($pwdNew);
        $response->addMessage
        (
          $response->i18n->l('Successfully changed password!','wbf.message')
        );
      }
      else
      {
        $response->addError
        (
          $response->i18n->l('The both passwords are not equal!','wbf.message')
        );
      }
    }
    else
    {
      $response->addError
      (
        $response->i18n->l('The old password is wrong!','wbf.message')
      );
    }

  }// end public function service_changePasswd */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_forgotPasswd( $request, $response )
  {

    $response = $this->getResponse();
    $request  = $this->getRequest();
    $orm      = $this->getOrm();
 
    $userName  = $request->data( 'username', Validator::TEXT );
    $eMail     = $request->data( 'e_mail', Validator::EMAIL );

    $model = $this->loadModel( 'WebfrapAuth' );
    
    $view = $response->loadView
    ( 
      'webfrap_auth-forgot_passwd', 
      'WebfrapAuth_ForgotPasswd'
    );
    
    
    try 
    {
      if( $userName )
      {
        
        $user = $model->getUserByName( $userName );
        
        if( !$user )
        {
          $view->displayError
          ( 
            "Der von dir angebene Benutzername ".SValid::text($userName)." existiert nicht! Hast du dich vielleicht vertippt?" 
          );
          return;
        }
        
        $model->startResetProcess( $user );
        
        $view->displaySuccess
        ( 
          "Es wurde eine E-Mail an die von dir hinterlegte Kontaktadresse verschickt. 
            Bitte folge den Anweisungen in der E-Mail um das Zurücksetzen abzuschliesen." 
        );
        
      }
      else if( $eMail )
      {
        
        $user = $model->getUserByEmail( $eMail );
        
        if( !$user )
        {
          $view->displayError
          ( 
            "Die von dir angegebene E-Mail ".SValid::text($eMail)." existiert nicht! Hast du dich vielleicht vertippt?" 
          );
          return;
        }
        
        $model->startResetProcess( $user );
        
        $view->displaySuccess
        ( 
          "Es wurde eine E-Mail an die von dir hinterlegte Kontaktadresse verschickt. 
            Bitte folge den Anweisungen in der E-Mail um das Zurücksetzen abzuschliesen." 
        );
        
      }
      else 
      {
        $view->displayError
        ( 
          "Zu Zurücksetzen des Passworts wird entweder ihr Benutzername, oder die E-Mail Adresse mit der sie 
          sich angemeldet haben benötigt. Solltest du beide vergessen haben wende dich bitte an den Support." 
        );
      }
    }
    catch( WebfrapFlow_Exception $e )
    {
      $view->displayError( $e->getMessage() );
    }


  }// end public function service_forgotPasswd */
  
  /**
   * @param LibRequestHttp $request
   * @param LibResponseHttp $response
   * @return void
   */
  public function service_logout( $request, $response )
  {

    $response = $this->getResponse();
    $flow     = $this->getFlowController();


    $user = $this->getUser();

    $user->logout();
    $response->addMessage
    (
      $response->i18n->l( 'User logged out', 'wbf.message' )
    );

    $flow->redirectToDefault( $this->tplEngine->isType( View::AJAX ) );

  }//end public function service_logout */

} // end class WebfrapAuth_Controller



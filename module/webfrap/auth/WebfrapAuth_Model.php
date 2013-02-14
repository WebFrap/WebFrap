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
class WebfrapAuth_Model extends Model
{
  
  /**
   * @param string $email
   * @return User
   */
  public function getUserByEmail($email )
  {
    
    $orm   = $this->getOrm();

    return $orm->execute( 'WbfsysRoleUser', 'WebfrapAuth::userByEmail', $email  );
    
  }//end public function getUserByEmail */
  
  /**
   * @param string $name
   * @return User
   */
  public function getUserByName($name )
  {
    
    $orm   = $this->getOrm();

    return $orm->get( 'WbfsysRoleUser', "upper(name) = upper('{$name}')" );
    
  }//end public function getUserByName */

  /**
   * Einen Token generieren und die Mail an den Benutzer verschicken
   * 
   * @param WbfsysUser_Entity $user
   * 
   * @throws Constraint_Exception
   * @throws LibMessage_Exception
   */
  public function startResetProcess($user )
  {
    
    $orm = $this->getOrm();
    
    if ($user->reset_pwd_date )
    {
      $now = new DateTime();
      $now->sub( new DateInterval('P1D') );
      $old = DateTime::createFromFormat( 'Y-m-d H:i:s', $user->reset_pwd_date  );
      
      // nur eine Anfrage alle 24 Stunden erlauben
      // SPAM und Missbrauch etwas einschränken
      if ($old > $now )
        throw new Constraint_Exception
        ( 
          'Es wurde bereits eine Anfrage innerhalb der letzten 24 Stunden gestellt. Bitte ruf deine E-Mails ab.' 
        );
      
    }
    
    $user->reset_pwd_date = date( 'Y-m-d H:i:s' );
    $user->reset_pwd_key  = SEncrypt::uniqueToken();
    $orm->update($user );
    
    // verschicken der Nachricht
    $message = new WebfrapAuth_ForgotPasswd_Message();  
    $message->addReceiver( new LibMessage_Receiver_User($user ) );
    $message->setEntity($user );
    $message->setSender($this->getUserByName( 'system' ) );

    $message->setChannels( array( 'mail', 'message' ) );

    $msgProvider = $this->getMessage();
    $msgProvider->send($message );
    
    
  }//end public function startResetProcess */
  
  /**
   * @param User $user
   * @param boolean $usedSSO
   */
  public function protocolLogin($user, $usedSSO = false )
  {
    
    $orm     = $this->getOrm();
    $request = $this->getRequest();
    
    $browser = $request->getBrowser();
    $browserVersion = str_replace('.', '_', $request->getBrowserVersion()) ;
    $os = $request->getPlatform();
    $mainLang = $request->getMainClientLanguage();
    $clientIp = $request->getClientIp();
    
    $browserNode = $orm->getWhere('WbfsysBrowser', "UPPER(access_key) = UPPER('{$browser}') " );
    if (!$browserNode )
      $browserNode = $orm->getWhere('WbfsysBrowser', "UPPER(access_key) = UPPER('unkown') " );
      
    if ( 'unknown' == $browser )
    {
      $browserVersionNode = $orm->getWhere('WbfsysBrowserVersion', "UPPER(access_key) = UPPER('unknown_0') " );
    }
    elseif
    ( 
      !$browserVersionNode = $orm->getWhere('WbfsysBrowserVersion', "UPPER(access_key) = UPPER('{$browser}_{$browserVersion}') " ) 
    )
    {
      $browserVersionNode = $orm->getWhere('WbfsysBrowserVersion', "UPPER(access_key) = UPPER('{$browser}_0') " );
    }
    
    $osNode = $orm->getWhere('WbfsysOs', "UPPER(access_key) = UPPER('{$os}') " );
    if (!$osNode )
      $osNode = $orm->getWhere('WbfsysOs', "UPPER(access_key) = UPPER('unkown') " );

    $langNode = $orm->getWhere('WbfsysLanguage', "UPPER(access_key) = UPPER('{$mainLang}') " );
    if (!$langNode )
      $langNode = $orm->getWhere('WbfsysLanguage', "UPPER(access_key) = UPPER('undefined') " );
    
    $pNode = $orm->newEntity( 'WbfsysProtocolUsage' );
    $pNode->id_browser = $browserNode;
    $pNode->id_browser_version = $browserVersionNode;
    $pNode->id_os = $osNode;
    $pNode->id_main_language = $langNode;
    $pNode->ip_address = $clientIp;
    $pNode->flag_sso   = $usedSSO;
    
    $orm->send($pNode );
    
  }//end public function protocolLogin */
  
  
/*//////////////////////////////////////////////////////////////////////////////
// login / logout / change pwd
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string $username
   */
  public function loadUserData($username )
  {

    // mal was prüfen
    $orm       = $this->getOrm();
    $response  = $this->getResponse();
    
    if ( is_object($username) )
    {
      $authRole        = $username;
    } else {
      try
      {
        if (!$authRole = $orm->get( 'WbfsysRoleUser', "UPPER(name) = UPPER('{$username}')" ) )
        {
          $response->addError( 'User '.$username.' not exists' );
          return false;
        }
      }
      catch( LibDb_Exception $exc )
      {
        $response->addError( 'Error in the query to fetch the data for user: '.$username );
        return false;
      }
    }
    
    $this->entity    = $authRole;
    $this->userData  = $authRole->getData();
    $this->userId    = $authRole->getId();
    $this->userLevel = (int)$authRole->getData('level');

    if ($authRole->profile )
    {
      $this->profileName = $authRole->profile;
      $this->profiles[$authRole->profile] = SParserString::subToName($this->profileName);
    }

    if ( WebFrap::classLoadable( 'CorePerson_Entity' ) )
    {
      if ($person = $orm->get( 'CorePerson', $authRole->id_person ) )
        $this->userData = array_merge($this->userData, $person->getData() );
    }
    
    if ( isset($this->userData['lastname'] )  && $this->userData['lastname'] )
    {
      $this->fullName = $this->userData['lastname'];
    } else {
      $this->fullName = null;
    }

    if ( isset($this->userData['firstname'] ) && $this->userData['firstname'] )
    {
      if ($this->fullName )
        $this->fullName .= ', '.$this->userData['firstname'];
      else
        $this->fullName = $this->userData['firstname'];
    }

    return true;

  }//end public function loadUserData */

  /**
   * @param User $user
   */
  public function loadGroupRoles($user )
  {

    $db = $this->getDb();

    /// TODO add this in an external datasource
    // Load User Rights
    $sql = 'SELECT
        wbfsys_role_group.rowid,
        wbfsys_role_group.m_parent,
        wbfsys_role_group.name ,
        wbfsys_role_group.access_key ,
        wbfsys_role_group.level
      from
        wbfsys_role_group
      join
        wbfsys_group_users on wbfsys_role_group.rowid = wbfsys_group_users.id_group
      where
        wbfsys_group_users.id_user = '.$user->getId().'
          and wbfsys_group_users.id_area is null
          and wbfsys_group_users.vid is null
        ';


    $roles = $db->select($sql );

    foreach($roles as $role )
    {

      $user->groupRoles[$role['access_key']] = $role['rowid'];

      if ($role['level'] > $this->userLevel )
        $user->userLevel = $role['level'];


      // if we have a parent load him
      if ($role['m_parent'] )
        $this->loadGroupParents($user, $role['m_parent'] );

    }//end foreach */

  }//end public function loadGroupRoles */

  /**
   * load assigned profiles
   * @todo dringend in eigene query auslagern
   */
  public function loadUserProfiles()
  {

    $db = $this->getDb();

    /// TODO add this in an external datasource
    // Load User Rights
    $sql = 'SELECT
        wbfsys_profile.name,
        wbfsys_profile.access_key
      FROM
        wbfsys_profile
      JOIN
        wbfsys_user_profiles 
        ON wbfsys_profile.rowid = wbfsys_user_profiles.id_profile
      WHERE
        wbfsys_user_profiles.id_user = '.$this->userId.'
      ORDER BY
        wbfsys_profile.name';

    $roles = $db->select($sql );

    foreach($roles as $role )
    {
      $kPey = trim($role['access_key'] );
      
      if (trim($role['name']) == '' )
      {
        $this->profiles[$kPey] = SParserString::subToName($role['access_key']);
      } else {
        $this->profiles[$kPey] = $role['name'];
      }
      
      
    }//end foreach */

    // wenn keine gruppen vorhanden sind müssen auch keine gruppenprofile
    // geladen werden
    if (!count($this->groupRoles) )
      return;

    /// TODO add this in an external datasource
    // Load User Rights
    $sql = 'SELECT
        wbfsys_profile.name ,
        wbfsys_profile.access_key
      from
        wbfsys_profile
      join
        wbfsys_group_profiles on wbfsys_profile.rowid = wbfsys_group_profiles.id_profile
      where
        wbfsys_group_profiles.id_group IN('.implode(', ',$this->groupRoles).') ';

    $roles = $db->select($sql );

    foreach($roles as $role )
    {
      $kPey = trim($role['access_key'] );
      $this->profiles[$kPey] = SParserString::subToCamelCase($role['access_key']);
    }//end foreach */


  }//end public function loadUserProfiles */

  /**
   *
   * @param int $idParent
   * @todo dringend in eigene query auslagern
   * @return void
   */
  public function loadGroupParents($user, $idParent )
  {

    $db = $this->getDb();

    // Load User Rights
    $sql = 'SELECT
        rowid,
        name ,
        profile,
        m_parent,
        access_key,
        level
      from
        wbfsys_role_group
      where
        rowid = '.$idParent;

    if (!$role = $db->select($sql , true, true  ) )
      return;

    $user->groupRoles[$role['access_key']] = $role['rowid'];

    if ($role['level'] > $this->userLevel )
    {
      $user->userLevel = $role['level'];
    }

    if ($role['profile'] )
    {
      $kPey = trim($role['profile']);
      $user->profiles[$kPey] = SParserString::subToCamelCase($kPey);
    }

    // if we have a parent load him
    if ($role['m_parent'] )
    {
      $this->loadGroupParents($user, $role['m_parent']);
    }

  }//end public function loadGroupParents */

} // end class WebfrapAuth_Model



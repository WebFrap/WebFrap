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
 * Check ob der Request über die richtige URL kam, ansonten redirect
 *
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage Mvc
 */
class MvcRouterAdressCheck
{

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   * @param LibConfPhp $conf
   * @return void
   */
  public static function checkRedirect($request, $conf )
  {
    
    $gwDomain = $conf->getStatus( 'gateway.domain' );
    $gwSSL    = $conf->getStatus( 'gateway.ssl' );
    
    
    $redirect    = false;
    $enforeceSSL = false;
    $denySSL     = false;
    
    if ( 2 === (int)$gwSSL ){
      $enforeceSSL = true;
    }elseif ( 1 === (int)$gwSSL ){
      $denySSL = true;
    }
    
    // nichts zu tun
    if (!$gwDomain && !$enforeceSSL && !$denySSL )
      return false;
      
    if ($enforeceSSL )
    {
      if (!$request->isSecure() )
        $redirect = true;
    }
    elseif ($denySSL )
    {
      if ($request->isSecure() )
        $redirect = true;
    }
      
    if (!$redirect )
    {
      $actualDomain = $request->getServerName();
      
      if ( strtolower($actualDomain) != strtolower($enforeceSSL) )
        $redirect = true;
    }
    
    if ( strtolower($actualDomain) != strtolower($enforeceSSL) )
    {
      $redirectUrl = $request->createRedirectAddress($gwDomain, $gwSSL  );
      
      header( "HTTP/1.1 301 Moved Permanently" );
      header( "Location:{$redirectUrl}" );
      return true;
    }
    
    return false;
    
  }//end public static function checkRedirect */


}//end class MvcRouterAdressCheck


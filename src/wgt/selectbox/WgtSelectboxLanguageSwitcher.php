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
class WgtSelectboxLanguageSwitcher
  extends WgtSelectboxHardcoded
{
/*//////////////////////////////////////////////////////////////////////////////
// attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   */
  public function load()
  {
    
    $db   = Webfrap::$env->getDb();
    $conf = Webfrap::$env->getConf();

    $sql = <<<SQL
select
  name,
  short
from
  wbfsys_language
where
  is_syslang = true;
SQL;
    
    $res = $db->select( $sql );

    $this->data =  array();

    foreach( $res as $lang )
    {
      $this->data[$lang['short']] = array( 'value' => ucfirst($lang['name']) );
    }

    $this->activ = $conf->getStatus('activ.language');

  }//end public function load()


} // end class WgtSelectboxLanguageSwitcher


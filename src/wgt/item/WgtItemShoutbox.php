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
 * @subpackage ModCms
 */
class WgtItemShoutbox
  extends WgtItemEntityAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   * Enter description here...
   *
   */
  protected function load()
  {



    $where = ' and com.m_deleted is null ';

    if( $this->multiLingual )
    {
      $where .= ' and com.id_lang = '.Controller::activLang();
    }

      if( $this->vidl )
    {
      $where .= ' com.vid_dataset = '.$this->vid;
    }

    $sql = 'SELECT com.comment , com.id_parent
      from core_comment com
      join core_entity en on com.id_entity = en.rowid
      where en.name = '.$this->table.' '.$where
       ;

     if( $data = $db->select( $sql ))
     {

     }

  }//end protected function load()

  /**
   * Enter description here...
   *
   * @return unknown
   */
  public function build()
  {

    return 'not yet implemented';

  }//end public function build()


} // end class WgtItemShoutbox



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
class WebfrapDocu_Page_Model extends Model
{

  /**
   * @param string $key
   * @return WebfrapDocu_Page_Data
   */
  public function getInfoPage($key)
  {

    $session = $this->getSession();
    $orm   = $this->getOrm();

    $lang = $session->getStatus('activ.language');

    if (!$lang)
      $lang = Conf::status('activ.language');

    $page  = $orm->get
    (
      'WbfsysDocuTree',
      "access_key='{$key}' and (id_lang IN("
        ." select rowid from wbfsys_language where UPPER(access_key) = UPPER('{$lang}') "
        .") or id_lang is null) "
    );

    if (!$page)
      return null;

    $subPages = $orm->getListWhere('WbfsysDocuTree', 'm_parent='.$page);

    $pageData = new WebfrapDocu_Page_Data($page, $subPages);

    return $pageData;

  }//end public function getInfoPage */

}//end class WebfrapDocu_Menu_Model


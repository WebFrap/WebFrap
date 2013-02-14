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
class WebfrapText_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibTemplate $view
   * @param array $keys
   * @return void
   */
  public function apppendTexts( $view , $keys )
  {

    $cond = "'".implode( $keys , "','" )."'";

    $sql =<<<CODE
SELECT access_key as k, content as c from wbfsys_text where access_key in({$cond});

CODE;

    $res = $this->getDb()->select($sql);

    $texts = array();
    foreach( $res as $text )
    {
      $texts['text_'.strtolower($text['k'])] = $text['c'];
    }

    $view->addVar($texts);

  }//end public function apppendTexts */


}//end class WebfrapText_Model


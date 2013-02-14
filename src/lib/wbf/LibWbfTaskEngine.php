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
 * @subpackage Base
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class LibWbfTaskEngine
{

  /**
   *
   * @var LibWbfTaskEngine
   */
  private static $instance = null;

  /**
   *
   */
  public static function getEngine( )
  {

    if (!self::$instance)
      self::$instance = new LibWbfTaskEngine();

    return self::$instance;

  }//end public static function getEngine */


/*//////////////////////////////////////////////////////////////////////////////
// constructor
//////////////////////////////////////////////////////////////////////////////*/



/*//////////////////////////////////////////////////////////////////////////////
// public function
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param $title
   */
  public function newEntityTask($title , $entiy  )
  {

  }//end public function newEntityTask */


}//end class LibWbfTask


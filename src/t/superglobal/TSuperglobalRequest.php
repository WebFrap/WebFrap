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
 *
 */
class TSuperglobalRequest
  extends TSuperglobalAbstract
{

////////////////////////////////////////////////////////////////////////////////
// Magic Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function construct( )
  {
    $this->request = Request::getInstance();
    $this->pool = $this->request->getUrlVar();

  }//end public function construct( )


////////////////////////////////////////////////////////////////////////////////
// Logic
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @see  TSuperglobalAbstract::get
   *
   */
  public function get($key = null , $validator = null,  $subkey = null)
  {
    return $this->request->getUrlVar($key, $validator);
  }

  /**
   * @see  TSuperglobalAbstract::add
   */
  public function add($key  , $value  = null , $subkey  = null)
  {
    return $this->request->addGet($key  , $value);
  }

  /**
   * @see  TSuperglobalAbstract::exists
   */
  public function exists($key, $subkey = null)
  {
    return $this->request->getExists($key);
  }


}//end class TSuperglobalRequest


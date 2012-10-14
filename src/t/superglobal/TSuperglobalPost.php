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
class TSuperglobalPost
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

    $this->request = Request::getActive();
    $this->pool = $this->request->data();

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
    return $this->request->data($key, $validator,$subkey);
  }

  /**
   * @see  TSuperglobalAbstract::add
   */
  public function add($key  , $value  = null , $subkey  = null)
  {
  }

  /**
   * @see  TSuperglobalAbstract::exists
   */
  public function exists($key, $subkey = null)
  {
    return $this->request->dataExists($key,$subkey);
  }

}//end class TSuperglobalPost


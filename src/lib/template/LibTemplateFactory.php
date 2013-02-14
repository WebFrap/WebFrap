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
class LibTemplateFactory
{

  /**
   *
   */
  public function item( $className, $key )
  {

    if (!WebFrap::loadable($className) )
    {
      throw new WgtItemNotFound_Exception( 'Class '.$className.' was not found' );
    }
    else
    {

      $object        = new $className($key);
      $object->view  = $this; // add back reference to the owning view
      $object->i18n  = $this->i18n;

      $this->object->content[$key] = $object;

      if(DEBUG)
        Debug::console('Created Item: '.$className .' key: '.$key );

      return $object;
    }


  }

} // end class LibTemplateAjax */


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
class WgtStyle
{

/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Die Breite des Elements
   */
  protected $styles = array();

/*//////////////////////////////////////////////////////////////////////////////
// Magic Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Implementieren eines Getters für die StyleElemente
   *
   * @return WgtStyleNode
   */
  public function __get($type )
  {

    if (!isset($this->styles[$type] ))
    {
      $styleClass = 'WgtStyle'.ucfirst($type);
      $this->styles[$type] = new $styleClass();
    }

    return $this->styles[$type];

  }//end public function __get */

  /**
   *
   */
  public function __clone()
  {

    $oldStyles = $this->styles;

    foreach($oldStyles as $key => $object )
    {
        $this->styles[$key] = clone $object;
    }

  }//end public function __clone */

  /**
   *
   */
  public function __toString()
  {
    return $this->build();
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Logic
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @return string
   */
  public function build()
  {

    $style = '';

    foreach($this->styles as $styleNode  )
    {
      $style .= $styleNode->build();
    }

    return $style;

  }//end public function build */

} // end class WgtStyle



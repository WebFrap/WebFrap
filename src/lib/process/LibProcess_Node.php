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
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author Dominik Donsch <dominik.bonsch@webfrap.net>
 *
 */
class LibProcess_Node
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Key des Projektknotens
   * @var string
   */
  public $key = null;

  /**
   * Key der aktuellen Projekt Phase
   * @var string
   */
  public $phaseKey = null;

  /**
   * @var string
   */
  public $label = null;

  /**
   * @var string
   */
  public $order = null;

  /**
   * @var string
   */
  public $icon  = null;

  /**
   * @var string
   */
  public $color = null;

  /**
   * @var string
   */
  public $description = null;

  /**
   * Complete node data
   * @var array
   */
  public $data = array();

////////////////////////////////////////////////////////////////////////////////
// Standard Konstruktor
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @param array $nodeData
   */
  public function __construct( array $nodeData, $key = null )
  {

    $this->data = $nodeData;
    $this->key = $key;

    $this->label = $nodeData['label'];

    $this->order = $nodeData['order'];

    $this->icon   = isset($nodeData['icon'])
      ? $nodeData['icon']
      : 'process/go_on.png';

    $this->color  = isset($nodeData['color'])
      ? $nodeData['color']
      : 'default';

    $this->description  = isset($nodeData['description'])
      ? $nodeData['description']
      : '';

    $this->phaseKey  = isset($nodeData['phase'])
      ? $nodeData['phase']
      : null;

  }//end public function __construct */

}//end class LibProcess_Node

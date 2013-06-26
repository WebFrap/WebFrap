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
 * @subpackage wgt/graph
 */
abstract class WgtGraph
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * die HTML ID des Graphen
   * @var string
   */
  public $graphId = null;

  /**
   * Nur beim Serverseitigen rendern nötig
   * @var unknown
   */
  protected $graph = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  public function setGraphId($graphId)
  {
    $this->graphId = $graphId;
  }

  public function create(){

  }

  public function publish()
  {

  }

  /**
   * Die ID des formulars welches zum updaten der Graphen benötigt wird
   * @param string $formId
   *
   * @return string
   */
  public function rennderPanelConfig( $formId )
  {

  }//end public function rennderPanelConfig */

  /**
   * @param array $data
   * @param string $active
   * @return string
   */
  protected function renderSelectOptions( $data, $active )
  {

    $html = '';

    foreach( $data as $value => $label ){

      $checked = '';
      if( $active === $value ){
        $checked = ' checked="checked" ';
      }

      $html .= '<option value="'.$value.'" '.$checked.' >'.$label.'</option>';

    }

    return $html;


  }//end protected function renderSelectOptions */

} // end abstract class WgtGraph


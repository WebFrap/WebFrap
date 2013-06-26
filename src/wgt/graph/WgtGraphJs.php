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
class WgtGraphJs extends WgtGraph
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/


  /**
   * Der Render Type des Graphen
   * @var string
   */
  public $graphType = null;

  /**
   * Die Daten die gerendert werden sollen
   * @var string
   */
  protected $data = null;

  /**
   * In welcher Box soll der Graph angezeigt werden
   * @var string
   */
  public $boxId = null;

  /**
   * Die id des Updateforms
   * @var string
   */
  public $formId = null;

  /**
   * Wird benötigt wenn der Graph referenzen in relation zu einem Datensatz
   * visualisiert
   * @var int
   */
  public $refId = null;

////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $formId
   * @param string $boxId
   * @param array $data
   */
  public function __construct( $formId, $boxId = null, $data = null)
  {
    $this->formId = $formId;
    $this->boxId = $boxId;
    $this->data = $data;
  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////


  /**
   * @param string $data
   */
  public function setData($data)
  {
    $this->data = $data;
  }//end public function setData */


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
  protected function renderSelectOptions($data, $active = null)
  {

    $html = '';

    foreach( $data as $value => $label ){

      $checked = '';
      if( $active === $value ){
        $checked = ' checked="checked" ';
      }

      if (is_array($label))
        $html .= '<option value="'.$value.'" '.$checked.' >'.$label[0].'</option>';
      else
        $html .= '<option value="'.$value.'" '.$checked.' >'.$label.'</option>';


    }

    return $html;


  }//end protected function renderSelectOptions */

} // end abstract class WgtGraph


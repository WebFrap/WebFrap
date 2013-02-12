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
 * Ausgeführte Aktionen protokollieren
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibProtocol_UserAction
{

  private $orm = null;

  /** Default constructor
   *  the conf and open a file
   *
   */
  public function __construct( $orm )
  {

    $this->orm = $orm;

  } // end public function __construct */

  /**
   * @param string $message
   * @param string $area
   * @param Entity $entity
   */
  public function write( $message, $area = null, $entity = null )
  {

    $vid      = null;
    $idEntity = null;

    $orm->insert(
      'WbfsysActionLog',
      array(
        'content' => $message,
        'vid' => $vid,
        'id_vid_entity' => $idEntity,
      )
    );

  } // end public function __destruct */

} // end LibProtocol_UserAction

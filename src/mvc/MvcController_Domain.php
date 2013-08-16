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
 * @subpackage Mvc
 */
abstract class MvcController_Domain  extends MvcController
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * The actual domain node
   * @var DomainNode
   */
  public $domainNode = null;

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Get the node with the domai information
   * if missing we can asume the request was invlid
   *
   * @param LibRequestHttp $request
   * @throws InvalidRequest_Exception
   * @return DomainNode
   */
  protected function getDomainNode($request, $isData = false)
  {

    if ($isData)
      $domainKey = $request->data('dkey', Validator::CKEY);
    else
      $domainKey = $request->param('dkey', Validator::CKEY);

    if (!$domainKey) {
      throw new InvalidRequest_Exception(
        'Missing Domain Parameter',
        Response::BAD_REQUEST
      );
    }

    $domainNode = DomainNode::getNode($domainKey);

    if (!$domainNode) {
      throw new InvalidRequest_Exception(
        'The requestes Metadate not exists',
        Response::NOT_FOUND
      );
    }

    $this->domainNode = $domainNode;

    return $domainNode;

  }//end protected function getDomainNode */

  /**
   * Load a DomainNode Model
   *
   * @param string $domainNode
   * @param string $modelKey
   * @param string $key
   *
   * @return MvcModel_Domain
   * @throws Mvc_Exception is thrown when the requested model not exosts
   */
  public function loadDomainModel($domainNode, $modelKey, $key = null)
  {

    if (is_array($key))
      $injectKeys = $key;

    if (!$key || is_array($key))
      $key = $modelKey;

    $modelName = $modelKey.'_Model';

    if (!isset($this->models[$key]  )) {
      if (Webfrap::classExists($modelName)) {
        $model = new $modelName($domainNode, $this);
        $this->models[$key] = $model;
      } else {
        throw new Mvc_Exception
        (
          'Internal Error',
          'Failed to load Submodul: '.$modelName
        );
      }
    }

    return $this->models[$key];

  }//end public function loadDomainModel */

} // end abstract class MvcController_Domain


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
 * @subpackage Maintenance
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapSettings_Search_Save_Request extends Context
{
/*//////////////////////////////////////////////////////////////////////////////
// Aspects
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * VID of a dataset if available
   * @var int
   */
  public $vid = null;

  /**
   * Type of the settings
   * @var int
   */
  public $type = null;

  /**
   * @var TFlag
   */
  public $filter = null;

  /**
   * Search Fields
   * @var array
   */
  public $searchFields = array();

  /**
   * Search Fields
   * @var array
  */
  public $searchFieldsStack = array();

  /**
   * @var ValidSearchBuilder
   */
  public $extSearchValidator = null;
  
  /**
   * Extended Search filter
   * @var array
  */
  public $extSearch = array();

/*//////////////////////////////////////////////////////////////////////////////
// Methoden
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   */
  public function __construct($request, $extSearchValidator = null)
  {

    if ($request->paramExists('as')) {
      if ($extSearchValidator)
        $this->extSearchValidator = $extSearchValidator;
      else
        $this->extSearchValidator = new ValidSearchBuilder();
    }

    $extSearchFields = $request->param('as');
    
    if ($extSearchFields)
      $this->interpretRequest($request);

  } // end public function __construct */


  /**
   * @param LibRequestHttp $request
   */
  public function interpretRequest($request)
  {


    $this->filter = new TFlag();

    $filters = $request->param('filter', Validator::BOOLEAN);

    if ($filters) {
      foreach ($filters as $key => $value) {
        $this->filter->$key = $value;
      }
    }

    $this->vid = $request->param( 'vid', Validator::EID );
    $this->type = $request->param( 'type', Validator::INT );

    $extSearchFields = $request->param('as');

    if (!$this->searchFieldsStack) {
      foreach ($this->searchFields as $searchFields) {
        foreach ($searchFields as $sKey => $sData) {
          $this->searchFieldsStack[$sKey] = $sData;
        }
      }
    }

    foreach ($extSearchFields as $fKey => $extField) {

      if (!isset($this->searchFieldsStack[$extField['field']])) {
        // field not exists
        continue;
      }

      $validField = $this->extSearchValidator->validate($extField, $this->searchFieldsStack[$extField['field']]);

      if ($validField) {

        if (isset($extField['parent'])) {

          if (!isset($this->extSearch[$extField['parent']]->sub)  )
            $this->extSearch[$extField['parent']]->sub = array();

          $this->extSearch[$extField['parent']]->sub[] = (object)$validField;

        } else {

          $this->extSearch[$fKey] = (object)$validField;

        }
        
      } else {
        
        Debug::console($extField['field'].' was invalid ');
      }

    }//end foreach


  }//end public function interpretRequest */

}//end class WebfrapSettings_Search_Save_Request */


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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Multi_Model extends Model
{
/*//////////////////////////////////////////////////////////////////////////////
// methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * multi save action, with this action you can save multiple entries
   * for this model in the database
   * save means create if not exist and update if allready exists
   *
   * @param TFlag $params named parameters
   * @return void
   */
  public function update($params   )
  {

    $orm  = $this->getOrm();
    $db   = $this->getDb();
    $view = $this->getView();

    try
    {
      // start a transaction in the database
      $db->begin();

      // for insert there has to be a list of values that have to be saved
      if (!$listWbfsysSecurityAccess = $this->getRegisterd( 'listRefWbfsysSecurityAccess' ) )
      {
        throw new WebfrapSys_Exception
        (
          'Internal Error',
          'listWbfsysSecurityAccess was not registered'
        );
      }

      $entityTexts = array();

      foreach($listWbfsysSecurityAccess as $entityWbfsysSecurityAccess )
      {
        if (!$orm->update($entityWbfsysSecurityAccess ) )
        {
          $entityText = $entityWbfsysSecurityAccess->text();
          $this->getResponse()->addError
          (
            $view->i18n->l
            (
              'Failed to save Area: '.$entityText,
              'wbf.message',
              array($entityText)
            )
          );
        }
        else
        {
          $entityTexts[] = $entityWbfsysSecurityAccess->text();
        }
      }

      $textSaved = implode($entityTexts,', ');
      $this->getResponse()->addMessage
      (
        $view->i18n->l
        (
          'Successfully saved Area: '.$textSaved,
          'wbf.message',
          array($textSaved )
        )
      );

      // everything ok
      $db->commit();

    }
    catch( LibDb_Exception $e )
    {
      $this->getResponse()->addError($e->getMessage());
      $db->rollback();
    }
    catch( WebfrapSys_Exception $e )
    {
      $this->getResponse()->addError($e->getMessage());
    }

    // check if there were any errors, if not fine
    return !$this->getResponse()->hasErrors();

  }//end public function update */


  /**
   * fetch the data from the http request object an put it
   * as list in the registry
   *
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData($params  )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    try
    {

      // if the validation fails report
      $listWbfsysSecurityAccess = $httpRequest->validateMultiUpdate
      (
        'WbfsysSecurityAccess',
        'security_access',
        $params->fieldsWbfsysSecurityArea
      );

      $this->register('listRefWbfsysSecurityAccess',$listWbfsysSecurityAccess);
      return true;

    }
    catch( InvalidInput_Exception $e )
    {
      return false;
    }

  }//end public function fetchUpdateData */

} // end class AclMgmt_Multi_Model */


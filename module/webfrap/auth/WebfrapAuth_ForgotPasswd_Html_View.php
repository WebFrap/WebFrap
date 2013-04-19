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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapAuth_ForgotPasswd_Html_View extends LibTemplateHtmlView
{

  public function init()
  {
    $this->setHtmlHead('public');
    $this->setIndex('public/plain');
  }

  /**
   *
   */
  public function displayError($errorMessage)
  {
    $this->addVar('error', $errorMessage);
    $this->setTemplate('webfrap/auth/form_forgot_pwd', true  );

  }//end public function displayError */

  /**
   * @param string $message
   */
  public function displaySuccess($message)
  {

    $this->addVar('message', $message);
    $this->setTemplate('webfrap/auth/success', true  );

  }//end public function displaySucess */

} // end class WebfrapAuth_ForgotPasswd_Html_View


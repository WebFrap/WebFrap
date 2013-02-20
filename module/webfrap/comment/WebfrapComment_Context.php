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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class WebfrapComment_Context extends Context
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// display methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibRequestHttp $request
   */
  public function __construct($request = null )
  {

    if (!$request )
      return null;

    if ($element = $request->param('element', Validator::CKEY))
      $this->element = $element;

    if ($refMask = $request->param('ref_mask', Validator::CKEY))
      $this->refMask = $refMask;

    if ($refField = $request->param('ref_field', Validator::CKEY))
      $this->refField = $refField;

    if ($refId = $request->param('ref_id', Validator::CKEY))
      $this->refId = $refId;

  }// end public function __construct */

  /**
   * @return string
   */
  public function toUrlExt()
  {

    if ($this->urlExt )
      return $this->urlExt;

    if ($this->element )
      $this->urlExt .= '&amp;element='.$this->element;

    if ($this->refMask )
      $this->urlExt .= '&amp;ref_mask='.$this->refMask;

    if ($this->refField )
      $this->urlExt .= '&amp;ref_field='.$this->refField;

    if ($this->refId )
      $this->urlExt .= '&amp;ref_id='.$this->refId;

    return $this->urlExt;

  }//end public function toUrlExt */

  /**
   * @return string
   */
  public function toActionExt()
  {

    if ($this->actionExt )
      return $this->actionExt;

    if ($this->element )
      $this->actionExt .= '&element='.$this->element;

    if ($this->refMask )
      $this->actionExt .= '&ref_mask='.$this->refMask;

    if ($this->refField )
      $this->actionExt .= '&ref_field='.$this->refField;

    if ($this->refId )
      $this->actionExt .= '&ref_id='.$this->refId;

    return $this->actionExt;

  }//end public function toActionExt */

} // end class WebfrapComment_Context */


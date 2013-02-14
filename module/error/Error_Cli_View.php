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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class Error_Cli_View extends LibTemplateCli
{

  public function displayException( $exception )
  {

    $out = $this->getResponse();

    $out->writeln('Sorry an internal Error occured');
    $out->writeln('');

    $out->writeln($exception->getMessage());
    $out->writeln((string)$exception);

  }

  public function displayEnduserError( $exception )
  {

    $out = $this->getResponse();

    $out->writeln('Sorry an internal Error occured');
    $out->writeln('');

    $out->writeln($exception->getMessage());
    $out->writeln((string)$exception);

  }

} // end class ImportIspcats_Subwindow


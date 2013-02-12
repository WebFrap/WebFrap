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
 * Class to create simple protocols
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class LibProtocolReport
  extends LibProtocolFile
{

  protected $numCols = null;

  /**
   * @return string
   */
  public function open()
  {

    $html = <<<HTML
<html>
  <head>
    <title>Report</title>
  </head>
  <body>
    <table>
HTML;

    $this->write( $html );

  }//end public function open */

  /**
   * @return string
   */
  public function close()
  {

    $html = <<<HTML
      </tbody>
    </table>
  </body>
</html>
HTML;

    $this->write( $html );

  }//end public function close */

  /**
   * @param array $cols
   */
  public function head( array $cols )
  {

    $this->numCols = count( $cols );

    $cHtml = "          <th>".implode( "</th>".NL."          <th>", $cols )."</th>";

    $html = <<<HTML
      <thead>
        <tr>
{$cHtml}
        </tr>
      </thead>
      <tbody>
HTML;

    $this->write( $html );

  }//end public function head */

  /**
   * @param string $title
   */
  public function paragraph( $title )
  {

    $html = <<<HTML
      </tbody>
      <thead>
        <tr>
          <th colspan="{$this->numCols}" ><h2>{$title}</h2></th>
        </tr>
      </thead>
      <tbody>
HTML;

    $this->write( $html );

  }//end public function paragraph */

  /**
   * @param array $cols
   */
  public function entry( array $cols )
  {

    $cHtml = "          <td>".implode( "</td>".NL."          <td>", $cols )."</td>";

    $html = <<<HTML
      <tr>
{$cHtml}
      </tr>

HTML;

    $this->write( $html );

  }//end public function entry */

} // end LibProtocolReport

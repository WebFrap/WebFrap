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
 * The base exception for all webfrap exceptions, to be able to catch all webfrap
 * exceptions
 * @package WebFrap
 * @subpackage tech_core
 *
 */
class Webfrap_Exception extends Exception
{

  /**
   *
   * @var string
   */
  protected $errorKey     = Response::INTERNAL_ERROR; // unspecified error

  /**
   * @return int
   */
  public function getErrorKey()
  {
    return $this->errorKey;
  }//end public function getErrorKey */

  /**
   * @todo check if we are in a http or a cli context
   * @return string dump the backtrace in a better readable format
   */
  public function dump()
  {

    $traces = $this->getTrace();

    $table = '<table>';
    $table .= <<<CODE
<thead>
  <tr>
    <th>Pos</th>
    <th>File</th>
    <th>Line</th>
    <th>Called</th>
    <th>Args</th>
  </tr>
</thead>
<tbody>
CODE;

    foreach ($traces as $key => $value) {

      /*
        'file' => string '/var/www/WorkspaceWebFrap/WebFrap/src/lib/LibTemplate.php' (length=74)
        'line' => int 1005
        'function' => string 'include' (length=7)
       */

      $file = isset($value['file'])?$value['file']:'???';
      $line = isset($value['line'])?$value['line']:'???';

      $table .= '<tr><td>'.$key.'</td>';
      $table .= '<td>'.$file.'</td>';
      $table .= '<td>'.$line.'</td>';

      if (!isset($value['class']) ) {
        $table .= '<td>'.$value['function'].'</td>';
      } else {
        $table .= '<td>'.$value['class'].$value['type'].$value['function'].'</td>';
      }

      if (!isset($value['args']) ) {
        $table .= '<td></td>';
      } else {
        $table .= '<td>
        <table>
          <thead>
            <tr>
              <th>pos</th>
              <th>type</th>
              <th>value</th>
            </tr>
          </thead>
          <tbody>
              ';

        foreach ($value['args'] as $numArg => $argValue) {
          $type = gettype($argValue);

          $table .='<tr>';
          $table .='<td>'.$numArg.'</td>';
          $table .='<td>'.$type.'</td>';

          if ( is_scalar($argValue) ) {
            $table .='<td>'.$argValue.'</td>';
          } elseif ( is_array($argValue) ) {
            $table .='<td>size:'.count($argValue).'</td>';
          } elseif ( is_object($argValue) ) {
            $table .='<td>class: '.get_class($argValue).'</td>';
          } else {
            $table .='<td></td>';
          }

          $table .='</tr>';
        }

        $table .='</tbody></table>';
      }

    }

    $table .= '</tbody></table>';

    return $table;

  }//end public function dump */

  /**
   * @param string
   */
  public function __toString()
  {

    if ( DEBUG )
      return Debug::dumpToString($this );
    else
      return $this->message;

  }//end public function __toString */

}//end class Webfrap_Exception


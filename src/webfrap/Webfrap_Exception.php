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
   * Message für den Entwickler. Soll im Debug Modus ausgegeben werden
   * @var string
   */
  protected $debugMessage = 'Internal Error'; // unspecified error
    
  /**
   * Container der eine oder mehrere Fehlermeldungen enthält
   *
   * @var ErrorContainer
   */
  public $error = null;
    
  /**
   * Wert der als Dump ausgegeben werden soll
   *
   * @var mixed
   */
  public $toDump = null;
  
  /**
   * Wie schwerwiegend ist der Fehler?
   *
   * @var int
   */
  public $severity = null;
  
  /**
   * Soll ein Dialog geöffnet werden?
   *
   * @var int
   */
  public $dialog = null;
  
  /**
   *
   * @var string
   */
  protected $errorKey = Response::INTERNAL_ERROR; // unspecified error
  
/*//////////////////////////////////////////////////////////////////////////////
// Konstruktor
//////////////////////////////////////////////////////////////////////////////*/
  
  /**
   * Das Error handling interface
   * 
   * @param [error message, (opt)debug message, (opt)dump] || multi error: [[error message, (opt)debug message], (opt)dump]
   * @param int $errorKey
   * @param Base $env
   * @param string $dialog
   * @param int $severity am ende
   * Passt nicht zum alten interface, soll das neue darstellen
   * 
   */
  public function __construct(
    $message, 
    $debugMessage = 'Internal Error', 
    $errorKey = Response::INTERNAL_ERROR,
    $dialog = null,
    $severity = null
  ) {
  
    // wenn object alles eins nach oben, dann haben wir das neue interface
    if(is_object($errorKey)){
      $env = $errorKey;
    } else {
      $env = Webfrap::$env;
    }
    
    $request = $env->getRequest();
    $response = $env->getResponse();
    
    $this->serverity = $severity;
    $this->dialog = $dialog;
  
    if (is_array($message)) {
      
      if(ctype_digit($debugMessage)){
        $this->errorKey = $debugMessage;
      } else {
        $this->errorKey = Response::INTERNAL_ERROR;
      }
      
      // multi message exception
      if (is_array($message[0])) {
        
      } else { // nur eine fehlermeldung
        
        parent::__construct($message[0]);

        $this->debugMessage = isset($message[1])?$message[1]:$message[0];
        $this->toDump = isset($message[2])?$message[2]:null;
        Error::addException($message[0], $this);
        
      }
      
    } else if (is_object($message)) { 
  
      if (DEBUG && 'Internal Error' != $debugMessage)
        parent::__construct($debugMessage);
      else
        parent::__construct('Multiple Errors');
  
      $this->error = $message;
  
      $this->debugMessage = $debugMessage;
      $this->errorKey = $message->getId();
  
      if ('cli' == $request->type)
        $response->writeLn($debugMessage);
  
      Error::addException($debugMessage, $this);
      
    } else {
      
      if (DEBUG && 'Internal Error' != $debugMessage && !is_numeric($debugMessage))
        parent::__construct($debugMessage);
      else
        parent::__construct($message);
  
      $this->debugMessage = $debugMessage;
      $this->errorKey = $errorKey;
  
      if ('cli' == $request->type)
        $response->writeLn($message);
  
      Error::addException($message , $this);
    }
  
  }//end public function __construct */
  
  /**
   *
   * @return string
   */
  public function getDebugMessage()
  {
    return $this->debugMessage;
  
  }//end public function getDebugMessage */
  
  /**
   *
   * @return string
   */
  public function getErrorKey()
  {
    return $this->errorKey;
  
  }//end public function getErrorKey */
  

  /**
   * @return string
   */
  public function getDialog()
  {
    return $this->dialog;
  
  }//end public function getDialog */
  
  /**
   * @return string
   */
  public function getServerity()
  {
    return $this->dialog;
  
  }//end public function getServerity */
  
  /**
   * @param LibResponseHttp $response
   */
  public function publish($response)
  {
  
    if ($this->error) {
      $this->error->publish($response);
    } else {
      $response->addError($this->message);
    }
  
  }//end public function publish */

  /**
   * @todo check if we are in a http or a cli context
   * @return string dump the backtrace in a better readable format
   */
  public function dump()
  {

    $traces = $this->getTrace();

    $table = '<table><label>'.$this->message.'</label>';
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

      if (!isset($value['class'])) {
        $table .= '<td>'.$value['function'].'</td>';
      } else {
        $table .= '<td>'.$value['class'].$value['type'].$value['function'].'</td>';
      }

      if (!isset($value['args'])) {
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

          if (is_scalar($argValue)) {
            $table .='<td>'.$argValue.'</td>';
          } elseif (is_array($argValue)) {
            $table .='<td>size:'.count($argValue).'</td>';
          } elseif (is_object($argValue)) {
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

    if (DEBUG)
      return Debug::dumpToString($this);
    else
      return $this->message;

  }//end public function __toString */

}//end class Webfrap_Exception


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
 * @subpackage tech_core
 */
class LibTemplateService extends LibTemplate
{
/*//////////////////////////////////////////////////////////////////////////////
// Public Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @var string
   */
  public $type          = 'service';

  /**
   *
   * @var string
   */
  public $contentType   = 'text/xml';

  /**
   * Flag if this is compressed
   * @var boolean
   */
  public $compressed = false;

/*//////////////////////////////////////////////////////////////////////////////
// Getter and Setter
//////////////////////////////////////////////////////////////////////////////*/

/*//////////////////////////////////////////////////////////////////////////////
// Logic Code
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * bauen bzw generieren der System und der Fehlermeldungen
   *
   * @return string
   */
  protected function buildMessages()
  {

    $pool = Message::getActive();
    $response = $this->getResponse();

    $html = '';

    // Gibet Fehlermeldungen? Wenn ja dann Raus mit
    if ($errors = $pool->getErrors()) {

       foreach($errors as $key => $message)
         $response->sendHeader('x-error-'.$key, urlencode($message)  );

    }

    if ($warnings = $pool->getWarnings()) {

       foreach($warnings as $key => $message)
         $response->sendHeader('x-warning-'.$key, urlencode($message)  );

    }

    if ($messages = $pool->getMessages()) {

       foreach($messages as $key => $message)
         $response->sendHeader('x-notice-'.$key, urlencode($message)  );

    }

  } // end protected function buildMessages */

  /**
   * build the body
   * @return string
   *
   */
  public function buildBody()
  {

    if ($this->assembledBody)
      return $this->assembledBody;

    $this->buildMessages();

    if ($filename = $this->templatePath($this->template , 'content', true)) {

      $VAR       = $this->var;
      $ITEM      = $this->object;
      $ELEMENT   = $this->object;
      $AREA      = $this->area;
      $FUNC      = $this->funcs;
      $CONDITION = $this->condition;

      $I18N      = $this->i18n;
      $USER      = $this->user;

      if (Log::$levelVerbose)
        Log::verbose("Load Service Template: $filename ");

      ob_start();
      include $filename;
      $content = ob_get_contents();
      ob_end_clean();

    } else {
      Error::report('Service Template not exists: '.$this->template.' '. ($this->tplInCode?'local tpl':'global tpl'));

      ///TODO add some good error handler here
      if (Log::$levelDebug)
        $content = '<p class="wgt-box error">Wrong Service Template: '
          .$this->template.' ('.$filename.' '
          .($this->tplInCode?'local tpl':'global tpl').')  </p>'.Debug::backtrace(false);
      else
        $content = '<p class="wgt-box error">Wrong Service Template '.$this->template.' </p>';

    }

    $this->assembledBody .= $content;

    return $this->assembledBody;

  }// end public function buildBody */

  /**
   *
   * @return string
   */
  public function buildIndex()
  {

    if ($filename = Webfrap::templatePath($this->indexTemplate, 'index')) {

      if (Log::$levelVerbose)
        Log::verbose('Parsing index: '.$filename);

      $stop      = true; // block
      $VAR       = $this->var;
      $FUNC      = $this->funcs;
      $ITEM      = $this->object;
      $ELEMENT   = $this->object;
      $AREA      = $this->area;

      $MESSAGES  = '';
      $TEMPLATE  = $this->template;
      $FOOTER    = $this->footer;

      $I18N      = $this->i18n;
      $USER      = $this->user;
      $URL       = $this->url;

      ob_start();
      include $filename;

      $content = ob_get_contents();
      ob_end_clean();

    } else {
      Error::addError('Index Template not exists: '.$filename);

      if (Log::$levelDebug)
        $content = '<p class="wgt-box error">Wrong Index Template: '.$filename.' </p>';

      else
        $content = '<p class="wgt-box error">Wrong Index Template</p>';
    }

    $this->assembledBody .= $content;

    return $this->assembledBody;

  }//end public function buildIndex */

  /**
   * Ausgabe Komprimieren
   */
  public function compress()
  {

    $this->compressed = true;
    $this->output = gzencode($this->output);

  }//end public function compress */

  /**
   * ETag für den Content berechnen
   * @return string
   */
  public function getETag()
  {
    return md5($this->output);
  }//end public function getETag */

  /**
   * Länge des Contents berechnen
   * @return int
   */
  public function getLength()
  {

    if ($this->compressed)
      return strlen($this->output);
    else
      return mb_strlen($this->output);

  }//end public function getLength */

  /**
   * flush the page
   *
   * @return void
   */
  public function compile()
  {

    $this->buildPage();

    if ($this->keyCachePage) {
      $this->writeCachedPage($this->keyCachePage , $this->compiled);
    }

    $this->output = $this->compiled;

  }//end public function compile */

  /**
   * flush the page
   *
   * @return void
   */
  public function build()
  {

    $this->buildPage();

    return $this->compiled;

  }//end public function build */

  /**
   * @return void
   */
  public function publish()
  {

    View::$blockHeader = true;

    echo $this->output;
    flush();

  }//end public function publish */

  /**
   * Einfaches bauen der Seite ohne Caching oder sonstige Rücksicht auf
   * Verluste
   *
   * @return void
   */
  public function buildPage()
  {

    if (trim($this->compiled) != '')
      return;

    // Parsing Data
    try {
      $this->buildBody();
    } catch (Exception $e) {

      $content = ob_get_contents();
      ob_end_clean();

      $this->assembledBody = '<h2>'.$e->getMessage().'</h2><pre>'.$e.'</pre>';
    }

    $this->buildMessages();

    $this->compiled .= $this->assembledBody.NL;

  } // end public function buildPage */

} // end class LibTemplateService */


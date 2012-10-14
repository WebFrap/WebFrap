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
class WgtItemGallery
  extends WgtItemAbstract
{


  public function render()
  {
    
    
    $htmlEntries = '';
    
    foreach( $this->data as $entry )
    {
      $htmlEntries .= $this->renderEntry( $entry );
    }
    
    
    $html = <<<HTML
    <div id="{$this->id}" class="content" >
      <div id="controls" class="controls" ></div>
      <div class="slideshow-container" >
        <div id="loading" class="loader" ></div>
        <div id="slideshow" class="slideshow" ></div>
        <div id="caption" class="caption-container" ></div>
      </div>
      <div id="captionToggle">
        <a href="#toggleCaption" class="off" title="Show Caption">Show Caption</a>
      </div>
    </div>
    <div id="thumbs" class="navigation" >
      <ul class="thumbs">
{$htmlEntries}
      </ul>
    </div>

    <div class="wgt-clear" ></div>
  </div>
HTML;
    
  }

  /**
   * @param array $entry
   */
  public function renderEntry( $entry )
  {

    $src   = "?f=gallery_entry-{$entry['gallery_entry_rowid']}&amp;n=".base64_encode( $entry['gallery_entry_name'] );
    $saveTitle  = htmlentities( $entry['gallery_entry_title'] );
    $desc       = $entry['gallery_entry_description'];

    $html = <<<HTML
    <li>
      <a class="thumb" name="gallery_entry-{$entry['gallery_entry_rowid']}" href="thumb.php{$src}" title="{$saveTitle}" >
        <img src="{$src}" alt="{$saveTitle}" />
      </a>
      <div class="caption" >
        <div class="download" >
          <a href="image.php{$imageSrc}" >Download Original</a>
        </div>
        <div class="image-title" >{$saveTitle}</div>
        <div class="image-desc" >{$desc}</div>
      </div>
    </li>
HTML;

    return $html;
    
  }//end public function renderEntry */
  


} //end of WgtItemGallery



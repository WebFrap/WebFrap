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



if ( console === undefined ){
  // console log fix
  // sicher stellen, dass der IE keinen fehler bei console wirft
  var console = {
    log: function(){},
    debug: function(){},
    info: function(){},
    warn: function(){},
    error: function(){},
    time: function(){},
    timeEnd: function(){},
    trace: function(){},
    group: function(){},
    groupEnd: function(){},
    assert: function(){}
  };
}

/**
 * Configuration Class
 * @return
 */
function WgtConf(){
  
  
  this.windowTitle      = 'WebFrap';
  
  this.fn               = WgtConf.prototype;

  //this.DEBUG = <?php if( DEBUG ) echo 'true'; else echo 'false'; ?>;
  this.DEBUG = {
    WCM: {
      ACTION : false,
      UI : false,
      WIDGET : false
    },
    UI: false,
    REQUEST : true
  };
  
  this.WEB_ROOT         = '<?php echo WEB_ROOT; ?>';
  this.SERVER_ADDR      = '<?php echo SERVER_ADDR; ?>';
  this.WEB_WGT          = '<?php echo WEB_WGT; ?>';
  this.WEB_STYLE        = '<?php echo WEB_STYLE; ?>';
  this.WEB_ICONS        = '<?php echo WEB_ICONS; ?>icons/default/';
  this.WEB_THEME        = '<?php echo WEB_THEME; ?>themes/default/';
  
  this.WEB_GW           = '<?php echo WEB_GW; ?>';
  this.HTTPS            = '<?php echo ( isset($_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] )? 'true': 'false'; ?>';

  document.cookie = [
     'WEB_ROOT', '=',
     encodeURIComponent(this.WEB_ROOT),
     '; path=/',
     this.HTTPS ? '; secure' : ''
   ].join('');
  
  document.cookie = [
    'WEB_WGT', '=',
    encodeURIComponent(this.WEB_WGT),
    this.HTTPS ? '; secure' : ''
  ].join('');
 
  document.cookie = [
    'WEB_ICONS', '=',
    encodeURIComponent(this.WEB_ICONS),
    this.HTTPS ? '; secure' : ''
  ].join('');
 
  document.cookie = [
    'WEB_THEME', '=',
    encodeURIComponent(this.WEB_THEME),
    this.HTTPS ? '; secure' : ''
  ].join('');
 
  document.cookie = [
    'WEB_GW', '=',
    encodeURIComponent(this.WEB_GW),
    this.HTTPS ? '; secure' : ''
  ].join('');

  this.iconPath         = this.WEB_ICONS;
  this.imagePath        = this.WEB_THEME+'images/';
  
  var cpath = this.iconPath+'xsmall/control/';
  
  this.iconCallendar    = cpath+'calendar.png';
  this.iconClock        = cpath+'clock.png';
  this.iconSortDesc     = cpath+'sort_up.png';
  this.iconSortAsc      = cpath+'sort_down.png';
  this.iconSortNone     = cpath+'sort_none.png';
  this.iconRefresh      = cpath+'cancel.png';
  this.iconAdd          = cpath+'add.png';
  this.iconEdit         = cpath+'edit.png';
  this.iconShow         = cpath+'show.png';
  this.iconDelete       = cpath+'delete.png';
  this.iconSave         = cpath+'save.png';
  this.iconConnect      = cpath+'connect.png';
  
  this.iconOpened       = cpath+'opened.png';
  this.iconClosed       = cpath+'closed.png';
  
  this.formatTime       = 'h:i';
  this.formatTimeSec    = 'h:i:s';
  this.timeSep          = ':';
  this.formatDate       = 'dd.mm.yy';
  this.formatDateMonth  = 'mm.yy';
  this.dateSep          = '.';
  //this.formatDate       = 'yy-mm-dd';
  this.theme            = 'default';
  this.lang             = 'de';

  this.colorCodes = {
    'access':{
      '0':'#C85E60',
      '1':'#D6EBBE',
      '2':'#B6DB8C',
      '4':'#99CD5D',
      '8':'#7ABE2F',
      '16':'#CAE2FF',
      '32':'#9EC9FF',
      '64':'#77B4FF',
      '128':'#4096FF',
      '256':'#AE2CFF'
    },
    'system':{
      'controll':'#ffffff',
      'defbg':'#E0F0FC',
    }
  };
  
}


window.$C = new WgtConf();








/*@interface.header@*/


// Avoid `console` errors in browsers that lack a console.
// taken from html5boilerplate
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

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
  this.SERVER_ADDR      = '<?php echo WEB_URL; ?>';
  this.WEB_WGT          = '<?php echo WEB_WGT; ?>';
  this.WEB_STYLE        = '<?php echo WEB_STYLE; ?>';
  this.WEB_ICONS_ROOT   = '<?php echo WEB_ICONS; ?>icons/';
  this.WEB_THEME_ROOT   = '<?php echo WEB_THEME; ?>themes/';
  this.WEB_ICONS        = '<?php echo WEB_ICONS; ?>icons/default/';
  this.WEB_THEME        = '<?php echo WEB_THEME; ?>themes/default/';
  
  this.WEB_GW           = '<?php echo WEB_GW; ?>';
  this.HTTPS            = 'true';

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

  this.themeKey         = 'default';
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
  this.formatDate       = 'yy-mm-dd';
  this.formatDateMonth  = 'yy-mm';
  this.dateSep          = '-';
  this.theme            = 'default';
  this.lang             = 'en';

  this.urls = {
      'contact_user':'modal.php?c=Base.Message.formNewMessage',
      'display_docu':'modal.php?c=Base.Docu.show'
    };
  
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








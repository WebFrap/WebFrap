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
class WebfrapConf_Model
  extends Model
{
  
  /**
   * Format der Configurationsdatei
   * - settings:
   * -- conf_key
   * --- Type
   * --- Validator
   * --- Description	
   * --- Default value
   * --- is required
   * 
   * @param string das Format einer Configurationsdatei
   */
  public $jsonFormat = <<<FORMAT
  
{
  "settings": {
  
  	"sys.name" : { 
			"string", 
			"Text", 
			"Name of the basesystem WebFrap for free || Buiznodes for commercial projects", 
			"WebFrap",
		  "true"  
		},
  	"sys.version" : { 
  		"string",  
  		"Version", 
  		"Version string eg 1.0 or 1.0_RC", 
  		"",
  		"true" 
		},
  	"sys.revision" : { 
  		"int",  
  		"Int", 
  		"Revision counter", 
  		"0",
  		"false" 
		},
  	"sys.generator" : { 
  		"string",  
  		"Text", 
  		"Name of the engine to be displayed in Version requests", 
  		"WebFrap",
  		"true"  
		},
  	"sys.licence" : { 
  		"int",  
  		"Int", 
  		"The Licence for the basesystem", 
  		"Bsd",
  		"true"
		},
  	"sys.copyright" : { "string",  "Text", "Copyright informations", "WebFrap.net <contact@webfrap.net>"  },
  	"sys.contact" : { "string",  "Text", "Contact information to the system provider", "WebFrap.net <contact@webfrap.net>"  },

  	"gateway.name" : { "string",  "Text", "Name of the Gateway", "Webfrap"  },
  	"gateway.version" : { "string",  "Version", "Version string eg 1.0 or 1.0_RC", "" },
  	"gateway.revision" : { "int",  "Int", "Revision counter", ""  },
  	"gateway.api.version" : { "string",  "Version", "The API Version of the gateway", "" },
  	"gateway.licence" : { "int",  "Int", "The Licence for the Gateway / Setup", ""  },
  	"gateway.copyright" : { "string",  "Text", "Copyright for the Gateway", ""  },
  	"gateway.admin.name" : { "string",  "HumanName", "Name of the gateway administrative contact", ""  },
  	"gateway.admin.mail" : { "string",  "Email", "Email of the gateway administrative contact", ""  },
  	"gateway.mandants" : { "boolean",  "Boolean", "Gibt es mehrere Mandaten auf dem Server oder wird das System nur von einem Mandanten genutzt", "false"  },
  	
  	"gateway.display.title" : { "string",  "Text", "The default title to be displayed in the Web browser"  },
  	"gateway.display.caption" : { "string",  "Text", "The Caption / Name of the Tool"  },
  	
  	"server.timezone" : { "string",  "TimeZone", "The Timezone for the server location"  },
  	"server.country" : { "string",  "CountryKey1", "The location of the actual server"  },
  	"server.language" : { "string",  "LanguageKey1", "The lanuaged used on the server if not overwritten by the user." },
  	"server.encoding" : { "string",  "Chartset", "Encoding Chartset of the server, normally utf-8" },
  	"server.currency" : { "string",  "CurrencyKey1", "The default currency for money values on the server." },
  	"server.domain" : { "string",  "HttpDomain", "The Main Domain of the server" },
  	"server.https" : { "int",  "Requirement", "0:Forbitten,1:Optional,2:Required" },
  	"server.sso" : { "int",  "Requirement", "0:Forbitten,1:Optional,2:Required" },
  	"server.aliases" : { 
  		"[string]|boolean",
  		"HttpDomain|Boolean",
  		"List of allowed aliases for this Server. Allowed aliases will not trigger a redirect to the main URL. If the value is only true the aliase will be matched with the database."  
		},

		"route.desktop" : { 
			"string",  
			"WbfUrlTripple", 
			"Route to the desktop", 
			"Webfrap.Desktop.display", 
			"true"  
		},
		"route.annon" : { 
			"string",  
			"WbfUrlTripple", 
			"Default route for annon users", 
			"Webfrap.Desktop.display", 
			"true"  
		},
		"route.user" : { 
			"string",  
			"WbfUrlTripple", 
			"Default rout for authentificated users", 
			"Webfrap.Desktop.display", 
			"true"  
		},
		"route.admin" : { 
			"string",  
			"WbfUrlTripple", 
			"Route to the admin panel", 
			"Webfrap.Desktop.display", 
			"true"  
		},
		"route.login" : { 
			"string",  
			"WbfUrlTripple", 
			"Route to the login mask", 
			"Webfrap.Desktop.display", 
			"true" 
		},
		"route.setup" : { 
			"string",  
			"WbfUrlTripple", 
			"Route to the setup subsystem", 
			"Webfrap.Desktop.display", 
			"true" 
		},
  	
		"ui.listing.numEntries"  : { 
			"[int]",  
			"int", 
			"Liste of possible size blocks to load", 
			"10,25,50,100,250,500", 
			"false"  
		},
		"ui.grid.controls"  : { 
			"string",  
			"Cname", 
			"Ui element for list controls", 
			"SplitButton", 
			"false"  
		},
		
		"ui.backend.js" : { "string",  "Cname", "Key for the backend Js listfile", "core", "true"  },
		"ui.backend.layout" : { "string",  "Cname", "Key for the backend css listfile", "core", "true"  },
		"ui.backend.theme" : { "string",  "Cname", "Key for the backend css theme listfile", "wbf", "true"  },
		"ui.frontend.js" : { "string",  "Cname", "Key for the frontend Js listfile", "core", "true"  },
		"ui.frontend.layout" : { "string",  "Cname", "Key for the frontend css listfile", "core", "true"  },
		"ui.frontend.theme" : { "string",  "Cname", "Key for the frontend css theme listfile", "wbf", "true"  }
  },
  "status": {
    "client.timezone" : { "string",  "TimeZone", "The Timezone of the client"  },
    "client.country" : { "string",  "CountryKey1", "Country of the client" },
    "client.language" : { "string",  "LanguageKey1", "The custom language used by the client." },
    "client.encoding" : { "string",  "Chartset", "Encoding Chartset of the client, normally utf-8" },
    "client.frontend.theme" : { "string",  "ThemeName", "Name of the Theme for the frontend" },
    "client.backend.theme" : { "string",  "ThemeName", "Name of the Theme for the backend" }
  },
  "initClasses":[
    	"Log": { "string",  "ClassName", "The Log subsystem"  },
    	"I18n": { "string",  "ClassName", "The i18n subsystem"  },
    	"Message": { "string",  "ClassName", "The message subsystem"  },
    	"Registry": { "string",  "ClassName", "The global object / cache / registry"  },
    	"Request": { "string",  "ClassName", "The http request as object"  },
    	"Response": { "string",  "ClassName", "The Response as object"  },
    	"Session": { "string",  "ClassName", "The Session as object"  },
    	"User": { "string",  "ClassName", "The data of the active user in an accessable object"  },
    	"View": { "string",  "ClassName", "The actual active View"  }
	],
	"modules": {
		"db": {
			"active": { "string",  "CountryKey1", "The expected location if no other is given"  },
			"adapters": {
				""
			},
			"description"; "Dbms connections with serveral adapters and master slave replication"
		},
		"ldap": {
			"description"; "List of available LDAP servers"
		},
		"http": {
			"description"; "Configuration of HTTP headers to be sent by the system"
		},
		"log": {
			"description"; "Adapters for the logsystem"
		},
		"cache": {
			"description"; "Cache adapter and settings"
		},
		"i18n": {
		
		},
		"upload": {
		
		},
		"user": {
		
		},
		"view": {
		
		},
		"beanstalkd": {
		
		},
		"memcached": {
		
		},
		"session": {
		
		},
		"services": {
		
		},
		"mail": {
		
		},
		"openfire": {
		
		}
	}
}
  
FORMAT;

  public function getFormat()
  {
    
  }
  

}//end class WebfrapConf_Model */


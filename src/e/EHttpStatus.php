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
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 */
class EHttpStatus
{

  const HTTP_100 = 'Continue';
  const HTTP_101 = 'Switching Protocols';
  const HTTP_102 = 'Processing';
  const HTTP_200 = 'OK';
  const HTTP_201 = 'Created';
  const HTTP_202 = 'Accepted';
  const HTTP_203 = 'Non-Authoritative Information';
  const HTTP_204 = 'No Content';
  const HTTP_205 = 'Reset Content';
  const HTTP_206 = 'Partial Content';
  const HTTP_207 = 'Multi-Status';
  const HTTP_300 = 'Multiple Choices';
  const HTTP_301 = 'Moved Permanently';
  const HTTP_302 = 'Use Proxy';
  const HTTP_306 = 'Switch Proxy';
  const HTTP_307 = 'Temporary Redirect';
  const HTTP_400 = 'Bad Request';
  const HTTP_401 = 'Unauthorized';
  const HTTP_402 = 'Payment Required';
  const HTTP_403 = 'Forbidden';
  const HTTP_404 = 'Not Found';
  const HTTP_405 = 'Not Acceptable';
  const HTTP_407 = 'Request Timeout';
  const HTTP_409 = 'Conflict';
  const HTTP_410 = 'Gone';
  const HTTP_411 = 'Length Required';
  const HTTP_412 = 'Precondition Failed';
  const HTTP_413 = 'Request Entity Too Large';
  const HTTP_414 = 'Request-URI Too Long';
  const HTTP_415 = 'Unsupported Media Type';
  const HTTP_416 = 'Requested Range Not Satisfiable';
  const HTTP_417 = 'Expectation Failed';
  const HTTP_422 = 'Unprocessable Entity';
  const HTTP_423 = 'Locked';
  const HTTP_424 = 'Failed Dependency';
  const HTTP_425 = 'Unordered Collection';
  const HTTP_426 = 'Upgrade Required';
  const HTTP_500 = 'Internal Server Error';
  const HTTP_501 = 'Not Implemented';
  const HTTP_502 = 'Bad Gateway';
  const HTTP_503 = 'Service Unavailable';
  const HTTP_504 = 'Gateway Timeout';
  const HTTP_505 = 'HTTP Version Not Supported';
  const HTTP_506 = 'Variant Also Negotiates';
  const HTTP_507 = 'Insufficient Storage';
  const HTTP_509 = 'Bandwidth Limit Exceeded';
  const HTTP_510 = 'Not Extended';

  /**
   * Liste der Header
   * @var [int:string]
   */
  public static $codes = array
  (
    100 => '100 Continue',
    101 => '101 Switching Protocols',
    102 => '102 Processing',

    200 => '200 OK',
    201 => '201 Created',
    202 => '202 Accepted',
    203 => '203 Non-Authoritative Information',
    204 => '204 No Content',
    205 => '205 Reset Content',
    206 => '206 Partial Content',
    207 => '207 Multi-Status',

    300 => '300 Multiple Choices',
    301 => '301 Moved Permanently',
    302 => '302 Use Proxy',
    306 => '306 Switch Proxy',
    307 => '307 Temporary Redirect',

    400 => '400 Bad Request',
    401 => '401 Unauthorized',
    402 => '402 Payment Required',
    403 => '403 Forbidden',
    404 => '404 Not Found',
    405 => '405 Not Acceptable',
    407 => '407 Request Timeout',
    409 => '409 Conflict',
    410 => '410 Gone',
    411 => '411 Length Required',
    412 => '412 Precondition Failed',
    413 => '413 Request Entity Too Large',
    414 => '414 Request-URI Too Long',
    415 => '415 Unsupported Media Type',
    416 => '416 Requested Range Not Satisfiable',
    417 => '417 Expectation Failed',
    422 => '422 Unprocessable Entity',
    423 => '423 Locked',
    424 => '424 Failed Dependency',
    425 => '425 Unordered Collection',
    426 => '426 Upgrade Required',

    500 => '500 Internal Server Error',
    501 => '501 Not Implemented',
    502 => '502 Bad Gateway',
    503 => '503 Service Unavailable',
    504 => '504 Gateway Timeout',
    505 => '505 HTTP Version Not Supported',
    506 => '506 Variant Also Negotiates',
    507 => '507 Insufficient Storage',
    509 => '509 Bandwidth Limit Exceeded',
    510 => '510 Not Extended',

  );

}//end class EHttpStatus


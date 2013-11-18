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
  * Php Backend für die Internationalisierungsklasse
  * @package WebFrap
  * @subpackage tech_core
  */
class LibHttpRequest_Curl implements LibHttpRequest
{
  
  /**
   * @readonly
   * @var string
   */
  protected $_url = null;
  
  /**
   * @var Resource
   */
  protected $rqtHandel = null;
  
  protected $timeout = 30;

  /**
   * @param string $url
   */
  public function __construct($url)
  {
    $this->_url = $url;
    $this->rqtHandel = curl_init();
    
    curl_setopt($this->rqtHandel, CURLOPT_URL, $url);
    curl_setopt($this->rqtHandel, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($this->rqtHandel, CURLOPT_RETURNTRANSFER, 1);// rückgabe des inhalts erwünscht
    
  }
  
  /**
   * @param string $key
   */
  public function __get($key){
  
  }//end public function __get */
  
  /**
   * @param array
   */
  public function setOptions($options)
  {
  
    foreach($options as $key => $value){
      curl_setopt($this->rqtHandel, $key, $value);
    }
  
  }//end public function setOptions */
  
  /**
   * 
   */
  public function execute()
  {
    
    curl_exec($this->rqtHandel);
    curl_close($this->rqtHandel);
    
  }//end public function execute */
  
  /**
   * @return [
   * "url",
   * "content_type",
   * "http_code",
   * "header_size",
   * "request_size",
   * "filetime",
   * "ssl_verify_result",
   * "redirect_count",
   * "total_time",
   * "namelookup_time",
   * "connect_time",
   * "pretransfer_time",
   * "size_upload",
   * "size_download",
   * "speed_download",
   * "speed_upload",
   * "download_content_length",
   * "upload_content_length",
   * "starttransfer_time",
   * "redirect_time"
   * ]
   */
  public function getInfo()
  {
    
    /*
      CURLINFO_SSL_VERIFYRESULT error codes:
      0: ok the operation was successful.
      2 : unable to get issuer certificate
      3: unable to get certificate CRL
      4: unable to decrypt certificate's signature
      5: unable to decrypt CRL's signature
      6: unable to decode issuer public key
      7: certificate signature failure
      8: CRL signature failure
      9: certificate is not yet valid
      10: certificate has expired
      11: CRL is not yet valid
      12: CRL has expired
      13: format error in certificate's notBefore field
      14: format error in certificate's notAfter field
      15: format error in CRL's lastUpdate field
      16: format error in CRL's nextUpdate field
      17: out of memory
      18: self signed certificate
      19: self signed certificate in certificate chain
      20: unable to get local issuer certificate
      21:unable to verify the first certificate
      22: certificate chain too long
      23: certificate revoked
      24: invalid CA certificate
      25: path length constraint exceeded
      26: unsupported certificate purpose
      27: certificate not trusted
      28: certificate rejected
      29: subject issuer mismatch
      30: authority and subject key identifier mismatch
      31: authority and issuer serial number mismatch
      32: key usage does not include certificate signing
      50: application verification failure
      details at http://www.openssl.org/docs/apps/verify.html#VERIFY_OPERATION
     */
    
    $info = curl_getinfo($this->rqtHandel);
  
  }//end public function execute */



} // end class LibHttpError


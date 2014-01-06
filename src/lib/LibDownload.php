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
 * Download Klasse für WebFrap
 * 
 * @package WebFrap
 * @subpackage tech_core
 */
class LibDownload
{
    
    /**
     * Name der Tabelle auf welchen sich der Datensatz bezieht
     * @var string
     */
    public $table = 'wbfsys_file';
    
    /**
     * Name des Attributes wo sich die Datei befindet
     * @var string
     */
    public $attr = 'name';
    
    /**
     * 
     * @var Pbase
     */
    protected $env = null;
    
    /**
     * @param Pbase $env
     */
    public function __construct($env)
    {
        $this->env = $env;
    }//end public function __construct */
    
    /**
     * @param string $fileId
     * @param array $params
     */
    public function getFileNode($fileId, $params)
    {
        
        return null;
        
    }//end public function getFileNode */
    
} // end class LibDownload


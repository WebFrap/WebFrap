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
 * de:
 * {
 * Diese Klasse wird zum emulieren von benamten parametern verwendet.
 *
 * Dazu werden __get und __set implementiert.
 * __get gibt entweder den passenden wert für einen key oder null zurück
 * }
 *
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 * @package WebFrap
 * @subpackage tech_core
 *            
 */
class ContextServiceList extends Context
{

    /**
     * Der type der Liste, z.B.
     * Table, Treetable, Selection
     * 
     * @var string
     */
    public $ltype = null;

    /**
     * Liste der Suchwerte aus der Col Search
     * 
     * @var array / null wenn leer
     */
    public $colConditions = null;

    /**
     * Conditions für die query
     * 
     * @var array / null wenn leer
     */
    public $conditions = null;

    /**
     * Variable für Sortierinformationen
     * 
     * @var array / null wenn leer
     */
    public $order = null;

    /**
     * Eine List mit Filtern
     * 
     * @var TFlag
     */
    public $filter = null;

    /**
     * Eine List mit Filtern
     * 
     * @var TFlag
     */
    public $dynFilters = array();

    /**
     * Flags für custom filter
     * 
     * @var TFlag
     */
    public $customFilterFlags = array();

    /**
     * Liste von Referenzen (wo wird das verwendet?)
     * 
     * @var array
     */
    public $refIds = null;

    /**
     * Search Fields
     * 
     * @var array
     */
    public $searchFields = array();

    /**
     * Search Fields
     * 
     * @var array
     */
    public $searchFieldsStack = array();

    /**
     * Extended Search filter
     * 
     * @var array
     */
    public $extSearch = array();
    
    /**
     * Flag ob die Head Metadaten mitgeliefert werden sollen
     *
     * @var array
     */
    public $noHead = false;

    /**
     * de:
     * {
     * Container zum speichern der key / value paare.
     * }
     * 
     * @var array
     */
    protected $content = array();

    /**
     *
     * @var string
     */
    protected $urlExt = null;

    /**
     *
     * @var string
     */
    protected $actionExt = null;

    /**
     *
     * @var ValidSearchBuilder
     */
    protected $extSearchValidator = null;

    /**
     *
     * @param LibRequestHttp $request            
     */
    public function __construct($request, $extSearchValidator = null)
    {
        $this->filter = new TFlag();
        
        $filters = $request->param('filter', Validator::BOOLEAN);
        
        if ($filters) {
            foreach ($filters as $key => $value) {
                $this->filter->$key = $value;
            }
        }
        
        // dynamische filter
        $this->dynFilters = $request->param('dynfilter', Validator::TEXT);
        $this->refIds = $request->paramList('refids', Validator::INT);
        $this->pRefId = $request->param('prefid', Validator::INT);
        
        $cffKeys = $request->paramKeys('cff');
        
        if ($cffKeys) {
            foreach ($cffKeys as $cffKey) {
                $this->customFilterFlags[$cffKey] = $request->param('cff', Validator::CKEY, $cffKey);
            }
        }

        if (! $this->refIds) {
            $this->refIds = new TArray();
        }
        
        if ($request->paramExists('as')) {
            if ($extSearchValidator)
                $this->extSearchValidator = $extSearchValidator;
            else
                $this->extSearchValidator = new ValidSearchBuilder();
        }
        
        $this->interpretRequest($request);
        $this->interpretCustomSearch($request);
        
    } // end public function __construct */

    
    /**
     * Extrahieren der für diesen Kontext relevanten parameter aus dem Benutzer Request
     * 
     * @param LibRequestHttp $request            
     */
    public function interpretRequest($request)
    {
        
        if ($request->paramExists('as')) {
            $this->interpretExtendedSearch($request);
        }
        
        $this->interpretRequestAcls($request);

            
        // über den ltype können verschiedene listenvarianten gewählt werden
        // diese müssen jedoch vorhanden / implementiert sein
        if ($ltype = $request->param('ltype', Validator::CNAME))
            $this->ltype = $ltype;
        

        if ($format = $request->param('format', Validator::CNAME))
            $this->format = $format;
        else 
            $this->format = 'json';

        // start position of the query and size of the table
        $this->noHead = $request->param('nohead', Validator::BOOLEAN);
            
        // wird bei selection und data verwendet
        if ($ltype = $request->param('context', Validator::CNAME))
            $this->context = $ltype;
        
        // start position of the query and size of the table
        $this->offset = $request->param('offset', Validator::INT);
        
        // start position of the query and size of the table
        $this->start = $request->param('start', Validator::INT);
        
        if ($this->offset) {
            if (! $this->start)
                $this->start = $this->offset;
        }
        
        // stepsite for query (limit) and the table
        if (! $this->qsize = $request->param('qsize', Validator::INT))
            $this->qsize = Wgt::$defListSize;
            
            // order for the multi display element
        $this->order = $request->param('order', Validator::CNAME);
        

            // flag for beginning seach filter
        if ($text = $request->param('begin', Validator::TEXT)) {
            // whatever is comming... take the first char
            $this->begin = $text[0];
        }

        
        // exclude whatever
        $this->exclude = $request->param('exclude', Validator::CKEY);
        
        // the activ id, mostly needed in exlude calls
        $this->objid = $request->param('objid', Validator::EID);
        
        
    } // end public function interpretRequest */
    
    /**
     * Interpretieren von Extended Search Parametern
     * 
     * @param LibRequestHttp $request            
     */
    public function interpretExtendedSearch($request)
    {
        $extSearchFields = $request->param('as');
        
        if (! $extSearchFields)
            return;
        
        if (! $this->searchFieldsStack) {
            foreach ($this->searchFields as $searchFields) {
                foreach ($searchFields as $sKey => $sData) {
                    $this->searchFieldsStack[$sKey] = $sData;
                }
            }
        }
        
        foreach ($extSearchFields as $fKey => $extField) {
            
            if (! isset($this->searchFieldsStack[$extField['field']])) {
                // field not exists
                continue;
            }
            
            $validField = $this->extSearchValidator->validate($extField, $this->searchFieldsStack[$extField['field']]);
            
            if ($validField) {
                
                if (isset($extField['parent'])) {
                    
                    if (! isset($this->extSearch[$extField['parent']]->sub))
                        $this->extSearch[$extField['parent']]->sub = array();
                    
                    $this->extSearch[$extField['parent']]->sub[] = (object) $validField;
                } else {
                    
                    $this->extSearch[$fKey] = (object) $validField;
                }
            } else {
                Debug::console($extField['field'].' was invalid ');
            }
        } // end foreach
    } // end public function interpretExtendedSearch */
    
    /**
     * Interpretieren der Custom Search / Order Flags
     * 
     * @param LibRequestHttp $request            
     */
    public function interpretCustomSearch($request)
    {} // end public function interpretCustomSearch */
    
    /**
     *
     * @return string
     */
    public function toUrlExt()
    {
        if ($this->urlExt)
            return $this->urlExt;
        
        if ($this->aclRoot)
            $this->urlExt .= '&amp;a_root='.$this->aclRoot;
        
        if ($this->aclRootId)
            $this->urlExt .= '&amp;a_root_id='.$this->aclRootId;
        
        if ($this->aclKey)
            $this->urlExt .= '&amp;a_key='.$this->aclKey;
        
        if ($this->aclNode)
            $this->urlExt .= '&amp;a_node='.$this->aclNode;
        
        if ($this->aclLevel)
            $this->urlExt .= '&amp;a_level='.$this->aclLevel;
        
        
        if ($this->dynFilters) {
            foreach ($this->dynFilters as $value) {
                $this->urlExt .= '&amp;dynfilter[]='.$value;
            }
        }
        
        if ($this->customFilterFlags) {
            foreach ($this->customFilterFlags as $fKey => $values) {
                foreach ($values as $value) {
                    $this->urlExt .= '&amp;cff['.$fKey.'][]='.$value;
                }
            }
        }
        
        return $this->urlExt;
    } // end public function toUrlExt */
    
    /**
     *
     * @return string
     */
    public function toActionExt()
    {
        if ($this->actionExt)
            return $this->actionExt;
        
        if ($this->aclRoot)
            $this->actionExt .= '&a_root='.$this->aclRoot;
        
        if ($this->aclRootId)
            $this->actionExt .= '&a_root_id='.$this->aclRootId;
        
        if ($this->aclKey)
            $this->actionExt .= '&a_key='.$this->aclKey;
        
        if ($this->aclNode)
            $this->actionExt .= '&a_node='.$this->aclNode;
        
        if ($this->aclLevel)
            $this->actionExt .= '&a_level='.$this->aclLevel;
                
        if ($this->dynFilters) {
            foreach ($this->dynFilters as $value) {
                $this->actionExt .= '&dynfilter[]='.$value;
            }
        }
        
        if ($this->customFilterFlags) {
            foreach ($this->customFilterFlags as $fKey => $values) {
                foreach ($values as $value) {
                    $this->actionExt .= '&cff['.$fKey.'][]='.$value;
                }
            }
        }
        
        return $this->actionExt;
    } // end public function toActionExt */

    
} // end class ContextListing

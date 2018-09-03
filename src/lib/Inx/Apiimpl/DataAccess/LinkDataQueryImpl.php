<?php

class Inx_Apiimpl_DataAccess_LinkDataQueryImpl implements Inx_Api_DataAccess_LinkDataQuery {
    
    private $_oSc;

    private $_oService;
    
    private $_oDataAccessUtil;
    
    private $aMailingIds;
    
    private $aLinkIds;
    
    private $aLinkNames;
    
    private $aLinkTypes;
    
    private $aRecipientIds;
    
    private $blLinkNameSet;
    
    private $blPermanentLinksOnly = true;
    
    public function __construct( Inx_Apiimpl_SessionContext $oSc )
    {
        $this->_oSc = $oSc;
        $this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::DATAACCESS4_SERVICE );
		$this->_oDataAccessUtil = new Inx_Apiimpl_DataAccess_DataAccessUtil();
    }
    
    public function linkIds(array $aLinkIds = null)
    {
        $this->aLinkIds = $aLinkIds;
        return $this;
    }

    public function linkNames(array $aLinkNames = null) 
    {
        $this->aLinkNames = $aLinkNames;
        return $this;
    }

    public function linkTypes(array $aLinkTypes = null) 
    {
		$this->_oDataAccessUtil->checkLinkTypeValid($aLinkTypes);
    	$this->aLinkTypes = $aLinkTypes;
        return $this;
    }

    public function mailingIds(array $aMailingIds = null)
    {
        $this->aMailingIds = $aMailingIds;
        return $this;
    }

    public function recipientIds(array $aRecipientIds = null)
    {
        $this->aRecipientIds = $aRecipientIds;
        return $this;
    }

    public function linkNameSet($blLinkNameSet)
    {
        $this->blLinkNameSet = $blLinkNameSet;
        return $this;
    }
    
    public function permanentLinksOnly()
    {
        $this->blPermanentLinksOnly = true;
        return $this;
    }
    
    public function permanentAndTemporaryLinks()
    {
    	$this->blPermanentLinksOnly = false;
    	return $this;
    }
    
    public function executeQuery()
    {
        try
        {
            $oResult = $this->_oService->selectLinkGeneric(
                    $this->_oSc->createCxt(), $this->aMailingIds,
                    $this->aLinkIds, $this->aRecipientIds,
                    $this->aLinkNames, $this->aLinkTypes,
                    Inx_Apiimpl_TConvert::TConvert( $this->blLinkNameSet ) ,
                    $this->blPermanentLinksOnly );

            return new Inx_Apiimpl_DataAccess_LinkDataRowSetImpl($this->_oSc,$oResult);
		}
        catch( Inx_Api_RemoteException $e )
		{
            $this->_oSc->notify( $e );
            return null;
		}
    }
}

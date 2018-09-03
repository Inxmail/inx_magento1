<?php
class Inx_Apiimpl_DataAccess_DataAccessUtil
{
	public function checkLinkTypeValid( array $aLinkTypes )
	{
		$aInvalidLinktypes = $this->getInvalidLinkTypes($aLinkTypes);
		if (!empty($aInvalidLinktypes))
		{
			$sInvalidLinktypes = implode(", ", $aInvalidLinktypes);
			throw new Inx_Api_IllegalArgumentException( "Invalid link type(s): $sInvalidLinktypes - see LinkDataRowSet for valid link types (excluding LINK_TYPE_UNKNOWN)" );
		}
	}
	
	public function getInvalidLinkTypes( array $aLinkTypes )
	{
		$aResult = array();
		
		if (!empty($aLinkTypes))
		{
			foreach($aLinkTypes as $iLinkType)
    	    {
				if( $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_REDIRECT
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNSUBSCRIBE
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_COUNT
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNIQUE_COUNT
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_VERIFY_SUBSCRIPTION
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_VERIFY_UNSUBSCRIPTION
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_OPENING_COUNT
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_CONTENT
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_OPENING_CONTENT
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNSUBSCRIBE_LINK
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_HEADER_UNSUBSCRIBE
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_JSP_UNSUBSCRIBE
					&& $iLinkType != Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_PAGE_UNSUBSCRIBE )
						$aResult[] = $iLinkType;
     	   }
		}
		
		return $aResult;
	}
}

<?php
class Inx_Apiimpl_Recipient_RecipientRowSetImpl 
    extends Inx_Apiimpl_Recipient_AbstractRecipientManipulationRowSet 
    implements Inx_Api_Recipient_RecipientRowSet
{
	protected $_oService;


	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientManager, stdClass $oRowSet )
	{
                parent::__construct( $oRecipientManager->_remoteRef(), $oRowSet->remoteRefId, $oRowSet->rowCount, 
                        $oRowSet->data, "recipient", $oRecipientManager );
		$this->_oService = $oRecipientManager->_remoteRef()->getService( Inx_Apiimpl_SessionContext::RECIPIENT_SERVICE );
	}


	public function getId()
	{
                $this->checkRecipientExists();
		return $this->_oCurrentObject->id;
	}


	public function setAttributeValue( Inx_Api_Recipient_Attribute $oAttr, $newValue, Inx_Api_IndexSelection $oSelection = null )
        {
            $ret = false;
            
            if (is_null($oSelection)) 
            {
                try
                {
                    $ret = $this->_oService->setAttributeValue1( $this->_sessionId(), $this->_refId(),
                        $oAttr->createAttrUpdate( $newValue ));
                }
                catch( Inx_Api_RemoteException $e )
                {
                        $this->_oBuffer->clear();
                        $this->_notify( $e );
                        return false;
                }
            } 
            else 
            {                
                try
                {
                    $ret = $this->_oService->setAttributeValue2( $this->_sessionId(), $this->_refId(), 
                        $oAttr->createAttrUpdate( $newValue ), Inx_Apiimpl_Util_SelectionUtils::convertToArray( $oSelection ) );
                } 
                catch( Inx_Api_RemoteException $e ) 
                {
                    $this->_oBuffer->clear();
                    $this->_notify( $e );                    
                    return false;
                }

                
            }

            $this->_oBuffer->clear();
            return $ret;
        }


	protected function checkRecipientExists()
	{
		$this->checkExists();
	}


	protected function getAttributeGetter( Inx_Api_Recipient_Attribute $oAttr )
	{		
		if( $oAttr->getContext() == $this->_oRecipientContext )
			return $oAttr;

		throw new Inx_Api_IllegalStateException( "wrong context" );
	}


	protected function getAttributeWriter( Inx_Api_Recipient_Attribute $oAttr )
	{
		if( $oAttr->getContext() == $this->_oRecipientContext )
			return $oAttr;

		throw new Inx_Api_IllegalStateException( "wrong context" );
	}


	protected function createWriteCopy( $oOriginRecipient )
	{
                $writeCopy = new stdClass();
                $writeCopy->id = $oOriginRecipient->id;
			
                $sa = $oOriginRecipient->stringData;
                if(! empty($sa))
                {
                        $writeCopy->stringData = $sa;
                }
                $ba = $oOriginRecipient->booleanData;
                if(! empty($ba))
                {
                        $writeCopy->booleanData = $ba;
                }
                $ia = $oOriginRecipient->integerData;
                if(! empty($ia))
                {
                        $writeCopy->integerData = $ia;
                }
                $da = $oOriginRecipient->doubleData;
                if(! empty($da) )
                {
                        $writeCopy->doubleData = $da;
                }
                $dta = $oOriginRecipient->datetimeData;
                if(! empty($dta))
                {
                        $writeCopy->datetimeData = $dta;
                }
                $ta = $oOriginRecipient->dateData;
                if(! empty($ta))
                {
                        $writeCopy->dateData = $ta;
                }
                $tta = $oOriginRecipient->timeData;
                if(! empty($tta))
                {
                        $writeCopy->timeData = $tta;
                }

		return $writeCopy;
	}


	protected function doFetch( $oCxt, $sRemoteRefId, $iIndex, $iDirection )
	{
		return $this->_oService->fetchRecipients( $oCxt->sid, $sRemoteRefId, $iIndex, $iDirection );
	}


	protected function createNewObject()
	{
		return $this->_oRecipientContext->createNewRecipientData();
	}


	protected function doDelete( $oSc, $sRemoteRefId, array $aIndices )
	{
		return $this->_oService->deleteRecipients( $oSc->sid, $sRemoteRefId, $aIndices );
	}


	protected function doRecipientUpdate( $oSc, $sRemoteRefId, stdClass $ru )
	{
		$h = $this->_oService->updateRecipient( $oSc->sid, $sRemoteRefId, $ru );
		if( $h->updExcDesc != null )
		{
			$x = $h->updExcDesc;
			switch( $x->type )
			{
				case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_ILLEGAL_VALUE:
        				throw new Inx_Api_Recipient_IllegalValueException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_DUPLICATE_KEY:
        				throw new Inx_Api_Recipient_DuplicateKeyException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_BLACK_LIST:
        				throw new Inx_Api_Recipient_BlackListException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_RECIPIENT_NOT_FOUND:
        				throw new Inx_Api_DataException( "recipient deleted" );
			}
		}
		return $h->value;
	}


	protected function updateBufferAfterUpdate( Inx_Apiimpl_Util_IndexedBuffer $oBuffer, $oUpdatedRecipient,
			$iCurrentRow, $blIsNewRecipient )
	{
		if( $blIsNewRecipient )
		{
			$this->_iRowCount++;
			$oBuffer->setBuffer( $iCurrentRow, array( $oUpdatedRecipient ) );
		}
		else
		{
			$oBuffer->setBuffer( $iCurrentRow, $oUpdatedRecipient );
		}

	}


	protected function createRecipientUpdate( $oCurrentRecipient, array $aChangedAttrs )
	{
        return $this->_oRecipientContext->createRecipientUpdate( $oCurrentRecipient, $aChangedAttrs );
	}

	public function getTrackingPermission( Inx_Api_List_ListContext $oList )
	{
                if(!$this->_oRecipientContext->includesTrackingPermissions())
                {
                    throw new Inx_Api_Recipient_TrackingPermissionNotFetchedException();
                }
            
		$oAttr = $this->getContext()->getTrackingPermissionAttribute( $oList );
		$iRet = $this->getInteger( $oAttr );
		return Inx_Api_TrackingPermission_TrackingPermissionState::byId( $iRet );
	}

	public function updateTrackingPermission( Inx_Api_List_ListContext $oList, Inx_Api_TrackingPermission_TrackingPermissionState $oValue )
	{
                if(!$this->_oRecipientContext->includesTrackingPermissions())
                {
                    throw new Inx_Api_Recipient_TrackingPermissionNotFetchedException();
                }
            
		$oAttr = $this->getContext()->getTrackingPermissionAttribute( $oList );
		$iPermissionValue = $oValue->getId();
		$this->updateInteger( $oAttr, $iPermissionValue );
	}

}
<?php
class Inx_Apiimpl_Recipient_UnsubscriptionRecipientRowSetImpl 
        extends Inx_Apiimpl_Recipient_AbstractRecipientManipulationRowSet 
        implements Inx_Api_Recipient_UnsubscriptionRecipientRowSet
{
	protected $_oService;

        /**
         * @var Inx_Api_List_ListContext
         */
	protected $_oListContext;


	public function __construct( Inx_Apiimpl_Recipient_RecipientContextImpl $oRecipientManager, 
            stdClass $oRowSet, Inx_Api_List_ListContext $oListContext )
	{
                parent::__construct( $oRecipientManager->_remoteRef(), $oRowSet->remoteRefId, $oRowSet->rowCount, 
                        $oRowSet->data, "recipient", $oRecipientManager );

		$this->_oService = $oRecipientManager->_remoteRef()->getService(
				Inx_Apiimpl_SessionContext::UNSUBSCRIBER_SERVICE );
		$this->_oListContext = $oListContext;
	}


	public function resubscribe( $sSubscriptionDate )
	{
		try
		{
			$attr = $this->getMetaData()->getSubscriptionAttribute($this->_oListContext );
			$this->updateDatetime( $attr, $sSubscriptionDate == null ? $this->getDatetime( $attr ) : $sSubscriptionDate );
		}
		catch( Inx_Api_Recipient_AttributeNotFoundException $e )
		{
			// should be never happens
			throw new Inx_Api_DataException( "list deleted?!" );
		}
	}


	public function setResubscribe( $sSubscriptionDate, Inx_Api_IndexSelection $oSelection = null )
	{
            if (is_null($oSelection)) 
            {
                try
                {
                    return $this->_oService->setAttributeValue1( $this->_sessionId(), $this->_refId(),
                        Inx_Apiimpl_TConvert::TConvert($sSubscriptionDate));
                }
                catch( Inx_Api_RemoteException $e )
                {
                    $this->_notify( $e );
                    return false;
                }
            } 
            else 
            {
                try
                {
                    return $this->_oService->setAttributeValue2( $this->_sessionId(), $this->_refId(), 
                        Inx_Apiimpl_TConvert::TConvert($sSubscriptionDate),
                        Inx_Apiimpl_Util_SelectionUtils::convertToArray( $oSelection ) );
                } 
                catch( Inx_Api_RemoteException $e ) 
                {
                    $this->_notify( $e );
                    return false;
                }
            }
            
            $this->_oBuffer->clear();
	}


	public function getId()
	{
		return $this->_oCurrentObject->id;
	}


	public function getUnsubscriptionDate()
	{
		try
		{
			return $this->getDatetime( $this->_oRecipientContext->getMetaData()
                                ->getSubscriptionAttribute( $this->_oListContext ) );
		}
		catch( Inx_Api_Recipient_AttributeNotFoundException $e )
		{
			return null;
		}
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


	protected function createWriteCopy( $oOriginObject )
	{
		$writeCopy = new stdClass(); // @TODO RecipientData
                $writeCopy->id = $oOriginObject->id;

                $sa = $oOriginObject->stringData;
                if(! empty($sa))
                {
                        $writeCopy->stringData = $sa;
                }
                $ba = $oOriginObject->booleanData;
                if(! empty($ba))
                {
                        $writeCopy->booleanData = $ba;
                }
                $ia = $oOriginObject->integerData;
                if(! empty($ia))
                {
                        $writeCopy->integerData = $ia;
                }
                $da = $oOriginObject->doubleData;
                if(! empty($da) )
                {
                        $writeCopy->doubleData = $da;
                }
                $dta = $oOriginObject->datetimeData;
                if(! empty($dta))
                {
                        $writeCopy->datetimeData = $dta;
                }
                $ta = $oOriginObject->dateData;
                if(! empty($ta))
                {
                        $writeCopy->dateData = $ta;
                }
                $tta = $oOriginObject->timeData;
                if(! empty($tta))
                {
                        $writeCopy->timeData = $tta;
                }

		return $writeCopy;
	}


	protected function createRecipientUpdate( $oCurrentRecipient, array $aChangedAttrs )
	{
		return $this->_oRecipientContext->createRecipientUpdate( $oCurrentRecipient, $aChangedAttrs );
	}


	protected function updateBufferAfterUpdate( Inx_Apiimpl_Util_IndexedBuffer $oBuffer, 
                $oUpdatedRecipient, $iCurrentRow, $blIsNewRecipient )
	{
		if( $blIsNewRecipient )
		{
			$this->rowCount++;
			$oBuffer->setBuffer( $iCurrentRow, array ( $oUpdatedRecipient ) );
		}
		else
		{
			$oBuffer->setBuffer( $iCurrentRow, $oUpdatedRecipient );
		}
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


	protected function createNewObject()
	{
		// not implemented as unsubscriber row set does not support insertion
		return null;
	}


	protected function doDelete( $oSc, $sRemoteRefId, array $aIndices )
	{
		return $this->_oService->deleteRecipients( $oSc->sid, $sRemoteRefId, $aIndices );
	}


	protected function doFetch( $oSc, $sRemoteRefId, $iIndex, $iDirection )
	{
		return $this->_oService->fetchRecipients( $oSc->sid, $sRemoteRefId, $iIndex, $iDirection );
	}
}
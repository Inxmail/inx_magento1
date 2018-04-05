<?php
class Inx_Apiimpl_Testprofiles_TestRecipientRowSetImpl 
    extends Inx_Apiimpl_Recipient_AbstractRecipientManipulationRowSet 
    implements Inx_Api_Testprofiles_TestRecipientRowSet
{
	private $_oService;


	public function __construct( Inx_Apiimpl_SessionContext $oSc, 
                Inx_Apiimpl_Recipient_RecipientContextImpl $oRc, stdClass $oData )
	{
                parent::__construct($oSc, $oData->remoteRefId, $oData->rowCount, self::convert($oData->data), 
                        'recipient', $oRc);
		$this->_oService = $oSc->getService( Inx_Apiimpl_SessionContext::TESTRECIPIENT_SERVICE );
	}


	public function getId()
	{
		return $this->_oCurrentObject->getRecipient()->id;
	}


	public function getName()
	{
		$this->checkExists();
		return $this->_oCurrentObject->getTestrecipientData()->profileDescr;
	}


	public function updateName( $sName )
	{
		$this->checkExists();
		if( is_null($sName) )
			throw new Inx_Api_IllegalArgumentException( 'name can not null' );
		$this->_oCurrentObject->getTestrecipientData()->profileDescr = $sName;
	}


	protected function checkReadAccess( Inx_Api_Recipient_Attribute $oAttr )
	{
		$this->checkRecipientExists();
		return $this->getAttributeGetter( $oAttr );
	}


	protected function checkRecipientExists()
	{
		$this->checkExists();
	}


	protected function getAttributeGetter( Inx_Api_Recipient_Attribute $oAttr )
	{
		return new Inx_Apiimpl_Testprofiles_TestRecipientAttributeAccessor($oAttr);
	}


	protected function getAttributeWriter( Inx_Api_Recipient_Attribute $oAttr )
	{
		return new Inx_Apiimpl_Testprofiles_TestRecipientAttributeAccessor($oAttr);
	}


	protected function createWriteCopy( $oOriginRecipient )
	{
                $writeCopy = new Inx_Apiimpl_Testprofiles_TestRecipientHolder(new stdClass()); // @TODO RecipientData
                $writeCopy->getRecipient()->id = $oOriginRecipient->getRecipient()->id;
                //fixes XAPI-45
                if(! empty($oOriginRecipient->getTestrecipientData()->profileDescr))
                {
                        $writeCopy->getTestrecipientData()->profileDescr = 
                                $oOriginRecipient->getTestrecipientData()->profileDescr;
                }

                $sa = $oOriginRecipient->getRecipient()->stringData;
                if(! empty($sa))
                {
                        $writeCopy->getRecipient()->stringData = $sa;
                }
                $ba = $oOriginRecipient->getRecipient()->booleanData;
                if(! empty($ba))
                {
                        $writeCopy->getRecipient()->booleanData = $ba;
                }
                $ia = $oOriginRecipient->getRecipient()->integerData;
                if(! empty($ia))
                {
                        $writeCopy->getRecipient()->integerData = $ia;
                }
                $da = $oOriginRecipient->getRecipient()->doubleData;
                if(! empty($da) )
                {
                        $writeCopy->getRecipient()->doubleData = $da;
                }
                $dta = $oOriginRecipient->getRecipient()->datetimeData;
                if(! empty($dta))
                {
                        $writeCopy->getRecipient()->datetimeData = $dta;
                }
                $ta = $oOriginRecipient->getRecipient()->dateData;
                if(! empty($ta))
                {
                        $writeCopy->getRecipient()->dateData = $ta;
                }
                $tta = $oOriginRecipient->getRecipient()->timeData;
                if(! empty($tta))
                {
                        $writeCopy->getRecipient()->timeData = $tta;
                }

		return $writeCopy;
	}


	protected function createRecipientUpdate( $oCurrentRecipient, 
                array $aChangedAttrs )
	{
		return $this->_oRecipientContext->createRecipientUpdate( $oCurrentRecipient->getRecipient(), 
                        $aChangedAttrs );
	}


	protected function updateBufferAfterUpdate( Inx_Apiimpl_Util_IndexedBuffer $oBuffer,
            $oUpdatedRecipient, $iCurrentRow, $blIsNewRecipient )
	{
		if( $blIsNewRecipient )
		{
			$this->_iRowCount++;
			$oBuffer->setBuffer( $iCurrentRow, new Inx_Apiimpl_Testprofiles_TestRecipientHolder( 
                                $oUpdatedRecipient->getTestrecipientData() ) );
		}
		else
		{
			$oBuffer->setBuffer( $iCurrentRow, $oUpdatedRecipient );
		}
	}


	protected function doRecipientUpdate( $oSc, $sRemoteRefId, stdClass $ru )
	{
		$h = $this->_oService->updateRecipient( $oSc->sid, $sRemoteRefId, 
                        $this->createTestrecipientUpdate( $ru ) );

		if( !is_null($h->updExcDesc) )
		{
			$x = $h->updExcDesc;
			switch( $x->type )
			{
                            case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_ILLEGAL_VALUE:
        				throw new Inx_Api_Recipient_IllegalValueException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_DUPLICATE_KEY:
        				throw new Inx_Api_Recipient_DuplicateKeyException( $x->msg, $x->type );
        			case Inx_Apiimpl_Recipient_Constants::UPDATE_EXCEPTION_RECIPIENT_NOT_FOUND:
        				throw new Inx_Api_DataException( "recipient deleted" );
			}
		}

		return new Inx_Apiimpl_Testprofiles_TestRecipientHolder( $h->value );
	}


	protected function createNewObject()
	{
		return new Inx_Apiimpl_Testprofiles_TestRecipientHolder( null, 
                        $this->_oRecipientContext->createNewRecipientData() );
	}


	protected function doDelete( $oSc, $sRemoteRefId, array $aIndices )
	{
		return $this->_oService->deleteRecipients( $oSc->sid, $sRemoteRefId, $aIndices );
	}


	protected function doFetch( $oCxt, $sRemoteRefId, $iIndex, $iDirection )
	{
		return self::convert( $this->_oService->fetchRecipients( $oCxt->sid, $sRemoteRefId, 
                        $iIndex, $iDirection ) );
	}


	private static function convert( array $aData = null )
	{
                if(is_null($aData))
                    return array();
            
                $aTrh = array();
		for( $i = 0; $i < sizeof($aData); $i++ )
			$aTrh[$i] = new Inx_Apiimpl_Testprofiles_TestRecipientHolder( $aData[$i] );
		return $aTrh;
	}


	private function createTestrecipientUpdate( stdClass $ru )
	{
                $tru = new stdClass();
		$tru->profileDescr = $this->_oCurrentObject->getTestrecipientData()->profileDescr;
		$tru->attrIndices = $ru->attrIndices;
		$tru->booleanData = $ru->booleanData;
		$tru->dateData = $ru->dateData;
		$tru->datetimeData = $ru->datetimeData;
		$tru->doubleData = $ru->doubleData;
		$tru->id = $ru->id;
		$tru->integerData = $ru->integerData;
		$tru->timeData = $ru->timeData;
		$tru->stringData = $ru->stringData;
		$tru->typeArrayIndices = $ru->typeArrayIndices;
		return $tru;
	}
}
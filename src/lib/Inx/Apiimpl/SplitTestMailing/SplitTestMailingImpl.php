<?php

class Inx_Apiimpl_SplitTestMailing_SplitTestMailingImpl implements Inx_Api_SplitTestMailing_SplitTestMailing
{
    /**
     * @var Inx_Apiimpl_AbstractSession
     */
    protected $_oSession;

    /**
     * @var stdClass
     */
    protected $_oService;

    /**
     * @var stdClass
     */
    protected $_oData;


    public function __construct(Inx_Apiimpl_AbstractSession $oSession, $oData)
    {
        $this->_oSession = $oSession;
        $this->_oData = $oData;
        $this->_oService = $this->_oSession->getService(Inx_Apiimpl_SessionContext::SPLIT_TEST_MAILING_SERVICE);
    }


    public function getId()
    {
        return $this->_oData->id;
    }


    public function reload()
    {
        try {
            $oData = $this->_oService->get($this->_oSession->createCxt(), $this->getId());

            if (empty($oData))
                throw new Inx_Api_DataException("Mailing has been deleted: ID: " . $this->getId());

            $this->_oData = $oData;
        } catch (Inx_Api_RemoteException $e) {
            $this->_oSession->notify($e);
        }

    }


    public function getName()
    {
        return Inx_Apiimpl_TConvert::convert($this->_oData->name);
    }


    public function getSubject()
    {
        return Inx_Apiimpl_TConvert::convert($this->_oData->subject);
    }


    public function getListContextId()
    {
        return $this->_oData->listId;
    }

    /**
     * @return Inx_Apiimpl_SplitTest_SplitTestImpl
     */
    public function getSplitTest()
    {
        $iSplitTestId = Inx_Apiimpl_TConvert::convert($this->_oData->splitTestId);

        try
        {
            if( $iSplitTestId !== null )
	            return $this->_oSession->getSplitTestManager()->get( $iSplitTestId );

        } catch( Inx_Api_DataException $e ) {
        }

        return null;
    }


    public function getCreationDatetime()
    {
        return Inx_Apiimpl_TConvert::convert($this->_oData->creationDatetime);
    }


    public function getModificationDatetime()
    {
        return Inx_Apiimpl_TConvert::convert($this->_oData->modificationDatetime);
    }


    public function findSendings()
    {
        return $this->_oSession->getSendingHistoryManager()->findSendingsByMailing($this->getId());
    }


    public function findLastSending()
    {
        return $this->_oSession->getSendingHistoryManager()->findLastSendingForMailing($this->getId());
    }

    public function commitUpdate() {
        throw new Inx_Api_NotImplementedException( "the object does not support this method yet" );
    }

    /**
     * @return Inx_Apiimpl_SplitTestMailing_SplitTestMailingImpl
     */
    public static function convert(Inx_Apiimpl_AbstractSession $oSession, array $oData)
    {
        if (empty($oData))
            return array();

        $aMailings = array();

        for ($i = 0; $i < sizeof($oData); $i++) {
            $aMailings[$i] = new Inx_Apiimpl_SplitTestMailing_SplitTestMailingImpl($oSession, $oData[$i]);
        }

        return $aMailings;
    }

}

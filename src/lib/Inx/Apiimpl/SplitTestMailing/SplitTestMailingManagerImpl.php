<?php

class Inx_Apiimpl_SplitTestMailing_SplitTestMailingManagerImpl implements Inx_Api_SplitTestMailing_SplitTestMailingManager, Inx_Apiimpl_Core_BOResultSetDelegate
{
    /**
     * @var Inx_Apiimpl_AbstractSession
     */
    protected $_oSession;

    /**
     * @var stdClass
     */
    protected $_oService;

    public function __construct(Inx_Apiimpl_AbstractSession $oSession)
    {
        $this->_oSession = $oSession;
        $this->_oService = $this->_oSession->getService(Inx_Apiimpl_SessionContext::SPLIT_TEST_MAILING_SERVICE);
    }

    /**
     * @param int $iId
     * @return Inx_Apiimpl_SplitTestMailing_SplitTestMailingImpl
     * @throws Inx_Api_APIException
     * @throws Inx_Api_DataException
     * @throws Inx_Api_IllegalArgumentException
     */
    public function get($iId)
    {
        if (!is_int($iId))
        {
            throw new Inx_Api_IllegalArgumentException('Integer parameter $iId expected, got ' . gettype($iId));
        }

        try
        {
            $data = $this->_oService->get($this->_oSession->createCxt(), $iId);

            if (empty($data))
                throw new Inx_Api_DataException("No Mailing found for ID: " . $iId);

            return new Inx_Apiimpl_SplitTestMailing_SplitTestMailingImpl($this->_oSession, $data);
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return null;
        }
    }

    /**
     * @return Inx_Apiimpl_Core_DelegateBOResultSet
     */
    public function selectAll()
    {
        try
        {
            $data = $this->_oService->selectAll($this->_oSession->createCxt());
            return new Inx_Apiimpl_Core_DelegateBOResultSet($this->_oSession, $this, $data->remoteRefId, $data->size,
                $data);
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return null;
        }
    }

    /**
     * @param Inx_Apiimpl_RemoteRef $oResultSetRef
     * @param int $iIndex
     * @param int $iDirection
     * @return array of Inx_Apiimpl_SplitTestMailing_SplitTestMailingManagerImpl's
     * @throws Inx_Api_RemoteException
     */
    public function fetchBOs(Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection)
    {
        return Inx_Apiimpl_SplitTestMailing_SplitTestMailingImpl::convert($this->_oSession,
                $this->_oService->fetchBOs($this->_oSession->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection));
    }

    /**
     * @param int $iId
     * @return bool|void
     * @throws Inx_Api_NotImplementedException
     */
    public function remove($iId) {
        throw new Inx_Api_NotImplementedException( "the objects does not support this method yet" );
    }

    /**
     * @param Inx_Apiimpl_RemoteRef $oResultSetRef
     * @param int[] $aIndexRanges
     * @throws Inx_Api_NotImplementedException
     */
    public function removeBOs(Inx_Apiimpl_RemoteRef $oResultSetRef, $aIndexRanges) {
        throw new Inx_Api_NotImplementedException( "the objects does not support this method yet" );
    }
}

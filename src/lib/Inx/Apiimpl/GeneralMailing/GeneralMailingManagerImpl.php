<?php

class Inx_Apiimpl_GeneralMailing_GeneralMailingManagerImpl implements Inx_Api_GeneralMailing_GeneralMailingManager, Inx_Apiimpl_Core_ROBOResultSetDelegate
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
        $this->_oService = $this->_oSession->getService(Inx_Apiimpl_SessionContext::GENERAL_MAILING_SERVICE);
    }

    /**
     * @return Inx_Api_GeneralMailing_GeneralMailingQueryImpl
     */
    public function createQuery()
    {
        return new Inx_Apiimpl_GeneralMailing_GeneralMailingQueryImpl($this->_oSession, $this, $this->_oService);
    }

    public function createRenderer()
    {
        return new Inx_Apiimpl_Rendering_GeneralMailingRendererImpl($this->_oSession);
    }

    public function createRendererForTestRecipient()
    {
        return new Inx_Apiimpl_Rendering_GeneralMailingRendererTestRecipientImpl($this->_oSession);
    }

    /**
     * @return Inx_Apiimpl_GeneralMailing_GeneralMailingImpl
     * @throws Inx_Api_DataException
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

            return new Inx_Apiimpl_GeneralMailing_GeneralMailingImpl($this->_oSession, $data);
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return null;
        }
    }

    /**
     * @return Inx_Apiimpl_Core_DelegateROBOResultSet
     */
    public function selectAll()
    {
        try
        {
            $data = $this->_oService->selectAll($this->_oSession->createCxt());
            return new Inx_Apiimpl_Core_DelegateROBOResultSet($this->_oSession, $this, $data->remoteRefId, $data->size,
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
     * @return array of Inx_Apiimpl_GeneralMailing_GeneralMailingImpl's
     * @throws Inx_Api_RemoteException
     */
    public function fetchBOs(Inx_Apiimpl_RemoteRef $oResultSetRef, $iIndex, $iDirection)
    {
        return Inx_Apiimpl_GeneralMailing_GeneralMailingImpl::convert($this->_oSession,
                $this->_oService->fetchBOs($this->_oSession->createCxt(), $oResultSetRef->refId(), $iIndex, $iDirection));
    }
}

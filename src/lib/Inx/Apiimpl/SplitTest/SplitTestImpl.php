<?php

class Inx_Apiimpl_SplitTest_SplitTestImpl implements Inx_Api_SplitTest_SplitTest
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
        $this->_oService = $this->_oSession->getService(Inx_Apiimpl_SessionContext::SPLIT_TEST_SERVICE);
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


    public function commitUpdate() {
        throw new Inx_Api_NotImplementedException( "the objects does not support this method yet" );
    }

        /**
     * @return Inx_Apiimpl_SplitTest_SplitTestImpl
     */
    public static function convert(Inx_Apiimpl_AbstractSession $oSession, array $oData)
    {
        if (empty($oData))
            return array();

        $aSplitTests = array();

        for ($i = 0; $i < sizeof($oData); $i++) {
            $aSplitTests[$i] = new Inx_Apiimpl_SplitTest_SplitTestImpl($oSession, $oData[$i]);
        }

        return $aSplitTests;
    }

}

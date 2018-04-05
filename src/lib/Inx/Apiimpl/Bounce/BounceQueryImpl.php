<?php

class Inx_Apiimpl_Bounce_BounceQueryImpl implements Inx_Api_Bounce_BounceQuery
{

    private $_oSc;

    private $_oService;

    private $_oDelegate;

    private $_oRc;

    private $_aAttributes;

    private $aMailingIds;

    private $aListIds;

    private $aCategoryIds;

    private $sStartDate;

    private $sEndDate;

    public function __construct(Inx_Apiimpl_SessionContext $oSc, Inx_Apiimpl_Core_BOResultSetDelegate $oDelegate,
                                Inx_Api_Recipient_RecipientContext $oRc = null, array $aAttrs = null)
    {
        $this->_oSc = $oSc;
        $this->_oDelegate = $oDelegate;
        $this->_oService = $oSc->getService(Inx_Apiimpl_SessionContext::BOUNCE3_SERVICE);
        $this->_oRc = $oRc;
        $this->_aAttributes = $aAttrs;
    }

    public function after($sDate)
    {
        $this->sStartDate = $sDate;
        return $this;
    }

    public function before($sDate)
    {
        $this->sEndDate = $sDate;
        return $this;
    }

    public function between($sStartDate, $sEndDate)
    {
        $this->sStartDate = $sStartDate;
        $this->sEndDate = $sEndDate;
    }

    /**
     *
     * @return Inx_Apiimpl_Bounce_BounceDelegateResultSet|null
     */
    public function executeQuery()
    {
        try {
            $attrs = $this->_aAttributes;
            if ($attrs == null) {
                $attrs = array();
            }
            $attrIds = $this->convertAttributesToIds($this->_aAttributes);

            $rcId = "-1";

            /**
             * @var stdClass
             */
            if ($this->_oRc != null) {
                $rcId = $this->_oRc->_remoteRef()->refId();
            }

            $result = $this->_oService->selectBounceGeneric($this->_oSc->createCxt(),
                $this->aListIds, $this->aMailingIds, $this->aCategoryIds, Inx_Apiimpl_TConvert::TConvert($this->sStartDate),
                Inx_Apiimpl_TConvert::TConvert($this->sEndDate), $rcId, $attrIds);
            return new Inx_Apiimpl_Bounce_BounceDelegateResultSet($this->_oSc,
                $this->_oDelegate, $result, $this->_oRc,
                $attrs);
        } catch (Inx_Api_RemoteException $e) {
            $this->_oSc->notify($e);
            return null;
        }
    }

    public function listIds(array $aListIds)
    {
        $this->aListIds = $aListIds;
        return $this;
    }

    public function categoryIds(array $aCategoryIds)
    {
        $this->checkCategoryIdsValid($aCategoryIds);
        $this->aCategoryIds = $aCategoryIds;
        return $this;
    }

    public function mailingIds(array $aMailingIds)
    {
        $this->aMailingIds = $aMailingIds;
        return $this;
    }

    private function convertAttributesToIds(array $aAttrs = null)
    {
        if ($aAttrs == null)
            return array();
        $attrIds = array();
        for ($i = 0; $i < sizeof($aAttrs); $i++)
            $attrIds[$i] = $aAttrs[$i]->getId();
        return $attrIds;
    }

    private function checkCategoryIdsValid(array $aCategoryIds )
    {
        if( $aCategoryIds != null )
        {
            foreach ($aCategoryIds as $categoryId)
            {
                if ($categoryId != Inx_Api_Bounce_Bounce::CATEGORY_HARD_BOUNCE && $categoryId != Inx_Api_Bounce_Bounce::CATEGORY_SOFT_BOUNCE
                && $categoryId != Inx_Api_Bounce_Bounce::CATEGORY_UNKNOWN_BOUNCE
                && $categoryId != Inx_Api_Bounce_Bounce::CATEGORY_AUTO_RESPONDER_BOUNCE
                && $categoryId != Inx_Api_Bounce_Bounce::CATEGORY_SPAM_BOUNCE)
                    throw new Inx_Api_IllegalArgumentException("Invalid bounce category: $categoryId - see Inx_Api_Bounce_Bounce interface for valid bounce categories" );
            }
        }
    }
}
<?php

class Inx_Apiimpl_GeneralMailing_GeneralMailingQueryImpl implements Inx_Api_GeneralMailing_GeneralMailingQuery
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
     * @var Inx_Apiimpl_Core_ROBOResultSetDelegate
     */
    protected $_oDelegate;

    /**
     * @var array Inx_Api_GeneralMailing_MailingType
     */
    protected $_aMailingTypes;

    /**
     * @var array int
     */
    protected $_aListIds;

    /**
     * @var array int
     */
    protected $_aMailingIds;

    /**
     * @var array
     */
    protected $_aMailingNames;

    /**
     * @var array
     */
    protected $_aMailingSubjects;

    /**
     * @var string
     */
    protected $_sCreatedStart;

    /**
     * @var string
     */
    protected $_sCreatedEnd;

    /**
     * @var string
     */
    protected $_sModifiedStart;

    /**
     * @var string
     */
    protected $_sModifiedEnd;

    /**
     * @var int
     */
    protected $_iOrderType;

    /**
     * @var Inx_Api_GeneralMailing_GeneralMailingAttribute
     */
    protected $_oOrderAttribute;

    public function __construct(Inx_Apiimpl_AbstractSession $oSession,
        Inx_Apiimpl_Core_ROBOResultSetDelegate $oDelegate, $oService)
    {
        $this->_oSession = $oSession;
        $this->_oDelegate = $oDelegate;
        $this->_oService = $oService;
    }

    /**
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery
     */
    public function mailingTypes(array $mailingTypes = null)
    {
        if ($mailingTypes != null)
        {
            if (in_array(Inx_Api_GeneralMailing_MailingType::UNKNOWN(), $mailingTypes, true))
            {
                throw new Inx_Api_IllegalArgumentException("MailingTypes must not contain UNKNOWN type!");
            }
        }

		$this->_aMailingTypes = $this->filterNullValues( $mailingTypes );
		return $this;
	}

	/**
	 * @return Inx_Api_GeneralMailing_GeneralMailingQuery
	 */
	public function listIds( array $listIds = null )
	{
		$this->_aListIds = $this->filterNullValues( $listIds );
		return $this;
	}

    /**
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery
     */
    public function mailingIds(array $mailingIds = null)
    {
        $this->_aMailingIds = $this->filterNullValues($mailingIds);
        return $this;
    }

    /**
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery
     */
    public function names(array $mailingNames = null)
    {
        $this->_aMailingNames = $this->filterNullValues($mailingNames);
        return $this;
    }

    /**
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery
     */
    public function subjects(array $mailingSubjects = null)
    {
        $this->_aMailingSubjects = $this->filterNullValues($mailingSubjects);
        return $this;
    }

    public function createdAfter($sSince)
    {
        $this->_sCreatedStart = $sSince;
        return $this;
    }

    public function createdBefore($sUntil)
    {
        $this->_sCreatedEnd = $sUntil;
        return $this;
    }

    public function createdBetween($sStart, $sEnd)
    {
        $this->_sCreatedStart = $sStart;
        $this->_sCreatedEnd = $sEnd;
        return $this;
    }

    public function modifiedAfter($sSince)
    {
        $this->_sModifiedStart = $sSince;
        return $this;
    }

    public function modifiedBefore($sUntil)
    {
        $this->_sModifiedEnd = $sUntil;
        return $this;
    }

    public function modifiedBetween($sStart, $sEnd)
    {
        $this->_sModifiedStart = $sStart;
        $this->_sModifiedEnd = $sEnd;
        return $this;
    }

    /**
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery
     */
    public function sort(Inx_Api_GeneralMailing_GeneralMailingAttribute $orderAttribute, $iOrderType)
    {
        if (null === $orderAttribute)
            throw new Inx_Api_NullPointerException("GeneralMailingAttribute for sorting must not be null!");
        if (Inx_Api_GeneralMailing_GeneralMailingAttribute::UNKNOWN() === $orderAttribute)
            throw new Inx_Api_IllegalArgumentException("GeneralMailingAttribute for sorting must not be UNKNOWN!");
        if ($iOrderType != Inx_Api_Order::ASC && $iOrderType != Inx_Api_Order::DESC)
            throw new Inx_Api_IllegalArgumentException("Order must be Ascending (Order.ASC) or Descending (Order.DESC)!");

        $this->_oOrderAttribute = $orderAttribute;
        $this->_iOrderType = $iOrderType;
        return $this;
    }

    /**
     * @return Inx_Apiimpl_Core_DelegateROBOResultSet
     */
    public function executeQuery()
    {
        $orderAttributeId = Inx_Api_GeneralMailing_GeneralMailingAttribute::MAILING_ID()->getId();

        if (null != $this->_oOrderAttribute)
            $orderAttributeId = $this->_oOrderAttribute->getId();

        if (empty($this->_iOrderType))
            $this->_iOrderType = Inx_Api_Order::ASC;

        $createdStart = Inx_Apiimpl_TConvert::TConvert($this->_sCreatedStart);
        $createdEnd = Inx_Apiimpl_TConvert::TConvert($this->_sCreatedEnd);
        $modifiedStart = Inx_Apiimpl_TConvert::TConvert($this->_sModifiedStart);
        $modifiedEnd = Inx_Apiimpl_TConvert::TConvert($this->_sModifiedEnd);

        try
        {
            $oResult = $this->_oService->find($this->_oSession->createCxt(),
                Inx_Api_GeneralMailing_MailingType::mailingTypeToIdArray($this->_aMailingTypes), $this->_aListIds,
                $this->_aMailingIds, $this->_aMailingNames, $this->_aMailingSubjects, $createdStart, $createdEnd,
                $modifiedStart, $modifiedEnd, $orderAttributeId, $this->_iOrderType);

            return new Inx_Apiimpl_Core_DelegateROBOResultSet($this->_oSession, $this->_oDelegate,
                $oResult->remoteRefId, $oResult->size, $oResult);
        }
        catch (Inx_Api_RemoteException $e)
        {
            $this->_oSession->notify($e);
            return null;
        }
    }

    private static function filterNullValues($given)
    {
        if (is_array($given))
            return array_filter($given, "not_null");

        return $given;
    }
}

function not_null($var)
{
    return( $var != null );
}

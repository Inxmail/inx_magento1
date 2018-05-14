<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */


/**
 * An <i>Inx_Api_DataAccess_ClickData</i> object can be used to retrieve information about a specific click 
 * accessible through an <i>Inx_Api_DataAccess_ClickDataRowSet</i>. 
 * A row set can be obtained using various filters:
 * <ul>
 * <li>mailing: <i>selectByMailing(int, RecipientContext, Attribute[])</i>
 * <li>link: <i>selectByLink(int, RecipientContext, Attribute[])</i>
 * <li>link type: only available in fluent query interface
 * <li>recipient: <i>selectByRecipient(int, RecipientContext, Attribute[])</i>
 * <li>recipient and mailing: <i>selectByRecipientAndMailing(int, int, RecipientContext, Attribute[])</i>
 * <li>before, after and between: various methods for selecting a time span are available
 * <li>sending id: only available in fluent query interface
 * </ul>
 * <p>
 * The basic select methods offer variants to filter the result by date. You can search for click data before or after a
 * specific date or between two specific dates.
 * <p>
 * The following example returns a result set containing click data for the specified mailing and fetches the email
 * address of the recipients:
 * 
 * <pre>
 * $oDataAccess = $oSession->getDataAccess();
 * $oClickData = $oDataAccess->getClickData();
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oEmail = $oRecipientContext->getMetaData()->getEmailAttribute();
 * ...
 * $oClickDataRowSet = $oClickData->selectByMailing( $iMailingId, $oRecipientContext, array($oEmail) );
 * </pre>
 * 
 * API version 1.11.1 allows you to filter by the type of the clicked link and to retrieve all clicks filtered only by
 * date. Offering all possible combinations would have made figuring out which method is the right one a tedious job.
 * Therefore, these filter types are only available using the new fluent style query API. The query API also allows to
 * specify arrays of IDs. The following snippet demonstrates how to filter the clicks by two mailings, two link types
 * and a start date:
 * 
 * <pre>
 * $oDataAccess = $oSession->getDataAccess();
 * $oClickData = $oDataAccess->getClickData();
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oEmail = $oRecipientContext->getMetaData()->getEmailAttribute();
 * 
 * $aMailingIds = array( 1234, 4711 );
 * $aLinkTypes = array( Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNIQUE_COUNT, 
 *      Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_OPENING_COUNT );
 * $sOneDayAgo = date( 'c', strtotime( '-1 day' ) );
 * ...
 * $oClickDataQuery = $oClickData->createQuery( $oRecipientContext, array( $oEmail ) );
 * $oClickDataRowSet = $oClickDataQuery->mailings( $aMailingIds )->linkTypes( $aLinkTypes )->after( $sOneDayAgo )->executeQuery();
 * </pre>
 * 
 * For more information on the data available for clicks, see the <i>Inx_Api_DataAccess_ClickDataRowSet</i> documentation.
 * 
 * @see Inx_Api_DataAccess_DataAccess
 * @see Inx_Api_DataAccess_ClickDataRowSet
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_ClickData
{	
    
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 */
	public function selectByMailing( $iMailingId, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);
	
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByMailingBefore( $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByMailingAfter( $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);

	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified mailing which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByMailingBetween( $iMailingId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc,array $aAttrs = null);
	
	
	
    /**
     * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 */
	public function selectByLink( $iLinkId,Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );

	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByLinkBefore( $iLinkId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByLinkAfter( $iLinkId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );

	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified link which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iLinkId the id of the link.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByLinkBetween( $iLinkId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );
	
    /**
     * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 */
	public function selectByRecipient( $iRecipientId, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );
	
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByRecipientBefore( $iRecipientId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );	
	
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAfter( $iRecipientId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );	
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByRecipientBetween( $iRecipientId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null );	
	
	
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.  
	 */
	public function selectByRecipientAndMailing( $iRecipientId, $iMailingId, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
    /**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing which occurred before the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks before this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAndMailingBefore( $iRecipientId, $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing which occurred after the specified date. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtSearchDate all clicks after this date will be selected. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAndMailingAfter( $iRecipientId, $iMailingId, $dtSearchDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
	/**
	 * This method returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing information about all clicks 
	 * regarding the specified recipient and mailing which occurred between the specified dates. 
	 * If there is no click data, an empty row set will be returned. 
	 * If the <i>Inx_Api_Recipielt_RecipientContext</i> is not null and the <i>Inx_Api_Recipient_Attribute</i> 
	 * array contains at least one element, the retrieved click data will contain information about the recipient 
	 * state and the specified recipient attributes.
	 * 
	 * @param int $iRecipientId the id of the recipient.
	 * @param int $iMailingId the id of the mailing.
	 * @param string $dtStartDate the start date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param string $dtEndDate the end date for the search. 
	 * 				The date has to be formatted as ISO 8601 date string.
	 * @param Inx_Api_Recipient_RecipientContext $oRc	the recipient context. 
	 * 				See <i>Inx_Api_Session->createRecipientContext()</i>
	 * @param array $aAttrs an array of <i>Inx_Api_Recipient_Attribute</i>s that will be fetched for later retrieval. 
	 * 				See <i>Inx_Api_Recipient_RecipientMetaData</i>
	 * @return Inx_Api_DataAccess_ClickDataRowSet an <i>Inx_Api_DataAccess_ClickDataRowSet</i> object that contains 
	 * 				the data produced by the given query.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.6.2
	 */
	public function selectByRecipientAndMailingBetween( $iRecipientId, $iMailingId, $dtStartDate, $dtEndDate, Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs = null);
	
	/**
	 * Creates a query object which allows to retrieve clicks using a fluent interface. Using this object you can filter
	 * the clicks by the following criteria:
	 * <ul>
	 * <li>mailing ID(s)</li>
	 * <li>link ID(s)</li>
	 * <li>recipient ID(s)</li>
	 * <li>link type(s)</li>
	 * <li>start date</li>
	 * <li>end date</li>
	 * </ul>
	 * All filters can be freely combined. IDs can be given as a single <i>int</i> or as an <i>int[]</i>.
	 * The same is true for the link types. This allows the creation of complex queries while the fluent interface keeps
	 * the syntax as concise as possible.
	 * <p>
     * <b>Important note:</b> The Inxmail Professional server will terminate any <i>ClickDataQuery</i> request that 
     * produces an overall result size of over ten million clicks, by default. Any request with a result size above this 
     * threshold will result in a server-side <i>RuntimeException</i>.
	 * 
	 * @param Inx_Api_Recipient_RecipientContext $oRc the <i>RecipientContext</i>. See 
         *      <i>Inx_Api_Session::createRecipientContext()</i>.
	 * @param array $aAttrs an array of recipient attributes that will be fetched for later retrieval. See
	 *      <i>Inx_Api_Recipient_RecipientMetaData</i>.
	 * @return Inx_Api_DataAccess_ClickDataQuery a <i>ClickDataQuery</i> object which allows to retrieve clicks using a 
         *      fluent interface.
         * @throws Inx_Api_NullPointerException if no <i>Inx_Api_Recipient_RecipientContext</i> is provided.
	 * @since API 1.11.1
	 */
	public function createQuery( Inx_Api_Recipient_RecipientContext $oRc, array $aAttrs );
}

<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */
/**
 * An <i>Inx_Api_DataAccess_DataAccess</i> object can be used to retrieve data regarding links and clicks. 
 * Link data can be retrieved using an <i>Inx_Api_DataAccess_LinkData</i> object, click data by using an 
 * <i>Inx_Api_DataAccess_ClickData</i> object. Both can be obtained via this class.
 * <p>
 * An <i>Inx_Api_DataAccess_LinkData</i> object can retrieve link data with the following filters:
 * <ul>
 * <li><i>Link id</i>: fetches a link by its unique identifier.
 * <li><i>Link name</i>: fetches a link by its name.
 * <li><i>Link type</i>: fetches a link by its type.
 * <li><i>Link name set</i>: fetches links which name is set or not set.
 * <li><i>Mailing id</i>: fetches all links used in the specified mailing.
 * <li><i>Recipient id</i>: fetches all links the specified user has clicked.
 * </ul>
 * <p>
 * An <i>Inx_Api_DataAccess_ClickData</i> object can retrieve click data with the following filters:
 * <ul>
 * <li><i>Mailing id</i>: fetches all clicks of links of the specified mailing.
 * <li><i>Recipient id</i>: fetches all clicks performed by the specified recipient.
 * <li><i>Mailing + Recipient id</i>: combination of the two above filters.
 * <li><i>Link id</i>: fetches all clicks of the specified link.
 * <li><i>Link type</i>: fetches all clicks of links of the specified type.
 * <li><i>Sending id</i>: fetches all clicks associated with the sending id.
 * <li><i>Time</i>: fetches all clicks in a certain time span.
 * </ul>
 * All of the click data filters can be combined with a date filter: before, after or between.
 * <p>
 * <i>Inx_Api_DataAccess_LinkData</i> and <i>Inx_Api_DataAccess_ClickData</i> retrieve the information as result set: 
 * <i>Inx_Api_DataAccess_LinkDataRowSet</i> for link data and <i>Inx_Api_DataAccess_ClickDataRowSet</i> for click data. 
 * Using these result sets it is easy to navigate through the data retrieved by the various methods.
 * <p>
 * The following snippet returns an <i>Inx_Api_DataAccess_LinkDataRowSet</i> containing all link data for the given 
 * recipient id:
 * <pre>
 * $oDataAccess = $oSession->getDataAccess();
 * $oLinkData = $oDataAccess->getLinkDataWithNewLinkType();
 * ...
 * $oLinkDataRowSet = $oLinkData->selectByRecipient( $iId );
 * </pre>
 * <p>
 * The following snippet returns an <i>Inx_Api_DataAccess_ClickDataRowSet</i> containing all click data for the given 
 * recipient id:
 * <pre>
 * $oDataAccess = $oSession->getDataAccess();
 * $oClickData = $oDataAccess->getClickData();
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oEmail = $oRecipientContext->getMetaData()->getEmailAttribute();
 * ...
 * ClickDataRowSet rowSet = cd.selectByRecipient( id, rc, new Attribute[]{email} );
 * </pre>
 * <p>
 * API version 1.11.1 allows you to filter by the type of the clicked link and to retrieve all clicks filtered only by
 * date. Offering all possible combinations would have made figuring out which method is the right one a tedious job.
 * Therefore, these filter types are only available using the new fluent query interface. The query API also allows to
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
 * $oClickDataQuery = $oClickData->createQuery( $oRecipientContext, array( email ) );
 * $oClickDataRowSet = $oClickDataQuery->mailings( $aMailingIds )->linkTypes( $aLinkTypes )->after( $sOneDayAgo ).executeQuery();
 * </pre>
 * <p>
 * API version 1.12.1 allows you to filter links with a fluent query interface, similar to the fluent query interface for
 * selecting clicks. Filter options newly available with this API version are only accessible through the new query. The
 * following snipped demonstrates by example how to filter links with the new fluent query interface.:
 * 
 * <pre>
 * $oQuery = session->getDataAccess()->getLinkDataWithNewLinkType()->createQuery();
 * $oResult = $oQuery->linkType(Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNIQUE_COUNT)->
 *      recipientIds(array(1001, 1002))->executeQuery();
 * </pre>
 * <p>
 * Note: All data provided by <i>Inx_Api_DataAccess_DataAccess</i> is read only!
 * <p>
 * For more information about link and click data, see the <i>Inx_Api_DataAccess_LinkData</i> and 
 * <i>Inx_Api_DataAccess_ClickData</i> documentation.
 * 
 * @see Inx_Api_DataAccess_LinkData
 * @see Inx_Api_DataAccess_ClickData
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_DataAccess
{
	/**
	 * Returns the link data object which can used to access the link data.
	 * 
	 * @deprecated old behavior is, that uniquely counted image links are counted as unique links. The new method
	 *             <i>getLinkDataWithNewLinkType()</i> returns them separated in unique-count and opening-count links.
	 * @return Inx_Api_DataAccess_LinkData the link data object.
	 */
	public function getLinkData();


	/**
	 * Returns the link data object which can used to access the link data.<br>
	 * In this method unique counted image links are not counted as unique links. These links have the new type
	 * opening-count.
	 * 
	 * @return Inx_Api_DataAccess_LinkData the link data object.
	 */
	public function getLinkDataWithNewLinkType();


	/**
	 * Returns the click data object which can be used to access the click data.<br>
	 * 
	 * @return Inx_Api_DataAccess_ClickData the click data object.
	 */
	public function getClickData();

}
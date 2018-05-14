<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */
/**
 * An <i>Inx_Api_DataAccess_LinkData</i> object can be used to retrieve information about a specific link 
 * accessible through an <i>Inx_Api_DataAccess_LinkDataRowSet</i>. A row set can be obtained using various filters:
 * <ul>
 * <li>Link id: <i>selectByLink(int)</i>
 * <li>Link name: <i>selectByLinkName(String)</i>
 * <li>Link type: Only available through fluent query interface
 * <li>Link name set: Only available through fluent query interface
 * <li>Mailing id: <i>selectByMailing(int)</i>
 * <li>Recipient id: <i>selectByRecipient(int)</i>
 * </ul>
 * <p>
 * The following example returns a result set containing link data for the specified mailing:
 * <pre>
 * $oDataAccess = $oSession->getDataAccess();
 * $oLinkData = $oDataAccess->getLinkDataWithNewLinkType();
 * ...
 * $oLinkDataRowSet = $oLinkData->selectByMailing( $iMailingId, FALSE );
 * </pre>
 * 
 * API version 1.12.1 allows you to filter by the type of the link or whether a link name is set at all, in addition to
 * all previous filter possibilities. Offering all possible combinations would have made figuring out which method is
 * the right one a tedious job. Therefore, these filter types are only available using the new fluent style query API.
 * The query API also allows to specify arrays of IDs. The following snippet demonstrates how to filter the links by two
 * mailings, two link types and a recipient:
 * 
 * <pre>
 * $oDa = $oSession->getDataAccess();
 * $oLd = $oDa->getLinkDataWithNewLinkType();
 * $oQuery = $oLd->createQuery();
 * 
 * $aMailingIds = array( 1234, 4711);
 * $aLinkTypes = array(
 *          Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_REDIRECT,
 *          Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_OPENING_COUNT,
 *          Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNIQUE_COUNT);
 * $aRecipientIds = array( 567 );
 * 
 * $oRowSet = $oQuery->mailings( $aMailingIds )->linkTypes( $aLinkTypes )->recipients( $aRecipientIds )->executeQuery();
 * </pre>
 * 
 * For more information on the data available for links, see the <i>Inx_Api_DataAccess_LinkDataRowSet</i> documentation.
 * 
 * @see Inx_Api_DataAccess_DataAccess
 * @see Inx_Api_DataAccess_LinkDataRowSet
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_LinkData
{	
    /**
     * This method returns a row set containing information about all links in the specified mailing. If there is no
	 * link data, an empty row set will be returned.
	 * 
	 * @param $iMailingId the id of the mailing.
	 * @param boolean $bPermanentLinksOnly indicates whether the query will include permanent links only.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query. 
	 */
	public function selectByMailing( $iMailingId, $bPermanentLinksOnly = false );
	
	
	/**
	 * This method returns a row set containing information about the specified link. If there is no link data, an empty
	 * row set will be returned.
	 * 
	 * @param in $iLinkId the id of the link.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query.
	 */
	public function selectByLink( $iLinkId );
	
	
	/**
	 * This method returns a row set containing information about all links that were clicked by the given recipient. If
	 * there is no link data, an empty row set will be returned.
	 * 
	 * @param int $iRecipient the id of the recipient.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query.
	 */	
	public function selectByRecipient( $iRecipient );
	
	
	/**
	 * This method returns a row set containing information about all links with the given name. If there is no link
	 * data, an empty row set will be returned.
	 * 
	 * @param string $linkName the name of the link.
	 * @param boolean $bPermanentLinksOnly indicates whether the query will include permanent links only.
	 * @return Inx_Api_DataAccess_LinkDataRowSet an <i>Inx_Api_DataAccess_LinkDataRowSet</i> object that contains the 
	 * data produced by the given query.
	 */	
	public function selectByLinkName( $linkName, $bPermanentLinksOnly = false );
	
        /**
	 * Creates a query object which allows to retrieve links using a fluent interface. Using this object you can filter
	 * the links by the following criteria:
	 * <ul>
	 * <li>mailing IDs
	 * <li>recipient IDs
	 * <li>link IDs
	 * <li>link types
	 * <li>link names
	 * <li>is link name set
	 * <li>permanent links only
	 * </ul>
	 * All filters can be freely combined. Most parameters shall be given as an array.
	 * This allows the creation of complex queries while the fluent interface keeps
	 * the syntax as concise as possible.
	 * 
	 * @return Inx_Api_DataAccess_LinkDataQuery a <i>LinkDataQuery</i> object which allows to retrieve links using a fluent interface.
	 * @since API 1.12.1
	 */
	public function createQuery();
}

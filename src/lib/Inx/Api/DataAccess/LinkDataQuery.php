<?php
/**
 * <i>LinkDataQuery</i> provides a fluent interface for retrieving link data. The following criteria can be used
 * to filter the links:
 * <ul>
 * <li>mailing IDs
 * <li>link IDs
 * <li>recipient IDs
 * <li>link types
 * <li>link names
 * <li>link name set
 * <li>permanent links only
 * </ul>
 * Each filter is assigned by calling the corresponding method. All filters can be freely combined.
 * Most parameters shall be given as an array. This allows the creation of complex queries while the fluent interface
 * keeps the syntax as concise as possible.
 * <p>
 * It is possible to set each filter multiple times, but each subsequent set call will overwrite the previous
 * configuration of this filter.
 * <p>
 * <b>Important note:</b> The Inxmail Professional server will terminate any <i>ClickDataQuery</i> request that 
 * produces an overall result size of over ten million links, by default. Any request with a result size above this 
 * threshold will result in a server-side <i>RuntimeException</i>.
 * <p>
 * The following snippet demonstrates how simple it is to retrieve all links which are of a certain type and have been
 * clicked by specific members:
 * 
 * <pre>
 * $oQuery = session->getDataAccess()->getLinkDataWithNewLinkType()->createQuery();
 * $oResult = $oQuery->linkTypes(aray(Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNIQUE_COUNT))->
 *      recipientIds(array(1001, 1002))->executeQuery();
 * </pre>
 * <p>
 * For more information about link data, see the {@link Inx_Api_DataAccess_LinkData} documentation.
 * 
 * @see Inx_Api_DataAccess_LinkData
 * @since API 1.12.1
 */
interface Inx_Api_DataAccess_LinkDataQuery
{
	/**
	 * Assigns a mailing filter for mailings, overwriting any existing mailing filters. The result will only
	 * contain links which are part of the given mailings. Invalid mailing IDs will be ignored.
	 * 
	 * @param $aMailingIds the IDs of the mailings by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_LinkDataQuery this query.
	 */
	public function mailingIds( array $aMailingIds = null );


	/**
	 * Assigns a link filter for links, overwriting any existing link filters. The filter matches all links with
	 * the given link IDs. The result will contain the links with the given link IDs. Invalid link IDs will be ignored.
	 * 
	 * @param $aLinkIds the IDs of the links by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_LinkDataQuery this query.
	 */
	public function linkIds( array $aLinkIds = null );


	/**
	 * Assigns a link type filter for link types, overwriting any existing link type filter. The result will
	 * contain only links of the given types.
	 * 
	 * @param $aLinkTypes the link types by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_LinkDataQuery this query.
     * @throws Inx_Api_IllegalArgumentException if at least one of the given link types is not one of the link types 
     *      specified in <i>Inx_Api_DataAccess_LinkDataRowSet</i>, excluding LINK_TYPE_UNKNOWN.
	 */
	public function linkTypes( array $aLinkTypes = null );


	/**
	 * Assigns a recipient filter for recipients, overwriting any existing recipient filters. The result will
	 * contain all links which have been clicked by at least one of the given recipients. Invalid recipient IDs will be
	 * ignored.
	 * 
	 * @param $aRecipientIds the ID of the recipient by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_LinkDataQuerythis query.
	 */
	public function recipientIds( array $aRecipientIds = null );


	/**
	 * Assigns a link name filter for link names, overwriting any existing link name filters. The result
	 * contains all links where the names (alias) of the link is equal to any given link name. If this method is not
	 * called at all or called with <i>null</i> this filter doesn't apply.
	 * 
	 * @param $aLinkNames the link names by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_LinkDataQuery this query.
	 */
	public function linkNames( array $aLinkNames = null );


	/**
	 * Assigns a link name set filter for filtering whether link name has a value or is <i>null</i>, overwriting
	 * any existing link name set filters. If <i>TRUE</i>, the result only contains links with a set name, which
	 * means <i>not null</i>. If <i>FALSE</i>, the result only contains links where the link name is
	 * <i>null</i>. If the method is not called at all or called with <i>null</i> this filter doesn't apply.
	 * 
	 * @param $blLinkNameSet defines whether a link name must be set or not.
	 * @return Inx_Api_DataAccess_LinkDataQuery this query.
	 */
	public function linkNameSet( $blLinkNameSet );


	/**
	 * Assigns a link filter for filtering permanent links, overwriting any existing permanent link filter. If called,
	 * the query result will contain permanent links only. This is the default behaviour.
	 * 
	 * @return Inx_Api_DataAccess_LinkDataQuery this query.
	 */
	public function permanentLinksOnly();


	/**
	 * Assigns a link filter for filtering permanent links, overwriting any existing permanent link filter. If called,
	 * the result may contain temporary links. If the method is not called, the result will include permanent links
	 * only.
	 * 
	 * @return Inx_Api_DataAccess_LinkDataQuery this query.
	 */
	public function permanentAndTemporaryLinks();


	/**
	 * Executes the query, applying all filters and returning the resulting <i>LinkDataRowSet</i>.
	 * 
	 * @return Inx_Api_DataAccess_LinkDataRowSet a <i>LinkDataRowSet</i> object that contains the data produced by this query.
	 */
	public function executeQuery();
}

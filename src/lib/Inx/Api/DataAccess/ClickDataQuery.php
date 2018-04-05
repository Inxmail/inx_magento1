<?php
/**
 * <i>Inx_Api_DataAccess_ClickDataQuery</i> provides a fluent interface for retrieving click data. The following criteria can be used
 * to filter the clicks:
 * <ul>
 * <li>mailing ID(s)</li>
 * <li>link ID(s)</li>
 * <li>recipient ID(s)</li>
 * <li>link type(s)</li>
 * <li>start date</li>
 * <li>end date</li>
 * <li>sending ID(s) (since API 1.12.1)</li>
 * </ul>
 * Each filter is assigned by calling the corresponding method. All filters can be freely combined. IDs can be given as
 * either a single <i>int</i> or as an <i>int[]</i> by choosing the appropriate method (singular versus plural). The same 
 * is true for the link types. This allows the creation of complex queries while the fluent interface keeps the syntax as 
 * concise as possible.
 * <p>
 * <b>Note:</b> Each filter may only be applied once. For example, it is not possible to create a query that retrieves all 
 * clicks of two time periods (e.g. all clicks performed during February and during September). However, applying a filter 
 * twice (i.e. calling the corresponding method twice) is not an error. The last application (method call) of the filter 
 * will always overwrite all previous applications.
 * <p>
 * <b>Important note:</b> The Inxmail Professional server will terminate any <i>ClickDataQuery</i> request that 
 * produces an overall result size of over ten million clicks, by default. Any request with a result size above this 
 * threshold will result in a server-side <i>RuntimeException</i>.
 * <p>
 * The following snippet demonstrates how simple it is to retrieve all clicks which have been performed after a certain
 * date. The last two lines show the actual creation and execution of the query:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $aAttrs = array( $oRecipientContext->getMetaData()->getEmailAttribute() );
 * $sStart = date( 'c', strtotime( '-1 day ) );
 * 
 * $oClickDataQuery = $oSession->getDataAccess()->getClickData()->createQuery( $oRecipientContext, $aAttrs );
 * $oClickDataRowSet = $oClickDataQuery->after( $sStart )->executeQuery();
 * </pre>
 * 
 * To demonstrate the power of this approach, the following snippet combines most of the available filters, thus
 * retrieving all clicks for the given mailings, recipients and link types, which occurred during February 2013:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $aAttrs = array( $oRecipientContext->getMetaData()->getEmailAttribute() ); 
 * $sStart = date( 'c', mktime( 0, 0, 0, 2, 1, 2013 ) );
 * $sEnd = date( 'c', mktime( 23, 59, 59, 2, 23, 2013 ) );
 * 
 * $aMailingIds = array( 1234, 4711 );
 * $aRecipientIds = array( 2, 3, 5, 7, 11, 13, 17 );
 * $aLinkTypes = array( Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_UNIQUE_COUNT, 
 *      Inx_Api_DataAccess_LinkDataRowSet::LINK_TYPE_OPENING_COUNT );
 * 
 * $oClickDataQuery = $oSession->getDataAccess()->getClickData()->createQuery( $oRecipientContext, $aAttrs );
 * $oClickDataRowSet = $oClickDataQuery->mailings( $aMailingIds )->recipients( $aRecipientIds )->linkTypes( 
 *      $aLinkTypes )->between( $sStart, $sEnd )->executeQuery();
 * </pre>
 * 
 * Note: Usually, it makes no sense to filter by mailing or link type when you are already filtering by individual
 * links, as this is just redundant information. Therefore the example above did not filter by any links. This can be
 * achieved analogical.
 * <p>
 * For more information about click data, see the <i>Inx_Api_DataAccess_ClickData</i> documentation.
 * 
 * @see Inx_Api_DataAccess_ClickData
 * @since API 1.11.1
 * @author chge, 03.04.2013
 */
interface Inx_Api_DataAccess_ClickDataQuery
{
	/**
	 * Assigns a mailing filter for a single mailing, overwriting any existing mailing filters. The result will only
	 * contain clicks on links which are part of the given mailing. Invalid mailing IDs will be ignored.
	 * 
         * @param int $iMailingId the ID of the mailing by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function mailing( $iMailingId );


	/**
	 * Assigns a mailing filter for several mailings, overwriting any existing mailing filters. The result will only
	 * contain clicks on links which are part of the given mailings. Invalid mailing IDs will be ignored.
	 * 
	 * @param array $aMailingIds the IDs of the mailings by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function mailings( array $aMailingIds );


	/**
	 * Assigns a link filter for a single link, overwriting any existing link filters. The result will only contain
	 * clicks on the given link. Invalid link IDs will be ignored.
	 * 
	 * @param int $iLinkId the ID of the link by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function link( $iLinkId );


	/**
	 * Assigns a link filter for several links, overwriting any existing link filters. The result will only contain
	 * clicks on the given links. Invalid link IDs will be ignored.
	 * 
	 * @param array $aLinkIds the IDs of the links by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function links( array $aLinkIds );


	/**
	 * Assigns a recipient filter for a single recipient, overwriting any existing recipient filters. The result will
	 * only contain clicks performed by the given recipient. Invalid recipient IDs will be ignored.
	 * 
	 * @param int $iRecipientId the ID of the recipient by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function recipient( $iRecipientId );


	/**
	 * Assigns a recipient filter for several recipients, overwriting any existing recipient filters. The result will
	 * only contain clicks performed by the given recipients. Invalid recipient IDs will be ignored.
	 * 
	 * @param array $aRecipientIds the IDs of the recipients by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function recipients( array $aRecipientIds );


	/**
	 * Assigns a link type filter for a single link type, overwriting any existing link type filters. The result will
	 * only contain clicks on links of the given type. Invalid link types will raise an Inx_Api_IllegalArgumentException.
	 * 
	 * @param int $iLinkType the link type by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
         * @throws Inx_Api_IllegalArgumentException if the given link type is not one of the link types specified in
	 *      <i>Inx_Api_DataAccess_LinkDataRowSet</i>, excluding LINK_TYPE_UNKNOWN.
	 */
	public function linkType( $iLinkType );


	/**
	 * Assigns a link type filter for several link types, overwriting any existing link type filters. The result will
	 * only contain clicks on links of the given types. Invalid link types will raise an Inx_Api_IllegalArgumentException.
	 * 
	 * @param array $aLinkTypes the link types by which the result shall be filtered.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
         * @throws Inx_Api_IllegalArgumentException if at least one of the given link types is not one of the link types 
         *      specified in <i>Inx_Api_DataAccess_LinkDataRowSet</i>, excluding LINK_TYPE_UNKNOWN.
	 */
	public function linkTypes( array $aLinkTypes );
        
        /**
         * Assigns a sending ID filter for a single sending ID, overwriting any existing sending ID filters. The result will
         * only contain clicks associated with this sending.
         * 
         * @param int $iSendingId the sending ID by which the result shall be filtered.
         * @return Inx_Api_DataAccess_ClickDataQuery this query.
         */
        public function sending( $iSendingId );
        
        /**
         * Assigns a sending ID filter for several sending IDs, overwriting any exsiting sending ID filters. The result will
         * contain only clicks associated with these sendings.
         * 
         * @param array $aSendingIds the sending IDs by which the result shall be filtered.
         * @return Inx_Api_DataAccess_ClickDataQuery this query.
         */
        public function sendings( array $aSendingIds );


	/**
	 * Assigns a before filter (end date), overwriting any existing before filters, including those imposed by between
	 * filters. The result will only contain clicks performed before or at the given date.
	 * 
	 * @param string $sDate the date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function before( $sDate );


	/**
	 * Assigns an after filter (start date), overwriting any existing after filters, including those imposed by between
	 * filters. The result will only contain clicks performed after or at the given date.
	 * 
	 * @param string $sDate the date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function after( $sDate );


	/**
	 * Assigns a between filter (start and end date), overwriting any existing before, after and between filters. The
	 * result will only contain clicks performed after or at the given start date and before or at the given end date.
	 * 
	 * @param string $sStart the start date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @param string $sEnd the end date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @return Inx_Api_DataAccess_ClickDataQuery this query.
	 */
	public function between( $sStart, $sEnd );


	/**
	 * Executes the query, applying all filters and returning the resulting <i>ClickDataRowSet</i>.
	 * <p>
     * <b>Important note:</b> The Inxmail Professional server will terminate any <i>ClickDataQuery</i> request that 
     * produces an overall result size of over ten million clicks, by default. Any request with a result size above this 
     * threshold will result in a server-side <i>RuntimeException</i>.
	 *
	 * @return Inx_Api_DataAccess_ClickDataRowSet a <i>ClickDataRowSet</i> object that contains the data produced by this query.
	 */
	public function executeQuery();
}

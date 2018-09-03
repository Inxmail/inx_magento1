<?php

/**
 * @package Inxmail
 * @subpackage GeneralMailing
 */

/**
 * The <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> object is used for constructing and executing general mailing queries.
 * The following filters can be defined:
 * <ul>
 * <li>Mailing IDs</li>
 * <li>Mailing types</li>
 * <li>Mailing names</li>
 * <li>Mailing subjects</li>
 * <li>Earliest mailing creation date</li>
 * <li>Latest mailing creation date</li>
 * <li>Earliest mailing modification date</li>
 * <li>Latest mailing modification date</li>
 * <li>List ids</li>
 * </ul>
 * The defined filters are additive (logical AND) but allow any field value if undefined.
 * In addition, the query can define a result ordering by any <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i>.
 * The methods implement a fluent API and thus can be chained.
 * <p>
 * It is possible to set each filter multiple times, but each subsequent set call will overwrite the previous configuration of this filter.
 * <p>
 * An empty <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> object can be obtained from the <i>Inx_Api_GeneralMailing_GeneralMailingManager</i>.
 * <p>
 * The following snippet shows how to construct and execute a query for all regular and split-test mailings of a particular list, ordered ascending by mailing name:
 *
 * <pre>
 * $oGeneralMailingManager = $oSession->getGeneralMailingManager();
 * $oGeneralMailingQuery = $oGeneralMailingManager->createQuery();
 *
 * $aMailingTypes = array( Inx_Api_GeneralMailing_MailingType::REGULAR_MAILING(),
 *      Inx_Api_GeneralMailing_MailingType::SPLIT_TEST_MAILING() );
 * $aListIds = array( 3 );
 *
 * $oROBOResultSet = $oGeneralMailingQuery->mailingTypes( $aMailingTypes )->listIds( $aListIds )
 *      ->sort(	Inx_Api_GeneralMailing_GeneralMailingAttribute::NAME(), Inx_Api_Order::ASC )
 *      ->executeQuery();
 *
 * foreach( $oROBOResultSet as $oMailing )
 * {
 * 	echo $oMailing->getName()."&#60;br&#62;";
 * }
 *
 * $oROBOResultSet->close();
 * </pre>
 * <p>
 * <b>Note:</b> The Inxmail server will check the session user's access permissions in any case and thus will provide accessible mailings only.
 * <p>
 *
 * @since API 1.11.10
 */
interface Inx_Api_GeneralMailing_GeneralMailingQuery
{

    /**
     * Sets the filter for <i>Inx_Api_GeneralMailing_MailingType</i>s.
     * The resulting <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings of the given <i>$types</i> only.
     * Any previously set <i>Inx_Api_GeneralMailing_MailingType</i> filter will be overwritten.
     * <p>
     * If <i>null</i> or an empty array is provided, this will reset the <i>Inx_Api_GeneralMailing_MailingType</i> filter.
     * <p>
     * <i>null</i> values in the given <i>$types</i> will be ignored.
     *
     * @param array $types the <i>Inx_Api_GeneralMailing_MailingType</i>s to be set as filter
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>
     * @throws Inx_Api_IllegalArgumentException if one of the provided types is <i>Inx_Api_GeneralMailing_MailingType::UNKNOWN</i>
     */
    public function mailingTypes(array $types = null);

    /**
     * Sets the filter for list IDs. The resulting <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings from the given lists only.
     * Any previously set list filter will be overwritten.
     * <p>
     * If <i>null</i> or an empty array is provided, this will reset the list filter.
     * <p>
     * Invalid or inexistent listIds will be included in the query. The resultset will be empty if there had been no valid list ID.
     * <p>
     * <b>Note:</b> If this filter includes the ID of an inaccessible list, this will cause a <i>Inx_Api_SecurityException</i> during query execution.
     *
     * @param array $listIds the IDs of the lists to be set as filter
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>
     */
    public function listIds(array $listIds = null);

    /**
     * Sets the filter for mailing IDs. The resulting <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings with the given IDs only.
     * Any previously set mailing ID filter will be overwritten.
     * <p>
     * If <i>null</i> or an empty array is provided, this will reset the mailing ID filter.
     * <p>
     * Invalid or inexistent mailing IDs will be included in the query.
     * The resultset will be empty if there had been no valid mailing ID.
     * <p>
     * <b>Note:</b> If this filter includes the ID of a mailing whose list is inaccessible, this will cause a <i>Inx_Api_SecurityException</i> during query execution.
     *
     * @param array $mailingIds the mailing IDs to be set as filter
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>
     */
    public function mailingIds(array $mailingIds = null);



	/**
	 * Sets the filter for mailing names. The resulting <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings matching any given name only.
	 * Any previously set mailing name filter will be overwritten.
	 * <p>
	 * If <i>null</i> or an empty array is provided, this will reset the mailing name filter.
	 * <p>
	 * <i>null</i> values in the given <i>$names</i> will be ignored.
	 * If an empty String is provided, it will be included in the query.
	 *
	 * @param array $names the mailing names to be set as filter
	 * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>
	 */
	public function names( array $names = null );

    /**
     * Sets the filter for mailing subjects. The resulting <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will
     * provide mailings matching any given subject only. Any previously set mailing subject filter will be overwritten.
     * <p>
     * If <i>null</i> or an empty array is provided, this will reset the mailing subject filter.
     * <p>
     * <i>null</i> values in the given <i>subjects</i> will be ignored. If an empty String is provided, it will be
     * included in the query.
     *
     * @param array() of string $subjects the mailing subjects to be set as filter
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>GeneralMailingQuery</i>
     */
    public function subjects(array $subjects = null);

    /**
     * Sets the filter for earliest mailing creation date. The resulting
     * <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings created at and after the given date only.
     * Any previously set earliest mailing creation date filter will be overwritten.
     * <p>
     * If <i>null</i> is provided, this will reset the earliest mailing creation date filter.
     *
     * @param string $sSince the creation date to be set as filter. The date has to be formatted as an ISO 8601 date
     * string.
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>GeneralMailingQuery</i>
     */
    public function createdAfter($sSince);

    /**
     * Sets the filter for latest mailing creation date. The resulting <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>
     * will provide mailings created at and before the given date only. Any previously set latest mailing creation date
     * filter will be overwritten.
     * <p>
     * If <i>null</i> is provided, this will reset the latest mailing creation date filter.
     *
     * @param string $sUntil the creation date to be set as filter. The date has to be formatted as an ISO 8601 date
     * string.
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>GeneralMailingQuery</i>
     */
    public function createdBefore($sUntil);

    /**
     * Sets the filters for earliest and latest mailing creation dates. The resulting
     * <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings created at and between the given dates.
     * Any previously set creation date filter (earliest and latest) will be overwritten.
     * <p>
     * If <i>null</i> is provided as start date, this will reset the earliest mailing creation date filter. If
     * <i>null</i> is provided as end date, this will reset the latest mailing creation date filter.
     *
     * @param string $sStart the date to be set as earliest mailing creation date filter. The date has to be formatted
     * as an ISO 8601 date string.
     * @param string $sEnd the date to be set as latest mailing creation date filter. The date has to be formatted as an
     * ISO 8601 date string.
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>GeneralMailingQuery</i>
     */
    public function createdBetween($sStart, $sEnd);

    /**
     * Sets the filter for earliest mailing modification date. The resulting
     * <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings modified at and after the given date
     * only. Any previously set earliest mailing modification date filter will be overwritten.
     * <p>
     * If <i>null</i> is provided, this will reset the earliest mailing modification date filter.
     *
     * @param string $sSince the modification date to be set as filter. The date has to be formatted as an ISO 8601 date
     * string.
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>GeneralMailingQuery</i>
     */
    public function modifiedAfter($sSince);

    /**
     * Sets the filter for latest mailing modification date. The resulting
     * <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings modified at and before the given date
     * only. Any previously set latest mailing modification date filter will be overwritten.
     * <p>
     * If <i>null</i> is provided, this will reset the latest mailing modification date filter.
     *
     * @param string $sUntil the modification date to be set as filter. The date has to be formatted as an ISO 8601 date
     * string.
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>GeneralMailingQuery</i>
     */
    public function modifiedBefore($sUntil);

    /**
     * Sets the filters for earliest and latest mailing modification dates. The resulting
     * <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will provide mailings modified at and between the given dates.
     * Any previously set modification date filter (earliest and latest) will be overwritten.
     * <p>
     * If <i>null</i> is provided as start date, this will reset the earliest mailing modification date filter. If
     * <i>null</i> is provided as end date, this will reset the latest mailing modification date filter.
     *
     * @param string $sStart the date to be set as earliest mailing modification date filter. The date has to be
     * formatted as an ISO 8601 date string.
     * @param string $sEnd the date to be set as latest mailing modification date filter. The date has to be formatted
     * as an ISO 8601 date string.
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>GeneralMailingQuery</i>
     */
    public function modifiedBetween($sStart, $sEnd);

    /**
     * Sets ordering attribute and ordering direction.
     * The resulting <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i> will be ordered by the provided <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i> in the specified <i>Inx_Api_Order</i>.
     * Any previously set ordering will be overwritten.
     * <p>
     * If <i>null</i> is provided as <i>$attribute</i>, this will cause a <i>Inx_Api_NullPointerException</i>.
     *
     * @param Inx_Api_GeneralMailing_GeneralMailingAttribute $attribute the <i>Inx_Api_GeneralMailing_GeneralMailingAttribute</i> to be ordered by
     * @param int $iOrderType the <i>Inx_Api_Order</i> direction
     * @return Inx_Api_GeneralMailing_GeneralMailingQuery the modified <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>
     * @throws Inx_Api_IllegalArgumentException if the provided <i>$attribute</i> is <i>Inx_Api_GeneralMailing_GeneralMailingAttribute::UNKNOWN</i> or if the provided <i>$iOrderType</i> is invalid
     * @throws Inx_Api_NullPointerException if the provided <i>$attribute</i> is <i>null</i>
     */
    public function sort(Inx_Api_GeneralMailing_GeneralMailingAttribute $attribute, $iOrderType);

    /**
     * Executes this <i>Inx_Api_GeneralMailing_GeneralMailingQuery</i>.
     * Returns a <i>ROBOResultSet</i> in the specified order containing all <i>Inx_Api_GeneralMailing_GeneralMailing</i>s, that pass all specified filters.
     * <p>
     * Unspecified filters are ignored, any value will pass for their fields.
     * All specified filters are combined with a logical AND.
     *
     * @return Inx_Api_ROBOResultSet A <i>Inx_Api_ROBOResultSet</i> containing all <i>Inx_Api_GeneralMailing_GeneralMailing</i>s, that pass all specified filters
     * @throws Inx_Api_SecurityException if an explicitly requested list is not accessible by the session user
     */
    public function executeQuery();
}

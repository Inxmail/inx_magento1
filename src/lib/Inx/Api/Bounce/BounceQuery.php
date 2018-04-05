<?php

/**
 * <i>BounceQuery</i> provides a fluent interface for retrieving bounces. The following criteria can be used to
 * filter bounces:
 * <ul>
 * <li>mailing ID(s)
 * <li>list ID(s)
 * <li>category ID(s)
 * <li>start date
 * <li>end date
 * </ul>
 * Each filter is assigned by calling the corresponding method. All filters can be freely combined. IDs can be given as
 * an <i>int[]</i>. This allows the creation of complex queries while the fluent interface
 * keeps the syntax as concise as possible.
 * <p>
 * <b>Note:</b> Each filter may only be applied once. For example, it is not possible to create a query that
 * retrieves all bounces of two time periods (e.g. all bounces performed during February and during September). However,
 * applying a filter twice (i.e. calling the corresponding method twice) is not an error. The last application (method
 * call) of the filter will always overwrite all previous applications.
 * <p>
 * An empty <i>Inx_Api_Bounce_BounceQuery</i> object can be obtained from the <i>Inx_Api_Bounce_BounceManager</i>.
 * <p>
 * The following snippet shows how to construct and execute a query for two particular lists with bounce category hard
 * bounce and soft bounce:
 *
 * <pre>
 * $oBounceManager = $oSession->getBounceManager();
 * $oBounceQuery = $oBounceManager->createQuery();
 *
 * $aListIds = array(3, 5);
 * $aCategoryIds = array(Inx_Api_Bounce_Bounce::CATEGORY_HARD_BOUNCE, Inx_Api_Bounce_Bounce::CATEGORY_AUTO_RESPONDER_BOUNCE);
 *
 * $oBOResultSet = $oBounceQuery->listIds($aListIds)->categoryIds($aCategoryIds)->executeQuery();
 *
 * foreach( $oBOResultSet as $oBounce )
 *	{
 *		echo $oBounce->getSender()."&#60;br&#62;";
 *	}
 *	
 * $oBOResultSet->close();
 * </pre>
 * <p>
 */
interface Inx_Api_Bounce_BounceQuery 
{
	/**
	 * Assigns a mailing filter for one or several mailings, overwriting any existing mailing filters. The result will only
	 * contain bounces which were received in reply to these mailings. Invalid mailing IDs will be ignored.
	 * 
	 * @param array $aMailingIds the IDs of the mailings by which the result shall be filtered.
	 * @return Inx_Api_Bounce_BounceQuery this query.
	 */
	public function mailingIds( array $aMailingIds );


	/**
	 * Assigns a list filter for one or several lists, overwriting any existing list filter. The result will only contain
	 * bounces which were received in reply to mailings from the given lists. Invalid list IDs will be ignored.
	 * 
	 * @param array $aListIds the IDs of the lists by which the result shall be filtered.
	 * @return Inx_Api_Bounce_BounceQuery this query
	 */
	public function listIds( array $aListIds );

    /**
     * Assigns a category filter for one or several categories, overwriting any existing category filter. The result
     * will only contain bounces which are received as a reply to mailings from the given categories.
     * For invalid category IDs an Inx_Api_IllegalArgumentException will be thrown.
     *
     * @param array $aCategoryIds the IDs of the categories by which the result shall be filtered.
     * @return Inx_Api_Bounce_BounceQuery this query
     * @throws Inx_Api_IllegalArgumentException if a category ID is invalid.
     */
    public function categoryIds( array $aCategoryIds );

	/**
	 * Assigns an before filter (end date), overwriting any existing before filters, including those imposed by between
	 * filters. The result will only contain bounces that happened before or at the given date.
	 * 
	 * @param string $sDate the date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @return Inx_Api_Bounce_BounceQuery this query.
	 */
	public function before( $sDate );


	/**
	 * Assigns an after filter (start date), overwriting any existing after filters, including those imposed by between
	 * filters. The result will only contain bounces that happened at or after the given date.
	 * 
	 * @param string $sDate the date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @return Inx_Api_Bounce_BounceQuery this query.
	 */
	public function after( $sDate );


	/**
	 * Assigns a between filter (start and end date), overwriting any existing before, after and between filters. The
	 * result will only contain bounces performed after or at the given start date and before or at the given end date.
	 * 
	 * @param string $sStart the start date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @param string $sEnd the end date by which the result shall be filtered, inclusively. The date has to be specified as 
         * ISO-8601 formatted datetime string.
	 * @return Inx_Api_Bounce_BounceQuery this query.
	 */
	public function between( $sStart, $sEnd );


	/**
	 * Executes the query, applying all filters and returning the resulting <i>BOResultSet</i>.
	 * 
	 * @return Inx_Apiimpl_Bounce_BounceDelegateResultSet a <i>BounceDelegateResultSet</i> object that contains the bounce data retrieved by this query.
	 * @throws Inx_Api_SecurityException if the user does not have permission to access the errormail agent
         */
	public function executeQuery();
}


<?php
/**
 * An <i>Inx_Api_ROBOResultSet</i> is effectively a list of <i>Inx_Api_ReadOnlyBusinessObject</i>s. 
 * The result set can be used to browse through this list.
 * <p>
 * Same as <i>Inx_Api_BOResultSet</i>, <i>Inx_Api_ROBOResultSet</i> implements <i>Iterator</i>. This enables you
 * to use a for-each loop on an <i>Inx_Api_ROBOResultSet</i>.
 * <p>
 * <b>Note:</b> An <i>Inx_Api_ROBOResultSet</i> object <b>must</b> be closed once it is not needed
 * anymore to prevent memory leaks and other potentially harmful side effects.
 * <p>
 * The following snippet demonstrates the preferable way to iterate over an <i>Inx_Api_ROBOResultSet</i>:
 * 
 * <pre>
 * $oSendings = $oSession->getSendingHistoryManager()->selectAll();
 * 
 * foreach( $oSendings as $oSending )
 * {
 * 	echo 'Mailing ' . $oSending->getMailingId() . ' has been sent to: '
 *          . implode( ',', $oSending->getRecipientIDs() ) . '&lt;br&gt;';
 * }
 * 
 * $oSendings->close();
 * </pre>
 * 
 * @see Inx_Api_BOResultSet
 * @author chge, 14.08.2013
 * @since API 1.11.1
 */
interface Inx_Api_ROBOResultSet extends Iterator
{
        /**
	 * Returns the <i>Inx_Api_ReadOnlyBusinessObject</i> with the specified index.
	 * 
	 * @param int $iIndex the index of the <i>Inx_Api_ReadOnlyBusinessObject</i> to retrieve in this result set.
	 * @return Inx_Api_ReadOnlyBusinessObject the <i>ReadOnlyBusinessObject</i> with the specified index.
	 * @throws DataException if no <i>Inx_Api_ReadOnlyBusinessObject</i> could be found (e.g. the object was deleted).
	 */
	public function get( $iIndex );

        /**
	 * Returns the number of read-only business objects in this result set.
	 * 
	 * @return int the number of read-only business objects.
	 */
	public function size();

        /**
	 * Closes this result set and releases any resources associated with the result set. An 
         * <i>Inx_Api_ROBOResultSet</i> object <b>must</b> be closed once it is not needed anymore 
         * to prevent memory leaks and other potentially harmful side effects.
	 */
	public function close();
}
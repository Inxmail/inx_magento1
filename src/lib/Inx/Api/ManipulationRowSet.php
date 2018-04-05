<?php
/**
 * <i>Inx_Api_ManipulationRowSet</i> provides a common base for row sets which enable the manipulation of the contained
 * data. An implementation of <i>Inx_Api_ManipulationRowSet</i> will provide a set of update methods which manipulate the
 * data in the currently selected row.
 * <p>
 * All row changes except for the <i>deleteRow()</i> and <i>deleteRows()</i> methods usually require a call
 * of <i>commitRowUpdate()</i> to be reflected on the server. Any uncommitted changes will be lost once the
 * <i>Inx_Api_ManipulationRowSet</i> is closed. However, calling <i>commitRowUpdate()</i> on deleted rows will trigger
 * an <i>Inx_Api_DataException</i>, as the recipient in the current row no longer exists.
 * <p>
 * Note: To safely abandon all changes of the current row, use the <i>rollbackRowUpdate()</i> method. This will
 * prevent any changes to the current row from being committed through <i>commitRowUpdate()</i>. Be aware that
 * <i>rollbackRowUpdate</i> will only undo <i>uncommitted</i> changes to the current row. So, once you called
 * <i>commitRowUpdate()</i> there is "no way back".
 * 
 * @author chge, 16.05.2013
 * @since API 1.11.1
 */
interface Inx_Api_ManipulationRowSet extends Inx_Api_InxRowSet
{
	/**
	 * Deletes the current row from this row set. This method cannot be called when the cursor is on the insert row (if
	 * available). Do <b>not</b> call <i>commitRowUpdate()</i> after invoking this method, as this would
	 * trigger an <i>Inx_Api_DataException</i>.
	 */
	public function deleteRow();


	/**
	 * Deletes the specified rows from this row set. Do <b>not</b> call <i>commitRowUpdate()</i> on an
	 * affected row after invoking this method, as this would trigger an <i>Inx_Api_DataException</i>.
	 * 
	 * @param Inx_Api_IndexSelection $selection the rows to be deleted.
	 */
	public function deleteRows( Inx_Api_IndexSelection $selection );


	/**
	 * Reports whether the underlying object of the currently selected row is deleted or not.
	 * 
	 * @return bool <i>true</i> if the underlying object of the currently selected row is deleted, <i>false</i>
	 *         otherwise.
	 */
	public function isRowDeleted();


	/**
	 * Updates the underlying object on the server with the new contents of the current row of this row set.
         * <br>
         * Note: Not all of the Exceptions listed in the exceptions section are thrown by each implementation 
         * of <i>ManipulationRowSet</i>:
         * <ul>
         * <li><i>Inx_Api_Recipient_RecipientRowSet</i> might throw:
         *      <ul>
         *      <li><i>Inx_Api_Recipient_BlackListException</i></li>
         *      <li><i>Inx_Api_Recipient_IllegalValueException</i></li>
         *      <li><i>Inx_Api_Recipient_DuplicateKeyException</i></li>
         *      <li><i>Inx_Api_DataException</i></li>
         *      </ul>
         * </li>
         * <li><i>Inx_Api_Testprofiles_TestRecipientRowSet</i> might throw:
         *      <ul>
         *      <li><i>Inx_Api_Recipient_IllegalValueException</i></li>
         *      <li><i>Inx_Api_Recipient_DuplicateKeyException</i></li>
         *      <li><i>Inx_Api_DataException</i></li>
         *      </ul>
         * </li>
         * <li><i>Inx_Api_Recipient_UnsubscriptionRecipientRowSet</i> might throw:
         *      <ul>
         *      <li><i>Inx_Api_Recipient_BlackListException</i></li>
         *      <li><i>Inx_Api_Recipient_IllegalValueException</i></li>
         *      <li><i>Inx_Api_Recipient_DuplicateKeyException</i></li>
         *      <li><i>Inx_Api_DataException</i></li>
         *      </ul>
         * </li>
         * </ul>
         * 
	 * 
	 * @throws Exception if the update failed.
         * @throws Inx_Api_Recipient_BlackListException if the email address is blocked by a blacklist entry.
	 * @throws Inx_Api_Recipient_IllegalValueException if one of the attribute values is invalid.
	 * @throws Inx_Api_Recipient_DuplicateKeyException if the key value is already used.
	 * @throws Inx_Api_DataException if the object was deleted or no object is selected (e.g. you forgot to call
	 *             <i>next()</i>).
	 */
	public function commitRowUpdate();


	/**
	 * Reverts the updates made to the current row in this row set. This method may be called after calling one or
	 * several update methods to roll back the updates made to a row. If no updates have been made or
	 * <i>commitRowUpdate</i> has already been called, this method has no effect.
	 */
	public function rollbackRowUpdate();
}
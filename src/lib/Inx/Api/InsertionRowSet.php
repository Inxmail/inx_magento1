<?php
/**
 * <i>Inx_Api_InsertionRowSet</i> provides a common base for all row set which enable the insertion of rows. To insert a
 * new row you have to do the following steps:
 * <ol>
 * <li>Call <i>moveToInsertRow()</i></li>
 * <li>Provide the row data using the offered update methods</li>
 * <li>Call <i>commitRowUpdate()</i></li>
 * </ol>
 * The insert row is a special row that acts as a staging area for an object to be inserted. Each implementation of
 * <i>Inx_Api_InsertionRowSet</i> provides a set of update methods which can be used to construct this new object.
 * Committing this row will create the object on the server and make the current row a normal row. This implies that you
 * have to call <i>moveToInsertRow()</i> each time you want to add a row.
 * 
 * @author chge, 16.05.2013
 * @since API 1.11.1
 */
interface Inx_Api_InsertionRowSet extends Inx_Api_ManipulationRowSet
{
	/**
	 * Moves the cursor to the insert row. The current cursor position is remembered while the cursor is positioned on
	 * the insert row. The insert row is a special row associated with a <i>Inx_Api_InsertionRowSet</i>. It is essentially
	 * a buffer where a new row may be constructed by calling the update methods prior to inserting the row into the row
	 * set. Only the update, getter, and <i>commitRowUpdate</i> method may be called when the cursor is on the
	 * insert row.
	 */
	public function moveToInsertRow();
}
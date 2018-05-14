<?php
/**
 * <i>Inx_Api_InxRowSet</i> provides a common interface for row set navigation. The most important methods of
 * <i>Inx_Api_InxRowSet</i> are <i>next()</i> and <i>close()</i>. The <i>next()</i> method can be used to
 * iterate over the rows of the row set. The following snippet shows how to iterate over a <i>Inx_Api_InxRowSet</i>:
 * 
 * <pre>
 * $oInxRowSet = ... //get an InxRowSet implementation
 * 
 * while($oInxRowSet->next())
 * {
 *    //retrieve some information from the row set.
 * }
 * 
 * $oInxRowSet->close();
 * </pre>
 * 
 * Be sure to call <i>next()</i> before the first retrieval statement on the row set. Initially the cursor is
 * before the first row, thus no data can be retrieved from the row set before calling <i>next()</i>. Doing so
 * will trigger an <i>Inx_Api_DataException</i>.
 * <p>
 * <b>Note:</b> An <i>Inx_Api_InxRowSet</i> object <i>must</i> be closed once it is not needed anymore
 * to prevent memory leaks and other potentially harmful side effects.
 * 
 * @author chge, 16.05.2013
 * @since API 1.11.1
 */
interface Inx_Api_InxRowSet
{
	/**
	 * Moves the cursor to the front of this row set, just before the first row. This method has no effect if the result
	 * set contains no rows.
	 */
	public function beforeFirstRow();


	/**
	 * Moves the cursor to the end of this row set, just after the last row. This method has no effect if the result set
	 * contains no rows.
	 */
	public function afterLastRow();


	/**
	 * Moves the cursor to the given row number in this row set. The first row is row 0, the second is row 1, and so on.
	 * 
         * @param int $iRow the number of the row to which the cursor should move.
	 */
	public function setRow( $iRow );


	/**
	 * Retrieves the current row number. The first row is number 0, the second number 1, and so on.
	 * 
	 * @return int the current row number.
	 */
	public function getRow();


	/**
	 * Moves the cursor down one row from its current position. Initially, the row set cursor is positioned before the
	 * first row; the first call to the method <i>next()</i> makes the first row the current row; the second call
	 * makes the second row the current row, and so on.
	 * 
	 * @return bool <i>true</i> if the new current row is valid, <i>false</i> if there are no more rows.
	 */
	public function next();


	/**
	 * Moves the cursor to the previous row in this row set.
	 * 
	 * @return bool <i>true</i> if the new current row is valid, <i>false</i> if it is off the result set.
	 */
	public function previous();


	/**
	 * Returns the number of rows in this row set.
	 * 
	 * @return int the number of rows.
	 */
	public function getRowCount();


	/**
	 * Releases the resources associated with this row set on the server immediately. A row set <b>must</b> be
	 * closed once it is not needed anymore to prevent memory leaks and other potentially harmful side effects.
	 */
	public function close();
}
<?php
/**
 * @package Inxmail
 */
/**
 * An <i>Inx_Api_DataException</i> is thrown when a <i>BusinessObject</i> cannot be found on the server.
 * Example: Calling <i>commitUpdate()</i> on a <i>BusinessObject</i> that was deleted will result in a
 * <i>DataException</i>.
 * 
 * @see Inx_Api_BusinessObject#commitUpdate()
 * @see Inx_Api_BusinessObject#reload()
 * @see Inx_Api_BOResultSet#get(int)
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 */
class Inx_Api_DataException extends Exception
{
	
}

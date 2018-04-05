<?php

/**
 * @package Inxmail
 * @subpackage SplitTestMailing
 */

/**
 * The <i>SplitTestMailingManager</i> enables access to split test mailings. These mailings can be accessed
 * through the <i>Inx_Api_SplitTestMailing_SplitTestMailing</i> business object.
 * <p>
 * <b>Mailing retrieval</b> There are several ways to retrieve mailings. The simplest way is to call
 * <i>selectAll()</i> which will retrieve all mailings. To retrieve a single mailing, use the
 * <i>get(int)</i> method.
 * <p>
 * Note: To access mailings, the following api user right is required: <i>Inx_Api_UserRights::MAILING_FEATURE_USE</i>
 *
 * @see Inx_Api_SplitTestMailing_SplitTestMailing
 * @since API 1.13.1
 */
interface Inx_Api_SplitTestMailing_SplitTestMailingManager extends Inx_Api_BOManager
{

}

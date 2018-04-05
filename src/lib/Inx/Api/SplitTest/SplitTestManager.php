<?php

/**
 * @package Inxmail
 * @subpackage SplitTest
 */

/**
 * The <i>SplitTestManager</i> enables access to split tests. These mailings can be accessed
 * through the <i>Inx_Api_SplitTestMailing_SplitTestMailing</i> business object.
 * These split tests can be accessed through the <i>Inx_Api_SplitTest_SplitTest</i> business object.
 * <p>
 * <b>Split test retrieval</b> To retrieve a split test, use the <i>get(int)</i> method.
 * <p>
 * Note: To access mailings, the following api user right is required: <i>Inx_Api_UserRights::SPLIT_TEST_FEATURE_USE</i>
 *
 * @see Inx_Api_SplitTest_SplitTest
 * @since API 1.13.1
 */
interface Inx_Api_SplitTest_SplitTestManager extends Inx_Api_BOManager
{

}

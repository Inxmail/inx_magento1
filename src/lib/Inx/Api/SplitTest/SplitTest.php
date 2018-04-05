<?php

/**
 * @package Inxmail
 * @subpackage SplitTestMailing
 */

/**
 * A <i>Inx_Api_SplitTest_SplitTest</i> object represents a split test in Inxmail. It provides the split test id and also the
 * corresponding split test name.
 *
 * @since API 1.13.1
 */
interface Inx_Api_SplitTest_SplitTest extends Inx_Api_BusinessObject
{

    /**
     * Returns the name of this split test.
     *
     * @return string the name of this split test.
     */
    public function getName();

}

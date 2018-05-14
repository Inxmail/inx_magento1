<?php
/**
 * This exception is thrown on methods that are not implemented.
 * 
 * Usually used on methods that are expected to be implemented, but in fact aren't.
 * 
 * @since API 1.13.1
 * @author sveh, 23.06.2015
 * @package Inxmail
 */
class Inx_Api_NotImplementedException extends BadMethodCallException {}

<?php

/**
 *
 * @author nic.stransky
 */
interface State {
	public function addItem($item);
	public function sendToPaypal();
	public function paypalResponseFailure();
	public function sendEmailFailureNotice();
	public function paypalResponseSuccess();
	public function sendEmailWithAttachment();
	public function destroyCart();
}

?>

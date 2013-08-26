<?php

/**
 * Description of Cart
 *
 * @author nic.stransky
 * 
 * NOTE: each state class's __toString method return string MUST NOT BE ALTERED. These values are used in the unit tests, so even if you think there is a better way to describe the state, you'll break the unit tests by changing these.
 */
class Cart {
	
	private $noItemsState;
	private $hasItemsState;
	private $waitingForPaypalResponseState;
	private $paymentFailedState;
	private $paymentSucceededState;
	private $deliveryCompletedState;
	
	private $state;
	private $items = array();
	
	public function __construct($items) {
		$this->noItemsState = new NoItemsState($this);
		$this->hasItemsState = new HasItemsState($this);
		$this->waitingForPaypalResponseState = new WaitingForPaypalResponseState($this);
		$this->paymentFailedState = new PaymentFailedState($this);
		$this->paymentSucceededState = new PaymentSucceededState($this);
		$this->deliveryCompletedState = new DeliveryCompletedState($this);
		
		$this->state = $this->noItemsState;

		// TODO eventually new Cart() should be possible without $items, and then ->addItem would be addItems and accept either an array of item objects or a single item
		// this would mean that the if below would actually be inside the cart->addItem method - not in the constructor
		if(is_array($items) && count($items) > 0) {
			$this->items = $items;
			$this->state = $this->hasItemsState;
		}
		
		
	}

	public function getItems() {
		return $this->items;
	}

	public function addItem($item) {
		$this->state->addItem($item);
	}
	
	public function deleteAllItems() {
		out("You have removed all items from the cart.");
		$this->items = array();
	}
	
	public function appendItemToItemsArray($item) {
		$this->items[] = $item;
		out("You have added an item.");	
	}
	
	public function sendToPaypal() {
		$this->state->sendToPaypal();
	}
	
	public function paypalResponseFailure() {
		$this->state->paypalResponseFailure();
		$this->state->sendEmailFailureNotice();
	}
	
	public function sendEmailFailureNotice() {
		$this->state->sendEmailFailureNotice();
	}
	
	public function paypalResponseSuccess() {
		$this->state->paypalResponseSuccess();
		$this->state->sendEmailWithAttachment();
	}
	
	public function sendEmailWithAttachment() {
		$this->state->sendEmailWithAttachment();
	}
	
	public function deliverItemsByEmail() {
		out("sending email to customer with items attached");
	}
	
	public function deliverFailureByEmail() {
		out("sending email to customer telling them their payment failed");
	}
	
	public function destroyCart() {
		$this->state->destroyCart();
	}

	
	public function setState(State $state) {
		$this->state = $state;
	}

	public function getState() {
		return $this->state;
	}
	
	public function getNoItemsState() {
		return $this->noItemsState;
	}

	public function getHasItemsState() {
		return $this->hasItemsState;
	}

	public function getWaitingForPaypalResponseState() {
		return $this->waitingForPaypalResponseState;
	}

	public function getPaymentFailedState() {
		return $this->paymentFailedState;
	}

	public function getPaymentSucceededState() {
		return $this->paymentSucceededState;
	}

	public function getDeliveryCompletedState() {
		return $this->deliveryCompletedState;
	}
			
	public function __toString() {
		return 
				"<li>Cart ID: 6, Cart contains: " . count($this->items) . " items</li>"
			.	"<li>State: {$this->state}</li>"
		;
	}
	
}

?>

<?php
require_once 'common.php';


/**
 * Description of CartTest
 *
 * @author nic.stransky
 */
$output_media_type = 'shell';
//db_connect();
class CartTest extends PHPUnit_Framework_TestCase {
	public function setup() { }
	public function tearDown() { echo "\n\n"; }
	public function testAddItems() {
		
		$items = array();
		$item->name = 'Apple';
		$item->url = 'http://www.hdwallpaperspics.com/uploads/2012/11/apple2-1.jpg';
		$items[] = $item;
		unset($item);

		$item->name = 'Banana';
		$item->url = 'http://paulwhartonstyle.com/wp-content/uploads/2013/03/shutterstock_99478112.jpg';
		$items[] = $item;
		unset($item);
		
		$cart = new Cart($items); 
				
		$item->name = 'Pear';
		$item->url = 'http://smoothiejuicerecipes.com/pear.jpg';
		$cart->addItem($item);
		unset($item);

		//
		$this->assertTrue(count($cart->getItems()) == 3);

	}
	
	public function testSendToPaypalWhenHasItems() {
		$item->name = 'Banana';
		$item->url = 'http://paulwhartonstyle.com/wp-content/uploads/2013/03/shutterstock_99478112.jpg';
		$items[] = $item;
		unset($item);
		
		$cart = new Cart($items); 
		$cart->sendToPaypal();
		$this->assertTrue( $cart->getState() == "Waiting for Payal's IPN response." );
	}
	
	public function testCantAddItemsWhenWaitingForPaypalResponse() {
		$item->name = 'Banana';
		$item->url = 'http://paulwhartonstyle.com/wp-content/uploads/2013/03/shutterstock_99478112.jpg';
		$items[] = $item;
		unset($item);
		
		$cart = new Cart($items); 
		$cart->sendToPaypal();
		
		$item->name = 'Pear';
		$item->url = 'http://smoothiejuicerecipes.com/pear.jpg';
		$cart->addItem($item);
		unset($item);

		$this->assertTrue(count($cart->getItems()) == 1);
		
	}
	
	public function testAddItemPayForItReceiveSuccessSendMail() {

		$items = array();
		$item->name = 'Apple';
		$item->url = 'http://www.hdwallpaperspics.com/uploads/2012/11/apple2-1.jpg';
		$items[] = $item;
		unset($item);

		$cart = new Cart($items);
		$cart->sendToPaypal();
		$cart->paypalResponseSuccess();
		
		$this->assertTrue( $cart->getState() == "DeliveryCompletedState. You can delete the cart." );		
		
	}
	
	public function testSendToPaypalSerializeAndDeserializeToReceivePaypalResponse() {

		$items = array();
		$item->name = 'Apple';
		$item->url = 'http://www.hdwallpaperspics.com/uploads/2012/11/apple2-1.jpg';
		$items[] = $item;
		unset($item);

		$cart = new Cart($items);
		$cart->sendToPaypal();
		
		// store the cart in database with session id
		$serial = serialize($cart);
		$serial_json = json_encode($serial);
		
		// retrieve cart from database using session id
		$serial_unjson = json_decode($serial_json);
		$cart = unserialize($serial_unjson);
		
		$cart->paypalResponseSuccess();
		
		$this->assertTrue( $cart->getState() == "DeliveryCompletedState. You can delete the cart." );		
	}
	
}

?>

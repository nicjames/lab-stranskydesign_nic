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

	public function testSendToPaypalSerialize() {

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
		
		
		
		$this->assertTrue(true);		
	}
	
}

?>

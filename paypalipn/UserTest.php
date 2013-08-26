<?php
//require_once 'common.php';
require_once 'Phactory\lib\PhactoryMongo.php';
/**
 * Description of UserTest
 * copied from http://phactory.org/mongodb-guide/ to learn database unit tests
 * @author nic.stransky
 */
$output_media_type = 'shell';
//db_connect();
function getUserAge($users, $user_id) {
	$user = $users->findOne(array('_id' => $user_id));
	
	if(null === $user) {
		return false;
	}
	
	return $user['age'];
}
class UserTest extends PHPUnit_Framework_TestCase {
	public static function setUpBeforeClass() {
		$mongo = new Mongo();
		Phactory::setConnection($mongo->test_db);
	}
	
	public function testSerializeStoreSendToPaypalRetrieveUnserializeReceivePaypalResponse() {
		/*
		global $_DB;
		
		$items = array();
		$item->name = 'Apple';
		$item->url = 'http://www.hdwallpaperspics.com/uploads/2012/11/apple2-1.jpg';
		$items[] = $item;
		unset($item);

		$cart = new Cart($items);
		
		$session_id = rand(); // used just for this self contained test
		$serial = serialize($cart);
		out("store cart in carts table, session_id: $session_id");
		
		$new_cart_id = idb_exe(
			"
			INSERT INTO carts
				(
					cart_object
				,	session_id
				,	date_created
				,	date_modified
				)
			VALUES
				(
					:cart_object
				,	:session_id
				,	current_timestamp()
				,	current_timestamp()
				)
			"
		,	array('cart_object' => $serial, 'session_id' => $session_id)
		);
		
		out("cart_id: $new_cart_id");
		$cart->sendToPaypal();

		// now the paypal IPN would post back (most likely to a different URL) with the session_id
		out("get cart from database");
		$results = idb_sel(
			"
			SELECT 
					cart_id
				,	cart_object
			FROM carts
			WHERE session_id = :session_id
			"
		,	array('session_id' => $session_id)
		);
		$serial = $results[0]['cart_object'];
		$cart = unserialize($serial);	
		
		$cart->paypalResponseSuccess();
		$this->assertTrue( $cart->getState() == "DeliveryCompletedState. You can delete the cart." );	
		 * 
		 */
	}
}

?>

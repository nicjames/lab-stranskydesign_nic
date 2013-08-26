<?php

include('paypalipn/common.php');
idb_connect();
/*
abstract class ItemType {
	const Cartoon = 1;
	const Fruit = 2;
}
 * ItemType::Cartoon  will result in a 1.
 * 
 */

?>
<li>Setup functions.</li>

<h1>Cart - Full Regression</h1>
<?php
//define("CLASS_FILEROOT", "c:/wamp/www/lab.stranskydesign.com.localhost/paypalipn");

out("define an item");
$items = array();
$item->name = 'Apple';
$item->url = 'http://www.hdwallpaperspics.com/uploads/2012/11/apple2-1.jpg';
$items[] = $item;
unset($item);

out("create cart with item");
$cart = new Cart($items);
out($cart);



// testing serialization for storing state of cart in database
$serial = serialize($cart);
session_start();
$session_id = session_id();

//global $_DB;
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

out("send cart to paypal");
$cart->sendToPaypal();
out($cart);

// now the paypal IPN would post back (most likely to a different URL) with the session_id
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
debug($results);

//$results = idb_sel("SELECT cart_id, cart_object FROM carts WHERE session_id = '$session_id'  ORDER BY cart_id DESC LIMIT 1");
//debug($results);


//$serial_unjson = json_decode($serial_json);
$serial = $results[0]['cart_object'];
$cart = unserialize($serial);

debug($cart->getItems());





out("receive IPN failure");
$cart->paypalResponseFailure();
out($cart);

out("send cart to paypal");
$cart->sendToPaypal();
out($cart);

out("receive IPN success");
$cart->paypalResponseSuccess();
out($cart);



?>
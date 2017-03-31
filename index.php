<?php
require __DIR__  . '/vendor/autoload.php';
//require_once __DIR___ .'vendor/braintree/braintree_php/lib/Braintree.php';
use Braintree\Gateway;





$accessToken = file_get_contents(__DIR__ . '/access_token');
$gateway = new Gateway(array(
    'accessToken' => $accessToken,
));

$clientToken = $gateway->clientToken()->generate();
?>
<!DOCTYPE html>
<html>
<head>
	<title>paypal</title>
</head>
<body>
<h1>Pay with paypal</h1>
<script src="https://www.paypalobjects.com/api/button.js?"
		data-merchant="braintree"
		data-id="paypal-button"
		data-button="checkout"
		data-color="gold"
		data-size="medium"
		data-shape="pill"
		data-button_type="submit"
		data-button_disabled="false"
            ></script>
<!--jquery for easy ajax call-->
<script src="js/jquery.min.js"></script>
<!-- Load the required components. -->
<script src="https://js.braintreegateway.com/web/3.11.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.11.0/js/paypal.min.js"></script>
<script>
    <?php
        $token = json_encode($clientToken);
        echo "window.TOKEN = $token";
    ?>
</script>
<!-- Use the components. We'll see usage instructions next. -->
<!--suppress JSUnresolvedVariable -->
<script>
    // Fetch the button you are using to initiate the PayPal flow
    var paypalButton = document.getElementById('paypal-button');



    // Create a Client component
    braintree.client.create({
        //		authorization: 'TOKEN'
        authorization: window.TOKEN
    }, function(clientErr, clientInstance) {
        // Create PayPal component
        braintree.paypal.create({
            client: clientInstance
        }, function(err, paypalInstance) {
            if(err){
                console.log(err);
                throw err;
            }
            console.log('paypalInstance', paypalInstance);
            paypalButton.addEventListener('click', function() {
                // Tokenize here!
                paypalInstance.tokenize({
                    flow: 'checkout', // Required
                    amount: 10.00, // Required
                    currency: 'USD', // Required
                    locale: 'en_US',
                    enableShippingAddress: true,
                    shippingAddressEditable: false,
                    shippingAddressOverride: {
                        recipientName: 'Scruff McGruff',
                        line1: '1234 Main St.',
                        line2: 'Unit 1',
                        city: 'Chicago',
                        countryCode: 'US',
                        postalCode: '60652',
                        state: 'IL',
                        phone: '123.456.7890'
                    }
                }, function(err, tokenizationPayload) {
                    // Tokenization complete
                    // Send tokenizationPayload.nonce to server
                    if(err){
                        console.log(err);
                        throw err;
                    }
                    console.log('tokenizationPayload', tokenizationPayload);
                    console.log(tokenizationPayload)
                });
            });
        });
    });
</script>
</body>
</html>
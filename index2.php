<?php
header('X-Frame-Options: GOFORIT');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div id="paypal-button-container"></div>

<div id="confirm" class="hidden">
    <div>Ship to:</div>
    <div><span id="recipient"></span>, <span id="line1"></span>, <span id="city"></span></div>
    <div><span id="state"></span>, <span id="zip"></span>, <span id="country"></span></div>

    <button id="confirmButton">Complete Payment</button>
</div>

<div id="thanks" class="hidden">
    Thanks, <span id="thanksname"></span>!
</div>

<script>

    // Render the PayPal button

    paypal.Button.render({

        // Set your environment

        env: 'sandbox', // sandbox | production

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox:    'AR5lJaa2rHSxGVfSP3nb-nx11jvXQTy5eLLuIM4yB88z7wHIHxqtEE34oTpwdWM-oT_H6gmJfkWLzl3k',
            production: 'Aco85QiB9jk8Q3GdsidqKVCXuPAAVbnqm0agscHCL2-K2Lu2L6MxDU2AwTZa-ALMn_N0z-s2MXKJBxqJ'
        },

        // Wait for the PayPal button to be clicked

        payment: function(resolve, reject) {

            return paypal.request.post('https://tinker.press/php-paypal/index2.php')
                         .then(function(data) {
                             console.log('create payment data', data);

                             resolve(data.paymentID);

                             return paypal.rest.payment.create(this.props.env, this.props.client, {
                                 transactions: [
                                     {
                                         amount: { total: '0.01', currency: 'USD' }
                                     }
                                 ]
                             });
                         })
                         .catch(function(err) {
                             reject(err);
                         });


        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {

            // Get the payment details

            return actions.payment.get().then(function(data) {

                // Display the payment details and a confirmation button

                var shipping = data.payer.payer_info.shipping_address;

                document.querySelector('#recipient').innerText = shipping.recipient_name;
                document.querySelector('#line1').innerText     = shipping.line1;
                document.querySelector('#city').innerText      = shipping.city;
                document.querySelector('#state').innerText     = shipping.state;
                document.querySelector('#zip').innerText       = shipping.postal_code;
                document.querySelector('#country').innerText   = shipping.country_code;

                document.querySelector('#paypal-button-container').style.display = 'none';
                document.querySelector('#confirm').style.display = 'block';

                // Listen for click on confirm button

                document.querySelector('#confirmButton').addEventListener('click', function() {

                    // Disable the button and show a loading message

                    document.querySelector('#confirm').innerText = 'Loading...';
                    document.querySelector('#confirm').disabled = true;

                    // Execute the payment

                    return actions.payment.execute().then(function() {

                        // Show a thank-you note

                        document.querySelector('#thanksname').innerText = shipping.recipient_name;

                        document.querySelector('#confirm').style.display = 'none';
                        document.querySelector('#thanks').style.display = 'block';
                    });
                });
            });
        }

    }, '#paypal-button-container');

</script>
</body>
</html>
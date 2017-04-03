<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div id="paypal-button"></div>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<script>
    paypal.Button.render({

        env: 'sandbox', // Optional: specify 'sandbox' environment

        payment: function(resolve, reject) {

            var CREATE_PAYMENT_URL = 'https://tinker.press/php-paypal/sample/payments/create-payment.php';

            return paypal.request.post(CREATE_PAYMENT_URL)
                         .then(function(data) { resolve(data.paymentID); })
                         .catch(function(err) { reject(err); });
        },

        onAuthorize: function(data) {

            // Note: you can display a confirmation page before executing

            var EXECUTE_PAYMENT_URL = 'https://tinker.press/php-paypal/sample/payments/execute-payment.php';

            return paypal.request.post(EXECUTE_PAYMENT_URL,
                { paymentID: data.paymentID, payerID: data.payerID })

                         .then(function(data) { /* Go to a success page */ })
                         .catch(function(err) { /* Go to an error page  */ });
        }

    }, '#paypal-button');
</script>
</body>
</html>
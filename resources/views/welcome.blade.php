<html>
<head>
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body>
<!-- <form action="{{url('payment/transaction')}}" method="GET"> -->
    <button id="payment-button">Pay with Khalti</button>

    <script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_8063d121402b4b81b8d3b9bd46c95c14",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "eventHandler": {
                onSuccess (payload) {
                    // console.log(payload); //response from khalti to client
                    
                    // hit merchant api for initiating verfication
                    $.ajax({
                        url:"{{url('/payment/verification')}}",
                        type: 'POST',
                        data:{
                            amount : payload.amount,
                            trans_token : payload.token
                        },
                        success: function(res)
                        {
                            console.log("transaction succedd"); // you can return to success page
                        },
                        error: function(error)
                        {
                            console.log("transaction failed");
                        }
                    })
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            checkout.show({amount: 1000});
        }
    </script>
</body>
</html>
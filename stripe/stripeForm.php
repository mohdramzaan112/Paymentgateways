<!-- Demo of Stripe Payment Gateway Integration  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>stripe payment</title>
</head>
<body>
    <h1>Stripe Payment Gateway Integration</h1>

    <!-- display errors returned by createToken -->
    <span class="payment-errors"></span>

    <!-- stripe payment form -->
    <form action="payment.php" method="POST" id="paymentFrm">
        <p>
            <label>Name</label>
            <input type="text" name="name" size="50" />
        </p>
        <p>
            <label>Email</label>
            <input type="text" name="email" size="50" />
        </p>
        <p>
            <label>Card Number</label>
            <input type="text" name="card_num" size="20" autocomplete="off" class="card-number" />
        </p>
        <p>
            <label>CVC</label>
            <input type="text" name="cvc" size="4" autocomplete="off" class="card-cvc" />
        </p>
        <p>
            <label>Expiration (MM/YYYY)</label>
            <input type="text" name="exp_month" size="2" class="card-expiry-month"/>
            <span> / </span>
            <input type="text" name="exp_year" size="4" class="card-expiry-year"/>
        </p>
        <button type="submit" id="payBtn">Submit Payment</button>
    </form>
    <!-- Stripe JavaScript library -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
    //set your publishable key
    Stripe.setPublishableKey('pk_test_*******');

    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {
        if (response.error) {
            //enable the submit button
            $('#payBtn').removeAttr("disabled");
            //display the errors on the form
            $(".payment-errors").html(response.error.message);
        } else {
            var form$ = $("#paymentFrm");
            //get token id
            var token = response['id'];
            //insert the token into the form
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            //submit form to the server
            form$.get(0).submit();
        }
    }
    $(document).ready(function() {
        //on form submit
        $("#paymentFrm").submit(function(event) {
            //disable the submit button to prevent repeated clicks
            $('#payBtn').attr("disabled", "disabled");
            
            //create single-use token to charge the user
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
            
            //submit from callback
            return false;
        });
    });
    </script>
</body>
</html>





<!-- https://github.com/stripe/stripe-php/releases -->

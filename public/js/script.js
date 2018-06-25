    
      $cartItems = [];
      $walletBalance = 0;
      $shippingCharges = 0;
      $shippingMethod = null;
      $overAllTotal = 0;
      $cartTotal = 0;

      $(document).ready(function(){
        getProductsOnCart();
        getWalletBalance();
        


        $('button.btnAddToCart').click(function(e){
          e.preventDefault();
          $product = JSON.parse($(this).attr('data-product'));
          $qty = $('input[name="inputQty'+$product.product_id+'"]').val();

          $.ajax({
            url: '/api/cart/start-shopping',
            type: 'POST',
            data : 
            { 
              product_id    : $product.product_id,
              qty           : $qty,
              price         : $product.product_price
            },
            success: function (data) {
              console.log(data);
              if (JSON.parse(data).code == 401 ){
                window.location.href='/login';
              }
            },
            error : function(error){
              console.log(error);
            },
            complete : function(){
            }
          });
          getProductsOnCart();
          setUpDefaultIndicators();
          setCartItemsIndicator();
          setCartTotalIndicator();

        });

        // get the shipping option selected by the user 
        $('input[name="shipment_option"]').change(function(){
          $shippingMethod = $(this).val();
          if ( $shippingMethod == 'ups' ){
            $shippingCharges = 5;
          } else {
            $shippingMethod == 'pickup'
            $shippingCharges = 0;
          }
            setShippingChargesIndicator();
            updateOverAllTotal();
        });
        $('button#btnPayNow').click(function(e){
          e.preventDefault();
          $context = $(this);
          if ($shippingMethod == null){
            showErrorMessage("You must select a shipping method");
            return false;
          }
          $(this).attr('disabled','disabled');
          $(this).text("Processing...");
         
          $.ajax({
            url: '/api/cart/checkout',
            type: 'POST',
            data: {
              transaction_cost: $overAllTotal,
              shipping_method: $shippingMethod,
              shipping_cost: $shippingCharges
            },
            success: function (data) {
              console.log("code" + JSON.parse(data).code);
              data = JSON.parse(data);
              if (data.code == 500){
                showErrorMessage(data.msg);
              }
              if (data.code == 200){
                getWalletBalance();
                $('#modalCheckout').hide();
                $('#modalCheckoutSuccess').modal({backdrop:false});
              }
            },
            complete: function(data){
              $context.removeAttr('disabled');
              $context.text('Pay Now');
            }
          });
        });

        $('button.btnRemoveFromCart').click(function(){
          if (confirm("Do you really want to remove this item from cart ?")){
            $cartListIndex = $(this).attr('data-cart-product-id');
            // remove row
             $(this).closest('tr').find('td').fadeOut(1000, 
                 function(){ 
                    $(this).parents('tr:first').remove();                    
              });    

            return removeProductFromCart($cartListIndex);
          }
        });
        $('button.btnUpdateQty').click(function(){
          $context = $(this);
           $cartListIndex = $(this).attr('data-cart-product-id');
           $productPrice = $(this).attr('data-cart-product-price');
           $newQty = $('input[name="product_qty'+$cartListIndex+'"]').val();
           $subTotal = parseFloat($productPrice) * parseFloat($newQty);
            $('span#subtotal'+$cartListIndex).html(Number($subTotal).toFixed(2));
           return updateProductQtyInCart($cartListIndex,$newQty,$context);
        });

        function setUpDefaultIndicators(){
          
          $cartItemsIndicator = $('span#cartItemsIndicator');
          $walletBalanceIndicator = $('span#walletBalanceIndicator');
          $shippingChargesIndicator = $('span#shippingCharges');
          $walletBalanceIndicator.html($walletBalance);
          $cartItemsIndicator.html($cartItems.length);
          $shippingChargesIndicator.html(Number($shippingCharges).toFixed(2));

        }
        function updateProductQtyInCart($cartListIndex, $newQty)
        {
          $.ajax({
            url: '/api/cart/list/'+$cartListIndex+'/update-qty',
            type: 'POST',
            data: {
              new_qty : $newQty
            },
            success: function (data) {
              console.log("finished!");

             
            },
            error : function(error){
              console.log(error);
            },
            complete : function(){
              getProductsOnCart();
              setCartTotalIndicator();
              updateOverAllTotal();
            }
          });
        }
        function removeProductFromCart($cartListIndex)
        {
          $.ajax({
            url: '/api/cart/list/'+$cartListIndex+'/remove',
            type: 'DELETE',
            success: function (data) {
              console.log("finished!");
            },
            error : function(error){
              console.log(error);
            },
            complete : function(){
              getProductsOnCart();
              setCartTotalIndicator();
              updateOverAllTotal();
            }
          });
        }

        function getProductsOnCart()
        {

          $.ajax({
            url: '/api/cart',
            type: 'GET',
            success: function (data) {
              $cartItems = JSON.parse(data);
            },
            error : function(error){
              console.log(error);
            },
            complete : function(){
               setUpDefaultIndicators();
               setCartTotalIndicator();

            }
          });
        }
        function getWalletBalance()
        {
          $.ajax({
            url: '/api/wallet/balance',
            type: 'GET',
            success: function (data) {
              $walletBalance = JSON.parse(data).wallet_balance;
            },
            error : function(error){
              console.log(error);
            },
            complete : function(){
              setUpDefaultIndicators();
            }
          });
        }

        function setCartTotalIndicator(){
          $cartTotal = 0;
          $cartItems.map(function(value,key){
              $cartTotal+= parseFloat(value.price) * parseFloat(value.qty);
          });
          $('span#cartTotalIndicator').html("$"+Number($cartTotal).toFixed(2));
          $('span#orderTotal').html(Number($cartTotal).toFixed(2));
          updateOverAllTotal();
        }

        function updateOverAllTotal(){
          console.log("cart total is" + $cartTotal);
          $overAllTotal = parseFloat($shippingCharges) + parseFloat($cartTotal);
          $('span#overAllTotal').html(Number($overAllTotal).toFixed(2));
        }

        function setBalanceIndicator($walletBalance) {
          $walletBalanceIndicator.html($walletBalance);
        }

        function setCartItemsIndicator() {
          $cartItemsIndicator.html($cartItems.length);
        }

        function setShippingChargesIndicator() {
          $shippingChargesIndicator.html(Number($shippingCharges).toFixed(2));
        }

        function showErrorMessage($msg) {
            $('span#cartErrorMsg').html($msg);
            $('.alert').css("display","block");
        }
      });
    <?php $total = 0; includeLayout('header.php') ?>
    <!-- Page Content -->
    <div class="container" style="margin-top:20px;">
      <?php if (count($productsOnCart) > 0) { ?>
         <a class="btn btn-primary" style="float:right;"  href="#modalCheckout" data-toggle="modal" role="button">Checkout & Pay</a> 
      <?php } ?>
      
     
      <h2 class="page-header">Your Shopping Cart</h2>

      <!-- Page Features -->
      <div class="row ">
        <table class="table table-inverse">
          <thead>
            <tr>
              <th></th>
              <th>Product Name</th>
              <th>Qty</th>
              <th>Price</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($productsOnCart) < 1) { ?>
                <tr>
                  <td><h3>There are no products in the cart.</h3>
                    <a href="/" class="btn btn-primary">Go to shop</a>
                  </td>
                </tr>
            <?php } ?>
            <?php foreach($productsOnCart as $product){
              $total += $product['price'] *  $product['qty'];
              ?>
              <tr>
                <td width="10%">
                  <img class="img-fluid img-thumbnail" alt="Responsive image" src="http://placehold.it/80x50" alt="">
                </td>
                <td> 
                  <?php print $product['product_name'] ?> 
                  <p> <?php print $product['product_desc'] ?> </p>
                  <button data-cart-product-id="<?php print $product['cart_product_id'] ?>" type="button" class="btn btn-sm btn-danger btnRemoveFromCart"> Remove from cart</button>
                  <button  
                    data-cart-product-id="<?php print $product['cart_product_id'] ?>" 
                    data-cart-product-price="<?php print $product['product_price'] ?>" 
                    type="button" class="btn btn-sm btn-default btnUpdateQty"> 
                    Update Qty
                  </button>
                </td>
                <td width="30%"> 
                  <input name="product_qty<?php print $product['cart_product_id'] ?>" type="number" min="1" style="width: 40%;" class="form-control" value="<?php print number_format($product['qty']) ?>">

                </td>
                <td> <?php print $product['price'] ?></td>
                <td> 
                  <span id="subtotal<?php print number_format($product['cart_product_id']) ?>">
                  <?php print number_format($product['price'] * $product['qty'],2) ?> </span> 
                </td>
              </tr>
            <?php } ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td>Total</td>
              <td>
                <strong> 
                  <span id="orderTotal"><?php print number_format($total,2) ?></span>
                </strong></td>
            </tr>
          </tbody>
        </table>


        


      </div>
      <!-- /.row -->

    </div>
    <!-- Modal -->
    <div class="modal" id="modalCheckout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Checkout - Cart Total : <strong> <?php print number_format($total,2) ?> </strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div style="display: none;" class="alert alert-danger" role="alert">
                <strong>Error!</strong> <span id="cartErrorMsg"></span>.
            </div>
            <div class="row">
              <div class="col-md-6">                
                <p><strong>Shipping Option</strong></p>
                <form action="" method="POST" role="form">

                 <div class="radio" style="padding:5px;border-bottom:1px dotted #ccc;">
                   <label>
                     <input type="radio" name="shipment_option" id="input1" value="pickup">
                     Pickup
                   </label>
                   <p class="text-muted">No additional cost.</p>
                 </div>
                 <div class="radio"  style="padding:5px;border-bottom:1px dotted #ccc;">
                   <label>
                     <input type="radio" name="shipment_option" id="input2" value="ups">
                     UPS
                   </label>
                   <p class="text-muted">Additional cost of $5.</p>
                 </div>

                 <p><strong>Payment Method</strong></p>
                 <div class="radio"  style="padding:5px;border-bottom:1px dotted #ccc;">
                   <label>
                     <input type="radio" checked="checked" name="payment_method" id="input2" value="wallet_balance">
                     Wallet Balance
                   </label>
                 </div>
               </form>
             </div><!-- /col-md-6 -->
             <div class="col-md-6">
                <p><strong>Order Summary</strong></p>
                <table class="table">
                  <tbody>
                    <tr>
                      <td>
                        Order Subtotal : 
                      </td>
                      <td>
                        <strong>
                          <span id="orderTotal"><?php print number_format($total,2) ?></span>
                        </strong>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Shipping Charges :
                      </td>
                      <td>
                        <strong><span id="shippingCharges"></span> </strong>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <strong>Overall Total</strong>
                      </td>
                      <td>
                        <strong>
                          <span id="overAllTotal"></span>
                        </strong>
                      </td>
                    </tr>
                  </tbody>
                </table>
             </div><!-- /col-md-6 -->
           </div><!-- /row -->
         </div>
         <div class="modal-footer">
          <p style="margin-right:55%;font-weight: bold;">Wallet Balance : 
            <span id="walletBalanceIndicator"></span> </p>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="btnPayNow" class="btn btn-primary">Pay Now</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modalCheckoutSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Success !
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Your transaction has been successfully completed!</p>
            <p>Your remaining wallet balance is : <strong><span id="walletBalanceIndicator"></span></strong></p>
         </div>
         <div class="modal-footer">
          <a href="/transactions" class="btn btn-primary">View Transactions</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 


  <!-- /.container -->
  <?php includeLayout('footer.php') ?>
</body>

</html>



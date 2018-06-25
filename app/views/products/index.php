    <?php includeLayout('header.php') ?>
    <!-- Page Content -->
    <div class="container">
      <?php if ( session('flash') != null ){ ?>
        <div class="alert alert-info" role="alert">
          <?php print session('flash') ?>
        </div>
      <?php } ?>

      <!-- Jumbotron Header -->
      <header class="jumbotron my-4">
        <h1 class="display-3">Welcome to ABCify ! </h1>
        <p class="lead">A "sounds-like shopify" e-commerce.</p>
      </header>

      <!-- Page Features -->
      <div class="row text-center">

        <?php foreach($products as $product){?>
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
              <img class="card-img-top" src="http://placehold.it/500x325" alt="">
              <div class="card-body">
                <h4 class="card-title"><?php print $product['product_name']?></h4>
                <p class="card-text"><?php print $product['product_desc']?></p>
                <p class="card-text">$ <?php print $product['product_price'] ?></p>
                <div data-product-id="<?php print $product['product_id'] ?>" id="rating<?php print $product['product_id'] ?>"></div>
                Qty : <input type="number" min="1" value="1" name="inputQty<?php print $product['product_id'] ?>" class="form-control" placeholder="Quantity">
              </div>
              <div class="card-footer">
                <button data-product="<?php echo htmlspecialchars(json_encode($product)) ?>"  class="btn btn-primary btnAddToCart">Add to cart</button>
              </div>
            </div>
          </div>
        <?php } ?>


      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->
    <?php includeLayout('footer.php') ?>
    <script type="text/javascript">
      $(document).ready(function (){

        $.ajax({
          url: '/api/products',
          type: 'GET',
          success: function (data) {
              
              JSON.parse(data).map(function(value, key){ 
                console.log(value);
                $("#rating"+value.product_id).rateYo({
                  starWidth: "15px",
                  rating: value.product_rating
                });
                listenForRatingChange(value.product_id);
              });
            },
            error : function(error){
              // console.log(error);
            },
            complete : function(data){
            }         
          });

        

        function listenForRatingChange($productId){
          $('#rating'+$productId).rateYo().on("rateyo.set", function (e, data) {
            $(this).next().text(data.rating);
            $rating = data.rating;
            $productId = $(this).attr('data-product-id');
            console.log("rating is " + $rating);
            $.ajax({
              url: '/api/products/'+$productId+'/rate',
              type: 'POST',
              data: {
                product_id: $productId,
                rating:   $rating
              },
              success: function (data) {
                console.log(data);
                if (JSON.parse(data).code == 401){
                  window.location.href='/login';
                }
              },
              error : function(error){
                console.log(error);
              },
              complete : function(){
              }
            });
          });

        }
      });
      

    </script>

  </body>

  </html>



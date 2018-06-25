<!-- Modal -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Shopping Cart</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="cartList"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
    <footer style="margin-top: 19%;" class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; ABCify e-commerce 2018</p>
      </div>
      <!-- /.container -->
    </footer>
    <?php unSetSession('flash') ?>
    <!-- Jquery core JavaScript -->
    <script src="<?php print asset('/js/jquery.min.js') ?>"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="<?php print asset('/js/bootstrap.min.js') ?>"></script>
    <!-- Custom script for this applicaiton -->
    <script src="<?php print asset('/js/script.js') ?>"></script>
    
    <script src="<?php print asset('/js/jquery.rateyo.min.js') ?>"></script>

    <?php includeLayout('header.php') ?>
    <!-- Page Content -->
    <div  class="container" style="margin-top:50px;">
      <h3 class="page-header">Transactions</h3>
      <!-- Page Features -->
      <div class="row ">         
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>Transaction Date</th>
              <th>Shipping Option</th>
              <th>Transaction Cost</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($transactions as $transaction){?>
              <tr>
                <td><?php print $transaction['transaction_id'] ?></td>
                <td><?php print $transaction['transaction_date'] ?></td>
                <td><?php print $transaction['shipping_method'] ?> </td>
                <td><strong>
                    <?php print number_format($transaction['transaction_cost'],2) ?>
                  </strong>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>


      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->
     <div class="modal" id="modalCheckoutSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 800px;" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Transaction Complete </strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h2 align="center">
              Transaction has been completed ! 
            </h2>
         </div>
         <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="btnPayNow" class="btn btn-primary">Pay Now</button>
        </div>
      </div>
    </div>
  </div>
    <?php includeLayout('footer.php') ?>


  </body>

  </html>



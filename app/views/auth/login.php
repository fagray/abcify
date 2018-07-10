    <?php includeLayout('header.php') ?>
    <!-- Page Content -->
    <div class="container" style="margin-top:50px;">
       <?php if (session('flash') != null ) { ?>
        <div class="alert alert-info" role="alert">
          <?php print session('flash') ?>
        </div>
      <?php } ?>
      <!-- Page Features -->
      <div class="row">      

        <div class="col-md-offset-3 col-md-6">
           <h3>Please Login</h3><br/>
          <form method="post">
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 form-control-label">Username</label>
            <div class="col-sm-10">
              <input name="username" type="text" class="form-control" id="inputEmail3" placeholder="Username">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 form-control-label">Password</label>
            <div class="col-sm-10">
              <input  name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
          </div>
          
          <div class="form-group row">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-secondary">Sign in</button>
            </div>
          </div>
        </form>
        </div>


      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->
    <?php includeLayout('footer.php') ?>


  </body>

  </html>



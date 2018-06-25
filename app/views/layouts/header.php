<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Raymund Santillan">

  <title>ABC Hosting Cart - Shop and be awesome</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php print asset('/css/bootstrap.css') ?>" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php print asset('/css/heroic-features.css') ?>" rel="stylesheet">
  <link href="<?php print asset('/css/jquery.rateyo.css') ?>" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">ABCsify</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <?php if (authUser()['user_id'] != null){ ?>
          <li class="nav-item">
            <a class="nav-link" href="#">Wallet Balance : $<span id="walletBalanceIndicator"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="/cart/view">Cart : <span id="cartItemsIndicator"></span> item(s)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="/cart/view">Total : <span id="cartTotalIndicator"></span></a>
          </li>
        <?php } ?>
          <?php if (authUser()['user_id'] != null){ ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <?php print authUser()['username'] ?>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/transactions">Transactions</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/logout">Logout</a>
            </div>
          </li>
          <?php }else { ?>
          <li class="nav-item">
              <a class="nav-link"  href="/login">Login</a>
          </li>
          <?php } ?>


        </ul>
      </div>
    </div>
  </nav>


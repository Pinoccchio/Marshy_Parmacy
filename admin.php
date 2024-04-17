<?php
$page_title = 'Admin Home Page';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(1);
?>
<?php
$c_categorie     = count_by_id('categories');
$c_product       = count_by_id('products');
$c_sale          = count_by_id('sales');
$c_user          = count_by_id('users');
$products_sold   = find_higest_saleing_product('10');
$recent_products = find_recent_product_added('5');
$recent_sales    = find_recent_sale_added('5');
$expiring_products = exp_products('11');
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-lg-3 col-md-6">
    <div class="panel panel-box">
      <a href="users.php" style="color:black;">
        <div class="panel-icon bg-secondary1">
          <i class='bx bx-user'></i>
          <h2 class="dbtext margin-top"><?php echo $c_user['total']; ?></h2>
          <p class="dbtext">Users</p>
        </div>  
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-md-6">
    <div class="panel panel-box">
      <a href="categorie.php" style="color:black;">
        <div class="panel-icon bg-red">
          <i class='bx bx-category'></i>
          <h2 class="dbtext margin-top"><?php echo $c_categorie['total']; ?></h2>
          <p class="dbtext">Categories</p>
        </div>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-md-6">
    <div class="panel panel-box">
      <a href="product.php" style="color:black;">
        <div class="panel-icon bg-blue2">
          <i class='bx bxs-cart-add'></i>
          <h2 class="dbtext margin-top"><?php echo $c_product['total']; ?></h2>
          <p class="dbtext">Products</p>
        </div>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-md-6">
    <div class="panel panel-box">
      <a href="sales.php" style="color:black;">
        <div class="panel-icon bg-green">
          <i class='bx bx-dollar'></i>
          <h2 class="dbtext margin-top"><?php echo $c_sale['total']; ?></h2>
          <p class="dbtext">Sales</p>
        </div>
      </a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-signal"></span>
          <span>Highest Selling Products</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Total Sold</th>
              <th>Total Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products_sold as $product_sold): ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td><?php echo (int)$product_sold['totalSold']; ?></td>
                <td><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-stats"></span>
          <span>Latest Sales</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Product Name</th>
              <th>Date</th>
              <th>Total Sale</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recent_sales as $recent_sale): ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <td><a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>"><?php echo remove_junk(first_character($recent_sale['name'])); ?></a></td>
                <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
                <td>₱<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
              </tr>
            <?php endforeach; ?> 
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-remove-sign"></span>
          <span>Expiring Products</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Stocks</th>
              <th>Date Added</th>
              <th>Expire in</th>
              <th>Expiration Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($expiring_products as $expiring_product): ?>
              <tr>
                <td><?php echo remove_junk(first_character($expiring_product['name'])); ?></td>
                <td><?php echo remove_junk($expiring_product['quantity']); ?></td>
                <td><?php echo remove_junk(read_date_no_time($expiring_product['date'])); ?></td>
                <td><?php echo remove_junk($expiring_product['Remaining_Days']); ?> Days</td>
                <td><?php echo remove_junk($expiring_product['exp_date']); ?></td>
              </tr>
            <?php endforeach; ?> 
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-plus"></span>
          <span>Recently Added Products</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="list-group">
          <?php foreach ($recent_products as $recent_product): ?>
            <a class="list-group-item clearfix" href="edit_product.php?id=<?php echo (int)$recent_product['id']; ?>">
              <h4 class="list-group-item-heading">
                <?php if ($recent_product['media_id'] === '0'): ?>
                  <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image']; ?>" alt="">
                <?php endif; ?>
                <?php echo remove_junk(first_character($recent_product['name'])); ?>
                <span class="label label-warning pull-right">₱<?php echo (int)$recent_product['sale_price']; ?></span>
              </h4>
              <span class="list-group-item-text pull-right"><?php echo remove_junk(first_character($recent_product['categorie'])); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<?php
$page_title = 'Add Product';
require_once('includes/load.php');

page_require_level(2);
$all_categories = find_all('categories');
$all_photo = find_all('media');

if(isset($_POST['submit'])) {
  $photo = new Media();
  $photo->upload($_FILES['file_upload']);
  if($photo->process_media()){
      $session->msg('s','photo has been uploaded.');
      redirect('add_product.php');
  } else{
    $session->msg('d',join($photo->errors));
    redirect('add_product.php');
  }
}

if(isset($_POST['add_product'])){
  $req_fields = array('product-title','product-categorie','exp-date','product-quantity','buying-price', 'saleing-price' );
  validate_fields($req_fields);
  if(empty($errors)){
    $p_name  = remove_junk($db->escape($_POST['product-title']));
    $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
    $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
    $p_buy   = remove_junk($db->escape($_POST['buying-price']));
    $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
    $p_expd  = remove_junk($db->escape($_POST['exp-date']));
    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else { 
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }

    $date    = make_date();
    $query  = "INSERT INTO products (";
    $query .=" name,quantity,buy_price,sale_price,categorie_id,media_id,date,exp_date";
    $query .=") VALUES (";
    $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$date}', '{$p_expd}'";
    $query .=")";
    $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
    if($db->query($query)){
      $session->msg('s',"Product added ");
      redirect('add_product.php', false);
    } else {
      $session->msg('d',' Sorry failed to added!');
      redirect('product.php', false);
    }
  } else{
    $session->msg("d", $errors);
    redirect('add_product.php',false);
  }
}

if(isset($_POST['delete_photo'])) {
  $photo_id = $_POST['photo_id'];
  $delete_photo = find_by_id('media', $photo_id);
  if($delete_photo && delete_by_id('media', $photo_id)) {
    echo json_encode(['status' => 'success', 'message' => 'Photo deleted successfully.']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete photo.']);
  }
  exit();
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-camera"></span>
        <span>All Photos</span>
        <div class="pull-right">
          <form class="form-inline" action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-btn">
                  <input type="file" name="file_upload" multiple="multiple" class="btn btn-primary btn-file"/>
                </span>
                <button type="submit" name="submit" class="btn btn-default">Upload</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th class="text-center">Photo</th>
              <th class="text-center">Photo Name</th>
              <th class="text-center" style="width: 20%;">Photo Type</th>
              <th class="text-center" style="width: 50px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_photo as $media_file): ?>
              <tr class="list-inline">
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center">
                  <img src="uploads/products/<?php echo $media_file['file_name'];?>" class="img-thumbnail" />
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_name'];?>
                </td>
                <td class="text-center">
                  <?php echo $media_file['file_type'];?>
                </td>
                <td class="text-center">
                  <button class="btn btn-danger btn-xs delete-photo" data-id="<?php echo $media_file['id']; ?>" title="Delete">
                    <span class="glyphicon glyphicon-trash"></span>
                  </button>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
        </strong>
      </div>

      <div class="panel-body">
        <div class="">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-th-large"></i> 
                    </span>
                    <input type="text" class="form-control" name="product-title" placeholder="Product Title" maxlength="40">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-th-large"></i>
                      </span>
                      <select class="form-control" name="product-categorie">
                            <option value="">Select Product Category</option>
                              <?php  foreach ($all_categories as $cat): ?>
                            <option value="<?php echo (int)$cat['id'] ?>">
                              <?php echo $cat['name'] ?></option>
                              <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <br>
              <br>

              <div class="form-group">
                <div class="col-md-6">
                  <div class="">
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-picture"></i>
                      </span>
                      <select class="form-control" name="product-photo">
                        <option value="">Select Product Photo</option>
                        <?php  foreach ($all_photo as $photo): ?>
                          <option value="<?php echo (int)$photo['id'] ?>">
                            <?php echo $photo['file_name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-calendar"></i> 
                    </span>
                    <span class="input-group-addon">
                      ExpirationDate:                                 
                    </span>
                    <input class="form-control" type="date" name="exp-date">
                  </div>
                </div>
              </div>

              <br>
              <br>
              
              <div class="form-group">
                <div class="">
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                      ₱
                      </span>
                      <input type="number" class="form-control" name="buying-price" placeholder="Buying Price">
                      <span class="input-group-addon">.00</span>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        ₱
                      </span>
                      <input type="number" class="form-control" name="saleing-price" placeholder="Selling Price">
                      <span class="input-group-addon">.00</span>
                    </div>
                  </div>
                </div>
              </div>
              
              <br>
              <br>

              <div class="form-group">
                <div class="">
                  <div class="col-md-6">
                    <div class="input-group">
                      <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
                    </div>
                  </div>
                </div>
              </div>
              
          </form>
        </div>
      </div>    
    </div>                                     
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>



<script>
$(document).ready(function() {
  $('.delete-photo').click(function() {
    var photoId = $(this).data('id');
    if(confirm('Are you sure you want to delete this photo?')) {
      $.ajax({
        url: 'add_product.php',
        type: 'POST',
        data: {
          delete_photo: 1,
          photo_id: photoId
        },
        success: function(response) {
          var data = JSON.parse(response);
          if(data.status === 'success') {
            alert(data.message);
            location.reload();
          } else {
            alert(data.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }
  });
});
</script>

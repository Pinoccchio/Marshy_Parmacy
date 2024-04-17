<?php
$page_title = 'All User';
require_once('includes/load.php');

// Set PHP Timezone to Philippine time
date_default_timezone_set('Asia/Manila');

// Check what level user has permission to view this page
page_require_level(1);

// Set MySQL Timezone to Philippine time
$db->query("SET time_zone = '+08:00'");

// Pull out all users from the database
$all_users = find_all_user();

// Function to update user status
function update_user_status($user_id, $status) {
    global $db;
    
    $status = (int)$status;
    $user_id = (int)$user_id;

    $query  = "UPDATE users SET ";
    $query .= "status='{$status}' ";
    $query .= "WHERE id='{$db->escape($user_id)}'";
    $result = $db->query($query);

    if ($result && $db->affected_rows() === 1) {
        return true;
    } else {
        return false;
    }
}

// Update user status if inactive for a month
foreach ($all_users as $a_user) {
    $last_login_timestamp = strtotime($a_user['last_login']);
    $one_month_ago = strtotime('-1 month'); // Changed from '-1 day' to '-1 month'
    
    if ($last_login_timestamp < $one_month_ago && $a_user['status'] === '1') {
        update_user_status($a_user['id'], '0'); // Set status to Deactive
    }
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Users</span>
                </strong>
                <a href="add_user.php" class="btn btn-info pull-right">Add New User</a>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th class="text-center" style="width: 15%;">User Role</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th style="width: 20%;">Last Login</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_users as $a_user) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($a_user['name'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_user['username'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name'])) ?></td>
                                <td class="text-center">
                                    <?php if ($a_user['status'] === '1') : ?>
                                        <span class="label label-success"><?php echo "Active"; ?></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><?php echo "Deactive"; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo read_date($a_user['last_login']) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <a href="#" class="btn btn-xs btn-danger delete-user-btn" data-toggle="tooltip" title="Remove" data-id="<?php echo (int)$a_user['id']; ?>">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<!-- JavaScript for confirmation dialog -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('.delete-user-btn');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                
                var userId = this.getAttribute('data-id');
                var confirmation = confirm('Are you sure you want to remove this user?');

                if (confirmation) {
                    window.location.href = 'delete_user.php?id=' + userId;
                }
            });
        });
    });
</script>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Navigation Menu</title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-weight: 400;
      overflow-x: hidden;
      overflow-y: auto;
      background: #ffffff;
      height: 100%;
      width: 100%;
      margin: 0;
      padding: 0;
    }

    ul.nav {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: space-around;
      background-color: #D0DFFF;
      height: max-content;
    }

    ul.nav li {
      flex: 1;
      text-align: center;
    }

    ul.nav li a {
      display: block;
      color: #000000;
      text-decoration: none;
      padding: 0.1px;
      font-size: 14px;
    }


    ul.nav li:hover {
      background-color: #D0DFFF;
    }

    ul.submenu {
      display: none;
      list-style: none;
      padding: 0;
      margin: 0;
      background-color: #5279DB;
      position: absolute;
      height: 200px;
    }

    ul.submenu li {
      text-align: center;
    }

    ul.submenu li a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 10px;
    }

    ul.submenu li:hover {
      background-color: #5279DB;
    }

    @media only screen and (max-width: 768px) {
      ul.nav {
        flex-direction: column;
        align-items: stretch;
      }

      ul.nav li {
        flex: none;
      }

      ul.submenu {
        flex-direction: column;
        position: static;
        display: none;
      }
    }
  </style>
</head>

<body>
  <ul class="nav" id="main-menu">
    <li>
      <a href="admin.php">
        <i class="glyphicon glyphicon-home"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-user"></i>
        <span>User Management</span>
      </a>
      <ul class="nav submenu">
        <li><a href="group.php">Manage Groups</a> </li>
        <li><a href="users.php">Manage Users</a> </li>
      </ul>
    </li>
    <li>
      <a href="categorie.php">
        <i class="glyphicon glyphicon-indent-left"></i>
        <span>Categories</span>
      </a>
    </li>
    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-th-large"></i>
        <span>Products</span>
      </a>
      <ul class="nav submenu">
        <li><a href="product.php">Manage Products</a> </li>
        <li><a href="add_product.php">Add Products</a> </li>
      </ul>
    </li>
    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-credit-card"></i>
        <span>Sales</span>
      </a>
      <ul class="nav submenu">
        <li><a href="sales.php">Manage Sales</a> </li>
        <li><a href="add_sale.php">Add Sale</a> </li>
      </ul>
    </li>
    <li>
      <a href="#" class="submenu-toggle">
        <i class="glyphicon glyphicon-duplicate"></i>
        <span>Sales Report</span>
      </a>
      <ul class="nav submenu">
        <li><a href="sales_report.php">Sales by dates </a></li>
        <li><a href="monthly_sales.php">Monthly sales</a></li>
        <li><a href="daily_sales.php">Daily sales</a> </li>
      </ul>
    </li>
  </ul>

</body>

</html>
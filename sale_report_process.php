<!doctype html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @media print {
            html,body{
                font-size: 9.5pt;
                margin: 0;
                padding: 0;
            }
            .page-break {
                page-break-before:always;
                width: auto;
                margin: auto;
            }
            .print-btn .fas {
                display: none;
            }
            .print-btn {
                display: none;
            }
        }
        .page-break{
            width: 980px;
            margin: 0 auto;
        }
        .sale-head{
            margin: 40px 0;
            text-align: center;
        }
        .sale-head h1, .sale-head strong{
            padding: 10px 20px;
            display: block;
        }
        .sale-head h1{
            margin: 0;
            border-bottom: 1px solid #212121;
        }
        .table>thead:first-child>tr:first-child>th{
            border-top: 1px solid #000;
        }
        table thead tr th {
            text-align: center;
            border: 1px solid #ededed;
        }
        table tbody tr td{
            vertical-align: middle;
        }
        .sale-head, table.table thead tr th, table tbody tr td, table tfoot tr td{
            border: 1px solid #212121;
            white-space: nowrap;
        }
        .sale-head h1, table thead tr th, table tfoot tr td{
            background-color: #f8f8f8;
        }
        tfoot{
            color:#000;
            text-transform: uppercase;
            font-weight: 500;
        }
        /* Print button styles */
        .print-btn-container {
            position: fixed;
            top: 100px;
            right: 100px;
        }
        .print-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            cursor: pointer;
            border-radius: 5px;
        } 
        /* Printer icon style */
        .fa-print {
            font-size: 15px; /* Adjust size as needed */
            margin-right: 5px; /* Add some space between icon and button border */
        }
    </style>
</head>
<body>
<?php
$page_title = 'Sales Report';
$results = '';
require_once('includes/load.php');

// Check which level user has permission to view this page
page_require_level(3);

$errors = array();

if(isset($_POST['submit'])) {
    $req_dates = array('start-date', 'end-date');
    validate_fields($req_dates);

    if(empty($errors)) {
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));
        $results = find_sale_by_dates($start_date, $end_date);
    } else {
        $session->msg("d", $errors);
        redirect('sales_report.php', false);
    }
} else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
}
?>
<?php if($results): ?>
    <div class="page-break">
        <div class="sale-head">
            <h1>Marsy_Pharmacy - Sales Report</h1>
            <strong><?php if(isset($start_date)){ echo $start_date;}?> TILL DATE <?php if(isset($end_date)){echo $end_date;}?> </strong>
        </div>
        <table class="table table-border">
            <thead>
            <tr>
                <th>Date</th>
                <th>Product Title</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Total Qty</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($results as $result): ?>
                <tr>
                    <td class=""><?php echo remove_junk($result['date']);?></td>
                    <td class="desc">
                        <h6><?php echo remove_junk(ucfirst($result['name']));?></h6>
                    </td>
                    <td class="text-right"><?php echo remove_junk($result['buy_price']);?></td>
                    <td class="text-right"><?php echo remove_junk($result['sale_price']);?></td>
                    <td class="text-right"><?php echo remove_junk($result['total_sales']);?></td>
                    <td class="text-right"><?php echo remove_junk($result['total_saleing_price']);?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr class="text-right">
                <td colspan="4"></td>
                <td colspan="1">Grand Total</td>
                <td> ₱ <?php echo number_format(total_price($results)[0], 2);?></td>
            </tr>
            <tr class="text-right">
                <td colspan="4"></td>
                <td colspan="1">Profit</td>
                <td> ₱ <?php echo number_format(total_price($results)[1], 2);?></td>
            </tr>
            </tfoot>
        </table>

        <!-- Print button -->
        <div class="print-btn-container">
            <button class="print-btn" onclick="window.print()">
                <!-- Print icon with text -->
                <i class="fas fa-print"> Print</i> 
            </button>
        </div>
    </div>
<?php else:
    $session->msg("d", "Sorry no sales has been found. ");
    redirect('sales_report.php', false);
endif;
?>
</body>
</html>

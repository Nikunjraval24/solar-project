<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit();
}
include("../db.php");

$res = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Orders</title>
<style>
body{font-family:Segoe UI;background:#f4f6f8;margin:0;}
.container{padding:30px;}
h2{color:#0f9d58;}
table{
  width:100%;
  border-collapse:collapse;
  background:#fff;
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 10px 30px rgba(0,0,0,0.1);
}
th,td{
  padding:12px;
  border-bottom:1px solid #eee;
  text-align:left;
}
th{background:#0f9d58;color:#fff;}
.status{
  padding:6px 10px;
  border-radius:20px;
  font-size:13px;
}
.Pending{background:#fff3cd;color:#856404;}
.Completed{background:#d4edda;color:#155724;}
.Cancelled{background:#f8d7da;color:#721c24;}
</style>
</head>

<body>
<div class="container">
<h2>📦 Orders Management</h2>

<table>
<tr>
  <th>#</th>
  <th>Customer</th>
  <th>Mobile</th>
  <th>Total</th>
  <th>Payment</th>
  <th>Status</th>
  <th>Change Status</th>
  <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($res)){ ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= htmlspecialchars($row['customer_name']) ?></td>
  <td><?= htmlspecialchars($row['mobile']) ?></td>
  <td>₹<?= number_format($row['grand_total'],2) ?></td>
  <td><?= htmlspecialchars($row['payment_method']) ?></td>

  <td>
    <span class="status <?= $row['order_status'] ?>">
      <?= $row['order_status'] ?>
    </span>
  </td>

  <td>
    <form method="post" action="update_order_status.php">
      <input type="hidden" name="id" value="<?= $row['id'] ?>">
      <select name="order_status" onchange="this.form.submit()">
        <option <?= $row['order_status']=='Pending'?'selected':'' ?>>Pending</option>
        <option <?= $row['order_status']=='Completed'?'selected':'' ?>>Completed</option>
        <option <?= $row['order_status']=='Cancelled'?'selected':'' ?>>Cancelled</option>
      </select>
    </form>
  </td>

  <td><?= $row['created_at'] ?? '-' ?></td>
</tr>
<?php } ?>

</table>
</div>
</body>
</html>

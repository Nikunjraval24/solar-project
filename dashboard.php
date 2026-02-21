<?php
session_start();

// 1. Admin login check
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// 2. Database connection
if (file_exists("../db.php")) {
    include("../db.php");
} else {
    die("Error: db.php file not found.");
}

// 3. Data fetching
$complaints_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM complaints");
$complaints_count = ($complaints_res) ? mysqli_fetch_assoc($complaints_res)['total'] : 0;

$feedback_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM feedback");
$feedback_count = ($feedback_res) ? mysqli_fetch_assoc($feedback_res)['total'] : 0;

$products_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$products_count = ($products_res) ? mysqli_fetch_assoc($products_res)['total'] : 0;

$orders_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
$orders_count = ($orders_res) ? mysqli_fetch_assoc($orders_res)['total'] : 0;

// Reviews Count
$reviews_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM product_reviews");
$reviews_count = ($reviews_res) ? mysqli_fetch_assoc($reviews_res)['total'] : 0;

$revenue_res = mysqli_query($conn, "SELECT SUM(grand_total) AS total FROM orders WHERE order_status='Completed'");
$total_revenue = ($revenue_res && mysqli_num_rows($revenue_res) > 0) ? mysqli_fetch_assoc($revenue_res)['total'] : 0;
$total_revenue = ($total_revenue) ? $total_revenue : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sun Solar | Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
    --primary: #f97316; 
    --secondary: #0f172a; 
    --bg: #f1f5f9;
    --sidebar-width: 260px;
}

* { box-sizing: border-box; }
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background-color: var(--bg);
    display: flex;
}

.sidebar {
    width: var(--sidebar-width);
    height: 100vh;
    background: var(--secondary);
    color: white;
    position: fixed;
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
    z-index: 100;
}

.sidebar-brand {
    font-size: 22px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 30px;
    display: flex; align-items: center; gap: 10px;
}

.sidebar a {
    display: flex;
    align-items: center;
    color: #94a3b8;
    text-decoration: none;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 5px;
    transition: 0.3s;
    cursor: pointer;
    font-weight: 500;
}

.sidebar a i { width: 25px; font-size: 18px; margin-right: 10px; }

.sidebar a:hover, .sidebar a.active {
    background: rgba(249, 115, 22, 0.15);
    color: var(--primary);
}

.logout-link { color: #fca5a5 !important; margin-top: auto; margin-bottom: 20px !important; }

.main {
    margin-left: var(--sidebar-width);
    width: calc(100% - var(--sidebar-width));
    padding: 40px;
}

.section { display: none; animation: fadeIn 0.5s ease; }
.section.active { display: block; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 40px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.02);
    display: flex;
    align-items: center; gap: 15px;
    border: 1px solid #e2e8f0;
}

.card-icon {
    width: 45px; height: 45px;
    background: rgba(249, 115, 22, 0.1);
    color: var(--primary);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
}

.card-info h2 { margin: 0; font-size: 22px; color: var(--secondary); }
.card-info p { margin: 0; color: #64748b; font-size: 11px; font-weight: 600; text-transform: uppercase; }

.box {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.02);
    margin-bottom: 30px;
    overflow-x: auto;
}

table { width: 100%; border-collapse: collapse; min-width: 800px; }
th { text-align: left; padding: 15px; background: #f8fafc; color: #64748b; font-size: 13px; }
td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.status-completed { background: #dcfce7; color: #166534; }
.status-pending { background: #fee2e2; color: #991b1b; }
.rating-star { color: #facc15; }
</style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand"><i class="fas fa-sun"></i> SUN SOLAR</div>
    
    <a onclick="openTab('dash')" id="link-dash" class="active"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a onclick="openTab('ord')" id="link-ord"><i class="fas fa-shopping-cart"></i> Orders</a>
    <a onclick="openTab('rev')" id="link-rev"><i class="fas fa-star"></i> Product Reviews</a>
    <a onclick="openTab('feed')" id="link-feed"><i class="fas fa-comments"></i> Feedback</a>
    <a onclick="openTab('comp')" id="link-comp"><i class="fas fa-headset"></i> Complaints</a>

    <a href="logout.php" class="logout-link"><i class="fas fa-power-off"></i> Logout</a>
</div>

<div class="main">
    
    <div id="dash" class="section active">
        <h1 style="margin-top:0;">Analytics Overview</h1>
        <div class="cards">
            <div class="card">
                <div class="card-icon" style="background:rgba(250,204,21,0.1); color:#facc15;"><i class="fas fa-star"></i></div>
                <div class="card-info"><h2><?php echo $reviews_count; ?></h2><p>Reviews</p></div>
            </div>
            <div class="card">
                <div class="card-icon" style="background:rgba(59,130,246,0.1); color:#3b82f6;"><i class="fas fa-comments"></i></div>
                <div class="card-info"><h2><?php echo $feedback_count; ?></h2><p>Feedback</p></div>
            </div>
            <div class="card">
                <div class="card-icon" style="background:rgba(239,68,68,0.1); color:#ef4444;"><i class="fas fa-ticket"></i></div>
                <div class="card-info"><h2><?php echo $complaints_count; ?></h2><p>Complaints</p></div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="card-info"><h2><?php echo $orders_count; ?></h2><p>Total Orders</p></div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-indian-rupee-sign"></i></div>
                <div class="card-info"><h2>₹<?php echo number_format($total_revenue); ?></h2><p>Revenue</p></div>
            </div>
        </div>
        
        <div class="box">
            <h3><i class="fas fa-chart-area"></i> Inquiry Growth</h3>
            <canvas id="growthChart" height="80"></canvas>
        </div>
    </div>

    <div id="ord" class="section">
        <h1>Orders Management</h1>
        <div class="box">
            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Customer</th><th>Mobile</th><th>Total</th><th>Status</th><th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($res)){
                        $status_class = ($row['order_status'] == 'Completed') ? 'status-completed' : 'status-pending';
                        echo "<tr>
                            <td>#{$row['id']}</td>
                            <td><b>{$row['customer_name']}</b></td>
                            <td>{$row['mobile']}</td>
                            <td>₹".number_format($row['grand_total'])."</td>
                            <td><span class='status-badge {$status_class}'>{$row['order_status']}</span></td>
                            <td>".date("d-m-Y", strtotime($row['created_at']))."</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="rev" class="section">
        <h1>Product Reviews</h1>
        <div class="box">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Product ID</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM product_reviews ORDER BY id DESC");
                    if($res && mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)){
                            $stars = str_repeat('<i class="fas fa-star rating-star"></i>', $row['rating']);
                            echo "<tr>
                                <td>#{$row['id']}</td>
                                <td><b>{$row['customer_name']}</b></td>
                                <td>#{$row['product_id']}</td>
                                <td>{$stars}</td>
                                <td>{$row['review_text']}</td>
                                <td>".date("d-m-Y", strtotime($row['created_at']))."</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No reviews found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="feed" class="section">
        <h1>User Feedback</h1>
        <div class="box">
            <table>
                <thead><tr><th>User ID</th><th>Message</th></tr></thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM feedback ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($res)){
                        $msg = $row['message'] ?? $row['feedback'] ?? 'No message';
                        echo "<tr><td>User #{$row['id']}</td><td>{$msg}</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="comp" class="section">
        <h1>Customer Complaints</h1>
        <div class="box">
            <table>
                <thead><tr><th>ID</th><th>Customer Name</th><th>Message</th></tr></thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM complaints ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($res)){
                        echo "<tr><td>#{$row['id']}</td><td><b>{$row['customer_name']}</b></td><td>{$row['complaint']}</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function openTab(tabId) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
    
    document.getElementById(tabId).classList.add('active');
    document.getElementById('link-' + tabId).classList.add('active');
}

const ctx1 = document.getElementById('growthChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: 'Total Activity',
            data: [5,12,8,20,15,18,22,19,16,14,17, <?php echo $complaints_count + $feedback_count + $reviews_count; ?>],
            borderColor: '#f97316',
            backgroundColor: 'rgba(249, 115, 22, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: { responsive: true }
});
</script>

</body>
</html>
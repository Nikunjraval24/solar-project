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

// 3. Data fetching with error handling
$complaints_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM complaints");
$complaints_count = ($complaints_res) ? mysqli_fetch_assoc($complaints_res)['total'] : 0;

$feedback_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM feedback");
$feedback_count = ($feedback_res) ? mysqli_fetch_assoc($feedback_res)['total'] : 0;

$products_res = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$products_count = ($products_res) ? mysqli_fetch_assoc($products_res)['total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sun Solar | Pro Admin Dashboard</title>

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

/* --- SIDEBAR --- */
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
    display: flex;
    align-items: center;
    gap: 10px;
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

.logout-link { color: #fca5a5 !important; margin-bottom: 20px !important; }

/* --- MAIN CONTENT --- */
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

/* --- CARDS --- */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.02);
    display: flex;
    align-items: center;
    gap: 20px;
    border: 1px solid #e2e8f0;
}

.card-icon {
    width: 60px; height: 60px;
    background: rgba(249, 115, 22, 0.1);
    color: var(--primary);
    border-radius: 15px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}

.card-info h2 { margin: 0; font-size: 28px; color: var(--secondary); }
.card-info p { margin: 0; color: #64748b; font-size: 14px; font-weight: 600; text-transform: uppercase; }

.box {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.02);
    margin-bottom: 30px;
}

table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 15px; background: #f8fafc; color: #64748b; font-size: 13px; }
td { padding: 15px; border-bottom: 1px solid #f1f5f9; }

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    background: #dcfce7;
    color: #166534;
}
</style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand"><i class="fas fa-sun"></i> SUN SOLAR</div>
    
    <a href="logout.php" class="logout-link"><i class="fas fa-power-off"></i> Logout</a>

    <a onclick="openTab('dash')" id="link-dash" class="active"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a onclick="openTab('prod')" id="link-prod"><i class="fas fa-box"></i> Products</a>
    <a onclick="openTab('feed')" id="link-feed"><i class="fas fa-comments"></i> Feedback</a>
    <a onclick="openTab('comp')" id="link-comp"><i class="fas fa-headset"></i> Complaints</a>
</div>

<div class="main">
    
    <div id="dash" class="section active">
        <h1 style="margin-top:0;">Analytics Overview</h1>
        <div class="cards">
            <div class="card">
                <div class="card-icon"><i class="fas fa-solar-panel"></i></div>
                <div class="card-info"><h2><?php echo $products_count; ?></h2><p>Products</p></div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-message"></i></div>
                <div class="card-info"><h2><?php echo $feedback_count; ?></h2><p>Feedback</p></div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-ticket"></i></div>
                <div class="card-info"><h2><?php echo $complaints_count; ?></h2><p>Complaints</p></div>
            </div>
        </div>
        
        <div class="box">
            <h3><i class="fas fa-chart-area"></i> Monthly Traffic & Growth</h3>
            <canvas id="growthChart" height="100"></canvas>
        </div>
    </div>

    <div id="prod" class="section">
        <h1>Product Inventory</h1>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            <div class="box">
                <table>
                    <thead><tr><th>ID</th><th>Product Name</th><th>Price</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php
                        // LIVE PRODUCTS (NO LIMIT)
                        $res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                        if($res && mysqli_num_rows($res) > 0) {
                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                    <td>#{$row['id']}</td>
                                    <td><b>{$row['name']}</b></td>
                                    <td>₹".number_format($row['price'])."</td>
                                    <td><span class='status-badge'>In Stock</span></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No products found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="box">
                <h3>Stock Ratio</h3>
                <canvas id="stockChart"></canvas>
            </div>
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
                    if($res && mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)){
                            $feed_msg = $row['message'] ?? $row['feedback'] ?? 'No feedback';
                            echo "<tr><td>User #{$row['id']}</td><td>{$feed_msg}</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No feedback received.</td></tr>";
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
                    if($res && mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)){
                            echo "<tr>
                                <td>#{$row['id']}</td>
                                <td><b>{$row['customer_name']}</b></td>
                                <td>{$row['complaint']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No complaints found.</td></tr>";
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
        labels: [
            'Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'
        ],
        datasets: [{
            label: 'Inquiry Growth',
            data: [
                5,12,8,20,15,18,22,19,16,14,17,
                <?php echo $complaints_count + $feedback_count; ?>
            ],
            borderColor: '#f97316',
            backgroundColor: 'rgba(249, 115, 22, 0.1)',
            fill: true,
            tension: 0.4
        }]
    }
});

const ctx2 = document.getElementById('stockChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Products', 'Complaints'],
        datasets: [{
            data: [<?php echo $products_count; ?>, <?php echo $complaints_count; ?>],
            backgroundColor: ['#f97316', '#1e293b']
        }]
    }
});
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard – replATE</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="styles.css">
<style>
.page { display:flex; min-height:100vh; }
.content { padding:28px; flex:1; }
.content-section { display:none; }
.content-section.active { display:block; animation:fadeInUp .35s ease both; }
@keyframes fadeInUp { from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);} }
</style>
</head>
<body>
<div class="page">
  <!-- SIDEBAR -->
  <div class="sidebar" id="admin-sidebar">
    <div class="sidebar-logo">
<div class="logo-icon"><img src="./logo.jpeg" alt="replATE" class="logo-img" style="width:100%;height:100%;object-fit:contain;border-radius:10px;"></div>
      <span class="logo-text">replATE</span>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-section-label">Overview</div>
      <div class="nav-item active" onclick="adminNav(this,'sec-dash')"><i class="fas fa-th-large"></i> Dashboard</div>
      <div class="nav-item" onclick="adminNav(this,'sec-analytics')"><i class="fas fa-chart-bar"></i> Analytics</div>
      <div class="nav-item" onclick="adminNav(this,'sec-impact')"><i class="fas fa-heart"></i> Impact</div>
      <div class="nav-section-label">Manage</div>
      <div class="nav-item" onclick="adminNav(this,'sec-users')"><i class="fas fa-users"></i> Users <span class="nav-badge">1,250</span></div>
      <div class="nav-item" onclick="adminNav(this,'sec-donations')"><i class="fas fa-box-open"></i> Donations <span class="nav-badge">2,100</span></div>
      <div class="nav-item" onclick="adminNav(this,'sec-ngos')"><i class="fas fa-building"></i> NGOs</div>
      <div class="nav-item" onclick="adminNav(this,'sec-volunteers')"><i class="fas fa-bicycle"></i> Volunteers</div>
    </nav>
    <div class="sidebar-bottom">
      <div class="sidebar-user">
        <div class="avatar" style="background:#EF4444">A</div>
        <div class="uinfo"><div class="uname">Admin User</div><div class="urole">Administrator</div></div>
      </div>
      <div class="nav-item" onclick="logout()" style="color:#EF4444"><i class="fas fa-sign-out-alt"></i> Logout</div>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main-wrap">
    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-search"><i class="fas fa-search" style="color:var(--text-3)"></i><input placeholder="Search users, donations…"/></div>
      <div class="topbar-right">
        <div class="notif-wrap">
          <div class="notif-btn" onclick="toggleNotif('admin-notif')"><i class="fas fa-bell"></i><span class="notif-badge">3</span></div>
          <div class="notif-dropdown" id="admin-notif">
            <div class="notif-header"><h3>Notifications</h3><a onclick="markAllRead('admin-notif')">Mark all read</a></div>
            <div class="notif-item"><div class="notif-dot"></div><div class="notif-content"><div class="title">New User Registered</div><div class="desc">Jane Doe joined as a Donor</div><div class="time">5 min ago</div></div></div>
            <div class="notif-item"><div class="notif-dot"></div><div class="notif-content"><div class="title">Donation Expired</div><div class="desc">Hotel Grand's biryani expired unclaimed</div><div class="time">1 hour ago</div></div></div>
            <div class="notif-item"><div class="notif-dot read"></div><div class="notif-content"><div class="title">NGO Verification Request</div><div class="desc">City Shelter needs verification</div><div class="time">2 hours ago</div></div></div>
          </div>
        </div>
        <div class="user-chip"><div class="avatar" style="background:#EF4444">A</div><div><div class="uname">Admin User</div><div class="urole">Admin</div></div></div>
        <button class="logout-btn" onclick="logout()"><i class="fas fa-sign-out-alt"></i></button>
      </div>
    </div>

    <div class="content">

      <!-- ── DASHBOARD ── -->
      <div class="content-section active" id="sec-dash">
        <div class="page-header">
          <div class="page-title"><h2>Admin Dashboard 👨‍💼</h2><p>Platform overview and management</p></div>
          <div class="date-badge"><i class="far fa-calendar"></i> Last 7 days</div>
        </div>
        <div class="stat-grid">
          <div class="stat-card"><div class="stat-info"><div class="label">Total Users</div><div class="value">1,250</div><div class="trend"><i class="fas fa-arrow-up"></i> +12% vs last week</div></div><div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="fas fa-users"></i></div></div>
          <div class="stat-card"><div class="stat-info"><div class="label">Total Donations</div><div class="value">2,100</div><div class="trend"><i class="fas fa-arrow-up"></i> +8% vs last week</div></div><div class="stat-icon" style="background:var(--orange-pale);color:var(--orange)"><i class="fas fa-box-open"></i></div></div>
          <div class="stat-card"><div class="stat-info"><div class="label">Meals Saved</div><div class="value">12,540</div><div class="trend"><i class="fas fa-arrow-up"></i> +15% vs last week</div></div><div class="stat-icon" style="background:#DCFCE7;color:#16A34A"><i class="fas fa-heart"></i></div></div>
          <div class="stat-card"><div class="stat-info"><div class="label">Active NGOs</div><div class="value">45</div><div class="trend"><i class="fas fa-arrow-up"></i> +5% vs last week</div></div><div class="stat-icon" style="background:var(--purple-light);color:var(--purple)"><i class="fas fa-chart-line"></i></div></div>
        </div>
        <div class="charts-row">
          <div class="chart-card"><div class="chart-title">Donations This Week</div><canvas id="donationsChart" height="180"></canvas></div>
          <div class="chart-card"><div class="chart-title">Food by City</div><canvas id="cityChart" height="180"></canvas></div>
          <div class="chart-card"><div class="chart-title">Donation Status</div><div class="donut-wrap"><canvas id="statusChart" height="160" width="160"></canvas><div class="donut-legend"><div class="legend-item"><div style="display:flex;align-items:center;gap:6px"><div class="legend-dot" style="background:var(--orange)"></div>Available</div><span style="font-weight:700">3</span></div><div class="legend-item"><div style="display:flex;align-items:center;gap:6px"><div class="legend-dot" style="background:#3B82F6"></div>Delivered</div><span style="font-weight:700">2</span></div><div class="legend-item"><div style="display:flex;align-items:center;gap:6px"><div class="legend-dot" style="background:#8B5CF6"></div>Claimed</div><span style="font-weight:700">1</span></div></div></div></div>
        </div>
        <div class="section-tag"><i class="fas fa-bolt"></i> Recent Activity</div>
        <div class="table-card">
          <table>
            <thead><tr><th>Type</th><th>Description</th><th>User</th><th>Time</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
              <tr><td><span class="badge donation">donation</span></td><td>New donation: Fresh Biryani</td><td><b>Restaurant A</b></td><td style="color:var(--text-2)">5 min ago</td><td><span class="badge active">active</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><span class="badge claim">claim</span></td><td>Claimed by Food Bank NGO</td><td><b>Food Bank NGO</b></td><td style="color:var(--text-2)">15 min ago</td><td><span class="badge active">active</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><span class="badge volunteer">volunteer</span></td><td>Pickup completed by John</td><td><b>John Volunteer</b></td><td style="color:var(--text-2)">30 min ago</td><td><span class="badge completed">completed</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><span class="badge user">user</span></td><td>New user registered</td><td><b>Jane Doe</b></td><td style="color:var(--text-2)">1 hour ago</td><td><span class="badge active">active</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ── USERS ── -->
      <div class="content-section" id="sec-users">
        <div class="page-header"><div class="page-title"><h2>Users 👥</h2><p>Manage all platform users</p></div><button class="add-btn" onclick="showToast('Add User modal opened','success')"><i class="fas fa-plus"></i> Add User</button></div>
        <div class="users-toolbar">
          <div class="topbar-search" style="width:300px"><i class="fas fa-search" style="color:var(--text-3)"></i><input placeholder="Search users…"/></div>
          <select class="filter-select"><option>All Roles</option><option>Admin</option><option>NGO</option><option>Volunteer</option><option>Donor</option></select>
          <select class="filter-select"><option>All Status</option><option>Active</option><option>Inactive</option></select>
        </div>
        <div class="table-card">
          <table>
            <thead><tr><th>User</th><th>Role</th><th>Email</th><th>City</th><th>Joined</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:var(--orange);width:34px;height:34px;font-size:12px">R</div><b>Restaurant A</b></div></td><td><span class="badge donation">Donor</span></td><td style="color:var(--text-2)">rest@example.com</td><td>Hyderabad</td><td style="color:var(--text-2)">Jan 12, 2026</td><td><span class="badge active">active</span></td><td><div class="action-btns"><button class="icon-btn" onclick="showToast('View user')"><i class="fas fa-eye"></i></button><button class="icon-btn" onclick="showToast('Edit user')"><i class="fas fa-pen"></i></button><button class="icon-btn del" onclick="showToast('User deleted','error')"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#8B5CF6;width:34px;height:34px;font-size:12px">F</div><b>Food Bank NGO</b></div></td><td><span class="badge ngo">NGO</span></td><td style="color:var(--text-2)">ngo@example.com</td><td>Mumbai</td><td style="color:var(--text-2)">Feb 3, 2026</td><td><span class="badge active">active</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#3B82F6;width:34px;height:34px;font-size:12px">J</div><b>John Volunteer</b></div></td><td><span class="badge volunteer">Volunteer</span></td><td style="color:var(--text-2)">john@example.com</td><td>Delhi</td><td style="color:var(--text-2)">Mar 1, 2026</td><td><span class="badge active">active</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#F59E0B;width:34px;height:34px;font-size:12px">J</div><b>Jane Doe</b></div></td><td><span class="badge user">User</span></td><td style="color:var(--text-2)">jane@example.com</td><td>Bangalore</td><td style="color:var(--text-2)">Mar 20, 2026</td><td><span class="badge active">active</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#14B8A6;width:34px;height:34px;font-size:12px">H</div><b>Hotel Grand</b></div></td><td><span class="badge donation">Donor</span></td><td style="color:var(--text-2)">hotel@example.com</td><td>Chennai</td><td style="color:var(--text-2)">Feb 18, 2026</td><td><span class="badge expired">inactive</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ── DONATIONS ── -->
      <div class="content-section" id="sec-donations">
        <div class="page-header"><div class="page-title"><h2>Donations 📦</h2><p>All food donations on the platform</p></div><button class="add-btn" onclick="showToast('Add Donation modal','success')"><i class="fas fa-plus"></i> Add Donation</button></div>
        <div class="table-card">
          <table>
            <thead><tr><th>Food Item</th><th>Donor</th><th>Qty</th><th>City</th><th>Expires</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
              <tr><td><b>Fresh Biryani</b></td><td>Restaurant A</td><td>50 servings</td><td>Hyderabad</td><td style="color:var(--text-2)">Today 8PM</td><td><span class="badge active">available</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><b>Vegetable Curries</b></td><td>Restaurant A</td><td>30 servings</td><td>Mumbai</td><td style="color:var(--text-2)">Today 9PM</td><td><span class="badge claimed">claimed</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><b>Sandwiches & Pastries</b></td><td>Cafe Fresh</td><td>25 pieces</td><td>Bangalore</td><td style="color:var(--red)">Expired</td><td><span class="badge expired">expired</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><b>Extra Breakfast</b></td><td>University Hostel</td><td>100 pieces</td><td>Delhi</td><td style="color:var(--text-2)">Tomorrow 10AM</td><td><span class="badge in-transit">in transit</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
              <tr><td><b>Party Leftovers</b></td><td>Catering Co</td><td>75 servings</td><td>Chennai</td><td style="color:var(--teal)">Delivered</td><td><span class="badge delivered">delivered</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button><button class="icon-btn del"><i class="fas fa-trash"></i></button></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ── NGOS ── -->
      <div class="content-section" id="sec-ngos">
        <div class="page-header"><div class="page-title"><h2>NGOs 🏢</h2><p>Verified partner organizations</p></div><button class="add-btn" onclick="showToast('Add NGO','success')"><i class="fas fa-plus"></i> Add NGO</button></div>
        <div class="table-card">
          <table>
            <thead><tr><th>Organization</th><th>City</th><th>Claims</th><th>Beneficiaries</th><th>Verified</th><th>Actions</th></tr></thead>
            <tbody>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#8B5CF6;width:34px;height:34px;font-size:12px">F</div><b>Food Bank NGO</b></div></td><td>Mumbai</td><td>142</td><td>2,840</td><td><span class="badge active">verified</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button></div></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#3B82F6;width:34px;height:34px;font-size:12px">C</div><b>City Shelter</b></div></td><td>Hyderabad</td><td>98</td><td>1,960</td><td><span class="badge active">verified</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn"><i class="fas fa-pen"></i></button></div></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#F59E0B;width:34px;height:34px;font-size:12px">H</div><b>Hope NGO</b></div></td><td>Delhi</td><td>76</td><td>1,520</td><td><span class="badge claim">pending</span></td><td><div class="action-btns"><button class="icon-btn"><i class="fas fa-eye"></i></button><button class="icon-btn" onclick="showToast('NGO verified! ✓','success')"><i class="fas fa-check"></i></button></div></td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ── VOLUNTEERS ── -->
      <div class="content-section" id="sec-volunteers">
        <div class="page-header"><div class="page-title"><h2>Volunteers 🚴</h2><p>Active delivery volunteers</p></div></div>
        <div class="table-card">
          <table>
            <thead><tr><th>Volunteer</th><th>City</th><th>Pickups</th><th>Meals Delivered</th><th>km Traveled</th><th>Rating</th><th>Status</th></tr></thead>
            <tbody>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#3B82F6;width:34px;height:34px;font-size:12px">J</div><b>John Doe</b></div></td><td>Delhi</td><td>42</td><td>247</td><td>186 km</td><td>⭐ 4.9</td><td><span class="badge active">active</span></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#F97316;width:34px;height:34px;font-size:12px">P</div><b>Priya S</b></div></td><td>Mumbai</td><td>28</td><td>168</td><td>124 km</td><td>⭐ 4.8</td><td><span class="badge active">active</span></td></tr>
              <tr><td><div style="display:flex;align-items:center;gap:10px"><div class="avatar" style="background:#8B5CF6;width:34px;height:34px;font-size:12px">R</div><b>Raju K</b></div></td><td>Hyderabad</td><td>15</td><td>90</td><td>67 km</td><td>⭐ 4.7</td><td><span class="badge in-transit">on trip</span></td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ── ANALYTICS ── -->
      <div class="content-section" id="sec-analytics">
        <div class="page-header"><div class="page-title"><h2>Analytics 📊</h2><p>Platform performance insights</p></div><div class="date-badge"><i class="far fa-calendar"></i> Last 30 days</div></div>
        <div class="stat-grid" style="margin-bottom:22px">
          <div class="stat-card"><div class="stat-info"><div class="label">Avg Response Time</div><div class="value">22<span style="font-size:16px">min</span></div><div class="trend"><i class="fas fa-arrow-down"></i> -8% faster</div></div><div class="stat-icon" style="background:#DBEAFE;color:#3B82F6"><i class="fas fa-clock"></i></div></div>
          <div class="stat-card"><div class="stat-info"><div class="label">Claim Rate</div><div class="value">87%</div><div class="trend"><i class="fas fa-arrow-up"></i> +3%</div></div><div class="stat-icon" style="background:#DCFCE7;color:#16A34A"><i class="fas fa-percentage"></i></div></div>
          <div class="stat-card"><div class="stat-info"><div class="label">Waste Prevented</div><div class="value">3.2<span style="font-size:16px">T</span></div><div class="trend"><i class="fas fa-arrow-up"></i> +12%</div></div><div class="stat-icon" style="background:var(--orange-pale);color:var(--orange)"><i class="fas fa-leaf"></i></div></div>
          <div class="stat-card"><div class="stat-info"><div class="label">CO₂ Saved</div><div class="value">6.4<span style="font-size:16px">T</span></div><div class="trend"><i class="fas fa-arrow-up"></i> +18%</div></div><div class="stat-icon" style="background:#EDE9FE;color:#8B5CF6"><i class="fas fa-globe"></i></div></div>
        </div>
        <div class="analytics-grid">
          <div class="chart-card"><div class="chart-title">Monthly Donations Trend</div><canvas id="trendChart" height="200"></canvas></div>
          <div class="chart-card"><div class="chart-title">User Growth</div><canvas id="userChart" height="200"></canvas></div>
          <div class="chart-card"><div class="chart-title">Food Categories</div><canvas id="catChart" height="200"></canvas></div>
          <div class="chart-card"><div class="chart-title">City-wise Distribution</div><canvas id="distChart" height="200"></canvas></div>
        </div>
      </div>

      <!-- ── IMPACT ── -->
      <div class="content-section" id="sec-impact">
        <div class="page-header"><div class="page-title"><h2>Impact 💚</h2><p>Our collective difference</p></div></div>
        <div class="impact-hero">
          <h2>Together We're Changing Lives 🌟</h2>
          <p>Every meal shared is a step toward a hunger-free world.</p>
          <div class="impact-stats">
            <div class="impact-stat"><div class="iv">12,540</div><div class="il">Meals Saved</div></div>
            <div class="impact-stat"><div class="iv">3.2T</div><div class="il">Waste Prevented</div></div>
            <div class="impact-stat"><div class="iv">45</div><div class="il">NGO Partners</div></div>
          </div>
        </div>
        <div class="charts-row" style="grid-template-columns:1fr 1fr">
          <div class="chart-card"><div class="chart-title">Meals Saved Over Time</div><canvas id="impactChart" height="200"></canvas></div>
          <div class="chart-card"><div class="chart-title">Top Contributors 🏆</div>
            <table style="width:100%">
              <thead><tr><th>#</th><th>Name</th><th>Donations</th><th>Meals</th></tr></thead>
              <tbody>
                <tr><td>🥇</td><td><b>Restaurant A</b></td><td>142</td><td>4,200</td></tr>
                <tr><td>🥈</td><td><b>Hotel Grand</b></td><td>98</td><td>2,940</td></tr>
                <tr><td>🥉</td><td><b>Hostel Mess</b></td><td>76</td><td>2,280</td></tr>
                <tr><td>4</td><td><b>Cafe Fresh</b></td><td>54</td><td>1,620</td></tr>
                <tr><td>5</td><td><b>Catering Co</b></td><td>42</td><td>1,260</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div><!-- /content -->
  </div><!-- /main-wrap -->
</div><!-- /page -->

<!-- CONFIRM MODAL -->
<div class="modal-overlay" id="modal">
  <div class="modal">
    <button class="modal-close" onclick="closeModal()">✕</button>
    <h3 id="modal-title">Confirm</h3>
    <p id="modal-body" style="color:var(--text-2);font-size:14px;margin-bottom:20px;line-height:1.5"></p>
    <div style="display:flex;gap:10px">
      <button onclick="closeModal()" style="flex:1;padding:11px;border-radius:10px;border:1.5px solid var(--border);background:var(--white);font-size:14px;font-weight:600;cursor:pointer;font-family:inherit">Cancel</button>
      <button id="modal-confirm" style="flex:1;padding:11px;border-radius:12px;border:none;background:linear-gradient(135deg,var(--orange),var(--orange-dark));color:#fff;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit">Confirm</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"><i class="fas fa-check-circle"></i> <span id="toast-msg">Done!</span></div>

<script src="app.js"></script>
<script>
let charts = {};

function adminNav(el, sectionId) {
  document.querySelectorAll('#admin-sidebar .nav-item').forEach(n => n.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
  const sec = document.getElementById(sectionId);
  if (sec) sec.classList.add('active');
  if (sectionId === 'sec-dash') setTimeout(initDashCharts, 100);
  if (sectionId === 'sec-analytics') setTimeout(initAnalyticsCharts, 100);
  if (sectionId === 'sec-impact') setTimeout(initImpactChart, 100);
}

function initDashCharts() {
  ['donationsChart','cityChart','statusChart'].forEach(id => { if(charts[id]) charts[id].destroy(); });
  const c1 = document.getElementById('donationsChart');
  if (c1) {
    const g = c1.getContext('2d');
    const grad = g.createLinearGradient(0,0,0,200);
    grad.addColorStop(0,'rgba(255,107,53,.35)');
    grad.addColorStop(1,'rgba(255,107,53,0)');
    charts.donationsChart = new Chart(c1, { type:'line', data:{ labels:['Tue','Wed','Thu','Fri','Sat','Sun','Mon'], datasets:[{ data:[28,42,35,55,48,63,71], borderColor:'#FF6B35', backgroundColor:grad, borderWidth:2.5, fill:true, tension:.45, pointBackgroundColor:'#FF6B35', pointRadius:4 }] }, options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'#F3F4F6'}},x:{grid:{display:false}}}} });
  }
  const c2 = document.getElementById('cityChart');
  if (c2) charts.cityChart = new Chart(c2, { type:'bar', data:{ labels:['Delhi','Mumbai','Bangalore','Chennai','Hyderabad'], datasets:[{ data:[120,95,80,65,55], backgroundColor:['#FF6B35','#F97316','#FBBF24','#3B82F6','#8B5CF6'], borderRadius:8, borderSkipped:false }] }, options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'#F3F4F6'}},x:{grid:{display:false}}}} });
  const c3 = document.getElementById('statusChart');
  if (c3) charts.statusChart = new Chart(c3, { type:'doughnut', data:{ labels:['Available','Delivered','Claimed'], datasets:[{ data:[3,2,1], backgroundColor:['#FF6B35','#3B82F6','#8B5CF6'], borderWidth:0, hoverOffset:8 }] }, options:{ responsive:false, cutout:'72%', plugins:{ legend:{display:false} } }, plugins:[{ id:'centerText', beforeDraw(chart){ const{width,height,ctx}=chart; ctx.save(); ctx.font='bold 24px Plus Jakarta Sans'; ctx.fillStyle='#1A1D23'; ctx.textAlign='center'; ctx.textBaseline='middle'; ctx.fillText('6',width/2,height/2-10); ctx.font='13px DM Sans'; ctx.fillStyle='#6B7280'; ctx.fillText('Total',width/2,height/2+14); ctx.restore(); } }] });
}

function initAnalyticsCharts() {
  ['trendChart','userChart','catChart','distChart'].forEach(id => { if(charts[id]) charts[id].destroy(); });
  const months = ['Oct','Nov','Dec','Jan','Feb','Mar'];
  const c = document.getElementById('trendChart');
  if (c) {
    const grad = c.getContext('2d').createLinearGradient(0,0,0,200);
    grad.addColorStop(0,'rgba(255,107,53,.35)'); grad.addColorStop(1,'rgba(255,107,53,0)');
    charts.trendChart = new Chart(c, { type:'line', data:{ labels:months, datasets:[{ data:[320,410,480,520,480,560], borderColor:'#FF6B35', backgroundColor:grad, fill:true, tension:.45, borderWidth:2.5, pointBackgroundColor:'#FF6B35', pointRadius:4 }] }, options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'#F3F4F6'}},x:{grid:{display:false}}}} });
  }
  const c2 = document.getElementById('userChart');
  if (c2) charts.userChart = new Chart(c2, { type:'bar', data:{ labels:months, datasets:[{ data:[900,1020,1080,1150,1200,1250], backgroundColor:'#3B82F6', borderRadius:8, borderSkipped:false }] }, options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:false,grid:{color:'#F3F4F6'}},x:{grid:{display:false}}}} });
  const c3 = document.getElementById('catChart');
  if (c3) charts.catChart = new Chart(c3, { type:'doughnut', data:{ labels:['Cooked Meals','Bakery','Groceries','Beverages','Other'], datasets:[{ data:[45,25,15,10,5], backgroundColor:['#FF6B35','#F97316','#3B82F6','#8B5CF6','#F59E0B'], borderWidth:0, hoverOffset:8 }] }, options:{responsive:true,plugins:{legend:{position:'right'}},cutout:'65%'} });
  const c4 = document.getElementById('distChart');
  if (c4) charts.distChart = new Chart(c4, { type:'bar', data:{ labels:['Delhi','Mumbai','Blr','Chennai','Hyd'], datasets:[{ data:[3200,2400,2100,1800,1440], backgroundColor:['#FF6B35','#F97316','#FBBF24','#3B82F6','#8B5CF6'], borderRadius:8, borderSkipped:false }] }, options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'#F3F4F6'}},x:{grid:{display:false}}}} });
}

function initImpactChart() {
  if (charts.impactChart) charts.impactChart.destroy();
  const c = document.getElementById('impactChart');
  if (!c) return;
  const grad = c.getContext('2d').createLinearGradient(0,0,0,200);
  grad.addColorStop(0,'rgba(255,107,53,.35)'); grad.addColorStop(1,'rgba(255,107,53,0)');
  charts.impactChart = new Chart(c, { type:'line', data:{ labels:['Oct','Nov','Dec','Jan','Feb','Mar'], datasets:[{ data:[1200,1800,2200,2600,2900,3200], borderColor:'#FF6B35', backgroundColor:grad, fill:true, tension:.45, borderWidth:2.5, pointBackgroundColor:'#FF6B35', pointRadius:4 }] }, options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'#F3F4F6'}},x:{grid:{display:false}}}} });
}

// Init charts on load
setTimeout(initDashCharts, 200);
</script>
</body>
</html>
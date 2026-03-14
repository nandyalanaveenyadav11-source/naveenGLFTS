<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLFTS Unified Command Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --bg-dark: #0f172a;
            --sidebar-bg: #1e293b;
            --card-glass: rgba(30, 41, 59, 0.7);
            --border-glass: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
            --success: #22c55e;
            --warning: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg-dark);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Login Screen Styling */
        #login-screen {
            position: fixed;
            inset: 0;
            z-index: 100;
            background: radial-gradient(circle at top left, #1e293b, #0f172a);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: var(--card-glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-glass);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
        }

        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, #a5b4fc, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-item {
            padding: 0.8rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 12px;
            cursor: pointer;
            color: var(--text-dim);
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(99, 102, 241, 0.1);
            color: var(--text-main);
        }

        .nav-item.active {
            border-left: 4px solid var(--primary);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2.5rem;
            overflow-y: auto;
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--card-glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-glass);
            padding: 1.5rem;
            border-radius: 20px;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 600;
            margin: 0.5rem 0;
            color: var(--primary-light);
        }

        .stat-label {
            color: var(--text-dim);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Shared UI Elements */
        .card {
            background: var(--card-glass);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        input, select {
            width: 100%;
            padding: 0.8rem 1rem;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            color: white;
            margin-top: 0.5rem;
        }

        .btn {
            width: 100%;
            padding: 0.9rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 1rem;
            transition: 0.3s;
        }

        .btn:hover { background: var(--primary-light); }

        .demo-chips {
            margin-top: 1.5rem;
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .chip {
            padding: 0.4rem 0.8rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-glass);
            border-radius: 50px;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .hidden { display: none !important; }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .results-table th, .results-table td {
            text-align: left;
            padding: 1rem;
            border-bottom: 1px solid var(--border-glass);
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        .badge-motion { background: rgba(34, 197, 94, 0.1); color: #4ade80; }
        .badge-idle { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
    </style>
</head>
<body>
    <!-- 1. Login Screen (Initially Visible) -->
    <div id="login-screen">
        <div class="login-card">
            <h1 style="text-align: center; margin-bottom: 2rem; background: linear-gradient(135deg, #a5b4fc, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">GLFTS Command Center</h1>
            <div style="margin-bottom: 1.5rem;">
                <label style="color: var(--text-dim); font-size: 0.85rem;">Email Address</label>
                <input type="email" id="login-email" placeholder="admin@glfts.com">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="color: var(--text-dim); font-size: 0.85rem;">Password</label>
                <input type="password" id="login-pass" value="password123">
            </div>
            <button class="btn" onclick="handleLogin()">Sign In</button>
            <div class="demo-chips">
                <div class="chip" onclick="fillLogin('admin@glfts.com')">Admin</div>
                <div class="chip" onclick="fillLogin('dispatcher@glfts.com')">Dispatcher</div>
            </div>
        </div>
    </div>

    <!-- 2. Main Portal (Initially Hidden) -->
    <div id="main-portal" class="hidden" style="display: flex; width: 100%;">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">GLFTS Admin</div>
            <div class="nav-item active" onclick="showTab('dashboard', this)">Fleet Overview</div>
            <div class="nav-item" onclick="showTab('tracking', this)">Shipment Tracking</div>
            <div class="nav-item" onclick="showTab('calculator', this)">Weight Calculator</div>
            <div style="margin-top: auto; border-top: 1px solid var(--border-glass); padding-top: 2rem;">
                <a href="/docs" target="_blank" class="nav-item" style="text-decoration: none;">Interactive API Docs</a>
                <div class="nav-item" onclick="logout()">Logout</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Dashboard Tab -->
            <div id="tab-dashboard" class="tab-content">
                <div class="header">
                    <h1>Fleet Dashboard</h1>
                    <div class="status-badge badge-motion">System Active</div>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Vehicles in Motion</div>
                        <div class="stat-value" id="motion-count">...</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Vehicles Idle</div>
                        <div class="stat-value" id="idle-count">...</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active Shipments</div>
                        <div class="stat-value">20</div>
                    </div>
                </div>
            </div>

            <!-- Tracking Tab -->
            <div id="tab-tracking" class="tab-content hidden">
                <div class="header"><h1>Shipment Tracking</h1></div>
                <div class="card">
                    <h2>Geospatial Filter</h2>
                    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                        <select id="origin-select">
                            <option value="">Any Origin...</option>
                        </select>
                        <select id="destination-select">
                            <option value="">Any Destination...</option>
                        </select>
                        <button class="btn" style="width: auto; margin-top: 0.5rem;" onclick="searchShipments()">Search</button>
                    </div>
                    <table class="results-table">
                        <thead><tr><th>Code</th><th>Origin</th><th>Dest</th><th>Weight</th><th>Status</th></tr></thead>
                        <tbody id="shipment-tbody"></tbody>
                    </table>
                </div>
            </div>

            <!-- Calculator Tab -->
            <div id="tab-calculator" class="tab-content hidden">
                <div class="header"><h1>Weight Calculator</h1></div>
                <div class="card">
                    <h2>Capacity Tool</h2>
                    <select id="vehicle-select" style="margin-bottom: 1rem;"><option value="">Select Truck...</option></select>
                    <button class="btn" style="margin-top: 0;" onclick="calculateCapacity()">Calculate Remaining Payload</button>
                    <div id="calculator-result" class="hidden" style="margin-top: 2rem;">
                        <div class="stats-grid" style="grid-template-columns: 1fr 1fr;">
                            <div class="stat-card"><div class="stat-label">Total</div><div class="stat-value" id="total-cap">0</div></div>
                            <div class="stat-card"><div class="stat-label">Remaining</div><div class="stat-value" id="remain-cap" style="color: var(--success);">0</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auth Logic
        function fillLogin(email) { document.getElementById('login-email').value = email; }
        function handleLogin() {
            document.getElementById('login-screen').classList.add('hidden');
            document.getElementById('main-portal').classList.remove('hidden');
            loadDashboard();
            loadSearchData();
        }
        function logout() { window.location.reload(); }

        // Tab Logic
        function showTab(tabId, el) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            if(el) el.classList.add('active');
            if(tabId === 'calculator') loadVehicles();
        }

        // Feature Logic
        async function loadDashboard() {
            const res = await fetch('/api/dashboard');
            const data = await res.json();
            document.getElementById('motion-count').innerText = data.vehicles_in_motion;
            document.getElementById('idle-count').innerText = data.vehicles_idle;
        }

        async function loadSearchData() {
            const res = await fetch('/api/locations');
            const data = await res.json();
            
            const oSelect = document.getElementById('origin-select');
            const dSelect = document.getElementById('destination-select');

            oSelect.innerHTML = '<option value="">Any Origin...</option>' + 
                data.origins.map(o => `<option value="${o}">${o}</option>`).join('');
            
            dSelect.innerHTML = '<option value="">Any Destination...</option>' + 
                data.destinations.map(d => `<option value="${d}">${d}</option>`).join('');
        }

        async function searchShipments() {
            const o = document.getElementById('origin-select').value;
            const d = document.getElementById('destination-select').value;
            const url = `/api/shipments?origin=${o}&destination=${d}`;
            const res = await fetch(url);
            const data = await res.json();
            document.getElementById('shipment-tbody').innerHTML = data.map(s => `
                <tr><td>${s.tracking_code.substring(0,8)}</td><td>${s.origin}</td><td>${s.destination}</td><td>${s.weight_kg}kg</td>
                <td><span class="status-badge ${s.status === 'In_Transit' ? 'badge-motion' : 'badge-idle'}">${s.status}</span></td></tr>
            `).join('');
        }

        async function loadVehicles() {
            const select = document.getElementById('vehicle-select');
            if (select.children.length <= 1) {
                const res = await fetch('/api/vehicles');
                const data = await res.json();
                select.innerHTML = '<option value="">Select Truck...</option>' + 
                    data.map(v => `<option value="${v.id}">${v.license_plate} (${v.vin_number.substring(0,8)}...)</option>`).join('');
            }
        }

        async function calculateCapacity() {
            const res = await fetch(`/api/vehicles/${document.getElementById('vehicle-select').value}/remaining-capacity`);
            const data = await res.json();
            document.getElementById('total-cap').innerText = data.vehicle_capacity + " Kg";
            document.getElementById('remain-cap').innerText = data.remaining_capacity + " Kg";
            document.getElementById('calculator-result').classList.remove('hidden');
        }
    </script>
</body>
</html>

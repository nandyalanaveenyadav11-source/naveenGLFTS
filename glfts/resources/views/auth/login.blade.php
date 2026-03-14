<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GLFTS Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-dark: #0f172a;
            --card-glass: rgba(30, 41, 59, 0.7);
            --border-glass: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: radial-gradient(circle at top left, #1e293b, #0f172a);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            position: relative;
        }

        .login-card {
            background: var(--card-glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: 600;
            background: linear-gradient(135deg, #a5b4fc, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: var(--text-dim);
        }

        input {
            width: 100%;
            padding: 0.8rem 1rem;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 0.9rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 1rem;
        }

        .login-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }

        .demo-helpers {
            margin-top: 2rem;
            text-align: center;
        }

        .demo-helpers p {
            font-size: 0.85rem;
            color: var(--text-dim);
            margin-bottom: 1rem;
        }

        .demo-chips {
            display: flex;
            gap: 0.8rem;
            justify-content: center;
        }

        .chip {
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glass);
            border-radius: 50px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .chip:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <h1>GLFTS Portal</h1>
            </div>

            <form action="/login" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="email" name="email" placeholder="admin@glfts.com" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="login-btn">Sign In</button>
            </form>

            <div class="demo-helpers">
                <p>Demo Quick Login</p>
                <div class="demo-chips">
                    <div class="chip" onclick="fillDemo('admin@glfts.com')">Admin</div>
                    <div class="chip" onclick="fillDemo('dispatcher@glfts.com')">Dispatcher</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillDemo(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password123';
        }
    </script>
</body>
</html>

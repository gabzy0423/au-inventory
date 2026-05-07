<?php $base_url = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AU Inventory - Login</title>
    <link rel="icon" type="image/png" href="<?= $base_url ?>/images/logo.png">
    <link rel="stylesheet" href="<?= $base_url ?>/css/app.css">
    <script defer src="<?= $base_url ?>/js/alpine.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-deep:   #0f172a;
            --blue-mid:    #1e3a5f;
            --blue-accent: #2563eb;
            --blue-light:  #3b82f6;
            --white:       #ffffff;
            --gray-50:     #f8fafc;
            --gray-100:    #f1f5f9;
            --gray-200:    #e2e8f0;
            --gray-400:    #94a3b8;
            --gray-500:    #64748b;
            --gray-700:    #334155;
            --gray-900:    #0f172a;
            --error:       #ef4444;
        }

        html, body {
            width: 100%;
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            overflow-x: hidden;
        }

        .layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ─── LEFT PANEL ─────────────────────────────────────────── */
        .left-panel {
            width: 48%;
            min-height: 100vh;
            background: var(--blue-deep);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        /* subtle dot grid */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* soft blue glow centre */
        .left-panel::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 520px; height: 520px;
            background: radial-gradient(circle, rgba(37,99,235,0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .left-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
            text-align: center;
            padding: 0 40px;
        }

        /* Logo circle */
        .logo-wrap {
            width: 136px;
            height: 136px;
            border-radius: 32px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
        }

        .logo-wrap img {
            width: 84px;
            height: 84px;
            object-fit: contain;
            filter: brightness(1.05);
        }

        /* Brand name — same feel as "AU Inventory" badge */
        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--white);
            line-height: 1;
            margin-bottom: 10px;
        }

        .brand-name span {
            color: var(--blue-light);
        }

        /* Tagline pill */
        .tagline-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(59,130,246,0.12);
            border: 1px solid rgba(59,130,246,0.22);
            border-radius: 100px;
            padding: 5px 14px;
            margin-bottom: 36px;
        }

        .tagline-pill span {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--blue-light);
        }

        .tagline-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--blue-light);
            opacity: 0.7;
        }

        /* Divider */
        .divider {
            width: 44px;
            height: 2px;
            background: rgba(255,255,255,0.12);
            border-radius: 2px;
            margin-bottom: 36px;
        }

        /* Headline */
        .headline {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1.35;
            letter-spacing: -0.02em;
            margin-bottom: 14px;
        }

        .headline em {
            font-style: normal;
            color: rgba(255,255,255,0.45);
            font-weight: 400;
        }

        /* Subtext */
        .subtext {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.38);
            line-height: 1.65;
            max-width: 280px;
            margin-bottom: 52px;
        }

        /* Stats row */
        .stats-row {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding: 0 28px;
        }

        .stat-item:first-child { padding-left: 0; }
        .stat-item:last-child  { padding-right: 0; }

        .stat-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.03em;
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.32);
        }

        .stat-sep {
            width: 1px;
            height: 32px;
            background: rgba(255,255,255,0.10);
        }

        /* ─── RIGHT PANEL ─────────────────────────────────────────── */
        .right-panel {
            flex: 1;
            min-height: 100vh;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
        }

        .form-card {
            width: 100%;
            max-width: 400px;
            animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
        }

        .form-header { margin-bottom: 36px; }

        .form-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.03em;
            margin-bottom: 6px;
        }

        .form-sub {
            font-size: 0.9rem;
            color: var(--gray-500);
        }

        /* Mobile Header - Hidden by default */
        .mobile-logo-header {
            display: none;
            text-align: center;
            margin-bottom: 32px;
        }

        .mobile-logo-wrap {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .mobile-logo-wrap img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .mobile-brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.02em;
        }

        .mobile-brand-name span {
            color: var(--blue-accent);
        }

        /* Error alert */
        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 24px;
        }

        .alert-error-icon {
            width: 18px; height: 18px;
            color: var(--error);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-error-text {
            font-size: 0.85rem;
            color: #b91c1c;
            font-weight: 500;
            line-height: 1.5;
        }

        /* Form group */
        .form-group { margin-bottom: 20px; }

        .form-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 7px;
        }

        label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--gray-700);
            letter-spacing: 0.01em;
        }

        .forgot-link {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--blue-accent);
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .forgot-link:hover { opacity: 0.75; }

        /* Input wrapper */
        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px; height: 18px;
            color: var(--gray-400);
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            background: var(--gray-50);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--gray-900);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            -webkit-appearance: none;
        }

        .form-input::placeholder { color: var(--gray-400); }

        .form-input:focus {
            border-color: var(--blue-accent);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
        }

        /* Eye toggle */
        .eye-btn {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 2px;
            color: var(--gray-400);
            transition: color 0.2s;
            display: flex;
            align-items: center;
        }

        .eye-btn:hover { color: var(--blue-accent); }

        .eye-btn svg { width: 18px; height: 18px; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--blue-accent);
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 12px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            letter-spacing: 0.01em;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -4px rgba(37,99,235,0.35);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-submit svg { width: 17px; height: 17px; }

        /* Footer */
        .form-footer {
            text-align: center;
            margin-top: 32px;
            font-size: 0.78rem;
            color: var(--gray-400);
            letter-spacing: 0.01em;
        }

        /* Fade-up animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── RESPONSIVE ─────────────────────────────────────────── */
        @media (max-width: 992px) {
            .left-panel { width: 40%; }
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 32px 24px; }
            .mobile-logo-header { display: block; }
            .form-header { text-align: center; }
        }
    </style>
</head>
<body>
<div class="layout">

    <!-- ── LEFT PANEL ── -->
    <div class="left-panel">
        <div class="left-content">

            <!-- Big logo -->
            <div class="logo-wrap">
                <img src="<?= $base_url ?>/images/logo.png" alt="AU Inventory Logo">
            </div>

            <!-- Brand name -->
            <div class="brand-name">AU <span>Inventory</span></div>

            <!-- Tagline pill -->
            <div class="tagline-pill">
                <div class="tagline-dot"></div>
                <span>Inventory Management System</span>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Headline -->
            <div class="headline">
                The smarter way to<br>
                <em>manage your assets.</em>
            </div>

            <!-- Subtext -->
            <p class="subtext">
                Track, audit, and manage your organization's inventory with precision and clarity.
            </p>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-item">
                    <span class="stat-value">99.9%</span>
                    <span class="stat-label">Uptime</span>
                </div>
                <div class="stat-sep"></div>
                <div class="stat-item">
                    <span class="stat-value">24/7</span>
                    <span class="stat-label">Active Sync</span>
                </div>
                <div class="stat-sep"></div>
                <div class="stat-item">
                    <span class="stat-value">Real-time</span>
                    <span class="stat-label">Tracking</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="right-panel">
        <div class="form-card">

            <!-- Mobile Logo Header -->
            <div class="mobile-logo-header">
                <div class="mobile-logo-wrap">
                    <img src="<?= $base_url ?>/images/logo.png" alt="AU Inventory Logo">
                </div>
                <div class="mobile-brand-name">AU <span>Inventory</span></div>
            </div>

            <div class="form-header">
                <div class="form-title">Welcome back</div>
                <p class="form-sub">Sign in to your AU Inventory account.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert-error">
                    <svg class="alert-error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <span class="alert-error-text">
                        <?php if ($_GET['error'] === 'account_archived'): ?>
                            Your account has been archived. Please contact your administrator.
                        <?php elseif ($_GET['error'] === 'login_required'): ?>
                            Session expired or login required. Please sign in.
                        <?php elseif ($_GET['error'] === 'unauthorized'): ?>
                            Access denied. You do not have permission to view that section.
                        <?php else: ?>
                            Incorrect email or password. Please try again.
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>

            <form action="<?= $base_url ?>/login" method="POST" autocomplete="off">

                <!-- Email -->
                <div class="form-group">
                    <div class="form-label-row">
                        <label for="email">Email Address</label>
                    </div>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input
                            id="email" type="email" name="email"
                            class="form-input" placeholder="name@company.com"
                            required autofocus autocomplete="off">
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div class="form-label-row">
                        <label for="password">Password</label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>
                    <div class="input-wrap">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">  
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input
                            id="password" type="password" name="password"
                            class="form-input" style="padding-right: 44px;"
                            placeholder="Enter your password"
                            required autocomplete="new-password">
                        <button type="button" class="eye-btn" onclick="togglePassword()">
                            <svg id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    Sign In
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                              d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>

            </form>

            <div class="form-footer">
                &copy; <?php echo date('Y'); ?> AU Inventory. All rights reserved.
            </div>

        </div>
    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7
                         a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243
                         M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29
                         m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    }
</script>

</body>
</html>
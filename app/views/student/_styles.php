<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --bg: #0f172a;
        --surface: #1e293b;
        --surface-2: #334155;
        --accent: #38bdf8;
        --accent-dim: #0ea5e9;
        --text: #f1f5f9;
        --muted: #94a3b8;
        --border: rgba(148, 163, 184, 0.2);
        --success: #34d399;
        --warning: #fbbf24;
    }

    body {
        font-family: 'Segoe UI', system-ui, sans-serif;
        background: linear-gradient(135deg, var(--bg) 0%, #1a1f3a 100%);
        color: var(--text);
        min-height: 100vh;
        line-height: 1.6;
    }

    .student-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
        background: rgba(15, 23, 42, 0.85);
        border-bottom: 1px solid var(--border);
        backdrop-filter: blur(8px);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .nav-brand {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--accent);
        letter-spacing: 0.02em;
    }

    .nav-links a {
        color: var(--muted);
        text-decoration: none;
        font-size: 0.95rem;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        transition: color 0.2s, background 0.2s;
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: var(--text);
        background: var(--surface);
    }

    .nav-sep {
        color: var(--surface-2);
        margin: 0 0.25rem;
    }

    .page-wrap {
        max-width: 900px;
        margin: 0 auto;
        padding: 2.5rem 1.5rem 4rem;
    }

    .page-title {
        font-size: clamp(1.75rem, 4vw, 2.25rem);
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .page-subtitle {
        color: var(--muted);
        margin-bottom: 2rem;
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
    }

    .card h2 {
        font-size: 1.15rem;
        margin-bottom: 1.25rem;
        color: var(--accent);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }

    .info-item label {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--muted);
        margin-bottom: 0.25rem;
    }

    .info-item span {
        font-size: 1rem;
        font-weight: 500;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-success {
        background: rgba(52, 211, 153, 0.15);
        color: var(--success);
        border: 1px solid rgba(52, 211, 153, 0.3);
    }

    .badge-warning {
        background: rgba(251, 191, 36, 0.15);
        color: var(--warning);
        border: 1px solid rgba(251, 191, 36, 0.3);
    }

    .tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        list-style: none;
    }

    .tag-list li {
        background: rgba(56, 189, 248, 0.12);
        color: var(--accent);
        padding: 0.3rem 0.75rem;
        border-radius: 6px;
        font-size: 0.85rem;
        border: 1px solid rgba(56, 189, 248, 0.25);
    }

    .btn {
        display: inline-block;
        padding: 0.65rem 1.25rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s, transform 0.15s;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: var(--accent);
        color: var(--bg);
    }

    .btn-primary:hover {
        background: var(--accent-dim);
        transform: translateY(-1px);
    }

    .alert {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .alert-info {
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.3);
        color: var(--accent);
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), #818cf8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--bg);
        flex-shrink: 0;
    }

    .bio-text {
        color: var(--muted);
        line-height: 1.7;
        margin-top: 0.5rem;
    }
</style>

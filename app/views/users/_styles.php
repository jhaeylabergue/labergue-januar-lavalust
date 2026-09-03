<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
        --ink: #eef2f6;
        --muted: #a9b7c6;
        --bg-a: #1b2a4a;
        --bg-b: #3a2a5c;
        --bg-c: #164a4a;
        --glass: rgba(255, 255, 255, 0.08);
        --glass-strong: rgba(255, 255, 255, 0.14);
        --line: rgba(255, 255, 255, 0.22);
        --accent: #6fe3c4;
        --accent-dark: #37b897;
    }

    body {
        margin: 0;
        color: var(--ink);
        background:
            radial-gradient(circle at 15% 10%, var(--bg-c) 0, transparent 45%),
            radial-gradient(circle at 85% 15%, var(--bg-b) 0, transparent 50%),
            radial-gradient(circle at 50% 90%, var(--bg-a) 0, transparent 60%),
            var(--bg-a);
        background-attachment: fixed;
        font-family: 'Segoe UI', system-ui, sans-serif;
        min-height: 100vh;
    }

    .users-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.25rem max(1.5rem, calc((100% - 1120px) / 2));
        border-bottom: 1px solid var(--line);
        background: var(--glass);
        backdrop-filter: blur(18px) saturate(140%);
        -webkit-backdrop-filter: blur(18px) saturate(140%);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .eyebrow, .kicker {
        display: block;
        margin: 0 0 .3rem;
        color: var(--accent);
        font: 700 .72rem/1.2 'Segoe UI', sans-serif;
        letter-spacing: .1em;
    }

    .brand { font-size: 1.15rem; font-weight: 600; }

    .portal-link {
        color: var(--ink);
        font: 600 .86rem 'Segoe UI', sans-serif;
        text-decoration: none;
        border-bottom: 1px solid var(--accent);
        padding-bottom: .2rem;
    }

    .page-wrap { max-width: 1120px; margin: 0 auto; padding: 4.5rem 1.5rem; }
    .page-heading { display: flex; align-items: end; justify-content: space-between; gap: 2rem; margin-bottom: 2rem; }
    .page-title { margin: 0; font-size: clamp(2.4rem, 6vw, 4.8rem); line-height: .95; font-weight: 600; letter-spacing: -.01em; }
    .page-subtitle { color: var(--muted); font: 1rem/1.6 'Segoe UI', sans-serif; margin: .8rem 0 0; }

    code {
        color: var(--accent);
        font-family: Consolas, monospace;
        font-size: .9em;
        background: var(--glass);
        padding: .1em .35em;
        border-radius: 6px;
        border: 1px solid var(--line);
    }

    .record-count {
        color: var(--accent);
        font: 700 .8rem 'Segoe UI', sans-serif;
        white-space: nowrap;
        background: var(--glass);
        border: 1px solid var(--line);
        padding: .4rem .8rem;
        border-radius: 999px;
    }

    .table-panel {
        overflow: hidden;
        background: var(--glass);
        backdrop-filter: blur(24px) saturate(150%);
        -webkit-backdrop-filter: blur(24px) saturate(150%);
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .table-wrap { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; font: .95rem/1.5 'Segoe UI', sans-serif; }
    .data-table th, .data-table td { text-align: left; padding: 1rem 1.15rem; border-bottom: 1px solid var(--line); white-space: nowrap; }
    .data-table th {
        background: rgba(255, 255, 255, 0.06);
        color: var(--ink);
        font-size: .72rem;
        letter-spacing: .08em;
    }
    .data-table tbody tr:last-child td { border-bottom: 0; }
    .data-table tbody tr:hover { background: var(--glass-strong); }

    @media (max-width: 600px) {
        .users-header { align-items: flex-start; }
        .page-wrap { padding-top: 3rem; }
        .page-heading { align-items: flex-start; flex-direction: column; gap: 1rem; }
        .table-panel { border-radius: 14px; }
    }
</style>
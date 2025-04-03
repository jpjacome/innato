<?php
// Set the content type header to CSS
header('Content-Type: text/css');

// Disable caching for development
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Define all your CSS styles here
?>
/* Control Panel Styles */
:root {
    --primary-color: #4F46E5;
    --secondary-color: #1f2937;
    --accent-color: #6366f1;
    --white: #ffffff;
    --text-color: #f9fafb;
}

body {
    background-color: var(--secondary-color);
    color: var(--text-color);
    font-family: ui-sans-serif, system-ui, sans-serif;
    line-height: 1.5;
}

.control-panel-card, .auth-card {
    background-color: #111827;
    border: 1px solid var(--accent-color);
    border-radius: 0.5rem;
    padding: 2rem;
    margin-bottom: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.auth-card {
    max-width: 28rem;
    margin-left: auto;
    margin-right: auto;
    margin-top: 2rem;
}

.control-panel-title, .auth-title {
    color: var(--white);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.control-panel-button, .form-button {
    display: inline-block;
    background-color: var(--primary-color);
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.control-panel-button:hover, .form-button:hover {
    background-color: #4338ca;
}

.control-panel-input, .form-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #4b5563;
    border-radius: 0.375rem;
    background-color: #374151;
    color: var(--white);
    line-height: 1.25;
}

.control-panel-input:focus, .form-input:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #d1d5db;
    margin-bottom: 0.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-checkbox {
    margin-right: 0.5rem;
}

.form-link {
    color: var(--accent-color);
    text-decoration: none;
}

.form-link:hover {
    text-decoration: underline;
}

/* Dashboard specific styles */
.dashboard-header {
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--accent-color);
    margin-bottom: 2rem;
}

.dashboard-title {
    color: var(--white);
    font-size: 2rem;
    font-weight: 700;
}

.dashboard-nav {
    margin-bottom: 2rem;
}

.dashboard-nav-item {
    display: block;
    padding: 0.75rem 1rem;
    color: #d1d5db;
    text-decoration: none;
    border-radius: 0.375rem;
    margin-bottom: 0.5rem;
}

.dashboard-nav-item:hover, .dashboard-nav-item.active {
    background-color: #374151;
    color: var(--white);
}

.dashboard-card {
    background-color: #111827;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Table styles */
.control-panel-table {
    width: 100%;
    border-collapse: collapse;
}

.control-panel-table th {
    text-align: left;
    padding: 0.75rem;
    font-weight: 600;
    border-bottom: 1px solid #4b5563;
    color: #d1d5db;
}

.control-panel-table td {
    padding: 0.75rem;
    border-bottom: 1px solid #374151;
}

.control-panel-table tr:hover {
    background-color: #1f2937;
}

/* Alert messages */
.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 0.375rem;
}

.alert-success {
    background-color: rgba(16, 185, 129, 0.2);
    border: 1px solid rgba(16, 185, 129, 0.5);
    color: #d1fae5;
}

.alert-error {
    background-color: rgba(239, 68, 68, 0.2);
    border: 1px solid rgba(239, 68, 68, 0.5);
    color: #fee2e2;
}

/* General utility classes */
.mt-4 {
    margin-top: 1rem;
}

.mb-4 {
    margin-bottom: 1rem;
}

.flex {
    display: flex;
}

.justify-between {
    justify-content: space-between;
}

.items-center {
    align-items: center;
}

/* Login specific styles */
.login-container {
    max-width: 28rem;
    margin: 3rem auto;
}

.login-title {
    text-align: center;
    margin-bottom: 2rem;
    color: #f9fafb;
}

.forgot-password {
    text-align: right;
    display: block;
    margin-bottom: 1rem;
} 
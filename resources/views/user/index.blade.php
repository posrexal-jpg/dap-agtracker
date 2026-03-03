@extends('layouts.user')

@section('content')
<style>
    /* Mobile-First Responsive Design */
    :root {
        --primary-color: #1e3a8a;
        --secondary-color: #60a5fa;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --touch-target-size: 44px;
    }

    /* Touch-friendly interactions */
    .btn, button, .form-control, select, input, textarea {
        min-height: var(--touch-target-size);
        touch-action: manipulation;
    }

    /* Modal Design Enhancement - Full Screen */
    .modal-dialog {
        max-width: 100vw !important;
        margin: 0 !important;
        height: 100vh !important;
    }

    .modal-content {
        border-radius: 0;
        border: none;
        padding: 0;
        box-shadow: none;
        background: #ffffff;
        overflow: hidden;
        height: 100vh !important;
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        border-bottom: none;
        padding: 28px 32px;
        margin: 0;
        border-radius: 20px 20px 0 0;
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.3px;
    }

    .modal-header .btn-close {
        background: rgba(255, 255, 255, 0.25);
        border-radius: 8px;
        width: 40px;
        height: 40px;
        padding: 10px;
        opacity: 0.9;
        transition: all 0.2s ease;
    }

    .modal-header .btn-close:hover {
        background: rgba(255, 255, 255, 0.4);
        opacity: 1;
    }

    .modal-body {
        padding: 20px 24px;
        flex: 1;
        overflow-y: auto;
        font-size: 14px;
    }

    .modal-body .form-group {
        margin-bottom: 20px;
    }

    .modal-body label {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
        margin-bottom: 8px;
        display: block;
    }

    .modal-body .form-control,
    .modal-body select {
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        padding: 12px 16px;
        font-size: 16px;
        transition: all 0.2s ease;
        background: #ffffff;
        min-height: var(--touch-target-size);
    }

    .modal-body .form-control:focus,
    .modal-body select:focus {
        border-color: #2563eb;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    /* Consent modal specific styling - Enhanced Design */
    #consentModal {
        z-index: 9999 !important;
    }

    #consentModal + .modal-backdrop,
    .modal-backdrop.show {
        z-index: 9998 !important;
    }

    #consentModal .modal-dialog {
        max-width: 900px;
    }

    #consentModal .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    }

    #consentModal .modal-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 24px 32px;
        border-radius: 20px 20px 0 0;
        border: none;
    }

    #consentModal .modal-header .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    #consentModal .modal-header .modal-title i {
        font-size: 1.75rem;
        color: #fbbf24;
    }

    #consentModal .modal-body {
        padding: 32px;
        max-height: 70vh;
        overflow-y: auto;
    }

    #consentModal .modal-body .consent-intro {
        background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
        border-left: 4px solid #3b82f6;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    #consentModal .modal-body .consent-intro p {
        font-size: 1rem;
        line-height: 1.8;
        color: #1e40af;
        margin: 0;
        font-weight: 500;
    }

    #consentModal .modal-body .consent-notice {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    #consentModal .modal-body .consent-notice p {
        color: #92400e;
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    #consentModal .modal-body .species-gallery {
        margin: 24px 0;
    }

    #consentModal .modal-body .species-gallery h6 {
        color: #1e3a8a;
        font-weight: 600;
        margin-bottom: 16px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #consentModal .modal-body .species-gallery h6 i {
        color: #3b82f6;
    }

    #consentModal .modal-body img {
        border-radius: 12px;
        border: 3px solid #e5e7eb;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    #consentModal .modal-body img:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        border-color: #3b82f6;
    }

    #consentModal .modal-body .species-info {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        margin-top: 24px;
    }

    #consentModal .modal-body .species-info h6 {
        color: #1e3a8a;
        font-weight: 600;
        margin-bottom: 12px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #consentModal .modal-body .species-info h6 i {
        color: #ef4444;
    }

    #consentModal .modal-body .species-info p {
        color: #475569;
        line-height: 1.8;
        margin: 0;
        font-size: 0.95rem;
    }

    #consentModal .modal-footer {
        padding: 20px 32px;
        border-top: 2px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 0 0 20px 20px;
        gap: 12px;
    }

    #consentModal .modal-footer .btn {
        padding: 12px 32px;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    #consentModal .modal-footer .btn-secondary {
        background: #e5e7eb;
        border: none;
        color: #475569;
    }

    #consentModal .modal-footer .btn-secondary:hover {
        background: #d1d5db;
        transform: translateY(-2px);
    }

    #consentModal .modal-footer .btn-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border: none;
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
    }

    #consentModal .modal-footer .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(30, 58, 138, 0.4);
    }

    /* Mobile responsive consent modal */
    @media (max-width: 768px) {
        #consentModal .modal-dialog {
            margin: 8px;
        }

        #consentModal .modal-header {
            padding: 20px;
        }

        #consentModal .modal-header .modal-title {
            font-size: 1.2rem;
        }

        #consentModal .modal-body {
            padding: 20px;
        }

        #consentModal .modal-body img {
            height: 140px;
        }

        #consentModal .modal-footer {
            padding: 16px 20px;
        }

        #consentModal .modal-footer .btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }

    .modal-footer {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 0;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        align-items: center;
        flex-shrink: 0;
    }

    .modal-footer .btn {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 16px;
        min-width: 120px;
        transition: all 0.2s ease;
        line-height: 1.5;
        min-height: var(--touch-target-size);
    }

    .modal-footer .btn-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        border: none;
    }

    .modal-footer .btn-primary:hover {
        background: linear-gradient(135deg, #1e293b 0%, #1d4ed8 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
    }

    .modal-footer .btn-secondary {
        background: #e5e7eb;
        color: #374151;
        border: none;
    }

    .modal-footer .btn-secondary:hover {
        background: #d1d5db;
        transform: translateY(-2px);
    }

    .modal-footer .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
    }

    .modal-footer .btn-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    /* Ensure modals are fully interactive */
    .modal,
    .modal-backdrop,
    .modal-content,
    .modal-body,
    .modal-footer,
    .modal-header {
        pointer-events: auto !important;
    }

    .modal-backdrop {
        pointer-events: auto !important;
    }

    /* Allow modal to be shown/hidden properly by Bootstrap */
    .modal.show {
        display: block !important;
    }

    /* Form Controls - Mobile Optimized */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        color: #374151;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control, select {
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        padding: 12px 16px;
        font-size: 16px; /* Prevents zoom on iOS */
        transition: all 0.3s ease;
        background: white;
        width: 100%;
    }

    .form-control:focus, select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        outline: none;
    }

    /* Button Styles - Mobile Enhanced */
    .btn {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 16px;
        min-height: var(--touch-target-size);
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        touch-action: manipulation;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
    }

    .btn-primary:hover, .btn-primary:active {
        background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover, .btn-secondary:active {
        background: #e5e7eb;
        transform: translateY(-1px);
    }

    /* Page Header - Mobile Responsive */
    .page-header {
        padding: 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .page-header-logo {
        display: none;
    }

    @media (min-width: 768px) {
        .page-header-logo {
            display: block;
            flex-shrink: 0;
        }

        .page-header-logo img {
            height: 50px;
            width: auto;
        }
    }

    .page-header-content {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 16px;
    }

    /* Status Indicators - Mobile Friendly */
    .connection-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .connection-status.online {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .connection-status.offline {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    /* Map Container - Mobile Optimized */
    #map {
        flex: 1;
        border-radius: 0;
        box-shadow: none;
        margin: 0 !important;
        padding: 0 !important;
        height: 100vh !important;
        width: 100vw !important;
        min-height: 100vh !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        z-index: 1 !important;
    }

    /* Map Legend */
    .map-legend {
        position: fixed;
        bottom: 20px;
        left: 10px;
        background: white;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        font-family: Arial, sans-serif;
        min-width: 160px;
    }

    .map-legend h6 {
        margin: 0 0 10px 0;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 6px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-size: 12px;
    }

    .legend-item:last-child {
        margin-bottom: 0;
    }

    .legend-marker {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
    }

    .legend-marker.green {
        background-color: #28a745;
    }

    .legend-marker.red {
        background-color: #dc3545;
        animation: pulse-red 2s infinite;
    }

    .legend-text {
        color: #555;
        font-weight: 500;
    }

    @keyframes pulse-red {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(220, 53, 69, 0);
        }
    }

    @media (max-width: 768px) {
        .map-legend {
            bottom: 80px;
            left: 10px;
            padding: 10px 12px;
            min-width: 140px;
        }

        .map-legend h6 {
            font-size: 12px;
            margin-bottom: 8px;
        }

        .legend-item {
            font-size: 11px;
            margin-bottom: 6px;
        }

        .legend-marker {
            width: 16px;
            height: 16px;
            margin-right: 8px;
        }
    }

    .content-wrapper {
        display: flex;
        flex-direction: column;
        flex: 1;
        width: 100%;
        height: 100%;
        padding: 0 !important;
        margin: 0 !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
    }

    /* Notification Styles */
    .notification {
        position: fixed;
        top: 20px;
        left: 16px;
        right: 16px;
        z-index: 9999;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        animation: slideIn 0.3s ease;
    }

    .notification.success {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .notification.warning {
        background: rgba(245, 158, 11, 0.95);
        color: white;
    }

    .notification.error {
        background: rgba(239, 68, 68, 0.95);
        color: white;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Loading States */
    .loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Pulse animation for outbreak markers (red) */
    @keyframes pulseOutbreak {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }

    .marker-outbreak {
        animation: pulseOutbreak 2s infinite;
    }

    /* Mobile-specific adjustments */
    @media (max-width: 768px) {
        .modal-header {
            padding: 20px 24px;
        }

        .modal-body {
            padding: 16px 20px;
        }

        .modal-footer {
            padding: 16px 20px;
        }

        .page-header {
            display: none !important;
        }

        .page-header-content {
            gap: 0 !important;
        }

        .page-header h1 {
            font-size: 0.95rem !important;
            margin-bottom: 4px !important;
            font-weight: 600 !important;
        }

        .page-header p.description {
            display: none !important;
        }

        .page-header .d-flex {
            flex-direction: row !important;
            gap: 6px !important;
            margin-top: 0 !important;
        }

        #map {
            margin: 0;
            height: 100vh;
            min-height: 100vh;
        }

        .btn {
            width: 100%;
            margin-bottom: 8px;
        }

        .connection-status {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }

        .btn-sm {
            font-size: 0.7rem !important;
            padding: 4px 8px !important;
        }
    }

    /* Mobile Orientation - Fullscreen Map */
    @media (max-width: 991px) {
        body, html {
            overflow: hidden !important;
        }

        .container-fluid {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        #map {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .page-header {
            display: none !important;
        }

        .layout-page {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .layout-page main {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    }

    /* iOS-specific fixes */
    @supports (-webkit-touch-callout: none) {
        .form-control, select {
            font-size: 16px !important; /* Prevent zoom */
        }

        .btn {
            -webkit-appearance: none;
            appearance: none;
        }
    }

    /* Android-specific fixes */
    @supports (-webkit-appearance: none) and (not (-webkit-touch-callout: none)) {
        .form-control, select {
            font-size: 16px !important;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .modal-content {
            background: linear-gradient(145deg, #1e293b, #334155);
            color: #f1f5f9;
        }

        .form-control, select {
            background: #334155;
            border-color: #475569;
            color: #f1f5f9;
        }

        .form-control:focus, select:focus {
            border-color: var(--secondary-color);
        }
    }

    /* Tablet - Fullscreen Map */
    @media (min-width: 992px) and (max-width: 1199px) {
        body, html {
            overflow: hidden !important;
        }

        .container-fluid {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        #map {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .page-header {
            display: none !important;
        }

        .layout-page {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .layout-page main {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    }

    /* Desktop-specific adjustments */
    @media (min-width: 1200px) {
        .container-fluid,
        .page-content,
        .content-wrapper {
            height: 100vh !important;
            min-height: 100vh !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        #map {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .page-header {
            display: none !important;
        }
        .user-sidebar {
            z-index: 1001;
        }
        .layout-page {
            height: 100vh !important;
            min-height: 100vh !important;
            display: flex;
            flex-direction: column;
        }
    }

    /* Keep map contained within the page content. Do not override global html/body layout. */
    .page-content, .content-wrapper {
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    #map {
        flex: 1;
        width: 100%;
        height: 100vh;
        min-height: 100vh;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        z-index: 1 !important;
    }
</style>

<div class="container-fluid" style="height: 100vh; min-height: 100vh; display: flex; flex-direction: column; overflow: hidden; padding: 0; margin: 0; position: fixed; top: 0; left: 0; right: 0; bottom: 0;">
<div class="page-header">
    <div class="page-header-logo">
        <img src="{{ asset('images/logo.png') }}" alt="COTS Tracker Logo">
    </div>
    <div class="page-header-content">
        <h1>🏊‍♂️ COTS Sighting Map</h1>
        <p class="description">View all reported Crown-of-Thorns Starfish (COTS), locally known as Dap-ag, sightings on the interactive map. Help protect our reefs by adding pin to report new sightings in your area.</p>

        <!-- Mobile-Optimized Status and Sync Controls -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
        <div class="connection-status online" id="connectionStatus">
            <i class="fas fa-wifi"></i>
            <span>Online</span>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="manualSync()" id="syncBtn">
                <i class="fas fa-sync-alt me-1"></i>Sync Data
            </button>
        </div>
    </div>
    </div>
</div>

<div class="page-content" style="flex: 1; overflow: hidden; padding: 0; margin: 0; display: flex; flex-direction: column; height: 100vh; min-height: 100vh; position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw;">
    <div class="content-wrapper" style="flex: 1; display: flex; flex-direction: column; height: 100vh; padding: 0; margin: 0; position: relative; width: 100%; overflow: hidden;">
        <div id="map"></div>
        
        <!-- Map Legend -->
        <div class="map-legend">
            <h6><i class="fas fa-map-marker-alt me-1"></i>Legend</h6>
            <div class="legend-item">
                <div class="legend-marker green"></div>
                <span class="legend-text">Normal (≤15 COTS)</span>
            </div>
            <div class="legend-item">
                <div class="legend-marker red"></div>
                <span class="legend-text">Outbreak (>15 COTS)</span>
            </div>
        </div>
            <!-- Consent Modal - Enhanced Design -->
            <div class="modal fade" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="consentModalLabel">
                                <i class="fas fa-shield-alt"></i>
                                <span>Data Privacy Consent</span>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Privacy Notice -->
                            <div class="consent-intro">
                                <p>
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Your Privacy Matters:</strong> All information you provide will be treated as strictly confidential and used solely for research and marine conservation purposes. We are committed to protecting your personal information and respecting your privacy rights.
                                </p>
                            </div>

                            <!-- Consent Agreement -->
                            <div class="consent-notice">
                                <p>
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    By clicking <strong>"I Agree"</strong>, you consent to the collection and processing of your data for research and monitoring purposes, in accordance with the Data Privacy Act of 2012 and other applicable data privacy laws.
                                </p>
                            </div>

                            <!-- Species Gallery -->
                            <div class="species-gallery">
                                <h6>
                                    <i class="fas fa-images"></i>
                                    Crown-of-Thorns Starfish (COTS) - Visual Reference
                                </h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <img src="{{ asset('images/img1.jpg') }}" alt="COTS Species 1" loading="lazy">
                                    </div>
                                    <div class="col-6">
                                        <img src="{{ asset('images/img2.jpg') }}" alt="COTS Species 2" loading="lazy">
                                    </div>
                                    <div class="col-6">
                                        <img src="{{ asset('images/img3.jpg') }}" alt="COTS Species 3" loading="lazy">
                                    </div>
                                    <div class="col-6">
                                        <img src="{{ asset('images/img4.jpg') }}" alt="COTS Species 4" loading="lazy">
                                    </div>
                                </div>
                            </div>

                            <!-- Species Information -->
                            <div class="species-info">
                                <h6>
                                    <i class="fas fa-info-circle"></i>
                                    About Crown-of-Thorns Starfish (Dap-ag)
                                </h6>
                                <p>
                                    The Crown-of-Thorns Starfish (COTS), locally known as <strong>Dap-ag</strong>, is a marine species with significant impact on coral reef ecosystems. While naturally part of the marine environment, population outbreaks can devastate coral reefs by feeding on coral polyps, causing extensive degradation. COTS poses a major threat to coral ecosystems in tropical and subtropical regions and is considered a key factor in coral reef decline. Your reports help researchers monitor and manage COTS populations to protect vital marine biodiversity.
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="button" class="btn btn-primary" id="agreeConsent">
                                <i class="fas fa-check-circle me-2"></i>I Agree & Continue
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Consent Modal -->
            <form id="locationForm" action="{{ route('user-save-location') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Modal 1: Sighting Details -->
    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal1Label" data-en="Sighting Details" data-bis="Detalye sa Pagkakita"><i class="fas fa-info-circle me-2"></i>Sighting Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                

                <div class="modal-body">
                    <div class="form-group">
                        <label for="language" data-en="Language:" data-bis="Pinulongan:">Language:</label>
                        <select class="form-control" id="language" name="language">
                            <option value="en">English</option>
                            <option value="bis">Bisaya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" data-en="Name:" data-bis="Ngalan:">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="optional">
                    </div>
                    <div class="form-group">
                        <label for="date_of_sighting" data-en="Date of COTS Sighting:" data-bis="Petsa sa Pagkakita sa COTS:">Date of COTS Sighting:</label>
                        <input type="date" class="form-control" id="date_of_sighting" name="date_of_sighting" required>
                    </div>
                    <div class="form-group">
                        <label for="time_of_sighting" data-en="Time of COTS Sighting:" data-bis="Oras sa Pagkakita sa COTS:">Time of COTS Sighting:</label>
                        <input type="time" class="form-control" id="time_of_sighting" name="time_of_sighting" required>
                    </div>
                    <div class="form-group">
                        <label for="municipality" data-en="Municipality:" data-bis="Munisipalidad:">Municipality:</label>
                        <select class="form-control" id="municipality" name="municipality" required>
                            <option value="" data-en="Select Municipality" data-bis="Pilia ang Munisipalidad">Select Municipality</option>
                            <!-- Municipalities will be populated here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barangay" data-en="Barangay:" data-bis="Barangay:">Barangay:</label>
                        <select class="form-control" id="barangay" name="barangay" required>
                            <option value="" data-en="Select Barangay" data-bis="Pilia ang Barangay">Select Barangay</option>
                            <!-- Barangays will be populated here -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-en="Close" data-bis="Sirado"><i class="fas fa-times me-2"></i>Close</button>
                    <button type="button" class="btn btn-primary" id="nextBtn1" data-en="Next" data-bis="Sunod"><i class="fas fa-arrow-right me-2"></i>Next</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: COTS Count -->
    <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal2Label" data-en="COTS Count" data-bis="Ihap sa COTS"><i class="fas fa-sort-numeric-up me-2"></i>COTS Count</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="early_juvenile" data-en="1-5cm:" data-bis="1-5cm:">1-5cm:</label>
                        <input type="number" class="form-control" id="early_juvenile" name="early_juvenile" min="0">
                    </div>
                    <div class="form-group">
                        <label for="juvenile" data-en="6-15cm:" data-bis="6-15cm:">6-15cm:</label>
                        <input type="number" class="form-control" id="juvenile" name="juvenile" min="0">
                    </div>
                    <div class="form-group">
                        <label for="sub_adult" data-en="15-25cm:" data-bis="15-25cm:">15-25cm:</label>
                        <input type="number" class="form-control" id="sub_adult" name="sub_adult" min="0">
                    </div>
                    <div class="form-group">
                        <label for="adult" data-en="25-35cm:" data-bis="25-35cm:">25-35cm:</label>
                        <input type="number" class="form-control" id="adult" name="adult" min="0">
                    </div>
                    <div class="form-group">
                        <label for="late_adult" data-en=">35cm:" data-bis=">35cm:">>35cm:</label>
                        <input type="number" class="form-control" id="late_adult" name="late_adult" min="0">
                    </div>
                    <div class="form-group">
                        <label for="number_of_cots" data-en="Total COTS:" data-bis="Kinatibuk-an nga COTS:">Total COTS:</label>
                        <input type="number" class="form-control" id="number_of_cots" name="number_of_cots" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="backBtn2" data-en="Back" data-bis="Balik"><i class="fas fa-arrow-left me-2"></i>Back</button>
                <button type="button" class="btn btn-primary" id="nextBtn2" data-en="Next" data-bis="Sunod"><i class="fas fa-arrow-right me-2"></i>Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Activity & Observer Info -->
    <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal3Label" data-en="Activity & Observer Info" data-bis="Kalihokan ug Tigtan-aw"><i class="fas fa-user me-2"></i>Activity & Observer Info</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="activity_type" data-en="Type of Activity:" data-bis="Matang sa Kalihokan:">Type of Activity:</label>
                        <select class="form-control" id="activity_type" name="activity_type" required>
                            <option value="" data-en="Select Activity" data-bis="Pilia ang Kalihokan">Select Activity</option>
                            <option value="Fishing" data-en="Fishing" data-bis="Pangisda">Fishing</option>
                            <option value="Recreational diving" data-en="Recreational Diving" data-bis="Paglangoy Alang sa Kalingawan">Recreational Diving</option>
                            <option value="Research" data-en="Research" data-bis="Panukiduki">Research</option>
                            <option value="Cots collection" data-en="COTS Collection" data-bis="Pagkolekta sa COTS">COTS Collection</option>
                            <option value="other" data-en="Other" data-bis="Uban pa">Other</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="custom_activity" name="custom_activity" placeholder="Please specify activity">
                    </div>
                    <div class="form-group">
                        <label for="observer_category" data-en="Observer Category:" data-bis="Kategorya sa Tigtan-aw:">Observer Category:</label>
                        <select class="form-control" id="observer_category" name="observer_category" required>
                            <option value="" data-en="Select Observer" data-bis="Pilia ang Tigtan-aw">Select Observer</option>
                            <option value="Fisherfolks" data-en="Fisherfolks" data-bis="Mananagat">Fisherfolks</option>
                            <option value="Barangay residents" data-en="Barangay Residents" data-bis="Lumulupyo sa Barangay">Barangay Residents</option>
                            <option value="Local government" data-en="Local Government" data-bis="Lokal nga Kagamhanan">Local Government</option>
                            <option value="Advocacy groups" data-en="Advocacy Group" data-bis="Grupo sa Pagpakiglambigit">Advocacy Group</option>
                            <option value="Researcher" data-en="Researcher" data-bis="Tigdukiduki">Researcher</option>
                            <option value="other" data-en="Other" data-bis="Uban pa">Other</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="custom_observer" name="custom_observer" placeholder="Please specify observer">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="backBtn3" data-en="Back" data-bis="Balik"><i class="fas fa-arrow-left me-2"></i>Back</button>
                <button type="button" class="btn btn-primary" id="nextBtn3" data-en="Next" data-bis="Sunod"><i class="fas fa-arrow-right me-2"></i>Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 4: Location & Media -->
    <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-fullscreen"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal4Label" data-en="Location & Media" data-bis="Lokasyon ug Media"><i class="fas fa-map-marker-alt me-2"></i>Location & Media</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="location_name" data-en="Location Name:" data-bis="Ngalan sa Lokasyon:">Location Name:</label>
                        <input type="text" class="form-control" id="location_name" name="location_name" placeholder="e.g., Near Reef Point, Coastal Area A" required>
                        <small class="text-muted" data-en="Specify the exact location or landmark where COTS were sighted" data-bis="Isulti ang eksaktong lokasyon o landmark diin nakita ang COTS">Specify the exact location or landmark where COTS were sighted</small>
                    </div>

                    <div class="form-group">
                        <label data-en="Latitude:" data-bis="Latitude:">Latitude:</label>
                        <p id="latitude_display" data-en="Not selected" data-bis="Wala mapili">Not selected</p>
                        <input type="hidden" id="latitude" name="latitude" required>
                    </div>

                    <div class="form-group">
                        <label data-en="Longitude:" data-bis="Longitude:">Longitude:</label>
                        <p id="longitude_display" data-en="Not selected" data-bis="Wala mapili">Not selected</p>
                        <input type="hidden" id="longitude" name="longitude" required>
                    </div>

                    <div class="form-group">
                        <label for="photo" data-en="Photos:" data-bis="Mga Litrato:">Photos:</label>
                        <input type="file" class="form-control" id="photo" name="photo[]" accept="image/*" multiple>
                    </div>
                    <div class="form-group">
                        <label for="description" data-en="Additional Comments:" data-bis="Dugang nga Komento:">Additional Comments:</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backBtn4" data-en="Back" data-bis="Balik"><i class="fas fa-arrow-left me-2"></i>Back</button>
                    <button type="submit" class="btn btn-success" data-en="Submit" data-bis="Isumite"><i class="fas fa-check me-2"></i>Submit</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <!-- End Location Form -->

    <!-- Core JS (no duplicates) -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>
    <!-- Leaflet is loaded in the layout; avoid duplicate includes here -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- User-specific JavaScript files -->
    <script src="{{ asset('js/user-location.js') }}"></script>
    <script src="{{ asset('js/user-modal.js') }}"></script>
    <script>
        // Embed server-side sightings data for the map
        window.SIGHTINGS = @json(isset($locations) ? $locations->toArray() : []);
    </script>
    <script src="{{ asset('js/user-map.js') }}"></script>
    <script src="{{ asset('js/user-form.js') }}"></script>
    
    <!-- Language Translation Script -->
    <script>
        $(document).ready(function() {
            // Language switcher
            $('#language').on('change', function() {
                const selectedLang = $(this).val();
                translateForm(selectedLang);
            });

            function translateForm(lang) {
                // Translate all elements with data attributes
                $('[data-en][data-bis]').each(function() {
                    const $element = $(this);
                    const text = lang === 'bis' ? $element.data('bis') : $element.data('en');
                    
                    // Handle different element types
                    if ($element.is('label') || $element.is('button') || $element.is('h5') || $element.is('p') || $element.is('small')) {
                        // For labels with icons, preserve the icon HTML
                        const icon = $element.find('i').length ? $element.find('i')[0].outerHTML : '';
                        if (icon) {
                            $element.html(icon + text);
                        } else {
                            $element.text(text);
                        }
                    } else if ($element.is('option')) {
                        $element.text(text);
                    }
                });

                // Update placeholders if needed
                if (lang === 'bis') {
                    $('#name').attr('placeholder', 'opsyonal');
                    $('#custom_activity').attr('placeholder', 'Palihug isulti ang kalihokan');
                    $('#custom_observer').attr('placeholder', 'Palihug isulti ang tigtan-aw');
                    $('#location_name').attr('placeholder', 'pananglitan, Duol sa Reef Point, Coastal Area A');
                } else {
                    $('#name').attr('placeholder', 'optional');
                    $('#custom_activity').attr('placeholder', 'Please specify activity');
                    $('#custom_observer').attr('placeholder', 'Please specify observer');
                    $('#location_name').attr('placeholder', 'e.g., Near Reef Point, Coastal Area A');
                }

                // Store selected language for form submission
                localStorage.setItem('selectedLanguage', lang);
            }

            // Check if there's a saved language preference
            const savedLang = localStorage.getItem('selectedLanguage');
            if (savedLang) {
                $('#language').val(savedLang);
                translateForm(savedLang);
            }
        });
    </script>
    <script src="{{ asset('js/user-offline.js') }}"></script>
    <script src="{{ asset('js/offline-manager.js') }}"></script>
    <script src="{{ asset('js/pwa-install.js') }}"></script>
</div>
</div>

@endsection
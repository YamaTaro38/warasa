@extends('layouts.dashboard')

@section('page-title', 'Smart Generate')
@section('breadcrumb', 'Product Generator / Smart Generate')

@section('content')
<style>
    /* ========== COMPACT STYLES ========== */
    .form-section { 
        background: white; 
        border: 1px solid #e2e8f0; 
        border-radius: 12px; 
        padding: 16px; 
        margin-bottom: 16px; 
    }
    .section-title { 
        font-size: 13px; 
        font-weight: 600; 
        margin-bottom: 14px; 
        padding-bottom: 10px; 
        border-bottom: 1px solid #e2e8f0; 
        display: flex; 
        align-items: center; 
        gap: 8px; 
    }
    .section-title i { 
        color: #ee4d2d; 
        font-size: 13px; 
    }
    .input-solid { 
        width: 100%; 
        padding: 8px 12px; 
        border: 1px solid #e2e8f0; 
        border-radius: 8px; 
        font-size: 12px; 
        transition: all 0.2s; 
        background: white; 
    }
    .input-solid:focus { 
        outline: none; 
        border-color: #ee4d2d; 
        box-shadow: 0 0 0 3px rgba(238,77,45,0.1); 
    }
    .input-solid.error { 
        border-color: #ef4444; 
        background: #fef2f2; 
    }
    .input-solid:disabled { 
        opacity: 0.6; 
        background: #f8fafc; 
        cursor: not-allowed; 
    }
    textarea.input-solid { 
        resize: vertical; 
        min-height: 80px; 
    }
    .switch { 
        position: relative; 
        display: inline-block; 
        width: 40px; 
        height: 22px; 
    }
    .switch input { 
        opacity: 0; 
        width: 0; 
        height: 0; 
    }
    .slider { 
        position: absolute; 
        cursor: pointer; 
        top: 0; 
        left: 0; 
        right: 0; 
        bottom: 0; 
        background-color: #cbd5e1; 
        transition: 0.2s; 
        border-radius: 34px; 
    }
    .slider:before { 
        position: absolute; 
        content: ""; 
        height: 18px; 
        width: 18px; 
        left: 2px; 
        bottom: 2px; 
        background-color: white; 
        transition: 0.2s; 
        border-radius: 50%; 
    }
    input:checked + .slider { 
        background-color: #ee4d2d; 
    }
    input:checked + .slider:before { 
        transform: translateX(18px); 
    }
    .autocomplete-container { 
        position: relative; 
    }
    .autocomplete-dropdown { 
        position: absolute; 
        top: 100%; 
        left: 0; 
        right: 0; 
        max-height: 200px; 
        overflow-y: auto; 
        background: white; 
        border: 1px solid #e2e8f0; 
        border-radius: 8px; 
        box-shadow: 0 4px 8px rgba(0,0,0,0.08); 
        z-index: 50; 
        display: none; 
    }
    .autocomplete-dropdown.active { 
        display: block; 
    }
    .autocomplete-item { 
        padding: 8px 12px; 
        cursor: pointer; 
        transition: background 0.15s; 
        border-bottom: 1px solid #f1f5f9; 
        font-size: 12px; 
    }
    .autocomplete-item:hover { 
        background: #f8fafc; 
    }
    .validation-message.error { 
        color: #ef4444; 
        font-size: 11px; 
        margin-top: 4px; 
        display: flex; 
        align-items: center; 
        gap: 4px; 
    }
    .validation-message.hidden { 
        display: none; 
    }
    .shipping-cards { 
        display: flex; 
        flex-wrap: wrap; 
        gap: 8px; 
        margin-top: 6px; 
    }
    .shipping-card { 
        padding: 4px 12px; 
        border: 1px solid #e2e8f0; 
        border-radius: 20px; 
        cursor: pointer; 
        text-align: center; 
        transition: all 0.15s; 
        background: white; 
        font-size: 11px; 
        font-weight: 500; 
    }
    .shipping-card.selected { 
        background: #ee4d2d; 
        border-color: #ee4d2d; 
        color: white; 
    }
    .shipping-card.disabled { 
        opacity: 0.5; 
        pointer-events: none; 
    }
    
    /* ========== VARIATION STYLES - IMPROVED ========== */
    .variation-card { 
        background: #ffffff; 
        border: 1px solid #e2e8f0; 
        border-radius: 10px; 
        padding: 14px; 
        margin-bottom: 14px; 
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .variation-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 14px; 
        flex-wrap: wrap; 
        gap: 12px; 
        padding-bottom: 10px;
        border-bottom: 1px dashed #e2e8f0;
    }
    .variation-name-wrapper {
        flex: 2;
        min-width: 180px;
    }
    .variation-name-wrapper label {
        font-size: 10px;
        color: #64748b;
        margin-bottom: 2px;
        display: block;
    }
    .variation-name { 
        width: 100%;
        font-size: 12px;
        font-weight: 500;
    }
    .variation-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .enable-images-checkbox { 
        display: flex; 
        align-items: center; 
        gap: 6px; 
        font-size: 11px;
        background: #f8fafc;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .remove-variation { 
        background: none; 
        border: none; 
        color: #ef4444; 
        font-size: 12px; 
        cursor: pointer; 
        padding: 5px 10px;
        border-radius: 6px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .remove-variation:hover { 
        background: #fef2f2; 
    }
    
    /* Options Container */
    .variation-options { 
        display: flex; 
        flex-direction: column; 
        gap: 10px; 
        margin-top: 12px; 
        margin-bottom: 12px;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 4px;
    }
    
    /* Option Item - Improved */
    .option-item { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 10px 14px; 
        background: #f8fafc; 
        border: 1px solid #e2e8f0; 
        border-radius: 10px; 
        transition: all 0.2s;
    }
    .option-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .option-image-wrapper {
        position: relative;
    }
    .option-image { 
        width: 56px; 
        height: 56px; 
        border-radius: 10px; 
        overflow: hidden; 
        background: #ffffff; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border: 1px solid #e2e8f0; 
        cursor: pointer; 
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .option-image:hover { 
        border-color: #ee4d2d; 
        box-shadow: 0 2px 8px rgba(238,77,45,0.15);
    }
    .option-image img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }
    .option-image .no-img { 
        font-size: 22px; 
        color: #cbd5e1; 
    }
    .option-value { 
        flex: 1; 
        font-weight: 500; 
        font-size: 13px; 
        color: #1e293b;
    }
    .option-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .option-upload-btn { 
        background: white; 
        border: 1px solid #cbd5e1; 
        border-radius: 8px; 
        padding: 6px 14px; 
        font-size: 11px; 
        cursor: pointer; 
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }
    .option-upload-btn:hover { 
        background: #ee4d2d; 
        border-color: #ee4d2d;
        color: white;
    }
    .option-upload-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .option-remove-img { 
        color: #ef4444; 
        cursor: pointer; 
        font-size: 14px; 
        padding: 6px;
        transition: all 0.2s;
        border-radius: 6px;
        background: white;
        border: 1px solid #e2e8f0;
    }
    .option-remove-img:hover { 
        color: #dc2626; 
        background: #fef2f2;
        border-color: #fecaca;
    }
    .option-remove-img:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    
    /* Add Option Input */
    .add-option-wrapper {
        margin-top: 12px;
        padding-top: 8px;
        border-top: 1px dashed #e2e8f0;
    }
    .add-option-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12px;
        background: white;
    }
    .add-option-input:focus {
        outline: none;
        border-color: #ee4d2d;
        box-shadow: 0 0 0 3px rgba(238,77,45,0.1);
    }
    
    /* Variation Info */
    .variation-info { 
        font-size: 10px; 
        color: #64748b; 
        margin-top: 10px; 
        padding: 8px 12px; 
        background: #fef2e8; 
        border-radius: 8px; 
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .variation-info i {
        color: #ee4d2d;
    }
    
    /* Image Support Info */
    .image-support-info {
        margin-top: 8px;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .image-support-info.text-orange-600 {
        background: #fff5f2;
        color: #ee4d2d;
    }
    .image-support-info.text-gray-400 {
        background: #f8fafc;
        color: #94a3b8;
    }

    .btn-primary { 
        background: #ee4d2d; 
        color: white; 
        padding: 8px 16px; 
        border-radius: 8px; 
        font-weight: 600; 
        transition: all 0.15s; 
        border: none; 
        cursor: pointer; 
        font-size: 13px; 
    }
    .btn-primary:hover { 
        background: #d63e1f; 
    }
    .btn-primary:disabled { 
        opacity: 0.5; 
        cursor: not-allowed; 
    }
    .btn-secondary { 
        background: #f1f5f9; 
        color: #475569; 
        padding: 6px 12px; 
        border-radius: 8px; 
        font-weight: 500; 
        font-size: 12px; 
        border: none; 
        cursor: pointer; 
    }
    .btn-secondary:hover { 
        background: #e2e8f0; 
    }
    .btn-secondary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .btn-outline {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        border-color: #ee4d2d;
        color: #ee4d2d;
    }
    .spinner-small { 
        width: 14px; 
        height: 14px; 
        border: 2px solid #e2e8f0; 
        border-top-color: #ee4d2d; 
        border-radius: 50%; 
        animation: spin 0.6s linear infinite; 
        display: inline-block; 
    }
    @keyframes spin { 
        to { transform: rotate(360deg); } 
    }
    .field-loading { 
        display: flex; 
        align-items: center; 
        gap: 8px; 
    }
    .keyword-badge { 
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
        background: #f1f5f9; 
        color: #1e293b; 
        padding: 4px 10px; 
        border-radius: 20px; 
        font-size: 11px; 
        font-weight: 500; 
        cursor: pointer;
    }
    .keyword-badge i {
        cursor: pointer;
        color: #94a3b8;
    }
    .keyword-badge i:hover {
        color: #ee4d2d;
    }
    .gallery-container { 
        display: flex; 
        flex-wrap: wrap; 
        gap: 8px; 
        margin-bottom: 10px; 
    }
    .gallery-item { 
        position: relative; 
        width: 70px; 
        height: 70px; 
        border-radius: 8px; 
        overflow: hidden; 
        border: 1px solid #e2e8f0; 
        background: #f8fafc; 
        cursor: pointer; 
    }
    .gallery-item img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }
    .gallery-item .remove-img { 
        position: absolute; 
        top: 2px; 
        right: 2px; 
        background: rgba(0,0,0,0.6); 
        color: white; 
        border-radius: 50%; 
        width: 18px; 
        height: 18px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 9px; 
        cursor: pointer; 
    }
    .upload-btn { 
        width: 70px; 
        height: 70px; 
        border: 2px dashed #cbd5e1; 
        border-radius: 8px; 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center; 
        cursor: pointer; 
        font-size: 11px; 
        color: #64748b; 
        background: #f8fafc; 
        gap: 4px; 
    }
    .upload-btn.disabled { 
        opacity: 0.5; 
        pointer-events: none; 
    }
    .lightbox { 
        display: none; 
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: rgba(0,0,0,0.92); 
        z-index: 9999; 
        justify-content: center; 
        align-items: center; 
        cursor: pointer; 
        backdrop-filter: blur(8px); 
    }
    .lightbox.active { 
        display: flex; 
    }
    .lightbox img { 
        max-width: 90%; 
        max-height: 90%; 
        object-fit: contain; 
    }
    .grid-2 { 
        display: grid; 
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); 
        gap: 16px; 
    }
    @media (max-width: 1100px) { 
        .grid-2 { 
            grid-template-columns: 1fr; 
        } 
    }

    /* Disabled overlay for generating state */
    body.is-generating .form-section {
        position: relative;
    }
    body.is-generating .form-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.7);
        border-radius: 12px;
        z-index: 10;
        pointer-events: none;
    }
    body.is-generating input:not(.no-disable),
    body.is-generating textarea:not(.no-disable),
    body.is-generating select:not(.no-disable),
    body.is-generating button:not(#generateBtn):not(#saveBtn):not(#clearBtn),
    body.is-generating .shipping-card,
    body.is-generating .autocomplete-container,
    body.is-generating .upload-btn,
    body.is-generating .option-upload-btn,
    body.is-generating .option-remove-img,
    body.is-generating .add-variation-btn,
    body.is-generating .remove-variation,
    body.is-generating .variation-new-option {
        pointer-events: none;
        opacity: 0.6;
    }
    body.is-generating [contenteditable="true"] {
        pointer-events: none;
        background: #f8fafc;
    }

    /* Stepper */
    .step-circle { 
        width: 28px; 
        height: 28px; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 12px; 
        font-weight: 600; 
        transition: all 0.2s; 
    }
    .step-circle.pending { 
        background: #e2e8f0; 
        color: #94a3b8; 
    }
    .step-circle.active { 
        background: #ee4d2d; 
        color: white; 
    }
    .step-circle.completed { 
        background: #10b981; 
        color: white; 
    }
    .step-label { 
        font-size: 11px; 
    }
    .step-label.active { 
        color: #1e293b; 
        font-weight: 600; 
    }
    .step-label.pending { 
        color: #94a3b8; 
    }
    .step-label.completed { 
        color: #10b981; 
        font-weight: 500; 
    }
    .step-connector { 
        flex: 1; 
        height: 2px; 
        background: #e2e8f0; 
        margin: 0 4px; 
    }
    .step-connector.completed { 
        background: #10b981; 
    }

    /* Panels */
    .smart-badge { 
        display: inline-flex; 
        align-items: center; 
        gap: 5px; 
        padding: 4px 10px; 
        background: linear-gradient(135deg, #ee4d2d, #d63e1f); 
        color: white; 
        border-radius: 20px; 
        font-size: 10px; 
        font-weight: 600; 
    }
    .csv-upload-area { 
        border: 2px dashed #cbd5e1; 
        border-radius: 10px; 
        padding: 24px 16px; 
        text-align: center; 
        cursor: pointer; 
        transition: all 0.2s; 
        background: #f8fafc; 
    }
    .csv-upload-area:hover { 
        border-color: #ee4d2d; 
        background: #fff5f2; 
    }
    .csv-table-container { 
        max-height: 280px; 
        overflow-y: auto; 
        margin-top: 10px; 
        border: 1px solid #e2e8f0; 
        border-radius: 8px; 
    }
    .csv-table { 
        width: 100%; 
        font-size: 11px; 
        border-collapse: collapse; 
    }
    .csv-table th, .csv-table td { 
        padding: 8px 10px; 
        text-align: left; 
        border-bottom: 1px solid #f1f5f9; 
    }
    .csv-table th { 
        background: #f8fafc; 
        position: sticky; 
        top: 0; 
        font-weight: 600; 
        font-size: 11px; 
    }
    .csv-row-selectable { 
        cursor: pointer; 
        transition: background 0.15s; 
    }
    .csv-row-selectable:hover { 
        background: #fef3c7; 
    }

    /* SEO Score Panel */
    .seo-score-panel { 
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe); 
        border: 1px solid #bae6fd; 
        border-radius: 12px; 
        padding: 14px; 
        margin-bottom: 16px; 
    }
    .seo-grade {
        font-size: 32px;
        font-weight: 800;
        line-height: 1;
    }
    .seo-grade-A { color: #10b981; }
    .seo-grade-B { color: #3b82f6; }
    .seo-grade-C { color: #f59e0b; }
    .seo-grade-D { color: #f97316; }
    .seo-grade-E { color: #ef4444; }
    .seo-grade-F { color: #dc2626; }
    
    .seo-progress-track { 
        height: 8px; 
        background: #e2e8f0; 
        border-radius: 4px; 
        overflow: hidden; 
        margin: 10px 0; 
    }
    .seo-progress-bar { 
        height: 100%; 
        border-radius: 4px; 
        transition: width 0.3s ease; 
    }
    .seo-progress-bar-A { background: #10b981; }
    .seo-progress-bar-B { background: #3b82f6; }
    .seo-progress-bar-C { background: #f59e0b; }
    .seo-progress-bar-D { background: #f97316; }
    .seo-progress-bar-E { background: #ef4444; }
    .seo-progress-bar-F { background: #dc2626; }
    
    .seo-detail-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 8px 0;
        font-size: 11px;
    }
    .seo-detail-label {
        width: 90px;
        font-weight: 500;
        color: #475569;
    }
    .seo-detail-bar-track {
        flex: 1;
        height: 5px;
        background: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
    }
    .seo-detail-bar-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s;
    }
    .seo-detail-score {
        width: 35px;
        text-align: right;
        font-weight: 600;
        color: #1e293b;
    }
    .seo-recommendation {
        background: white;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 11px;
        margin-top: 8px;
        color: #475569;
        border-left: 3px solid #3b82f6;
    }
    .seo-recommendation i {
        color: #3b82f6;
        margin-right: 6px;
    }
    .seo-recommendation.warning {
        border-left-color: #f59e0b;
    }
    .seo-recommendation.warning i {
        color: #f59e0b;
    }
    .seo-recommendation.danger {
        border-left-color: #ef4444;
    }
    .seo-recommendation.danger i {
        color: #ef4444;
    }

    /* Competitor Panel */
    .competitor-panel { 
        background: linear-gradient(135deg, #fff7ed, #fef3c7); 
        border: 1px solid #fed7aa; 
        border-radius: 12px; 
        padding: 14px; 
        margin-bottom: 16px; 
    }
    .competitor-stat-card {
        background: rgba(255,255,255,0.7);
        border-radius: 8px;
        padding: 8px;
        text-align: center;
    }
    .competitor-tag { 
        display: inline-block; 
        background: white; 
        color: #ee4d2d; 
        padding: 3px 10px; 
        border-radius: 16px; 
        font-size: 10px; 
        margin: 2px; 
        font-weight: 500;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    /* Modal Grid */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-container {
        background: white;
        border-radius: 16px;
        width: 900px;
        max-width: 90%;
        max-height: 85vh;
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.95);
        transition: transform 0.2s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .modal-overlay.active .modal-container {
        transform: scale(1);
    }
    .modal-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-close {
        cursor: pointer;
        font-size: 18px;
        color: #94a3b8;
        transition: color 0.2s;
    }
    .modal-close:hover {
        color: #ef4444;
    }
    .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
    }
    .modal-footer {
        padding: 12px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }
    .product-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.2s;
        cursor: pointer;
        background: white;
    }
    .product-card:hover {
        border-color: #ee4d2d;
        box-shadow: 0 4px 12px rgba(238, 77, 45, 0.15);
        transform: translateY(-2px);
    }
    .product-card-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background: #f8fafc;
    }
    .product-card-info {
        padding: 12px;
    }
    .product-card-name {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-card-price {
        font-size: 14px;
        font-weight: 700;
        color: #ee4d2d;
        margin-bottom: 4px;
    }
    .product-card-sold {
        font-size: 10px;
        color: #64748b;
    }
</style>

<div class="max-w-full">
    <!-- Stepper Header -->
    <div class="flex items-center justify-between mb-4 bg-white p-3 rounded-xl border border-gray-200">
        <div class="flex items-center gap-2 flex-1 justify-center">
            <div id="stepCircle1" class="step-circle active">1</div>
            <div id="stepLabel1" class="step-label active">Upload CSV</div>
        </div>
        <div class="step-connector" id="stepConnector1"></div>
        <div class="flex items-center gap-2 flex-1 justify-center">
            <div id="stepCircle2" class="step-circle pending">2</div>
            <div id="stepLabel2" class="step-label pending">Pilih Produk</div>
        </div>
        <div class="step-connector" id="stepConnector2"></div>
        <div class="flex items-center gap-2 flex-1 justify-center">
            <div id="stepCircle3" class="step-circle pending">3</div>
            <div id="stepLabel3" class="step-label pending">Generate</div>
        </div>
    </div>

    <!-- STEP 1: UPLOAD CSV -->
    <div id="stepContent1" class="form-section">
        <div class="section-title">
            <i class="fas fa-file-csv"></i>
            <span>Upload Data Kompetitor (CSV)</span>
        </div>
        <p class="text-xs text-gray-500 mb-3">Upload hasil scrapper Shopee untuk analisis AI</p>
        
        <div class="csv-upload-area" id="csvUploadArea">
            <i class="fas fa-cloud-upload-alt text-3xl text-orange-500 mb-2"></i>
            <p class="text-xs font-medium mb-1">Klik atau drag & drop CSV</p>
            <p class="text-[10px] text-gray-400">Format: nama_produk, harga, deskripsi_produk, url_gambar, terjual</p>
            <input type="file" id="csvFileInput" accept=".csv" class="hidden">
        </div>
        <div id="csvUploadError" class="validation-message error hidden mt-2"></div>
    </div>

    <!-- STEP 2: CHOOSE PRODUCT -->
    <div id="stepContent2" class="form-section hidden" style="display: none;">
        <div class="flex justify-between items-center mb-3">
            <div class="section-title mb-0" style="border-bottom: none; padding-bottom: 0;">
                <i class="fas fa-list-ul"></i>
                <span>Pilih Produk Kompetitor</span>
            </div>
            <div class="flex gap-2">
                <button type="button" class="btn-outline text-xs" id="viewProductGridBtn">
                    <i class="fas fa-th-large"></i> Grid View
                </button>
                <button type="button" class="btn-secondary text-xs" id="backToStep1Btn">
                    <i class="fas fa-arrow-left mr-1"></i> Upload Ulang
                </button>
            </div>
        </div>
        
        <div class="csv-table-container">
            <table class="csv-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Terjual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="csvProductList"></tbody>
            </table>
        </div>
    </div>

    <!-- STEP 3: GENERATOR -->
    <div id="stepContent3" class="hidden" style="display: none;">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                Smart Generate
                <span class="smart-badge"><i class="fas fa-brain"></i> AI Mode</span>
            </h1>
            <button type="button" class="btn-secondary text-xs" id="backToStep2Btn">
                <i class="fas fa-arrow-left mr-1"></i> Ganti Produk
            </button>
        </div>

        <div class="grid-2">
            <!-- LEFT: Input Form -->
            <div class="space-y-4" id="inputSection">
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-box"></i>
                        <span>Informasi Produk</span>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium mb-1">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" id="productName" class="input-solid w-full" placeholder="Contoh: Samsung A16 8/128GB">
                            <div id="productNameValidation" class="validation-message error hidden"><i class="fas fa-exclamation-circle"></i> Nama produk harus diisi</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-1">Info Tambahan</label>
                            <textarea id="additionalInfo" rows="2" class="input-solid w-full" placeholder="Instruksi khusus untuk AI..."></textarea>
                        </div>
                        <!-- <div>
                            <label class="block text-xs font-medium mb-1">Project</label>
                            <select id="projectId" class="input-solid w-full">
                                <option value="">Tanpa Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div> -->
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-palette"></i>
                        <span>Generate Gambar</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium">Aktifkan generate gambar</span>
                        <label class="switch">
                            <input type="checkbox" id="genImageSwitch">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div id="imageOptions" class="mt-3 space-y-2" style="display: none;">
                        <textarea id="imagePrompt" rows="2" class="input-solid w-full" placeholder="Deskripsi gambar..."></textarea>
                        <select id="imageCount" class="input-solid w-24 text-xs">
                            <option value="1">1 Gambar</option>
                            <option value="2">2 Gambar</option>
                            <option value="3">3 Gambar</option>
                        </select>
                    </div>
                </div>

                <button id="generateBtn" class="btn-primary w-full py-2 flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-magic"></i> Generate & Optimasi
                </button>
            </div>

            <!-- RIGHT: Preview -->
            <div class="space-y-4">
                <!-- Competitor Panel -->
                <div class="competitor-panel" id="competitorPanel" style="display: none;">
                    <div class="text-xs font-bold text-orange-900 mb-2 flex items-center gap-2">
                        <i class="fas fa-chart-line"></i> Riset Kompetitor
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <div class="competitor-stat-card">
                            <div class="text-[9px] text-orange-700 uppercase">Rata-Rata Harga</div>
                            <div class="text-sm font-bold text-orange-900" id="compAvgPrice">Rp 0</div>
                        </div>
                        <div class="competitor-stat-card">
                            <div class="text-[9px] text-orange-700 uppercase">Rentang Harga</div>
                            <div class="text-xs font-bold text-orange-900" id="compPriceRange">Rp 0 - 0</div>
                        </div>
                    </div>
                    <div id="compKeywords" class="flex flex-wrap gap-1"></div>
                </div>

                @php
                    $seoScoreVisible = true;
                    $competitorVisible = true;
                    try {
                        $seoScoreVisible = \App\Models\MenuVisibility::where('menu_key', 'seo_score')->first()->is_visible ?? true;
                        $competitorVisible = \App\Models\MenuVisibility::where('menu_key', 'competitor_analyze')->first()->is_visible ?? true;
                    } catch (\Exception $e) {}
                @endphp
                @if($seoScoreVisible)
                <!-- SEO Score Panel -->
                <div class="seo-score-panel" id="seoScorePanel" style="display: none;">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="text-xs font-bold text-blue-900 flex items-center gap-2">
                                <i class="fas fa-chart-line"></i> SEO Score
                            </div>
                            <div class="text-[10px] text-blue-700">Optimasi produk untuk peringkat terbaik</div>
                        </div>
                        <div class="text-right">
                            <span class="seo-grade" id="seoGrade">-</span>
                            <div class="text-[9px] text-gray-500" id="seoScorePercent">0%</div>
                        </div>
                    </div>
                    <div class="seo-progress-track">
                        <div class="seo-progress-bar" id="seoProgressBar" style="width: 0%;"></div>
                    </div>
                    <div id="seoScoreDetails" class="space-y-1 mt-2"></div>
                    <div class="mt-3 pt-2 border-t border-blue-200/50">
                        <div class="text-[10px] font-bold text-blue-900 mb-1 flex items-center gap-1">
                            <i class="fas fa-lightbulb"></i> Rekomendasi Optimasi:
                        </div>
                        <div id="seoRecommendations" class="space-y-1"></div>
                    </div>
                </div>
                @endif

                <!-- Preview Section -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-eye"></i>
                        <span>Preview Hasil</span>
                    </div>

                    <!-- Gallery -->
                    <div class="mb-3">
                        <div id="galleryContainer" class="gallery-container"></div>
                        <div class="upload-btn" id="uploadImageBtn">
                            <i class="fas fa-plus"></i>
                            <span>Upload</span>
                        </div>
                        <input type="file" id="imageUploadInput" accept="image/jpeg,image/png,image/jpg" multiple style="display: none;">
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <div class="flex justify-between items-center mb-1">
                            <div class="field-loading">
                                <span class="text-xs font-medium text-gray-700">Judul SEO</span>
                                <span id="titleSpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <div class="flex gap-1">
                                <button type="button" id="copyTitleBtn" class="text-gray-400 hover:text-orange text-xs"><i class="fas fa-copy"></i></button>
                                <button type="button" id="refreshTitleBtn" class="text-gray-400 hover:text-orange text-xs"><i class="fas fa-sync-alt"></i></button>
                            </div>
                        </div>
                        <div id="editableTitle" class="input-solid min-h-[50px]" contenteditable="true">-</div>
                        <div class="text-[9px] text-gray-400 mt-1" id="titleCharCount">0 karakter</div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <div class="flex justify-between items-center mb-1">
                            <div class="field-loading">
                                <span class="text-xs font-medium text-gray-700">Deskripsi</span>
                                <span id="descSpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <div class="flex gap-1">
                                <button type="button" id="copyDescBtn" class="text-gray-400 hover:text-orange text-xs"><i class="fas fa-copy"></i></button>
                                <button type="button" id="refreshDescBtn" class="text-gray-400 hover:text-orange text-xs"><i class="fas fa-sync-alt"></i></button>
                            </div>
                        </div>
                        <div id="editableDescription" class="input-solid min-h-[100px]" contenteditable="true">-</div>
                        <div class="text-[9px] text-gray-400 mt-1" id="descCharCount">0 karakter</div>
                    </div>

                    <!-- Category & Brand -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <div class="field-loading mb-1">
                                <span class="text-xs font-medium text-gray-700">Kategori</span>
                                <span id="categorySpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <div class="autocomplete-container">
                                <input type="text" id="previewCategorySearch" class="input-solid w-full text-xs" placeholder="Cari kategori">
                                <div id="previewCategoryDropdown" class="autocomplete-dropdown"></div>
                            </div>
                            <input type="hidden" id="previewCategoryId">
                        </div>
                        <div>
                            <div class="field-loading mb-1">
                                <span class="text-xs font-medium text-gray-700">Brand</span>
                                <span id="brandSpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <input type="text" id="brandInput" class="input-solid w-full text-xs" placeholder="Merek">
                        </div>
                    </div>

                    <!-- Price & Stock -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <div class="field-loading mb-1">
                                <span class="text-xs font-medium text-gray-700">Harga</span>
                                <span id="priceSpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <input type="text" id="priceInput" class="input-solid w-full text-xs" placeholder="0" value="0">
                        </div>
                        <div>
                            <span class="text-xs font-medium text-gray-700 mb-1 block">Stok</span>
                            <input type="number" id="stockInput" class="input-solid w-full text-xs" value="10">
                        </div>
                    </div>

                    <!-- Weight & Dimension -->
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <div class="field-loading mb-1">
                                <span class="text-xs font-medium text-gray-700">Berat (gram)</span>
                                <span id="weightSpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <input type="number" id="weightInput" class="input-solid w-full text-xs" step="any" value="250">
                        </div>
                        <div>
                            <div class="field-loading mb-1">
                                <span class="text-xs font-medium text-gray-700">Dimensi (cm)</span>
                                <span id="dimensionSpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <div class="flex gap-1">
                                <input type="number" id="dimensionP" class="input-solid w-1/3 text-xs" placeholder="P" value="30">
                                <span class="text-gray-400 text-xs">x</span>
                                <input type="number" id="dimensionL" class="input-solid w-1/3 text-xs" placeholder="L" value="20">
                                <span class="text-gray-400 text-xs">x</span>
                                <input type="number" id="dimensionT" class="input-solid w-1/3 text-xs" placeholder="T" value="5">
                            </div>
                            <input type="hidden" id="dimensionInput">
                        </div>
                    </div>

                    <!-- Shipping -->
                    <div class="mb-3">
                        <div class="text-xs font-medium text-gray-700 mb-1">Jasa Kirim</div>
                        <div class="shipping-cards" id="shippingContainer">
                            <div class="shipping-card" data-value="jne">JNE</div>
                            <div class="shipping-card" data-value="jnt">J&T</div>
                            <div class="shipping-card" data-value="pos">POS</div>
                            <div class="shipping-card" data-value="sicepat">SiCepat</div>
                        </div>
                    </div>

                    <!-- Variations -->
                    <div class="mb-3">
                        <div class="flex justify-between items-center mb-3">
                            <div class="field-loading">
                                <span class="text-xs font-medium text-gray-700">Variasi Produk</span>
                                <span id="variationSpinner" class="spinner-small" style="display: none;"></span>
                            </div>
                            <button type="button" id="addVariationBtn" class="btn-outline text-xs add-variation-btn" style="padding: 4px 12px;">
                                <i class="fas fa-plus"></i> Tambah Variasi
                            </button>
                        </div>
                        <div id="variationsContainer"></div>
                        <div class="variation-info">
                            <i class="fas fa-info-circle"></i> Hanya 1 variasi yang dapat memiliki gambar per opsi. Centang "Gambar per Opsi" untuk mengaktifkan upload gambar untuk setiap opsi.
                        </div>
                    </div>

                    <!-- Keywords -->
                    <div class="mb-3">
                        <div class="field-loading mb-1">
                            <span class="text-xs font-medium text-gray-700">Keywords SEO</span>
                            <span id="keywordsSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <div id="previewKeywords" class="flex flex-wrap gap-1"></div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 mt-4">
                        <button id="saveBtn" class="flex-1 btn-primary py-1.5 text-xs flex items-center justify-center gap-1" disabled>
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button id="clearBtn" class="flex-1 btn-secondary py-1.5 text-xs flex items-center justify-center gap-1">
                            <i class="fas fa-trash-alt"></i> Bersihkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Grid Produk -->
<div id="productGridModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-th-large text-orange-500"></i>
                Pilih Produk Kompetitor
            </div>
            <div class="modal-close" onclick="closeProductModal()">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="modal-body" id="productGridBody">
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-pulse text-2xl text-gray-400"></i>
                <p class="text-sm text-gray-500 mt-2">Loading products...</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeProductModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightboxModal" class="lightbox" onclick="closeLightbox()">
    <img id="lightboxImage" src="" alt="Preview">
</div>

<script>
// ==================== DOM Elements ====================
const generateBtn = document.getElementById('generateBtn');
const productNameInput = document.getElementById('productName');
const additionalInfo = document.getElementById('additionalInfo');
const projectSelect = document.getElementById('projectId');
const genImageSwitch = document.getElementById('genImageSwitch');
const imageOptions = document.getElementById('imageOptions');
const imagePrompt = document.getElementById('imagePrompt');
const imageCount = document.getElementById('imageCount');
const saveBtn = document.getElementById('saveBtn');
const clearBtn = document.getElementById('clearBtn');
const editableTitle = document.getElementById('editableTitle');
const editableDescription = document.getElementById('editableDescription');
const previewKeywords = document.getElementById('previewKeywords');
const priceInput = document.getElementById('priceInput');
const stockInput = document.getElementById('stockInput');
const weightInput = document.getElementById('weightInput');
const dimensionP = document.getElementById('dimensionP');
const dimensionL = document.getElementById('dimensionL');
const dimensionT = document.getElementById('dimensionT');
const dimensionInput = document.getElementById('dimensionInput');
const brandInput = document.getElementById('brandInput');
const variationsContainer = document.getElementById('variationsContainer');
const addVariationBtn = document.getElementById('addVariationBtn');
const copyTitleBtn = document.getElementById('copyTitleBtn');
const copyDescBtn = document.getElementById('copyDescBtn');
const refreshTitleBtn = document.getElementById('refreshTitleBtn');
const refreshDescBtn = document.getElementById('refreshDescBtn');
const galleryContainer = document.getElementById('galleryContainer');
const uploadImageBtn = document.getElementById('uploadImageBtn');
const imageUploadInput = document.getElementById('imageUploadInput');

// Stepper
const stepContent1 = document.getElementById('stepContent1');
const stepContent2 = document.getElementById('stepContent2');
const stepContent3 = document.getElementById('stepContent3');
const stepCircle1 = document.getElementById('stepCircle1');
const stepCircle2 = document.getElementById('stepCircle2');
const stepCircle3 = document.getElementById('stepCircle3');
const stepLabel1 = document.getElementById('stepLabel1');
const stepLabel2 = document.getElementById('stepLabel2');
const stepLabel3 = document.getElementById('stepLabel3');
const stepConnector1 = document.getElementById('stepConnector1');
const stepConnector2 = document.getElementById('stepConnector2');

// CSV
const csvFileInput = document.getElementById('csvFileInput');
const csvUploadArea = document.getElementById('csvUploadArea');
const csvProductList = document.getElementById('csvProductList');
const backToStep1Btn = document.getElementById('backToStep1Btn');
const backToStep2Btn = document.getElementById('backToStep2Btn');
const viewProductGridBtn = document.getElementById('viewProductGridBtn');
const productGridModal = document.getElementById('productGridModal');
const productGridBody = document.getElementById('productGridBody');

// SEO Elements
const seoScorePanel = document.getElementById('seoScorePanel');
const seoGrade = document.getElementById('seoGrade');
const seoProgressBar = document.getElementById('seoProgressBar');
const seoScoreDetails = document.getElementById('seoScoreDetails');
const seoRecommendations = document.getElementById('seoRecommendations');
const seoScorePercent = document.getElementById('seoScorePercent');

// Competitor Elements
const competitorPanel = document.getElementById('competitorPanel');
const compAvgPrice = document.getElementById('compAvgPrice');
const compPriceRange = document.getElementById('compPriceRange');
const compKeywords = document.getElementById('compKeywords');

// Validation
const productNameValidation = document.getElementById('productNameValidation');

// Spinners
const titleSpinner = document.getElementById('titleSpinner');
const descSpinner = document.getElementById('descSpinner');
const categorySpinner = document.getElementById('categorySpinner');
const brandSpinner = document.getElementById('brandSpinner');
const priceSpinner = document.getElementById('priceSpinner');
const dimensionSpinner = document.getElementById('dimensionSpinner');
const variationSpinner = document.getElementById('variationSpinner');
const weightSpinner = document.getElementById('weightSpinner');
const keywordsSpinner = document.getElementById('keywordsSpinner');

// State
let isGenerating = false;
let allCategories = [];
let variationCounter = 0;
let variationData = [];
let activeImageVariationId = null;
let imageList = [];
let csvProductsList = [];
let selectedCsvProduct = null;
let currentCompetitorAnalysis = null;
let selectedShipping = ['jne', 'jnt', 'pos', 'sicepat'];
let keywordList = [];

let currentGeneratedData = {
    title: '', description: '', keywords: '', price: 0, stock: 10, weight: 250, dimension: '',
    categoryId: null, brand: '', shippingOptions: ['jne','jnt','pos','sicepat'], variations: [], images: []
};

// Helper functions
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function sanitizeText(text) {
    if (!text) return '';
    return text.replace(/[\u0000-\u001F\u007F-\u009F]/g, '').trim();
}

function showToast(message, type, duration = 2000) {
    const existingToast = document.querySelector('.toast-message');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-message';
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 12px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), duration);
}

// Disable all inputs during generation
function setGeneratingState(disabled) {
    isGenerating = disabled;
    if (disabled) {
        document.body.classList.add('is-generating');
        generateBtn.disabled = true;
        saveBtn.disabled = true;
        clearBtn.disabled = true;
        backToStep2Btn.disabled = true;
        addVariationBtn.disabled = true;
    } else {
        document.body.classList.remove('is-generating');
        generateBtn.disabled = false;
        saveBtn.disabled = !productNameInput.value;
        clearBtn.disabled = false;
        backToStep2Btn.disabled = false;
        addVariationBtn.disabled = false;
    }
}

// Stepper Navigation
function showStep(stepNum) {
    [stepContent1, stepContent2, stepContent3].forEach(el => el.style.display = 'none');
    [stepCircle1, stepCircle2, stepCircle3].forEach(el => el.className = 'step-circle pending');
    [stepLabel1, stepLabel2, stepLabel3].forEach(el => el.className = 'step-label pending');
    [stepConnector1, stepConnector2].forEach(el => el.classList.remove('completed'));

    if (stepNum === 1) {
        stepContent1.style.display = 'block';
        stepCircle1.className = 'step-circle active';
        stepLabel1.className = 'step-label active';
    } else if (stepNum === 2) {
        stepContent2.style.display = 'block';
        stepCircle1.className = 'step-circle completed';
        stepLabel1.className = 'step-label completed';
        stepCircle2.className = 'step-circle active';
        stepLabel2.className = 'step-label active';
        stepConnector1.classList.add('completed');
    } else if (stepNum === 3) {
        stepContent3.style.display = 'block';
        stepCircle1.className = 'step-circle completed';
        stepLabel1.className = 'step-label completed';
        stepCircle2.className = 'step-circle completed';
        stepLabel2.className = 'step-label completed';
        stepCircle3.className = 'step-circle active';
        stepLabel3.className = 'step-label active';
        stepConnector1.classList.add('completed');
        stepConnector2.classList.add('completed');
    }
}

backToStep1Btn.addEventListener('click', () => showStep(1));
backToStep2Btn.addEventListener('click', () => showStep(2));

// CSV Upload
csvUploadArea.addEventListener('click', () => csvFileInput.click());

csvFileInput.addEventListener('change', async function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('csv_file', file);
    document.getElementById('csvUploadError').classList.add('hidden');

    try {
        const res = await fetch('{{ route("generator.upload-csv") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        });
        const data = await res.json();
        if (data.success && data.products) {
            csvProductsList = data.products;
            renderProductList(csvProductsList);
            renderProductGrid(csvProductsList);
            showStep(2);
            showToast('Berhasil upload ' + csvProductsList.length + ' produk!', 'success');
        } else {
            throw new Error(data.message || 'Format CSV tidak valid');
        }
    } catch(err) {
        document.getElementById('csvUploadError').innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + err.message;
        document.getElementById('csvUploadError').classList.remove('hidden');
    } finally {
        csvFileInput.value = '';
    }
});

function renderProductList(products) {
    csvProductList.innerHTML = products.map((p, idx) => `
        <tr class="csv-row-selectable" onclick="selectProduct(${idx})">
            <td class="text-center">${idx + 1}</td>
            <td class="font-medium">${escapeHtml(p.nama_produk)}</td>
            <td class="text-orange-600 font-semibold">Rp ${(p.harga || 0).toLocaleString('id-ID')}</td>
            <td>${escapeHtml(p.terjual || '-')}</td>
            <td><button class="btn-primary text-[10px] py-1 px-2">Pilih</button></td>
        </tr>
    `).join('');
}

function renderProductGrid(products) {
    if (!products || products.length === 0) {
        productGridBody.innerHTML = `
            <div class="text-center py-8">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                <p class="text-sm text-gray-500">Tidak ada produk yang tersedia</p>
            </div>
        `;
        return;
    }
    
    productGridBody.innerHTML = `
        <div class="product-grid">
            ${products.map((p, idx) => `
                <div class="product-card" onclick="selectProductFromGrid(${idx})">
                    <img class="product-card-image" src="${p.url_gambar && p.url_gambar[0] ? p.url_gambar[0] : 'https://placehold.co/280x160/e2e8f0/94a3b8?text=No+Image'}" 
                         onerror="this.src='https://placehold.co/280x160/e2e8f0/94a3b8?text=No+Image'"
                         alt="${escapeHtml(p.nama_produk)}">
                    <div class="product-card-info">
                        <div class="product-card-name">${escapeHtml(p.nama_produk)}</div>
                        <div class="product-card-price">Rp ${(p.harga || 0).toLocaleString('id-ID')}</div>
                        <div class="product-card-sold"><i class="fas fa-chart-line"></i> Terjual: ${p.terjual || '0'}</div>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

// Modal functions
function openProductModal() {
    if (csvProductsList.length === 0) {
        showToast('Belum ada data produk. Upload CSV terlebih dahulu!', 'error');
        return;
    }
    renderProductGrid(csvProductsList);
    productGridModal.classList.add('active');
}

function closeProductModal() {
    productGridModal.classList.remove('active');
}

viewProductGridBtn.addEventListener('click', openProductModal);
productGridModal.addEventListener('click', function(e) {
    if (e.target === productGridModal) closeProductModal();
});

// Select product
window.selectProduct = async function(index) {
    selectedCsvProduct = csvProductsList[index];
    productNameInput.value = selectedCsvProduct.nama_produk;
    validateProductName();

    try {
        const res = await fetch('{{ route("generator.analyze-competitor") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ products: csvProductsList })
        });
        const data = await res.json();
        if (data.success && data.data) {
            currentCompetitorAnalysis = data.data;
            renderCompetitorStats(currentCompetitorAnalysis);
        }
    } catch(err) { console.error(err); }

    currentGeneratedData.price = selectedCsvProduct.harga || 0;
    currentGeneratedData.title = selectedCsvProduct.nama_produk;
    currentGeneratedData.description = selectedCsvProduct.deskripsi_produk || '';
    
    if (selectedCsvProduct.url_gambar && Array.isArray(selectedCsvProduct.url_gambar)) {
        imageList = [...selectedCsvProduct.url_gambar];
    }
    
    updatePreview();
    updateSEOScore();
    showStep(3);
    showToast('Produk "' + selectedCsvProduct.nama_produk.substring(0, 50) + '" dipilih!', 'success');
};

window.selectProductFromGrid = function(index) {
    closeProductModal();
    selectProduct(index);
};

function renderCompetitorStats(stats) {
    if (!stats) return;
    competitorPanel.style.display = 'block';
    compAvgPrice.innerText = 'Rp ' + (stats.price_stats?.avg || 0).toLocaleString('id-ID');
    compPriceRange.innerText = 'Rp ' + (stats.price_stats?.min || 0).toLocaleString('id-ID') + ' - Rp ' + (stats.price_stats?.max || 0).toLocaleString('id-ID');
    
    if (stats.top_keywords?.length) {
        compKeywords.innerHTML = stats.top_keywords.map(kw => `<span class="competitor-tag">${escapeHtml(kw)}</span>`).join('');
    }
}

// Validation
function validateProductName() {
    const isValid = productNameInput.value.trim() !== '';
    productNameValidation.classList.toggle('hidden', isValid);
    return isValid;
}
productNameInput.addEventListener('input', validateProductName);
productNameInput.addEventListener('blur', validateProductName);

// Dimension
function updateDimension() {
    dimensionInput.value = `${dimensionP.value || 0}x${dimensionL.value || 0}x${dimensionT.value || 0}`;
}
[dimensionP, dimensionL, dimensionT].forEach(inp => inp.addEventListener('input', updateDimension));
updateDimension();

// Price Format
function formatPriceInput(input) {
    let val = input.value.replace(/[^0-9]/g, '');
    if (val === '') { input.value = ''; return; }
    input.value = parseInt(val).toLocaleString('id-ID');
}
priceInput.addEventListener('input', () => formatPriceInput(priceInput));

// Image Switch
genImageSwitch.addEventListener('change', function() {
    imageOptions.style.display = this.checked ? 'block' : 'none';
});

// Shipping
function initShippingCards() {
    document.querySelectorAll('.shipping-card').forEach(card => {
        card.removeEventListener('click', handleShippingClick);
        card.addEventListener('click', handleShippingClick);
        if (selectedShipping.includes(card.dataset.value)) card.classList.add('selected');
        else card.classList.remove('selected');
    });
}

function handleShippingClick() {
    if (isGenerating) return;
    const val = this.dataset.value;
    if (selectedShipping.includes(val)) {
        selectedShipping = selectedShipping.filter(v => v !== val);
        this.classList.remove('selected');
    } else {
        selectedShipping.push(val);
        this.classList.add('selected');
    }
    updateSEOScore();
}
initShippingCards();

// Gallery
function renderGallery() {
    if (!galleryContainer) return;
    galleryContainer.innerHTML = imageList.map((url, idx) => `
        <div class="gallery-item">
            <img src="${url}" onclick="openLightbox('${url}')">
            <span class="remove-img" onclick="event.stopPropagation(); removeImage(${idx})"><i class="fas fa-times"></i></span>
        </div>
    `).join('');
}

function removeImage(index) { 
    if (!isGenerating) { 
        imageList.splice(index, 1); 
        renderGallery(); 
        updateSEOScore();
    } 
}

function addImage(url) { 
    imageList.push(url); 
    renderGallery(); 
    updateSEOScore();
}

window.openLightbox = function(src) {
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxModal = document.getElementById('lightboxModal');
    if (lightboxImage && lightboxModal) {
        lightboxImage.src = src;
        lightboxModal.classList.add('active');
    }
};

window.closeLightbox = function() {
    const lightboxModal = document.getElementById('lightboxModal');
    if (lightboxModal) lightboxModal.classList.remove('active');
};

imageUploadInput.addEventListener('change', function(e) {
    if (isGenerating) return;
    Array.from(e.target.files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => addImage(ev.target.result);
            reader.readAsDataURL(file);
        }
    });
    imageUploadInput.value = '';
});

if (uploadImageBtn) {
    uploadImageBtn.addEventListener('click', () => { if (!isGenerating) imageUploadInput.click(); });
}

// Category Autocomplete
async function loadCategories() {
    try {
        const res = await fetch('{{ route("categories.list") }}');
        const data = await res.json();
        if (data.success) allCategories = data.categories;
    } catch(e) { console.error(e); }
}

function setupCategoryAutocomplete(inputId, dropdownId, hiddenId) {
    const input = document.getElementById(inputId);
    const dropdown = document.getElementById(dropdownId);
    const hidden = document.getElementById(hiddenId);
    if (!input) return;
    
    input.addEventListener('input', function() {
        if (isGenerating) return;
        const query = this.value.toLowerCase();
        if (!query.trim()) { dropdown.classList.remove('active'); return; }
        const filtered = allCategories.filter(c => c.name.toLowerCase().includes(query)).slice(0, 10);
        if (filtered.length) {
            dropdown.innerHTML = filtered.map(c => `<div class="autocomplete-item" data-id="${c.id}" data-name="${escapeHtml(c.name)}">${escapeHtml(c.name)}</div>`).join('');
            dropdown.classList.add('active');
            dropdown.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('click', () => {
                    input.value = item.dataset.name;
                    hidden.value = item.dataset.id;
                    dropdown.classList.remove('active');
                    currentGeneratedData.categoryId = item.dataset.id;
                    updateSEOScore();
                });
            });
        } else {
            dropdown.classList.remove('active');
        }
    });
    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.remove('active');
    });
}

// ==================== VARIATIONS WITH ENHANCED IMAGE SUPPORT ====================
function disableOtherImageVariations(exceptIdx) {
    document.querySelectorAll('.variation-card').forEach(card => {
        const cb = card.querySelector('.enable-images-cb');
        const idx = parseInt(card.dataset.idx);
        if (cb && idx !== exceptIdx && cb.checked) {
            cb.checked = false;
            cb.dispatchEvent(new Event('change'));
        }
    });
    activeImageVariationId = exceptIdx;
}

function addVariationField(variation = null) {
    const idx = variationCounter++;
    const hasImageSupport = variation ? variation.hasImage === true : false;
    
    const div = document.createElement('div');
    div.className = 'variation-card';
    div.dataset.idx = idx;
    div.innerHTML = `
        <div class="variation-header">
            <div class="variation-name-wrapper">
                <label><i class="fas fa-tag"></i> Nama Variasi</label>
                <input type="text" placeholder="Contoh: Warna, Ukuran, Bahan" 
                       class="variation-name input-solid text-xs" value="${variation ? escapeHtml(variation.name) : ''}">
            </div>
            <div class="variation-actions">
                <div class="enable-images-checkbox">
                    <input type="checkbox" class="enable-images-cb" ${hasImageSupport ? 'checked' : ''}>
                    <span><i class="fas fa-image"></i> Gambar per Opsi</span>
                </div>
                <button type="button" class="remove-variation" title="Hapus Variasi">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </div>
        </div>
        <div class="variation-options" id="var-options-${idx}"></div>
        <div class="add-option-wrapper">
            <input type="text" placeholder="+ Tambah opsi baru (contoh: Merah, Biru atau S, M, L)" 
                   class="add-option-input" data-idx="${idx}">
        </div>
        <div class="image-support-info ${hasImageSupport ? 'text-orange-600' : 'text-gray-400'}">
            ${hasImageSupport ? '<i class="fas fa-image"></i> Klik ikon kamera untuk upload gambar setiap opsi' : '<i class="fas fa-info-circle"></i> Centang "Gambar per Opsi" untuk mengupload gambar tiap opsi variasi'}
        </div>
    `;
    
    const optionsContainer = div.querySelector('#var-options-' + idx);
    const enableCb = div.querySelector('.enable-images-cb');
    const infoDiv = div.querySelector('.image-support-info');
    let options = [];
    
    if (variation && variation.options) {
        if (hasImageSupport && Array.isArray(variation.options) && variation.options[0] && variation.options[0].value !== undefined) {
            options = variation.options.map(opt => ({ value: opt.value, image: opt.image || null }));
        } else if (!hasImageSupport && Array.isArray(variation.options)) {
            options = variation.options.map(opt => ({ value: opt, image: null }));
        }
    }
    
    function renderOptions() {
        const hasImage = enableCb.checked;
        optionsContainer.innerHTML = '';
        if (options.length === 0) {
            optionsContainer.innerHTML = '<div class="text-center text-gray-400 py-4 text-xs">Belum ada opsi. Ketik opsi di atas dan tekan Enter</div>';
            return;
        }
        
        options.forEach((opt, optIdx) => {
            const optDiv = document.createElement('div');
            optDiv.className = 'option-item';
            
            if (hasImage) {
                const hasValidImage = opt.image && opt.image !== 'null' && opt.image !== '';
                const imageHtml = hasValidImage 
                    ? `<img src="${opt.image}">` 
                    : '<i class="fas fa-image no-img"></i>';
                
                optDiv.innerHTML = `
                    <div class="option-image-wrapper">
                        <div class="option-image" onclick="${hasValidImage ? `openLightbox('${opt.image}')` : ''}">
                            ${imageHtml}
                        </div>
                    </div>
                    <div class="option-value">${escapeHtml(opt.value)}</div>
                    <div class="option-buttons">
                        <button type="button" class="option-upload-btn" data-opt-idx="${optIdx}">
                            <i class="fas fa-camera"></i> Upload
                        </button>
                        <button type="button" class="option-remove-img" data-opt-idx="${optIdx}" ${!hasValidImage ? 'disabled' : ''}>
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <input type="file" class="option-file-input hidden" accept="image/jpeg,image/png,image/jpg" data-opt-idx="${optIdx}" style="display:none;">
                `;
                
                const uploadBtn = optDiv.querySelector('.option-upload-btn');
                const fileInput = optDiv.querySelector('.option-file-input');
                const removeBtn = optDiv.querySelector('.option-remove-img');
                
                uploadBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (isGenerating) return;
                    fileInput.click();
                });
                
                fileInput.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (ev) => {
                            opt.image = ev.target.result;
                            renderOptions();
                            syncVariationData();
                            updateSEOScore();
                            showToast('Gambar berhasil diupload untuk ' + opt.value, 'success', 1500);
                        };
                        reader.readAsDataURL(file);
                    }
                    fileInput.value = '';
                });
                
                removeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (isGenerating) return;
                    opt.image = null;
                    renderOptions();
                    syncVariationData();
                    updateSEOScore();
                    showToast('Gambar dihapus untuk ' + opt.value, 'info', 1000);
                });
            } else {
                optDiv.innerHTML = `<div class="option-value" style="margin-left: 0;">${escapeHtml(opt.value)}</div>`;
            }
            optionsContainer.appendChild(optDiv);
        });
    }
    renderOptions();
    
    const newOptionInput = div.querySelector('.add-option-input');
    newOptionInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && newOptionInput.value.trim() && !isGenerating) {
            e.preventDefault();
            options.push({ value: newOptionInput.value.trim(), image: null });
            renderOptions();
            newOptionInput.value = '';
            syncVariationData();
            updateSEOScore();
            showToast('Opsi "' + newOptionInput.value.trim() + '" ditambahkan', 'success', 1000);
        }
    });
    
    enableCb.addEventListener('change', function() {
        const hasImage = enableCb.checked;
        if (hasImage) {
            disableOtherImageVariations(idx);
        } else {
            if (activeImageVariationId === idx) activeImageVariationId = null;
        }
        document.querySelectorAll('.variation-card .enable-images-cb').forEach(cb => {
            const cbIdx = parseInt(cb.closest('.variation-card').dataset.idx);
            if (cb && cbIdx !== idx) cb.disabled = hasImage;
        });
        infoDiv.innerHTML = hasImage 
            ? '<i class="fas fa-image"></i> Klik ikon kamera untuk upload gambar setiap opsi' 
            : '<i class="fas fa-info-circle"></i> Centang "Gambar per Opsi" untuk mengupload gambar tiap opsi variasi';
        infoDiv.className = 'image-support-info ' + (hasImage ? 'text-orange-600' : 'text-gray-400');
        if (!hasImage) {
            options.forEach(opt => opt.image = null);
        }
        renderOptions();
        syncVariationData();
        updateSEOScore();
    });
    
    div.querySelector('.remove-variation').addEventListener('click', () => {
        if (!isGenerating) {
            div.remove();
            variationData = variationData.filter(v => v.idx !== idx);
            syncGlobalVariationData();
            updateSEOScore();
            showToast('Variasi dihapus', 'info', 1000);
        }
    });
    
    variationsContainer.appendChild(div);
    
    function syncVariationData() {
        const varName = div.querySelector('.variation-name').value.trim();
        const hasImage = enableCb.checked;
        const opts = hasImage 
            ? options.map(opt => ({ value: opt.value, image: opt.image }))
            : options.map(opt => opt.value);
        
        if (varName && options.length > 0) {
            const existingIndex = variationData.findIndex(v => v.idx === idx);
            if (existingIndex !== -1) {
                variationData[existingIndex] = { idx, name: varName, options: opts, hasImage };
            } else {
                variationData.push({ idx, name: varName, options: opts, hasImage });
            }
        } else {
            variationData = variationData.filter(v => v.idx !== idx);
        }
        syncGlobalVariationData();
    }
    
    const nameInput = div.querySelector('.variation-name');
    nameInput.addEventListener('input', () => { syncVariationData(); updateSEOScore(); });
    syncVariationData();
}

function syncGlobalVariationData() {
    currentGeneratedData.variations = variationData.map(v => ({
        name: v.name,
        hasImage: v.hasImage,
        options: v.options
    }));
}

addVariationBtn.addEventListener('click', () => { if (!isGenerating) addVariationField(); });

// Update Preview
function updatePreview() {
    if (currentGeneratedData.price > 0) priceInput.value = currentGeneratedData.price.toLocaleString('id-ID');
    if (currentGeneratedData.stock) stockInput.value = currentGeneratedData.stock;
    if (currentGeneratedData.weight) weightInput.value = currentGeneratedData.weight;
    if (currentGeneratedData.brand) brandInput.value = currentGeneratedData.brand;
    if (currentGeneratedData.title) editableTitle.innerText = currentGeneratedData.title;
    if (currentGeneratedData.description) editableDescription.innerHTML = currentGeneratedData.description;
    if (currentGeneratedData.dimension) {
        const parts = currentGeneratedData.dimension.split('x');
        if (parts.length === 3) {
            dimensionP.value = parts[0];
            dimensionL.value = parts[1];
            dimensionT.value = parts[2];
            updateDimension();
        }
    }
    if (currentGeneratedData.keywords) {
        const kwList = currentGeneratedData.keywords.split(',').map(k => k.trim()).filter(k => k);
        previewKeywords.innerHTML = kwList.map(k => `
            <span class="keyword-badge">
                ${escapeHtml(k)} 
                <i class="fas fa-copy" onclick="copyKeyword('${escapeHtml(k)}')"></i>
            </span>
        `).join('');
        keywordList = kwList;
    }
    if (currentGeneratedData.variations?.length && variationsContainer.children.length === 0) {
        variationCounter = 0;
        variationData = [];
        activeImageVariationId = null;
        currentGeneratedData.variations.forEach(v => addVariationField(v));
    }
    if (imageList.length === 0 && currentGeneratedData.images?.length) {
        imageList = [...currentGeneratedData.images];
    }
    renderGallery();
    saveBtn.disabled = !productNameInput.value || isGenerating;
    
    updateCharCounts();
}

function updateCharCounts() {
    const titleCharCount = document.getElementById('titleCharCount');
    const descCharCount = document.getElementById('descCharCount');
    if (titleCharCount) {
        const titleLen = editableTitle.innerText === '-' ? 0 : editableTitle.innerText.length;
        titleCharCount.innerHTML = `${titleLen} karakter ${titleLen >= 30 && titleLen <= 70 ? '✓ optimal' : '(ideal: 30-70 karakter)'}`;
        titleCharCount.style.color = titleLen >= 30 && titleLen <= 70 ? '#10b981' : '#f59e0b';
    }
    if (descCharCount) {
        const descLen = editableDescription.innerText === '-' ? 0 : editableDescription.innerText.length;
        descCharCount.innerHTML = `${descLen} karakter ${descLen >= 100 && descLen <= 500 ? '✓ optimal' : '(ideal: 100-500 karakter)'}`;
        descCharCount.style.color = descLen >= 100 && descLen <= 500 ? '#10b981' : '#f59e0b';
    }
}

editableTitle.addEventListener('input', () => {
    updateCharCounts();
    updateSEOScore();
});
editableDescription.addEventListener('input', () => {
    updateCharCounts();
    updateSEOScore();
});

// ==================== ENHANCED SEO SCORE ====================
function calculateSEOScore() {
    const title = editableTitle.innerText === '-' ? '' : editableTitle.innerText.trim();
    const description = editableDescription.innerText === '-' ? '' : editableDescription.innerText.trim();
    const hasCategory = document.getElementById('previewCategoryId') && document.getElementById('previewCategoryId').value;
    const hasBrand = brandInput.value.trim() !== '';
    const price = parseInt(priceInput.value.replace(/[^0-9]/g, '')) || 0;
    const hasImages = imageList.length > 0;
    const hasVariations = currentGeneratedData.variations && currentGeneratedData.variations.length > 0;
    const keywordCount = keywordList.length;
    
    let totalScore = 0;
    let maxScore = 100;
    let details = [];
    
    // Title Score (max 25 points)
    let titleScore = 0;
    let titleMessage = '';
    if (title.length === 0) {
        titleScore = 0;
        titleMessage = 'Judul belum diisi';
    } else if (title.length < 20) {
        titleScore = 8;
        titleMessage = 'Judul terlalu pendek (min 20 karakter)';
    } else if (title.length >= 20 && title.length <= 40) {
        titleScore = 18;
        titleMessage = 'Judul cukup baik';
    } else if (title.length > 40 && title.length <= 70) {
        titleScore = 25;
        titleMessage = 'Judul optimal untuk SEO';
    } else if (title.length > 70 && title.length <= 100) {
        titleScore = 15;
        titleMessage = 'Judul agak panjang';
    } else {
        titleScore = 8;
        titleMessage = 'Judul terlalu panjang (>100 karakter)';
    }
    details.push({ name: 'Judul SEO', score: titleScore, max: 25, message: titleMessage });
    totalScore += titleScore;
    
    // Description Score (max 20 points)
    let descScore = 0;
    let descMessage = '';
    if (description.length === 0) {
        descScore = 0;
        descMessage = 'Deskripsi belum diisi';
    } else if (description.length < 50) {
        descScore = 5;
        descMessage = 'Deskripsi terlalu pendek (min 50 karakter)';
    } else if (description.length >= 50 && description.length <= 150) {
        descScore = 12;
        descMessage = 'Deskripsi cukup baik';
    } else if (description.length > 150 && description.length <= 500) {
        descScore = 20;
        descMessage = 'Deskripsi optimal untuk SEO';
    } else if (description.length > 500 && description.length <= 1000) {
        descScore = 14;
        descMessage = 'Deskripsi agak panjang';
    } else {
        descScore = 7;
        descMessage = 'Deskripsi terlalu panjang (>1000 karakter)';
    }
    details.push({ name: 'Deskripsi', score: descScore, max: 20, message: descMessage });
    totalScore += descScore;
    
    // Keywords Score (max 15 points)
    let keywordScore = 0;
    let keywordMessage = '';
    if (keywordCount === 0) {
        keywordScore = 0;
        keywordMessage = 'Belum ada keyword';
    } else if (keywordCount >= 3 && keywordCount <= 8) {
        keywordScore = 15;
        keywordMessage = 'Keyword optimal (' + keywordCount + ' keyword)';
    } else if (keywordCount > 0 && keywordCount < 3) {
        keywordScore = 8;
        keywordMessage = 'Keyword terlalu sedikit (min 3)';
    } else {
        keywordScore = 10;
        keywordMessage = 'Keyword terlalu banyak (max 8)';
    }
    details.push({ name: 'Keywords', score: keywordScore, max: 15, message: keywordMessage });
    totalScore += keywordScore;
    
    // Category & Brand Score (max 15 points)
    let catBrandScore = 0;
    if (hasCategory && hasBrand) {
        catBrandScore = 15;
    } else if (hasCategory || hasBrand) {
        catBrandScore = 8;
    } else {
        catBrandScore = 0;
    }
    let catBrandMessage = hasCategory && hasBrand ? 'Kategori dan brand terisi' : (hasCategory ? 'Brand belum diisi' : (hasBrand ? 'Kategori belum diisi' : 'Kategori dan brand belum diisi'));
    details.push({ name: 'Kategori & Brand', score: catBrandScore, max: 15, message: catBrandMessage });
    totalScore += catBrandScore;
    
    // Price Score (max 10 points)
    let priceScore = price > 0 ? 10 : 0;
    details.push({ name: 'Harga', score: priceScore, max: 10, message: price > 0 ? 'Harga valid' : 'Harga belum diisi' });
    totalScore += priceScore;
    
    // Images Score (max 10 points)
    let imagesScore = 0;
    if (hasImages) {
        imagesScore = imageList.length >= 3 ? 10 : (imageList.length === 2 ? 7 : 4);
    }
    details.push({ name: 'Gambar', score: imagesScore, max: 10, message: hasImages ? (imageList.length >= 3 ? 'Gambar cukup (' + imageList.length + ' gambar)' : 'Tambahkan lebih banyak gambar (min 3)') : 'Belum ada gambar' });
    totalScore += imagesScore;
    
    // Variations Score (max 5 points)
    let variationsScore = hasVariations ? 5 : 0;
    details.push({ name: 'Variasi', score: variationsScore, max: 5, message: hasVariations ? 'Variasi produk tersedia' : 'Tambah variasi produk' });
    totalScore += variationsScore;
    
    let percentage = Math.round((totalScore / maxScore) * 100);
    let grade = 'F';
    let gradeClass = 'seo-grade-F';
    let progressColor = 'seo-progress-bar-F';
    
    if (percentage >= 85) { grade = 'A'; gradeClass = 'seo-grade-A'; progressColor = 'seo-progress-bar-A'; }
    else if (percentage >= 70) { grade = 'B'; gradeClass = 'seo-grade-B'; progressColor = 'seo-progress-bar-B'; }
    else if (percentage >= 55) { grade = 'C'; gradeClass = 'seo-grade-C'; progressColor = 'seo-progress-bar-C'; }
    else if (percentage >= 40) { grade = 'D'; gradeClass = 'seo-grade-D'; progressColor = 'seo-progress-bar-D'; }
    else if (percentage >= 25) { grade = 'E'; gradeClass = 'seo-grade-E'; progressColor = 'seo-progress-bar-E'; }
    else { grade = 'F'; gradeClass = 'seo-grade-F'; progressColor = 'seo-progress-bar-F'; }
    
    let recommendations = [];
    if (title.length === 0 || title.length < 20) recommendations.push({ type: 'danger', text: 'Buat judul produk yang menarik dan mengandung kata kunci utama (min 20 karakter)' });
    if (title.length > 70) recommendations.push({ type: 'warning', text: 'Persingkat judul menjadi 40-70 karakter untuk hasil SEO yang lebih baik' });
    if (description.length === 0) recommendations.push({ type: 'danger', text: 'Isi deskripsi produk yang detail untuk meningkatkan konversi' });
    if (description.length < 100) recommendations.push({ type: 'warning', text: 'Tambahkan deskripsi yang lebih detail (min 100 karakter)' });
    if (keywordCount === 0) recommendations.push({ type: 'danger', text: 'Tambahkan keywords yang relevan dengan produk Anda' });
    if (keywordCount > 0 && keywordCount < 3) recommendations.push({ type: 'warning', text: 'Tambahkan lebih banyak keywords (minimal 3)' });
    if (!hasCategory) recommendations.push({ type: 'warning', text: 'Pilih kategori yang tepat untuk produk Anda' });
    if (!hasBrand) recommendations.push({ type: 'warning', text: 'Isi brand/merek produk' });
    if (imageList.length === 0) recommendations.push({ type: 'danger', text: 'Upload gambar produk (minimal 3 gambar untuk hasil terbaik)' });
    if (imageList.length > 0 && imageList.length < 3) recommendations.push({ type: 'warning', text: 'Tambahkan lebih banyak gambar produk (minimal 3 gambar)' });
    if (!hasVariations) recommendations.push({ type: 'info', text: 'Tambah variasi produk (ukuran, warna, dll) untuk meningkatkan conversion rate' });
    
    return { totalScore, maxScore, percentage, grade, gradeClass, progressColor, details, recommendations };
}

function updateSEOScore() {
    if (!seoScorePanel) return;
    
    const scoreData = calculateSEOScore();
    seoScorePanel.style.display = 'block';
    seoGrade.textContent = scoreData.grade;
    seoGrade.className = 'seo-grade ' + scoreData.gradeClass;
    
    if (seoProgressBar) {
        seoProgressBar.style.width = scoreData.percentage + '%';
        seoProgressBar.className = 'seo-progress-bar ' + scoreData.progressColor;
    }
    
    if (seoScorePercent) {
        seoScorePercent.textContent = scoreData.percentage + '%';
    }
    
    if (seoScoreDetails) {
        seoScoreDetails.innerHTML = scoreData.details.map(detail => `
            <div class="seo-detail-row">
                <span class="seo-detail-label">${detail.name}</span>
                <div class="seo-detail-bar-track">
                    <div class="seo-detail-bar-fill" style="width: ${(detail.score / detail.max) * 100}%; background: ${detail.score / detail.max >= 0.7 ? '#10b981' : (detail.score / detail.max >= 0.4 ? '#f59e0b' : '#ef4444')};"></div>
                </div>
                <span class="seo-detail-score">${detail.score}/${detail.max}</span>
            </div>
            <div class="text-[9px] text-gray-400 ml-[90px] -mt-1 mb-1">${detail.message}</div>
        `).join('');
    }
    
    if (seoRecommendations) {
        seoRecommendations.innerHTML = scoreData.recommendations.map(rec => `
            <div class="seo-recommendation ${rec.type === 'danger' ? 'danger' : (rec.type === 'warning' ? 'warning' : '')}">
                <i class="fas ${rec.type === 'danger' ? 'fa-exclamation-circle' : (rec.type === 'warning' ? 'fa-clock' : 'fa-info-circle')}"></i>
                ${rec.text}
            </div>
        `).join('');
    }
    
    currentGeneratedData.seoScore = scoreData;
}

window.copyKeyword = function(kw) {
    navigator.clipboard.writeText(kw);
    showToast('Keyword "' + kw + '" copied!', 'success', 1000);
};

// Copy & Refresh
copyTitleBtn.addEventListener('click', () => { 
    if (isGenerating) return;
    navigator.clipboard.writeText(editableTitle.innerText); 
    showToast('Title copied!', 'success', 1000);
});

copyDescBtn.addEventListener('click', () => { 
    if (isGenerating) return;
    navigator.clipboard.writeText(editableDescription.innerText); 
    showToast('Description copied!', 'success', 1000);
});

refreshTitleBtn.addEventListener('click', async () => { 
    if (isGenerating || !validateProductName()) return; 
    titleSpinner.style.display = 'inline-block';
    try {
        const res = await fetch('{{ route("generator.generate-complete") }}', {
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify({ 
                name: productNameInput.value, 
                additional_prompt: additionalInfo.value, 
                csv_data: selectedCsvProduct, 
                csv_products: csvProductsList 
            })
        });
        const data = await res.json();
        if (data.success && data.data) { 
            editableTitle.innerText = data.data.ai_title || productNameInput.value; 
            currentGeneratedData.title = editableTitle.innerText;
            updateCharCounts();
            updateSEOScore(); 
        }
    } catch(e) { 
        console.error(e); 
        showToast('Error: ' + e.message, 'error', 3000);
    } finally { 
        titleSpinner.style.display = 'none'; 
    }
});

refreshDescBtn.addEventListener('click', async () => { 
    if (isGenerating || !validateProductName()) return; 
    descSpinner.style.display = 'inline-block';
    try {
        const res = await fetch('{{ route("generator.generate-complete") }}', {
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify({ 
                name: productNameInput.value, 
                additional_prompt: additionalInfo.value, 
                csv_data: selectedCsvProduct, 
                csv_products: csvProductsList 
            })
        });
        const data = await res.json();
        if (data.success && data.data) { 
            editableDescription.innerHTML = data.data.ai_description || ''; 
            currentGeneratedData.description = editableDescription.innerHTML;
            updateCharCounts();
            updateSEOScore(); 
        }
    } catch(e) { 
        console.error(e); 
        showToast('Error: ' + e.message, 'error', 3000);
    } finally { 
        descSpinner.style.display = 'none'; 
    }
});

// Generate Main Function
generateBtn.addEventListener('click', async function() {
    if (!validateProductName() || isGenerating) return;
    
    setGeneratingState(true);
    generateBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
    
    const spinners = [titleSpinner, descSpinner, categorySpinner, brandSpinner, priceSpinner, dimensionSpinner, variationSpinner, weightSpinner, keywordsSpinner];
    spinners.forEach(s => { if (s) s.style.display = 'inline-block'; });
    
    try {
        if (genImageSwitch.checked) {
            const prompt = imagePrompt.value || `${productNameInput.value} product photography, studio lighting, white background, high quality`;
            const count = parseInt(imageCount.value) || 1;
            const imgRes = await fetch('{{ route("generator.generate-image") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ prompt, count })
            });
            const imgData = await imgRes.json();
            if (imgData.success && imgData.images) {
                imgData.images.forEach(img => {
                    if (!imageList.includes(img)) imageList.push(img);
                });
                renderGallery();
            }
        }
        
        const res = await fetch('{{ route("generator.generate-complete") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: productNameInput.value,
                additional_prompt: additionalInfo.value,
                csv_data: selectedCsvProduct,
                csv_products: csvProductsList
            })
        });
        const data = await res.json();
        
        if (data.success && data.data) {
            const d = data.data;
            currentGeneratedData = {
                title: d.ai_title || productNameInput.value,
                description: d.ai_description || '',
                keywords: d.keywords || '',
                price: d.recommended_price || selectedCsvProduct?.harga || 0,
                stock: 10,
                weight: d.recommended_weight || 250,
                dimension: d.recommended_dimension || '30x20x5',
                categoryId: d.recommended_category_id || null,
                brand: d.recommended_brand || '',
                shippingOptions: d.recommended_shipping_options || ['jne', 'jnt', 'pos', 'sicepat'],
                variations: d.recommended_variations || [],
                images: imageList
            };
            
            if (d.recommended_shipping_options) {
                selectedShipping = d.recommended_shipping_options;
                initShippingCards();
            }
            
            if (d.recommended_category_id && allCategories.length) {
                const cat = allCategories.find(c => c.id == d.recommended_category_id);
                if (cat) {
                    document.getElementById('previewCategorySearch').value = cat.name;
                    document.getElementById('previewCategoryId').value = cat.id;
                }
            }
            
            if (d.keywords) {
                keywordList = d.keywords.split(',').map(k => k.trim()).filter(k => k);
            }
            
            updatePreview();
            updateSEOScore();
            showToast('✨ Produk berhasil digenerate! Silakan review dan edit jika diperlukan.', 'success', 3000);
        } else {
            throw new Error(data.message || 'Gagal generate produk');
        }
    } catch(e) {
        console.error(e);
        showToast('Error: ' + e.message, 'error', 3000);
    } finally {
        setGeneratingState(false);
        generateBtn.innerHTML = '<i class="fas fa-magic"></i> Generate & Optimasi';
        spinners.forEach(s => { if (s) s.style.display = 'none'; });
    }
});

// Save Product
saveBtn.addEventListener('click', async function() {
    if (isGenerating || !validateProductName()) return;
    
    let hasImageVariation = false;
    let missingImages = [];
    
    for (const variation of variationData) {
        if (variation.hasImage && variation.options && variation.options.length > 0) {
            hasImageVariation = true;
            for (let i = 0; i < variation.options.length; i++) {
                const opt = variation.options[i];
                if (!opt.image || opt.image === null || opt.image === '') {
                    missingImages.push(`${variation.name}: ${opt.value}`);
                }
            }
        }
    }
    
    if (hasImageVariation && missingImages.length > 0) {
        showToast(`Gambar wajib diupload untuk semua opsi variasi!\nOpsi yang belum: ${missingImages.join(', ')}`, 'error', 5000);
        return;
    }
    
    setGeneratingState(true);
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Menyimpan...';
    
    const variations = currentGeneratedData.variations.map(v => {
        if (v.hasImage && Array.isArray(v.options)) {
            return {
                name: v.name,
                hasImage: true,
                options: v.options.map(opt => ({
                    value: opt.value,
                    image: opt.image || null
                }))
            };
        } else {
            return {
                name: v.name,
                hasImage: false,
                options: v.options
            };
        }
    });
    
    const payload = {
        name: sanitizeText(productNameInput.value),
        ai_title: sanitizeText(editableTitle.innerText),
        description: sanitizeText(editableDescription.innerHTML),
        keywords: currentGeneratedData.keywords || '',
        category_id: document.getElementById('previewCategoryId').value || null,
        brand: sanitizeText(brandInput.value),
        price: parseInt(priceInput.value.replace(/[^0-9]/g, '')) || 0,
        stock: parseInt(stockInput.value) || 0,
        weight: parseFloat(weightInput.value) || 250,
        dimension: dimensionInput.value || '',
        shipping_options: selectedShipping,
        variations: variations,
        project_id: projectSelect.value || null,
        images: imageList
    };
    
    try {
        const res = await fetch('{{ route("generator.save") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        
        const data = await res.json();
        if (data.success) {
            showToast('✅ Produk berhasil disimpan!', 'success', 1500);
            setTimeout(() => {
                if (data.product && data.product.uuid) {
                    window.location.href = '/products/' + data.product.uuid;
                } else {
                    window.location.href = '{{ route("products.index") }}';
                }
            }, 1500);
        } else {
            showToast('❌ Gagal menyimpan: ' + (data.message || 'Unknown error'), 'error', 3000);
        }
    } catch(e) {
        console.error('Save error:', e);
        showToast('Error: ' + e.message, 'error', 3000);
    } finally {
        setGeneratingState(false);
        this.disabled = false;
        this.innerHTML = '<i class="fas fa-save"></i> Simpan Produk';
    }
});

// Clear All
clearBtn.addEventListener('click', () => {
    if (isGenerating) return;
    if (confirm('Bersihkan semua data? Semua perubahan akan hilang.')) {
        productNameInput.value = '';
        additionalInfo.value = '';
        imagePrompt.value = '';
        genImageSwitch.checked = false;
        imageOptions.style.display = 'none';
        variationsContainer.innerHTML = '';
        variationCounter = 0;
        variationData = [];
        activeImageVariationId = null;
        editableTitle.innerText = '-';
        editableDescription.innerText = '-';
        previewKeywords.innerHTML = '';
        brandInput.value = '';
        priceInput.value = '';
        stockInput.value = '10';
        weightInput.value = '250';
        dimensionP.value = '30';
        dimensionL.value = '20';
        dimensionT.value = '5';
        updateDimension();
        document.getElementById('previewCategorySearch').value = '';
        document.getElementById('previewCategoryId').value = '';
        productNameValidation.classList.add('hidden');
        selectedShipping = ['jne', 'jnt', 'pos', 'sicepat'];
        initShippingCards();
        imageList = [];
        keywordList = [];
        renderGallery();
        currentGeneratedData = {
            title: '', description: '', keywords: '', price: 0, stock: 10, weight: 250, dimension: '',
            categoryId: null, brand: '', shippingOptions: ['jne', 'jnt', 'pos', 'sicepat'], variations: [], images: []
        };
        updateCharCounts();
        updateSEOScore();
        saveBtn.disabled = true;
        showToast('Semua data telah dibersihkan', 'info', 1500);
    }
});

// Event listeners for real-time SEO updates
brandInput.addEventListener('input', () => updateSEOScore());
priceInput.addEventListener('input', () => updateSEOScore());
stockInput.addEventListener('input', () => updateSEOScore());
weightInput.addEventListener('input', () => updateSEOScore());
[dimensionP, dimensionL, dimensionT].forEach(inp => inp.addEventListener('input', () => updateSEOScore()));

// Drag & drop for CSV upload
csvUploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    csvUploadArea.style.borderColor = '#ee4d2d';
    csvUploadArea.style.background = '#fff5f2';
});

csvUploadArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    csvUploadArea.style.borderColor = '#cbd5e1';
    csvUploadArea.style.background = '#f8fafc';
});

csvUploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    csvUploadArea.style.borderColor = '#cbd5e1';
    csvUploadArea.style.background = '#f8fafc';
    const file = e.dataTransfer.files[0];
    if (file && (file.type === 'text/csv' || file.name.endsWith('.csv'))) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        csvFileInput.files = dataTransfer.files;
        csvFileInput.dispatchEvent(new Event('change'));
    } else {
        showToast('Harap upload file CSV!', 'error', 2000);
    }
});

// Initialize
loadCategories();
setupCategoryAutocomplete('previewCategorySearch', 'previewCategoryDropdown', 'previewCategoryId');
updateCharCounts();
showStep(1);
</script>
@endsection
<style>
    .page-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--control-panel-border);
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .editor-info-card {
        background: var(--control-panel-card-bg);
        border: 1px solid var(--control-panel-border);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 2rem;
    }

    .editor-info-card h3 {
        margin: 0 0 0.5rem 0;
        color: var(--control-panel-text);
        font-size: 1rem;
    }

    .editor-info-card p {
        margin: 0;
        color: var(--control-panel-text-muted);
    }

    .destination-form {
        margin-top: 2rem;
    }

    .tabs-container {
        background: var(--control-panel-card-bg);
        border: 1px solid var(--control-panel-border);
        border-radius: 8px;
        overflow: hidden;
    }

    .tabs-nav {
        display: flex;
        background: var(--control-panel-bg);
        border-bottom: 1px solid var(--control-panel-border);
        overflow-x: auto;
    }

    .tab-button {
        padding: 1rem 1.5rem;
        border: none;
        background: transparent;
        color: var(--control-panel-text-muted);
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .tab-button:hover {
        background: var(--control-panel-hover-bg, rgba(0, 0, 0, 0.05));
        color: var(--control-panel-text);
    }

    .tab-button.active {
        background: var(--control-panel-card-bg);
        color: var(--control-panel-accent);
        border-bottom: 2px solid var(--control-panel-accent);
    }

    .tab-content {
        display: none;
        padding: 2rem;
    }

    .tab-content.active {
        display: block;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--control-panel-text);
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--control-panel-border);
        border-radius: 4px;
        background: var(--control-panel-card-bg);
        color: var(--control-panel-text);
        font-size: 0.9rem;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--control-panel-accent);
    }

    .error-message {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: block;
    }

    .activity-item,
    .service-item {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        align-items: center;
    }

    .activity-item input,
    .service-item input,
    .service-item select {
        flex: 1;
    }

    .remove-item {
        padding: 0.5rem 1rem;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .form-actions {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--control-panel-border);
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .tabs-nav {
            flex-wrap: wrap;
        }

        .tab-button {
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
        }

        .tab-content {
            padding: 1rem;
        }

        .header-actions {
            flex-direction: column;
        }

        .activity-item,
        .service-item {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

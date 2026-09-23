<style>
    #bibliotheque-liste {
        padding: 12px 0 80px;
    }

    /* --- Filtres --- */
    .biblio-filters {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
        padding: 20px;
        background: var(--paper-alt);
        border: 1px solid var(--line);
    }

    .filter-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 180px;
    }

    .filter-field label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .03em;
        color: var(--ink-soft);
    }

    .filter-field select,
    .filter-field input {
        border: 1px solid var(--line);
        background: var(--white);
        padding: 8px 10px;
        font-size: 14px;
        color: var(--ink);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    /* --- Grille de cartes --- */
    .biblio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 28px;
    }

    .biblio-card {
        display: flex;
        flex-direction: column;
        border: 1px solid var(--line);
        border-top: 3px solid var(--forest-mid);
        background: var(--white);
        padding: 20px;
        border-radius: var(--radius);
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .biblio-card:hover {
        box-shadow: var(--shadow);
        transform: translateY(-3px);
    }

    .biblio-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .biblio-format {
        font-family: "Fraunces", serif;
        font-weight: 700;
        font-size: 11px;
        color: var(--forest-deep);
        background: var(--water-soft);
        padding: 4px 10px;
        border-radius: var(--radius);
    }

    .biblio-categorie {
        font-size: 12px;
        color: var(--ink-soft);
        font-weight: 600;
    }

    .biblio-title {
        font-family: "Fraunces", serif;
        font-size: 17px;
        line-height: 1.35;
        margin: 0 0 8px;
        color: var(--forest-deep);
    }

    .biblio-desc {
        font-size: 13.5px;
        line-height: 1.55;
        color: var(--ink-soft);
        margin: 0 0 14px;
        flex-grow: 1;
    }

    .biblio-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 4px 14px;
        font-size: 12.5px;
        color: var(--ink-soft);
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px dashed var(--line);
    }

    .biblio-meta .lbl {
        font-weight: 700;
        color: var(--ink);
    }

    .biblio-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }

    .biblio-card-footer .btn svg {
        margin-right: 4px;
        vertical-align: -2px;
    }

    .biblio-count {
        font-size: 11.5px;
        color: var(--ink-soft);
    }

    .biblio-consultation {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--clay);
    }

    .biblio-consultation-label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
    }

    .biblio-code {
        display: block;
        font-family: "Fraunces", serif;
        font-size: 13px;
        color: var(--ink);
    }

    /* --- États vides --- */
    .biblio-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 60px 20px;
        color: var(--ink-soft);
        text-align: center;
        border: 1px dashed var(--line);
        border-radius: var(--radius);
    }

    .biblio-empty svg {
        color: var(--forest-mid);
    }

    .biblio-pagination {
        margin-top: 36px;
    }

    /* --- Pagination (.enef-pagination) --- */
    .enef-pagination {
        display: flex;
        justify-content: center;
    }

    .enef-pagination ul {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .enef-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        font-size: 14px;
        font-weight: 600;
        color: var(--ink);
        border: 1px solid var(--line);
        background: var(--white);
        border-radius: var(--radius);
        transition: border-color .15s ease, color .15s ease, background .15s ease;
    }

    a.page-link:hover {
        border-color: var(--forest-mid);
        color: var(--forest-mid);
    }

    .enef-pagination .page-item.active .page-link {
        background: var(--forest-deep);
        border-color: var(--forest-deep);
        color: #fff;
    }

    .enef-pagination .page-item.disabled .page-link {
        color: var(--line);
        border-color: var(--line);
        cursor: not-allowed;
    }

    .enef-pagination .page-link.dots {
        border: none;
        background: none;
        color: var(--ink-soft);
    }

    .enef-pagination .page-link svg {
        display: block;
    }

    @media (max-width: 640px) {
        .biblio-filters {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\bibliotheque\_styles.blade.php ENDPATH**/ ?>
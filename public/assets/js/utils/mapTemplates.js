/**
 * Map Template Helpers
 * HTML template generation functions for map components
 * 
 * @description Extracted from renderProvinceMap, renderDrillDownMap, and renderKabModal
 * to reduce function size and improve maintainability
 */

// ========================================
// SEARCH INPUT TEMPLATE
// ========================================

/**
 * Generate search input with suggestions dropdown
 * @param {Object} options - Configuration options
 * @returns {string} HTML string
 */
function createSearchInput(options) {
    const {
        id,
        placeholder,
        value = '',
        suggestions = [],
        onInput,
        onKeydown,
        theme
    } = options;

    const { bg, border, textColor, inputBg, hoverBg } = theme;

    const suggestionsHtml = suggestions.length > 0
        ? `<div style="position: absolute; top: 100%; left: 0; right: 0; margin-top: 4px; background: ${bg}; border: 1px solid ${border}; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 20; overflow: hidden;">
            ${suggestions.map(s => `
                <button onclick="${s.onClick}" 
                        style="width: 100%; text-align: left; padding: 8px 12px; font-size: 0.75rem; color: ${textColor}; border: none; background: transparent; cursor: pointer;"
                        onmouseover="this.style.background='${hoverBg}'" 
                        onmouseout="this.style.background='transparent'">${s.label}</button>
            `).join('')}
        </div>`
        : '';

    return `
        <div style="position: relative;">
            <input type="text" id="${id}" 
                   placeholder="${placeholder}" 
                   value="${value}"
                   style="padding: 6px 12px; border: 1px solid ${border}; border-radius: 8px; font-size: 0.75rem; width: 140px; background: ${inputBg}; color: ${textColor};"
                   oninput="${onInput}"
                   onkeydown="${onKeydown}">
            ${suggestionsHtml}
        </div>
    `;
}

// ========================================
// SELECT DROPDOWN TEMPLATE
// ========================================

/**
 * Generate select dropdown
 * @param {Object} options - Configuration options
 * @returns {string} HTML string
 */
function createSelect(options) {
    const { id, value, onChange, items, theme } = options;
    const { border, inputBg, textColor } = theme;

    const optionsHtml = items.map(item =>
        `<option value="${item.value}" ${value === item.value ? 'selected' : ''}>${item.label}</option>`
    ).join('');

    return `
        <select id="${id}" 
                style="padding: 6px 12px; border: 1px solid ${border}; border-radius: 8px; font-size: 0.75rem; background: ${inputBg}; color: ${textColor};" 
                onchange="${onChange}">
            ${optionsHtml}
        </select>
    `;
}

// ========================================
// STAT CARD TEMPLATE
// ========================================

/**
 * Generate stat card for map header
 * @param {Object} options - Configuration options
 * @returns {string} HTML string
 */
function createStatCard(options) {
    const { value, label, colorBg, colorBorder, colorText, theme } = options;
    const { isDark } = theme;

    const bgColor = isDark ? colorBg.replace('0.1', '0.1') : colorBg;
    const borderColor = isDark ? colorBorder.replace('0.3', '0.3') : colorBorder;

    return `
        <div style="background: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 8px; padding: 12px; text-align: center;">
            <div style="font-size: 1.5rem; font-weight: 700; color: ${colorText};">${value}</div>
            <div style="font-size: 0.625rem; color: ${colorText};">${label}</div>
        </div>
    `;
}

// ========================================
// LEGEND TEMPLATE
// ========================================

/**
 * Generate map legend
 * @param {Object} theme - Theme colors
 * @returns {string} HTML string
 */
function createMapLegend(theme, colorMode) {
    const { border, mutedColor } = theme;

    const statusItems = [
        { color: '#22c55e', label: 'Terbentuk' },
        { color: '#eab308', label: 'Perpanjangan' },
        { color: '#3b82f6', label: 'Dalam Proses' },
        { color: '#9ca3af', label: 'Belum' }
    ];

    const percentageItems = [
        { color: '#22c55e', label: '≥80%' },
        { color: '#84cc16', label: '60-79%' },
        { color: '#eab308', label: '40-59%' },
        { color: '#f97316', label: '20-39%' },
        { color: '#ef4444', label: '<20%' }
    ];

    const items = colorMode === 'percentage' ? percentageItems : statusItems;

    return `
        <div style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center; margin-top: 16px; padding-top: 16px; border-top: 1px solid ${border};">
            ${items.map(item => `
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 16px; height: 16px; border-radius: 4px; background: ${item.color};"></div>
                    <span style="font-size: 0.75rem; color: ${mutedColor};">${item.label}</span>
                </div>
            `).join('')}
        </div>
    `;
}

// ========================================
// BREADCRUMB TEMPLATE
// ========================================

/**
 * Generate breadcrumb navigation
 * @param {Object} options - Configuration options
 * @returns {string} HTML string
 */
function createBreadcrumb(options) {
    const { items, theme } = options;
    const { textColor, mutedColor } = theme;

    return `
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; font-size: 0.875rem;">
            ${items.map((item, i) => {
        if (item.onClick) {
            return `<button onclick="${item.onClick}" style="color: #3b82f6; background: none; border: none; cursor: pointer; font-size: 0.875rem;">${item.label}</button>`;
        }
        if (i < items.length - 1) {
            return `<span style="color: ${textColor}; font-weight: 500;">${item.label}</span><span style="color: ${mutedColor};">>></span>`;
        }
        return `<span style="color: ${textColor}; font-weight: 500;">${item.label}</span>`;
    }).join('')}
        </div>
    `;
}

// ========================================
// MODAL TEMPLATE
// ========================================

/**
 * Generate modal wrapper
 * @param {Object} options - Configuration options
 * @returns {string} HTML string
 */
function createModal(options) {
    const { id, content, onClose, theme } = options;
    const { bg } = theme;

    return `
        <div id="${id}-backdrop" 
             style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 50; animation: fadeIn 0.2s ease-out;" 
             onclick="${onClose}">
            <div style="background: ${bg}; border-radius: 16px; max-width: 480px; width: 95%; max-height: 85vh; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.25); animation: scaleIn 0.2s ease-out;" 
                 onclick="event.stopPropagation()">
                ${content}
            </div>
        </div>
    `;
}

// ========================================
// ANGGOTA LIST ITEM TEMPLATE
// ========================================

/**
 * Generate anggota list item
 * @param {Object} anggota - Anggota data
 * @param {Object} theme - Theme colors
 * @returns {string} HTML string
 */
function createAnggotaItem(anggota, theme) {
    const { cardBg, textColor, mutedColor, hoverBg, isDark } = theme;

    return `
        <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: ${cardBg}; border-radius: 8px; transition: background 0.2s;" 
             onmouseover="this.style.background='${hoverBg}';" 
             onmouseout="this.style.background='${cardBg}';">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: ${isDark ? 'rgba(59,130,246,0.2)' : '#dbeafe'}; display: flex; align-items: center; justify-content: center; color: #2563eb; font-weight: 500; font-size: 0.875rem; flex-shrink: 0;">
                ${anggota.nama.charAt(0)}
            </div>
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 0.875rem; font-weight: 500; color: ${textColor}; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${anggota.nama}</p>
                <p style="font-size: 0.75rem; color: ${mutedColor}; margin: 2px 0 0 0;">${anggota.statusKeanggotaan || anggota.jabatan || '-'} • ${anggota.asalInstansi || anggota.instansi || '-'}</p>
            </div>
        </div>
    `;
}

// ========================================
// EXPORTS
// ========================================

if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        createSearchInput,
        createSelect,
        createStatCard,
        createMapLegend,
        createBreadcrumb,
        createModal,
        createAnggotaItem
    };
}

if (typeof window !== 'undefined') {
    window.BSAN_Templates = {
        createSearchInput,
        createSelect,
        createStatCard,
        createMapLegend,
        createBreadcrumb,
        createModal,
        createAnggotaItem
    };
}

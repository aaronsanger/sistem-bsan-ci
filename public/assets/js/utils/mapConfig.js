/**
 * Map Configuration Constants
 * Extracted from magic numbers in map-visualization.js
 * 
 * @description Provides consistent configuration values for the map component
 */

// ========================================
// STROKE & SIZING CONSTANTS
// ========================================

const MAP_CONFIG = {
    // Province map stroke widths
    PROVINCE_STROKE: {
        normal: 0.1,
        highlighted: 0.3
    },

    // Kabupaten/Kota map stroke widths
    KAB_STROKE: {
        normal: 0.02,
        highlighted: 0.06
    },

    // View box padding
    VIEW_BOX_PADDING: {
        province: 1,
        kabupaten: 0.3
    },

    // Timing constants (milliseconds)
    TIMING: {
        searchDebounce: 50,
        initDelay: 100,
        animationDuration: 200
    },

    // Search configuration
    SEARCH: {
        maxSuggestions: 5
    },

    // Mini-map configuration
    MINI_MAP: {
        viewBox: '94 -7 48 20',
        width: 120,
        height: 40
    }
};

// ========================================
// STATUS COLORS (for map fills)
// Uses centralized statusConfig.js when available
// ========================================

const STATUS_COLORS = typeof STATUS_COLORS_MAP !== 'undefined'
    ? { ...STATUS_COLORS_MAP, default: '#d1d5db' }
    : {
        disetujui: '#10b981',
        approved: '#10b981',
        pending: '#f59e0b',
        draft: '#3b82f6',
        ditolak: '#ef4444',
        declined: '#ef4444',
        belumAda: '#9ca3af',
        default: '#d1d5db'
    };

// ========================================
// PERCENTAGE COLOR THRESHOLDS
// ========================================

const PERCENTAGE_THRESHOLDS = [
    { min: 80, color: '#22c55e' },  // Green - Excellent
    { min: 60, color: '#84cc16' },  // Lime - Good
    { min: 40, color: '#eab308' },  // Amber - Warning
    { min: 20, color: '#f97316' },  // Orange - Poor
    { min: 0, color: '#ef4444' }    // Red - Critical
];

// ========================================
// HELPER FUNCTIONS
// ========================================

/**
 * Get color based on Pokja status string.
 * Delegates to centralized getStatusColorFromConfig() when available.
 */
function getStatusColor(status) {
    // Use centralized config if available
    if (typeof getStatusColorFromConfig === 'function') {
        return getStatusColorFromConfig(status);
    }

    // Fallback to local logic
    if (!status) return STATUS_COLORS.default;
    const statusLower = status.toLowerCase();

    if (statusLower === 'disetujui' || statusLower === 'approved' || statusLower === 'terbentuk' || statusLower === 'aktif') {
        return STATUS_COLORS.disetujui || '#10b981';
    }
    if (statusLower === 'pending' || statusLower === 'dalam proses' || statusLower === 'menunggu persetujuan' || statusLower === 'perlu perpanjangan') {
        return STATUS_COLORS.pending || '#f59e0b';
    }
    if (statusLower === 'draft') {
        return STATUS_COLORS.draft || '#3b82f6';
    }
    if (statusLower === 'ditolak' || statusLower === 'declined' || statusLower === 'tidak aktif') {
        return STATUS_COLORS.ditolak || '#ef4444';
    }
    if (statusLower === 'belum ada' || statusLower === 'belum terbentuk' || statusLower === 'belum') {
        return STATUS_COLORS.belumAda || '#9ca3af';
    }

    return STATUS_COLORS.default;
}

/**
 * Get color based on percentage value
 * @param {number} percentage - Percentage value (0-100)
 * @returns {string} Hex color code
 */
function getPercentageColor(percentage) {
    for (const threshold of PERCENTAGE_THRESHOLDS) {
        if (percentage >= threshold.min) {
            return threshold.color;
        }
    }
    return PERCENTAGE_THRESHOLDS[PERCENTAGE_THRESHOLDS.length - 1].color;
}

/**
 * Get contrasting text color for a background
 * @param {string} backgroundColor - Hex background color
 * @returns {string} 'white' or 'black'
 */
function getContrastingTextColor(backgroundColor) {
    const hex = backgroundColor.replace('#', '');
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);

    const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
    return luminance > 0.5 ? 'black' : 'white';
}

/**
 * Get legend items for map
 * @returns {Array} Legend items with label and color
 */
function getMapLegendItems() {
    // Use centralized config if available
    if (typeof getStatusLegendItems === 'function') {
        return getStatusLegendItems();
    }
    return [
        { label: 'Disetujui', color: STATUS_COLORS.disetujui || '#10b981' },
        { label: 'Pending', color: STATUS_COLORS.pending || '#f59e0b' },
        { label: 'Draft', color: STATUS_COLORS.draft || '#3b82f6' },
        { label: 'Ditolak', color: STATUS_COLORS.ditolak || '#ef4444' },
        { label: 'Belum Ada', color: STATUS_COLORS.belumAda || '#9ca3af' }
    ];
}

// ========================================
// EXPORTS
// ========================================

if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        MAP_CONFIG,
        STATUS_COLORS,
        PERCENTAGE_THRESHOLDS,
        getStatusColor,
        getPercentageColor,
        getContrastingTextColor,
        getMapLegendItems
    };
}

if (typeof window !== 'undefined') {
    window.BSAN_MapConfig = {
        MAP_CONFIG,
        STATUS_COLORS,
        PERCENTAGE_THRESHOLDS,
        getStatusColor,
        getPercentageColor,
        getContrastingTextColor,
        getMapLegendItems
    };
}

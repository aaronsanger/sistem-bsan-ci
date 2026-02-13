/**
 * Theme Color Utilities
 * Provides consistent dark/light mode colors across all components
 * 
 * @description Extracted from repeated theme logic in map-visualization.js
 * to follow DRY principle and ensure consistent theming
 */

// ========================================
// THEME DETECTION
// ========================================

/**
 * Check if dark mode is currently active
 * @returns {boolean} True if dark mode is active
 */
function isDarkMode() {
    return document.documentElement.getAttribute('data-theme') === 'dark';
}

// ========================================
// COLOR CONSTANTS
// ========================================

const THEME_COLORS = {
    // Light mode colors
    light: {
        bg: 'white',
        cardBg: '#f9fafb',
        inputBg: 'white',
        border: '#e5e7eb',
        textColor: '#374151',
        mutedColor: '#6b7280',
        hoverBg: '#eff6ff',
        svgBg: 'linear-gradient(to bottom right, #f0f9ff, #e0f2fe)',

        // Status backgrounds
        status: {
            terbentuk: { bg: '#f0fdf4', border: '#bbf7d0', text: '#16a34a' },
            dalamProses: { bg: '#eff6ff', border: '#bfdbfe', text: '#2563eb' },
            belum: { bg: '#f9fafb', border: '#e5e7eb', text: '#6b7280' },
            perpanjangan: { bg: '#fefce8', border: '#fef08a', text: '#ca8a04' }
        }
    },

    // Dark mode colors
    dark: {
        bg: '#0F0A0A',
        cardBg: '#0F0A0A',
        inputBg: '#0F0A0A',
        border: '#3f4739',
        textColor: 'white',
        mutedColor: '#9ca3af',
        hoverBg: '#3f4739',
        svgBg: 'linear-gradient(to bottom right, #0F0A0A, #0F0A0A)',

        // Status backgrounds
        status: {
            terbentuk: { bg: 'rgba(34,197,94,0.1)', border: 'rgba(34,197,94,0.3)', text: '#22c55e' },
            dalamProses: { bg: 'rgba(59,130,246,0.1)', border: 'rgba(59,130,246,0.3)', text: '#3b82f6' },
            belum: { bg: 'rgba(156,163,175,0.1)', border: 'rgba(156,163,175,0.3)', text: '#9ca3af' },
            perpanjangan: { bg: 'rgba(234,179,8,0.1)', border: 'rgba(234,179,8,0.3)', text: '#eab308' }
        }
    }
};

// ========================================
// THEME GETTER FUNCTION
// ========================================

/**
 * Get all theme colors for current mode
 * @returns {Object} Theme color object with all needed colors
 */
function getThemeColors() {
    const isDark = isDarkMode();
    const colors = isDark ? THEME_COLORS.dark : THEME_COLORS.light;

    return {
        isDark,
        ...colors
    };
}

/**
 * Get status-specific styling for badges/cards
 * @param {string} status - Status string (Terbentuk, Dalam Proses, Belum Terbentuk, Perlu Perpanjangan)
 * @returns {Object} Style object with bg, border, text colors
 */
function getStatusStyle(status) {
    const { isDark, status: statusColors } = getThemeColors();

    switch (status) {
        case 'Terbentuk':
        case 'Aktif':
            return { ...statusColors.terbentuk, icon: '✓' };
        case 'Dalam Proses':
        case 'Menunggu Persetujuan':
            return { ...statusColors.dalamProses, icon: '⏳' };
        case 'Perlu Perpanjangan':
            return { ...statusColors.perpanjangan, icon: '⚠' };
        case 'Belum Terbentuk':
        default:
            return { ...statusColors.belum, icon: '✗' };
    }
}

// ========================================
// EXPORTS
// ========================================

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        THEME_COLORS,
        isDarkMode,
        getThemeColors,
        getStatusStyle
    };
}

// Export to window for browser usage
if (typeof window !== 'undefined') {
    window.BSAN_Theme = {
        THEME_COLORS,
        isDarkMode,
        getThemeColors,
        getStatusStyle
    };
}

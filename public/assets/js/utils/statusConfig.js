/**
 * statusConfig.js — Single Source of Truth for Pokja Status Definitions
 * 
 * All status names, colors, icons, and mappings are defined here.
 * Other files should import/reference this instead of defining their own.
 * 
 * Usage:
 *   - Include via <script src="/assets/js/utils/statusConfig.js"></script>
 *   - Access: POKJA_STATUS, STATUS_COLORS_MAP, mapRawStatus(), etc.
 */

// ============================================================
// CANONICAL STATUS DEFINITIONS
// ============================================================
const POKJA_STATUS = {
    DISETUJUI: {
        key: 'Disetujui',
        color: '#10b981',
        colorDark: '#34d399',
        icon: '✓',
        order: 1,
        rawKeys: ['approved', 'disetujui'],
        badgeClass: 'bg-green-100 text-green-800',
    },
    PENDING: {
        key: 'Pending',
        color: '#f59e0b',
        colorDark: '#fbbf24',
        icon: '⏳',
        order: 2,
        rawKeys: ['pending'],
        badgeClass: 'bg-yellow-100 text-yellow-800',
    },
    DRAFT: {
        key: 'Draft',
        color: '#3b82f6',
        colorDark: '#60a5fa',
        icon: '📝',
        order: 3,
        rawKeys: ['draft'],
        badgeClass: 'bg-blue-100 text-blue-800',
    },
    DITOLAK: {
        key: 'Ditolak',
        color: '#ef4444',
        colorDark: '#f87171',
        icon: '✗',
        order: 4,
        rawKeys: ['declined', 'ditolak', 'rejected'],
        badgeClass: 'bg-red-100 text-red-800',
    },
    BELUM_ADA: {
        key: 'Belum Ada',
        color: '#9ca3af',
        colorDark: '#6b7280',
        icon: '○',
        order: 5,
        rawKeys: ['belum_ada', 'none', ''],
        badgeClass: 'bg-gray-100 text-gray-800',
    },
};

// ============================================================
// CONVENIENCE LOOKUPS
// ============================================================

/** Color map: status key → color hex */
const STATUS_COLORS_MAP = {};
Object.values(POKJA_STATUS).forEach(s => {
    STATUS_COLORS_MAP[s.key] = s.color;
    STATUS_COLORS_MAP[s.key.toLowerCase()] = s.color;
});

/** Icon map: status key → icon */
const STATUS_ICONS_MAP = {};
Object.values(POKJA_STATUS).forEach(s => {
    STATUS_ICONS_MAP[s.key] = s.icon;
});

/** Ordered list of status keys */
const STATUS_KEYS_ORDERED = Object.values(POKJA_STATUS)
    .sort((a, b) => a.order - b.order)
    .map(s => s.key);

// ============================================================
// STATUS MAPPING FUNCTIONS
// ============================================================

/**
 * Map a raw/database status string to the canonical display name.
 * Examples: 'approved' → 'Disetujui', 'pending' → 'Pending', unknown → 'Belum Ada'
 */
function mapRawStatus(rawStatus) {
    if (!rawStatus) return POKJA_STATUS.BELUM_ADA.key;
    const lower = rawStatus.toLowerCase().trim();
    for (const status of Object.values(POKJA_STATUS)) {
        if (status.rawKeys.includes(lower) || status.key.toLowerCase() === lower) {
            return status.key;
        }
    }
    return POKJA_STATUS.BELUM_ADA.key;
}

/**
 * Get the color for a given status (accepts both raw and display names).
 */
function getStatusColorFromConfig(status) {
    const mapped = mapRawStatus(status);
    return STATUS_COLORS_MAP[mapped] || POKJA_STATUS.BELUM_ADA.color;
}

/**
 * Get filter options for map dropdowns.
 * Returns: [{ value: 'all', label: 'Semua' }, { value: 'Disetujui', label: '✓ Disetujui' }, ...]
 */
function getStatusFilterOptions() {
    const options = [{ value: 'all', label: 'Semua' }];
    Object.values(POKJA_STATUS)
        .sort((a, b) => a.order - b.order)
        .forEach(s => {
            options.push({ value: s.key, label: `${s.icon} ${s.key}` });
        });
    return options;
}

/**
 * Get legend items for map visualization.
 * Returns: [{ label: 'Disetujui', color: '#10b981' }, ...]
 */
function getStatusLegendItems() {
    return Object.values(POKJA_STATUS)
        .sort((a, b) => a.order - b.order)
        .map(s => ({ label: s.key, color: s.color }));
}

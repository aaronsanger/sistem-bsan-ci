/**
 * MAP VISUALIZATION - Refactored Indonesia SVG Map Component
 * 
 * @description Clean code refactoring of map-visualization.js
 * - Removed duplicate color functions (now in mapConfig.js)
 * - Removed duplicate theme logic (now in themeColors.js)
 * - Extracted templates to mapTemplates.js
 * - Added constants for magic numbers
 * - Split large functions into smaller helpers
 */

// ========================================
// DEPENDENCIES
// Load these scripts before this file:
// - js/utils/themeColors.js
// - js/utils/mapConfig.js
// - js/utils/mapTemplates.js
// ========================================

// ========================================
// GLOBAL STATE
// ========================================

let geoData = null;
let mapLoading = true;
let mapSelectedProvinsi = null;
let mapHoveredFeature = null;
let mapColorMode = 'status'; // 'status' or 'percentage'
let mapStatusFilter = 'all';
let mapSearchQuery = '';
let mapKabSearchQuery = '';
let mapHighlightedProvinsi = null;
let mapHighlightedKab = null;
let mapModalOpen = false;
let searchDebounceTimer = null;
let kabSearchDebounceTimer = null;

// ========================================
// GEOMETRY UTILITIES
// ========================================

/**
 * Convert coordinate array to SVG path
 */
function coordinatesToPath(coords) {
    if (!coords || coords.length === 0) return '';
    return coords
        .map((point, i) => {
            const x = point[0];
            const y = -point[1];
            return i === 0 ? `M ${x} ${y}` : `L ${x} ${y}`;
        })
        .join(' ') + ' Z';
}

/**
 * Convert GeoJSON geometry to SVG path
 */
function multiPolygonToPath(geometry) {
    if (geometry.type === 'Polygon') {
        return coordinatesToPath(geometry.coordinates[0]);
    } else if (geometry.type === 'MultiPolygon') {
        return geometry.coordinates.map(polygon => coordinatesToPath(polygon[0])).join(' ');
    }
    return '';
}

/**
 * Normalize province/kabupaten name for matching
 */
function normalizeName(name) {
    return name
        .toLowerCase()
        .replace(/^(kab\.|kabupaten|kota administrasi|kota adm\.|kota|prov\.?|provinsi)\s*/gi, '')
        .replace(/^kepulauan\s+/i, 'kep. ')
        .replace(/\s+/g, ' ')
        .trim();
}

// ========================================
// DATA MATCHING
// ========================================

/**
 * Find province data by feature name
 */
function getProvinceStatus(featureName) {
    if (!window.provinsiData) return null;
    const geoName = normalizeName(featureName);

    let match = provinsiData.find(p => normalizeName(p.nama) === geoName);

    if (!match) {
        const partialMatches = provinsiData.filter(p => {
            const appName = normalizeName(p.nama);
            return geoName.includes(appName) || appName.includes(geoName);
        });
        partialMatches.sort((a, b) => b.nama.length - a.nama.length);
        match = partialMatches[0];
    }

    return match;
}

/**
 * Find kabupaten/kota data
 */
function getKotaKabStatus(featureName, provinsiName) {
    const provData = getProvinceStatus(provinsiName);
    if (!provData?.kotaKab) return null;

    const geoName = normalizeName(featureName);

    let match = provData.kotaKab.find(k => normalizeName(k.nama) === geoName);

    if (!match) {
        match = provData.kotaKab.find(k => {
            const appName = normalizeName(k.nama);
            return geoName.includes(appName) || appName.includes(geoName);
        });
    }

    return match;
}

/**
 * Get fill color for a map feature
 */
function getFeatureFill(feature, isProvince = true) {
    const { getStatusColor, getPercentageColor } = window.BSAN_MapConfig;

    if (isProvince) {
        const provName = feature.properties.Provinsi;
        const data = getProvinceStatus(provName);

        if (!data) return '#d1d5db';

        // Apply status filter
        if (mapStatusFilter !== 'all') {
            const statusMatch = data.statusPokja === mapStatusFilter ||
                data.kotaKab?.some(k => k.statusPokja === mapStatusFilter);
            if (!statusMatch) return '#e5e7eb';
        }

        if (mapColorMode === 'percentage') {
            return getPercentageColor(data.persentase || 0);
        }
        return getStatusColor(data.statusPokja);
    } else {
        const kabName = feature.properties['Kabupaten/Kota'];
        const data = getKotaKabStatus(kabName, mapSelectedProvinsi);
        const status = data?.statusPokja || 'Belum Terbentuk';

        // Apply status filter at kabupaten level
        if (mapStatusFilter !== 'all') {
            if (status !== mapStatusFilter) return '#e5e7eb';
        }

        // Apply color mode at kabupaten level
        if (mapColorMode === 'percentage') {
            // Use the kab's own percentage: pokja formed = 100%, otherwise 0%
            const kabPct = (status === 'Terbentuk') ? 100 : (status === 'Dalam Proses') ? 50 : 0;
            return getPercentageColor(kabPct);
        }
        return getStatusColor(status);
    }
}

// ========================================
// VIEW BOX CALCULATION
// ========================================

/**
 * Calculate SVG viewBox for a set of features
 */
function calculateViewBox(features, padding = 1) {
    const { VIEW_BOX_PADDING } = window.BSAN_MapConfig.MAP_CONFIG;
    let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;

    const processCoords = (coords) => {
        coords.forEach(point => {
            const x = point[0];
            const y = -point[1];
            minX = Math.min(minX, x);
            minY = Math.min(minY, y);
            maxX = Math.max(maxX, x);
            maxY = Math.max(maxY, y);
        });
    };

    features.forEach(feature => {
        const geo = feature.geometry;
        if (geo.type === 'Polygon') {
            processCoords(geo.coordinates[0]);
        } else if (geo.type === 'MultiPolygon') {
            geo.coordinates.forEach(polygon => processCoords(polygon[0]));
        }
    });

    return `${minX - padding} ${minY - padding} ${maxX - minX + padding * 2} ${maxY - minY + padding * 2}`;
}

// ========================================
// MAP INITIALIZATION
// ========================================

async function initializeMap() {
    const mapContainer = document.getElementById('map-container');
    if (!mapContainer) return;

    const { TIMING } = window.BSAN_MapConfig.MAP_CONFIG;
    const theme = window.BSAN_Theme.getThemeColors();

    mapContainer.innerHTML = `
        <div style="display: flex; align-items: center; justify-content: center; height: 400px; background: ${theme.bg}; border: 1px solid ${theme.border}; border-radius: 12px;">
            <div style="text-align: center;">
                <div style="width: 48px; height: 48px; border: 4px solid ${theme.border}; border-top-color: #3b82f6; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                <p style="margin-top: 16px; color: ${theme.mutedColor};">Memuat peta...</p>
            </div>
        </div>
        <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
    `;

    try {
        // Try to use pre-loaded data first
        if (window.INDONESIA_ALL_LEVELS) {
            geoData = window.INDONESIA_ALL_LEVELS;
        } else if (window.indonesiaAllLevelsData) {
            geoData = window.indonesiaAllLevelsData;
        } else {
            const response = await fetch('./indonesia_3level_v4.json');
            if (!response.ok) throw new Error('Failed to fetch');
            geoData = await response.json();
        }

        mapLoading = false;
        renderMap();
    } catch (error) {
        console.error('Map initialization error:', error);
        mapContainer.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: center; height: 400px; background: ${theme.bg}; border: 1px solid ${theme.border}; border-radius: 12px;">
                <p style="color: #ef4444;">Gagal memuat peta. Silakan refresh halaman.</p>
            </div>
        `;
    }
}

// ========================================
// MAIN RENDER FUNCTION
// ========================================

function renderMap() {
    if (mapLoading || !geoData) return;

    if (mapSelectedProvinsi) {
        renderDrillDownMap();
    } else {
        renderProvinceMap();
    }
}

// ========================================
// PROVINCE MAP RENDERING
// ========================================

function renderProvinceMap() {
    const mapContainer = document.getElementById('map-container');
    if (!mapContainer || !geoData) return;

    const theme = window.BSAN_Theme.getThemeColors();
    const { PROVINCE_STROKE } = window.BSAN_MapConfig.MAP_CONFIG;

    const provinceFeatures = geoData.features.filter(f => f.properties.Level === 'Provinsi');
    const viewBox = calculateViewBox(provinceFeatures);

    // Generate SVG paths
    const paths = provinceFeatures.map((feature) => {
        const provName = feature.properties.Provinsi;
        const isHighlighted = mapHighlightedProvinsi === provName;

        return `
            <path
                data-province="${provName}"
                d="${multiPolygonToPath(feature.geometry)}"
                fill="${getFeatureFill(feature, true)}"
                stroke="${isHighlighted ? '#f59e0b' : '#ffffff'}"
                stroke-width="${isHighlighted ? PROVINCE_STROKE.highlighted : PROVINCE_STROKE.normal}"
                style="cursor: pointer; transition: all 0.2s;"
                onmouseover="handleMapHover(this, event, '${provName}', true)"
                onmouseout="handleMapHoverEnd()"
                onmousemove="handleMapMove(event)"
                onclick="handleProvinceClick('${provName}')"
            />
        `;
    }).join('');

    // Build filter options
    const filterOptions = [
        { value: 'all', label: 'Semua Status' },
        { value: 'Terbentuk', label: '✓ Terbentuk' },
        { value: 'Dalam Proses', label: '⏳ Dalam Proses' },
        { value: 'Belum Terbentuk', label: '✗ Belum' }
    ];

    const colorOptions = [
        { value: 'status', label: '🎨 Warna Status' },
        { value: 'percentage', label: '📊 Warna Persentase' }
    ];

    mapContainer.innerHTML = `
        <div style="background: ${theme.bg}; border: 1px solid ${theme.border}; border-radius: 12px; padding: 16px;">
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: ${theme.textColor};">Peta Indonesia</h3>
                    <p style="font-size: 0.75rem; color: ${theme.mutedColor};">Klik provinsi untuk melihat kabupaten/kota</p>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; position: relative;">
                    <div style="position: relative;">
                        <input type="text" id="map-search" placeholder="Cari provinsi / kab / kota..." 
                               value="${mapSearchQuery}"
                               style="padding: 6px 12px; border: 1px solid ${theme.border}; border-radius: 8px; font-size: 0.75rem; width: 180px; background: ${theme.inputBg}; color: ${theme.textColor};"
                               oninput="handleMapSearch(this.value)"
                               onkeydown="handleSearchKeydown(event)">
                    </div>
                    <select id="map-filter" style="padding: 6px 12px; border: 1px solid ${theme.border}; border-radius: 8px; font-size: 0.75rem; background: ${theme.inputBg}; color: ${theme.textColor};" onchange="handleMapFilter(this.value)">
                        ${filterOptions.map(opt => `<option value="${opt.value}" ${mapStatusFilter === opt.value ? 'selected' : ''}>${opt.label}</option>`).join('')}
                    </select>
                    <select id="map-color" style="padding: 6px 12px; border: 1px solid ${theme.border}; border-radius: 8px; font-size: 0.75rem; background: ${theme.inputBg}; color: ${theme.textColor};" onchange="handleMapColorMode(this.value)">
                        ${colorOptions.map(opt => `<option value="${opt.value}" ${mapColorMode === opt.value ? 'selected' : ''}>${opt.label}</option>`).join('')}
                    </select>
                </div>
            </div>
            
            <!-- SVG Map -->
            <div style="position: relative;">
                <svg viewBox="${viewBox}" style="width: 100%; height: 400px; background: ${theme.svgBg}; border-radius: 8px;" preserveAspectRatio="xMidYMid meet">
                    ${paths}
                </svg>
                <div id="map-tooltip" style="position: absolute; pointer-events: none; background: #1f2937; color: white; padding: 8px 16px; border-radius: 8px; font-size: 0.875rem; box-shadow: 0 10px 15px rgba(0,0,0,0.1); display: none; z-index: 10; white-space: nowrap;"></div>
            </div>
            
            <!-- Legend -->
            ${window.BSAN_Templates.createMapLegend(theme, mapColorMode)}
        </div>
    `;
}

// ========================================
// DRILL-DOWN MAP RENDERING
// ========================================

function renderDrillDownMap() {
    const mapContainer = document.getElementById('map-container');
    if (!mapContainer || !geoData || !mapSelectedProvinsi) return;

    const theme = window.BSAN_Theme.getThemeColors();
    const { KAB_STROKE, VIEW_BOX_PADDING, MINI_MAP } = window.BSAN_MapConfig.MAP_CONFIG;

    // Build filter options (same as province level)
    const filterOptions = [
        { value: 'all', label: 'Semua Status' },
        { value: 'Terbentuk', label: '✓ Terbentuk' },
        { value: 'Dalam Proses', label: '⏳ Dalam Proses' },
        { value: 'Belum Terbentuk', label: '✗ Belum' }
    ];

    const colorOptions = [
        { value: 'status', label: '🎨 Warna Status' },
        { value: 'percentage', label: '📊 Warna Persentase' }
    ];

    // Get Kabupaten/Kota features
    const kabFeatures = geoData.features.filter(
        f => f.properties.Level === 'Kabupaten/Kota' && f.properties.Provinsi === mapSelectedProvinsi
    );

    if (kabFeatures.length === 0) {
        console.warn('No Kabupaten/Kota features found for', mapSelectedProvinsi);
        renderProvinceMap();
        return;
    }

    const viewBox = calculateViewBox(kabFeatures, VIEW_BOX_PADDING.kabupaten);

    // Calculate stats
    const provData = getProvinceStatus(mapSelectedProvinsi);
    const kotaKabList = provData?.kotaKab || [];
    const stats = {
        terbentuk: kotaKabList.filter(k => k.statusPokja === 'Terbentuk').length,
        dalamProses: kotaKabList.filter(k => k.statusPokja === 'Dalam Proses').length,
        belum: kotaKabList.filter(k => k.statusPokja === 'Belum Terbentuk').length,
        persentase: kotaKabList.length > 0
            ? (kotaKabList.filter(k => k.statusPokja === 'Terbentuk').length / kotaKabList.length * 100).toFixed(0)
            : 0
    };

    // Generate kabupaten paths
    const paths = kabFeatures.map((feature) => {
        const kabName = feature.properties['Kabupaten/Kota'];
        const isHighlighted = mapHighlightedKab === kabName;
        return `
            <path
                data-kabupaten="${kabName}"
                d="${multiPolygonToPath(feature.geometry)}"
                fill="${getFeatureFill(feature, false)}"
                stroke="${isHighlighted ? '#f97316' : '#ffffff'}"
                stroke-width="${isHighlighted ? KAB_STROKE.highlighted : KAB_STROKE.normal}"
                style="cursor: pointer; transition: all 0.2s; ${isHighlighted ? 'filter: brightness(1.2);' : ''}"
                onmouseover="handleMapHover(this, event, '${kabName}', false)"
                onmouseout="handleMapHoverEnd()"
                onmousemove="handleMapMove(event)"
                onclick="handleKabClick('${kabName}', '${mapSelectedProvinsi}')"
            />
        `;
    }).join('');

    // Generate mini-map
    const provinceFeatures = geoData.features.filter(f => f.properties.Level === 'Provinsi');
    const miniMapPaths = provinceFeatures.map(f => `
        <path d="${multiPolygonToPath(f.geometry)}" 
              fill="${f.properties.Provinsi === mapSelectedProvinsi ? '#3b82f6' : '#d1d5db'}" 
              stroke="#fff" stroke-width="0.05"
              style="cursor: pointer;"
              onclick="handleProvinceClick('${f.properties.Provinsi}')"
        />
    `).join('');

    mapContainer.innerHTML = `
        <div style="background: ${theme.bg}; border: 1px solid ${theme.border}; border-radius: 12px; padding: 16px;">
            <!-- Breadcrumb -->
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; font-size: 0.875rem;">
                <button onclick="handleBackToIndonesia()" style="color: #3b82f6; background: none; border: none; cursor: pointer; font-size: 0.875rem;">Indonesia</button>
                <span style="color: ${theme.mutedColor};">>></span>
                <span style="color: ${theme.textColor}; font-weight: 500;">${mapSelectedProvinsi}</span>
                <span style="color: ${theme.mutedColor};">(${kabFeatures.length} Kab/Kota)</span>
            </div>
            
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: ${theme.textColor};">Prov. ${mapSelectedProvinsi}</h3>
                    <p style="font-size: 0.75rem; color: ${theme.mutedColor};">Klik kabupaten/kota untuk detail</p>
                </div>
                <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                    <div style="position: relative;">
                        <input type="text" id="kab-search" placeholder="Cari Kab/Kota..." 
                               value="${mapKabSearchQuery}"
                               style="padding: 6px 12px; border: 1px solid ${theme.border}; border-radius: 8px; font-size: 0.75rem; width: 140px; background: ${theme.inputBg}; color: ${theme.textColor};"
                               oninput="handleKabSearch(this.value)"
                               onkeydown="handleKabSearchKeydown(event)">
                    </div>
                    <select id="map-filter" style="padding: 6px 12px; border: 1px solid ${theme.border}; border-radius: 8px; font-size: 0.75rem; background: ${theme.inputBg}; color: ${theme.textColor};" onchange="handleMapFilter(this.value)">
                        ${filterOptions.map(opt => `<option value="${opt.value}" ${mapStatusFilter === opt.value ? 'selected' : ''}>${opt.label}</option>`).join('')}
                    </select>
                    <select id="map-color" style="padding: 6px 12px; border: 1px solid ${theme.border}; border-radius: 8px; font-size: 0.75rem; background: ${theme.inputBg}; color: ${theme.textColor};" onchange="handleMapColorMode(this.value)">
                        ${colorOptions.map(opt => `<option value="${opt.value}" ${mapColorMode === opt.value ? 'selected' : ''}>${opt.label}</option>`).join('')}
                    </select>
                    <button onclick="handleBackToIndonesia()" 
                            style="padding: 8px 16px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 4px;"
                            onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                        ← Kembali
                    </button>
                </div>
            </div>
            
            <!-- Stats -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 16px;">
                ${window.BSAN_Templates.createStatCard({ value: stats.terbentuk, label: 'Terbentuk', colorBg: theme.status.terbentuk.bg, colorBorder: theme.status.terbentuk.border, colorText: '#22c55e', theme })}
                ${window.BSAN_Templates.createStatCard({ value: stats.dalamProses, label: 'Dalam Proses', colorBg: theme.status.dalamProses.bg, colorBorder: theme.status.dalamProses.border, colorText: '#3b82f6', theme })}
                ${window.BSAN_Templates.createStatCard({ value: stats.belum, label: 'Belum', colorBg: theme.status.belum.bg, colorBorder: theme.status.belum.border, colorText: theme.mutedColor, theme })}
                ${window.BSAN_Templates.createStatCard({ value: stats.persentase + '%', label: 'Persentase', colorBg: theme.status.dalamProses.bg, colorBorder: theme.status.dalamProses.border, colorText: '#3b82f6', theme })}
            </div>
            
            <!-- SVG Map with Mini-Map -->
            <div style="position: relative;">
                <svg viewBox="${viewBox}" style="width: 100%; height: 400px; background: ${theme.svgBg}; border-radius: 8px;" preserveAspectRatio="xMidYMid meet">
                    ${paths}
                </svg>
                
                <!-- Mini-Map Overlay -->
                <div style="position: absolute; top: 8px; right: 8px; background: ${theme.bg}cc; backdrop-filter: blur(4px); border-radius: 8px; border: 1px solid ${theme.border}; padding: 8px; width: ${MINI_MAP.width}px; display: none;" id="mini-map" class="mini-map-desktop">
                    <p style="font-size: 0.5rem; color: ${theme.mutedColor}; text-align: center; margin-bottom: 4px;">Indonesia</p>
                    <svg viewBox="${MINI_MAP.viewBox}" style="width: 100%; height: ${MINI_MAP.height}px; background: ${theme.cardBg}; border-radius: 4px;" preserveAspectRatio="xMidYMid meet">
                        ${miniMapPaths}
                    </svg>
                    <button onclick="handleBackToIndonesia()" style="width: 100%; margin-top: 4px; font-size: 0.5rem; color: #3b82f6; background: none; border: none; cursor: pointer;">Lihat Semua</button>
                </div>
                
                <div id="map-tooltip" style="position: absolute; pointer-events: none; background: #1f2937; color: white; padding: 8px 16px; border-radius: 8px; font-size: 0.875rem; box-shadow: 0 10px 15px rgba(0,0,0,0.1); display: none; z-index: 10; white-space: nowrap;"></div>
            </div>
            
            <!-- Legend -->
            ${window.BSAN_Templates.createMapLegend(theme, mapColorMode)}
        </div>
        
        <!-- Modal Container -->
        <div id="kab-modal"></div>
        
        <style>
            @media (min-width: 768px) {
                .mini-map-desktop { display: block !important; }
            }
        </style>
    `;
}

// ========================================
// KABUPATEN MODAL
// ========================================

function renderKabModal(kabName, provName) {
    const kabData = getKotaKabStatus(kabName, provName);
    const modalContainer = document.getElementById('kab-modal');
    if (!modalContainer) return;

    const theme = window.BSAN_Theme.getThemeColors();
    const statusStyle = window.BSAN_Theme.getStatusStyle(kabData?.statusPokja || 'Belum Terbentuk');

    // SK Info
    const skInfo = kabData ? {
        nomorSK: kabData.nomorSK || '-',
        tanggalSK: kabData.tanggalSK || '-',
        tanggalBerakhir: kabData.tanggalBerakhirSK || '-',
        statusSK: kabData.statusSK || '-'
    } : { nomorSK: '-', tanggalSK: '-', tanggalBerakhir: '-', statusSK: '-' };

    // Anggota list
    const anggotaCount = kabData?.anggota?.length || 0;
    const anggotaHtml = anggotaCount > 0
        ? kabData.anggota.map(a => window.BSAN_Templates.createAnggotaItem(a, theme)).join('')
        : `<div style="text-align: center; padding: 32px; color: ${theme.mutedColor};"><p style="font-size: 0.875rem; margin: 0;">Belum ada data anggota</p></div>`;

    modalContainer.innerHTML = `
        <div id="kab-modal-backdrop" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 50; animation: fadeIn 0.2s ease-out;" onclick="closeKabModal(event)">
            <div style="background: ${theme.bg}; border-radius: 16px; max-width: 480px; width: 95%; max-height: 85vh; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.25); animation: scaleIn 0.2s ease-out;" onclick="event.stopPropagation()">
                <!-- Header -->
                <div style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; padding: 16px 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <p style="font-size: 0.75rem; color: rgba(191,219,254,1); margin: 0 0 2px 0;">Pokja</p>
                            <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0;">${kabName}</h2>
                            <p style="font-size: 0.875rem; color: rgba(191,219,254,0.8); margin: 4px 0 0 0;">Prov. ${provName}</p>
                        </div>
                        <button onclick="closeKabModal()" style="background: rgba(255,255,255,0.1); border: none; color: rgba(255,255,255,0.8); font-size: 1.5rem; cursor: pointer; padding: 4px 8px; border-radius: 8px; line-height: 1;">&times;</button>
                    </div>
                    <div style="margin-top: 12px;">
                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background: ${statusStyle.bg}; color: ${statusStyle.text};">
                            ${statusStyle.icon} ${kabData?.statusPokja || 'Belum Terbentuk'}
                        </span>
                    </div>
                </div>
                
                <!-- Tabs -->
                <div style="display: flex; border-bottom: 1px solid ${theme.border};">
                    <button id="tab-info" onclick="switchModalTab('info')" style="flex: 1; padding: 12px; font-size: 0.875rem; border: none; background: transparent; cursor: pointer; color: #3b82f6; border-bottom: 2px solid #3b82f6; font-weight: 500;">Informasi SK</button>
                    <button id="tab-anggota" onclick="switchModalTab('anggota')" style="flex: 1; padding: 12px; font-size: 0.875rem; border: none; background: transparent; cursor: pointer; color: ${theme.mutedColor}; border-bottom: 2px solid transparent;">Anggota (${anggotaCount})</button>
                </div>
                
                <!-- Content -->
                <div style="padding: 16px; max-height: 400px; overflow-y: auto;">
                    <div id="content-info">
                        <div style="display: grid; gap: 12px;">
                            <div style="background: ${theme.cardBg}; padding: 12px; border-radius: 8px;">
                                <p style="font-size: 0.625rem; color: ${theme.mutedColor}; margin: 0;">Nomor SK</p>
                                <p style="font-size: 0.875rem; color: ${theme.textColor}; margin: 4px 0 0 0; font-weight: 500;">${skInfo.nomorSK}</p>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                <div style="background: ${theme.cardBg}; padding: 12px; border-radius: 8px;">
                                    <p style="font-size: 0.625rem; color: ${theme.mutedColor}; margin: 0;">Tanggal SK</p>
                                    <p style="font-size: 0.875rem; color: ${theme.textColor}; margin: 4px 0 0 0;">${skInfo.tanggalSK}</p>
                                </div>
                                <div style="background: ${theme.cardBg}; padding: 12px; border-radius: 8px;">
                                    <p style="font-size: 0.625rem; color: ${theme.mutedColor}; margin: 0;">Berakhir</p>
                                    <p style="font-size: 0.875rem; color: ${theme.textColor}; margin: 4px 0 0 0;">${skInfo.tanggalBerakhir}</p>
                                </div>
                            </div>
                            <div style="background: ${theme.cardBg}; padding: 12px; border-radius: 8px;">
                                <p style="font-size: 0.625rem; color: ${theme.mutedColor}; margin: 0;">Status SK</p>
                                <span style="display: inline-block; margin-top: 4px; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; background: ${skInfo.statusSK === 'Valid' ? '#dcfce7' : theme.cardBg}; color: ${skInfo.statusSK === 'Valid' ? '#16a34a' : theme.mutedColor};">${skInfo.statusSK}</span>
                            </div>
                        </div>
                    </div>
                    <div id="content-anggota" style="display: none;">
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            ${anggotaHtml}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes scaleIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        </style>
    `;

    mapModalOpen = true;
}

function switchModalTab(tab) {
    const theme = window.BSAN_Theme.getThemeColors();
    const tabInfo = document.getElementById('tab-info');
    const tabAnggota = document.getElementById('tab-anggota');
    const contentInfo = document.getElementById('content-info');
    const contentAnggota = document.getElementById('content-anggota');

    if (tab === 'info') {
        tabInfo.style.color = '#3b82f6';
        tabInfo.style.borderBottom = '2px solid #3b82f6';
        tabAnggota.style.color = theme.mutedColor;
        tabAnggota.style.borderBottom = '2px solid transparent';
        contentInfo.style.display = 'block';
        contentAnggota.style.display = 'none';
    } else {
        tabAnggota.style.color = '#3b82f6';
        tabAnggota.style.borderBottom = '2px solid #3b82f6';
        tabInfo.style.color = theme.mutedColor;
        tabInfo.style.borderBottom = '2px solid transparent';
        contentInfo.style.display = 'none';
        contentAnggota.style.display = 'block';
    }
}

function closeKabModal(event) {
    if (event && event.target.id !== 'kab-modal-backdrop') return;
    const modalContainer = document.getElementById('kab-modal');
    if (modalContainer) modalContainer.innerHTML = '';
    mapModalOpen = false;
}

// ========================================
// EVENT HANDLERS
// ========================================

function handleMapHover(element, event, name, isProvince) {
    mapHoveredFeature = name;
    element.style.filter = 'brightness(0.85)';

    const tooltip = document.getElementById('map-tooltip');
    if (!tooltip) return;

    if (isProvince) {
        const data = getProvinceStatus(name);
        if (data) {
            const totalPokja = data.pokjaProvinsi + data.jumlahPokjaKotaKab;
            const totalWilayah = 1 + data.jumlahKotaKab;
            tooltip.innerHTML = `${name} <span style="opacity: 0.7">| ${totalPokja}/${totalWilayah} (${data.persentase.toFixed(0)}%)</span>`;
        } else {
            tooltip.innerHTML = name;
        }
    } else {
        const data = getKotaKabStatus(name, mapSelectedProvinsi);
        tooltip.innerHTML = `${name} <span style="opacity: 0.7">| ${data ? data.statusPokja : 'Data tidak ditemukan'}</span>`;
    }
    tooltip.style.display = 'block';
}

function handleMapHoverEnd() {
    mapHoveredFeature = null;
    document.querySelectorAll('#map-container path').forEach(p => p.style.filter = '');
    const tooltip = document.getElementById('map-tooltip');
    if (tooltip) tooltip.style.display = 'none';
}

function handleMapMove(event) {
    const tooltip = document.getElementById('map-tooltip');
    if (tooltip && tooltip.style.display !== 'none') {
        const parent = tooltip.parentElement;
        if (!parent) return;
        const rect = parent.getBoundingClientRect();
        tooltip.style.left = (event.clientX - rect.left + 10) + 'px';
        tooltip.style.top = (event.clientY - rect.top - 30) + 'px';
    }
}

function handleProvinceClick(provName) {
    mapSelectedProvinsi = provName;
    mapSearchQuery = '';
    mapHighlightedProvinsi = null;
    renderMap();
}

function handleKabClick(kabName, provName) {
    renderKabModal(kabName, provName);
}

function handleBackToIndonesia() {
    mapSelectedProvinsi = null;
    mapKabSearchQuery = '';
    mapHighlightedKab = null;
    renderMap();
}

// Kabupaten search handlers
function handleKabSearch(value) {
    mapKabSearchQuery = value;
    updateKabSuggestionsDropdown(value);
}

function handleKabSearchKeydown(event) {
    if (event.key === 'Enter' && mapKabSearchQuery) {
        const kabFeatures = geoData.features.filter(
            f => f.properties.Level === 'Kabupaten/Kota' && f.properties.Provinsi === mapSelectedProvinsi
        );
        const match = kabFeatures.find(f =>
            f.properties['Kabupaten/Kota'].toLowerCase().includes(mapKabSearchQuery.toLowerCase())
        );
        if (match) {
            highlightKabupaten(match.properties['Kabupaten/Kota']);
            mapKabSearchQuery = '';
            document.getElementById('kab-search').value = '';
        }
    } else if (event.key === 'Escape') {
        mapKabSearchQuery = '';
        document.getElementById('kab-search').value = '';
        renderMap();
    }
}

function highlightKabupaten(kabName) {
    mapHighlightedKab = kabName;
    renderMap();
}

/**
 * Navigate to a specific kabupaten: drill into parent province and spotlight the kab
 */
function navigateToKabupaten(kabName, provName) {
    mapSelectedProvinsi = provName;
    mapHighlightedKab = kabName;
    mapSearchQuery = '';
    mapHighlightedProvinsi = null;
    const searchInput = document.getElementById('map-search');
    if (searchInput) searchInput.value = '';
    renderMap();
}

function handleMapSearch(query) {
    mapSearchQuery = query;
    updateSuggestionsDropdown(query);

    const { TIMING } = window.BSAN_MapConfig.MAP_CONFIG;
    if (searchDebounceTimer) clearTimeout(searchDebounceTimer);

    searchDebounceTimer = setTimeout(() => {
        if (query) {
            const match = provinsiData.find(p => p.nama.toLowerCase().includes(query.toLowerCase()));
            mapHighlightedProvinsi = match ? match.nama : null;
        } else {
            mapHighlightedProvinsi = null;
        }

        if (!mapSelectedProvinsi) {
            updateProvinceHighlights();
        } else {
            renderMap();
        }
    }, TIMING.searchDebounce);
}

function updateSuggestionsDropdown(query) {
    const theme = window.BSAN_Theme.getThemeColors();

    if (!query) {
        const existing = document.querySelector('#map-search + div');
        if (existing) existing.remove();
        return;
    }

    const q = query.toLowerCase();

    // Province matches
    const provSuggestions = provinsiData
        .filter(p => p.nama.toLowerCase().includes(q))
        .slice(0, 3)
        .map(p => ({
            type: 'province',
            label: p.nama,
            sublabel: 'Provinsi',
            provName: p.nama
        }));

    // Kabupaten/Kota matches (search across ALL provinces)
    const kabSuggestions = [];
    for (const prov of provinsiData) {
        for (const kab of (prov.kotaKab || [])) {
            if (kab.nama.toLowerCase().includes(q)) {
                kabSuggestions.push({
                    type: 'kabupaten',
                    label: kab.nama,
                    sublabel: prov.nama,
                    provName: prov.nama,
                    kabName: kab.nama
                });
            }
            if (kabSuggestions.length >= 5) break;
        }
        if (kabSuggestions.length >= 5) break;
    }

    const allSuggestions = [...provSuggestions, ...kabSuggestions].slice(0, 7);

    if (allSuggestions.length === 0) {
        const existing = document.querySelector('#map-search + div');
        if (existing) existing.remove();
        return;
    }

    const html = allSuggestions.map(s => {
        if (s.type === 'province') {
            return `<button onclick="handleProvinceClick('${s.provName}'); mapSearchQuery=''; document.getElementById('map-search').value='';" 
                     style="width: 100%; text-align: left; padding: 8px 12px; font-size: 0.75rem; color: ${theme.textColor}; border: none; background: transparent; cursor: pointer; display: flex; justify-content: space-between; align-items: center;"
                     onmouseover="this.style.background='${theme.hoverBg}'" onmouseout="this.style.background='transparent'">
                     <span>${s.label}</span>
                     <span style="font-size: 0.625rem; color: ${theme.mutedColor}; margin-left: 8px;">Provinsi</span>
                  </button>`;
        } else {
            return `<button onclick="navigateToKabupaten('${s.kabName}', '${s.provName}')" 
                     style="width: 100%; text-align: left; padding: 8px 12px; font-size: 0.75rem; color: ${theme.textColor}; border: none; background: transparent; cursor: pointer; display: flex; justify-content: space-between; align-items: center;"
                     onmouseover="this.style.background='${theme.hoverBg}'" onmouseout="this.style.background='transparent'">
                     <span>${s.label}</span>
                     <span style="font-size: 0.625rem; color: ${theme.mutedColor}; margin-left: 8px;">${s.sublabel}</span>
                  </button>`;
        }
    }).join('');

    const dropdownHtml = `<div style="position: absolute; top: 100%; left: 0; right: 0; min-width: 220px; margin-top: 4px; background: ${theme.bg}; border: 1px solid ${theme.border}; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 20; overflow: hidden;">${html}</div>`;

    const searchInput = document.getElementById('map-search');
    if (searchInput) {
        const existing = searchInput.parentElement.querySelector('div[style*="position: absolute"]');
        if (existing) existing.remove();
        searchInput.insertAdjacentHTML('afterend', dropdownHtml);
    }
}

function updateKabSuggestionsDropdown(query) {
    const theme = window.BSAN_Theme.getThemeColors();

    if (!query) {
        const existing = document.querySelector('#kab-search + div');
        if (existing) existing.remove();
        return;
    }

    const kabFeatures = geoData.features.filter(
        f => f.properties.Level === 'Kabupaten/Kota' && f.properties.Provinsi === mapSelectedProvinsi
    );

    const suggestions = kabFeatures
        .filter(f => f.properties['Kabupaten/Kota'].toLowerCase().includes(query.toLowerCase()))
        .slice(0, 5);

    if (suggestions.length === 0) {
        const existing = document.querySelector('#kab-search + div');
        if (existing) existing.remove();
        return;
    }

    const html = suggestions.map(f => {
        const kab = f.properties['Kabupaten/Kota'];
        return `<button onclick="highlightKabupaten('${kab}'); mapKabSearchQuery=''; document.getElementById('kab-search').value='';" 
                 style="width: 100%; text-align: left; padding: 8px 12px; font-size: 0.75rem; color: ${theme.textColor}; border: none; background: transparent; cursor: pointer;"
                 onmouseover="this.style.background='${theme.hoverBg}'" onmouseout="this.style.background='transparent'">${kab}</button>`;
    }).join('');

    const dropdownHtml = `<div style="position: absolute; top: 100%; left: 0; right: 0; margin-top: 4px; background: ${theme.bg}; border: 1px solid ${theme.border}; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 20; overflow: hidden;">${html}</div>`;

    const searchInput = document.getElementById('kab-search');
    if (searchInput) {
        const existing = searchInput.parentElement.querySelector('div[style*="position: absolute"]');
        if (existing) existing.remove();
        searchInput.insertAdjacentHTML('afterend', dropdownHtml);
    }
}

function updateProvinceHighlights() {
    const { PROVINCE_STROKE } = window.BSAN_MapConfig.MAP_CONFIG;

    document.querySelectorAll('#map-container path[data-province]').forEach(path => {
        const provName = path.getAttribute('data-province');
        const feature = geoData?.features.find(f => f.properties.Provinsi === provName && f.properties.Level === 'Provinsi');
        if (feature) {
            const isHighlighted = mapHighlightedProvinsi === provName;
            path.setAttribute('fill', isHighlighted ? '#fbbf24' : getFeatureFill(feature, true));
            path.setAttribute('stroke', isHighlighted ? '#f59e0b' : '#ffffff');
            path.setAttribute('stroke-width', isHighlighted ? PROVINCE_STROKE.highlighted : PROVINCE_STROKE.normal);
        }
    });
}

function handleSearchKeydown(event) {
    if (event.key === 'Enter' && mapSearchQuery) {
        const q = mapSearchQuery.toLowerCase();
        // Check province match first
        const provMatch = provinsiData.find(p => p.nama.toLowerCase().includes(q));
        // Check kabupaten match
        let kabMatch = null;
        for (const prov of provinsiData) {
            const kab = (prov.kotaKab || []).find(k => k.nama.toLowerCase().includes(q));
            if (kab) {
                kabMatch = { kabName: kab.nama, provName: prov.nama };
                break;
            }
        }
        // Prefer kabupaten match if query doesn't match a province exactly
        if (kabMatch && (!provMatch || !provMatch.nama.toLowerCase().includes(q))) {
            navigateToKabupaten(kabMatch.kabName, kabMatch.provName);
        } else if (provMatch) {
            handleProvinceClick(provMatch.nama);
            mapSearchQuery = '';
            const input = document.getElementById('map-search');
            if (input) input.value = '';
        }
    } else if (event.key === 'Escape') {
        mapSearchQuery = '';
        mapHighlightedProvinsi = null;
        renderMap();
    }
}

function handleMapFilter(filter) {
    mapStatusFilter = filter;
    renderMap();
}

function handleMapColorMode(mode) {
    mapColorMode = mode;
    renderMap();
}

// ========================================
// INITIALIZATION
// ========================================

document.addEventListener('DOMContentLoaded', () => {
    const { TIMING } = window.BSAN_MapConfig?.MAP_CONFIG || { TIMING: { initDelay: 100 } };
    setTimeout(initializeMap, TIMING.initDelay);
});

// Re-render on theme change
const originalToggleTheme = window.BSAN?.toggleTheme;
if (originalToggleTheme) {
    window.BSAN.toggleTheme = function () {
        originalToggleTheme();
        renderMap();
    };
}

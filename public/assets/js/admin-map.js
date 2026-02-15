/**
 * ADMIN MAP COMPONENT
 * Standalone Indonesia SVG map for the Admin Dashboard
 * Features: search, filter, tooltip, drill-down, admin statuses
 */

// ========================================
// STATE
// ========================================
let _am = {
    geo: null,
    prov: null,        // selected province name
    filter: 'all',
    search: '',
    highlight: null,   // highlighted name
    timer: null,       // search debounce
};

// Status config — uses centralized statusConfig.js (loaded via layout)
// Fallback for safety if statusConfig.js hasn't loaded yet
const AM_STATUS = typeof POKJA_STATUS !== 'undefined'
    ? Object.fromEntries(Object.values(POKJA_STATUS).map(s => [s.key, { color: s.color, icon: s.icon, order: s.order }]))
    : {
        'Disetujui': { color: '#10b981', icon: '✓', order: 1 },
        'Pending': { color: '#f59e0b', icon: '⏳', order: 2 },
        'Draft': { color: '#3b82f6', icon: '📝', order: 3 },
        'Ditolak': { color: '#ef4444', icon: '✗', order: 4 },
        'Belum Ada': { color: '#9ca3af', icon: '○', order: 5 },
    };
const AM_DEFAULT_COLOR = '#d1d5db';

// ========================================
// GEOMETRY
// ========================================
function amCoordToPath(coords) {
    if (!coords || coords.length === 0) return '';
    return coords.map((p, i) => (i === 0 ? 'M' : 'L') + ' ' + p[0] + ' ' + (-p[1])).join(' ') + ' Z';
}

function amGeoToPath(geom) {
    if (geom.type === 'Polygon') return amCoordToPath(geom.coordinates[0]);
    if (geom.type === 'MultiPolygon') return geom.coordinates.map(p => amCoordToPath(p[0])).join(' ');
    return '';
}

function amViewBox(features, pad) {
    let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
    const pc = (coords) => { coords.forEach(p => { minX = Math.min(minX, p[0]); maxX = Math.max(maxX, p[0]); minY = Math.min(minY, -p[1]); maxY = Math.max(maxY, -p[1]); }); };
    features.forEach(f => { const g = f.geometry; if (g.type === 'Polygon') pc(g.coordinates[0]); else if (g.type === 'MultiPolygon') g.coordinates.forEach(p => pc(p[0])); });
    return (minX - pad) + ' ' + (minY - pad) + ' ' + (maxX - minX + pad * 2) + ' ' + (maxY - minY + pad * 2);
}

// ========================================
// DATA BRIDGE
// ========================================
function amGetStatusMap() {
    // Build province→status map from admin demo data
    const subs = (typeof getActiveSubmissions === 'function') ? getActiveSubmissions() : [];
    const statusLabels = { approved: 'Disetujui', pending: 'Pending', draft: 'Draft', declined: 'Ditolak' };
    const map = {};
    subs.forEach(s => {
        const name = (s.wilayah || '').replace('Prov. ', '');
        map[name] = statusLabels[s.status] || s.status || 'Belum Ada';
    });
    return map;
}

function amGetKabStatus(provName, kabName) {
    // Deterministic kab status based on province status
    const statusMap = amGetStatusMap();
    const provStatus = statusMap[provName] || 'Belum Ada';
    const hash = kabName.length + provName.length;
    if (provStatus === 'Disetujui') return hash % 5 === 0 ? 'Pending' : 'Disetujui';
    if (provStatus === 'Pending') return hash % 3 === 0 ? 'Belum Ada' : 'Pending';
    if (provStatus === 'Draft') return hash % 3 === 0 ? 'Draft' : 'Belum Ada';
    if (provStatus === 'Ditolak') return hash % 2 === 0 ? 'Ditolak' : 'Belum Ada';
    return 'Belum Ada';
}

function amGetColor(status) {
    return (AM_STATUS[status] || {}).color || AM_DEFAULT_COLOR;
}

// ========================================
// THEME
// ========================================
function amTheme() {
    const dark = document.documentElement.getAttribute('data-theme') === 'dark';
    return {
        dark,
        bg: dark ? '#1a1414' : '#ffffff',
        card: dark ? '#0F0A0A' : '#ffffff',
        border: dark ? '#3f4739' : '#e5e7eb',
        text: dark ? '#e5e7eb' : '#1f2937',
        muted: dark ? '#9ca3af' : '#6b7280',
        input: dark ? '#1a1414' : '#ffffff',
        svgBg: dark ? '#1a1414' : '#f0f4ff',
        hover: dark ? 'rgba(59,130,246,0.1)' : 'rgba(59,130,246,0.05)',
    };
}

// ========================================
// TOOLTIP
// ========================================
function amShowTip(evt, html) {
    const t = document.getElementById('am-tooltip');
    if (!t) return;
    t.innerHTML = html;
    t.style.display = 'block';
    const r = t.parentElement.getBoundingClientRect();
    let x = evt.clientX - r.left + 14;
    let y = evt.clientY - r.top - 10;
    // Keep tooltip within bounds
    if (x + 200 > r.width) x = evt.clientX - r.left - 200;
    if (y < 0) y = 10;
    t.style.left = x + 'px';
    t.style.top = y + 'px';
}
function amMoveTip(evt) {
    const t = document.getElementById('am-tooltip');
    if (!t || t.style.display === 'none') return;
    const r = t.parentElement.getBoundingClientRect();
    t.style.left = (evt.clientX - r.left + 14) + 'px';
    t.style.top = (evt.clientY - r.top - 10) + 'px';
}
function amHideTip() {
    const t = document.getElementById('am-tooltip');
    if (t) t.style.display = 'none';
}

// ========================================
// INIT
// ========================================
async function initAdminMap() {
    const c = document.getElementById('admin-map-container');
    if (!c) return;
    c.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:400px;"><div style="text-align:center;"><div style="width:40px;height:40px;border:3px solid #e5e7eb;border-top-color:#3b82f6;border-radius:50%;animation:amspin 1s linear infinite;margin:0 auto;"></div><p style="margin-top:12px;color:#9ca3af;font-size:0.875rem;">Memuat peta...</p></div></div><style>@keyframes amspin{to{transform:rotate(360deg)}}</style>';
    try {
        if (!_am.geo) {
            const res = await fetch('/indonesia_3level_v4.json');
            if (!res.ok) throw new Error('fetch failed');
            _am.geo = await res.json();
        }
        amRender();
    } catch (e) {
        c.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:400px;"><p style="color:#ef4444;">Gagal memuat peta. Silakan refresh.</p></div>';
    }
}

// ========================================
// MAIN RENDER
// ========================================
function amRender() {
    if (!_am.geo) return;
    if (_am.prov) amRenderKab();
    else amRenderProv();
}

// ========================================
// PROVINCE VIEW
// ========================================
function amRenderProv() {
    const c = document.getElementById('admin-map-container');
    if (!c) return;
    const th = amTheme();
    const statusMap = amGetStatusMap();
    const provFeatures = _am.geo.features.filter(f => f.properties.Level === 'Provinsi');
    const vb = amViewBox(provFeatures, 1);

    const paths = provFeatures.map(f => {
        const name = f.properties.Provinsi;
        const status = statusMap[name] || 'Belum Ada';
        let fill = amGetColor(status);
        let opacity = '1';
        let sw = '0.1';
        let sc = '#fff';

        // Filter
        if (_am.filter !== 'all' && status !== _am.filter) {
            fill = '#f3f4f6'; opacity = '0.4'; sw = '0.04'; sc = '#e5e7eb';
        }

        // Highlight
        if (_am.highlight === name) {
            sc = '#f59e0b'; sw = '0.3';
        }

        const safeName = name.replace(/'/g, "\\'");
        return `<path data-name="${name}" d="${amGeoToPath(f.geometry)}" fill="${fill}" stroke="${sc}" stroke-width="${sw}" style="cursor:pointer;transition:all 0.2s;opacity:${opacity};"
            onclick="amDrillDown('${safeName}')"
            onmouseover="this.style.filter='brightness(0.85)';amShowTip(event,'<b>${name}</b><br>${status}')"
            onmousemove="amMoveTip(event)"
            onmouseout="this.style.filter='';amHideTip()"/>`;
    }).join('');

    // Filter options
    const filterOpts = [
        { v: 'all', l: 'Semua' },
        { v: 'Disetujui', l: '✓ Disetujui' },
        { v: 'Pending', l: '⏳ Pending' },
        { v: 'Draft', l: '📝 Draft' },
        { v: 'Ditolak', l: '✗ Ditolak' },
        { v: 'Belum Ada', l: '○ Belum Ada' },
    ];

    c.innerHTML = `
    <div style="background:${th.bg};border:1px solid ${th.border};border-radius:12px;padding:16px;">
        <!-- Header -->
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:12px;">
            <div>
                <h3 style="font-size:1rem;font-weight:600;color:${th.text};margin:0;">Peta Indonesia</h3>
                <p style="font-size:0.75rem;color:${th.muted};margin:4px 0 0;">Klik provinsi untuk melihat kabupaten/kota</p>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" id="am-search" placeholder="Cari provinsi / kab / kota..." value="${_am.search}"
                        style="padding:6px 12px;border:1px solid ${th.border};border-radius:8px;font-size:0.75rem;width:200px;background:${th.input};color:${th.text};outline:none;"
                        oninput="amSearch(this.value)" onkeydown="amSearchKey(event)">
                    <div id="am-suggestions" style="position:absolute;top:100%;left:0;right:0;margin-top:4px;background:${th.bg};border:1px solid ${th.border};border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.12);z-index:30;overflow:hidden;display:none;max-height:240px;overflow-y:auto;"></div>
                </div>
                <select id="am-filter"
                    style="padding:6px 12px;border:1px solid ${th.border};border-radius:8px;font-size:0.75rem;background:${th.input};color:${th.text};"
                    onchange="amFilter(this.value)">
                    ${filterOpts.map(o => `<option value="${o.v}" ${_am.filter === o.v ? 'selected' : ''}>${o.l}</option>`).join('')}
                </select>
            </div>
        </div>
        <!-- Map -->
        <div style="position:relative;">
            <svg viewBox="${vb}" style="width:100%;height:400px;background:${th.svgBg};border-radius:8px;" preserveAspectRatio="xMidYMid meet">${paths}</svg>
            <div id="am-tooltip" style="position:absolute;pointer-events:none;background:#1f2937;color:white;padding:8px 14px;border-radius:8px;font-size:0.8rem;box-shadow:0 4px 12px rgba(0,0,0,0.2);display:none;z-index:20;white-space:nowrap;line-height:1.5;"></div>
        </div>
        <!-- Legend -->
        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:center;margin-top:16px;padding-top:16px;border-top:1px solid ${th.border};">
            ${Object.entries(AM_STATUS).map(([label, cfg]) => `
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:14px;height:14px;border-radius:4px;background:${cfg.color};"></div>
                    <span style="font-size:0.75rem;color:${th.muted};">${label}</span>
                </div>
            `).join('')}
        </div>
    </div>`;
}

// ========================================
// KABUPATEN VIEW (Drill-down)
// ========================================
function amRenderKab() {
    const c = document.getElementById('admin-map-container');
    if (!c) return;
    const th = amTheme();
    const provName = _am.prov;
    const kabFeatures = _am.geo.features.filter(f => f.properties.Level === 'Kabupaten/Kota' && f.properties.Provinsi === provName);

    if (kabFeatures.length === 0) { _am.prov = null; amRenderProv(); return; }

    const vb = amViewBox(kabFeatures, 0.3);

    // Count stats
    let stats = { Disetujui: 0, Pending: 0, Draft: 0, Ditolak: 0, 'Belum Ada': 0 };
    const kabPaths = kabFeatures.map(f => {
        const name = f.properties['Kabupaten/Kota'] || f.properties.Provinsi;
        const status = amGetKabStatus(provName, name);
        stats[status] = (stats[status] || 0) + 1;
        let fill = amGetColor(status);
        let opacity = '1';
        let sw = '0.03';
        let sc = '#fff';

        if (_am.filter !== 'all' && status !== _am.filter) {
            fill = '#f3f4f6'; opacity = '0.4'; sw = '0.02'; sc = '#e5e7eb';
        }
        if (_am.highlight === name) {
            sc = '#f97316'; sw = '0.1';
        }

        const safeName = name.replace(/'/g, "\\'");
        return `<path data-name="${name}" d="${amGeoToPath(f.geometry)}" fill="${fill}" stroke="${sc}" stroke-width="${sw}" style="cursor:pointer;transition:all 0.2s;opacity:${opacity};"
            onmouseover="this.style.filter='brightness(0.85)';amShowTip(event,'<b>${name.replace(/'/g, '')}</b><br>${status}')"
            onmousemove="amMoveTip(event)"
            onmouseout="this.style.filter='';amHideTip()"/>`;
    }).join('');

    // Mini map of Indonesia (highlight current province)
    const provFeatures = _am.geo.features.filter(f => f.properties.Level === 'Provinsi');
    const miniPaths = provFeatures.map(f =>
        `<path d="${amGeoToPath(f.geometry)}" fill="${f.properties.Provinsi === provName ? '#3b82f6' : '#d1d5db'}" stroke="#fff" stroke-width="0.05" style="cursor:pointer;" onclick="amDrillDown('${f.properties.Provinsi.replace(/'/g, "\\'")}')" />`
    ).join('');

    // Filter options
    const filterOpts = [
        { v: 'all', l: 'Semua' },
        { v: 'Disetujui', l: '✓ Disetujui' },
        { v: 'Pending', l: '⏳ Pending' },
        { v: 'Draft', l: '📝 Draft' },
        { v: 'Ditolak', l: '✗ Ditolak' },
        { v: 'Belum Ada', l: '○ Belum Ada' },
    ];

    c.innerHTML = `
    <div style="background:${th.bg};border:1px solid ${th.border};border-radius:12px;padding:16px;">
        <!-- Breadcrumb -->
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:0.875rem;">
            <button onclick="amBack()" style="color:#3b82f6;background:none;border:none;cursor:pointer;font-size:0.875rem;font-weight:500;">← Indonesia</button>
            <span style="color:${th.muted};">»</span>
            <span style="color:${th.text};font-weight:500;">${provName}</span>
            <span style="color:${th.muted};">(${kabFeatures.length} Kab/Kota)</span>
        </div>
        <!-- Header -->
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:12px;">
            <div>
                <h3 style="font-size:1rem;font-weight:600;color:${th.text};margin:0;">Prov. ${provName}</h3>
                <p style="font-size:0.75rem;color:${th.muted};margin:4px 0 0;">Hover untuk detail kabupaten/kota</p>
            </div>
            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" id="am-search" placeholder="Cari Kab/Kota..." value="${_am.search}"
                        style="padding:6px 12px;border:1px solid ${th.border};border-radius:8px;font-size:0.75rem;width:160px;background:${th.input};color:${th.text};outline:none;"
                        oninput="amSearchKab(this.value)" onkeydown="amSearchKabKey(event)">
                    <div id="am-suggestions" style="position:absolute;top:100%;left:0;right:0;margin-top:4px;background:${th.bg};border:1px solid ${th.border};border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.12);z-index:30;overflow:hidden;display:none;max-height:200px;overflow-y:auto;"></div>
                </div>
                <select id="am-filter"
                    style="padding:6px 12px;border:1px solid ${th.border};border-radius:8px;font-size:0.75rem;background:${th.input};color:${th.text};"
                    onchange="amFilter(this.value)">
                    ${filterOpts.map(o => `<option value="${o.v}" ${_am.filter === o.v ? 'selected' : ''}>${o.l}</option>`).join('')}
                </select>
                <!-- Mini map -->
                <svg viewBox="94 -7 48 20" width="100" height="35" style="border:1px solid ${th.border};border-radius:6px;background:${th.svgBg};" preserveAspectRatio="xMidYMid meet">${miniPaths}</svg>
            </div>
        </div>
        <!-- Stat cards -->
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;margin-bottom:16px;">
            ${Object.entries(AM_STATUS).map(([label, cfg]) => {
        const count = stats[label] || 0;
        return `<div style="text-align:center;padding:8px;border-radius:8px;background:${cfg.color}15;border:1px solid ${cfg.color}30;">
                    <div style="font-size:1.25rem;font-weight:700;color:${cfg.color};">${count}</div>
                    <div style="font-size:0.625rem;color:${cfg.color};margin-top:2px;">${label}</div>
                </div>`;
    }).join('')}
        </div>
        <!-- Map -->
        <div style="position:relative;">
            <svg viewBox="${vb}" style="width:100%;height:400px;background:${th.svgBg};border-radius:8px;" preserveAspectRatio="xMidYMid meet">${kabPaths}</svg>
            <div id="am-tooltip" style="position:absolute;pointer-events:none;background:#1f2937;color:white;padding:8px 14px;border-radius:8px;font-size:0.8rem;box-shadow:0 4px 12px rgba(0,0,0,0.2);display:none;z-index:20;white-space:nowrap;line-height:1.5;"></div>
        </div>
        <!-- Legend -->
        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:center;margin-top:16px;padding-top:16px;border-top:1px solid ${th.border};">
            ${Object.entries(AM_STATUS).map(([label, cfg]) => `
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:14px;height:14px;border-radius:4px;background:${cfg.color};"></div>
                    <span style="font-size:0.75rem;color:${th.muted};">${label}</span>
                </div>
            `).join('')}
        </div>
    </div>`;
}

// ========================================
// NAVIGATION
// ========================================
function amDrillDown(provName) {
    _am.prov = provName;
    _am.highlight = null;
    _am.search = '';
    amRender();
}

function amBack() {
    _am.prov = null;
    _am.highlight = null;
    _am.search = '';
    _am.filter = 'all';
    amRender();
}

function amFilter(val) {
    _am.filter = val;
    amRender();
}

// ========================================
// SEARCH - Province Level
// ========================================
function amSearch(query) {
    _am.search = query;
    const dd = document.getElementById('am-suggestions');
    if (!dd) return;

    if (!query || query.length < 2) {
        dd.style.display = 'none';
        _am.highlight = null;
        if (_am.timer) clearTimeout(_am.timer);
        // Re-render to clear highlights
        _am.timer = setTimeout(() => amRender(), 100);
        return;
    }

    const q = query.toLowerCase();
    const th = amTheme();
    const suggestions = [];

    // Search provinces
    const provFeatures = _am.geo.features.filter(f => f.properties.Level === 'Provinsi');
    provFeatures.forEach(f => {
        if (f.properties.Provinsi.toLowerCase().includes(q)) {
            suggestions.push({ type: 'prov', name: f.properties.Provinsi, sub: 'Provinsi' });
        }
    });

    // Search kab/kota across all provinces
    const kabFeatures = _am.geo.features.filter(f => f.properties.Level === 'Kabupaten/Kota');
    kabFeatures.forEach(f => {
        const kn = f.properties['Kabupaten/Kota'] || '';
        if (kn.toLowerCase().includes(q) && suggestions.length < 10) {
            suggestions.push({ type: 'kab', name: kn, sub: f.properties.Provinsi, prov: f.properties.Provinsi });
        }
    });

    if (suggestions.length > 0) {
        dd.style.display = 'block';
        dd.innerHTML = suggestions.slice(0, 8).map(s => {
            const icon = s.type === 'prov' ? '🗺️' : '📍';
            const safeName = s.name.replace(/'/g, "\\'");
            const safeProv = (s.prov || '').replace(/'/g, "\\'");
            const onclick = s.type === 'prov'
                ? `amSearchSelect('prov','${safeName}')`
                : `amSearchSelect('kab','${safeName}','${safeProv}')`;
            return `<button onclick="${onclick}" style="width:100%;text-align:left;padding:8px 12px;font-size:0.75rem;color:${th.text};border:none;background:transparent;cursor:pointer;display:flex;align-items:center;gap:8px;border-bottom:1px solid ${th.border};"
                onmouseover="this.style.background='${th.hover}'" onmouseout="this.style.background='transparent'">
                <span>${icon}</span>
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:500;">${s.name}</div>
                    <div style="font-size:0.625rem;color:${th.muted};">${s.sub}</div>
                </div>
            </button>`;
        }).join('');
    } else {
        dd.style.display = 'block';
        dd.innerHTML = `<div style="padding:12px;text-align:center;font-size:0.75rem;color:${th.muted};">Tidak ditemukan</div>`;
    }

    // Highlight with debounce
    if (_am.timer) clearTimeout(_am.timer);
    _am.timer = setTimeout(() => {
        const match = suggestions[0];
        _am.highlight = match ? match.name : null;
        // Update highlights without full re-render (just update stroke)
        document.querySelectorAll('#admin-map-container svg path[data-name]').forEach(p => {
            const n = p.getAttribute('data-name');
            if (n === _am.highlight) {
                p.setAttribute('stroke', '#f59e0b');
                p.setAttribute('stroke-width', '0.3');
            } else {
                p.setAttribute('stroke', '#fff');
                p.setAttribute('stroke-width', '0.1');
            }
        });
    }, 150);
}

function amSearchSelect(type, name, prov) {
    const dd = document.getElementById('am-suggestions');
    if (dd) dd.style.display = 'none';
    _am.search = '';

    if (type === 'prov') {
        amDrillDown(name);
    } else if (type === 'kab') {
        if (prov) _am.prov = prov;
        _am.highlight = name;
        amRender();
    }
}

function amSearchKey(event) {
    if (event.key === 'Escape') {
        const dd = document.getElementById('am-suggestions');
        if (dd) dd.style.display = 'none';
        _am.search = '';
        event.target.value = '';
        _am.highlight = null;
        amRender();
    }
    if (event.key === 'Enter') {
        const dd = document.getElementById('am-suggestions');
        const first = dd ? dd.querySelector('button') : null;
        if (first) first.click();
    }
}

// ========================================
// SEARCH - Kabupaten Level
// ========================================
function amSearchKab(query) {
    _am.search = query;
    const dd = document.getElementById('am-suggestions');
    if (!dd) return;

    if (!query || query.length < 2) {
        dd.style.display = 'none';
        _am.highlight = null;
        // Update highlights
        document.querySelectorAll('#admin-map-container svg path[data-name]').forEach(p => {
            p.setAttribute('stroke', '#fff');
            p.setAttribute('stroke-width', '0.03');
        });
        return;
    }

    const q = query.toLowerCase();
    const th = amTheme();
    const kabFeatures = _am.geo.features.filter(f => f.properties.Level === 'Kabupaten/Kota' && f.properties.Provinsi === _am.prov);
    const suggestions = [];
    kabFeatures.forEach(f => {
        const kn = f.properties['Kabupaten/Kota'] || '';
        if (kn.toLowerCase().includes(q)) {
            suggestions.push({ name: kn });
        }
    });

    if (suggestions.length > 0) {
        dd.style.display = 'block';
        dd.innerHTML = suggestions.slice(0, 6).map(s => {
            const safeName = s.name.replace(/'/g, "\\'");
            return `<button onclick="amSearchKabSelect('${safeName}')" style="width:100%;text-align:left;padding:8px 12px;font-size:0.75rem;color:${th.text};border:none;background:transparent;cursor:pointer;border-bottom:1px solid ${th.border};"
                onmouseover="this.style.background='${th.hover}'" onmouseout="this.style.background='transparent'">
                📍 ${s.name}
            </button>`;
        }).join('');
    } else {
        dd.style.display = 'block';
        dd.innerHTML = `<div style="padding:12px;text-align:center;font-size:0.75rem;color:${th.muted};">Tidak ditemukan</div>`;
    }

    // Highlight with debounce
    if (_am.timer) clearTimeout(_am.timer);
    _am.timer = setTimeout(() => {
        const match = suggestions[0];
        _am.highlight = match ? match.name : null;
        document.querySelectorAll('#admin-map-container svg path[data-name]').forEach(p => {
            const n = p.getAttribute('data-name');
            if (n === _am.highlight) {
                p.setAttribute('stroke', '#f97316');
                p.setAttribute('stroke-width', '0.1');
            } else {
                p.setAttribute('stroke', '#fff');
                p.setAttribute('stroke-width', '0.03');
            }
        });
    }, 150);
}

function amSearchKabSelect(name) {
    const dd = document.getElementById('am-suggestions');
    if (dd) dd.style.display = 'none';
    _am.search = '';
    _am.highlight = name;
    amRender();
}

function amSearchKabKey(event) {
    if (event.key === 'Escape') {
        const dd = document.getElementById('am-suggestions');
        if (dd) dd.style.display = 'none';
        _am.search = '';
        event.target.value = '';
        _am.highlight = null;
        document.querySelectorAll('#admin-map-container svg path[data-name]').forEach(p => {
            p.setAttribute('stroke', '#fff');
            p.setAttribute('stroke-width', '0.03');
        });
    }
    if (event.key === 'Enter') {
        const dd = document.getElementById('am-suggestions');
        const first = dd ? dd.querySelector('button') : null;
        if (first) first.click();
    }
}

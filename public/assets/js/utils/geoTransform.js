/**
 * GeoJSON Transformation Utilities
 * Vanilla JavaScript version of geoTransform.ts
 */

/**
 * Convert polygon coordinates to SVG path data
 * @param {Array} coords - Array of [longitude, latitude] pairs
 * @returns {string} SVG path data string
 */
function coordinatesToPath(coords) {
    if (!coords || coords.length === 0) return '';

    return coords.map((coord, i) => {
        const x = coord[0];
        const y = -coord[1]; // Flip Y for SVG
        return `${i === 0 ? 'M' : 'L'}${x},${y}`;
    }).join(' ') + ' Z';
}

/**
 * Convert MultiPolygon or Polygon geometry to SVG path
 * @param {Object} geometry - GeoJSON geometry object
 * @returns {string} Combined SVG path data string
 */
function geometryToPath(geometry) {
    if (geometry.type === 'Polygon') {
        return geometry.coordinates
            .map(ring => coordinatesToPath(ring))
            .join(' ');
    }

    if (geometry.type === 'MultiPolygon') {
        return geometry.coordinates
            .map(polygon => polygon.map(ring => coordinatesToPath(ring)).join(' '))
            .join(' ');
    }

    return '';
}

/**
 * Calculate bounding box for coordinates
 * @param {Array} coords - Array of [longitude, latitude] pairs
 * @returns {Object} Bounding box { minX, minY, maxX, maxY }
 */
function calculateBoundingBox(coords) {
    if (!coords || coords.length === 0) {
        return { minX: 0, minY: 0, maxX: 0, maxY: 0 };
    }

    let minX = Infinity, minY = Infinity;
    let maxX = -Infinity, maxY = -Infinity;

    coords.forEach(([x, y]) => {
        minX = Math.min(minX, x);
        minY = Math.min(minY, y);
        maxX = Math.max(maxX, x);
        maxY = Math.max(maxY, y);
    });

    return { minX, minY, maxX, maxY };
}

/**
 * Calculate center point of coordinates
 * @param {Array} coords - Array of [longitude, latitude] pairs
 * @returns {Array} Center point [x, y]
 */
function calculateCenter(coords) {
    const bbox = calculateBoundingBox(coords);
    return [
        (bbox.minX + bbox.maxX) / 2,
        (bbox.minY + bbox.maxY) / 2
    ];
}

/**
 * Scale coordinates to fit within a viewport
 * @param {Array} coords - Original coordinates
 * @param {number} width - Target width
 * @param {number} height - Target height
 * @param {number} padding - Padding in pixels
 * @returns {Array} Scaled coordinates
 */
function scaleCoordinates(coords, width, height, padding = 20) {
    const bbox = calculateBoundingBox(coords);
    const dataWidth = bbox.maxX - bbox.minX;
    const dataHeight = bbox.maxY - bbox.minY;

    const scaleX = (width - 2 * padding) / dataWidth;
    const scaleY = (height - 2 * padding) / dataHeight;
    const scale = Math.min(scaleX, scaleY);

    const offsetX = padding + (width - 2 * padding - dataWidth * scale) / 2;
    const offsetY = padding + (height - 2 * padding - dataHeight * scale) / 2;

    return coords.map(([x, y]) => [
        (x - bbox.minX) * scale + offsetX,
        (y - bbox.minY) * scale + offsetY
    ]);
}

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        coordinatesToPath,
        geometryToPath,
        calculateBoundingBox,
        calculateCenter,
        scaleCoordinates
    };
}

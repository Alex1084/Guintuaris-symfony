import 'leaflet'

import 'leaflet/dist/leaflet.css';
import data from '../../guintuaris_cells.json';
import notes from '../../notes.json';

// doc for json
// https://github.com/Azgaar/Fantasy-Map-Generator/wiki/Data-model
// let pack = data.pack
let pack = data.cells



let levelData = { 
    0: {level : "-990", color: "rgb(94, 79, 162)", width: "0.2em"},
    1: {level : "-950", color: "rgb(94, 79, 162)", width: "0.2em"},
    2: {level : "-450", color: "rgb(94, 79, 162)", width: "0.2em"},
    3: {level : "-283", color: "rgb(94, 79, 162)", width: "0.2em"},
    4: {level : "-200", color: "rgb(94, 79, 162)", width: "0.2em"},
    5: {level : "-150", color: "rgb(94, 79, 162)", width: "0.2em"},
    6: {level : "-117", color: "rgb(90, 85, 165)", width: "0.2em"},
    7: {level : "-93", color: "rgb(85, 90, 167)", width: "0.2em"},
    8: {level : "-75", color: "rgb(81, 96, 170)", width: "0.2em"},
    9: {level : "-61", color: "rgb(77, 102, 172)", width: "0.2em"},
    10: {level : "-50", color: "rgb(74, 108, 176)", width: "0.2em"},
    11: {level : "-41", color: "rgb(69, 112, 176)", width: "0.2em"},
    12: {level : "-33", color: "rgb(69, 119, 178)", width: "0.2em"},
    13: {level : "-27", color: "rgb(67, 125, 179)", width: "0.2em"},
    14: {level : "-21", color: "rgb(66, 130, 180)", width: "0.2em"},
    15: {level : "-17", color: "rgb(66, 136, 181)", width: "0.2em"},
    16: {level : "-12", color: "rgb(67, 142, 180)", width: "0.2em"},
    17: {level : "-9", color: "rgb(69, 148, 180)", width: "0.2em"},
    18: {level : "-6", color: "rgb(71, 153, 179)", width: "0.2em"},
    19: {level : "-3", color: "rgb(74, 159, 178)", width: "0.2em"},
    20: {level : "4", color: "rgb(105, 189, 169)", width: "0.2em"},
    21: {level : "9", color: "rgb(111, 193, 168)", width: "0.2em"},
    22: {level : "16", color: "rgb(117, 197, 167)", width: "0.2em"},
    23: {level : "25", color: "rgb(124, 200, 166)", width: "0.2em"},
    24: {level : "36", color: "rgb(130, 204, 165)", width: "0.2em"},
    25: {level : "49", color: "rgb(137, 207, 165)", width: "0.2em"},
    26: {level : "64", color: "rgb(143, 210, 164)", width: "0.2em"},
    27: {level : "81", color: "rgb(150, 213, 164)", width: "0.2em"},
    28: {level : "100", color: "rgb(156, 215, 163)", width: "0.2em"},
    29: {level : "121", color: "rgb(163, 218, 163)", width: "0.2em"},
    30: {level : "144", color: "rgb(169, 221, 162)", width: "0.2em"},
    31: {level : "169", color: "rgb(176, 223, 161)", width: "0.2em"},
    32: {level : "196", color: "rgb(182, 226, 161)", width: "0.2em"},
    33: {level : "225", color: "rgb(188, 228, 160)", width: "0.2em"},
    34: {level : "256", color: "rgb(194, 230, 159)", width: "0.2em"},
    35: {level : "289", color: "rgb(200, 233, 159)", width: "0.2em"},
    36: {level : "324", color: "rgb(205, 235, 159)", width: "0.2em"},
    37: {level : "361", color: "rgb(210, 237, 158)", width: "0.2em"},
    38: {level : "400", color: "rgb(215, 239, 159)", width: "0.2em"},
    39: {level : "441", color: "rgb(220, 241, 159)", width: "0.2em"},
    40: {level : "484", color: "rgb(224, 243, 161)", width: "0.1em"},
    41: {level : "529", color: "rgb(228, 244, 162)", width: "0.1em"},
    42: {level : "576", color: "rgb(232, 246, 164)", width: "0.1em"},
    43: {level : "625", color: "rgb(235, 247, 166)", width: "0.1em"},
    44: {level : "676", color: "rgb(238, 248, 168)", width: "0.1em"},
    45: {level : "729", color: "rgb(241, 249, 171)", width: "0.1em"},
    46: {level : "784", color: "rgb(244, 249, 173)", width: "0.1em"},
    47: {level : "841", color: "rgb(246, 250, 174)", width: "0.1em"},
    48: {level : "900", color: "rgb(248, 249, 176)", width: "0.1em"},
    49: {level : "961", color: "rgb(249, 249, 176)", width: "0.1em"},
    50: {level : "1024", color: "rgb(251, 248, 176)", width: "0.1em"},
    51: {level : "1089", color: "rgb(252, 247, 175)", width: "0.1em"},
    52: {level : "1156", color: "rgb(253, 245, 173)", width: "0.1em"},
    53: {level : "1225", color: "rgb(253, 243, 170)", width: "0.1em"},
    54: {level : "1296", color: "rgb(254, 241, 167)", width: "0.1em"},
    55: {level : "1369", color: "rgb(254, 238, 163)", width: "0.1em"},
    56: {level : "1444", color: "rgb(254, 235, 159)", width: "0.1em"},
    57: {level : "1521", color: "rgb(254, 232, 155)", width: "0.1em"},
    58: {level : "1600", color: "rgb(254, 229, 150)", width: "0.1em"},
    59: {level : "1681", color: "rgb(254, 225, 145)", width: "0.1em"},
    60: {level : "1764", color: "rgb(254, 221, 141)", width: "0.1em"},
    61: {level : "1849", color: "rgb(254, 217, 136)", width: "0.1em"},
    62: {level : "1936", color: "rgb(254, 212, 131)", width: "0.1em"},
    63: {level : "2025", color: "rgb(254, 208, 127)", width: "0.1em"},
    64: {level : "2116", color: "rgb(254, 203, 123)", width: "0.1em"},
    65: {level : "2209", color: "rgb(253, 198, 118)", width: "0.1em"},
    66: {level : "2304", color: "rgb(253, 193, 114)", width: "0.1em"},
    67: {level : "2401", color: "rgb(253, 188, 110)", width: "0.1em"},
    68: {level : "2500", color: "rgb(253, 183, 106)", width: "0.1em"},
    69: {level : "2601", color: "rgb(252, 177, 103)", width: "0.2em"},
    70: {level : "2704", color: "rgb(252, 172, 99)", width: "0.2em"},
    71: {level : "2809", color: "rgb(251, 166, 95)", width: "0.2em"},
    72: {level : "2916", color: "rgb(250, 160, 92)", width: "0.2em"},
    73: {level : "3025", color: "rgb(250, 154, 89)", width: "0.2em"},
    74: {level : "3136", color: "rgb(249, 148, 86)", width: "0.2em"},
    75: {level : "3249", color: "rgb(248, 142, 83)", width: "0.2em"},
    76: {level : "3364", color: "rgb(247, 135, 81)", width: "0.2em"},
    77: {level : "3481", color: "rgb(245, 129, 78)", width: "0.2em"},
    78: {level : "3600", color: "rgb(244, 124, 77)", width: "0.2em"},
    79: {level : "3721", color: "rgb(242, 118, 75)", width: "0.2em"},
    80: {level : "3844", color: "rgb(240, 112, 74)", width: "0.2em"},
    81: {level : "3969", color: "rgb(238, 106, 73)", width: "0.2em"},
    82: {level : "4096", color: "rgb(236, 101, 73)", width: "0.2em"},
    83: {level : "4225", color: "rgb(233, 96, 73)", width: "0.2em"},
    84: {level : "4356", color: "rgb(231, 91, 73)", width: "0.2em"},
    85: {level : "4489", color: "rgb(228, 86, 73)", width: "0.2em"},
    86: {level : "4624", color: "rgb(224, 80, 74)", width: "0.2em"},
    87: {level : "4761", color: "rgb(221, 75, 74)", width: "0.2em"},
    88: {level : "4900", color: "rgb(217, 70, 75)", width: "0.2em"},
    89: {level : "5041", color: "rgb(213, 65, 75)", width: "0.2em"},
    90: {level : "5184", color: "rgb(209, 60, 75)", width: "0.2em"},
    91: {level : "5329", color: "rgb(205, 54, 75)", width: "0.2em"},
    92: {level : "5476", color: "rgb(200, 49, 74)", width: "0.2em"},
    93: {level : "5625", color: "rgb(195, 43, 74)", width: "0.2em"},
    94: {level : "5776", color: "rgb(190, 37, 73)", width: "0.2em"},
    95: {level : "5929", color: "rgb(185, 31, 72)", width: "0.2em"},
    96: {level : "6084", color: "rgb(180, 25, 71)", width: "0.2em"},
    97: {level : "6241", color: "rgb(174, 19, 70)", width: "0.2em"},
    98: {level : "6400", color: "rgb(169, 13, 69)", width: "0.2em"},
    99: {level : "6561", color: "rgb(163, 7, 67)", width: "0.2em"},
    100: {level : "6724", color: "rgb(158, 1, 66)", width: "0.2em"},
}

let colors = {
    red : "#e74c3c",
    blue : '#3498db',
    green : '#1abc9c',
    yellow : '#f1c40f',
    purple : '#9b59b6',
    orange : '#e67e22',
    turquoise : '#1abc9c',
    fushia : '#e91e63',
    lime : '#2ecc71',
}
function getPinSVG(color, width = 1, height = 1.6) {
    return `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 160" width="${width}" height="${height}">
        <polygon fill="#34495e" points="40,50 60,50, 60,145 50,160 40,145"/> Main red circle
        <circle cx="50" cy="50" r="50" fill="${color}" />
        
        <!-- Smaller white circle inside the main red circle -->
        <circle cx="30" cy="30" r="15" fill="rgba(255, 255, 255, 0.3)" />
        
        </svg>`;
}
function updatePin(marker, color = null)
{
    pinIcon.options.iconSize = [marker.currentWidth, marker.currentHeight];
    pinIcon.options.iconAnchor = [marker.currentWidth*0.5, marker.currentHeight];

    if (color !== null)
    {
        pinIcon.options.html = getPinSVG(
            color, 
            marker.currentWidth, 
            marker.currentHeight
        );
    }
    else
    {
        pinIcon.options.html = getPinSVG(
            marker.color, 
            marker.currentWidth, 
            marker.currentHeight
        );
    }

    marker.setIcon(pinIcon);
}
function trueCoordinates(x,y = null)
{
    let trueX;
    let trueY;
    if (Array.isArray(x))
    {
        trueX = x[0]*24+64;
        trueY = x[1]*24+9100
    }
    else
    {    
        trueX = x*24+64;
        trueY = y*24+9100
    }
    return [trueY,trueX]
}
function getNote(id,type) {
    let note = ''
    if (notesIndex.hasOwnProperty(type+id))
    {
        note = notesIndex[type+id].legend;
    }
    return note
}

let pinIcon = L.divIcon({
    iconSize: [1, 1.6], // Taille totale de l'icône
    iconAnchor: [0.5, 1.6], // Point d'ancrage au centre de la base du marqueur
})

let mapBounds = [[0,0], [32768, 32768]];
let biomeLayer = L.tileLayer('../img/map/biomes/{z}/{x}/{y}.png', {
    name : "biomes",
    noWrap: false,
    bounds: mapBounds
});

let heightLayer = L.tileLayer('../img/map/height/{z}/{x}/{y}.png', {
    name : "height",
    noWrap: true,
    bounds: mapBounds
});
let stateLayer = L.tileLayer('../img/map/states/{z}/{x}/{y}.png', {
    name : "states",
    noWrap: true,
    bounds: mapBounds
});
let reliefLayer = L.tileLayer('../img/map/relief/{z}/{x}/{y}.png', {
    name : "relief",
    noWrap: true,
    bounds: mapBounds
});


// ****** Notes ****** \\
let notesIndex = {};
for (let note of notes) {
        notesIndex[note.id] = note;
}

// ****** Cells Layer ****** \\
// let littlePolygon = [8369,8370,8631,8632]


// let cells = [];
// for (let cell of pack.cells) {
//     if (cell.biome == 0)
//         continue;

//     let polygonCoordinates = []
//     for (let vertice of cell.v) {
//         let coordinates = trueCoordinates(pack.vertices[vertice].p);
//         polygonCoordinates.push(coordinates);
    
//     }
//     let polygon = L.polygon(polygonCoordinates, {
//         // fill : false,
//         weight: 0.7
//     });
//     polygon.bindPopup(""+cell.i);
//     cells.push(polygon);
// }
// let cellsLayer = L.layerGroup(cells);

// ****** Burgs Layer ****** \\
let burgs = [];
for (let burg of pack.burgs) {
    if (!burg.hasOwnProperty("i") || burg.removed == true || burg.population <= 0.1 )
        continue;
    let color = colors.red
    if (burg.capital == 1) {
        color = colors.yellow
    }
    pinIcon.options.html = getPinSVG(color);
    let burgMarker = L.marker(trueCoordinates(burg.x, burg.y), {icon:pinIcon});
    
    burgMarker.originalColor = color;
    burgMarker.color = color;
    burgMarker.currentWidth = 1;
    burgMarker.currentHeight = 1.6;
    
    burgMarker.html = `<h4>${burg.name}</h4>
        <span>Population : ${Math.round(burg.population*1000)} habitant(s) </span>`+ getNote(burg.i, "burg");

    burgMarker.on('click', onMarkerClick);

    burgs.push(burgMarker);
}
let burgsLayer = L.layerGroup(burgs);

// ****** Routes Layer ****** \\
let routes = [];
let trailStyle = {
    color : 'red',
    weight : '0.125',
    originWeigth : '0.125',
}
let seaRoadStyle = {
    color : 'white',
    weight : '0.2',
    originWeigth : '0.2',
}
let roadStyle = {
    color : 'red',
    weight : '0.2',
    originWeigth : '0.2'
}
for (let route of pack.routes) {
    let style;
    let points = [];
    for (let point of route.points) {
        points.push(trueCoordinates(point));
    }

    switch (route.group) {
        case 'trails':
            style = trailStyle;
            break;
        case 'searoutes':
            style = seaRoadStyle;
            break;
        case 'roads':
            style = roadStyle;
            break;
        default:
            style = roadStyle;
            break;
    }
    let routeLine = L.polyline(points, {
        dashArray : '0.5, 0.5',
        dashOrigin : '0.5, 0.5',
        lineCap : 'butt',
        lineJoin : 'round',
        scaleFactor : '5.0'

    });
    routeLine.setStyle(style);
    routes.push(routeLine);
    routeLine.originalStyle = style;
    routeLine.on('click', onMarkerClick);

    if (route.name == undefined) {
        route.name = "Route sans nom"
    }
    if (route.length == undefined) {
        route.length = "Non renseigné"
    }
    routeLine.html = `<h4>${route.name}</h4>
    <span>Distance : ${typeof route.length == "string" ? route.length : Math.round(route.length)+'km'}</span>
    `+ getNote(route.i, "route");

}
let routesLayer = L.layerGroup(routes);

// ****** Rivers Layer ****** \\
let rivers = [];
let selectedStyle = {
    color : '#ff7800',
}
let riverStyle = {
    color : '#3388ff',
    weight : '0.25',
    originWeigth : '0.5',
    scaleFactor : '5.0'
}
for (let river of pack.rivers) {
    let points = [];

    if (river.hasOwnProperty("points") === false)
    {
        for (let cellId of river.cells)
        {
            if (cellId === -1)           
                continue
                
            let coordinates = pack.cells[cellId].p;
            points.push(trueCoordinates(coordinates));
        }
    }
    else
    {
        for (let point of river.points) {
            points.push(trueCoordinates(point));
        }
    }
    let riverLine = L.polyline(points);
    riverLine.originalStyle = riverStyle;

    riverLine.html = `<h4>${river.name}</h4>
                <span>Flux : ${river.discharge}m<i class="power">3</i>/s</span> <br>
                <span>Longeur : ${river.length}km</span>`+getNote(river.i, "river");
    rivers.push(riverLine);

    riverLine.on('click', onMarkerClick);
}
let riversLayer = L.layerGroup(rivers);

// ****** State Layer ****** \\
// let statesCells = {};
// let provincesCells = {};
// let religionCells = {};
// let cultureCells = {};
// // let states = [];

// for (let cell of pack.cells) {
//     if (cell.biome == 0)
//         continue;

//     let stateId = cell.state;
//     let provinceId = cell.province;
//     let religionId = cell.religion;
//     let cultureId = cell.culture;
    
//     // **** State ****\\
//     if (!statesCells[stateId])
//         statesCells[stateId] = [];

//     if (stateId !== undefined || stateId !== null)
//         statesCells[stateId].push(cell);
    
//     // **** Provinces ****\\
//     if (!provincesCells[provinceId])
//         provincesCells[provinceId] = [];

//     if (provinceId !== undefined || provinceId !== null)
//         provincesCells[provinceId].push(cell);

//     // **** Religion ****\\
//     if (!religionCells[religionId])
//         religionCells[religionId] = [];

//     if (religionId !== undefined || religionId !== null)
//         religionCells[religionId].push(cell);

//     // **** Culture ****\\
//     if (!cultureCells[cultureId])
//         cultureCells[cultureId] = [];

//     if (cultureId !== undefined || cultureId !== null)
//         cultureCells[cultureId].push(cell);
    
// }

let maxZoom = 7; // Ajuste cela en fonction de ton maxZoom
let scaleFactor = Math.pow(2, maxZoom); // Facteur d'échelle basé sur maxZoom

// Définir un CRS personnalisé
let myCRS = L.extend({}, L.CRS.Simple, {
    transformation: new L.Transformation(1 / scaleFactor, 0, 1 / scaleFactor, 0)
});

let map = L.map('map', {
    minZoom: 2,
    maxZoom: maxZoom,
    layers:[biomeLayer, burgsLayer, riversLayer, routesLayer],
    // crs: L.CRS.Simple,
    crs: myCRS,
    maxBounds: mapBounds,
    maxBoundsViscosity: 1.0
})

map.fitBounds(mapBounds);
map.setView(trueCoordinates(799.39, 133.48), 6)

let navigationControl = L.control({ position: "topright" });
navigationControl.onAdd = function(map) {
    let div = L.DomUtil.create("div", "legend");
    div.innerHTML += `<a href="/">Retour a l'acceuil</a>`;
  
    return div;
};
navigationControl.addTo(map);

let baseMaps = {
    'biomes': biomeLayer,
    'height': heightLayer,
    'relief': reliefLayer,
    // 'states': stateLayer
};

let overlayMaps = {
    "Cities": burgsLayer,
    "Routes": routesLayer,
    "Rivieres": riversLayer,
    // "Cells" : cellsLayer,
    // "States" : statesLayer,
};

// Ajouter le contrôle personnalisé à la carte
let layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);


let InfoControl = L.Control.extend({
    onAdd: function(map) {
        this._div = L.DomUtil.create('div', 'info-control');
        this._div.innerHTML = `
            <div class="control-bar">
                <b>Informations</b>
                <div class="close-control">
                    <span>X</span>
                </div>
                <div class="minimize-control">
                    <span>_</span>
                </div>
            </div>
            <div class="content"></div>
            `;


        // Rendre le contrôle déplaçable
        L.DomUtil.addClass(this._div, 'leaflet-draggable');
        let draggable = new L.Draggable(this._div);
        draggable.enable();
        L.DomEvent.on(this._div.querySelector('.minimize-control span'), 'click', this._toggleMinimize, this);
        L.DomEvent.on(this._div, 'wheel', L.DomEvent.stopPropagation);

        // Ajout d'un gestionnaire d'événement pour fermer le contrôle
        L.DomEvent.on(this._div.querySelector('.close-control span'), 'click', this._closeControl, this);
        return this._div;
    },

    update: function(polygon) {
        this._div.style.display = 'block';  // Cache le contrôle lorsque le bouton "X" est cliqué
        if (lastSelectedPolygon !== null) {
            if (lastSelectedPolygon instanceof L.Marker) {
                lastSelectedPolygon.color = lastSelectedPolygon.originalColor
                updatePin(lastSelectedPolygon)
                
            }
            else if (lastSelectedPolygon instanceof L.Polyline) {
                lastSelectedPolygon.setStyle(lastSelectedPolygon.originalStyle);
            }
        }

        if (polygon instanceof L.Marker) {
            polygon.color = colors.purple
            updatePin(polygon)
        }
        else if (polygon instanceof L.Polyline) {
            polygon.setStyle(selectedStyle);
        }
        // Afficher la popup à la position du clic

        lastSelectedPolygon = polygon;
        this._div.querySelector('.content').innerHTML = polygon.html
    },

    _closeControl: function() {
        if (lastSelectedPolygon !== null) {
            if (lastSelectedPolygon instanceof L.Marker) {
                lastSelectedPolygon.color = lastSelectedPolygon.originalColor
                updatePin(lastSelectedPolygon)
                
            }
            else if (lastSelectedPolygon instanceof L.Polyline) {
                lastSelectedPolygon.setStyle(lastSelectedPolygon.originalStyle);
            }
            lastSelectedPolygon = null;
        }
        this._div.style.display = 'none';  // Cache le contrôle lorsque le bouton "X" est cliqué
        this._div.querySelector('.content').innerHTML = '';
    },
    _toggleMinimize: function() {
        const contentDiv = this._div.querySelector('.content');
        const minimizeButton = this._div.querySelector('.minimize-control span');
        if (contentDiv.style.display === 'none') {
            contentDiv.style.display = 'block';
            minimizeButton.textContent = '_';
        } else {
            contentDiv.style.display = 'none';
            minimizeButton.textContent = '+';
        }
    }
});
let lastSelectedPolygon = null;
let infosPopup = new InfoControl({ position: "topleft" });
map.addControl(infosPopup);

let biomeLegend = L.control({ position: "bottomleft" });

biomeLegend.onAdd = function(map) {
  let div = L.DomUtil.create("div", "legend");
  div.innerHTML += "<h4>Biomes</h4>";
  div.innerHTML += `<i style="background: #008000"></i><span>Plaines</span><br>
  <i style="background: #448D40"></i><span>Forêt</span><br>
  <i style="background: #c3da3f"></i><span>Marais</span><br>
  <i style="background: #fbe79f"></i><span>Desert chaud</span><br>
  <i style="background: #b5b887"></i><span>Desert froid</span><br>
  <i style="background: #96784b"></i><span>Tundra</span><br>
  <i style="background: #d5e7eb"></i><span>Glacier</span><br>
  <i style="background: #4b6b32"></i><span>Taïga</span><br>`;

  return div;
};

biomeLegend.addTo(map);

let heightLegend = L.control({ position: "bottomleft" });

heightLegend.onAdd = function(map) {
    let div = L.DomUtil.create("div", "legend");

    div.innerHTML += "<h4>Height</h4>";
    div.innerHTML += `<p>Hauteur : <span id="height"></span> mètre</p>
        <div style="padding:2px;">`;
    for (let key in levelData) {
        if (Object.prototype.hasOwnProperty.call(levelData, key)) {
            let element = levelData[key];
            div.innerHTML += `<div class="height-legend" data-color="${key}" style="background-color: ${element.color}; width: ${element.width};"></div>`
        }
    }
    div.innerHTML += `</div>`;

    return div;
};
function addHeightLegendListeners() {
    let heightLegends = document.querySelectorAll('.height-legend');
    
    let heightSpan = document.getElementById("height");
    heightLegends.forEach(function(div) {
        

        div.addEventListener("mouseover", function() {
            let dataColor = div.getAttribute('data-color')
            heightSpan.textContent = levelData[dataColor].level;
        })

        // Optionnel : remettre le texte à vide lorsque la souris quitte la div
        div.addEventListener('mouseout', function() {
            heightSpan.textContent = '';
        });
    })
}

map.on("layeradd", (eventLayer) =>{
    if (eventLayer.layer instanceof L.TileLayer) {
        if (eventLayer.layer.options.name === 'biomes')
        {
            biomeLegend.addTo(map);
            map.removeControl(heightLegend);
        } 
        else if (eventLayer.layer.options.name === 'height')
        {
            heightLegend.addTo(map);
            addHeightLegendListeners();
            map.removeControl(biomeLegend);
        } 
        else 
        {
            map.removeControl(heightLegend);
            map.removeControl(biomeLegend);
        }
    }
})

function updateLineWeight() {
    // let defaultWeight = ;
    let zoomLevel = map.getZoom();
    let scaleFactor = Math.pow(2,zoomLevel-1)
    let newDash = 0.5 * scaleFactor;
    
    let width = 0.5 * scaleFactor;
    let height = 0.5*1.6 * scaleFactor;


    riversLayer.eachLayer(function (layer) {
        let newWieght = 0.25 * scaleFactor;
        
        layer.setStyle({weight : newWieght});
        // console.log(layer.getStyle());
        layer.originalStyle.weight = newWieght
    })
    routesLayer.eachLayer(function (layer) {
        let newWieght = layer.options.originWeigth * scaleFactor;
        
        layer.setStyle({weight : newWieght, dashArray: newDash});
        // console.log(layer.getStyle());
        layer.originalStyle.weight = newWieght
        layer.originalStyle.dashArray = newDash
    })
    burgsLayer.eachLayer(function (layer) {
        
        layer.currentWidth = width;
        layer.currentHeight = height;
        updatePin(layer)
        // console.log(layer);
        
    })
    
}

map.on('zoom', updateLineWeight)

function onMarkerClick(e) {
    // Mettre le polygone en surbrillance
    
    infosPopup
        .update(this)
}

document.addEventListener('DOMContentLoaded', (e) => {
    Swal.fire({
        title: 'Bienvenue !',
        html: `<p>Comme tu peux le constater, il y a désormais une carte du monde de Guintuaris.</p>
        <p>Tu peux explorer cette carte pour découvrir les villes, les paysages, et toutes sortes de choses.</p>
        <br>
        <p>La carte du monde est encore en cours de développement, donc certaines choses peuvent être incomplètes, incorrectes ou tout simplement absentes.</p>
        <p>Par conséquent, je te demande d'être indulgent si ce que tu cherches n'est pas disponible ou s'il contient des erreurs.</p>
        <br>
        <p>Merci et bonne exploration !</p>`,    
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'c\'est partit !', 

        background : 'url(../img/scroll.png)',
        width : 479,
        heightAuto : false,
        customClass: 'swal-height',
        padding : "2.5%"
    })
})
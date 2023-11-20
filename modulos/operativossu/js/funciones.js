$(document).on("click", ".feature-row", function(e) {
    $(document).off("mouseout", ".feature-row", clearHighlight);
    sidebarClick(parseInt($(this).attr("id"), 10));
});
if (!("ontouchstart" in window)) {
    $(document).on("mouseover", ".feature-row", function(e) {
        highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
    });
}
$(document).on("mouseout", ".feature-row", clearHighlight);

function clearHighlight() {
    highlight.clearLayers();
}

function sidebarClick(id) {
    var layer = markerClusters.getLayer(id);
    map.setView([layer.getLatLng().lat, layer.getLatLng().lng], 20);
    //layer.fire("click");
}

function syncSidebar() {
    /* Empty sidebar features */
    $("#feature-list tbody").empty();
    /* Loop through theaters layer and add only features which are in the map bounds */
    operativoM.eachLayer(function(layer) {
        if (map.hasLayer(operativoMLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoM.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoP.eachLayer(function(layer) {
        if (map.hasLayer(operativoPLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoP.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoT.eachLayer(function(layer) {
        if (map.hasLayer(operativoTLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoT.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoME.eachLayer(function(layer) {
        if (map.hasLayer(operativoMELayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoME.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoMI.eachLayer(function(layer) {
        if (map.hasLayer(operativoMILayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoMI.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoC.eachLayer(function(layer) {
        if (map.hasLayer(operativoCLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoC.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoCA.eachLayer(function(layer) {
        if (map.hasLayer(operativoCALayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoCA.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoCD.eachLayer(function(layer) {
        if (map.hasLayer(operativoCDLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoCD.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoV.eachLayer(function(layer) {
        if (map.hasLayer(operativoVLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/operativoV.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoDF.eachLayer(function(layer) {
        if (map.hasLayer(operativoDFLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/marker-icon-2x-blue.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    operativoCV.eachLayer(function(layer) {
        if (map.hasLayer(operativoCVLayer)) {
            $("#feature-list tbody").append('<tr class="feature-row" id="' + L.stamp(layer) + '" lat="' + layer.getLatLng().lat + '" lng="' + layer.getLatLng().lng + '"><td style="vertical-align: middle;"><img width="16" height="18" src="img/marker-icon-yellow.png"></td><td class="feature-name">' + layer.feature.properties.evento + '</td><td class="feature-name">' + layer.feature.properties.fechaEvento + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
        }
    });
    ///// LISTAR EN SIDEBAR
    featureList = new List("features", {
        valueNames: ["feature-name"]
    });
    featureList.sort("feature-name", {
        order: "asc"
    });
}
var highlight = L.geoJson(null);
var highlightStyle = {
    stroke: false,
    fillColor: "#164987",
    fillOpacity: 0.7,
    radius: 10
};
var markerClusters = new L.MarkerClusterGroup({
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: true,
    zoomToBoundsOnClick: true,
    disableClusteringAtZoom: 18
});
/////////////// FUNCION DETALLE
function detalle(feature, layer) {
    if (feature.properties) {
        var content = "<table class='table table-striped table-bordered table-condensed'>" + "<tr><th>Ubicación de Operativo:</th><td>" + feature.properties.siglasGeoSenplades + "/" + feature.properties.descS + "</td></tr>" + "<tr><th>Operativo de:</th><td>" + feature.properties.siglas + "/" + feature.properties.desctipo + "</td></tr>" + "<tr><th>Descripción:</th><td>" + feature.properties.descripcion + "</td></tr>" + "<tr><th>Persona que Registró el Operativo:</th><td>" + feature.properties.jefeOperativo + "</td></tr>" + "<tr><th>Fecha:</th><td>" + feature.properties.fechaEvento + "</td></tr>"
        for (x in feature.properties.descTipoResum) {
            content += "<tr><th><a href='javascript:void(0)' onclick='muestraResumen(" + feature.properties.idHdrEvento + "," + feature.properties.descTipoResum[x].tipres + ")'>" + feature.properties.descTipoResum[x].descrip + "</a></th><td>" + feature.properties.descTipoResum[x].cta + "</td></tr>";
        } + "</table>";
        layer.on({
            click: function(e) {
                $("#feature-title").html(feature.properties.evento);
                $("#feature-info").html(content);
                $("#featureModal").modal("show");
                highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], highlightStyle));
            }
        });
    }
}

function iconmoto(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoM.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////MOTOS
var operativoMLayer = L.geoJson(null);
var operativoM = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.estadoPolicia == 3 && feature.properties.desctipo == "MOTOS");
    },
    pointToLayer: iconmoto,
    onEachFeature: detalle
});

function iconpersonas(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoP.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////PERSONAS
var operativoPLayer = L.geoJson(null);
var operativoP = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "PERSONAS");
    },
    pointToLayer: iconpersonas,
    onEachFeature: detalle
});

function icontaxis(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoT.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////TAXIS
var operativoTLayer = L.geoJson(null);
var operativoT = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "TAXIS");
    },
    pointToLayer: icontaxis,
    onEachFeature: detalle
});

function iconvehiculos(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoV.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////VEHÍCULOS
var operativoVLayer = L.geoJson(null);
var operativoV = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "VEHÍCULOS");
    },
    pointToLayer: iconvehiculos,
    onEachFeature: detalle
});

function iconcachinerias(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoC.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////CACHINERÍAS
var operativoCLayer = L.geoJson(null);
var operativoC = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "CACHINERÍAS");
    },
    pointToLayer: iconcachinerias,
    onEachFeature: detalle
});

function iconmecanicas(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoME.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////MECÁNICAS
var operativoMELayer = L.geoJson(null);
var operativoME = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "MECÁNICAS");
    },
    pointToLayer: iconmecanicas,
    onEachFeature: detalle
});

function iconmicrotrafico(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoMI.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////MICROTRÁFICO
var operativoMILayer = L.geoJson(null);
var operativoMI = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "MICROTRÁFICO");
    },
    pointToLayer: iconmicrotrafico,
    onEachFeature: detalle
});

function iconarmas(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoCA.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////CONTROL DE ARMAS
var operativoCALayer = L.geoJson(null);
var operativoCA = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "CONTROL DE ARMAS");
    },
    pointToLayer: iconarmas,
    onEachFeature: detalle
});

function icondiversion(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/operativoCD.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
///////////////CENTROS DE DIVERSÍON
var operativoCDLayer = L.geoJson(null);
var operativoCD = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "CENTROS DE DIVERSÍON");
    },
    pointToLayer: icondiversion,
    onEachFeature: detalle
});

///////////////EMERGENCIA SANITARIA
function iconemer(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/marker-icon-yellow.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}

var operativoCVLayer = L.geoJson(null);
var operativoCV = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo == "EMERGENCIA SANITARIA");
    },
    pointToLayer: iconemer,
    onEachFeature: detalle
});

///////////////DEFAUL
function icondefault(feature, latlng) {
    return L.marker(latlng, {
        icon: L.icon({
            iconUrl: "img/marker-icon-2x-blue.png",
            iconSize: [26, 42],
            iconAnchor: [12, 42],
            popupAnchor: [1, -34],
            shadowSize: [42, 42]
        }),
        title: feature.properties.evento,
        riseOnHover: true
    });
}
var operativoDFLayer = L.geoJson(null);
var operativoDF = L.geoJson(operativos, {
    filter: function(feature, layer) {
        return (feature.properties.desctipo !== "EMERGENCIA SANITARIA" && feature.properties.desctipo !== "PERSONAS" && feature.properties.desctipo !== "MOTOS" && feature.properties.desctipo !== "TAXIS" && feature.properties.desctipo !== "CENTROS DE DIVERSÍON" && feature.properties.desctipo !== "CONTROL DE ARMAS" && feature.properties.desctipo !== "MICROTRÁFICO" && feature.properties.desctipo !== "MECÁNICAS" && feature.properties.desctipo !== "CACHINERÍAS" && feature.properties.desctipo !== "VEHÍCULOS");
    },
    pointToLayer: icondefault,
    onEachFeature: detalle
});
map = L.map("map", {
    zoom: 10,
    center: [-0.4494108397310957, -78.585734328125],
    layers: [cartoLight, markerClusters, highlight],
});


/////
///////CLUSTER AL SELECCIONAR
map.on("overlayadd", function(e) {
    if (e.layer === operativoVLayer) {
        markerClusters.addLayer(operativoV);
        syncSidebar()
    }
    if (e.layer === operativoCLayer) {
        markerClusters.addLayer(operativoC);
        syncSidebar()
    }
    if (e.layer === operativoCDLayer) {
        markerClusters.addLayer(operativoCD);
        syncSidebar()
    }
    if (e.layer === operativoCALayer) {
        markerClusters.addLayer(operativoCA);
        syncSidebar()
    }
    if (e.layer === operativoMELayer) {
        markerClusters.addLayer(operativoME);
        syncSidebar()
    }
    if (e.layer === operativoMILayer) {
        markerClusters.addLayer(operativoMI);
        syncSidebar()
    }
    if (e.layer === operativoMLayer) {
        markerClusters.addLayer(operativoM);
        syncSidebar()
    }
    if (e.layer === operativoPLayer) {
        markerClusters.addLayer(operativoP);
        syncSidebar()
    }
    if (e.layer === operativoTLayer) {
        markerClusters.addLayer(operativoT);
        syncSidebar()
    }
    if (e.layer === operativoDFLayer) {
        markerClusters.addLayer(operativoDF);
        syncSidebar()
    }
    if (e.layer === operativoDFLayer) {
        markerClusters.addLayer(operativoDF);
        syncSidebar()
    }
    if (e.layer === operativoCVLayer) {
        markerClusters.addLayer(operativoCV);
        syncSidebar()
    }
});
map.on("overlayremove", function(e) {
    if (e.layer === operativoVLayer) {
        markerClusters.removeLayer(operativoV);
        syncSidebar()
    }
    if (e.layer === operativoCLayer) {
        markerClusters.removeLayer(operativoC);
        syncSidebar()
    }
    if (e.layer === operativoCDLayer) {
        markerClusters.removeLayer(operativoCD);
        syncSidebar()
    }
    if (e.layer === operativoCALayer) {
        markerClusters.removeLayer(operativoCA);
        syncSidebar()
    }
    if (e.layer === operativoMELayer) {
        markerClusters.removeLayer(operativoME);
        syncSidebar()
    }
    if (e.layer === operativoMILayer) {
        markerClusters.removeLayer(operativoMI);
        syncSidebar()
    }
    if (e.layer === operativoMLayer) {
        markerClusters.removeLayer(operativoM);
        syncSidebar()
    }
    if (e.layer === operativoPLayer) {
        markerClusters.removeLayer(operativoP);
        syncSidebar()
    }
    if (e.layer === operativoTLayer) {
        markerClusters.removeLayer(operativoT);
        syncSidebar()
    }
    if (e.layer === operativoDFLayer) {
        markerClusters.removeLayer(operativoDF);
        syncSidebar()
    }
    if (e.layer === operativoCVLayer) {
        markerClusters.removeLayer(operativoCV);
        syncSidebar()
    }
});
map.on("moveend", function(e) {
    syncSidebar();
});
map.on("click", function(e) {
    highlight.clearLayers();
});
//////
if (operativoC.getLayers().length > 0) {
    markerClusters.addLayer(operativoC);
    map.addLayer(operativoCLayer);
    syncSidebar()
}
if (operativoCD.getLayers().length > 0) {
    markerClusters.addLayer(operativoCD);
    map.addLayer(operativoCDLayer);
    syncSidebar()
}
if (operativoCA.getLayers().length > 0) {
    markerClusters.addLayer(operativoCA);
    map.addLayer(operativoCALayer);
    syncSidebar()
}
if (operativoME.getLayers().length > 0) {
    markerClusters.addLayer(operativoME);
    map.addLayer(operativoMELayer);
    syncSidebar()
}
if (operativoMI.getLayers().length > 0) {
    markerClusters.addLayer(operativoMI);
    map.addLayer(operativoMILayer);
    syncSidebar()
}
if (operativoM.getLayers().length > 0) {
    markerClusters.addLayer(operativoM);
    map.addLayer(operativoMLayer);
    syncSidebar()
}
if (operativoP.getLayers().length > 0) {
    markerClusters.addLayer(operativoP);
    map.addLayer(operativoPLayer);
    syncSidebar()
}
if (operativoT.getLayers().length > 0) {
    markerClusters.addLayer(operativoT);
    map.addLayer(operativoTLayer);
    syncSidebar()
}
if (operativoV.getLayers().length > 0) {
    markerClusters.addLayer(operativoV);
    map.addLayer(operativoVLayer);
    syncSidebar()
}
if (operativoDF.getLayers().length > 0) {
    markerClusters.addLayer(operativoDF);
    map.addLayer(operativoDFLayer);
    syncSidebar()
}
if (operativoCV.getLayers().length > 0) {
    markerClusters.addLayer(operativoCV);
    map.addLayer(operativoCVLayer);
    syncSidebar()
}
///////////////GROUPLAYER
var groupedOverlays = {
    "<b style=color:rgb(220,31,37);>Tipos de Operativo</b> <br>": {
        "<div class='iconogroup'><img src='img/operativoC.png'  height='30'></div>(<span id='Cachinerías'></span>)&nbsp;<span class='nomgroup'>Cachinerías</span>": operativoCLayer,
        "<div class='iconogroup'><img src='img/operativoCD.png'  height='30'></div>(<span id='Diversión'></span>)&nbsp;<span class='nomgroup'>Centros de Diversión</span>": operativoCDLayer,
        "<div class='iconogroup'><img src='img/operativoCA.png' height='30'></div>(<span id='Armas'></span>)&nbsp;<span class='nomgroup'>Control de Armas</span>": operativoCALayer,
        "<div class='iconogroup'><img src='img/operativoME.png' height='30'></div>(<span id='Mecánicas'></span>)&nbsp;<span class='nomgroup'>Mecánicas</span>": operativoMELayer,
        "<div class='iconogroup'><img src='img/operativoMI.png' height='30'></div>(<span id='Microtráfico'></span>)&nbsp;<span class='nomgroup'>Microtráfico</span>": operativoMILayer,
        "<div class='iconogroup'><img src='img/operativoM.png' height='30'></div>(<span id='Motocicletas'></span>)&nbsp;<span class='nomgroup'>Motocicletas</span>": operativoMLayer,
        "<div class='iconogroup'><img src='img/operativoP.png' height='30'></div>(<span id='Personas'></span>)&nbsp;<span class='nomgroup'>Personas</span>": operativoPLayer,
        "<div class='iconogroup'><img src='img/operativoT.png' height='30'></div>(<span id='Taxis'></span>)&nbsp;<span class='nomgroup'>Taxis</span>": operativoTLayer,
        "<div class='iconogroup'><img src='img/operativoV.png' height='30'></div>(<span id='Vehículos'></span>)&nbsp;<span class='nomgroup'>Vehículos</span>": operativoVLayer,
        "<div class='iconogroup'><img src='img/marker-icon-yellow.png' height='30'></div>(<span id='Emergencia'></span>)&nbsp;<span class='nomgroup'>Emergencia Sanitaria</span>": operativoCVLayer,
        "<div class='iconogroup'><img src='img/marker-icon-2x-blue.png' height='30'></div>(<span id='Otros'></span>)&nbsp;<span class='nomgroup'>Otros</span>": operativoDFLayer
    }
};
///////CUENTA DE OPERATIVOS POR VARIABLE
$(function() {
    $('#Cachinerías').append(operativoC.getLayers().length);
    $('#Diversión').append(operativoCD.getLayers().length);
    $('#Armas').append(operativoCA.getLayers().length);
    $('#Mecánicas').append(operativoME.getLayers().length);
    $('#Microtráfico').append(operativoMI.getLayers().length);
    $('#Motocicletas').append(operativoM.getLayers().length);
    $('#Personas').append(operativoP.getLayers().length);
    $('#Taxis').append(operativoT.getLayers().length);
    $('#Vehículos').append(operativoV.getLayers().length);
    $('#Emergencia').append(operativoCV.getLayers().length);
    $('#Otros').append(operativoDF.getLayers().length);
});
//////////
////CUADRO SIDEBAR
/////////
var options = {
    exclusiveGroups: ["Tipos de Operativo"],
    groupCheckboxes: true,
    collapsed: false,
};
var sidebar = L.control.sidebar('sidebar').addTo(map);
////subimos a div groupedLayers
var panel = L.control.groupedLayers(null, groupedOverlays, options).addTo(map);
var htmlObject = panel.getContainer();
var a = document.getElementById('filtros')

function setParent(el, newParent) {
    newParent.appendChild(el);
}
setParent(htmlObject, a);
////QUITAR HIGTH
$("#featureModal").on("hidden.bs.modal", function(e) {
    $(document).on("mouseout", ".feature-row", clearHighlight);
});
//////////POSICION DEL ZOOM
map.zoomControl.setPosition('bottomright');
//////////LOCALIZACION
var locateControl = L.control.locate({
    position: "bottomright",
    drawCircle: true,
    follow: true,
    setView: true,
    keepCurrentZoomLevel: true,
    markerStyle: {
        weight: 1,
        opacity: 0.8,
        fillOpacity: 0.8
    },
    circleStyle: {
        weight: 1,
        clickable: false
    },
    icon: "fa fa-location-arrow",
    metric: true,
    strings: {
        title: "Mi ubicacion",
        popup: "Estás dentro de {distance} {unit} desde este punto",
        outsideMapBoundsMsg: "Pareces ubicado fuera de los límites del mapa"
    },
    locateOptions: {
        maxZoom: 18,
        watch: true,
        enableHighAccuracy: true,
        maximumAge: 10000,
        timeout: 10000
    }
}).addTo(map);
//////////BUSCAR
L.Control.geocoder({
    position: "bottomright"
}).addTo(map);
//////FUNCION MUESTRA DETALLE
function muestraResumen(a, b) {
    $('#feature-resumen').load('cargaResumen.php?idEv=' + a + '&tipT=' + b);
}
$(document).on("click", function(e) {
    var container = $("#feature-resumen");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        document.getElementById('feature-resumen').innerHTML = "";
    }
});
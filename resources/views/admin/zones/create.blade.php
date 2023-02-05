@extends('layouts.admin.dashboard')

@section('scripts-header')
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?libraries=geometry,drawing&key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap">
    </script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
@stop
@section('content')
    <div class="mb-2" align="right">
        <div class="mb-2" align="right">
            <a href="{{ route('admin.zones.geolocation') }}" class="btn btn-sm btn-dark">
                <i class="fa-solid fa-chevron-left me-2"></i>
                Voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        Detalhes da zona e entrega
                    </div>
                    <hr>
                    <div class="body">
                        <div class="form-group mt-2">
                            <label>Nome da zona de entrega:</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm"
                                placeholder="Nome:" value="{{ @$zone->name ?? old('name') }}" required minlength="5">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label>Informe a latitude do ponto central:</label>
                                    <input type="text" name="lat" id="lat" class="form-control form-control-sm"
                                        placeholder="-1.12345" value="" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label>Informe a longitude do ponto central:</label>
                                    <input type="text" name="lng" id="lng" class="form-control form-control-sm"
                                        placeholder="3.45654" value="" required />
                                </div>
                            </div>
                        </div>

                        <div class="top-section mt-2">
                            Tempo estimado para entrega
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label>Tempo inicial:</label>
                                    <input type="number" name="delivery_time_ini" id="delivery_time_ini"
                                        class="form-control form-control-sm" placeholder="40"
                                        value="{{ @$zone->delivery_time_ini ?? old('delivery_time_ini') }}" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <label>Tempo final:</label>
                                    <input type="number" name="delivery_time_end" id="delivery_time_end"
                                        class="form-control form-control-sm" placeholder="60"
                                        value="{{ @$zone->delivery_time_end ?? old('delivery_time_end') }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label>Unidade de medida do tempo:</label>
                                    <select class="form-select form-select-sm" name="time_type" id="time_type"
                                        aria-label="Default select example">
                                        <option selected disabled>Selecione uma opção</option>
                                        <option {{ @$zone->time_type == 1 ? 'selected' : '' }} value="1">Minutos
                                        </option>
                                        <option {{ @$zone->time_type == 2 ? 'selected' : '' }} value="2">Horas</option>
                                        <option {{ @$zone->time_type == 3 ? 'selected' : '' }} value="3">Dias</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label>Valor da entrega: <small class="text-danger">'caso seja grátis, deixe o campo vazio'
                                </small></label>
                            <input type="text" name="price" id="price" class="form-control form-control-sm"
                                onkeyup="Helper.prototype.formatCurrency(this)" value="{{ @$zone->price ?? old('price') }}"
                                required />
                        </div>

                        <div class="form-group mt-2">
                            <label>Grátis a partir de:
                                <small class="text-danger"> 'caso a entrega não seja grátis, ela passa a ser se o pedido
                                    atingir o valor
                                    informado abaixo' </small></label>
                            <input type="text" name="free_when" id="free_when" class="form-control form-control-sm"
                                onkeyup="Helper.prototype.formatCurrency(this)"
                                value="{{ @$zone->free_when ?? old('free_when') }}" required />
                        </div>

                        <div class="form-group mt-2">
                            <label>Status</label>
                            <select class="form-select form-select-sm" name="active" id="active"
                                aria-label="Default select example">
                                <option {{ @$zone->active == 1 ? 'selected' : '' }} value="1">Ativo</option>
                                <option {{ @$zone->active == 0 ? 'selected' : '' }} value="0">Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Desenhe a zona de entrega</div>
                    <hr>
                    <div class="body">
                        <div id="map"></div>
                    </div>
                    <div class="card-footer">
                        <div class="maps">
                            <button class="btn btn-sm btn-success" id="save-button">Salvar</button>
                            {{-- <button class="btn btn-sm btn-primary" id="edit-button">Edit Shape</button> --}}
                            <button class="btn btn-sm btn-danger" id="delete-button">Limpar seleção</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        var lat = -1.39874;
        var lng = -48.43870;
        const is_edit = "{{ $is_edit }}";
        var edit_coordinate = '{{ @$zone->coordinates }}';
        var map;
        var drawingManager;
        var selectedShape;
        var shapeExists = false;

        document.getElementById('lat').addEventListener('change', function() {
            lat = this.value;
            if (document.getElementById('lng').value) {
                lng = document.getElementById('lng').value;
            }

            map.setCenter({
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            });
        });

        document.getElementById('lng').addEventListener('change', function() {
            if (document.getElementById('lat').value) {
                lat = document.getElementById('lat').value;
            }
            
            lng = this.value;

            map.setCenter({
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            });
        });

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: lat,
                    lng: lng
                },
                zoom: 15
            });

            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon']
                },
                polygonOptions: {
                    editable: true
                }
            });


            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                if (event.type === 'polygon') {
                    var newShape = event.overlay;
                    newShape.type = event.type;

                    disabledDrawing()

                    google.maps.event.addListener(newShape, 'click', function() {
                        setSelection(newShape);
                    });
                    setSelection(newShape);
                    shapeExists = true;
                }
            });

            google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
            google.maps.event.addListener(map, 'click', clearSelection);

            document.getElementById('delete-button').addEventListener('click', deleteSelectedShape);
            document.getElementById('save-button').addEventListener('click', saveShape);

            if (is_edit == 'S') {
                const polygonCoords = [
                    @foreach ($zone->coordinates[0] as $coords)
                        {
                            lat: {{ $coords->getLat() }},
                            lng: {{ $coords->getLng() }}
                        },
                    @endforeach
                ];
                edit_coordinate = polygonCoords;
                shapeExists = true;
                setShapeFromDb();
            }
            // document.getElementById('edit-button').addEventListener('click', editShape);
        }

        function setShapeFromDb() {
            disabledDrawing()
            var polygon = new google.maps.Polygon({
                paths: edit_coordinate,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });

            polygon.setMap(map);

            setSelection(polygon);

            // Adicionando o listener de eventos "dragend" ao shape
            google.maps.event.addListener(polygon, 'dragend', function() {
                selectedShape = this;
            });

            // Adicionando o listener de eventos "click" ao shape
            google.maps.event.addListener(polygon, 'click', function() {
                setSelection(this);
            });

        }

        function disabledDrawing() {
            //desabilita a possibilidade de desenhar um poligono
            drawingManager.setOptions({
                drawingControlOptions: {
                    drawingModes: []
                }
            });
            drawingManager.setDrawingMode(null)
        }

        function setSelection(shape) {
            clearSelection();
            selectedShape = shape;
            shape.setEditable(true);
        }

        function clearSelection() {
            if (selectedShape) {
                selectedShape.setEditable(false);
                selectedShape = null;
            }
        }

        function deleteSelectedShape() {
            if (selectedShape) {
                selectedShape.setMap(null);
                shapeExists = false;
                drawingManager.setOptions({
                    drawingControlOptions: {
                        drawingModes: ['polygon']
                    }
                });
            }
        }

        function saveShape() {
            if (!selectedShape) {
                return Helper.prototype.showError('Desenhe no mapa a sua zona de entrega');
            }

            var vertices = selectedShape.getPath().getArray();
            var shapeCoords = [];
            for (var i = 0; i < vertices.length; i++) {
                var xy = vertices[i];
                shapeCoords.push({
                    lat: xy.lat(),
                    lng: xy.lng()
                });
            }

            const data = {
                _token: "{{ csrf_token() }}",
                coordinates: JSON.stringify(shapeCoords),
                name: $("#name").val(),
                delivery_time_ini: $("#delivery_time_ini").val(),
                delivery_time_end: $("#delivery_time_end").val(),
                time_type: $("#time_type").val(),
                active: $("#active").val(),
                type: 2, //coordenadas geograficas
                free: $("#price").val() ? 1 : 0,
                free_when: $("#free_when").val(),
                price: $("#price").val()
            }

            $("#save-button").html('Salvando <i class="fas fa-spinner fa-spin"></i>');
            $("#save-button").attr('disabled', 'disabled');
            $("#delete-butto").attr('disabled', 'disabled');

            // Envie os dados para o back-end via AJAX
            $.ajax({
                type: "{{ $method }}",
                url: "{{ $routeAction }}",
                data: data,
                success: function(data) {
                    console.log('Shape saved successfully');

                    $("#save-button").html('Salvar');
                    $("#save-button").attr('disabled', false);
                    $("#delete-butto").attr('disabled', false);

                    window.location.href = "{{ route('admin.zones.geolocation') }}"
                },
                error: function(res) {
                    console.log('Error saving shape: ' + res);

                    $("#save-button").html('Salvar');
                    $("#save-button").attr('disabled', false);
                    $("#delete-butto").attr('disabled', false);

                    let response = res.responseJSON;
                    let html = `${response.message}<br>`;
                    if (response.errors) {
                        Object.keys(response.errors).forEach(function(key, index) {
                            console.log(key, index);
                            html += `${key}</br>`
                        });
                    }
                    Helper.prototype.showError(html);
                }
            });
        }

        // function deleteShape() {
        //     if (selectedShape) {
        //         selectedShape.setMap(null);
        //         // Envie os dados para o back-end via AJAX
        //         $.ajax({
        //             type: 'DELETE',
        //             url: '/delete-shape/' + selectedShape.id,
        //             success: function(data) {
        //                 console.log('Shape deleted successfully');
        //             },
        //             error: function(error) {
        //                 console.log('Error deleting shape: ' + error);
        //             }
        //         });
        //     }
        // }
    </script>
@stop

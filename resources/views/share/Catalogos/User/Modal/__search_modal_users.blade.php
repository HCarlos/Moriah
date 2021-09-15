
            <div class="form-row has-error mb-1">
                <label for = "IdP" class="col-md-4 col-form-label">Id</label>
                <div class="col-md-8">
                    <input type="text" name="IdP" id="IdP" value="{{ old('IdP') }}" class="form-control" />
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "ap_paterno" class="col-md-4 col-form-label">Ap Paterno</label>
                <div class="col-md-8">
                    <input type="text" name="ap_paterno" id="ap_paterno" value="{{ old('ap_paterno') }}" class="form-control" />
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "ap_materno" class="col-md-4 col-form-label">Ap Materno</label>
                <div class="col-md-8">
                    <input type="text" name="ap_materno" id="ap_materno" value="{{ old('ap_materno') }}" class="form-control" />
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "nombre" class="col-md-4 col-form-label">Nombre</label>
                <div class="col-md-8">
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control" />
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "curp" class="col-md-4 col-form-label">CURP</label>
                <div class="col-md-8">
                    <input type="text" name="curp" id="curp" value="{{ old('curp') }}" class="form-control" />
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "curp10" class="col-md-4 col-form-label">CURP(10)</label>
                <div class="col-md-8">
                    <input type="text" name="curp10" id="curp10" value="{{ old('curp10') }}" class="form-control" />
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "fecha_inicial" class="col-md-4 col-form-label">FN Inicial</label>
                <div class="col-md-8">
                    <input type="date" name="fecha_inicial" id="fecha_inicial" value="{{ old('fecha_inicial') }}" class="form-control" data-toggle="tooltip" data-placement="right" title="Fecha de Nacimiento" />
                </div>
                <label for = "fecha_final" class="col-md-4 col-form-label">FN Final</label>
                <div class="col-md-8">
                    <input type="date" name="fecha_final" id="fecha_final" value="{{ old('fecha_final') }}" class="form-control" data-toggle="tooltip" data-placement="right" title="Fecha de Nacimiento"  />
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "role_id" class="col-md-4 col-form-label">Rol</label>
                <div class="col-md-8">
                    <select id="role_id" name="role_id" class="form-control role_id" size="1">
                        <option value="0" selected >Seleccione un Rol</option>
                        @foreach($Roles as $id => $valor)
                            <option value="{{ $id }}">{{ $valor }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row has-error mb-1">
                <label for = "user_id_anterior" class="col-md-4 col-form-label">Id Anterior</label>
                <div class="col-md-8">
                    <input type="text" name="user_id_anterior" id="user_id_anterior" value="{{ old('user_id_anterior') }}" class="form-control" />
                </div>
            </div>

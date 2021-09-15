<div class="form-group row">
    <label class="col-sm-2 col-form-label">Contraseña actual</label>
    <div class="col-sm-4">
        <input type="password" class="form-control " placeholder="Ingrese contraseña actual" name="password_actual" id="password_actual">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label">Nueva contraseña</label>
    <div class="col-sm-4">
        <input type="password" class="form-control " placeholder="Ingrese nueva contraseña" name="password" id="password" >
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label">Repetir nueva contraseña</label>
    <div class="col-sm-4">
        <input type="password" class="form-control " placeholder="Repetir nueva contraseña" name="password_confirmation" id="password_confirmation" >
    </div>
</div>

<input type="hidden" name="id" id="id" value="{{$User->id}}">


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

<input type="hidden" name="user_id" id="user_id" value="{{ $User->id }}" class="form-control" />

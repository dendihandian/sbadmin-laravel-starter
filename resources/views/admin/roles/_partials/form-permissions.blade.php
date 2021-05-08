@php
    $_role = $role ?? null;
    $_permissions = $permissions ?? collect([]);
    $_role_permission_ids = optional(optional(optional($_role)->permissions)->pluck('id'))->toArray() ?? [];
@endphp

<div class="row">
    <div class="form-group col-lg-12">
        <label>{{ __('Permissions') }}</label>

        @foreach ($_permissions->chunk(20) as $_permissions_chunk)
        <div class="col-lg-4">
            @foreach ($_permissions_chunk as $_permission)
            <div class="d-flex justify-content-start align-items-center">
                <input name="permissions[{{ $_permission->name}}]" type="checkbox" @if (in_array($_permission->id, $_role_permission_ids)) checked @endif @if ($readonly ?? false) disabled @endif /><span class="ml-2">{{ $_permission->display_name ?? $_permission->name }}</span>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
    <div class="form-group pl-2 d-flex">
        <div class="form-group w-100">
            <div class="row">
                {{-- text --}}
                <div class="col-4">
                    <p>#</p>
                    @foreach ($roleNames as $roleName)
                    @if (is_array($roleName))
                    <p class="text-capitalize">User Management</p>
                    <ul class="text-capitalize">

                        @foreach ($roleName as $userManagement)
                        <p class="text-capitalize">
                            {{$userManagement}} Management
                        </p>
                        @endforeach
                    </ul>
                    @else

                    <p class="text-capitalize">
                        {{$roleName}}
                    </p>
                    @endif
                    @endforeach

                </div>
                {{-- view --}}
                <div class="col-2">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>View</p>
                        <input type="checkbox" name="user-management-view" class="mt-2 mb-3" id="">
                        @foreach ($roleNames as $roleName)
                        @if (is_array($roleName))

                        @foreach ($roleName as $roleView)
                        <input type="checkbox" name="permission-{{$roleView}}-view" class="mt-2 mb-3 ml-5" id=""
                            @if($role->hasPermissionTo($roleView.'.view','web'))
                        checked
                        @endif>
                        @endforeach
                        @else
                        <input type="checkbox" name="permission-{{$roleName}}-view" class="mt-2 mb-3" id=""
                            @if($role->hasPermissionTo($roleName.'.view','web'))
                        checked
                        @endif>
                        @endif

                        @endforeach

                    </div>
                </div>
                {{-- create --}}
                <div class="col-2">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>Create</p>
                        <input type="checkbox" name="user-management-create" class="mt-2 mb-3" id="">
                        @foreach ($roleNames as $roleName)
                        @if (is_array($roleName))

                        @foreach ($roleName as $rolecreate)
                        <input type="checkbox" name="permission-{{$rolecreate}}-create" class="mt-2 mb-3 ml-5" id=""
                            @if($role->hasPermissionTo($rolecreate.'.create','web'))
                        checked
                        @endif>
                        @endforeach
                        @else
                        <input type="checkbox" name="permission-{{$roleName}}-create" class="mt-2 mb-3" id=""
                            @if($role->hasPermissionTo($roleName.'.create','web'))
                        checked
                        @endif>
                        @endif

                        @endforeach
                    </div>
                </div>
                {{-- update --}}
                <div class="col-2">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>Update</p>
                        <input type="checkbox" name="user-management-edit" class="mt-2 mb-3" id="">
                        @foreach ($roleNames as $roleName)
                        @if (is_array($roleName))

                        @foreach ($roleName as $roleEdit)
                        <input type="checkbox" name="permission-{{$roleEdit}}-edit" class="mt-2 mb-3 ml-5" id=""
                            @if($role->hasPermissionTo($roleEdit.'.edit','web'))
                        checked
                        @endif>
                        @endforeach
                        @else
                        <input type="checkbox" name="permission-{{$roleName}}-edit" class="mt-2 mb-3" id=""
                            @if($role->hasPermissionTo($roleName.'.edit','web'))
                        checked
                        @endif>
                        @endif

                        @endforeach
                    </div>
                </div>
                {{-- delete --}}
                <div class="col-2">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>Delete</p>
                        <input type="checkbox" name="user-management-delete" class="mt-2 mb-3" id="">
                        @foreach ($roleNames as $roleName)
                        @if (is_array($roleName))

                        @foreach ($roleName as $roledelete)
                        <input type="checkbox" name="permission-{{$roledelete}}-delete" class="mt-2 mb-3 ml-5" id=""
                            @if($role->hasPermissionTo($roledelete.'.delete','web'))
                        checked
                        @endif>
                        @endforeach
                        @else
                        <input type="checkbox" name="permission-{{$roleName}}-delete" class="mt-2 mb-3" id=""
                            @if($role->hasPermissionTo($roleName.'.delete','web'))
                        checked
                        @endif>
                        @endif

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


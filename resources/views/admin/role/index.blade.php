<x-admin>
    @section('title','Roles')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Roles</h3>
            <div class="card-tools">
                <a href="{{ route('admin.role.create') }}" class="btn btn-sm btn-primary">Add</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="roleTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.role.edit',encrypt($role->id)) }}" class="btn btn-sm btn-secondary">
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.role.destroy',encrypt($role->id)) }}" method="POST" onclick="confirm('Are you sure')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">
                {{ $roles->links('vendor.pagination.bootstrap-4') }}
                <!-- Utilisation du style de pagination Bootstrap 4 -->
            </div>
        </div>
    </div>
</x-admin>

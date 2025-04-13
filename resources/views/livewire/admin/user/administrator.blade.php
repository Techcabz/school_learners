<div class="table-responsived">
    <style>
        .bg-success,
        .btn-success {
            background: #3F8E4E !important;
        }
    </style>
    @include('livewire.admin.user.adminModal')
    <div class="table-responsive">
        <table id="datatable3" class="table table-bordered" width="100%">
            <thead class="thead-custom text-white">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>

                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($usersList as $list)
                    <tr>
                        <td>{{ $list->id }}</td>
                        <td>{{ $list->username }}</td>
                        <td>{{ $list->email }}</td>
                        <td><span
                                class="badge bg-{{ $list->user_status == 1 ? 'warning' : 'success' }} ">{{ $list->user_status == 1 ? 'Pending' : 'Granted' }}
                        </td>
                        <td>
                            {{ $list->created_at }}
                        </td>
                        <td>
                            <div class="dropdown d-flex justify-content-center">
                                <button class="btn btn-secondary btn-custom btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <div class="dropdown-item">
                                        <div class="d-flex align-items-center gap-3">
                                            <button data-bs-toggle="modal"
                                                wire:click="editLoginDetails({{ $list->id }})"
                                                data-bs-target="#adminEditModal" type="button"
                                                class="btn btn-sm btn-success">
                                                Edit
                                            </button>
                                            <button data-bs-toggle="modal" wire:click="userID({{ $list->id }})"
                                                data-bs-target="#adminDeleteModal" type="button"
                                                class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

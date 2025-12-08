<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Usuarios</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.role_management') }}" class="btn btn-purple me-2">
                            <i class="bi bi-bullseye"></i> Gestión de Roles
                        </a>
                    @endif
                </div>
                <div>
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Alta de Usuario</a>
                </div>
            </div>

            @include('components.alerts')

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($users as $user)
                    <div class="col">
                        <div class="card h-100 {{ $user->trashed() ? 'opacity-50' : '' }}">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}" class="rounded mb-3" style="width: 160px; height: 160px; object-fit: cover;">
                                <div class="fw-semibold text-body-emphasis">{{ $user->name }}</div>
                                <div class="small text-body-secondary mt-1">{{ $user->email }}</div>
                                <div class="mt-1">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">Administrador</span>
                                    @elseif($user->role === 'supervisor')
                                        <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">Supervisor</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Empleado</span>
                                    @endif
                                </div>
                                <div class="small text-body-secondary mt-1">{{ number_format($user->commission_percentage, 2) }}% comisión</div>
                                <div class="extra-small text-body-tertiary mt-1">ID: {{ $user->id }}</div>
                                <div class="extra-small text-body-tertiary mt-1">{{ $user->created_at->format('d/m/Y') }}</div>
                                <div class="mt-2">
                                    @if($user->trashed())
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">Inhabilitado</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Activo</span>
                                    @endif
                                </div>

                                <div class="mt-3 d-flex gap-2">
                                    @if(!$user->trashed())
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-success btn-sm">
                                            Editar
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Inhabilitar usuario?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Inhabilitar
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                Reactivar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

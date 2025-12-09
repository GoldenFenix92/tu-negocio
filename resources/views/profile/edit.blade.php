<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Perfil</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 800px;">
            <div class="d-flex flex-column gap-4">
                <div class="card">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

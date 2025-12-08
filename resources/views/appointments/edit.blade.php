<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            {{ __('Editar Cita') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid" style="max-width: 1200px;">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Detalles de la Cita') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('appointments.update', $appointment) }}" x-data="appointmentForm()" @submit.prevent="submitForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Client Selection -->
                                <div class="mb-3 position-relative">
                                    <x-input-label for="client_search" :value="__('Buscar Cliente')" />
                                    <input type="text" id="client_search" x-model="clientSearchTerm" @input.debounce.300ms="searchClients" class="form-control mt-1" placeholder="Escribe el nombre o email del cliente">
                                    <div x-show="clientSearchResults.length > 0" class="position-absolute z-3 bg-gray-800 border border-secondary rounded mt-1 w-100 overflow-auto" style="max-height: 15rem;">
                                        <template x-for="client in clientSearchResults" :key="client.id">
                                            <div @click="selectClient(client)" class="p-2 cursor-pointer border-bottom border-secondary" style="cursor: pointer;" x-text="client.name + ' ' + client.paternal_lastname + ' (' + client.email + ')'" onmouseover="this.style.backgroundColor='#374151'" onmouseout="this.style.backgroundColor=''"></div>
                                        </template>
                                    </div>
                                    <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                                </div>

                                <div x-show="selectedClient.id" class="mb-3">
                                    <div class="alert alert-success py-2">
                                        <p class="mb-1 small">Cliente Seleccionado: <strong x-text="selectedClient.name + ' ' + selectedClient.paternal_lastname"></strong></p>
                                        <p class="mb-1 small">Descuento: <span x-text="selectedClient.discount_percentage + '%'"></span></p>
                                        <input type="hidden" name="client_id" x-model="selectedClient.id">
                                        <button type="button" @click="clearClient()" class="btn btn-outline-danger btn-sm mt-1">Limpiar Cliente</button>
                                    </div>
                                </div>

                                <div x-show="!selectedClient.id" class="mb-3">
                                    <x-input-label for="guest_name" :value="__('Nombre del Invitado (si no es cliente registrado)')" />
                                    <x-text-input id="guest_name" class="mt-1" type="text" name="guest_name" x-model="guestName" />
                                    <x-input-error :messages="$errors->get('guest_name')" class="mt-2" />
                                </div>

                                <!-- Appointment Date and Time -->
                                <div class="mb-3">
                                    <x-input-label for="appointment_datetime" :value="__('Fecha y Hora de la Cita')" />
                                    <x-text-input id="appointment_datetime" class="mt-1" type="datetime-local" name="appointment_datetime" x-model="appointmentDatetime" required />
                                    <x-input-error :messages="$errors->get('appointment_datetime')" class="mt-2" />
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <x-input-label for="status" :value="__('Estado')" />
                                    <select id="status" name="status" x-model="status" class="form-select mt-1" required>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Anticipo">Anticipo</option>
                                        <option value="Pagado">Pagado</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>

                                <!-- Notes -->
                                <div class="mb-3">
                                    <x-input-label for="notes" :value="__('Comentarios Adicionales')" />
                                    <textarea id="notes" name="notes" x-model="notes" class="form-control mt-1" rows="3"></textarea>
                                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <!-- Item Selection (Products/Services) -->
                                <div class="mb-3 position-relative">
                                    <x-input-label for="item_search" :value="__('Buscar Productos o Servicios')" />
                                    <input type="text" id="item_search" x-model="itemSearchTerm" @input.debounce.300ms="searchItems" class="form-control mt-1" placeholder="Escribe el nombre del producto o servicio">
                                    <div x-show="itemSearchResults.length > 0" class="position-absolute z-3 bg-gray-800 border border-secondary rounded mt-1 w-100 overflow-auto" style="max-height: 15rem;">
                                        <template x-for="item in itemSearchResults" :key="item.id + item.type">
                                            <div @click="addItem(item)" class="p-2 cursor-pointer border-bottom border-secondary" style="cursor: pointer;" x-text="item.name + ' (' + item.type + ')'" onmouseover="this.style.backgroundColor='#374151'" onmouseout="this.style.backgroundColor=''"></div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Selected Items List -->
                                <div class="mb-3" x-show="selectedItems.length > 0">
                                    <label class="form-label">Items Seleccionados</label>
                                    <div class="card bg-gray-700">
                                        <div class="card-body p-3">
                                            <template x-for="(item, index) in selectedItems" :key="item.id + item.type + index">
                                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-secondary">
                                                    <div class="flex-fill">
                                                        <span x-text="item.name + ' (' + item.type + ')'"></span>
                                                        <input type="hidden" :name="`items[${index}][itemable_id]`" :value="item.id">
                                                        <input type="hidden" :name="`items[${index}][itemable_type]`" :value="item.type">
                                                        <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" @input="calculateTotal" min="1" class="form-control form-control-sm d-inline-block ms-2" style="width: 80px;">
                                                        x <span x-text="formatCurrency(item.price)"></span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="fw-medium" x-text="formatCurrency(item.quantity * item.price)"></span>
                                                        <button type="button" @click="removeItem(index)" class="btn btn-outline-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Cost Display -->
                                <div class="card bg-primary bg-opacity-25 border-primary mb-3">
                                    <div class="card-body text-end">
                                        <h4 class="mb-0">Total: <span x-text="formatCurrency(totalCost)"></span></h4>
                                        <input type="hidden" name="total" x-model="totalCost">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button type="submit">
                                {{ __('Actualizar Cita') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function appointmentForm() {
            return {
                clientSearchTerm: '',
                clientSearchResults: [],
                selectedClient: { id: null, name: '', paternal_lastname: '', discount_percentage: 0 },
                guestName: '',
                appointmentDatetime: '',
                itemSearchTerm: '',
                itemSearchResults: [],
                selectedItems: [],
                status: 'Pendiente',
                notes: '',
                totalCost: 0,

                // Initial data for editing
                appointment: @json($appointment),
                discountPercentage: @json($discountPercentage),

                init() {
                    this.$watch('selectedItems', () => this.calculateTotal());
                    this.$watch('selectedClient.discount_percentage', () => this.calculateTotal());

                    // Populate form fields with existing appointment data
                    if (this.appointment) {
                        if (this.appointment.client) {
                            this.selectedClient = {
                                id: this.appointment.client.id,
                                name: this.appointment.client.name,
                                paternal_lastname: this.appointment.client.paternal_lastname,
                                discount_percentage: this.discountPercentage,
                            };
                        } else if (this.appointment.guest_name) {
                            this.guestName = this.appointment.guest_name;
                        }
                        this.appointmentDatetime = this.appointment.appointment_datetime.substring(0, 16); // Format for datetime-local
                        this.status = this.appointment.status;
                        this.notes = this.appointment.notes;
                        this.totalCost = this.appointment.total;

                        // Populate selected items
                        this.selectedItems = this.appointment.items.map(item => ({
                            id: item.itemable.id,
                            name: item.itemable.name,
                            price: item.price,
                            type: item.itemable_type.split('\\').pop(), // Extract Product or Service
                            quantity: item.quantity,
                        }));
                        this.calculateTotal();
                    }
                },

                async searchClients() {
                    if (this.clientSearchTerm.length < 2) {
                        this.clientSearchResults = [];
                        return;
                    }
                    const response = await fetch(`{{ route('appointments.search_clients') }}?search=${this.clientSearchTerm}`);
                    this.clientSearchResults = await response.json();
                },

                selectClient(client) {
                    this.selectedClient = client;
                    this.clientSearchTerm = '';
                    this.clientSearchResults = [];
                    this.guestName = ''; // Clear guest name if client is selected
                },

                clearClient() {
                    this.selectedClient = { id: null, name: '', paternal_lastname: '', discount_percentage: 0 };
                    this.calculateTotal();
                },

                async searchItems() {
                    if (this.itemSearchTerm.length < 2) {
                        this.itemSearchResults = [];
                        return;
                    }
                    const response = await fetch(`{{ route('appointments.search_items') }}?search=${this.itemSearchTerm}`);
                    this.itemSearchResults = await response.json();
                },

                addItem(item) {
                    const existingItem = this.selectedItems.find(i => i.id === item.id && i.type === item.type);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        this.selectedItems.push({ ...item, quantity: 1 });
                    }
                    this.itemSearchTerm = '';
                    this.itemSearchResults = [];
                    this.calculateTotal();
                },

                removeItem(index) {
                    this.selectedItems.splice(index, 1);
                    this.calculateTotal();
                },

                calculateTotal() {
                    let subtotal = this.selectedItems.reduce((sum, item) => sum + (item.quantity * item.price), 0);
                    let discountAmount = 0;
                    if (this.selectedClient.id && this.selectedClient.discount_percentage > 0) {
                        discountAmount = subtotal * (this.selectedClient.discount_percentage / 100);
                    }
                    this.totalCost = subtotal - discountAmount;
                },

                formatCurrency(value) {
                    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
                },

                submitForm() {
                    // Ensure totalCost is updated before submission
                    this.calculateTotal();
                    this.$el.submit();
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
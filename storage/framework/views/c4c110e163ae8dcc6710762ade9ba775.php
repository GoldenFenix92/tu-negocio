<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="h4 mb-0 text-white">
            Configuración de Marca
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Form Column -->
                <div class="col-lg-7">
                    <div class="card shadow-sm mb-4" style="background-color: var(--color-secondary); border-color: var(--text-primary);">
                        <div class="card-body" style="color: var(--text-primary);">
                            <form method="POST" action="<?php echo e(route('settings.update')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>

                                <!-- General Information -->
                                <h3 class="h5 mb-4 border-bottom pb-2" style="border-color: var(--text-primary) !important;">Información General</h3>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="app_name" class="form-label">Nombre de la Tienda</label>
                                        <input id="app_name" class="form-control" type="text" name="app_name" value="<?php echo e($settings['app_name'] ?? config('app.name')); ?>" required style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="store_type" class="form-label">Tipo de Tienda</label>
                                        <select id="store_type" name="store_type" class="form-select" onchange="suggestFonts(this.value)" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                            <option value="general" <?php echo e(($settings['store_type'] ?? '') == 'general' ? 'selected' : ''); ?>>General</option>
                                            <option value="abarrotes" <?php echo e(($settings['store_type'] ?? '') == 'abarrotes' ? 'selected' : ''); ?>>Abarrotes</option>
                                            <option value="salon_belleza" <?php echo e(($settings['store_type'] ?? '') == 'salon_belleza' ? 'selected' : ''); ?>>Salón de Belleza</option>
                                            <option value="restaurante" <?php echo e(($settings['store_type'] ?? '') == 'restaurante' ? 'selected' : ''); ?>>Restaurante</option>
                                            <option value="ropa" <?php echo e(($settings['store_type'] ?? '') == 'ropa' ? 'selected' : ''); ?>>Tienda de Ropa</option>
                                            <option value="tecnologia" <?php echo e(($settings['store_type'] ?? '') == 'tecnologia' ? 'selected' : ''); ?>>Tecnología</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Dirección</label>
                                        <input id="address" class="form-control" type="text" name="address" value="<?php echo e($settings['address'] ?? ''); ?>" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input id="phone" class="form-control" type="text" name="phone" value="<?php echo e($settings['phone'] ?? ''); ?>" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email de Contacto</label>
                                        <input id="email" class="form-control" type="email" name="email" value="<?php echo e($settings['email'] ?? ''); ?>" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                    </div>
                                </div>

                                <!-- Branding -->
                                <h3 class="h5 mb-4 mt-5 border-bottom pb-2" style="border-color: var(--text-primary) !important;">Marca Visual</h3>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="logo" class="form-label">Logo</label>
                                        <input id="logo" type="file" name="logo" class="form-control" accept="image/*" onchange="handleLogoUpload(event)" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Sube tu logo para extraer colores automáticamente.</div>
                                        <?php if(isset($settings['logo'])): ?>
                                            <div class="mt-2">
                                                <img src="<?php echo e($settings['logo']); ?>" alt="Current Logo" class="img-fluid p-2 rounded" style="max-height: 80px; background-color: rgba(255,255,255,0.1);">
                                            </div>
                                        <?php endif; ?>
                                        <div id="logo-preview" class="mt-2 d-none">
                                            <img id="logo-preview-img" src="" alt="Logo Preview" class="img-fluid p-2 rounded" style="max-height: 80px; background-color: rgba(255,255,255,0.1);">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="favicon" class="form-label">Favicon (.ico)</label>
                                        <input id="favicon" type="file" name="favicon" class="form-control" accept=".ico,image/x-icon" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Icono para la pestaña del navegador.</div>
                                        <?php if(isset($settings['favicon'])): ?>
                                            <div class="mt-2">
                                                <img src="<?php echo e($settings['favicon']); ?>" alt="Current Favicon" class="img-fluid p-2 rounded" style="max-height: 32px; background-color: rgba(255,255,255,0.1);">
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="font_family" class="form-label">Tipografía</label>
                                        <select id="font_family" name="font_family" class="form-select" onchange="updatePreview()" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                            <option value="Inter" <?php echo e(($settings['font_family'] ?? '') == 'Inter' ? 'selected' : ''); ?>>Inter</option>
                                            <option value="Roboto" <?php echo e(($settings['font_family'] ?? '') == 'Roboto' ? 'selected' : ''); ?>>Roboto</option>
                                            <option value="Open Sans" <?php echo e(($settings['font_family'] ?? '') == 'Open Sans' ? 'selected' : ''); ?>>Open Sans</option>
                                            <option value="Lato" <?php echo e(($settings['font_family'] ?? '') == 'Lato' ? 'selected' : ''); ?>>Lato</option>
                                            <option value="Montserrat" <?php echo e(($settings['font_family'] ?? '') == 'Montserrat' ? 'selected' : ''); ?>>Montserrat</option>
                                            <option value="Playfair Display" <?php echo e(($settings['font_family'] ?? '') == 'Playfair Display' ? 'selected' : ''); ?>>Playfair Display</option>
                                            <option value="Merriweather" <?php echo e(($settings['font_family'] ?? '') == 'Merriweather' ? 'selected' : ''); ?>>Merriweather</option>
                                            <option value="Raleway" <?php echo e(($settings['font_family'] ?? '') == 'Raleway' ? 'selected' : ''); ?>>Raleway</option>
                                            <option value="Oswald" <?php echo e(($settings['font_family'] ?? '') == 'Oswald' ? 'selected' : ''); ?>>Oswald</option>
                                            <option value="Nunito" <?php echo e(($settings['font_family'] ?? '') == 'Nunito' ? 'selected' : ''); ?>>Nunito</option>
                                            <option value="Poppins" <?php echo e(($settings['font_family'] ?? '') == 'Poppins' ? 'selected' : ''); ?>>Poppins</option>
                                            <option value="Roboto Mono" <?php echo e(($settings['font_family'] ?? '') == 'Roboto Mono' ? 'selected' : ''); ?>>Roboto Mono</option>
                                            <option value="Fira Sans" <?php echo e(($settings['font_family'] ?? '') == 'Fira Sans' ? 'selected' : ''); ?>>Fira Sans</option>
                                            <option value="Segoe UI" <?php echo e(($settings['font_family'] ?? '') == 'Segoe UI' ? 'selected' : ''); ?>>Segoe UI</option>
                                        </select>
                                        <p id="font-suggestion" class="text-success small mt-1 d-none">Sugerencia basada en tipo de tienda</p>
                                    </div>
                                </div>

                                <!-- Colors -->
                                <div class="d-flex justify-content-between align-items-center mb-4 mt-5 border-bottom pb-2" style="border-color: var(--text-primary) !important;">
                                    <h3 class="h5 mb-0">Paleta de Colores</h3>
                                    <div id="palette-actions" style="display: none;">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-secondary" onclick="shuffleColors()" title="Aleatorio" style="color: var(--text-primary); border-color: var(--text-primary);">
                                                <i class="bi bi-shuffle"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="extractDarkColors()" title="Oscuros" style="color: var(--text-primary); border-color: var(--text-primary);">
                                                <i class="bi bi-moon-fill"></i> Oscuros
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="extractLightColors()" title="Claros" style="color: var(--text-primary); border-color: var(--text-primary);">
                                                <i class="bi bi-sun-fill"></i> Claros
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6 col-sm-6">
                                        <label for="primary_color" class="form-label">Color Primario</label>
                                        <div class="input-group">
                                            <input type="color" id="primary_color" name="primary_color" value="<?php echo e($settings['primary_color'] ?? '#3b82f6'); ?>" class="form-control form-control-color" title="Elige un color" oninput="updatePreview()">
                                            <input type="text" class="form-control" value="<?php echo e($settings['primary_color'] ?? '#3b82f6'); ?>" onchange="document.getElementById('primary_color').value = this.value; updatePreview();" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                        </div>
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Botones, Links, Elementos Activos</div>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-6">
                                        <label for="secondary_color" class="form-label">Color Secundario</label>
                                        <div class="input-group">
                                            <input type="color" id="secondary_color" name="secondary_color" value="<?php echo e($settings['secondary_color'] ?? '#1f2937'); ?>" class="form-control form-control-color" title="Elige un color" oninput="updatePreview()">
                                            <input type="text" class="form-control" value="<?php echo e($settings['secondary_color'] ?? '#1f2937'); ?>" onchange="document.getElementById('secondary_color').value = this.value; updatePreview();" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                        </div>
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Paneles, Tarjetas, Barras Laterales</div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <label for="background_color" class="form-label">Color de Fondo</label>
                                        <div class="input-group">
                                            <input type="color" id="background_color" name="background_color" value="<?php echo e($settings['background_color'] ?? '#111827'); ?>" class="form-control form-control-color" title="Elige un color" oninput="updatePreview()">
                                            <input type="text" class="form-control" value="<?php echo e($settings['background_color'] ?? '#111827'); ?>" onchange="document.getElementById('background_color').value = this.value; updatePreview();" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                        </div>
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Fondo General de la Aplicación</div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <label for="text_color" class="form-label">Color de Texto</label>
                                        <div class="input-group">
                                            <input type="color" id="text_color" name="text_color" value="<?php echo e($settings['text_color'] ?? '#d1d5db'); ?>" class="form-control form-control-color" title="Elige un color" oninput="updatePreview()">
                                            <input type="text" class="form-control" value="<?php echo e($settings['text_color'] ?? '#d1d5db'); ?>" onchange="document.getElementById('text_color').value = this.value; updatePreview();" style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--text-primary);">
                                        </div>
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Texto Principal</div>
                                    </div>
                                </div>

                                <!-- Visual Effects -->
                                <h3 class="h5 mb-4 mt-5 border-bottom pb-2" style="border-color: var(--text-primary) !important;">Efectos Visuales</h3>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label for="shadow_intensity" class="form-label">Intensidad de Sombras</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="range" id="shadow_intensity" name="shadow_intensity" 
                                                   class="form-range flex-grow-1" 
                                                   min="0.5" max="2" step="0.1" 
                                                   value="<?php echo e($settings['shadow_intensity'] ?? '1.0'); ?>"
                                                   oninput="updateShadowPreview()">
                                            <span id="shadow_intensity_value" class="badge bg-secondary" style="min-width: 50px; background-color: var(--color-primary) !important;">1.0x</span>
                                        </div>
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Controla el tamaño de las sombras</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="shadow_blur" class="form-label">Difuminación</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="range" id="shadow_blur" name="shadow_blur" 
                                                   class="form-range flex-grow-1" 
                                                   min="0" max="20" step="1" 
                                                   value="<?php echo e($settings['shadow_blur'] ?? '10'); ?>"
                                                   oninput="updateShadowPreview()">
                                            <span id="shadow_blur_value" class="badge bg-secondary" style="min-width: 50px; background-color: var(--color-primary) !important;">10px</span>
                                        </div>
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">Nivel de desenfoque de sombras</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="shadow_opacity" class="form-label">Opacidad de Sombras</label>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="range" id="shadow_opacity" name="shadow_opacity" 
                                                   class="form-range flex-grow-1" 
                                                   min="0.05" max="1" step="0.05" 
                                                   value="<?php echo e($settings['shadow_opacity'] ?? '0'); ?>"
                                                   oninput="updateShadowPreview()">
                                            <span id="shadow_opacity_value" class="badge bg-secondary" style="min-width: 50px; background-color: var(--color-primary) !important;">Auto</span>
                                        </div>
                                        <div class="form-text text-muted" style="color: var(--text-primary) !important; opacity: 0.7;">0 = Automático según tema</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Preview Column -->
                <div class="col-lg-5">
                    <div class="sticky-top" style="top: 20px; z-index: 1;">
                        <h4 class="h5 mb-3 text-white">Vista Previa en Vivo</h4>
                        
                        <!-- Preview Container -->
                        <div id="preview-container" class="rounded shadow-lg overflow-hidden border" style="border-color: #4b5563;">
                            
                            <!-- Mock Header -->
                            <div id="preview-header" class="p-3 d-flex justify-content-between align-items-center" style="background-color: var(--color-secondary); border-bottom: 1px solid var(--text-primary);">
                                <div class="d-flex align-items-center gap-2">
                                    <div id="preview-logo-placeholder" class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; overflow: hidden;">
                                        <img id="preview-logo-img" src="<?php echo e($settings['logo'] ?? asset('images/brand-logo.png')); ?>" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <span id="preview-app-name" class="fw-bold" style="color: var(--text-primary);"><?php echo e($settings['app_name'] ?? config('app.name')); ?></span>
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="rounded-circle" style="width: 24px; height: 24px; background-color: var(--text-primary); opacity: 0.5;"></div>
                                    <div class="rounded-circle" style="width: 24px; height: 24px; background-color: var(--text-primary); opacity: 0.5;"></div>
                                </div>
                            </div>

                            <!-- Mock Body -->
                            <div id="preview-body" class="p-4" style="background-color: var(--bg-primary); min-height: 400px;">
                                <ul class="nav nav-tabs mb-3" id="previewTabs" role="tablist" style="border-bottom-color: var(--text-muted);">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#preview-dashboard" type="button" role="tab" style="color: var(--text-primary); background: transparent; border: none; border-bottom: 2px solid var(--color-primary);">Dashboard</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tables-tab" data-bs-toggle="tab" data-bs-target="#preview-tables" type="button" role="tab" style="color: var(--text-muted); background: transparent; border: none;">Tablas</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="forms-tab" data-bs-toggle="tab" data-bs-target="#preview-forms" type="button" role="tab" style="color: var(--text-muted); background: transparent; border: none;">Formularios</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="typo-tab" data-bs-toggle="tab" data-bs-target="#preview-typo" type="button" role="tab" style="color: var(--text-muted); background: transparent; border: none;">Tipografía</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="previewTabContent">
                                    <!-- Dashboard Preview -->
                                    <div class="tab-pane fade show active" id="preview-dashboard" role="tabpanel">
                                        <h5 class="mb-3" style="color: var(--text-primary);">Resumen</h5>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="p-3 rounded" style="background-color: var(--color-secondary); border: 1px solid var(--text-muted);">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span style="color: var(--text-secondary);">Ventas de Hoy</span>
                                                        <span style="color: var(--color-primary);">
                                                            <i class="bi bi-graph-up"></i>
                                                        </span>
                                                    </div>
                                                    <h3 class="fw-bold mb-0" style="color: var(--text-primary);">$1,250.00</h3>
                                                    <small style="color: var(--text-muted);">+15% vs ayer</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 rounded text-center" style="background-color: var(--color-secondary); border: 1px solid var(--text-muted);">
                                                    <div class="mb-2" style="color: var(--text-primary);">Productos</div>
                                                    <button class="btn btn-sm w-100" style="background-color: var(--color-primary); color: #fff; border: none;">Ver</button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 rounded text-center" style="background-color: var(--color-secondary); border: 1px solid var(--text-muted);">
                                                    <div class="mb-2" style="color: var(--text-primary);">Clientes</div>
                                                    <button class="btn btn-sm w-100" style="background-color: transparent; border: 1px solid var(--color-primary); color: var(--color-primary);">Nuevo</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tables Preview -->
                                    <div class="tab-pane fade" id="preview-tables" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table" style="color: var(--text-primary); border-color: var(--text-muted);">
                                                <thead>
                                                    <tr style="border-bottom: 2px solid var(--text-primary);">
                                                        <th style="background-color: var(--color-secondary); color: var(--text-primary);">ID</th>
                                                        <th style="background-color: var(--color-secondary); color: var(--text-primary);">Nombre</th>
                                                        <th style="background-color: var(--color-secondary); color: var(--text-primary);">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-bottom: 1px solid var(--text-muted);">
                                                        <td>#101</td>
                                                        <td>Producto A</td>
                                                        <td><span class="badge" style="background-color: var(--color-primary); color: #fff;">Activo</span></td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid var(--text-muted);">
                                                        <td>#102</td>
                                                        <td>Producto B</td>
                                                        <td><span class="badge bg-secondary" style="opacity: 0.8;">Inactivo</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Forms Preview -->
                                    <div class="tab-pane fade" id="preview-forms" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label" style="color: var(--text-primary);">Email</label>
                                            <input type="email" class="form-control" placeholder="nombre@ejemplo.com" style="background-color: var(--color-secondary); color: var(--text-primary); border: 1px solid var(--text-muted);">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" style="color: var(--text-primary);">Rol</label>
                                            <select class="form-select" style="background-color: var(--color-secondary); color: var(--text-primary); border: 1px solid var(--text-muted);">
                                                <option>Administrador</option>
                                                <option>Usuario</option>
                                            </select>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked style="background-color: var(--color-primary); border-color: var(--color-primary);">
                                            <label class="form-check-label" style="color: var(--text-secondary);">
                                                Notificaciones activas
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Typography & Buttons Preview -->
                                    <div class="tab-pane fade" id="preview-typo" role="tabpanel">
                                        <h1 style="color: var(--text-primary);">Encabezado H1</h1>
                                        <h3 style="color: var(--text-primary);">Encabezado H3</h3>
                                        <p style="color: var(--text-secondary);">Este es un párrafo de texto secundario que debe ser legible pero menos prominente.</p>
                                        <p style="color: var(--text-muted); font-size: 0.875rem;">Este es texto "muted" o deshabilitado, debe ser visible.</p>
                                        
                                        <div class="d-flex gap-2 mt-3">
                                            <button class="btn" style="background-color: var(--color-primary); color: #fff;">Primario</button>
                                            <button class="btn" style="background-color: transparent; border: 1px solid var(--text-muted); color: var(--text-primary);">Secundario</button>
                                            <button class="btn btn-danger">Peligro</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted small mt-2">Esta es una vista previa aproximada. Algunos elementos pueden variar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script>
        // Initial preview update
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize shadow slider displays
            if (document.getElementById('shadow_intensity')) {
                const intensity = parseFloat(document.getElementById('shadow_intensity').value);
                const blur = parseInt(document.getElementById('shadow_blur').value);
                const opacity = parseFloat(document.getElementById('shadow_opacity').value);
                
                document.getElementById('shadow_intensity_value').textContent = intensity.toFixed(1) + 'x';
                document.getElementById('shadow_blur_value').textContent = blur + 'px';
                document.getElementById('shadow_opacity_value').textContent = opacity === 0 ? 'Auto' : Math.round(opacity * 100) + '%';
            }
            
            updatePreview();
        });

        function updatePreview() {
            const primary = document.getElementById('primary_color').value;
            const secondary = document.getElementById('secondary_color').value;
            const background = document.getElementById('background_color').value;
            const text = document.getElementById('text_color').value;
            const font = document.getElementById('font_family').value;
            const appName = document.getElementById('app_name').value;

            const container = document.getElementById('preview-container');
            
            // Load Font Dynamically
            const fontLink = document.getElementById('dynamic-font-link') || document.createElement('link');
            fontLink.id = 'dynamic-font-link';
            fontLink.rel = 'stylesheet';
            fontLink.href = `https://fonts.googleapis.com/css2?family=${font.replace(/ /g, '+')}:wght@400;600;700&display=swap`;
            document.head.appendChild(fontLink);

            // Calculate brightness for shadow adaptation
            const bgR = parseInt(background.substr(1, 2), 16);
            const bgG = parseInt(background.substr(3, 2), 16);
            const bgB = parseInt(background.substr(5, 2), 16);
            const brightness = (bgR * 299 + bgG * 587 + bgB * 114) / 1000;
            const isDark = brightness < 128;
            
            // Get shadow configuration from sliders
            const shadowIntensity = parseFloat(document.getElementById('shadow_intensity')?.value || 1.0);
            const shadowBlur = parseInt(document.getElementById('shadow_blur')?.value || 10);
            const shadowOpacityInput = parseFloat(document.getElementById('shadow_opacity')?.value || 0);
            
            // Shadow variables based on theme (auto if 0)
            const shadowColorRgb = '0, 0, 0';
            const shadowOpacity = shadowOpacityInput === 0 ? (isDark ? 0.5 : 0.15) : shadowOpacityInput;
            
            // Update CSS variables for the preview container
            container.style.setProperty('--color-primary', primary);
            container.style.setProperty('--color-secondary', secondary);
            container.style.setProperty('--bg-primary', background);
            container.style.setProperty('--text-primary', text);
            container.style.setProperty('--font-family', font);
            
            // Calculate and set RGB for primary color (for glow effects)
            const r = parseInt(primary.substr(1, 2), 16);
            const g = parseInt(primary.substr(3, 2), 16);
            const b = parseInt(primary.substr(5, 2), 16);
            container.style.setProperty('--color-primary-rgb', `${r}, ${g}, ${b}`);
            
            // Set shadow variables with configurable values
            container.style.setProperty('--shadow-color-rgb', shadowColorRgb);
            container.style.setProperty('--shadow-opacity', shadowOpacity);
            container.style.setProperty('--shadow-intensity', shadowIntensity);
            container.style.setProperty('--shadow-blur-base', `${shadowBlur}px`);
            
            // Calculate shadows with intensity and blur multipliers
            const sm1 = Math.round(1 * shadowIntensity);
            const sm2 = Math.round(2 * shadowIntensity);
            const sm3 = Math.round(3 * shadowIntensity);
            const blur1 = Math.round(shadowBlur * 0.3);
            const blur2 = Math.round(shadowBlur * 0.5);
            const blur3 = Math.round(shadowBlur * 1.0);
            const blur4 = Math.round(shadowBlur * 1.5);
            
            container.style.setProperty('--shadow-sm', `0 ${sm1}px ${blur1}px 0 rgba(${shadowColorRgb}, ${shadowOpacity * 0.3}), 0 ${sm1}px ${blur2}px 0 rgba(${shadowColorRgb}, ${shadowOpacity * 0.2})`);
            container.style.setProperty('--shadow-md', `0 ${Math.round(4 * shadowIntensity)}px ${blur2}px -1px rgba(${shadowColorRgb}, ${shadowOpacity * 0.5}), 0 ${sm2}px ${blur1}px -2px rgba(${shadowColorRgb}, ${shadowOpacity * 0.3})`);
            container.style.setProperty('--shadow-lg', `0 ${Math.round(10 * shadowIntensity)}px ${blur3}px -3px rgba(${shadowColorRgb}, ${shadowOpacity * 0.6}), 0 ${Math.round(4 * shadowIntensity)}px ${blur2}px -4px rgba(${shadowColorRgb}, ${shadowOpacity * 0.4})`);
            
            // Set glow variables
            container.style.setProperty('--glow-primary-sm', `0 0 0 1px rgba(${r}, ${g}, ${b}, 0.1), 0 0 ${blur1}px 0 rgba(${r}, ${g}, ${b}, 0.1)`);
            container.style.setProperty('--glow-primary-md', `0 0 0 1px rgba(${r}, ${g}, ${b}, 0.3), 0 0 ${blur3}px 0 rgba(${r}, ${g}, ${b}, 0.2)`);
            
            // Border color
            container.style.setProperty('--border-color', `color-mix(in srgb, ${text}, transparent 70%)`);
            
            // Derived text colors
            container.style.setProperty('--text-secondary', `color-mix(in srgb, ${text}, transparent 30%)`);
            container.style.setProperty('--text-muted', `color-mix(in srgb, ${text}, transparent 50%)`);

            // Update specific elements
            document.getElementById('preview-app-name').textContent = appName;
            document.getElementById('preview-body').style.fontFamily = font;
        }

        function updateShadowPreview() {
            // Update value displays
            const intensity = parseFloat(document.getElementById('shadow_intensity').value);
            const blur = parseInt(document.getElementById('shadow_blur').value);
            const opacity = parseFloat(document.getElementById('shadow_opacity').value);
            
            document.getElementById('shadow_intensity_value').textContent = intensity.toFixed(1) + 'x';
            document.getElementById('shadow_blur_value').textContent = blur + 'px';
            document.getElementById('shadow_opacity_value').textContent = opacity === 0 ? 'Auto' : Math.round(opacity * 100) + '%';
            
            // Update the preview
            updatePreview();
        }

        function handleLogoUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    // Update preview logo
                    const previewImg = document.getElementById('logo-preview-img');
                    previewImg.src = img.src;
                    document.getElementById('logo-preview').classList.remove('d-none');
                    document.getElementById('preview-logo-img').src = img.src;
                    
                    // Extract colors
                    extractColors(img);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        let extractedPalette = [];

        function extractColors(img) {
            const colorThief = new ColorThief();
            // Get palette of 10 colors for more variety
            const palette = colorThief.getPalette(img, 10);
            
            if (palette && palette.length >= 4) {
                // Convert RGB arrays to Hex
                extractedPalette = palette.map(rgb => rgbToHex(rgb[0], rgb[1], rgb[2]));
                
                // Show palette actions
                document.getElementById('palette-actions').style.display = 'block';
                
                // Initial assignment (smart default)
                assignColorsSmartly();
            }
        }

        function extractDarkColors() {
            if (extractedPalette.length === 0) return;
            
            // Filter for darker colors (brightness < 128)
            const darkColors = extractedPalette.filter(c => getBrightness(c) < 100);
            
            // If not enough dark colors, take the darkest from the full palette
            const pool = darkColors.length >= 3 ? darkColors : [...extractedPalette].sort((a, b) => getBrightness(a) - getBrightness(b)).slice(0, 5);
            
            // Shuffle pool
            const shuffled = pool.sort(() => 0.5 - Math.random());
            
            let background = shuffled[0];
            let secondary = shuffled[1] || background;
            // Primary should be vibrant, maybe from the full palette if pool is too dark
            let primary = extractedPalette.find(c => getBrightness(c) > 100) || shuffled[2] || '#3b82f6';
            
            // Ensure distinctness
            if (secondary === background) secondary = softenColor(background, -0.1); // Darken/lighten

            const text = getContrastColor(background);

            setInputValue('background_color', background);
            setInputValue('secondary_color', secondary);
            setInputValue('primary_color', primary);
            setInputValue('text_color', text);
            updatePreview();
        }

        function extractLightColors() {
            if (extractedPalette.length === 0) return;
            
            // Filter for lighter colors
            const lightColors = extractedPalette.filter(c => getBrightness(c) > 150);
            
            // If not enough light colors, take the lightest
            const pool = lightColors.length >= 3 ? lightColors : [...extractedPalette].sort((a, b) => getBrightness(b) - getBrightness(a)).slice(0, 5);
            
            // Shuffle pool
            const shuffled = pool.sort(() => 0.5 - Math.random());
            
            let background = shuffled[0];
            let secondary = shuffled[1] || background;
            // Primary should be vibrant/darker for contrast on light bg
            let primary = extractedPalette.find(c => getBrightness(c) < 150) || shuffled[2] || '#3b82f6';
            
            if (secondary === background) secondary = softenColor(background, 0.1);

            const text = getContrastColor(background);

            setInputValue('background_color', background);
            setInputValue('secondary_color', secondary);
            setInputValue('primary_color', primary);
            setInputValue('text_color', text);
            updatePreview();
        }

        function assignColorsSmartly() {
            const colors = [...extractedPalette];
            const sortedByBrightness = [...colors].sort((a, b) => getBrightness(a) - getBrightness(b));
            
            // Default logic
            let background = sortedByBrightness[0]; 
            background = softenColor(background, 0.2);

            let secondary = sortedByBrightness[1];
            secondary = softenColor(secondary, 0.1);

            let primary = colors.find(c => c !== background && c !== secondary) || colors[2];
            primary = softenColor(primary, 0);
            
            const text = getContrastColor(background);

            setInputValue('background_color', background);
            setInputValue('secondary_color', secondary);
            setInputValue('primary_color', primary);
            setInputValue('text_color', text);
            updatePreview();
        }

        function shuffleColors() {
            if (extractedPalette.length < 3) return;
            
            const colors = [...extractedPalette];
            
            // Randomly pick background from the darker half of the palette (to ensure usability)
            // or just random? Let's try random but bias towards dark for background if we want "dark mode" feel,
            // but user might want light mode. Let's just pick 3 distinct random colors.
            
            // Shuffle array
            for (let i = colors.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [colors[i], colors[j]] = [colors[j], colors[i]];
            }

            let background = colors[0];
            let secondary = colors[1];
            let primary = colors[2];

            // Ensure contrast for text
            let text = getContrastColor(background);
            
            // Soften them a bit
            background = softenColor(background, 0.1);
            secondary = softenColor(secondary, 0.1);
            primary = softenColor(primary, 0);

            setInputValue('background_color', background);
            setInputValue('secondary_color', secondary);
            setInputValue('primary_color', primary);
            setInputValue('text_color', text);
            updatePreview();
        }

        function softenColor(hex, desaturateAmount) {
             // Simple placeholder for softening logic. 
             // In a real app, we'd convert to HSL, reduce S, maybe adjust L.
             // For now, let's just return the hex as we don't have a full color lib here.
             // But we can ensure it's not pure black/white if it was.
             if (hex === '#000000') return '#111827';
             if (hex === '#ffffff') return '#f3f4f6';
             return hex;
        }

        function setInputValue(id, value) {
            const input = document.getElementById(id);
            const textInput = input.nextElementSibling; // The text input next to color picker
            input.value = value;
            if (textInput && textInput.type === 'text') {
                textInput.value = value;
            }
        }

        function rgbToHex(r, g, b) {
            return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
        }

        function getBrightness(hex) {
            const r = parseInt(hex.substr(1, 2), 16);
            const g = parseInt(hex.substr(3, 2), 16);
            const b = parseInt(hex.substr(5, 2), 16);
            return (r * 299 + g * 587 + b * 114) / 1000;
        }

        function getContrastColor(hex) {
            // Return off-white or off-black for softer look
            return getBrightness(hex) > 128 ? '#1f2937' : '#f3f4f6';
        }

        function suggestFonts(type) {
            fetch(`<?php echo e(route("settings.suggest_fonts")); ?>?type=${type}`)
                .then(response => response.json())
                .then(fonts => {
                    const select = document.getElementById('font_family');
                    if (fonts.length > 0) {
                        // Ensure the suggested font exists in the select
                        const font = fonts[0];
                        let option = Array.from(select.options).find(opt => opt.value === font);
                        if (!option) {
                            option = new Option(font, font);
                            select.add(option);
                        }
                        select.value = font;
                        document.getElementById('font-suggestion').classList.remove('d-none');
                        document.getElementById('font-suggestion').innerText = `Sugerencia: ${fonts.join(', ')}`;
                        updatePreview();
                    }
                });
        }
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/settings/index.blade.php ENDPATH**/ ?>
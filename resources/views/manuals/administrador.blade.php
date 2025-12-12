<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-semibold fs-4 text-white m-0">
                <i class="bi bi-shield-lock"></i> Manual de Administrador
            </h2>
            <a href="{{ route('manual.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="card position-sticky" style="top: 1rem;">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">Contenido</h5>
                            <nav class="nav flex-column">
                                <a class="nav-link" href="#intro">Introducción</a>
                                <a class="nav-link" href="#usuarios">Gestión de Usuarios</a>
                                <a class="nav-link" href="#marca">Configuración de Marca</a>
                                <a class="nav-link" href="#database">Base de Datos</a>
                                <a class="nav-link" href="#cupones">Gestión de Cupones</a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <!-- Introducción -->
                    <div class="card mb-4" id="intro">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-info-circle text-danger"></i> Introducción</h3>
                            <p>Como administrador, tienes control total del sistema. Puedes gestionar usuarios, personalizar la apariencia, configurar backups y administrar todas las funciones avanzadas.</p>
                            <div class="alert alert-warning">
                                <strong><i class="bi bi-exclamation-triangle"></i> Precaución:</strong> Ten cuidado al modificar configuraciones críticas como la base de datos.
                            </div>
                            <div class="alert alert-info">
                                <strong><i class="bi bi-book"></i> Nota:</strong> Consulta también los manuales de <a href="{{ route('manual.show', 'usuario') }}">Usuario</a> y <a href="{{ route('manual.show', 'supervisor') }}">Supervisor</a>.
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Usuarios -->
                    <div class="card mb-4" id="usuarios">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-people text-danger"></i> Gestión de Usuarios</h3>
                            
                            <h5 class="fw-semibold mt-4">Crear Nuevos Usuarios</h5>
                            <ol>
                                <li>Ve a <strong>Administración → Gestión de Usuarios</strong></li>
                                <li>Haz clic en "Nuevo Usuario"</li>
                                <li>Completa la información:
                                    <ul>
                                        <li>Nombre</li>
                                        <li>Correo electrónico</li>
                                        <li>Contraseña</li>
                                        <li>Rol (Admin, Supervisor, Empleado)</li>
                                    </ul>
                                </li>
                                <li>Agrega foto de perfil (opcional)</li>
                                <li>Guarda el usuario</li>
                            </ol>

                            <h5 class="fw-semibold mt-4">Roles y Permisos</h5>
                            <ul>
                                <li><strong>Administrador:</strong> Acceso completo a todas las funciones</li>
                                <li><strong>Supervisor:</strong> Gestión de inventario, clientes, proveedores y reportes</li>
                                <li><strong>Empleado/Usuario:</strong> Acceso a POS, ventas y control de caja personal</li>
                            </ul>

                            <h5 class="fw-semibold mt-4">Editar y Eliminar Usuarios</h5>
                            <ol>
                                <li>Busca el usuario en la lista</li>
                                <li>Haz clic en el botón de edición</li>
                                <li>Modifica la información necesaria</li>
                                <li>Para eliminar, usa la opción de eliminación (soft delete)</li>
                                <li>Los usuarios eliminados pueden restaurarse</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Configuración de Marca -->
                    <div class="card mb-4" id="marca">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-palette text-danger"></i> Configuración de Marca</h3>
                            <p>Personaliza la apariencia del sistema:</p>

                            <h5 class="fw-semibold mt-4">Colores del Tema</h5>
                            <ol>
                                <li>Ve a <strong>Configuración de Marca</strong></li>
                                <li>En "Paleta de Colores":
                                    <ul>
                                        <li><strong>Color Primario:</strong> Botones, enlaces, sidebar activo</li>
                                        <li><strong>Color Secundario:</strong> Fondo de tarjetas y sidebar</li>
                                        <li><strong>Fondo Principal:</strong> Fondo de la aplicación</li>
                                        <li><strong>Color de Texto:</strong> Texto principal</li>
                                    </ul>
                                </li>
                                <li>Usa los botones de colores preestablecidos o el selector personalizado</li>
                                <li>Los cambios se reflejan en la vista previa en tiempo real</li>
                            </ol>

                            <h5 class="fw-semibold mt-4">Tipografía</h5>
                            <p>Selecciona la fuente del sistema:</p>
                            <ul>
                                <li>Elige entre más de 20 fuentes de Google Fonts</li>
                                <li>La fuente se aplica a toda la interfaz</li>
                                <li>Opciones populares: Inter, Poppins, Roboto, Montserrat</li>
                            </ul>

                            <h5 class="fw-semibold mt-4">Efectos Visuales</h5>
                            <p>Configura sombras y efectos:</p>
                            <ul>
                                <li><strong>Intensidad de Sombras:</strong> Qué tan pronunciadas son las sombras</li>
                                <li><strong>Difuminación:</strong> Suavidad de las sombras</li>
                                <li><strong>Opacidad:</strong> Transparencia de las sombras (0 = automático)</li>
                            </ul>

                            <h5 class="fw-semibold mt-4">Identidad Visual</h5>
                            <ol>
                                <li>Sube tu logo (se muestra en sidebar, tickets y reportes)</li>
                                <li>Sube tu favicon (ícono del navegador)</li>
                                <li>Los cambios se aplican inmediatamente en toda la app</li>
                            </ol>

                            <div class="alert alert-success">
                                <strong><i class="bi bi-lightbulb"></i> Consejo:</strong> Guarda combinaciones exitosas como "Presets" para aplicarlas rápidamente.
                            </div>
                        </div>
                    </div>

                    <!-- Base de Datos -->
                    <div class="card mb-4" id="database">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-database text-danger"></i> Gestión de Base de Datos</h3>
                            
                            <h5 class="fw-semibold mt-4">Backups Automáticos</h5>
                            <p>El sistema crea backups automáticos diariamente. Para configurar:</p>
                            <ul>
                                <li>Los backups se guardan en <code>storage/app/backups</code></li>
                                <li>Se mantienen los últimos 7 backups automáticos</li>
                                <li>Incluyen toda la estructura y datos de la BD</li>
                            </ul>

                            <h5 class="fw-semibold mt-4">Crear Backup Manual</h5>
                            <ol>
                                <li>Ve a <strong>Base de Datos → Crear Backup</strong></li>
                                <li>Haz clic en "Crear Backup Ahora"</li>
                                <li>El sistema genera un archivo SQL</li>
                                <li>Descarga el archivo para guardarlo externamente</li>
                            </ol>

                            <div class="alert alert-warning">
                                <strong><i class="bi bi-exclamation-triangle"></i> Importante:</strong> Siempre crea un backup manual antes de realizar cambios importantes.
                            </div>

                            <h5 class="fw-semibold mt-4">Restaurar Backup</h5>
                            <ol>
                                <li>Ve a <strong>Base de Datos → Restaurar</strong></li>
                                <li>Selecciona un backup del servidor o sube uno externo</li>
                                <li>Previsualiza el contenido del backup</li>
                                <li>Confirma la restauración</li>
                                <li>El sistema sobrescribirá los datos actuales</li>
                            </ol>

                            <h5 class="fw-semibold mt-4">Importar/Exportar CSV</h5>
                            <p>Para migrar datos de otras aplicaciones:</p>
                            <ul>
                                <li><strong>Exportar:</strong> Descarga datos en formato CSV</li>
                                <li><strong>Importar:</strong> Sube archivos CSV con formato específico</li>
                                <li>Útil para integración con Excel o Google Sheets</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Cupones -->
                    <div class="card mb-4" id="cupones">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-tag text-danger"></i> Gestión de Cupones</h3>
                            
                            <h5 class="fw-semibold mt-4">Crear Cupones de Descuento</h5>
                            <ol>
                                <li>Ve a <strong>Administración → Gestión de Cupones</strong></li>
                                <li>Haz clic en "Nuevo Cupón"</li>
                                <li>Configura:
                                    <ul>
                                        <li>Nombre/código del cupón</li>
                                        <li>Tipo de descuento (porcentaje o monto fijo)</li>
                                        <li>Valor del descuento</li>
                                        <li>Fecha de inicio y fin</li>
                                        <li>Límite de usos (opcional)</li>
                                    </ul>
                                </li>
                                <li>Activa el cupón</li>
                            </ol>

                            <h5 class="fw-semibold mt-4">Monitorear Uso de Cupones</h5>
                            <ul>
                                <li>Consulta estadísticas de cada cupón</li>
                                <li>Ve cuántas veces fue usado</li>
                                <li>Identifica los cupones más populares</li>
                                <li>Desactiva cupones vencidos o no deseados</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

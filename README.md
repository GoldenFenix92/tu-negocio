# EBC - Elise Beauty Center (Sistema POS Completo)

Sistema de Punto de Venta y Gestión Administrativa desarrollado con Laravel 12 y Bootstrap 5. Una solución completa y altamente personalizable para gestión de ventas, inventario, control de caja, usuarios y reportes financieros con tema dinámico.

## 📋 Tabla de Contenidos

-   [Características Principales](#-características-principales)
-   [Tecnologías Utilizadas](#-tecnologías-utilizadas)
-   [Requisitos del Sistema](#-requisitos-del-sistema)
-   [Instalación](#️-instalación-y-configuración)
-   [Roles y Permisos](#-roles-y-permisos)
-   [Funcionalidades Detalladas](#-funcionalidades-detalladas)
-   [Personalización Visual](#-personalización-visual)
-   [Manuales de Usuario](#-manuales-de-usuario)
-   [Credenciales de Acceso](#-credenciales-de-acceso)

---

## ✨ Características Principales

### 💰 Sistema de Ventas (POS)

-   Interfaz intuitiva y ágil para realizar ventas
-   Búsqueda rápida de productos por nombre o SKU
-   Navegación por categorías con imágenes
-   Soporte para productos y servicios
-   Múltiples métodos de pago (Efectivo, Tarjeta, Transferencia)
-   Aplicación de cupones de descuento
-   Descuentos especiales por cliente
-   Generación e impresión de tickets en PDF
-   Registro de vouchers y folios

### 📦 Gestión de Inventario

-   CRUD completo de productos y servicios
-   Organización por categorías
-   Control de stock en tiempo real
-   Registro de movimientos (entradas/salidas)
-   Alertas automáticas de stock bajo
-   Gestión de proveedores
-   Importación/exportación de datos

### 💵 Control de Caja Avanzado

-   Sesiones de caja por usuario
-   Registro de efectivo inicial
-   Arqueos periódicos durante el turno
-   Cortes de caja al finalizar sesión
-   Movimientos de efectivo (retiros/depósitos)
-   Conciliación automática
-   Reportes detallados en PDF
-   Historial completo de transacciones

### 📊 Reportes y Estadísticas

-   Dashboard con métricas en tiempo real
-   Ventas del día/semana/mes
-   Productos más vendidos
-   Ingresos por método de pago
-   Reportes de sesiones de caja
-   Historial de ventas completo
-   Exportación a PDF
-   Gráficas y visualizaciones

### 👥 Gestión de Clientes

-   Base de datos de clientes
-   Historial de compras por cliente
-   Descuentos personalizados
-   Gestión de citas y calendario
-   Perfil con foto y datos de contacto

### 🛠️ Administración

-   Gestión de usuarios con roles
-   Configuración de marca personalizable
-   Backups automáticos de base de datos
-   Restauración de backups
-   Gestión de cupones
-   Importación/exportación CSV
-   Sistema de permisos granular

### 🎨 Personalización Visual Dinámica

-   **Paleta de colores personalizable:**
    -   Color primario (botones, enlaces, elementos activos)
    -   Color secundario (fondos de tarjetas, sidebar)
    -   Fondo principal
    -   Color de texto
-   **Tipografía configurable:** Más de 20 fuentes de Google Fonts
-   **Efectos visuales ajustables:**
    -   Intensidad de sombras
    -   Difuminación
    -   Opacidad
-   **Identidad visual:**
    -   Logo personalizado
    -   Favicon propio
-   **Vista previa en tiempo real**
-   **Temas preestablecidos** para aplicación rápida

---

## 🚀 Tecnologías Utilizadas

### Backend

-   **Laravel 12** - Framework PHP moderno y robusto
-   **PHP 8.2+** - Lenguaje del lado del servidor
-   **MySQL** - Sistema de gestión de base de datos relacional

### Frontend

-   **Bootstrap 5** - Framework CSS responsivo
-   **Bootstrap Icons** - Íconos modernos
-   **JavaScript Vanilla** - Interactividad sin dependencias pesadas
-   **Google Fonts API** - Tipografías dinámicas

### Librerías y Herramientas

-   **Laravel Breeze** - Autenticación y gestión de usuarios
-   **DomPDF** - Generación de reportes en PDF
-   **Color Thief** - Extracción de paletas de colores de imágenes
-   **Vite** - Build tool moderno y rápido

---

## 💻 Requisitos del Sistema

-   PHP >= 8.2
-   Composer
-   Node.js >= 16.x
-   NPM o Yarn
-   MySQL >= 5.7 o MariaDB >= 10.3
-   Extensiones PHP requeridas:
    -   BCMath
    -   Ctype
    -   Fileinfo
    -   JSON
    -   Mbstring
    -   OpenSSL
    -   PDO
    -   Tokenizer
    -   XML
    -   GD (para manejo de imágenes)

---

## 🛠️ Instalación y Configuración

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/ebc-pv.git
cd ebc-pv
```

### 2. Instalar Dependencias de PHP

```bash
composer install
```

### 3. Instalar Dependencias de Frontend

```bash
npm install
```

### 4. Configurar Entorno

```bash
# Copiar archivo de configuración
cp .env.example .env

# Editar .env y configurar:
# - DB_DATABASE=nombre_base_datos
# - DB_USERNAME=usuario
# - DB_PASSWORD=contraseña
```

### 5. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 6. Crear Base de Datos

Crear una base de datos MySQL con el nombre especificado en `.env`

### 7. Ejecutar Migraciones y Seeders

```bash
php artisan migrate --seed
```

### 8. Crear Enlaces Simbólicos para Storage

```bash
php artisan storage:link
```

### 9. Compilar Assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 10. Iniciar Servidor

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

---

## 🔐 Roles y Permisos

### Administrador

**Acceso completo al sistema**

-   ✅ Todas las funciones de Supervisor y Usuario
-   ✅ Gestión de usuarios (crear, editar, eliminar)
-   ✅ Asignación de roles y permisos
-   ✅ Configuración de marca (colores, tipografía, logos)
-   ✅ Gestión de base de datos (backups, restauración)
-   ✅ Gestión de cupones
-   ✅ Acceso a todos los reportes y estadísticas

### Supervisor

**Gestión operativa y administrativa**

-   ✅ Todas las funciones de Usuario
-   ✅ Gestión de inventario (productos, categorías, servicios)
-   ✅ Control de stock y movimientos
-   ✅ Gestión de clientes y proveedores
-   ✅ Visualización de reportes avanzados
-   ✅ Supervisión de sesiones de caja de otros usuarios

### Usuario / Empleado

**Operación diaria del punto de venta**

-   ✅ Punto de Venta (POS)
-   ✅ Realizar ventas
-   ✅ Aplicar cupones y descuentos
-   ✅ Gestión de citas (calendario)
-   ✅ Control de caja personal (sesiones, arqueos, cortes)
-   ✅ Consulta de historial de ventas propias
-   ✅ Gestión de perfil personal

---

## 📚 Funcionalidades Detalladas

### Punto de Venta (POS)

1. **Selección de Productos:**

    - Búsqueda por nombre o SKU
    - Navegación por categorías visuales
    - Visualización con imágenes y precios

2. **Carrito de Compra:**

    - Ajuste de cantidades
    - Eliminación de items
    - Cálculo automático de totales

3. **Gestión del Cliente:**

    - Búsqueda rápida de clientes
    - Registro de nuevos clientes en el momento
    - Aplicación automática de descuentos especiales

4. **Descuentos y Cupones:**

    - Validación automática de cupones
    - Aplicación de descuentos por cliente
    - Visualización del ahorro en ticket

5. **Métodos de Pago:**

    - **Efectivo:** Cálculo automático de cambio
    - **Tarjeta:** Registro de pago con tarjeta
    - **Transferencia:** Registro de transferencias bancarias
    - Soporte para pagos mixtos

6. **Generación de Tickets:**
    - Impresión en PDF
    - Datos de la empresa
    - Detalle completo de la venta
    - Información del cajero
    - Fecha y folio único

### Control de Caja

1. **Sesiones de Caja:**

    - Inicio con efectivo inicial
    - Código de autorización requerido
    - Una sesión activa por usuario
    - Registro automático de todas las ventas

2. **Arqueos:**

    - Conteo de efectivo durante el turno
    - Comparación con el sistema
    - Registro de diferencias
    - Historial de arqueos

3. **Cortes de Caja:**

    - Cierre formal de sesión
    - Resumen completo de ventas
    - Desglose por método de pago
    - Generación de reporte en PDF

4. **Movimientos de Efectivo:**
    - Retiros con justificación
    - Depósitos adicionales
    - Registro de responsable
    - Trazabilidad completa

### Gestión de Inventario

1. **Productos:**

    - Información completa (nombre, SKU, descripción, precio)
    - Control de stock actual
    - Stock mínimo para alertas
    - Categorización
    - Imágenes de productos
    - Soft delete (recuperable)

2. **Categorías:**

    - Organización jer árquica
    - Imágenes por categoría
    - Activación/desactivación
    - Asignación a múltiples productos

3. **Movimientos de Stock:**

    - Entradas (compras, devoluciones)
    - Salidas (ventas, mermas, ajustes)
    - Motivo y descripción
    - Fecha y responsable
    - Historial completo

4. **Alertas de Stock:**
    - Notificaciones automáticas
    - Listado de productos bajo stock mínimo
    - Reporte exportable en PDF
    - Indicadores visuales en el sistema

### Gestión de Base de Datos

1. **Backups Automáticos:**

    - Backup diario programado
    - Retención de últimos 7 backups
    - Almacenamiento en `storage/app/backups`

2. **Backups Manuales:**

    - Creación bajo demanda
    - Descarga inmediata
    - Formato SQL estándar

3. **Restauración:**

    - Desde archivos del servidor
    - Desde archivo local
    - Vista previa antes de restaurar
    - Confirmación de sobrescritura

4. **Importación/Exportación CSV:**
    - Exportación de datos a Excel/Sheets
    - Importación masiva de datos
    - Validación de formato
    - Reporte de errores

---

## 🎨 Personalización Visual

### Paleta de Colores

Accede a **Configuración de Marca** para personalizar:

1. **Color Primario:**

    - Aplica a: botones, enlaces, elementos activos del sidebar
    - Efecto: resplandores y sombras con el color seleccionado

2. **Color Secundario:**

    - Aplica a: fondos de tarjetas, sidebar, elementos secundarios

3. **Fondo Principal:**

    - Color de fondo de toda la aplicación

4. **Color de Texto:**
    - Color principal del texto en toda la interfaz

### Tipografía

Selecciona entre más de 20 fuentes profesionales de Google Fonts:

-   Inter (por defecto)
-   Poppins
-   Roboto
-   Montserrat
-   Open Sans
-   Lato
-   Y muchas más...

### Efectos Visuales

Ajusta las sombras y efectos:

-   **Intensidad:** Qué tan marcadas son las sombras (0.5 - 2.0)
-   **Difuminación:** Suavidad del efecto (5 - 20px)
-   **Opacidad:** Transparencia de las sombras (0 = automático, 0.1 - 1.0)

### Identidad Visual

-   **Logo:** Se muestra en sidebar, tickets y reportes (recomendado: PNG transparente)
-   **Favicon:** Ícono del navegador (16x16 o 32x32px)

### Vista Previa en Tiempo Real

Todos los cambios se reflejan inmediatamente en una vista previa interactiva antes de guardar.

---

## 📖 Manuales de Usuario

El sistema incluye manuales integrados accesibles desde el menú lateral:

### Manual de Usuario

Guía completa para empleados que operan el POS:

-   Cómo realizar ventas
-   Gestión de caja personal
-   Consulta de historial
-   Gestión de citas

### Manual de Supervisor

Funciones avanzadas para supervisores:

-   Gestión de inventario
-   Administración de clientes y proveedores
-   Generación de reportes
-   Control de usuarios

### Manual de Administrador

Administración completa del sistema:

-   Gestión de usuarios y roles
-   Configuración de marca
-   Backups y base de datos
-   Configuración de cupones

**Acceso:** Cada usuario ve únicamente los manuales correspondientes a su rol y roles inferiores.

---

## 🔑 Credenciales de Acceso

El sistema cuenta con usuarios predeterminados generados por los seeders:

| Rol                  | Correo Electrónico   | Contraseña      |
| :------------------- | :------------------- | :-------------- |
| **Administrador**    | `admin@ebc.com`      | `ADMINISTRADOR` |
| **Supervisor**       | `supervisor@ebc.com` | `SUPERVISOR`    |
| **Usuario (Cajero)** | `usuario@ebc.com`    | `USUARIO`       |

### Códigos de Autorización

Para operaciones sensibles en el **Control de Caja**:

-   **Código General:** `EBCADMIN`
-   **Código Avanzado (Admin/Supervisor):** `EBCFCADMIN`

---

## 🔧 Configuración Avanzada

### Backups Automáticos

Para configurar backups automáticos, agrega al cron del servidor:

```bash
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

### Variables de Entorno Importantes

```env
APP_NAME="EBC - Punto de Venta"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_bd
DB_USERNAME=usuario
DB_PASSWORD=contraseña

MAIL_MAILER=smtp
# Configurar si necesitas envío de correos
```

---

## 📝 Estructura del Proyecto

```
ebc-pv/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   └── Policies/            # Políticas de autorización
├── database/
│   ├── migrations/          # Migraciones de BD
│   └── seeders/            # Datos iniciales
├── public/
│   └── images/             # Imágenes públicas
├── resources/
│   ├── views/              # Vistas Blade
│   │   ├── manuals/        # Vistas de manuales
│   │   ├── layouts/        # Layouts del sistema
│   │   └── ...
│   └── css/                # Estilos
├── routes/
│   └── web.php             # Rutas web
└── storage/
    └── app/
        └── backups/        # Backups de BD
```

---

## 🤝 Contribuciones

Este es un proyecto privado para Elise Beauty Center. Para sugerencias o reportes de errores, contacta al administrador del sistema.

---

## 📄 Licencia

Propiedad de Elise Beauty Center. Todos los derechos reservados.

---

## 📞 Soporte

Para soporte técnico o consultas:

-   Consulta los manuales integrados en el sistema
-   Contacta al administrador del sistema
-   Revisa la documentación técnica en `/docs`

---

**Desarrollado con ❤️ para Elise Beauty Center**

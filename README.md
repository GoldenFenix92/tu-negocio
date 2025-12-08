# EBC - Elise Beauty Center (Punto de Venta)

Sistema de Punto de Venta y Gestión Administrativa desarrollado para Elise Beauty Center. Esta aplicación permite gestionar ventas, inventario, control de caja, usuarios y reportes financieros.

## 🚀 Tecnologías Utilizadas

Este proyecto está construido con un stack moderno y robusto:

-   **Backend:** [Laravel 12](https://laravel.com) (PHP 8.2+)
-   **Frontend:** [Bootstrap 5](https://getbootstrap.com) (Diseño responsivo y componentes UI)
-   **Base de Datos:** MySQL
-   **Generación de PDF:** [laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
-   **Scripting:** Vanilla JavaScript

## ✨ Funcionalidades Principales

-   **Punto de Venta (POS):** Interfaz ágil para realizar ventas, aplicar descuentos y gestionar clientes.
-   **Control de Caja:** Gestión de turnos, arqueos, cortes de caja y movimientos de efectivo.
-   **Inventario:** Control de stock, alertas de stock bajo y registro de movimientos (entradas/salidas).
-   **Gestión de Usuarios:** Roles y permisos (Administrador, Supervisor, Empleado).
-   **Reportes:** Generación de reportes de ventas y financieros en PDF.

## 🔐 Credenciales de Acceso (Entorno Local/Pruebas)

El sistema cuenta con los siguientes usuarios predeterminados generados por los seeders:

| Rol                  | Correo Electrónico   | Contraseña      |
| :------------------- | :------------------- | :-------------- |
| **Administrador**    | `admin@ebc.com`      | `ADMINISTRADOR` |
| **Supervisor**       | `supervisor@ebc.com` | `SUPERVISOR`    |
| **Usuario (Cajero)** | `usuario@ebc.com`    | `USUARIO`       |

## 🔑 Códigos de Administración

Para realizar acciones sensibles en el módulo de **Control de Caja** (como realizar cortes de caja), se requieren códigos de autorización especiales:

-   **Código General:** `EBCADMIN`
-   **Código Avanzado (Admin/Supervisor):** `EBCFCADMIN`

## 🛠️ Instalación y Configuración

1.  **Clonar el repositorio**
2.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```
3.  **Instalar dependencias de Frontend:**
    ```bash
    npm install
    npm run build
    ```
4.  **Configurar entorno:**
    -   Copiar `.env.example` a `.env`
    -   Configurar credenciales de base de datos en `.env`
5.  **Generar clave de aplicación:**
    ```bash
    php artisan key:generate
    ```
6.  **Ejecutar migraciones y seeders:**
    ```bash
    php artisan migrate --seed
    ```
7.  **Iniciar servidor:**
    ```bash
    php artisan serve
    ```

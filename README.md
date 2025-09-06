# 📌 API Clínica - Gestión de Usuarios, Pacientes y Citas

Este proyecto es una **API REST** desarrollada en **Laravel** que permite gestionar la autenticación de usuarios, pacientes, médicos, especialidades, consultorios y citas médicas.  
Incluye seguridad basada en **Laravel Sanctum** y control de acceso por **roles**.

---

## 🚀 Tecnologías utilizadas
- **PHP 8+**
- **Laravel 10+**
- **MySQL**
- **Laravel Sanctum** (autenticación con tokens personales)
- **Middleware de Roles**

---

## 📂 Estructura relevante
- **Controllers/**
  - `AuthController.php` → Registro, login, logout y datos del usuario autenticado.
  - `PacientesController.php` → CRUD y consultas especiales de pacientes.
- **Middleware/**
  - `RoleMiddleware.php` → Control de accesos por roles (`admin`, `paciente`, etc.).
- **Models/**
  - `User.php` → Usuarios con roles y autenticación vía Sanctum.
  - `Pacientes.php` → Modelo de pacientes con relación a citas.
- **Database/Migrations/**
  - `users` con campo `role`
  - `pacientes`
  - `personal_access_tokens`

---

## 🔑 Autenticación
La API utiliza **Laravel Sanctum** para autenticación vía **Bearer Token**.

- Registro de usuario → genera un token de acceso.
- Login → devuelve un `access_token`.
- Logout → invalida todos los tokens del usuario.

**Roles soportados**:
- `admin`
- `paciente`

---

## 📌 Endpoints principales

### 🔐 Autenticación
| Método | Endpoint      | Descripción               | Auth |
|--------|--------------|---------------------------|------|
| POST   | `/registrar` | Registro de nuevo usuario | ❌   |
| POST   | `/login`     | Login y generación token  | ❌   |
| GET    | `/me`        | Usuario autenticado       | ✅   |
| POST   | `/logout`    | Cerrar sesión             | ✅   |

---

### 🧑‍⚕️ Pacientes
| Método | Endpoint                | Descripción                        | Rol    |
|--------|--------------------------|------------------------------------|--------|
| GET    | `/listarPacientes`       | Listar todos los pacientes         | admin  |
| POST   | `/crearPaciente`         | Crear un paciente                  | admin  |
| GET    | `/pacientes/{id}`        | Ver un paciente específico         | admin  |
| PUT    | `/actualizarPaciente/{id}` | Actualizar datos de un paciente   | admin  |
| DELETE | `/eliminarPaciente/{id}` | Eliminar paciente                  | admin  |

#### Consultas personalizadas:
| Endpoint                              | Descripción                                    |
|---------------------------------------|------------------------------------------------|
| `/listarPacientesConCitasConfirmadas` | Pacientes con citas confirmadas                |
| `/listarPacientesMayores60`           | Pacientes mayores de 60 años                   |
| `/listarPacientesSinCitas`            | Pacientes sin citas                            |
| `/listarPacientesPorLetraC`           | Pacientes cuyo nombre empieza con "C"          |

---

### 📅 Citas
| Método | Endpoint       | Descripción                    | Rol              |
|--------|----------------|--------------------------------|------------------|
| GET    | `/listarCitas` | Listar todas las citas         | admin, paciente |
| POST   | `/crearCita`   | Crear una nueva cita           | admin, paciente |
| GET    | `/listarCitasPendientes` | Listar citas pendientes | todos |
| GET    | `/listarCitasDeHoy` | Listar citas del día       | todos |

---

### 🏥 Otros módulos
#### Médicos
- `/listarMedicos` → Listado general (admin, paciente)  
- `/crearMedico` → Crear (admin)  
- `/eliminarMedico/{id}` → Eliminar (admin)  
- `/listarMedicosSinCitas` → Médicos sin citas  
- `/listarMedicosPediatria` → Médicos de pediatría  

#### Especialidades
- `/listarEspecialidades` → Listado (admin, paciente)  
- `/crearEspecialidad` → Crear (admin)  
- `/listarEspecialidadesPorLetraP` → Filtrar por letra "P"  
- `/listarEspecialidadesConMasDe2Medicos` → Especialidades con más de 2 médicos  

#### Consultorios
- `/listarConsultorios` → Listado (admin, paciente)  
- `/crearConsultorio` → Crear (admin)  

---

## ⚙️ Instalación y uso
### Clonar repositorio  
   - bash
   git clone <repo-url>
   cd proyecto

### Instalar dependencias

- composer install


### Configurar .env con base de datos y Sanctum.

- Ejecutar migraciones

- php artisan migrate


### Iniciar servidor

- php artisan serve

## 🛡️ Middleware de Roles

El RoleMiddleware restringe el acceso según el rol del usuario autenticado. <br>
<br>
**Ejemplo:**

Route::group(['middleware' => RoleMiddleware::class . ':admin'], <br>function () {
<br>   Route::post('crearPaciente', [PacientesController::class, 'store']);<br>
});

**📌 Migraciones destacadas**

- users → ahora incluye role.

- pacientes → almacena información básica de pacientes.

- personal_access_tokens → tokens de Sanctum para autenticación.

**✨ Autor**

- Proyecto desarrollado como práctica de Laravel + API REST + Sanctum.


---
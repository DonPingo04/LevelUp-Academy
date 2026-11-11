# Level Up Academy - Backend & API

Sistema de gestión integral para **Level Up Academy**, desarrollado como una SPA (Single Page Application) con un backend robusto en **Laravel**, base de datos relacional en **PostgreSQL** y autenticación mediante **Laravel Sanctum**.

---

## Tecnologías y Stack
* **Backend:** Laravel (API RESTful)
* **Base de Datos:** PostgreSQL
* **Autenticación:** Laravel Sanctum (SPA Authentication)
* **Frontend (Integrado):** Vue.js
* **Integración ERP:** Sincronización de contactos y facturación con **Odoo** (`odoo_partner_id`, `odoo_invoice_id`).

---

## Arquitectura y Modelos Principales
El sistema modela la estructura académica y administrativa mediante las siguientes entidades y relaciones clave:
* **Usuarios (`usuarios`):** Tabla central de autenticación con roles (`secretaria`, `profesor`, `alumno`, `familiar`).
* **Perfiles 1 a 1 (`Alumnos`, `Familiares`, `Profesores`):** Extienden los datos específicos de cada rol desde la tabla de usuarios.
* **Gestión Académica (`Cursos`, `Grupos`, `Niveles`, `Periodos`, `Sesiones`):** Control de la oferta educativa, horarios y aulas.
* **Matrículas y Calificaciones (`Matriculas`, `Calificaciones`):** Gestión de inscripciones con soporte de **pagadores polimórficos** (pueden pagar los propios alumnos o sus familiares autorizados) y registro de notas por evaluación.
* **Tablas Pivote Complejas:** 
  * `alumno_familiar` (con atributos adicionales de parentesco y autorización).
  * `alumno_nivel` (clave primaria compuesta para el seguimiento curricular).

---

## Requisitos del Sistema
Asegúrate de tener instalado en tu entorno de desarrollo:
* PHP >= 8.3
* Composer
* PostgreSQL
* Node.js y NPM (para el frontend en Vue.js)

---

## 📦 Instalación y Configuración

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/tu-usuario/level-up-academy.git](https://github.com/tu-usuario/level-up-academy.git)
   cd level-up-academy

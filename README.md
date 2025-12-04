# Nombre del proyecto: Aventones V2.

## Objetivo principal del proyecto:

- Desarrollar un prototipo funcional de una aplicación web que integre los conocimientos adquiridos en programación web.  

- El proyecto incluye una interfaz web, una base de datos MySQL y la utilización de PHP como lenguaje principal. Además, para la V2 de este proyecto el desarrollo se estructura siguiendo el patrón de arquitectura Modelo–Vista–Controlador (MVC), lo que permite una organización modular y una mejor separación de responsabilidades dentro del sistema. Para su implementación, se utiliza el framework CodeIgniter, que facilita la gestión de rutas, controladores, modelos, vistas y buenas prácticas de desarrollo web.

## Funcionalidad General (V1 + V2):

- **Tres tipos de roles:** pasajeros, conductores y administradores.  

- **Proceso de registro:** los usuarios de tipo pasajero o conductor que no tengan acceso podrán registrarse en el sistema mediante un formulario visible desde la pantalla de inicio de sesión.  Una vez completado el registro, su cuenta quedará en estado pendiente. El usuario deberá activar su cuenta a través de un enlace enviado a su correo electrónico personal.

- **Gestión de rides:** CRUD completo (crear, leer, actualizar y eliminar) de viajes.

- **Gestión de vehículos:** CRUD completo de vehículos asociados a los conductores.

- **Reservas:** los usuarios pasajeros pueden realizar reservas desde la pantalla de búsqueda de rides.  
  Tanto los conductores como los clientes pueden visualizar las reservas asociadas a su usuario (activas y pasadas).  
  Si la reserva ya fue aceptada por el conductor, el cliente aún puede cancelarla.

- **Búsqueda de rides:** existe una página pública y privada que permite filtrar viajes por origen, destino y fecha, con opción de ordenamiento ascendente o descendente. Los usuarios no registrados pueden consultar información general de los viajes.Además,Las búsquedas realizadas (públicas o privadas) se registran en un reporte.


- **Gestión de usuarios:** los usuarios pueden actualizar su información personal en cualquier momento.

- **Panel de administración:** los administradores pueden visualizar la lista de usuarios, desactivar cuentas y crear nuevos administradores.

- **Script:** el sistema cuenta con un script que identifica las reservas pendientes que han pasado cierta cantidad de minutos desde su creación y envía un correo de recordatorio al conductor.


## Nuevos Features Introducidos en Aventones V2

- **Inicio de sesión sin contraseña:** el usuario puede seleccionar la opción "Passwordless", ingresar su correo electrónico y recibir un enlace único en su email. Si existe un usuario asociado, el sistema enviará un vínculo especial que permite iniciar sesión sin ingresar contraseña. Este enlace es de un solo uso: una vez utilizado, queda invalidado automáticamente.

- **Reporte de búsquedas:** el administrador puede generar un reporte por rango de fechas, visualizando: fecha de búsqueda, usuario que realizó la búsqueda (o “Usuario no reconocido” si fue realizado desde la búsqueda pública), lugar de salida, lugar de llegada, cantidad de resultados obtenidos.


## Librerías instalación:

# PHPMailer

El proyecto utiliza PHPMailer para el envío de correos electrónicos (como notificaciones y activaciones de cuenta).

Para instalarlo correctamente, sigue los siguientes pasos:

1. **Instalar Composer**  
   Composer es un gestor de dependencias para PHP, necesario para instalar PHPMailer.  
   Se descarga en el siguiente link:
   [https://getcomposer.org/Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)

2. **Configurar la ruta de PHP durante la instalación**  
   Asegúrate de indicar la siguiente ruta cuando el instalador lo solicite:C:\xampp\php\php.exe

3. **Marcar la opción:**  
Add Composer to the PATH, esto permite utilizar Composer desde cualquier terminal, incluyendo la de Visual Studio Code.

4. **Verificar la instalación de Composer**  
Ejecuta el siguiente comando en la terminal: composer -V

5. **Instalar la librería PHPMailer**  
Una vez confirmado que Composer está instalado correctamente, ejecuta: composer require phpmailer/phpmailer

## Framework instalación:

1. **Descargar CodeIgniter 4**
Se obtiene desde la página oficial: https://codeigniter.com/download

2. **Descomprimir el archivo descargado**
Se extrajo el contenido del ZIP dentro del directorio del proyecto, por ejemplo: C:\xampp\htdocs\ISW-613\proyectoIIAventones\

3. **Configurar el Virtual Host en Apache (XAMPP)**
Para ejecutar el proyecto en un dominio local más limpio y organizado, se configuró un Virtual Host dentro del archivo: C:\xampp\apache\conf\extra\httpd-vhosts.conf

4. **Registrar el dominio local en el archivo hosts**
Para que el navegador reconozca el dominio definido en Apache, se editó el archivo: C:\Windows\System32\drivers\etc\hosts

5. **Verificar el funcionamiento del framework**
Una vez reiniciado, se ingresó en el navegador: http://aventonesisw.local/

6. **Configurar base_url en CodeIgniter**
En app/Config/App.php, se ajustó el valor: public $baseURL = http://aventonesisw.local/;



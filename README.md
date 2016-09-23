# AnexMailing
Software open source que gestiona los suscriptores de tu web.

# Versión actual
Actualmente se encuentra en una versión beta (1.1b), necesito testers para asegurar que funcione bien y pasé a la versión rc.

# Guía de usuario
El software es bastante sencillo de usar, por ahora no tengo la documentación oficial pero creo que es muy intuitivo. De todas formas voy a tener que hacer una.

El software esta divido en 2 partes:

<b>Back-office (panel de administrador)</b>:
* Inicio: un dashboard que muestra el resumen de tus suscriptores
* Suscriptores: permite gestionar a los suscriptores, dar de baja y exportar a CSV.

<b>Front-office (javascript de suscripción)</b>:
Mediante un javascript que genera el backend se creará toda la API para que desde la página web de tu cliente puedas poner a prueba como funciona el aplicativo y comenzar a suscribir a los usuarios.

<b>Nota</b>: <em>por ahora el front-office no es tan importante, me gustaría que me apoyen más con el back-office</em>.

<b>Ejemplo del front-office</b>: si tu entorno de trabajo es DEV podrás acceder desde el administrador una página de prueba.
Su configuración es muy simple

```
var am = new AnexMailing({
    email: 'email',
    name: 'name',
    done: function(type, r){
        // Limpiamos cualquier mensaje de validación previo
        $('.validation-message').html('');
        
        // Si el request fue éxitoso
        if(type === 'success') {
            subscribed();
        }
        
        // Si ocurrió un error de validación
        if(type === 'validation') {
            if(r.errors !== null) {
                for(var k in r.errors) {
                    $('#val-' + k).text(r.errors[k][0]);
                }
            }
        }
        
        // Si ocurrió cualquier error no controlado
        if(type === 'error') {
            
        }
    }
});
```


# Instalación
Clona el proyecto en una carpeta de tu PC y comenzamos a ejecutar los siguientes comandos porque no he incluído algunas dependencias para alivianar la app.

1- Primero necesitamos instalar los packages de composer, en la raíz del proyecto corremos el siguiente comando:
```
composer update
```

2- Necesitamos las dependencias de Bower, en la carpeta "assets/" corremos el siguiente comando:
```
bower update
```

3- <b>OPCIONAL</b>: Si queremos modificar el archivo Gulp para la minificación y concatenación de archivos js/css nos vamos a la carpeta "gulp/" y ejecutamos el siguiente comando
```
npm update
```

4- En la carpeta SQL tenemos un script de base de datos, ejecútalo para crear la DB. Solo usa una tabla el aplicativo.

5- Edita el archivo config.php, este es demasiado intuitivo pero de todas formas vamos a explicar
* <b>database</b>: en este pondrán su cadena de conexión, la api que usa la App para conectarse a la DB es PDO.
* <b>users</b>: es un arreglo que permite gestionar los usuarios de la App.
* <b>environment</b>: modifica el entorno de desarrollo actual, para testing esta bien dev para publicación se recomienda dev.
* <b>timezone</b>: la hora local de tu zona geográfica
* <b>tokenAuthSecurity</b>: es un secret key que usa para el tema de seguridad con la autenticación, cambien este valor por algo único.
* <b>trustedDomain</b>: son los dominios de confianza, los que no sean igual a estos los considerará como posiblemente falsos.
* <b>startYear</b>: el año de inicio para tu proyecto, ideal para el dashboard y otras cosas.

# Tareas pendientes
* Lanzar la web oficial
* Documentación oficial
* Api de exportación a Mailchimp, por ahora se usa un CSV

# Créditos
Realizado por <a href="http://anexsoft.com">Anexsoft</a>.

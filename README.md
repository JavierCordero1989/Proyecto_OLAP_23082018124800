# Plantilla-Laravel

![Logo de Laravel e Infyom](http://blog.kozzaja.com/wp-content/uploads/2017/01/ominfy.png "Infyom + Laravel")

###### Plantilla con contenido para empezar un proyecto

Al descargar o clonar este repositorio o proyecto, se deben seguir varios pasos para que pueda funcionar todo adecuadamente.

***Primero***: instalar composer en el proyecto, mediante consola se debe ejecutar el comando **composer install**.

***Segundo***: despues de la instalacion, se debe ejecutar por consola el comando **php artisan key:generate**.

***Tercero***: crear la base de datos, con el nombre deseado.

***Cuarto***: modificar el archivo **.env.example**, lo que se debe hacer es copiarlo y pegarlo dentro de la misma carpeta del proyecto, y modificar la copia. Lo que se debe modificar es el nombre del archivo de la copia y dejarlo como **.env**, luego de eso modificar las siguientes variables:

~~~
DB_DATABASE='nombre de la base de datos'
DB_USERNAME='usuario de la BD'
DB_PASSWORD='contraseña del usuario'
~~~

Todos los cambios anteriores, por supuesto deben ir sin las comillas.

***Quinto***: una vez hechos los anteriores pasos, se debe ejecutar en consola el comando **php artisan migrate --seed**, esto para que las tablas necesarias para la aplicación sean creadas en la base de datos que se especificó en el archivo **.env** y además sean cargadas con algunos datos por defecto para uso de la aplicación.

***Sexto***: con los datos ya listos, solo resta ejecutar el comando en consola **php artisan serve** para que el servidor comience a ejecutarse y poder utilizar la aplicación. Lo que resta es entrar al navegador predeterminado o favorito y en la barra para direcciones ingresar **http://localhost:8000** o **http://127.0.0.1:8000** que es lo mismo.

## Notas aclaratorias

Se debe tener en la computadora instalado el motor de base de datos mysql o algún otro compatible con Laravel, y tener instalado **composer** también, ya que es indispensable para el proyecto.

Todos los comandos ejecutados por consola, deben ser realizados ubicando la consola dentro de la carpeta del proyecto.

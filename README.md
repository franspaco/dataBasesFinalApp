# Data Bases Final Project
##Dependencias:
* Apache 2.4
* Mysql >=5.7
* PHP >= 5.5 (Solo está probado con 7.0)

##Instrucciones de instalación:

1. Clonar el repositorio a el "DocumentRoot" de apache, o descargarlo y extraerlo. index.php debe quedar en el folder raiz del servidor.

2. Cargar el modelo de base de datos en mysql workbench que se encuentra en "mysql_model/final_db.mwb" y sincronizarlo a la base de datos que se desee. (se recomienda borrar este archivo posteriormente)

3. Crear un folder al lado del folder raíz de apache llamado "php_files", que debo contener un archivo "config.php.ini" para almacenar los datos de la conexión a mysql. (desde index.php, este archivo debe estar en la ruta relativa: "../php_files/config.php.ini" )

4. Ingresar la información en el archivo con el formato:

```php
mysqluser = "usuario"
mysqlpass = "contraseña"
mysqlDB   = "nombre de base de datos"
```

5. Crear un usuario ADMIN en la página de registro (register.php) desde el explorador, es importante que sea el primer usuario dado que el id '1' está ligado con el administrador. *

6. Ir a la guia y crear canales default con el boton "new". Todos los canales que cree el admin serán default, por tanto se despliegan a usuarios sin sesión y se autosuscribe a ellos a todos los usuarios nuevos.

7. Hacer posts!

-----
###Notas:

Si no fuera posible creal al usuario admin por a través de la aplicación puede crearse manualmente con el comando:
```sql
INSERT INTO USERS (username, email, password) values ('admin', 'admin@localhost', <contraseña> );
```
Donde `<contraseña>` debe ser un hash. Este puede generarse con la función password_hash() que puede encontrarse en test.php donde se puede editar para obtener el hash de la contraseña deseada al cargar el archivo a través del servidor. No se recomienda utilizar este método.

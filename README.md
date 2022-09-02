# Proyecto 4 aka Proyecto F.E.O (Sistema para la gestión administrativa del Centro Médico Hiperbárico y de Rehabilitación SHENQUE C.A Ubicado en Cagua, Estado Aragua)

> ### Autores:
>
> - @Oriana Blanco.
> - @Francis Baloa.
> - @Enrique Chacón.
>
> Estudiantes de la Universidad Politécnica Territorial de Aragua (UPTA).

> ##### Convenciones a seguir en el proyecto como buenas prácticas:
>
> - Cada archivo deberá estar ubicado en su carpeta correspondiente.
> - Se utilizará el patrón de diseño modelo-vista-controlador (MVC).
> - Los nombres de las variables, métodos, clases, entre otras, de la arquitectura estarán codificadas en su totalidad en inglés.
> - Los nombres de las variables, métodos, clases, entre otras, del proyecto se intentará que sean en su totalidad en español.
> - Las clases y los archivos que sean una clase **PHP** (o en su defecto **JS**) deberán tener el nombre en formato PascalCase, es decir: `ClaseEjemplo.php | ClaseEjemplo::class`.
> - Los archivos de controlador, modelo (o vista de ser necesario), deberán terminar con su respectivo nombre en inglés para que sea más fácil identificarlos, es decir: `UsuarioController.php | UsuarioView.php | UsuarioModel.php`.
> - De añadir una carpeta adicional a la estructura, añadir su respectiva ruta.
> - Las variables, atributos y métodos deberán tener el nombre en formato CamelCase, es decir: `camelCaseMethod(); | $varAttribute;`.
> - Las varibles/atributos de los modelos deberán tener el mismo nombre como en la base de datos y se utilizará el formato snake_case, es decir: `$usuario_id, $fecha_entrega`.
> - Para identificar más rápido un objeto este deberá incluir un "_" al comienzo de su nombre y utilizar el formato CamelCase, es decir: `$_objetoRandom`.
> - En los modelos colocar los mismos atributos que se encuentren en la base de datos, ya si se necesitan más añadirlos.
> - Gracias  a contar con un autoloader, no es necesario usar require/include de las clases. Solo considerar agregar las rutas en `config.php` en caso de añadir nuevas carpetas.

> #### Estructura del proyecto:
>
> - **assets**: En esta carpeta se encontrarán todos los recursos **CSS** y **JS**.
> - **autoloader**: En esta carpeta se encuentra la clase `Autoloader.php` y el `launcher.php` el cual inicializará el autoloader.
> - **config**: En esta carpeta se encuentra los archivos de configuración, más especificamente un archivo llamado `autoloader.php` el cual retorna todas las constantes/rutas que se encuentren en `config.php`.
> - **controllers**: Básicamente se encontrarán todos los controladores y el controlador base llamado `Controller.php`.
> - **database**: Aquí se encuentra el archvio de la clase `Database`, el cual establece la conexión a la base de datos.
> - **models**: En esta carpeta se encontrarán todos los modelos del proyecto, además de contar con dos clases especiales, la primera `BaseModel.php` el cual (como indica su nombre) contiene una base con métodos reusables para otros modelos, la segunda `GenericModel.php`, es un modelo genérico el cual podrá ser heredado por cualquier modelo con el objetivo de reutilizar código, si se hereda esta clase especificando solo el nombre de la tabla en la base de datos y estableciendo sus atributos se podrá utilizar cualquier método del `BaseModel`.
> - **routes**: En esta carpeta, se encontrarán todas las clases y archivos que hacen posible que el enrutador funcione correctamente. Resaltando que el archivo `routes.php`, se encarga de registrar todas las rutas del sistema.
> - **utils**: En esta carpeta, se encontrarán aquellas clases que serán de utilidad para el proyecto.
> - **views**: Aquí se encontrarán todas las vistas del sistema.
> - **root/raiz**: Aquí se encontrarán algunos archvios de configuración/ejecución del sistema para su correcto funcionamiento.

> #### Archivos base de la estructura MVC del proyecto:
>
> - `autoloader > Autoloader.php`.
> - `autoloader > launcher.php`.
> - `config > autoloader.php`.
> - `controllers > Controller.php`.
> - `database > Database.php`.
> - `models > BaseModel.php`.
> - `models > GenericModel.php`.
> - `routes > Request.php`.
> - `routes > Router.php`.
> - `routes > routes.php`.
> - `routes > Uri.php`.
> - `views > View.php`.
> - `root > index.php`.
> - `root > .htaccess`.

> #### Modelos: 

Si un controlador require de un modelo, es conveniente comenzar por este. Para ello, contamos con diferentes operaciones genéricas las cuales pueden ser heredadas de la clase `GenericModel`. Si se hereda esta clase, obtenemos 5 métodos (por los momentos) los cuales son: `getAll();`, `getFirst();`, `update();`, `insert();`, `delete();`. Además de algunos especiales como: `where();` y `orWhere();`. 

Ahora bien, para hacer uso de estos métodos, al momento de heredar la clase `GenericModel`, debemos ejecutar su constructor de esta manera:

```PHP

class ExampleModel extends GenericModel{

    //Atributos del modelo, colocarle el nombre preferiblemente iguales a la base de datos

    public function __construct($properties = null){

        /**
         * @param string $table
         * @param class $className
         * @param array $properties = null (optional)
        */

        parent::__construct('exampleTable', ExampleModel::class, $properties);
    }
}

```

De esta manera, al instanciar este modelo, ya podremos utilizar los métodos anteriormente mencionados. Por otro lado, al momento de instanciar el modelo contamos con un parámetro llamado **properties** en el constructor, aquí podrían pasarse otros atributos adicionales de ser necesario. Y por supuesto, que dentro de cada modelo se podrán definir sus propios métodos para usarlos en su respectivo controlador.

> ###### Observación: El primer parámetro del constructor de la clase `GenericModel` (el cual es el nombre de la tabla en la base de datos a la que está asociada el modelo), debe ser identico al nombre en la base de datos, es decir, si nuestra tabla en la base de datos se llama `exampleTable`, deberá pasarse como primer parámetro `exampleTable`. Esto debidio a que hacemos uso de ese nombre para las consultas preestablecidas y si se coloca un nombre distinto al de la base de datos, nos arrojará un error diciendo que esa tabla no existe/encuentra en la misma.


Llegados a este punto, una vez definido el modelo, la manera de usar los métodos del `GenericModel` es la siguiente:

- El método `getAll();` nos traerá consigo todos los registros de una tabla en particular, ejemplo: 

```PHP

$exampleNames = $_exampleModel->getAll();

```

- El método `getFirst();` nos devolverá el primer registro de la lista de un `getAll();`, para sacarle más provecho es conveniente usar los métodos especiales `where();` o `orWhere();`, por ahora un ejemplo básico:

```PHP

$exampleName = $_exampleModel->getFirst();

```

- El método `insert();` ejecutará la operación genérica de hacer la inserción de un registro a una tabla, este recibe un array/objeto como parámetro aunque si especificamos los atributos correctamente en el modelo (y sus métodos **getters** y **setters**) podemos omitir este parámetro, ejemplo:

```PHP

//Método 1

$data = [
    'name' => 'example'
    'lastName' => 'example2'
];

//Si la ejecución fue correcta el método insert() devolverá un número mayor a 0 
$response = $_exampleModel->insert($data);

/*--------------------------------------------------------------*/

//Método 2 (Si especificamos todos los atributos en el modelo con su respectivo setter, podemos hacerlo de esta manera)

$_exampleModel->setName('example');
$_exampleModel->setLastName('example2');

$response = $_exampleModel->insert();

/*--------------------------------------------------------------*/

//Método 3 (Mejora del primer método, pues aparte de enviar el array/objeto, también hacemos un set a sus atributos. Para ello, ocuparemos el método fill())

$_exampleModel->fill([
    'name' => 'example',
    'lastName' => 'example2'
]);

$response = $_exampleModel->insert();

```

- El método `update();` ejecutará la operación genérica de hacer la modificación/actualización de un registro o varios en la base de datos. Muy similar al método `insert();` a diferencia de que usualmente solo queremos modificar/actualizar registros especificos y no todos, por ello, es conveniente usar algunos de los métodos especiales `where();` o `orWhere();`, ejemplo:

```PHP

//Método 1 (Sin utilizar el método where, es decir que afectará a todos los registros)

//Datos a modificar
$data = [
    'name' => 'exampleUpdated'
];

$response = $_exampleModel->update($data);

//Método 1 (Utilizando el método where)

//Datos a modificar
$data = [
    'name' => 'exampleUpdated',
    'example_id' => 4 // Podemos especificar directamente el id dentro del array/objeto o colocarlo directamente dentro del where(); preferiblemente hacerlo de esta manera.
];

/** Where function
 *  
 * @param string $keyName //Nombre de la llave/campo de la base de datos
 * @param string $condition //Condicion a evaluar, =,>,<...
 * @param string/int $value
*/

//Nótese que los métodos especiales where(); o orWhere(); deben colocarse antes del método que ejecuta la operación, en este caso el update();

$response = $_exampleModel->where('example_id', '=', $data['example_id'])
                        ->update($data);

/*--------------------------------------------------------------*/

//Método 2 

$_exampleModel->setName('exampleUpdated');
$_exampleModel->setExampleId(4);

$response = $_exampleModel->where('example_id', '=', $_exampleModel->getExampleId())
                        ->update();

/*--------------------------------------------------------------*/

//Método 3

$_exampleModel->fill([
    'name' => 'exampleUpdated';
    'example_id' => 4
]);

$response = $_exampleModel->where('example_id', '=', $_exampleModel->getExampleId())
                        ->update();

```

- El método `delete();` ejecutará la operación genérica de eliminar un registro o varios en la base de datos. Similar al método `update();` respecto al uso de los métodos especiales `where();` o `orWhere()`.

```PHP

//Método 1

$exampleDeleteId = 4;

$response = $_exampleModel->where('example_id', '=', $exampleDeleteId)
                        ->delete();

/*--------------------------------------------------------------*/

//Método 2

$_exampleModel->setExampleId(4);

$response = $_exampleModel->where('example_id' '=', $_exampleModel->getExampleId())
                        ->delete();

/*--------------------------------------------------------------*/

//Método 3

$_exampleModel->fill([
    'example_id' => 4
]);

$response = $_exampleModel->where('example_id' '=', $_exampleModel->getExampleId())
                        ->delete();

```

- Hasta los momentos, no hemos hablado de los métodos especiales `where();` o `orWhere();` a profundidad, ambos cumplen una misma funcionalidad el cual es el filtrar de manera más sencilla los registros. No obstante, se cambian sus operadores por condición, es decir, `where();` usará el operador `AND`, mientras que `orWhere();` utilizará el operador `OR`. Además, estos cuentan con ciertas propiedades a considerar:
  
  - Pueden ser anidados.
  - Si se usa un solo un condicional se pueden usar cualquiera de los dos `where();` o `orWhere();`. Preferiblemente usar el `where();`.
  - Al ser anidados, se pueden utilizar ambos a la vez.

Aquí algunos ejemplos de cómo funcionan:

```PHP

//Ejemplo 1

$_exampleModel->setName('exampleQuery');
$_exampleModel->setExampleId(4);

$response = $_exampleModel->where('name', '=', $_exampleModel->getName())
                        ->where('example_id', '=', $_exampleModel->getExampleId())
                        ->update();
             
// SQL output example: "UPDATE example SET name = exampleQuery WHERE name = exampleQuery AND example_id = 4"; 

//Ejemplo 1 (Con orWhere)

$_exampleModel->setName('exampleQuery');
$_exampleModel->setExampleId(4);

$response = $_exampleModel->where('name', '=', $_exampleModel->getName())
                        ->orWhere('example_id', '=', $_exampleModel->getExampleId())
                        ->update();
             
// SQL output example: "UPDATE example SET name = exampleQuery WHERE name = exampleQuery OR example_id = 4"; 

/*--------------------------------------------------------------*/

//Ejemplo 2 (Necesitamos obtener todos los registros que tengan nombre: Oriana, Francis o Enrique)

$data = $_exampleModel->where('name', '=', 'Oriana')
                    ->orWhere('name', '=', 'Francis')
                    ->orWhere('name', '=', 'Enrique')
                    ->getAll();

// SQL output example: "SELECT * FROM example WHERE name = 'Oriana' OR name = 'Francis' OR name = 'Enrique'";

/*--------------------------------------------------------------*/

//Ejemplo 3 (Necesitamos obtener todos los registros que sean mayor de edad, se encuentren en cualquier estado menos 'registrado' y vivan en Venezuela o Colombia)

$data = $_exampleModel->where('age', '>=', 18)
                    ->where('status', '!=', 'REGISTERED')
                    ->where('country', '=', 'Venezuela')
                    ->orWhere('country', '=', 'Colombia')
                    ->getAll();

// SQL output example: "SELECT * FROM usuarios WHERE age >= 18 AND status != 'REGISTERED' AND country = 'Venezuela' OR country = 'Colombia'; 

```

> #### Controladores:

Para los controladores, contamos con una clase base llamada `Controller` la cual nos permitirá usar el método `view();` para renderizar las vistas, esta clase base a su vez deberá también ser heredada por nuestros controladores que en este caso no requerimos utilizar ningún método mágico como el `__construct();`. Asimismo, por convención, se definirá un método `index();` en cada controlador el cual será la vista principal del mismo y la palabra **Controller** luego de especificar su nombre. 

Ejemplo para la creación de un controlador:

```PHP

class ExampleController extends Controller{

    //Atributos (opcional)

    //Constructor (opcional)

    public function index(){

        /** Método view();
         * @param string $file //Nombre del archivo, por defecto la ruta será /views/
         * @param array $variables = null (optional) //Array de variables para usar en la vista
        */ 

        //Para encontrar el archivo de la vista sería de esta manera:

        $fileName = 'exampleView.php'; //La ruta sería views/exampleView.php

        $fileName = 'exampleFolder/exampleView.php'; //La ruta sería views/exampleFolder/exampleView.php

        $fileName = 'exampleFolder/exampleView' //Mismo funcionamiento que la anterior pero sin especificar la extensión del archivo.

        //Nótese que hay que retornar el método view();
        return $this->view($fileName);

    }

    //Método index pero pasando variables a las vistas
    public function indexVar(){

        $exampleVars = [
            'exampleVar1' => 'exampleValue1'
            'exampleVar2' => 'exampleValue2'
            'exampleVar3' => 'exampleValue3'
        ];
        
        //Para usarlas en las vistas sería colocar el nombre de la llave, es decir: $exampleVar1, exampleVar2, exampleVar3

        //También podemos enviar variables tipo array

        $exampleVars = [
            'exampleArray1' => [
                'exampleKey1' => 'exampleValue1',
                'exampleKey2' => 'exampleValue2',
                'exampleKey3' => 'exampleValue3'
            ],
            'exampleArray2' => [
                'exampleKey1' => 'exampleValue1',
                'exampleKey2' => 'exampleValue2',
                'exampleKey3' => 'exampleValue3'
            ]
        ];

        //Para usarlas en las vistas sería de la siguiente manera: $exampleArray1['exampleKey1'], $exampleArray2['exampleKey3'] ...


        return $this->view('exampleView', $exampleVars);

    }

    //Métodos adicionales usando los modelos u otras vistas
}

```

Cabe resaltar que también contamos con una clase `Response`, que será de utilidad para retornar la respuesta de un método del controlador. Para su uso solo basta crear un objeto de esta clase y pasarle los datos preferiblemente por su método mágico `__construct()` de esta manera:

```PHP

/** Método __construct del response
 * @param string $code = null
 * @param string $message = null
 * @param mixed $data = null
*/

//Ejemplo 1

$_response = new Response();

$_response->setCode('SUCCESS');
$_response->setMessage('exampleMessage');
$_response->setData(['exampleData' => 'exampleValue']);

return $_response;

//Ejemplo 2 (Sin enviar mensaje personalizado)

//Podemos enviar los datos en el mismo constructor o haciendo uso del setter
$_response = new Response('SUCCESS');

$_response->setData($data);

return $_response;

//Ejemplo 3 (Enviando la respuesta en formato JSON)

$_response = new Response('FAILED','',$data);

/** Método json();
 * @param int $status //Código de la respuesta
 * @param object/array $obj = null (optional)
*/

//Nótese que si establecemos el atributo $data de la clase Response, podemos llamar el método json directamente sin enviarle el segundo parámetro el cual serían los datos
return $_response->json(200);

//Ejemplo 4 (Enviando un objeto en formato JSON)

$_response = new Response();

$data = [
    'ok' => true,
    'data' => [
        'exampleKey' => 'exampleValue'
    ]
];

return $_response->json(200, $data);

```

Y para recibir datos JSON enviado por medio de JS basta con incluir en nuestrro método la función nativa file_get_contents() junto a json_decode() de esta manera:

```PHP

$data = json_decode(file_get_contents('php://input'), true);

```

> #### Vistas: 

A pesar de contar con una clase `View`, no hace falta usarla, puesto que, el controlador se encarga de proveeneros el método `view()` para no tener que crear un objeto de esta clase en cada método de vista. 

Sin embargo, existe una clase llamada `Url` la cual será de utilidad en la creación de vistas, más especificamente, en la incorporación/solicitud de archivos (JS, CSS, IMG, etc...) que podemos usar de la siguiente manera:

```PHP

/** Método estático to()
 * @param string $url
 * @return string basePath . 'url'
*/

<script src="<?php echo Url::to('assets/js/example/example.js'); ?>"></script>

```

Algo a tener en cuenta, es que esta clase `Url` no puede ser usada en los include/require de PHP, pues nos terminará arrojando errores. No obstante, para simplificar la codificación de las rutas, podemos usar las constantes de las rutas que se encuentran definidias en el archivo `config.php` de esta manera:

```PHP

<head>

//Primera forma
include PATH_VIEWS . 'partials/header.php';

//Segunda forma
include constant('PATH_VIEWS') . 'partials/header.php';

</head>

```

> #### Rutas:

Una vez tengamos definido el controlador, podemos establecer las rutas para cada método/vista que deseemos especificando su método HTTP, de los cuales tendremos disponible: `GET`, `POST`, `PUT`, `PATCH`, `DELETE`.

Para comenzar a establecer las rutas, debemos dirigirnos al archivo `routes.php` que se encuentra ubicado en la carpeta `routes` y utilizar la clase `Router` la cual contiene método estáticos de los métodos HTTP, es decir: `get()` , `post()`, `put()`, `patch()`, `delete()`. Aquí algunas maneras de como establecer las rutas:

```PHP

/** Cualquier método HTTP
 * @param string $uri
 * @param mixed $function = null
*/

Router::get('/example', function(){

    return "I'm a example";
});

//Recibiendo parámetros (Primera forma)

Router::get('/example', function(Request $request){

    //Nótese que el atributo del Request debe ser igual al que se pase por la ruta, es decir en este caso es 'exampleValue' pero si nosotros pasamos algo tipo: basepath/example?exampleValuee=123, se creará un atributo con ese nombre y no con el 'exampleValue'

    return $request->exampleValue;
});

//Recibiendo parámetros (Segunda forma)

Router::get('/example/:exampleValue', function($exampleValue){
    
    return $exampleValue;
});

```

La anterior forma de crear las rutas serviría en un contexto simple, puesto que, para hacerlo de una mejor manera, podemos pasar los controladores directamente de esta manera:

```PHP

//En vez de pasar una función en el segundo parámetro, pasamos el nombre de la clase + el método. En este caso no hace especificar el método ya que estamos usando la ruta base y automáticamente por defecto toma el método index() del controlador.

Router::get('/', ExampleController::class);

```

Para especificar los métodos del controlador podemos hacerlo de dos forma de esta manera:

```PHP

//Primera forma

Router::post('/exampleRegister', ExampleController::class . '@insertExample');

//Segunda forma

Router::post('/insert_example', ExampleController::class);

//Tercera forma (misma que la segunda pero utilizando '-' en vez de '_')

Router::post('/insert-example', ExampleController::class);

```

Usando la primera forma, debemos no solo especificar el nombre de la clase, sino también un '@' seguido del nombre del método en cuestión que por supuesto deberá ser idéntico a como se llame en el controlador.

Para el segundo y tercer método que son idénticos (simplemente cambia el símbolo '-' y '_'), es diferente, pues estaremos llamando al método directamente del controlador separado por alguno de los símbolos. Un ejemplo de ello puede ser el siguiente: 

```PHP

//Suponiendo que tengamos un método en el controlador ExampleController llamado thisIsAExampleMethod la manera de llamarlo con la segunda forma sería la siguiente:

Router::post('/this_is_a_example_method', ExampleController::class);

//Mientras que de la primera forma sería:

Router::post('/exampleMethod', ExampleController::class . '@thisIsAExampleMethod');

```

La dos formas de hacerlas son correctas y dependerá mucho del nombre del método y su función.

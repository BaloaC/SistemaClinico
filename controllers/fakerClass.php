<?php

require_once './vendor/fakerphp/faker/src/autoload.php';

    class fakerClass extends Controller {

        public function usarFaker()
        {

            $faker = Faker\Factory::create('es_ES');

            $datos = [];

            for ($i = 0; $i < 20; $i++) {
                $nombre = $faker->company;
                $ubicacion = $faker->city;

                $datos[] = [
                    'nombre' => $nombre,
                    'ubicacion' => $ubicacion,
                ];
                echo $datos;
                exit();
                // $_proveedorModel = new ProveedorModel();
                // $_proveedorModel->insert($datos);
            }

        }
    }
?>
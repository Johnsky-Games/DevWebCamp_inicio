<?php

namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image; // Importar la clase Image de Intervention para manipular imágenes en el servidor
use Model\Paquete;

class RegistroController
{
    public static function crear(Router $router)
    {
        if (!isAuth()) {
            header('Location: /login');
        }

        //Verificar si el usuario ya está registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if (isset($registro) && $registro->paquete_id === "3") {
            header('Location: /boleto?id=' . urlencode($registro->token));
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro',
        ]);
    }

    public static function gratis(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isAuth()) {
                header('Location: /login');
            }

            //Verificar si el usuario ya está registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if (isset($registro) && $registro->paquete_id === "3") {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            //Crear registros
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if ($resultado) {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }
        }
    }

    public static function boleto(Router $router)
    {
        if (!isAuth()) {
            header('Location: /login');
        }

        //Validar la URL
        $id = $_GET['id'] ?? null;
        if (!$id || !strlen($id) === 8) {
            header('Location: /');
        }

        //Buscarlo en DB
        $registro = Registro::where('token', $id);
        if (!$registro) {
            header('Location: /');
        }

        // Llenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);
        // debuguear($registro);
        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }
}
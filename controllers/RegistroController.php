<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Regalo;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image; // Importar la clase Image de Intervention para manipular imágenes en el servidor

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

    public static function pagar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isAuth()) {
                header('Location: /login');
            }

            //Validar que POST no venga vacío
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }

            //Crear el registro

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            $datos =$_POST;
            $datos['token'] = $token;
            $datos['usuario_id'] = $_SESSION['id'];

            
            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }
    
    public static function conferencias(Router $router)
    {
        if(!isAuth()){
            header('Location: /login');
        }

        //Validar que el usuario tenga el plan presencial
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if($registro->paquete_id !== '1'){
            header('Location: /');
        }

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateados = [];
        foreach ($eventos as $evento) {

                $evento->categoria = Categoria::find($evento->categoria_id);
                $evento->dia = Dia::find($evento->dia_id);
                $evento->hora = Hora::find($evento->hora_id);
                $evento->ponente = Ponente::find($evento->ponente_id);
                
            if ($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_v'][] = $evento;
            }

            if ($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_s'][] = $evento;
            }

            if ($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_v'][] = $evento;
            }

            if ($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_s'][] = $evento;
            }
        }

        $regalos = Regalo::all('ASC');

        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'registro' => $registro,
            'regalos' => $regalos
        ]);
    }
}
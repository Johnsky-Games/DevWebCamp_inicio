<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image; // Importar la clase Image de Intervention para manipular imágenes en el servidor

class PonentesController
{
    public static function index(Router $router)
    {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/ponentes?page=1');
        }

        $registros_por_pagina = 10;

        $total = Ponente::total();

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        
        if ($paginacion->totalPaginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        
        }
        
        $ponentes = Ponente::paginar($registros_por_pagina,$paginacion->offset());
        if (!isAdmin()) {
            header('Location: /login');
        }


        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function crear(Router $router)
    {
        if (!isAdmin()) {
            header('Location: /login');
        }
        $alertas = [];
        $ponente = new Ponente;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isAdmin()) {
                header('Location: /login');
            }

            //Leer imagen

            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                //Crear la carpeta sino existe

                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                //Generar versiones .png y .webp
                $img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600)->encode('png', 80);
                $img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            //Sincronizar datos
            $ponente->sincronizar($_POST);

            //Validar
            $alertas = $ponente->validar();

            //Guardar el regsitro en la base de datos
            if (empty($alertas)) {
                //Guardar las imagenes
                $img_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $img_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');

                //Guardar en la base de datos

                $resultado = $ponente->guardar();


                if ($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente / Conferencista',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }
    public static function editar(Router $router)
    {
        if (!isAdmin()) {
            header('Location: /login');
        }

        $alertas = [];

        //Validar Id
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/ponentes');
        }

        //Obtener el ponente a editar
        $ponente = Ponente::find($id);

        if (!$ponente) {
            header('Location: /admin/ponentes');
        }

        $ponente->imagen_actual = $ponente->imagen;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isAdmin()) {
                header('Location: /login');
            }

            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                //Crear la carpeta sino existe

                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                //Generar versiones .png y .webp
                $img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600)->encode('png', 80);
                $img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    $img_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $img_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                }
            }
            $resultado = $ponente->guardar();

            if ($resultado) {
                header('Location: /admin/ponentes');
            }
        }

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'ponente' => $ponente,
            'alertas' => $alertas,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function eliminar()
    {
        if (!isAdmin()) {
            header('Location: /login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $ponente = Ponente::find($id);
            if (!isset($ponente)) {
                header('Location: /admin/ponentes');
            }
            $resultado = $ponente->eliminar();
            if ($resultado) {
                header('Location: /admin/ponentes');
            }
        }
    }
}
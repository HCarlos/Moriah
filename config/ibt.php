<?php


return [

    'images_type_validate' => 'jpg,jpeg,gif,png,svg,bmp,JPG,JPEG,GIF,PNG,SVG,BMP',
    'images_type_extension' => ['jpg','jpeg','gif','png','svg','bmp','JPG','JPEG','GIF','PNG','SVG','BMP'],
    'videos_type_extension' => ['mp4','3gp','bin'],
    'excel_type_extension' => ['xlsx','xls'],

    'file_max_bytes'           => '1024000',

    'doctos_type_validate' => 'xlsx,xls,pdf,docx,doc,pptx,ppt',
    'doctos_type_extension' => ['xlsx','xls','pdf','docx','doc','pptx','ppt'],

    'file_dropzone_mimetype' => 'image/jpg,image/jpeg,image/gif,image/png,image/JPG,image/JPEG,image/GIF,image/PNG,video/mp4,video/3gp,image/svg+xml,video/quicktime,video/quicktime',

    'limite_maximo_registros' => 200,
    'limite_minimo_registros' => 100,
    'maximo_registros_consulta' => 200,
    'minimo_registrios_consulta' => 100,

    // ------------------------,-----------------------------------
    // Aqui se deben configurar los formatos a utilizar.
    // -----------------------------------------------------------

    'archivos'=>[

        'fmt_lista_usuarios'      => 'fmt_lista_usuarios.xlsx',
        'fmt_lista_familias'      => 'fmt_lista_familias.xlsx',
        'fmt_lista_catalogos'     => 'fmt_lista_catalogos.xlsx',
        'icono_video_png'         => 'icon-video.png',
        'archivos_txt'            => 'archivo.txt',
        'archivos_json'           => 'archivo.json',
        'archivos_imagen_jpg'     => 'archivo.jpg',

    ],

    // ARCHIVOS DE IMAGENES DEL SISTEMA
    'logo_reportes_encabezado' => public_path().'/images/web/logo-0.png',

    // -----------------------------------------------------------
    // La mayor parte de los Tablas estan configuradas aquí,
    // es en este mismo sitio donde la debes mantener forerver
    // -----------------------------------------------------------

    'table_names' => [

        'users' => [
            'users'         => 'users',
            'roles'         => 'roles',
            'permissions'   => 'permissions',
            'user_adress'   => 'user_adress',
            'user_extend'   => 'user_extend',
            'user_social'   => 'user_social',
            'categorias'    => 'categorias',
            'imagenes'      => 'imagenes',
            'parentescos'   => 'parentescos',
            'role_user'     => 'role_user',
            'permission_user' => 'permission_user',
            'permission_role' => 'permission_role',
            'users' => 'users',

        ],

        'catalogos' => [
            'users'          => 'users',
            'empresas'       => 'empresas',
            'ciclos'         => 'ciclos',
            'subciclos'      => 'subciclos',
            'niveles'        => 'niveles',
            'grados'         => 'grados',
            'alumnos'        => 'alumnos',
            'familias'       => 'familias',

        ],

        'relaciones' => [
            'ciclo_subciclo'        => 'ciclo_subciclo',
            'imagen_user'           => 'imagen_user',
            'familia_familiar_user' => 'familia_familiar_user',
        ],

        'biblos' => [
            'codigo_lenguaje_paises'       => 'codigo_lenguaje_paises',
            'editoriales'       => 'editoriales',
            'fichas'       => 'fichas',
            'editoriale_ficha'       => 'editoriale_ficha',
            'ficha_portada'       => 'ficha_portada',
            'portadas' => 'portadas',

        ],

    ],

    'style' => [
        'denuncia' => "<style>
                            b { font-family: arial, sans-serif; }
                            bAzul { font-family: arial, sans-serif; color:blue; }
                            p {text-align: justify;}
                            bVerde { font-family: arial, sans-serif; color:green; }
                            bChocolate { font-family: arial, sans-serif; color:chocolate; }
                            bOrange { font-family: arial, sans-serif; color:orangered; }
                            span { font-family: arial, sans-serif; text-align: center; }
                       </style>",
    ],



];


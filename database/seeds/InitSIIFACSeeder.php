<?php

use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Concepto;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\FamiliaCliente;
use App\Models\SIIFAC\FamiliaProducto;
use App\Models\SIIFAC\Medida;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Proveedor;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class InitSIIFACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $IdEmp1 = Empresa::findOrCreateEmpresa('COMERCIALIZADORA ARJI, S.A. DE C.V.','COMERCIALIZADORA ARJI, S.A. DE C.V.','AV. MEXICO #2 COL. DEL BOSQUE, VILLAHERMOSA, TABASCO CP.86160','CAR-930816-FH0');
        $IdEmp2 = Empresa::findOrCreateEmpresa('LIBROS 2006/2007', 'LIBROS 2006/2007','AVENIDA MEXICO #2','');
        $IdEmp3 = Empresa::findOrCreateEmpresa('Empresa 3', 'Empresa 3','AVENIDA MEXICO #2','');

        $IdEmp = $IdEmp1->id;

        $IdAlma1 = Almacen::findOrCreateAlmacen(1,'LIBROS','JESUS GABRIEL',3,'LB',$IdEmp);
        $IdAlma2 = Almacen::findOrCreateAlmacen(2,'UNIFORMES','LEZBITH',3,'UN',$IdEmp);
        $IdAlma3 = Almacen::findOrCreateAlmacen(2,'CUADERNOS','KIKE',3,'CU',$IdEmp);
        $IdAlma = $IdAlma1->id;

        $IdFP1 = FamiliaProducto::findOrCreateFamiliaProducto(1,'KINDER',0.00,1,$IdEmp);
        $IdFP2 = FamiliaProducto::findOrCreateFamiliaProducto(2,'PRIMARIA',0.00,1,$IdEmp);
        $IdFP3 = FamiliaProducto::findOrCreateFamiliaProducto(3,'SECUNDARIA',0.00,1,$IdEmp);
        $IdFP4 = FamiliaProducto::findOrCreateFamiliaProducto(4,'PREPARATORIA',0.00,1,$IdEmp);
        $IdFP5 = FamiliaProducto::findOrCreateFamiliaProducto(5,'SERVICIOS',0.00,1,$IdEmp);

        $IdFC1 = FamiliaCliente::findOrCreateFamiliaCliente('MAESTROS',$IdEmp);
        $IdFC2 = FamiliaCliente::findOrCreateFamiliaCliente('VARIOS',$IdEmp);
        $IdFC3 = FamiliaCliente::findOrCreateFamiliaCliente('PUBLICO EN GENERAL',$IdEmp);

        $IdCon1 = Concepto::findOrCreateConcepto(false,-1,'DEVOLUCION DE EFECTIVO',0.00,$IdEmp);
        $IdCon2 = Concepto::findOrCreateConcepto(true,1,'CARGO COMISION 20%',0.00,$IdEmp);

        $IdMed1 = Medida::findOrCreateMedida('PIEZA','',0,$IdEmp);
        $IdMed = $IdMed1->id;

        $IdProd1 = Producto::findOrCreateProducto($IdAlma,1,$IdMed,5,'010500100005','MATERIAL DIDACTICO','MATERIAL DIDACTICO',5000,1,false,NOW(),'',850,0,0,53,850,45050,$IdEmp);


        $IdProv = Proveedor::findOrCreateProveedor(1,'JORJUBEL','JULIO URRETA','MEXICO',$IdEmp);

//        $user = User::find(1);
//        $user->familiasClientes()->attach($IdFC1);
//        $user->familiasClientes()->attach($IdFC2);
//        $user->familiasClientes()->attach($IdFC3);

        $Paq1 = Paquete::findOrCreatePaquete(1,'110615120716','PAQUETE 2° DE SECUNDARIA ESP.',0,$IdEmp);
        $Paq2 = Paquete::findOrCreatePaquete(1,'010300196385','CUOTA DE COMPUTACION 3° SEC',0,$IdEmp);
        $Paq3 = Paquete::findOrCreatePaquete(1,'978607050233','CUOTA DHP 3° SEC',0,$IdEmp);
        $Paq4 = Paquete::findOrCreatePaquete(1,'978110749787','PREPARE 5, WORKBOOK',0,$IdEmp);
        $Paq5 = Paquete::findOrCreatePaquete(1,'978052118829','CAMBRIDGE PET FOR SCHOOLS 1',0,$IdEmp);
        $Paq6 = Paquete::findOrCreatePaquete(1,'010400179315','CALCULADORA CASIO',0,$IdEmp);
        $Paq7 = Paquete::findOrCreatePaquete(1,'978019433217','SELECT READINGS UPPER-INTERMED',0,$IdEmp);
        $Paq8 = Paquete::findOrCreatePaquete(1,'010300121126','PAQUETE 3 SEC ESPAÑOL',0,$IdEmp);
        $Paq9 = Paquete::findOrCreatePaquete(1,'110615120149','PAQUETE 1° DE SECUNDARIA',0,$IdEmp);
        $Paq10 = Paquete::findOrCreatePaquete(1,'978131650298','CAMBRIDGE FCE 2, PT',0,$IdEmp);
        $Paq11 = Paquete::findOrCreatePaquete(1,'010400100002','PAQUETE 1° PREPA CAE',0,$IdEmp);
        $Paq12 = Paquete::findOrCreatePaquete(1,'110615115908','PAQUETE 6° DE PRIMARIA',0,$IdEmp);
        $Paq13 = Paquete::findOrCreatePaquete(1,'978607172008','INVENTARIOS DE ORIENTACION PRO',0,$IdEmp);
        $Paq14 = Paquete::findOrCreatePaquete(1,'770689497253','COMPETENCIAS LECTORAS 2',0,$IdEmp);
        $Paq15 = Paquete::findOrCreatePaquete(1,'010400124135','COMPLETE CAE, STUDENTS BOOK',0,$IdEmp);
        $Paq16 = Paquete::findOrCreatePaquete(1,'110615115652','PAQUETE 5° DE PRIMARIA',0,$IdEmp);
        $Paq17 = Paquete::findOrCreatePaquete(1,'978110769267','CAMBRIDGE FCE 1, PT',0,$IdEmp);
        $Paq18 = Paquete::findOrCreatePaquete(1,'978607012414','MI CASA FUERON MIS PALABRAS',0,$IdEmp);
        $Paq19 = Paquete::findOrCreatePaquete(1,'978607072876','DOCE CUENTOS PEREGRINOS',0,$IdEmp);
        $Paq20 = Paquete::findOrCreatePaquete(1,'770689420133','EL RETRATO DE DORIAN GREY',0,$IdEmp);
        $Paq21 = Paquete::findOrCreatePaquete(1,'110615115322','PAQUETE 4° DE PRIMARIA',0,$IdEmp);
        $Paq22 = Paquete::findOrCreatePaquete(1,'978607758679','VIDA Y CONOCIMIENTO: CIENCIAS',0,$IdEmp);
        $Paq23 = Paquete::findOrCreatePaquete(1,'978607100430','ORTOGRAFIA PARA SEC. 1',0,$IdEmp);
        $Paq24 = Paquete::findOrCreatePaquete(1,'750600759516','ESPAÑOL 1 SEC',0,$IdEmp);
        $Paq25 = Paquete::findOrCreatePaquete(1,'010400149657','CUOTA DE COMPUTACION 1° PREPA',0,$IdEmp);
        $Paq26 = Paquete::findOrCreatePaquete(1,'978607210800','FORMACION CIVICA Y ETICA 2',0,$IdEmp);
        $Paq27 = Paquete::findOrCreatePaquete(1,'110615115146','PAQUETE 3° DE PRIMARIA',0,$IdEmp);
        $Paq28 = Paquete::findOrCreatePaquete(1,'978052115609','ENGLISH IN MIND STD BOOK 2',0,$IdEmp);
        $Paq29 = Paquete::findOrCreatePaquete(1,'978052112300','ENGLISH IN MIND WORKBOOK 2',0,$IdEmp);
        $Paq30 = Paquete::findOrCreatePaquete(1,'978607050230','CUOTA DHP 6° PRIM',0,$IdEmp);
        $Paq31 = Paquete::findOrCreatePaquete(1,'978968248254','MI LIBRO FAVORITO MATEMATICAS',0,$IdEmp);
        $Paq32 = Paquete::findOrCreatePaquete(1,'978607849518','GEOGRAFIA DE MEXICO Y DEL MUND',0,$IdEmp);
        $Paq33 = Paquete::findOrCreatePaquete(1,'110615115017','PAQUETE 2° DE PRIMARIA',0,$IdEmp);
        $Paq34 = Paquete::findOrCreatePaquete(1,'978019433212','SELECT READINGS INTERMEDIATE',0,$IdEmp);
        $Paq35 = Paquete::findOrCreatePaquete(1,'978110767516','COMPLETE FIRTS FOR SCHOOL STD',0,$IdEmp);
        $Paq36 = Paquete::findOrCreatePaquete(1,'978110767179','COMPLETE FIRTS FOR SCHOOL WORK',0,$IdEmp);
        $Paq37 = Paquete::findOrCreatePaquete(1,'110615114847','PAQUETE 1° DE PRIMARIA',0,$IdEmp);
        $Paq38 = Paquete::findOrCreatePaquete(1,'978019480252','FAMILY AND FRIENDS, READERS PA',0,$IdEmp);
        $Paq39 = Paquete::findOrCreatePaquete(1,'978607210665','FORMACIÓN CÍVICA Y ÉTICA 1',0,$IdEmp);
        $Paq40 = Paquete::findOrCreatePaquete(1,'849918941917','EL MISTERIO DE LOS MUTILADOS',0,$IdEmp);
        $Paq41 = Paquete::findOrCreatePaquete(1,'978607012459','LAS CHICAS DE ALAMBRE',0,$IdEmp);
        $Paq42 = Paquete::findOrCreatePaquete(1,'978607013428','ESTA HERIDA QUE DUELE Y NO SE',0,$IdEmp);
        $Paq43 = Paquete::findOrCreatePaquete(1,'110615114307','PAQUETE KINDER 3',0,$IdEmp);
        $Paq44 = Paquete::findOrCreatePaquete(1,'110615114631','PAQUETE 1° DE INGLES',0,$IdEmp);
        $Paq45 = Paquete::findOrCreatePaquete(1,'770689497255','COMPETENCIAS LECTORAS 4',0,$IdEmp);
        $Paq46 = Paquete::findOrCreatePaquete(1,'978968569847','ABRAPALABRA 4',0,$IdEmp);
        $Paq47 = Paquete::findOrCreatePaquete(1,'978607910715','ACENTO 4, ORTOGRAFIA',0,$IdEmp);
        $Paq48 = Paquete::findOrCreatePaquete(1,'110615113816','PAQUETE KINDER 2',0,$IdEmp);
        $Paq49 = Paquete::findOrCreatePaquete(1,'978607910712','ACENTO 1, ORTOGRAFIA',0,$IdEmp);
        $Paq50 = Paquete::findOrCreatePaquete(1,'770689497252','COMPETENCIAS LECTORAS 1',0,$IdEmp);
        $Paq51 = Paquete::findOrCreatePaquete(1,'978968569844','ABRAPALABRA 1',0,$IdEmp);
        $Paq52 = Paquete::findOrCreatePaquete(1,'110615113643','PAQUETE KINDER 1',0,$IdEmp);
        $Paq53 = Paquete::findOrCreatePaquete(1,'160625120155','PAQUETE 1° PREPA CAE',0,$IdEmp);
        $Paq54 = Paquete::findOrCreatePaquete(1,'978110763148','COMPLETE CAE, WORKBOOK',0,$IdEmp);
        $Paq55 = Paquete::findOrCreatePaquete(1,'978052118038','PREPARE 7, WORKBOOK',0,$IdEmp);
        $Paq56 = Paquete::findOrCreatePaquete(1,'010400124135','COMPLETE CAE, STUDENTS BOOK',0,$IdEmp);
        $Paq57 = Paquete::findOrCreatePaquete(1,'978110762839','OBJECTIVE FIRST WORKBOOK',0,$IdEmp);
        $Paq58 = Paquete::findOrCreatePaquete(1,'010300121132','PAQUETE 1 SEC',0,$IdEmp);
        $Paq59 = Paquete::findOrCreatePaquete(1,'978607426254','LITTLE SPARKS 2, ACTIVITY PAD',0,$IdEmp);
        $Paq60 = Paquete::findOrCreatePaquete(1,'978607426252','LITTLE SPARKS 3, STUDENTS BOOK',0,$IdEmp);
        $Paq61 = Paquete::findOrCreatePaquete(1,'978607426255','LITTLE SPARKS 3, ACTIVITY PAD',0,$IdEmp);
        $Paq62 = Paquete::findOrCreatePaquete(1,'506300411913','PASITO A PASITO, LECTO-ESCRITU',0,$IdEmp);
        $Paq63 = Paquete::findOrCreatePaquete(1,'010100165893','CUADERNO DE EJERCICIOS CALIGRA',0,$IdEmp);
        $Paq64 = Paquete::findOrCreatePaquete(1,'978607050234','CUOTA DHP KIII',0,$IdEmp);
        $Paq65 = Paquete::findOrCreatePaquete(1,'110615121801','PAQUETE 2° DE SECUNDARIA PET',0,$IdEmp);
        $Paq66 = Paquete::findOrCreatePaquete(1,'110615122121','PAQUETE 2° DE SECUNDARIA FCE',0,$IdEmp);
        $Paq67 = Paquete::findOrCreatePaquete(1,'010400179315','CALCULADORA CASIO',0,$IdEmp);
        $Paq68 = Paquete::findOrCreatePaquete(1,'978607050231','CUOTA DHP 1° SEC',0,$IdEmp);
        $Paq69 = Paquete::findOrCreatePaquete(1,'010300100096','CUOTA DE COMPUTACION 1° SEC',0,$IdEmp);
        $Paq70 = Paquete::findOrCreatePaquete(1,'110615122613','PAQUETE 3° DE SECUNDARIA ESP.',0,$IdEmp);
        $Paq71 = Paquete::findOrCreatePaquete(1,'978052118560','ENGLISH IN MIND 3, WORKBOOK',0,$IdEmp);
        $Paq72 = Paquete::findOrCreatePaquete(1,'978052115948','ENGLISH IN MIND 3, STUDENTS BO',0,$IdEmp);
        $Paq73 = Paquete::findOrCreatePaquete(1,'010400100001','PAQUETE 1° PREPA FCE',0,$IdEmp);
        $Paq74 = Paquete::findOrCreatePaquete(1,'978607050229','CUOTA DHP 5° PRIM',0,$IdEmp);
        $Paq75 = Paquete::findOrCreatePaquete(1,'978019479880','OXFORD ADVANCED LEARNERS DICTI',0,$IdEmp);
        $Paq76 = Paquete::findOrCreatePaquete(1,'978607050225','CUOTA DHP 1° PRIM',0,$IdEmp);
        $Paq77 = Paquete::findOrCreatePaquete(1,'010200165556','CUOTA DHP 1° INGLES',0,$IdEmp);
        $Paq78 = Paquete::findOrCreatePaquete(1,'010500100005','MATERIAL DIDACTICO',0,$IdEmp);
        $Paq79 = Paquete::findOrCreatePaquete(1,'110615123325','PAQUETE 3° SECUNDARIA PET',0,$IdEmp);
        $Paq80 = Paquete::findOrCreatePaquete(1,'978052174648','COMPLETE PET, STUDENTS BOOK',0,$IdEmp);
        $Paq81 = Paquete::findOrCreatePaquete(1,'978607426253','LITTLE SPARKS 1, ACTIVITY PAD',0,$IdEmp);
        $Paq82 = Paquete::findOrCreatePaquete(1,'978607171583','JUEGO CON TRAZOS Y NUMEROS 2',0,$IdEmp);
        $Paq83 = Paquete::findOrCreatePaquete(1,'978607774383','FIGURAS Y FORMAS  NIVEL INTERM',0,$IdEmp);
        $Paq84 = Paquete::findOrCreatePaquete(1,'110615123854','PAQUETE 3° SECUNDARIA FCE',0,$IdEmp);
        $Paq85 = Paquete::findOrCreatePaquete(1,'010400100006','PAQUETE 3° PREPA CAE',0,$IdEmp);
        $Paq86 = Paquete::findOrCreatePaquete(1,'010400100004','PAQUETE 2° PREPA CAE',0,$IdEmp);
        $Paq87 = Paquete::findOrCreatePaquete(1,'010400100005','PAQUETE 3° PREPA FCE',0,$IdEmp);
        $Paq88 = Paquete::findOrCreatePaquete(1,'010400100003','PAQUETE 2° PREPA FCE',0,$IdEmp);
        $Paq89 = Paquete::findOrCreatePaquete(1,'160625120455','PAQUETE 3° PREPA CAE',0,$IdEmp);
        $Paq90 = Paquete::findOrCreatePaquete(1,'978110748234','PREPARE 5, STUDENTŽS BOOK',0,$IdEmp);
        $Paq91 = Paquete::findOrCreatePaquete(1,'978110762834','OBJECTIVE FIRST STUDENTS BOOK',0,$IdEmp);
        $Paq92 = Paquete::findOrCreatePaquete(1,'978607100431','ORTOGRAFIA PARA SECUNDARIA 2',0,$IdEmp);
        $Paq93 = Paquete::findOrCreatePaquete(1,'750600759520','ESPAÑOL 2 SEC',0,$IdEmp);
        $Paq94 = Paquete::findOrCreatePaquete(1,'010300121133','PAQUETE 2° SEC. ESPAÑOL',0,$IdEmp);
        $Paq95 = Paquete::findOrCreatePaquete(1,'010500100005','MATERIAL DIDACTICO',0,$IdEmp);
        $Paq96 = Paquete::findOrCreatePaquete(1,'010100121112','PAQUETE DE KINDER 2',0,$IdEmp);
        $Paq97 = Paquete::findOrCreatePaquete(1,'010100121113','PAQUETE DE KINDER 3',0,$IdEmp);
        $Paq98 = Paquete::findOrCreatePaquete(1,'010200121114','PAQUETE 1 INGLES',0,$IdEmp);
        $Paq99 = Paquete::findOrCreatePaquete(1,'160625120326','PAQUETE 2° PREPA CAE',0,$IdEmp);
        $Paq100 = Paquete::findOrCreatePaquete(1,'010100121111','PAQUETE DE KINDER 1',0,$IdEmp);
        $Paq101 = Paquete::findOrCreatePaquete(1,'978607172763','JUGUEMOS A LEER',0,$IdEmp);
        $Paq102 = Paquete::findOrCreatePaquete(1,'978607910713','ACENTO 2, ORTOGRAFIA',0,$IdEmp);
        $Paq103 = Paquete::findOrCreatePaquete(1,'978019480863','FAMILY AND FRIENDS 2, WORKBOOK',0,$IdEmp);
        $Paq104 = Paquete::findOrCreatePaquete(1,'978019480830','FAMILY AND FRIENDS 2, CLASS BO',0,$IdEmp);
        $Paq105 = Paquete::findOrCreatePaquete(1,'978110763148','COMPLETE CAE, WORKBOOK',0,$IdEmp);
        $Paq106 = Paquete::findOrCreatePaquete(1,'978607050235','CUOTA DHP 2° PREPA',0,$IdEmp);
        $Paq107 = Paquete::findOrCreatePaquete(1,'770689497256','COMPETENCIAS LECTORAS 5',0,$IdEmp);
        $Paq108 = Paquete::findOrCreatePaquete(1,'978607071508','PERSONA NORMAL',0,$IdEmp);
        $Paq109 = Paquete::findOrCreatePaquete(1,'978052112470','COMPLETE KEY FOR SCHOOL STD BK',0,$IdEmp);
        $Paq110 = Paquete::findOrCreatePaquete(1,'978968569849','ABRAPALABRA 6',0,$IdEmp);
        $Paq111 = Paquete::findOrCreatePaquete(1,'770689497257','COMPETENCIAS LECTORAS 6',0,$IdEmp);
        $Paq112 = Paquete::findOrCreatePaquete(1,'770689420155','VEINTE POEMAS DE AMOR Y UNA CA',0,$IdEmp);
        $Paq113 = Paquete::findOrCreatePaquete(1,'010300100060','PAQUETE 2° SEC. PET',0,$IdEmp);
        $Paq114 = Paquete::findOrCreatePaquete(1,'978607013405','EL CASO DEL CERRO PANTEON',0,$IdEmp);
        $Paq115 = Paquete::findOrCreatePaquete(1,'321227451033','CUOTA DE COMPUTACION 2° SEC',0,$IdEmp);
        $Paq116 = Paquete::findOrCreatePaquete(1,'978607426250','LITTLE SPARKS 1, STUDENTS BOOK',0,$IdEmp);
        $Paq117 = Paquete::findOrCreatePaquete(1,'978607172008','INVENTARIOS DE ORIENTACION PRO',0,$IdEmp);
        $Paq118 = Paquete::findOrCreatePaquete(1,'978607100447','QUIMICA 1: LA MATERIA ES EL EN',0,$IdEmp);
        $Paq119 = Paquete::findOrCreatePaquete(1,'978607100524','QUIMICA 2: PARA COMPRENDER TU',0,$IdEmp);
        $Paq120 = Paquete::findOrCreatePaquete(1,'978607050232','CUOTA DHP 2° SEC',0,$IdEmp);
        $Paq121 = Paquete::findOrCreatePaquete(1,'010300100061','PAQUETE 2° SEC. FCE',0,$IdEmp);
        $Paq122 = Paquete::findOrCreatePaquete(1,'978968569845','ABRAPALABRA 2',0,$IdEmp);
        $Paq123 = Paquete::findOrCreatePaquete(1,'978019480831','FAMILY AND FRIENDS 3, CLASS BO',0,$IdEmp);
        $Paq124 = Paquete::findOrCreatePaquete(1,'978019480864','FAMILY AND FRIENDS 3, WORKBOOK',0,$IdEmp);
        $Paq125 = Paquete::findOrCreatePaquete(1,'978607050226','CUOTA DHP 2° PRIM',0,$IdEmp);
        $Paq126 = Paquete::findOrCreatePaquete(1,'978052116860','ENGLISH IN MIND LEVEL 1, WORKB',0,$IdEmp);
        $Paq127 = Paquete::findOrCreatePaquete(1,'978019433217','SELECT READINGS UPPER-INTERMED',0,$IdEmp);
        $Paq128 = Paquete::findOrCreatePaquete(1,'978607050236','CUOTA DHP 1° PREPA.',0,$IdEmp);
        $Paq129 = Paquete::findOrCreatePaquete(1,'978607171607','JUEGO CON TRAZOS Y NUMEROS 1',0,$IdEmp);
        $Paq130 = Paquete::findOrCreatePaquete(1,'978110768958','CAMBRIDGE CAE 1, PT',0,$IdEmp);
        $Paq131 = Paquete::findOrCreatePaquete(1,'160625120044','PAQUETE 1° PREPA FCE',0,$IdEmp);
        $Paq132 = Paquete::findOrCreatePaquete(1,'010300174851','PREPARE 7, STUDENTŽS BOOK',0,$IdEmp);
        $Paq133 = Paquete::findOrCreatePaquete(1,'010200121115','PAQUETE 1 PRIM',0,$IdEmp);
        $Paq134 = Paquete::findOrCreatePaquete(1,'010200121116','PAQUETE 2 PRIM',0,$IdEmp);
        $Paq135 = Paquete::findOrCreatePaquete(1,'010200121117','PAQUETE 3 PRIM',0,$IdEmp);
        $Paq136 = Paquete::findOrCreatePaquete(1,'010200121118','PAQUETE 4 PRIM',0,$IdEmp);
        $Paq137 = Paquete::findOrCreatePaquete(1,'010200121119','PAQUETE 5 PRIM',0,$IdEmp);
        $Paq138 = Paquete::findOrCreatePaquete(1,'010200121130','PAQUETE 6 PRIM',0,$IdEmp);
        $Paq139 = Paquete::findOrCreatePaquete(1,'978607050227','CUOTA DHP 3° PRIM',0,$IdEmp);
        $Paq140 = Paquete::findOrCreatePaquete(1,'978076644444','ENGLISH IN MIND STARTER WORKBO',0,$IdEmp);
        $Paq141 = Paquete::findOrCreatePaquete(1,'978052118537','ENGLISH IN MIND STARTER STD BO',0,$IdEmp);
        $Paq142 = Paquete::findOrCreatePaquete(1,'978968569846','ABRAPALABRA 3',0,$IdEmp);
        $Paq143 = Paquete::findOrCreatePaquete(1,'770689497254','COMPETENCIAS LECTORAS 3',0,$IdEmp);
        $Paq144 = Paquete::findOrCreatePaquete(1,'010300125818','EL CUENTO DE LA ISLA DESCONOCI',0,$IdEmp);
        $Paq145 = Paquete::findOrCreatePaquete(1,'978607774382','FIGURAS Y FORMAS NIVEL ELEMENT',0,$IdEmp);
        $Paq146 = Paquete::findOrCreatePaquete(1,'750600759525','ESPAÑOL 3 SEC',0,$IdEmp);
        $Paq147 = Paquete::findOrCreatePaquete(1,'978607100414','ORTOGRAFIA PARA SECUNDARIA 3',0,$IdEmp);
        $Paq148 = Paquete::findOrCreatePaquete(1,'978607426251','LITTLE SPARKS 2, STUDENTS BOOK',0,$IdEmp);
        $Paq149 = Paquete::findOrCreatePaquete(1,'978607849523','HISTORIA DE MÉXICO',0,$IdEmp);
        $Paq150 = Paquete::findOrCreatePaquete(1,'010400100556','CUOTA DHP 3° PREPA.',0,$IdEmp);
        $Paq151 = Paquete::findOrCreatePaquete(1,'010400100556','CUOTA DHP 3° PREPA.',0,$IdEmp);
        $Paq152 = Paquete::findOrCreatePaquete(1,'978607100524','QUIMICA 2: PARA COMPRENDER TU',0,$IdEmp);
        $Paq153 = Paquete::findOrCreatePaquete(1,'978019433211','SELECT READINGS-PRE INTERMEDIA',0,$IdEmp);
        $Paq154 = Paquete::findOrCreatePaquete(1,'010500100005','MATERIAL DIDACTICO',0,$IdEmp);
        $Paq155 = Paquete::findOrCreatePaquete(1,'010200100024','CUADERNO DE EJERCICIOS CALIGRA',0,$IdEmp);
        $Paq156 = Paquete::findOrCreatePaquete(1,'978110762834','OBJECTIVE FIRST STUDENTS BOOK',0,$IdEmp);
        $Paq157 = Paquete::findOrCreatePaquete(1,'160625120415','PAQUETE 3° PREPA FCE',0,$IdEmp);
        $Paq158 = Paquete::findOrCreatePaquete(1,'978607050235','CUOTA DHP 2° PREPA',0,$IdEmp);
        $Paq159 = Paquete::findOrCreatePaquete(1,'978110762839','OBJECTIVE FIRST WORKBOOK',0,$IdEmp);
        $Paq160 = Paquete::findOrCreatePaquete(1,'978968246755','MI LIBRO MAGICO',0,$IdEmp);
        $Paq161 = Paquete::findOrCreatePaquete(1,'978019480862','FAMILY AND FRIENDS 1, WORKBOOK',0,$IdEmp);
        $Paq162 = Paquete::findOrCreatePaquete(1,'978019480829','FAMILY AND FRIENDS 1, CLASS BO',0,$IdEmp);
        $Paq163 = Paquete::findOrCreatePaquete(1,'160625120244','PAQUETE 2° PREPA FCE',0,$IdEmp);
        $Paq164 = Paquete::findOrCreatePaquete(1,'978607849522','HISTORIA UNIVERSAL',0,$IdEmp);
        $Paq165 = Paquete::findOrCreatePaquete(1,'978607849513','CIENCIAS 2, FISICA.',0,$IdEmp);
        $Paq166 = Paquete::findOrCreatePaquete(1,'978110760309','CAMBRIDGE PET FOR SCHOOLS 2',0,$IdEmp);
        $Paq167 = Paquete::findOrCreatePaquete(1,'978607493343','MY WORLD DICTIONARY',0,$IdEmp);
        $Paq168 = Paquete::findOrCreatePaquete(1,'978607910714','ACENTO 3, ORTOGRAFIA',0,$IdEmp);
        $Paq169 = Paquete::findOrCreatePaquete(1,'978607910717','ACENTO 6, ORTOGRAFIA',0,$IdEmp);
        $Paq170 = Paquete::findOrCreatePaquete(1,'010300121135','PAQUETE 3 SEC PET',0,$IdEmp);
        $Paq171 = Paquete::findOrCreatePaquete(1,'978052117907','ENGLISH IN MIND LEVEL 1, STD B',0,$IdEmp);
        $Paq172 = Paquete::findOrCreatePaquete(1,'010300131136','PAQUETE 3 SEC FCE',0,$IdEmp);
        $Paq173 = Paquete::findOrCreatePaquete(1,'978607050228','CUOTA DHP 4° PRIM',0,$IdEmp);
        $Paq174 = Paquete::findOrCreatePaquete(1,'978607013334','EL DIA QUE LA ABUELA EXPLOTO',0,$IdEmp);
        $Paq175 = Paquete::findOrCreatePaquete(1,'978052117682','KEY ENGLISH TEST FOR SCHOOL 1,',0,$IdEmp);
        $Paq176 = Paquete::findOrCreatePaquete(1,'978052112436','COMPLETE KEY FOR SCHOOL WORKBO',0,$IdEmp);
        $Paq177 = Paquete::findOrCreatePaquete(1,'978968569848','ABRAPALABRA 5',0,$IdEmp);
        $Paq178 = Paquete::findOrCreatePaquete(1,'978607910716','ACENTO 5, ORTOGRAFIA',0,$IdEmp);
        $Paq179 = Paquete::findOrCreatePaquete(1,'978607012949','DIOSES Y HEROES DE LA MITOLOGI',0,$IdEmp);
        $Paq180 = Paquete::findOrCreatePaquete(1,'010400149657','CUOTA DE COMPUTACION 1° PREPA',0,$IdEmp);
        $Paq181 = Paquete::findOrCreatePaquete(1,'978607050236','CUOTA DHP 1° PREPA.',0,$IdEmp);
        $Paq182 = Paquete::findOrCreatePaquete(1,'978019433212','SELECT READINGS INTERMEDIATE',0,$IdEmp);
        $Paq183 = Paquete::findOrCreatePaquete(1,'978052174139','COMPLETE PET, WORKBOOK',0,$IdEmp);
        $Paq184 = Paquete::findOrCreatePaquete(1,'978607849514','CIENCIAS 3: QUIMICA',0,$IdEmp);
        $Paq185 = Paquete::findOrCreatePaquete(1,'978607100447','QUIMICA 1: LA MATERIA ES EL EN',0,$IdEmp);




    }
}

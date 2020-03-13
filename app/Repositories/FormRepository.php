<?php
/**
 * Created by PhpStorm.
 * User: smartrahat
 * Date: 10/12/2017
 * Time: 6:31 PM
 */

namespace App\Repositories;
use App\Models\Municipio;
use App\Models\Departamento;


class FormRepository
{

    public function tipoDocumentos(){
        return [
            'CC'=>'Cédula de ciudadanía',
            'CE'=>'Cédula de extranjería'
        ];
    }
    
    public function estado(){
        return collect([
            'Activo'=>'Activo',
            'Inactivo'=>'Inactivo'
        ]);
    }

    public function nivelEstudios(){
        return collect([
            'Básica Primaria',
            'Básica Secundaria',
            'Técnica',
            'Tecnólogo',
            'Pre grado',
            'Pos grado'
        ]);
    }

    public function cargo(){
        return collect([
            'Gerente',
            'Administrador',
            'Coordinador',
            'Jefe',
            'Analista',
            'Asistente',
            'Representante legal',
            'Auxiliar',
            'Varios'
        ]);
    }

    public function remuneracion(){
        return collect([
            'Menos de $700.000',
            'Más de $700.000',
            'Más de $1.000.000',
            'Más de $2.000.000',
            'Más de $3.000.000',
            'Más de $4.000.000',
            'Más de $5.000.000',
            'Más de $10.000.000',
            'Más de $15.000.000',
            'Prefiero no decirlo'
        ]);
    }

    public function grupoEtnico(){
        return collect([
            'Rrom (Gitanos)',
            'Indígenas',
            'Afrocolombianos',
            'Raizales',
            'Otro'
        ]);
    }

    public static function idiomas(){
        return [
            'Alemán',
            'Arabe',
            'Catalan',
            'Chino',
            'Coreano',
            'Español',
            'Francés',
            'Griego',
            'Hebreo',
            'Hindi',
            'Holandés',
            'Inglés',
            'Japonés',
            'Portugués',
            'Ruso',
            'Turco'
        ];
    }

    public static function departamentos(){
        return Departamento::select('id_departamento','departamento')->get();
    }

    public function municipios($departamento){
        return Municipio::where('departamento_id',$departamento)->select('id_municipio','municipio')->get();
    }

    public function tipoEmpresas(){
        return collect([
            'Persona natural comerciante',
            'Empresa unipersonal',
            'Sociedades por Acciones Simplificadas (S.A.S)',
            'Sociedad Colectiva',
            'Sociedad Anónima (S.A.)',
            'Sociedad de Responsabilidad Limitada (Ltda.)',
            'Sociedad en Comandita Simple (S. en C.)',
            'Sociedad en Comandita por Acciones (S.C.A.)',
            'Empresa Asociativa de Trabajo (E.A.T.)',
            'Sociedades Agrarias de Transformación (S.A.T)'
        ]);
    }

    public function redesSociales(){
         return [
            'Facebook',
            'Twitter',
            'Instagram'
        ];
    }

    public function numeroTrabajadores(){
         return [
            'Seleccione una opción',
            'No superior a los 10 trabajadores',
            'Entre 11 y 50 trabajadores',
            'Entre 51 y 200 trabajadores'
        ];
    }

    public function activosTotales(){
         return collect([
            'Inferior a 500 SMMLV',
            'Entre 501 y 5.000 SMMLV',
            'Entre 5.001 y 30.000 SMMLV'
        ]);
    }

    public static function profesion(){
        return collect([
            '2111'=>'Físicos y Astrónomos',
            '2112'=>'Meteorólogos',
            '2114'=>'Geólogos  y Geofísicos',
            '2141'=>'Ingenieros industriales y de producción',
            '2310'=>'Profesores de educación superior, de universidad, institutos, tutores universitarios.',
            '2320'=>'Profesores de formación profesional',
            '2330'=>'Profesores de educación secundaria',
            '2341'=>'Profesores de educación primaria',
            '2342'=>'Profesores de primera infancia',
            '2351'=>'Especialistas en métodos pedagógicos',
            '2352'=>'Profesores de educación especial e inclusiva',
            '2353'=>'Otros profesores de idiomas',
            '2354'=>'Otros profesores de música',
            '2355'=>'Otros profesores de artes',
            '2356'=>'Instructores de tecnologías de la información',
            '2359'=>'Otros profesionales de la educación no clasificados en otros grupos primarios',
            '2411'=>'Contadores, Auditores financieros, revisor fiscal y auditor contable.',
            '2412'=>'Asesores financieros  de inversiones',
            '2413'=>'Analistas financieros',
            '2421'=>'Analista de gestión y organización, auditor de calidad.',
            '2422'=>'Profesionales en políticas de administración',
            '2423'=>'Profesionales de gestión y de talento humano',
            '2424'=>'Profesionales en formación y desarrollo personal',
            '2511'=>'Analista de sistemas',
            '2512'=>'Desarrolladores de software',
            '2513'=>'Desarrolladores de web y multimedia',
            '2514'=>'Programadores de aplicaciones',
            '2521'=>'Diseñadores y administradores de bases de datos',
            '2522'=>'Administrador de sistemas, redes, equipos informáticos, consultor de tecnología, analista de infraestructura y sistemas.',
            '2523'=>'Profesionales en redes de computadores',
            '2611'=>'Abogados',
            '2632'=>'Sociólogos, antropólogos y afines',
            '2633'=>'Filósofos historiadores y especialistas en ciencias políticas',
            '2634'=>'Psicólogos',
            '2635'=>'Profesionales del trabajo social y consejeros',
            '2636'=>'Profesionales relígiosos, miembros del clero',
            '2643'=>'Traductores y otros lingüistas',
            '3252'=>'Técnicos en documentación sanitaria (registros médicos, archivos de salud)',
            '3253'=>'Trajadores comunitarios de salud',
            '3255'=>' Técnicos y asistente terapeutas',
            '3321'=>'Agente de seguros',
            '3411'=>'Técnicos y profesionales del nivel medio del derecho de servicios legales y afines',
            '3412'=>'Trabajadores y asistentes sociales',
            '3413'=>'Auxiliares laicos de las religiones',
            '3511'=>'Técnicos en operaciones de tecnología de la información y las comunicaciones',
            '3512'=>'Técnicos en asistencia y soporte a usuarios de la de tecnología de la información y las comunicaciones',
            '3513'=>'Técnicos en redes y sistemas de computación',
            '3514'=>'Técnicos del la web',
            '3521'=>'Técnicos de radiodifusión y grabación audiovisual',
            '3522'=>'Técnicos de ingenieria y las telecomunicaciones',
            '4131'=>'Operadores de máquinas, procesadores de texto mecanógrafos y digitadores',
            '4132'=>'Grabadores de datos',
            '4211'=>'Cajeros de oficinas de correo, cobro y pago de dinero.',
            '4311'=>'Auxiliar contable, financiero y cálculo de costos.',
            '4312'=>'Auxiliares de servicios estadísticos, financieros y de seguros',
            '4313'=>'Auxiliares de nóminas',
            '5113'=>'Guias de museos, galerías de arte, de turismo y afines',
            '5161'=>'Astrólogos, adivinos y trabajadores afines',
            '5162'=>'Acompañantes de personas no incluidos en otros grupos primarios',
            '5164'=>'Cuidadores de animales domésticos',
            '5230'=>'Taquillero y expendedores de boletas',
            '5311'=>'Cuidadores de niños, cuidadores de personas y hogar',
            '5312'=>'Auxiliares de maestros',
            '5321'=>'Trabajadores de cuidados personales en instituciones',
            '5322'=>'Trabajadores de cuidados personales a domicilio',
            '5323'=>'Trabajadores de los cuidados personales en servicios de salud',
            '7352'=>'Decoradores de piezas artesanales de madera',
            '7515'=>'Catadores y clasificadores de alimentos y bebidas',
            '9411'=>'Preparadores de comidas rápidas',
            '9510'=>'Vendedor ambulante de servicios tales como lustra botas, limpiador de ventanas de automóviles, mandados o recados. distribución de folletos, cuidar bienes',
            '9520'=>'Vendedor ambulante de mercancías, excluye comidas de preparación rápida.',
            '1420'=>'Comerciantes al por mayor y al por menor',
            '1420'=>'Prendero',
            '1439'=>'Agente de viajes',
            '2113'=>'Químicos',
            '2120'=>'Actuarios y Estadísticos',
            '2132'=>'Agrónomos Silvicultores Zootecnistas y afines',
            '2162'=>'Arquitectos paisajistas',
            '2165'=>'Cartógrafos y topógrafos',
            '2166'=>'Diseñadores gráficos y multimedia',
            '2230'=>'Profesionales de medicina tradicional y alternativa',
            '2250'=>'Veterinarios',
            '2431'=>'Profesionales de la Publicista y la comercialización.',
            '2432'=>'Profesionales de relaciones públicas',
            '2432'=>'Profesionales de relaciones públicas',
            '2433'=>'Profesionales de ventas técnicas y médicas',
            '2434'=>'Profesionales de ventas de información y de las tecnologías y las comunicaciones',
            '2619'=>'Profesionales en derecho no clasificados en otros grupos primarios',
            '2641'=>'Autores y otros escritores',
            '2642'=>'Periodistas, comentaristas',
            '2651'=>'Escultores pintores artistas y afines',
            '2652'=>'Compositores músicos y cantantes',
            '2653'=>'Coreógrafos y bailarines',
            '2654'=>'Directores y productores de cine teatro y afines',
            '2655'=>'Actores',
            '2656'=>'Locutores de radio televisión y otros medios de comunicación',
            '2659'=>'Artistas creativos interpretativos no clasificados en otros grupos primarios (payasos magos y otros artistas no clasificados)',
            '3118'=>'Delineante y dibujantes técnicos .',
            '3254'=>'Técnicos en optometria y ópticas',
            '3315'=>'Tasadores y evaluadores, evaluadores de bienes raíces.',
            '3332'=>'Organizador de conferencias y eventos',
            '3339'=>'Operador turístico',
            '3421'=>'Atletas y deportistas',
            '3422'=>'Entrenadores, instructores y árbitros de actividades deportivas',
            '3423'=>'Instructores de educación física y actividades recreativas',
            '4212'=>'Receptores de apuesta y afines',
            '4214'=>'Cobradores y afines',
            '4223'=>'Telefonistas',
            '4227'=>'Entrevistadores de encuestas de investigaciones de mercado',
            '4413'=>'Codificadores de datos correctores de pruebas de imprenta y afines',
            '5113'=>'Guía de turismo',
            '5131'=>'Meseros',
            '5132'=>'Bármanes',
            '5141'=>' Peluqueros',
            '5142'=>'Especialistas en tratamientos de belleza y afines',
            '5151'=>'Supervisores de mantenimiento y limpieza en oficias hoteles y otros establecimientos',
            '5241'=>'Modelos de modas, arte y publicidad',
            '5242'=>'Vendedores de mostradores tiendas y afines',
            '5243'=>'Vendedores puerta a puerta',
            '5244'=>'Vendedores a través de medios tecnológicos',
            '5246'=>'Vendedores de comidas en mostrador',
            '5249'=>'Otros vendedores no clasificados en grupos primarios',
            '6113'=>'Agricultores y trabajadores de huertas invernaderos viveros y jardines',
            '6114'=>'Agricultores y trabajadores calificados de cultivos mixtos',
            '6121'=>'Criadores de ganado y de la cría de animales domésticos , excepto aves de corral',
            '6122'=>'Avicultores y trabajadores calificados de la avicultura, incluye aves de corral',
            '6123'=>'Criadores y trabajadores calificados de la apicultura y la sericultura',
            '6129'=>' Criadores y trabajadores pecuarios calificados, avicultores y criadores de insectos no clasificados en otros grupos primarios',
            '6130'=>'Productos y trabajadores calificados e explotaciones agropecuarias mixtas cuya producción se destina al mercado . (siembra y cosechas de campo, recolección de cosechas etc)',
            '6221'=>'Trabajadores de explotación de acuicultura',
            '7311'=>'Reparación de instrumentos de precisión incluye relojeros y joyeros',
            '7312'=>'Fabricantes y afinadores de instrumentos musicales',
            '7314'=>'Alfareros y ceramistas',
            '7316'=>'Rotulístas, pintores decorativos y grabadores',
            '7321'=>'Preimpresores y afines',
            '7322'=>'Impresores',
            '7323'=>'Encuadernadores y afines',
            '7331'=>'Tejedores con telares',
            '7332'=>'Tejedores con agujas',
            '7333'=>'Otros tejedores',
            '7341'=>'Cestero mimbreras',
            '7342'=>'Sombrereros artesanales',
            '7370'=>'Artesanos del cuero',
            '7391'=>'Artesanos del papel',
            '7511'=>'Carniceros pescaderos y afines',
            '7512'=>'Panaderos, Pastelero y confiteros',
            '7513'=>'Operarios de la elaboración de productos lácteos',
            '7514'=>'Operarios  de la conservación de frutas legumbre verduras y afines',
            '7531'=>'Sastres, modistos peleteros y sombrereros',
            '7532'=>'Patronistas y cortadores de tela cuero y afines',
            '7533'=>'Costureros bordadores y afines',
            '7534'=>'Tapiceros colchoneros y afines',
            '7549'=>'Trabajadores que realizan arreglos florales',
            '9121'=>'Lavanderos y planchador a mano',
            '9129'=>'Otro personal de limpieza no clasificados en otros grupos primarios ( limpiador de piscinas, limpiador de alfombras, drenajes)',
            '9321'=>'Empacadores manuales',
            '9334'=>'Surtidores de estanterías',
            '9626'=>'Lectores de medidores',
            '9629'=>'Otros ocupaciones elementales no clasificados en otros gruposprimarios (acomodadores de espectáculos públicos, guardarropas etc)',
            '2131'=>'Biólogo, epidemiólogo, botánico, zoólogo y afines',
            '2133'=>'Profesionales de la protección medio ambiental',
            '2141'=>'Ingenieros Industriales y de producción',
            '2144'=>'Ingenieros Mecánicos, aeronáutico, automotriz, diseñador de motores.',
            '2148'=>' Ingenieros catastrales, topógrafos, geodesias y afines',
            '2149'=>' Ingeniero textil, ingeniero de seguridad.',
            '2211'=>'Médico general, medico clínico',
            '2212'=>'Médicos especialistas',
            '2261'=>'Odontólogos',
            '2262'=>'Farmacéuticos',
            '2263'=>'Profesionales de seguridad y salud en el trabajo , higiene laboral y ambiental',
            '2264'=>'Fisioterapeutas',
            '2265'=>' Dietista, y nutricionista',
            '2266'=>'Fonoaudiólogos y terapeutas',
            '2267'=>'Optómetras',
            '2269'=>'Otros profesionales de la salud no clasificados en otros grupos primarios',
            '3132'=>'Operadores incineradores instalaciones de tratamiento de agua y afines',
            '3139'=>'Técnicos en control de procesos no clasificados en otros grupos primarios',
            '3211'=>'Operadores audiométricos, de escáner óptico y afines',
            '3251'=>'Higienista asistentes odontológicos dental',
            '3256'=>' Asistente médicos ( asistente clínico, oftálmico, técnicos de transfusiones)',
            '3257'=>'Inspectores de seguridad, salud en el trabajo , medio ambiental y afines',
            '3258'=>'Técnicos en atención pre hospitalaria (Paramédico)',
            '3259'=>'Otros técnicos y profesionales del nivel de la salud  no clasificados en otros grupos primarios ( consejeros de terapia de familia , planificación familiar, VIH)',
            '3431'=>'Camarógrafo, fotógrafo , operador equipos de grabación de sonido',
            '3432'=>'Diseñadores y decoradores de interiores',
            '3433'=>'Técnicos en galerías de artes museos y bibliotecas',
            '3434'=>'Chef de cocina',
            '5120'=>'Cocineros, Parrillero asador de carnes',
            '5163'=>'Personal de servicios funerarios y embalsamadores',
            '5169'=>'Otros trabajadores de servicios personales tales como acompañantes, trabajadores sexuales, damas de compañía, gigoló, prostitutas.',
            '5211'=>'Vendedores en kioscos y puestas de mercado',
            '5212'=>'Vendedores ambulantes de alimentos preparados para consumo inmediato',
            '5329'=>'Trabajadores de los cuidados personales en servicios de salud, auxiliares del area de la salud',
            '6111'=>'Agricultores y trabajadores de cultivos intensivos',
            '6112'=>'Agricultores y trabajadores de plantaciones de árboles y arbustos',
            '6122'=>' Avicultores y trabajadores calificados de la avicultura',
            '6310'=>'trabajadores agrícolas de subsistencia',
            '6320'=>'Trabajdores pecuarios de subsistencias',
            '6330'=>'trabajadores agropecuarios de subsistencia (recolecta frutas y plantas silvestres)',
            '6340'=>'Pescadores cazadores tramperos y recolectores de subsistencia',
            '7113'=>'Labrantes trozadores y grabadores de piedra',
            '7115'=>'Carpinteros de armar y de obra blanca',
            '7122'=>'enchapadores parqueteros y colocadores de suelos',
            '7123'=>'Revocadores',
            '7124'=>' Instaladores de material aislante e isonorizacion',
            '7126'=>'Fontanero de instaladores de tuberías',
            '7213'=>'Chapistas y caldereros',
            '7215'=>'Aparejadores y espalmadores de cables',
            '7221'=>'Herreros y forjadores',
            '7222'=>'Herramientitas y afines ( fabricantes de herramientas de mano. artículos de ferretería)',
            '7223'=>'Ajustadores y operadores de máquinas de herramientas',
            '7224'=>'Pulidores de metales y afiladores de herramientas',
            '7231'=>'Mecánicos y reparadores de vehículos automotores',
            '7232'=>'Mecánicos y reparadores se sistemas y motores de aeronaves',
            '7233'=>'Mecánicos y reparadores de máquinas agrícolas e industriales',
            '7234'=>'Reparadores e bicicletas y afines',
            '7315'=>'Sopladores, moldeadores,  laminadores cortadores y pulidores de vidrio',
            '7351'=>'Tallador de piezas artesanales de madera',
            '7352'=>'Decoradores de piezas artesanales de madera',
            '7361'=>'Joyeros',
            '7362'=>'Orfebres y plateros',
            '7363'=>'Bisutero',
            '7392'=>'Artesanos del hierro y otros metales',
            '7393'=>'Artesanos de semillas y cortezas vegetales',
            '7399'=>'Artesanos de otros materiales no clasificados en otros grupos primarios ( tela, parafina, jabon, cuerno, cera, etc)',
            '7411'=>'Electricistas de obra y afines',
            '7412'=>' Ajustadores de electricistas incluye reparación de aparatos de uso domestico',
            '7413'=>' Instaladores y reparadores de  líneas eléctricas',
            '7421'=>'Ajustadores e instaladores en electrónica',
            '7422'=>'Instaladores y reparadores en tecnologías de la información y las comunicaciones',
            '7516'=>'preparadores y elaboradores de cigarrillos y productos del tabaco',
            '7521'=>'operarios del tratamiento  de la madera',
            '7522'=>'Ebanistas y Carpinteros',
            '7523'=>'Ajustadores y operadores de máquinas para trabajar madera',
            '7536'=>'Zapatero, y afines',
            '7713'=>'Fabricante de quesos, lácteos',
            '8160'=>'Trabajadores  con máquinas para elaborar alimentos y productos afines',
            '9122'=>'Lavador de autos, vehículos',
            '9214'=>'Trabajadores de jardinería y horticultura',
            '9329'=>'Ayudante de elaboración e alimentos y bebidas',
            '9333'=>'Trabajdores de carga (Bracero , coteros, estibadores cargadores de camiones)',
            '9412'=>'Ayudante de cocina',
            '9624'=>'Acarreadores de agua y recolectores de leña',
            '2151'=>'Ingenieros electricistas eléctricos, electrónicos, de telecomunicaciones y afines',
            '2152'=>'Ingenieros electrónicos',
            '2153'=>'Ingenieros de telecomunicaciones',
            '2212'=>'Médico cirujano general, plástico , anestesiólogo.',
            '3134'=>'Operadores de instalaciones de refinación de petróleo y gas natural',
            '3135'=>'Controladores de procesos de producción de metales',
            '3151'=>'Maquinistas en navegación',
            '3152'=>'Trabajadores de la navegación de buques y embarcaciones',
            '3153'=>'Pilotos de aviación y afines',
            '3155'=>'Técnicos en seguridad aeronáutica',
            '4323'=>'Trabajadores de servicios de transporte',
            '5164'=>'Instructores de conducción',
            '5245'=>'Vendedores de combustible incluye montallantero, cambiador de aceite, engrase y afines',
            '6112'=>'Agricultores y trabajadores calificados para plantaciones de arboles y arbustos (podador y recolector)',
            '6210'=>'Trabajador forestal calificados y afines',
            '6222'=>'Pescadores de agua dulce y en aguas costeras',
            '6223'=>'Pescadores de altamar',
            '6224'=>'Cazadores y tramperos',
            '7127'=>'Mecánicos montadores de aire acondicionado y refrigeración',
            '7131'=>'Pintores y empapeladores',
            '7132'=>'Barnizadores y afines',
            '7212'=>'Soldadores y oxicortadores',
            '7535'=>'Apelambradores, pellejeros y curtidores  en tratamiento de pieles y pelos de animales',
            '8311'=>'Maquinistas de locomotoras',
            '8312'=>'Guardafrenos, guardagujas y agentes de maniobras',
            '8321'=>'Conductores de motocicletas',
            '8323'=>'Conductores de camionetas y vehículos livianos',
            '8324'=>'Conductores de taxis',
            '8331'=>'Conductores de buses microbuses y tranvías',
            '8332'=>'Conductores de camiones y vehículos pesados',
            '8341'=>'Trabajadores de maquinaria agrícola y forestal móvil',
            '8343'=>'Trabajadores de grúas aparatos elevadores y afines',
            '8344'=>'Operadores de montacargas',
            '9331'=>'Conductores de vehículos accionado a pedal o a brazo',
            '9621'=>'Mensajeros mandaderos maleteros y repartidores',
            '9622'=>'Personas que realizan trabajos varios',
            '2142'=>'Ingenieros civiles.',
            '2143'=>'Ingenieros medio ambientales',
            '2144'=>'Ingeniero marino',
            '2145'=>'Ingeniero químico',
            '2146'=>'Ingenieros de minas metalúrgicos y afines',
            '2149'=>'Ingeniero de tráfico, ingeniero de energía nuclear, ingeniero de salvamento marítimo.',
            '2161'=>'Arquitectos constructores',
            '2212'=>'Médico especialista en medicina nuclear, médico radiólogo, médico patólogo forense.',
            '2212'=>'Médico especialista en psiquiatría para atención de víctimas.',
            '2619'=>'Profesionales en derecho no clasificados en otros grupos primarios que atienden víctimas',
            '2635'=>'Profesionales del trabajo social, consejeros, psicólogos para atención a víctimas',
            '2659'=>'Artistas creativos interpretativos no clasificados en otros grupos primarios incluye (Acróbata, equilibrista, trapecista, torero y otras ocupaciones relacionada con espectáculos públicos en actividades extremas)',
            '3118'=>'Delineante de arquitectura, dibujante técnico, con intervención directa en obras',
            '3133'=>'Controladores de instalaciones de procesamiento de productos químicos, filtración y separación de sustancia químicas, procesos químicos.',
            '3154'=>'Controlador de tráfico aéreo y marítimo',
            '3211'=>'Radiólogo oral, operador de equipo audiométrico, de escáner óptico,',
            '3355'=>'Detective privado',
            '3421'=>'Atletas y Deportistas  (Deporte extremo )',
            '4323'=>'Controladores administrativos de tráfico aéreo',
            '5411'=>'Bomberos y rescatistas',
            '5414'=>'Escolta, guardaespaldas',
            '7111'=>'Constructores de Casas',
            '7112'=>'Albañiles',
            '7114'=>'Operarios en cemento armado enfoscadores y afines',
            '7119'=>'Oficiales de la construcción de obra gruesa y afines no clasificados en grupos primarios (demolición, reparación y mantenimiento de fachadas, armado de andamios, operarios de construcción, edificios de gran altura)',
            '7121'=>'Techadores',
            '7125'=>'Cristaleras',
            '7133'=>'Limpiadores de fachadas, deshollinadores.',
            '7211'=>'Moldeadores y macheros, fundición de metales',
            '7212'=>'Soldadores y oxicortadores (cortan metales con gas o arco eléctrico)',
            '7213'=>'Chapistas caldereros horneros- exposición altas temperaturas',
            '7214'=>'Montadores de estructuras metálicas',
            '7419'=>'Personal de servicios de protección no clasificados en otros grupos primarios ( salvavidas, socorristas)',
            '7541'=>'Buzos',
            '7544'=>'Fumigadores y otros controladores de plagas y malas hierbas',
            '7549'=>'Trabajadores e oficios relacionados no clasificados en otros grupos primarios tales como los que manipulas juegos pirotécnicos.',
            '8342'=>'Trabajadores de máquinas de movimientos de tierra construcciones de vías y afines',
            '9123'=>'Limpiadores de ventanas',
            '9212'=>'Clasificadores de desechos',
            '9311'=>'Trabajadores de minas y canteras',
            '9312'=>'Trabajadores de obras públicas y mantenimiento',
            '9313'=>'Trabajadores de la construcción',
            '9313'=>'Trabajadores de construcción , demolición, excavación',
            '9333'=>' Bracero, coteros , estibadores de embarcaciones aéreas, marítimas y/o fluviales',
            '9611'=>'Recolectores de basura y material reciclable',
            '9613'=>'Barrenderos y afines'
        ]);

    }





    


}
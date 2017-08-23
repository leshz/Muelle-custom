<?php
/**
	Plugin Name:	Muelle-wp-custom
	Plugin URI:		http://github.com/leshz/
	Description:	Plugin para mostrar estado del muelle e informacion 
	Version: 		0.1.0
	Author:			Jeffer Barragán
	Author URI:		github.com/leshz
	License:		GPLv2 or later
**/

/*
* Función para añadir una página al menú de administrador de wordpress
*/



function mapEdit_plugin_menu(){
	//Añade una página de menú a wordpress
	add_menu_page(	'Tiempo Real Muelle',				//Título de la página
					'Muelle',							//Título del menú
					'administrator',					//Rol que puede acceder
				  	'max-length-content-settings',		//Id de la página de opciones
				  	'max_length_content_page_settings',	//Función que pinta la página de configuración del plugin
				  	'dashicons-admin-site');			//Icono del menú
}
add_action('admin_menu','mapEdit_plugin_menu');

/*
* Función que pinta la página de configuración del plugin
*/
function max_length_content_page_settings(){
	
	installDB();		
	
	wp_enqueue_style( $handle="ccsAdmin",  $src = '/wp-content/plugins/Muelle-custom/css/admin.css');
	wp_enqueue_style( $handle="cssDatepicker",  $src = '/wp-content/plugins/Muelle-custom/css/datetimepicker.css');
	wp_enqueue_script( $handle="maskLibrary" , $src= '/wp-content/plugins/Muelle-custom/js/mask.js');
	wp_enqueue_script( $handle="datepicker" , $src= '/wp-content/plugins/Muelle-custom/js/datetimepicker.min.js');
	wp_enqueue_script( $handle="jsAdmin" , $src= '/wp-content/plugins/Muelle-custom/js/adminScript.js');
	
	
?>
<div class="twelve columns">
	<div class="wrap">
		<div class="muelle-form">
			<h4>Editor Muelle</h4>
			<form method="POST" action="<?php  echo (plugin_dir_url(__FILE__) ."form_submit.php"); ?>" >
				<div class="content-form">
					<div class="row bar-unity">
						<div class="front">
							<div class="four columns">
								<label>Motonave</label>
								<input class="u-full-width" name="one[motonave]"type="text" />
							</div>
							<div class="three columns">
								<label>Muelle actual</label>
								<select class="u-full-width" name="one[muelle]" >
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</div>
							<div class="three columns">
							<label>Orientación </label>
								<select class="u-full-width" name="one[orientacion]" >
									<option value="proa">Proa</option>
									<option value="popa">Popa</option>
								</select>
								
							</div>
							<div class="two columns b-section" >
								<a class="button-primary moreInfo"><span class="dashicons dashicons-plus"></span> Ver más</a>
							</div>
						</div>
						<div class="completeform hiden">
							<div class="row">
								<div class="three columns">
									<label>Fecha de atraque</label>
								<input class="u-full-width" data-toggle="datepicker" id="date" name="one[date]" type="text" />
								</div>
								<div class="three columns">
									<label>Agente Maritimo</label>
									<input class="u-full-width" name="one[agente]" type="text" />
								</div>
								<div class="three columns">
									<label>Clientes Principales</label>
									<input class="u-full-width" name="one[cliente]" type="text" />
								</div>
								<div class="three columns">
									<label>Tipo de Producto</label>
									<input class="u-full-width" name="one[producto]" type="text" />
								</div>
							
							</div>
							<div class="row">
									<div class="three columns">
									<label>Tonelaje Anunciado</label>
									<input class="u-full-width" id="ton" name="one[tonelaje-anun]" type="text" />
								</div>
								<div class="three columns">
									<label>Tonelaje Descargado</label>
									<input class="u-full-width"  id="ton"name="one[tonelaje-desc]" type="text" />
								</div>
								<div class="three columns">
									<label>Fecha de atraque</label>
								<input class="u-full-width" id="date"name="one[empty]" type="text" />
								</div>
								<div class="three columns">
									<label>Vacio</label>
									<input class="u-full-width" name="one[empty]"type="text" />
								</div>
							</div>
						</div>
					</div>
				</div>
			<button type="submit">Salvar</button>
			</form>
		</div>
	</div>
</div>	
<?php
}


function max_length_action($content){
	global $post;
	//Comprobamos que sea un post y no estemos visualizando su vista individual
	if ($post && $post->post_type=='post' && !is_singular('post')){
		//Recuperamos el valor del parámetro conasa_max_length_value
		$len = get_option('max_length_value');
		$content = mb_substr($content, 3, $len);
	}

	return $content;
}
add_filter('the_content','max_length_action');

	
function installDB () {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'muelle_status';	
	
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (`id` int(11) NOT NULL,
		  `motonave` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
		  `muelle_actual` int(11) NOT NULL,
		  `orientacion` int(11) NOT NULL,
		  `fecha_atrac` date NOT NULL,
		  `agente` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
		  `client_princp` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
		  `producto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
		  `ton_anun` int(11) DEFAULT NULL,
		  `ton_desc` int(11) DEFAULT NULL ) $charset_collate;";
		dbDelta( $sql );
		$sql = "ALTER TABLE $table_name ADD PRIMARY KEY (`id`);";
		$wpdb->query($sql);
		$sql = "ALTER TABLE $table_name MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
		$wpdb->query($sql);
	}
}

?>
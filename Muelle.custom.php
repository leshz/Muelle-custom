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
	add_menu_page(	'Tiempo Real Muelle',				//Título de la página
					'Muelle',							//Título del menú
					'administrator',					//Rol que puede acceder
				  	'muelle_form_settings-page',		//Id de la página de opciones
				  	'muelle_form_settings',	//Función que pinta la página de configuración del plugin
				  	'dashicons-admin-site');			//Icono del menú
}
add_action('admin_menu','mapEdit_plugin_menu');

register_activation_hook( __FILE__, 'installDB' );
 
function installDB () {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;

	$table_name = $wpdb->prefix . 'muelle_status';	
	
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (`id` int(11) NOT NULL,
		  `motonave` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
		  `muelle_actual` int(11) NOT NULL,
		  `orientacion` int(11) NOT NULL,
		  `fecha_atrac` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
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

register_deactivation_hook(__FILE__, 'remove_tables' );
 
function remove_tables(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'muelle_status';
    $sql = "DROP table IF EXISTS $table_name";
	$wpdb->query($sql);
}



function muelle_form_settings(){
	
	wp_enqueue_style( $handle="ccsAdmin",  $src = '/wp-content/plugins/Muelle-custom/css/admin.css');
	wp_enqueue_script( $handle="maskLibrary" , $src= '/wp-content/plugins/Muelle-custom/js/mask.js');
	wp_enqueue_script( $handle="datepicker" , $src= '/wp-content/plugins/Muelle-custom/js/datetimepicker.min.js');
	wp_enqueue_script( $handle="jsAdmin" , $src= '/wp-content/plugins/Muelle-custom/js/adminScript.js');
	$resultado = createFormConsulDb();

?>
<div class="twelve columns">
	<div class="wrap">
		<div class="muelle-form">
			<h1>Editor Muelle</h1>
			<form method="POST" id="adminInfo" action="<?php echo admin_url( 'admin-post.php' ) ;?> " >
			<input type="hidden" name="action" value="process_form">
				<div class="content-form">
				
				<?php 
				
				
				foreach ($resultado as $form =>$item ) {
					
				 ?>
						<div class="row bar-unity">
						<input type="hidden"  name="<?php echo$form; ?>[id]" value="<?php echo $item['id']; ?>">
						<div class="front">
							<div class="four columns">
								<label>Motonave</label>
								<input class="u-full-width" name="<?php echo$form; ?>[motonave]" value="<?php echo $item['motonave']; ?>" type="text" />
							</div>
							<div class="three columns">
								<label>Muelle actual</label>
								<select class="u-full-width" name="<?php echo$form; ?>[muelle]"  value="<?php echo $item['muelle_actual']; ?>">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</div>
							<div class="three columns">
							<label>Orientación </label>
								<select class="u-full-width" name="<?php echo$form; ?>[orientacion]" >
									<option value="1">Proa</option>
									<option value="2">Popa</option>
								</select>
								
							</div>
							<div class="two columns b-section" >
								<button type="button" class="button-primary moreInfo"><i class="fa fa-plus" aria-hidden="true"></i></button>
								<button type="button" class="button-primary delete"><i class="fa fa-times" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="completeform hiden">
							<div class="row">
								<div class="three columns">
									<label>Fecha de atraque</label>
								<input class="u-full-width" data-toggle="datepicker" id="date" name="<?php echo$form; ?>[date]" value="<?php echo $item['fecha_atrac'];?>" type="text" />
								</div>
								<div class="three columns">
									<label>Agente Maritimo</label>
									<input class="u-full-width" name="<?php echo$form; ?>[agente]" value="<?php echo $item['agente']; ?>"type="text" />
								</div>
								<div class="three columns">
									<label>Clientes Principales</label>
									<input class="u-full-width" name="<?php echo$form; ?>[cliente]" type="text"  value="<?php echo $item['client_princp']; ?>"/>
								</div>
								<div class="three columns">
									<label>Tipo de Producto</label>
									<input class="u-full-width" name="<?php echo$form; ?>[producto]" type="text" value="<?php echo $item['producto']; ?>" />
								</div>
							
							</div>
							<div class="row">
									<div class="three columns">
									<label>Tonelaje Anunciado</label>
									<input class="u-full-width" id="ton" name="<?php echo$form; ?>[tonelaje-anun]" type="text" value="<?php echo $item['ton_anun']; ?>" />
								</div>
								<div class="three columns">
									<label>Tonelaje Descargado</label>
									<input class="u-full-width"  id="ton"name="<?php echo$form; ?>[tonelaje-desc]" type="text" value="<?php echo $item['ton_desc']; ?>" />
								</div>
								<div class="three columns">
									<label>Fecha de atraque</label>
								<input class="u-full-width" id="date"name="<?php echo$form; ?>[empty]" type="text" />
								</div>
								<div class="three columns">
									<label>Vacio</label>
									<input class="u-full-width" name="<?php echo$form; ?>[empty2]"type="text"  />
								</div>
							</div>
						</div>
					</div>						
				<?php } ?>
				</div>
				<div class="row buttons-section">
				
					<div class="three columns">
						<button type="submit" class="admin button button-primary submitbutton" id="submit" ><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Guardar</button>
					</div>
					<div class="three columns special">
						<button id="addField" type="button"class="admin button button-primary bubble"><i class="fa fa-plus" aria-hidden="true"></i></button>
					</div>
				</div>
				</form>
		</div>
	</div>
</div>	
<?php
}
	

function createFormConsulDb(){
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM wp_muelle_status" );
	if(count($results) == 0){	
		$results = array(
			0 => array(
					'id' =>"" ,
					'motonave' =>"" ,
					'muelle_actual'=>"" ,
					'orientacion' =>"" ,
					'fecha_atrac' =>"" ,
					'agente' =>"" ,
					'client_princp' =>"" ,
					'producto' =>"" ,
					'ton_anun' =>"" ,
					'ton_desc' => "")
			);
	}
	$results = json_decode(json_encode($results), true);
	return $results; 
}

function deleteField(){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;	
		$DelenteID=$_POST['id'];
		$table_name = $wpdb->prefix . 'muelle_status';	
		$sql = "DELETE FROM $table_name WHERE  `id` = $DelenteID;";
		$wpdb->query($sql);
		return $wpdb; 
	die();	
}

add_action('wp_ajax_deleteField', 'deleteField');


// 


//add_action( 'admin_post_nopriv_process_form', 'process_form_data' );
add_action( 'admin_post_process_form', 'process_form_data' );

function process_form_data() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'muelle_status';	 
	$formInfo = $_POST;
	unset($formInfo['action']);
//	echo "<pre>" ;
//	print_r($formInfo);
//	echo "</pre>" ;
	

	//$newDate = date("d-m-Y", strtotime($originalDate));
	//	die;
	foreach ($formInfo as $item => $info) {
		
		if($info['id'] != ""){
			$wpdb-> update ($table_name, array(
									
										'motonave'=>$info['motonave'],
										'muelle_actual'=>$info['muelle'],
										'orientacion'=>$info['orientacion'],
										'fecha_atrac'=>$info['date'],
										'agente'=>$info['agente'],
										'client_princp'=>$info['cliente'],
										'producto'=>$info['producto'],
										'ton_anun'=>$info['tonelaje-anun'],
										'ton_desc'=>$info['tonelaje-desc']	
										),
										array('id'=>$info['id']) );
		}
		else{
			$wpdb->insert($table_name, array(
										'motonave'=>$info['motonave'],
										'muelle_actual'=>$info['muelle'],
										'orientacion'=>$info['orientacion'],
										'fecha_atrac'=>$info['date'],
										'agente'=>$info['agente'],
										'client_princp'=>$info['cliente'],
										'producto'=>$info['producto'],
										'ton_anun'=>$info['tonelaje-anun'],
										'ton_desc'=>$info['tonelaje-desc']	
										));
		}	
}	
	wp_redirect( $_SERVER['HTTP_REFERER'] );
}

?>
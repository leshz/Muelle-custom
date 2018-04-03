<?php
/**
	Plugin Name:	Muelle-wp-custom
	Plugin URI:		http://github.com/leshz/
	Description:	Plugin para mostrar estado del muelle e informacion
	Version: 			0.1.1
	Author:				Jeffer Barragán
	Author URI:		github.com/leshz
	License:		GPLv2 or later
**/

/*
* Función para añadir una página al menú de administrador de wordpress
*/


function mapEdit_plugin_menu(){
	add_menu_page(	'Tiempo Real Muelle',					//Título de la página
									'Muelle',											//Título del menú
									'administrator',							//Rol que puede acceder
									'muelle_form_settings-page',	//Id de la página de opciones
									'muelle_form_settings',				//Función que pinta la página de configuración del plugin
									'dashicons-admin-site');			//Icono del menú
}
add_action('admin_menu','mapEdit_plugin_menu');

register_activation_hook( __FILE__, 'installDB' );

//------Script SQL-------->
/**
ALTER TABLE `wp_muelle_status` ADD `responsable` VARCHAR(30) NULL,
ALTER TABLE `wp_muelle_status` ADD `actualizacion` VARCHAR(30) NULL
**/

function installDB () {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;

	$table_name = $wpdb->prefix . 'muelle_status';

	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (`id` int(3) NOT NULL,
		  `motonave` varchar(75) COLLATE utf8_spanish_ci NOT NULL,
		  `muelle_actual` int(2) DEFAULT NULL,
		  `orientacion` int(2) DEFAULT NULL,
		  `fecha_atrac` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `hora` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `agente` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `client_princp` varchar(99) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `producto` varchar(99) COLLATE utf8_spanish_ci DEFAULT NULL,
      `eslora` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
      `calado` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `ton_anun` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `ton_desc` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `ton_acum` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
		  `sal-motonave` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
		 	`responsable` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
			`actualizacion` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL) $charset_collate;";

		dbDelta( $sql );
		$sql = "ALTER TABLE $table_name ADD PRIMARY KEY (`id`);";
		$wpdb->query($sql);
		$sql = "ALTER TABLE $table_name MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;";
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

	wp_enqueue_style( $handle="ccsAdmin",  plugin_dir_url( __FILE__ ).'assets/admin/css/admin.css');
	wp_enqueue_script( $handle="maskLibrary" , plugin_dir_url( __FILE__ ).'assets/admin/js/mask.js');
	wp_enqueue_script( $handle="datepicker" , plugin_dir_url( __FILE__ ).'assets/admin/js/datetimepicker.min.js');
	wp_enqueue_script( $handle="timepicker" , plugin_dir_url( __FILE__ ).'assets/admin/js/wickedpicker.js');
	wp_enqueue_script( $handle="jsAdmin" , plugin_dir_url( __FILE__ ).'assets/admin/js/adminScript.js');
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
								<input class="u-full-width motonave" maxlength="75" name="<?php echo$form; ?>[motonave]" value="<?php echo $item['motonave']; ?>" type="text" required />
							</div>
							<div class="two columns">
								<label>Muelle</label>
								<select class="u-full-width" name="<?php echo$form; ?>[muelle]"  value="<?php echo $item['muelle_actual']; ?>">
								<option value=""></option>
								<?php
								for($i=1;$i <= 14 ; $i++){
									if($item['muelle_actual']==$i){
										echo "<option value='$i' selected>$i</option>";
									}else{
										echo "<option value='$i'>$i</option>";
									}
								} ?>
								</select>
							</div>
							<div class="two columns">
								<label>Atracado</label>
								<select class="u-full-width" name="<?php echo$form; ?>[orientacion]" >
								<option value=""></option>
								<?php
									if($item['orientacion']==1){
										echo "<option value='1' selected>Babor <-- </option>";
										echo "<option value='2'>Estribor --> </option>";
									}elseif($item['orientacion']==2){
										echo "<option value='1'>Babor <-- </option>";
										echo "<option value='2' selected>Estribor --> </option>";
									}else{
										echo "<option value='1'>Babor <-- </option>";
										echo "<option value='2'>Estribor --> </option>";
									}
								?>
								</select>

							</div>
							<div class="two columns">
									<label>Fecha de atraque</label>
									<input class="u-full-width" data-toggle="datepicker" id="date" name="<?php echo$form; ?>[date]" value="<?php echo $item['fecha_atrac'];?>" type="text" />
								</div>
							<div class="two columns b-section" >
								<button type="button" class="button-primary moreInfo"><i class="fa fa-plus" aria-hidden="true"></i></button>
								<button type="button" class="button-primary delete"><i class="fa fa-times" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="completeform hiden">
							<div class="row">

								<div class="two-haf columns">
									<label>Hora de atraque </label>
									<input class="u-full-width timepickband" type="text"  id="time" name="<?php echo$form; ?>[hora]" value="<?php echo $item['hora']; ?>" />
								</div>
								<div class="two-haf columns">
									<label>Agente Maritimo</label>
									<input class="u-full-width"  maxlength="75" name="<?php echo$form; ?>[agente]" value="<?php echo $item['agente']; ?>"type="text" />
								</div>
								<div class="two-haf columns">
									<label>Clientes Principales</label>
									<input class="u-full-width" maxlength="99"  name="<?php echo$form; ?>[cliente]" type="text"  value="<?php echo $item['client_princp']; ?>"/>
								</div>
								<div class="two-haf columns">
									<label>Producto</label>
									<input class="u-full-width" maxlength="99" name="<?php echo$form; ?>[producto]" type="text" value="<?php echo $item['producto']; ?>" />
								</div>
								<div class="two-haf columns">
									<label>Eslora</label>
									<input class="u-full-width" id="slora" maxlength="8" name="<?php echo$form; ?>[eslora]" type="text" value="<?php echo $item['eslora']; ?>" />
								</div>


							</div>
							<div class="row">
								<div class="two-haf columns">
									<label>Calado</label>
									<input class="u-full-width" id="calado"  maxlength="8"  name="<?php echo $form; ?>[calado]"type="text"  value="<?php echo $item['calado']; ?>"  />
								</div>
								<div class="two-haf columns">
									<label>Tonelaje Anunciado</label>
									<input class="u-full-width" id="ton"  maxlength="20" name="<?php echo $form; ?>[tonelaje-anun]" type="text" value="<?php echo $item['ton_anun']; ?>" />
								</div>
								<div class="two-haf columns">
									<label>Tonelaje Descargado</label>
									<input class="u-full-width"   maxlength="20" id="ton"name="<?php echo $form; ?>[tonelaje-desc]" type="text" value="<?php echo $item['ton_desc']; ?>" />
								</div>
								<div class="two-haf columns">
									<label>Tonelaje Acumulado</label>
								<input class="u-full-width" id="ton" maxlength="20" name="<?php echo $form; ?>[tonelaje-acum]" type="text" value="<?php echo $item['ton_acum']; ?>" />
								</div>
								<div class="two-haf columns">
									<label>Saldo Motonave</label>
									<input class="u-full-width" id="ton" maxlength="20" name="<?php echo $form; ?>[sal-motonave]"type="text" value="<?php echo $item['sal-motonave']; ?>" />
								</div>
							</div>
							<div class="row">
								<div class="five columns">
									<label>Responsable</label>
									<input class="u-full-width"  name="<?php echo $form; ?>[responsable]"type="text" value="<?php echo $item['responsable']; ?>" />
								</div>
								<div class="three columns">
									<label>Fecha de actualizacion</label>
									<input class="u-full-width" id="date-ac" data-toggle="datepicker" maxlength="20" name="<?php echo $form; ?>[actualizacion]"type="text" value="<?php echo $item['actualizacion']; ?>" />
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
	$table_name = $wpdb->prefix . 'muelle_status';
	$results = $wpdb->get_results( "SELECT * FROM $table_name"  );
	if(count($results) == 0){
		$results = array(
			0 => array(
					'id' =>"" ,
					'motonave' =>"" ,
					'muelle_actual'=>"",
					'orientacion' =>"" ,
					'fecha_atrac' =>"" ,
					'hora'	=>	"",
					'agente' =>"" ,
					'client_princp' =>"" ,
					'producto' =>"" ,
					'eslora' => "",
					'calado' => "",
					'ton_anun' =>"" ,
					'ton_desc' => "",
					'ton_acum' => "",
					'sal-motonave'=>"",
					'responsable' => "",
					'actualizacion'=>""
					)
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


function limpiarString($texto) {
    //$textoLimpio = preg_replace('([^0-9])', '', $texto);
    //return $textoLimpio;
    return $texto;
}


//add_action( 'admin_post_nopriv_process_form', 'process_form_data' );
add_action( 'admin_post_process_form', 'process_form_data' );

function process_form_data() {
	$wpdb->show_errors = true;
	$wpdb->suppress_errors = false;
	global $wpdb;
	$table_name = $wpdb->prefix . 'muelle_status';
	$formInfo = $_POST;
	unset($formInfo['action']);
	foreach ($formInfo as $item => $info) {

		$coco = setdatedb($info['actualizacion']);
		if($info['id'] != ""){
			$wpdb-> update ($table_name, array(
										'motonave'=>$info['motonave'],
										'muelle_actual'=>$info['muelle'],
										'orientacion'=>$info['orientacion'],
										'fecha_atrac'=>$info['date'],
										'hora'=>$info['hora'],
										'agente'=>$info['agente'],
										'client_princp'=>$info['cliente'],
										'producto'=>$info['producto'],
										'eslora'=>$info['eslora'],
										'calado'=>$info['calado'],
										'ton_anun'=>limpiarString($info['tonelaje-anun']),
										'ton_desc'=>limpiarString($info['tonelaje-desc']),
										'ton_acum'=>limpiarString($info['tonelaje-acum']),
										'sal-motonave'=>$info['sal-motonave'],
										'responsable' => $info['responsable'],
										'actualizacion'=> setdatedb($info['actualizacion'])
										),
										array('id'=>$info['id']) );
		}
		else {
			$wpdb->insert($table_name, array(
										'motonave'=>$info['motonave'],
										'muelle_actual'=>$info['muelle'],
										'orientacion'=>$info['orientacion'],
										'fecha_atrac'=>$info['date'],
										'hora'=>$info['hora'],
										'agente'=>$info['agente'],
										'client_princp'=>$info['cliente'],
										'producto'=>$info['producto'],
										'eslora'=>$info['eslora'],
										'calado'=>$info['calado'],
										'ton_anun'=>limpiarString($info['tonelaje-anun']),
										'ton_desc'=>limpiarString($info['tonelaje-desc']),
										'ton_acum'=>limpiarString($info['tonelaje-acum']),
										'sal-motonave'=>$info['sal-motonave'],
										'responsable' => $info['responsable'],
										'actualizacion'=> setdatedb($info['actualizacion'])
										));
		}
	}
	wp_redirect( $_SERVER['HTTP_REFERER'] );
	// return $wpdb->print_error();
}

function setdatedb($date){
	date_default_timezone_set('America/Bogota');
	if ($date == '') {
		return  date("d/m/Y");
	}
}


function styles_muelle() {
    wp_register_style( 'muellecss', plugin_dir_url( __FILE__ ).'assets/client/css/muelle.css', FALSE, NULL, 'all' );
    wp_register_script('maskLibrary' , plugin_dir_url( __FILE__ ).'assets/client/js/muelle.js',FALSE, NULL, 'all');
}

add_action( 'wp_enqueue_scripts', 'styles_muelle' );


function muelle_status() {
	$datainfo = createFormConsulDb();
?>
	<div class="container_muelle">
		<div class="loader">
			<div class="loading">
				<div class="sk-folding-cube">
					<div class="sk-cube1 sk-cube"></div>
					<div class="sk-cube2 sk-cube"></div>
					<div class="sk-cube4 sk-cube"></div>
					<div class="sk-cube3 sk-cube"></div>
				</div>
			</div>
		</div>
		<div class="muelle_back">
			<img src="<?php echo plugins_url( 'assets/client/img/mapa-puerto-2.png', __FILE__ ) ?>" draggable="false" />
			<div class="battleship">
			<?php
			if( $datainfo[0]['motonave'] != "" ){
				foreach ($datainfo as $ship) {
			?>
				<div class="ship <?php echo "muelle{$ship['muelle_actual']}" ;
											if($ship['orientacion']==1){
													echo" babor";
												}
												else{
													echo" estribor";
												}
											?>"
											id="<?php echo"muelle{$ship['muelle_actual']}" ;?>" >
				 <span class="tooltiptext"><?php echo $ship['motonave'];  ?></span>
				</div>
			<?php
			}
			?>
			</div>
		</div>

		<div class="container infomuelle" id ="info-ship">
		<?php
			foreach ($datainfo as $ship) { ?>
<div class="shipinfo " id="<?php echo "muelle{$ship['muelle_actual']}" ?>" >


	<?php
			if($GLOBALS['spanish']){
	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Motonave</th>
	                    <td><?php echo $ship['motonave']; ?></td>
	                </tr>
	                <tr>
	                    <th>Fecha de Atraque</th>
	                    <td><?php echo $ship['fecha_atrac']; ?></td>
	                </tr>
	                <tr>
	                    <th>Hora Atraque</th>
	                    <td><?php echo $ship['hora']; ?></td>
	                </tr>
	                <tr>
	                    <th>Agente Maritimo</th>
	                    <td><?php echo $ship['agente']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Eslora</th>
	                    <td><?php echo $ship['eslora']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Calado</th>
	                    <td><?php echo $ship['calado']; ?></td>
	                </tr>
	                <tr>
	                    <th>Atracado</th>
	                    <td><?php if ($ship['orientacion']==1){
	                    		echo "Babor";
	                    	} else if ($ship['orientacion']==2){
	                    		echo "Estribor";
	                    	} ?></td>
	                </tr>
									<tr>
										<th class="ulti" >Responsable</th>
										<td><?php echo $ship['responsable'] ?></td>
									</tr>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Clientes Principales</th>
	                    <td><?php echo $ship['client_princp']; ?></td>
	                </tr>
	                <tr>
	                    <th>Producto</th>
	                    <td><?php echo $ship['producto']; ?></td>
	                </tr>
	                <tr>
	                    <th>Tonelaje Anunciado</th>
	                    <td><?php echo $ship['ton_anun']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th>Tonelaje Descargado</th>
	                    <td><?php echo $ship['ton_desc']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Tonelaje Acumulado</th>
	                    <td><?php echo $ship['ton_acum']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Saldo motonave</th>
	                    <td><?php echo $ship['sal-motonave']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th>Atracado en Muelle #</th>
	                    <td><?php echo $ship['muelle_actual']; ?></td>
	                </tr>
									<tr>
										<th class="ulti" >Última actualización</th>
										<td><?php echo $ship['actualizacion'] ?></td>
									</tr>
	            </tbody>
	        </table>
	    </div>
	</div>

	<?php
	}
	else {
	?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Motor ship</th>
	                    <td><?php echo $ship['motonave']; ?></td>
	                </tr>
	                <tr>
	                    <th>Mooring Date</th>
	                    <td><?php echo $ship['fecha_atrac']; ?></td>
	                </tr>
	                <tr>
	                    <th>Mooring Time</th>
	                    <td><?php echo $ship['hora']; ?></td>
	                </tr>
	                <tr>
	                    <th>Shipping Agent</th>
	                    <td><?php echo $ship['agente']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Length</th>
	                    <td><?php echo $ship['eslora']; ?></td>
	                </tr>
	                 <tr>
	                    <th>Depth of Water</th>
	                    <td><?php echo $ship['calado']; ?></td>
	                </tr>
	                <tr>
	                    <th class="ulti">Moorgin to</th>
	                    <td><?php if ($ship['orientacion']==1){
	                    		echo "Port";
	                    	} else if ($ship['orientacion']==2){
	                    		echo "Standboard";
	                    	} ?></td>
	                </tr>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	        <table>
	            <tbody>
	                <tr>
	                    <th>Main Customers</th>
	                    <td><?php echo $ship['client_princp']; ?></td>
	                </tr>
	                <tr>
	                    <th>Product</th>
	                    <td><?php echo $ship['producto']; ?></td>
	                </tr>
	                <tr>
	                    <th>Announced Tonnage</th>
	                    <td><?php echo $ship['ton_anun']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th>Unloader Tonnage</th>
	                    <td><?php echo $ship['ton_desc']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Accumulated Tonnage</th>
	                    <td><?php echo $ship['ton_acum']; ?> TM</td>
	                </tr>
	                 <tr>
	                    <th>Motorship Balance</th>
	                    <td><?php echo $ship['sal-motonave']; ?> TM</td>
	                </tr>
	                <tr>
	                    <th class="ulti">Mooring at dock #</th>
	                    <td><?php echo $ship['muelle_actual']; ?></td>
	                </tr>
	            </tbody>
	        </table>
	    </div>
	</div>


	<?php
	}
	?>
</div>
		<?php } }
		?>
		</div>
	</div>
<?php
	wp_enqueue_style('muellecss');
	wp_enqueue_script('maskLibrary');
}

add_shortcode('muelle_status', 'muelle_status');


function getFiveLastpdf($atts){

	$attachments = get_posts(
		array(
		    'post_type' => 'attachment',
		    'posts_per_page' => $atts['val'],
		    'post_status' => null,
		    'post_mime_type' => 'application/pdf'
    	)
	);
?>
	<div class="filepicker">
	<select>

	<option value="0">
	<?php
		$txt = ($GLOBALS['spanish']) ? "Seleccione una fecha" : "Select date" ;
		echo $txt;
	?>
	</option>

<?php
	foreach ( $attachments as $attachment ) {
		$title = get_the_title($attachment);
		$title = explode(" ", $title);
			if (strnatcasecmp ($title[0] , "SITUACION") == 0 ){
				$hora = get_the_date('j \d\e\ F \d\e\ Y', $attachment);
				echo "<option value='{$attachment->guid}'>{$hora}</option>";
			}
	}
?>
	</select>
	<button>
	<?php
		$txt = ($GLOBALS['spanish']) ? "Descargar Situacion portuaria" : "Download pier status" ;
		echo $txt;
	?></button>
	</div>
<?php
}
add_shortcode('pdfselect', 'getFiveLastpdf');
?>

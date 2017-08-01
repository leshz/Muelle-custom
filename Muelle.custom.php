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
?>
	<div class="wrap">
		<h2>Muelle en tiempo real</h2>
		<form method="POST" action="options.php">
			<?php 
				settings_fields('max-length-content-settings-group');
				do_settings_sections( 'max-length-content-settings-group' ); 
			?>
			<label>Longitud máxima:&nbsp;</label>
			<input 	type="text" 
					name="max_length_value" 
					id="max_length_value" 
					value="<?php echo get_option('max_length_value'); ?>" />
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

/*
* Función que registra las opciones del formulario en una lista blanca para que puedan ser guardadas
*/
function max_length_content_settings(){
	register_setting('max-length-content-settings-group',
					 'max_length_value',
					 'intval');
}
add_action('admin_init','max_length_content_settings');

/*
* Función que devuelve el contenido de un post limitado a la longitud configurada en la página de opciones 
*/
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
?>
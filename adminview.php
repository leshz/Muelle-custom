<?php 

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
									<label>Tonelaje descargado día</label>
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
									<label>Operador</label>
									<input class="u-full-width"  name="<?php echo $form; ?>[responsable]"type="text" value="<?php echo $item['responsable']; ?>" />
								</div>
								<div class="three columns">
									<label>Hora y fecha de actualizacion</label>
									<input class="u-full-width" id="date-ac"  data-toggle="datepicker"  maxlength="20" name="<?php echo $form; ?>[actualizacion]"type="text" value="<?php echo $item['actualizacion']; ?>" />

								</div>
								<div class="twelve columns">
									<small>Si el campo <strong>Hora y fecha de actualizacion</strong> se encuentra vacio, se actualizara automaticamente</small>
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
<?php }  ?>
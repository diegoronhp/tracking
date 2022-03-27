	<?php
		
	?>	
	<!-- Modal -->
	<div class="modal-wrapper" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="popup-contenedor">
		<a class="popup-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar cliente</h4>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="edit_clientes" name="edit_clientes" action="Connections/edit_clientes.php">
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">Nit</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nit" name="mod_nit"  required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div> 
			  </div>
		  <div class="form-group">
				<label for="mod_dv" class="col-sm-3 control-label" >DV</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="mod_dv" name="mod_dv">
				</div> 
			  </div>
			  <div	class="form-group">
			  <label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
			  <div class="col-sm-8">
			  	<input type="text" class="form-control" id="mod_nombre" name="mod_nombre" required>
			  </div>
				</div>
			   <div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
				 <input type="email" class="form-control" id="mod_email" name="mod_email">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_direccion" name="mod_direccion" ></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_ciudad" class="col-sm-3 control-label">Ciudad</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_ciudad" name="mod_ciudad" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_dia_corte" class="col-sm-3 control-label" >Dia Corte</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="mod_dia_corte" name="mod_dia_corte">
				</div> 
			  </div>
			  <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="a" selected>Activo</option>
					<option value="i">Inactivo</option>
				  </select>
				</div>
			  </div>
			 
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
			
			
		  </div>
		</div>
	</div>
	
	<?php
		
	?>
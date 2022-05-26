<!doctype html>
<html lang="en">
	<body>
		<div class="form-group">
			<p>
			<textarea
				class="form-control" type="text" name="tran_coment" rows="4" value=""
				placeholder="Añadir un comentario" id="TA"
			></textarea>
			<div class="ta_err"><span class="help-block text-danger"></span></div>
			</p>
		</div>
		
		<div class="form-group" style="overflow:auto;">
			<div style="float:right;">
				<button type="button" onclick="last_step()">Finalizar Transaccion</button>
				<a href="reset_regist.php" class="text-white">
					<button type="button" class="bg-danger">Cancelar</a>
				</a>
			</div>
		</div>
</html>

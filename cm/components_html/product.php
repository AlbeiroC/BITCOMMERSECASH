<form key="<?php echo rand(85,3843737); ?>">
	<input type="hidden" class="btc-usd-price input-number">
	<div class="box">
		<div class="columns is-mobile offer" style="overflow: auto;">
			<div class="column is-2" style="min-width: 70px;">
				<input type="file" name="file-uploads" style="position: fixed;left: -4000px;top: -200vh;">
				<div class="has-text-centered button is-large" data-file="[name=file-uploads]">
					<span class="icon">
						<i class="fa fa-plus has-text-link fa-3x"></i>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="box">
		<div class="columns is-multiline is-mobile">
			<div class="column is-half">
				<div class="field">
					<div class="control">
						¿Que vendes?
					</div>
					<div class="control has-icons-left is-expanded">
						<input type="text" class="input" name="producto" maxlength="150" required="">
						<span class="icon is-left">
							<i class="fa fa-edit"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="column is-half">
				<div class="field">
					<div class="control">
						Existencias
					</div>
					<div class="control is-expanded">
						<input type="text" class="input input-number input-number-without-zero" name="stock" value="1" min="1">
					</div>
				</div>
			</div>
			<div class="column is-full">
				<div class="field">
					<div class="control">
						Describe tu producto: 
					</div>
					<div class="control">
						<textarea  name="descripcion" class="textarea" maxlength="1000" required=""></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

	<br><br>
	<div class="box">
		<div class="box box-closeup">
			<i class="fa fa-calculator"></i> <span class="is-hidden-mobile">Calculadora de precios</span> (<span class="btc-usd-price"></span> USD / BTC)
		</div>
		<div class="columns is-mobile">
			<div class="column">
				<div class="field has-addons">
					<div class="control is-expanded">
						<input type="text" class="input input-number" value="h" name="usd_price" min="0.01" required="">
					</div>
					<div class="control">
						<div class="button is-static is-uppercase">USD</div>
					</div>
				</div>
			</div>
			<div class="column is-hidden">
				<div class="field has-addons">
					<div class="control button is-static">
						BTC
					</div>
					<div class="control is-expanded">
						<input type="text" class="input input-number-bitcoin" readonly="" value="s" name="btc_price" min="0.00000001">
					</div>
					<div class="control">
						<span class="is-hidden"><input type="hidden" name="automatic_price" value="false"></span>
						<button type="button" class="fixed-btc-price button" title="Activa la casilla para fijar este precio en Bitcoins o desactivala para que el precio sea automático."><i class="far fa-circle fa-3x"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<br><br>
	<div class="box">
		<div class="box box-closeup">
			<i class="fa fa-truck"></i> Envios
		</div>
		<div class="columns is-mobile">
			<div class="column has-text-centered" title="El producto se envía a nivel Nacional">
				Nacionales
				<br>
				<input id="national" type="checkbox" name="shipping[]" value="national" class="switch">
				<label for="national" class="has-text-link"></label>
			</div>
			<div class="column has-text-centered" title="El producto se envía a nivel Internacional">
				Internacionales
				<br>
				<input id="international" type="checkbox" name="shipping[]" value="international" class="switch">
				<label for="international" class="has-text-link"></label>
			</div>
		</div>
	</div>


	<br><br>
	<div class="box">
		<div class="box box-closeup">
			Procesadores de Pago:
		</div>
		<div class="columns is-mobile">
			<div class="column has-text-link has-text-centered" title="Paypal">
				<span class="icon">
					<i class="fab fa-paypal fa-3x"></i>
				</span>
				<br>
				<input id="paypal" type="checkbox" name="payment[]" value="paypal" class="is-link switch">
				<label for="paypal" class="has-text-link"></label>
			</div>
			<div class="column has-text-centered has-text-warning" title="Bitcoin">
				<span class="icon">
					<i class="fab fa-bitcoin fa-3x"></i>
				</span>
				<br>
				<input id="bitcoin" type="checkbox" name="payment[]" value="bitcoin" class="is-warning switch">
				<label for="bitcoin" class="has-text-link"></label>
			</div>
			<div class="column has-text-centered has-text-success" title="Transferencias o Consignaciones">
				<span class="icon">
					<i class="fa fa-university fa-3x"></i>
				</span>
				<br>
				<input id="bank" type="checkbox" name="payment[]" value="bank" class="is-success switch">
				<label for="bank" class="has-text-link"></label>
			</div>
		</div>
	</div>

	<div class="columns">
		<div class="column is-6-mobile is-offset-3-mobile is-4-desktop is-offset-4-desktop">
			<center>
				<button type="submit" class="button is-link">Guardar</button>
			</center>
		</div>
	</div>

</form>
					<form action="" onsubmit="return false;" id="update-info" autocomplete="off">
						<center>
							<div class="box dropzone" style="padding: 5px;height: auto;max-width: 162px;margin-bottom: -25px;z-index:2;position: relative;background: #fff url(https://cdn3.iconfinder.com/data/icons/internet-and-web-4/78/internt_web_technology-11-512.png) no-repeat center /50px;">
								<div class="dz-message"></div>
							</div>
						</center>
						<div class="box" style="padding-top: 50px;z-index:1;position: relative;">
							<div class="columns is-mobile is-multiline">
								<div class="column is-6">
									<div class="field has-addons">
										<div class="control is-expanded">
											<input type="text" class="input input-beauty user-data-user-nombre no-changeable" name="nombre" autocomplete="off" placeholder="Nombre de la empresa">
										</div>
									</div>
								</div>
								<div class="column is-6">
									<div class="field has-addons">
										<div class="control is-expanded">
											<input type="text" class="input input-beauty user-data-user-email no-changeable" name="email" autocomplete="off" placeholder="E-Mail">
										</div>
									</div>
								</div>
								<div class="column is-6">
									<div class="field has-addons">
										<div class="control is-expanded">
											<input type="password" class="input input-beauty" name="password" autocomplete="off" placeholder="Clave de seguridad">
										</div>
									</div>
								</div>
								<div class="column is-6">
									<div class="field has-addons">
										<div class="control is-expanded">
											<input type="password" class="input input-beauty" name="repassword" autocomplete="off" placeholder="Repetir Clave">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="box" style="margin-top: 75px;">
							<div class="box box-closeup">
								<i class="far fa-edit"></i><span class="notice"></span>
							</div>
							<textarea name="about" class="textarea user-data-user-about no-changeable"></textarea>
						</div>
						<div class="box" style="margin-top: 75px;">
							<div class="box box-closeup">
								<i class="far fa-share-square"></i><span class="notice"></span>
							</div>
							<div class="columns">
								<div class="column">
									<div class="field">
									  <p class="control has-icons-left">
									    <input class="input user-data-user-facebook input-beauty no-changeable" type="text" placeholder="Usuario o Url" name="facebook">
									    <span class="icon is-small is-left">
									      <i class="fab fa-facebook"></i>
									    </span>
									  </p>
									</div>
								</div>
								<div class="column">
									<div class="field">
									  <p class="control has-icons-left">
									    <input class="input user-data-user-instagram input-beauty no-changeable" type="text" placeholder="Usuario o Url" name="instagram">
									    <span class="icon is-small is-left">
									      <i class="fab fa-instagram"></i>
									    </span>
									  </p>
									</div>									
								</div>
								<div class="column">
									<div class="field">
									  <p class="control has-icons-left">
									    <input class="input user-data-user-twitter input-beauty no-changeable" type="text" placeholder="Usuario o Url" name="twitter">
									    <span class="icon is-small is-left">
									      <i class="fab fa-twitter"></i>
									    </span>
									  </p>
									</div>
								</div>
							</div>
						</div>

						<div class="box" style="margin-top: 75px;z-index: 9;">
							<div class="box box-closeup" data-open=".modal-countries" style="padding: 2px;">
								<img class="img-flag-register" data-src="<?php echo $user['pais_bandera']; ?>" style="height: 50px;width: 75px;">
								<span class="notice"></span>
							</div>
							<div class="field">
								<div class="control has-icons-left has-icons-right">
									<span class="icon is-left">
										<i class="fa fa-flag"></i>
									</span>
									<input type="hidden" name="divisa" class="no-ajaxable pais-moneda no-changeable">
									<input type="hidden" name="pais" class="no-ajaxable pais-code no-changeable">
									<input type="text" placeholder="¿De donde eres?" name="preview" class="no-ajaxable input is-rounded find-countrie pais-nombre no-changeable" style="position: relative;z-index: 2;background: none;">
									<span class="icon is-right divisa-input" style="text-transform:uppercase;"></span>
								</div>
							</div>
						</div>

						<div class="box" style="background: none;box-shadow: none;border-width: 0px;">
							<div class="level">
								<div class="level-left"> </div>
								<div class="level-right">
									<div class="level-item">
										<div class="field has-addons">
											<div class="control">
												<button type="submit" class="button is-link">Guardar</button>
												<input type="reset" class="is-hidden">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</form>
<div class="modal modal-countries is-active" style="display:none;">
  <div class="modal-background"></div>
  <div class="modal-card">
  	<div class="modal-card-head">
		<style>
			.has-autocomplete{
				position: absolute;
				z-index: 1;
				top: 0px;
				left: 0px;
				opacity: 0.4;
				color: #A1A1A1;
			}
		</style>
		<div class="field">
			<div class="control has-icons-left has-icons-right">
				<span class="icon is-left">
					<i class="fa fa-flag"></i>
				</span>
				<input type="text" class="input is-rounded find-countrie no-list" style="position: relative;z-index: 2;background: none;">
				<span class="icon is-right divisa-input" style="text-transform:uppercase;"></span>
			</div>
		</div>
  	</div>
	<section class="modal-card-body has-scroll" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;position: relative;min-height:calc(100vh - (150px));max-height:calc(100vh - (150px));">
		<div class="columns is-multiline is-mobile">
			<?php
				$countrys = json_decode(file_get_contents('./cm/country_list.json'),true);
				foreach ($countrys as $key => $pais) {
					$pais['flag'] = str_replace('https','http',str_replace('restcountries.eu/data/','bitcommersecash.local/api_v2/countries/',$pais['flag']));
					$code = eraseStr(strtolower($pais['translations']['es']));
					echo '<div class="column pais_img"><a href="#countrie-tag" keycode="'.$code.'" countrie="'.$pais['translations']['es'].'" currency="'.$pais['currencies'][0]['code'].'" iso2="'.$pais['alpha2Code'].'" iso3="'.$pais['alpha3Code'].'" flag="'.$pais['flag'].'" title="'.$pais['translations']['es'].'"><img src="'.$pais['flag'].'" style="max-width:50px;"></a></div>';
				}
			?>
		</div>
	</section>
  </div>
</div>

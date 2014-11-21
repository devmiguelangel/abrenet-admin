<?php
require $_SESSION['dir'] . '/app/controllers/UserController.php';

$user = new UserController();
if ($user->login('admin', 'pw4admin') === true) {
	echo "string";
}

/*function crypt_pass($password, $digito = 7) {
	$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$salt = sprintf('$2x$%02d$', $digito);
	
	for($i = 0; $i < 22; $i++){
		$salt .= $set_salt[mt_rand(0, 63)];
	}
	
	return crypt($password, $salt);
}

echo crypt_pass('pw4admin');

$pass_bd = '$2x$07$zcfSZ2.sE.jOSZdcCGK0geXOjt98pv2iUM22AIdJl.gcjgwYMd44S';

if(crypt('pw4admin', $pass_bd) == $pass_bd) {
	echo "<br>OK";
}
*/
?>
<div class="rc-records">
	


    
	<div class="rp-pr-container" id="rp-tab-2" style=" display:none; ">
    	<form class="f-reports">
        	<!--<label>N° de Póliza: </label>
            <select id="frp-policy" name="frp-policy">
                <option value="">Seleccione...</option>
<option value="QFMjMSQyMDEzNTM3Y2ZlZmIzZTQxZTUuODg2ODk3MTM=">80199</option>            </select>-->

            <label>No. de Certificado: </label>
            <input type="text" id="frp-nc" name="frp-nc" value="" autocomplete="off">

            <br>
            <label>Cliente: </label>
            <input type="text" id="frp-client" name="frp-client" value="" autocomplete="off">

            <label style="width:auto;">C.I.: </label>
            <input type="text" id="frp-dni" name="frp-dni" value="" autocomplete="off">

            <label style="width:auto;">Complemento: </label>
            <input type="text" id="frp-comp" name="frp-comp" value="" autocomplete="off" style="width:40px;">

            <label style="width:auto;">Extensión: </label>
            <select id="frp-ext" name="frp-ext">
                <option value="">Seleccione...</option>
<option value="1">La Paz</option><option value="2">Oruro</option><option value="3">Potosí</option><option value="4">Cochabamba</option><option value="5">Chuquisaca</option><option value="6">Tarija</option><option value="7">Santa Cruz</option><option value="8">Beni</option><option value="9">Pando</option>            </select><br>

            <label style="">Fecha: </label>
            <label style="width:auto;">desde: </label>
            <input type="text" id="frp-date-b" name="frp-date-b" value=""
            	autocomplete="off" class="date" readonly>

            <label style="width:auto;">hasta: </label>
            <input type="text" id="frp-date-e" name="frp-date-e" value=""
            	autocomplete="off" class="date" readonly>

            <input type="hidden" id="frp-id-user" name="frp-id-user" value="QFMjMSQyMDEzNTM1NTdhNzEyYzFiYjYuNTA5MTQ2NDk=">
            <input type="hidden" id="ms" name="ms" value="8991b1d81282aa116cf7f035c8ad50ec">
            <input type="hidden" id="page" name="page" value="f9bffe20974b0244098886ab6ac791f6">
            <input type="hidden" id="data-pr" name="data-pr" value="REU=" >
            <input type="hidden" id="pr" name="pr" value="DE">
            <br>
            <div id="accordion" class="accordion">

				<h5>Entidad Financiera</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-1" name="frp-ef-1" value="1">
                    	Ecofuturo                 </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-2" name="frp-ef-2" value="2">
                    	Idepro                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-3" name="frp-ef-3" value="3">
                    	Crecer                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-4" name="frp-ef-4" value="4">
                    	 Sartawi                  </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-5" name="frp-ef-5" value="5">
                    	 BISA LEASING             </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-6" name="frp-ef-6" value="6">
                    	 Emprender                </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-7" name="frp-ef-7" value="7">
                    	 Paulo VI                 </label>
		       </div>

				<h5>Aseguradora</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-1" name="frp-ase-1" value="1">
                    	Crediseguros               </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-2" name="frp-ase-2" value="2">
                    	Alianza                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-3" name="frp-ase-3" value="3">
                    	Credinform                 </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-4" name="frp-ase-4" value="4">
                    	Bisa Seguros               </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-5" name="frp-ase-5" value="5">
                    	Nacional Vida              </label>
		       </div>


				<h5>Pendiente</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-pe" name="frp-pe" value="P">
                    	Pendiente                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-sp" name="frp-sp" value="S">
                    	Subsanado/Pendiente                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ob" name="frp-ob" value="O">
                    	Observado                    </label><br>
<label class="lbl-cb">
		<input type="checkbox" id="frp-estado-14" name="frp-estado-14" value="14">&nbsp;Examenes Medicos y/o Requisitos</label> <label class="lbl-cb">
		<input type="checkbox" id="frp-estado-15" name="frp-estado-15" value="15">&nbsp;Reaseguro</label> <label class="lbl-cb">
		<input type="checkbox" id="frp-estado-16" name="frp-estado-16" value="16">&nbsp;Aclaraciones</label> <label class="lbl-cb">
		<input type="checkbox" id="frp-estado-17" name="frp-estado-17" value="17">&nbsp;Error en Datos</label>                 </div>
                <h5>Aprobado</h5>
                <div>
					<label class="lbl-cb">
						<input type="checkbox" id="frp-approved-fc" name="frp-approved-fc" value="FC">
							Free Cover					</label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-nf" name="frp-approved-nf" value="NF">
	                    	No Free Cover                    </label>
					<label class="lbl-cb">
						<input type="checkbox" id="frp-approved-ep" name="frp-approved-ep" value="EP">
							Extraprima					</label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-np" name="frp-approved-np" value="NP">
                    		No Extraprima                    </label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-em" name="frp-approved-em" value="EM">
                    		Emitido                    </label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-ne" name="frp-approved-ne" value="NE">
                    		No Emitido                    </label>
                </div>

                <h5>Rechazado</h5>
                <div>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-rejected" name="frp-rejected" value="RE">
                    		Rechazado                    </label>
                </div>

                <h5>Anulado</h5>
                <div>
                	<label class="lbl-cb">
                		<input type="checkbox" id="frp-canceled" name="frp-canceled" value="AN">
                			Anulado                	</label>
                </div>
            </div>

            <div align="center">
            	<input type="hidden" id="idef" name="idef" value="QFMjMSQyMDEzNTM1NTI0YTM1MDg0YzAuMDgxNDgzNjg=">
                <input type="submit" id="frp-search" name="frp-search"
                	value="Buscar" class="frp-btn">
                <input type="reset" id="frp-reset" name="frp-reset"
                	value="Restablecer Campos" class="frp-btn">
            </div>
        </form>
        <div class="result-container">
            <div class="result-loading rl-de"></div>
            <div class="result-search rs-de">
            	<table class="result-list" id="result-de">
					 <thead>
					    <tr>
					      <td>No. Certificado</td>
					      <td>Entidad Financiera</td>
					      <td>Cliente</td>
					      <td>CI</td>
					      <td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Ciudad</td>
					      <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Celular</td>
					      <td>Email</td>
					      <td>Monto Solicitado</td>
					      <td>Moneda</td>
					      <td><?=htmlentities('Plazo Crédito', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Estatura (cm)</td>
					      <td>Peso (kg)</td>
					      <td><?=htmlentities('Participación (%)', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Deudor / Codeudor</td>
					      <td>Edad</td>
					      <td>Creado Por</td>
					      <td>Fecha de Ingreso</td>
					      <td>Sucursal</td>
					      <td>Agencia</td>
					      <td>Certificados Anulados</td>
					      <td>Anulado por</td>
					      <td><?=htmlentities('Fecha de Anulación', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Estado Banco</td>
					      <td><?=htmlentities('Motivo Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Porcentaje Extraprima</td>
					      <td><?=htmlentities('Fecha Respuesta final Compañia', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Días en Proceso', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Días de Ultima Modificación', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Duración total del caso', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Solicitud Enviada</td>
					    </tr>
					  </thead>
				</table></div>
        </div>
    </div>






	<div class="rp-pr-container" id="rp-tab-3" style=" display:none; ">
    	<form class="f-reports">
        	<!--<label>N° de Póliza: </label>
            <select id="frp-policy" name="frp-policy">
                <option value="">Seleccione...</option>
<option value="QFMjMSQyMDEzNTM3Y2ZmZDk5NzZiYjQuMzY1MzcwNjg=">111100</option>            </select>-->

            <label>No. de Certificado: </label>
            <input type="text" id="frp-nc" name="frp-nc" value="" autocomplete="off">

            <br>
            <label>Cliente: </label>
            <input type="text" id="frp-client" name="frp-client" value="" autocomplete="off">

            <label style="width:auto;">C.I.: </label>
            <input type="text" id="frp-dni" name="frp-dni" value="" autocomplete="off">

            <label style="width:auto;">Complemento: </label>
            <input type="text" id="frp-comp" name="frp-comp" value="" autocomplete="off" style="width:40px;">

            <label style="width:auto;">Extensión: </label>
            <select id="frp-ext" name="frp-ext">
                <option value="">Seleccione...</option>
<option value="1">La Paz</option><option value="2">Oruro</option><option value="3">Potosí</option><option value="4">Cochabamba</option><option value="5">Chuquisaca</option><option value="6">Tarija</option><option value="7">Santa Cruz</option><option value="8">Beni</option><option value="9">Pando</option>            </select><br>

            <label style="">Fecha: </label>
            <label style="width:auto;">desde: </label>
            <input type="text" id="frp-date-b" name="frp-date-b" value=""
            	autocomplete="off" class="date" readonly>

            <label style="width:auto;">hasta: </label>
            <input type="text" id="frp-date-e" name="frp-date-e" value=""
            	autocomplete="off" class="date" readonly>

            <input type="hidden" id="frp-id-user" name="frp-id-user" value="QFMjMSQyMDEzNTM1NTdhNzEyYzFiYjYuNTA5MTQ2NDk=">
            <input type="hidden" id="ms" name="ms" value="8991b1d81282aa116cf7f035c8ad50ec">
            <input type="hidden" id="page" name="page" value="f9bffe20974b0244098886ab6ac791f6">
            <input type="hidden" id="data-pr" name="data-pr" value="VFJE" >
            <input type="hidden" id="pr" name="pr" value="TRD">
            <br>
            <div id="accordion" class="accordion">

				<h5>Entidad Financiera</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-1" name="frp-ef-1" value="1">
                    	Ecofuturo                 </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-2" name="frp-ef-2" value="2">
                    	Idepro                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-3" name="frp-ef-3" value="3">
                    	Crecer                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-4" name="frp-ef-4" value="4">
                    	 Sartawi                  </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-5" name="frp-ef-5" value="5">
                    	 BISA LEASING             </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-6" name="frp-ef-6" value="6">
                    	 Emprender                </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-7" name="frp-ef-7" value="7">
                    	 Paulo VI                 </label>
		       </div>

				<h5>Aseguradora</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-1" name="frp-ase-1" value="1">
                    	Crediseguros               </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-2" name="frp-ase-2" value="2">
                    	Alianza                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-3" name="frp-ase-3" value="3">
                    	Credinform                 </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-4" name="frp-ase-4" value="4">
                    	Bisa Seguros               </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-5" name="frp-ase-5" value="5">
                    	Nacional Vida              </label>
		       </div>


                <h5>Aprobado</h5>
                <div>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-em" name="frp-approved-em" value="EM">
                    		Emitido                    </label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-ne" name="frp-approved-ne" value="NE">
                    		No Emitido                    </label>
                </div>

                <h5>Rechazado</h5>
                <div>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-rejected" name="frp-rejected" value="RE">
                    		Rechazado                    </label>
                </div>

                <h5>Anulado</h5>
                <div>
                	<label class="lbl-cb">
                		<input type="checkbox" id="frp-canceled" name="frp-canceled" value="AN">
                			Anulado                	</label>
                </div>
            </div>

            <div align="center">
            	<input type="hidden" id="idef" name="idef" value="QFMjMSQyMDEzNTM1NTI0YTM1MDg0YzAuMDgxNDgzNjg=">
                <input type="submit" id="frp-search" name="frp-search"
                	value="Buscar" class="frp-btn">
                <input type="reset" id="frp-reset" name="frp-reset"
                	value="Restablecer Campos" class="frp-btn">
            </div>
        </form>
        <div class="result-container">
            <div class="result-loading rl-trd"></div>
            <div class="result-search rs-trd">


				<table class="result-list" id="result-de">
					 <thead>
					    <tr>
					      <td>No. Certificado</td>
					      <td>Entidad Financiera</td>
					      <td>Cliente</td>
					      <td>CI</td>
					      <td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Ciudad</td>
					      <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Celular</td>
					      <td>Email</td>
					      <td>Avenida o calle</td>
					      <td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Numero domicilio</td>
					      <td>Email</td>
					      <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Opción', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Tipo inmueble</td>
					      <td>Uso</td>
					      <td>Estado</td>
					      <td>Departamento</td>
					      <td>Zona</td>
					      <td><?=htmlentities('Dirección', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Monto inmueble</td>
					      <td><?=htmlentities('Tipo vehículo', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Marca</td>
					      <td>Modelo</td>
					      <td>Placa</td>
					      <td><?=htmlentities('Uso vehículo', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Tracción', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Cero KM </td>
					      <td><?=htmlentities('Monto vehículo', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Plazo crédito', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('No. póliza', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Forma Pago</td>
					      <td>Emitido</td>
					      <td>Sucursal</td>
					      <td>Agencia</td>
					      <td>Creado por</td>
					      <td>Fecha de ingreso</td>
					      <td>Certificados anulados</td>
					      <td>Certificado inmueble</td>
					      <td><?=htmlentities('Certificado vehículo', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Cotización inmueble', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Cotización vehículo', ENT_QUOTES, 'UTF-8');?></td>
					    </tr>
					  </thead>
				</table>
            </div>
        </div>
    </div>


	<div class="rp-pr-container" id="rp-tab-4" style=" display:none; ">
    	<form class="f-reports">
        	<!--<label>N° de Póliza: </label>
            <select id="frp-policy" name="frp-policy">
                <option value="">Seleccione...</option>
<option value="QFMjMSQyMDEzNTM3Y2ZmZWE0Y2FhMDguNTM3OTYzMDc=">15411</option>            </select>-->

            <label>No. de Certificado: </label>
            <input type="text" id="frp-nc" name="frp-nc" value="" autocomplete="off">

            <br>
            <label>Cliente: </label>
            <input type="text" id="frp-client" name="frp-client" value="" autocomplete="off">

            <label style="width:auto;">C.I.: </label>
            <input type="text" id="frp-dni" name="frp-dni" value="" autocomplete="off">

            <label style="width:auto;">Complemento: </label>
            <input type="text" id="frp-comp" name="frp-comp" value="" autocomplete="off" style="width:40px;">

            <label style="width:auto;">Extensión: </label>
            <select id="frp-ext" name="frp-ext">
                <option value="">Seleccione...</option>
<option value="1">La Paz</option><option value="2">Oruro</option><option value="3">Potosí</option><option value="4">Cochabamba</option><option value="5">Chuquisaca</option><option value="6">Tarija</option><option value="7">Santa Cruz</option><option value="8">Beni</option><option value="9">Pando</option>            </select><br>

            <label style="">Fecha: </label>
            <label style="width:auto;">desde: </label>
            <input type="text" id="frp-date-b" name="frp-date-b" value=""
            	autocomplete="off" class="date" readonly>

            <label style="width:auto;">hasta: </label>
            <input type="text" id="frp-date-e" name="frp-date-e" value=""
            	autocomplete="off" class="date" readonly>

            <input type="hidden" id="frp-id-user" name="frp-id-user" value="QFMjMSQyMDEzNTM1NTdhNzEyYzFiYjYuNTA5MTQ2NDk=">
            <input type="hidden" id="ms" name="ms" value="8991b1d81282aa116cf7f035c8ad50ec">
            <input type="hidden" id="page" name="page" value="f9bffe20974b0244098886ab6ac791f6">
            <input type="hidden" id="data-pr" name="data-pr" value="VFJN" >
            <input type="hidden" id="pr" name="pr" value="TRM">
            <br>
            <div id="accordion" class="accordion">

				<h5>Entidad Financiera</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-1" name="frp-ef-1" value="1">
                    	Ecofuturo                 </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-2" name="frp-ef-2" value="2">
                    	Idepro                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-3" name="frp-ef-3" value="3">
                    	Crecer                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-4" name="frp-ef-4" value="4">
                    	 Sartawi                  </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-5" name="frp-ef-5" value="5">
                    	 BISA LEASING             </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-6" name="frp-ef-6" value="6">
                    	 Emprender                </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ef-7" name="frp-ef-7" value="7">
                    	 Paulo VI                 </label>
		       </div>

				<h5>Aseguradora</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-1" name="frp-ase-1" value="1">
                    	Crediseguros               </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-2" name="frp-ase-2" value="2">
                    	Alianza                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-3" name="frp-ase-3" value="3">
                    	Credinform                 </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-4" name="frp-ase-4" value="4">
                    	Bisa Seguros               </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ase-5" name="frp-ase-5" value="5">
                    	Nacional Vida              </label>
		       </div>


				<h5>Pendiente</h5>
                <div>
                    <label class="lbl-cb"><input type="checkbox" id="frp-pe" name="frp-pe" value="P">
                    	Pendiente                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-sp" name="frp-sp" value="S">
                    	Subsanado/Pendiente                    </label>
                    <label class="lbl-cb"><input type="checkbox" id="frp-ob" name="frp-ob" value="O">
                    	Observado                    </label><br>
<label class="lbl-cb">
		<input type="checkbox" id="frp-estado-10" name="frp-estado-10" value="10">&nbsp;Reaseguro</label> <label class="lbl-cb">
		<input type="checkbox" id="frp-estado-11" name="frp-estado-11" value="11">&nbsp;Aclaraciones</label> <label class="lbl-cb">
		<input type="checkbox" id="frp-estado-12" name="frp-estado-12" value="12">&nbsp;Error en Datos</label> <label class="lbl-cb">
		<input type="checkbox" id="frp-estado-13" name="frp-estado-13" value="13">&nbsp;Medidas de Seguridad</label>                 </div>
                <h5>Aprobado</h5>
                <div>
					<label class="lbl-cb">
						<input type="checkbox" id="frp-approved-ep" name="frp-approved-ep" value="EP">
							Extraprima					</label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-np" name="frp-approved-np" value="NP">
                    		No Extraprima                    </label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-em" name="frp-approved-em" value="EM">
                    		Emitido                    </label>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-approved-ne" name="frp-approved-ne" value="NE">
                    		No Emitido                    </label>
                </div>

                <h5>Rechazado</h5>
                <div>
                    <label class="lbl-cb">
                    	<input type="checkbox" id="frp-rejected" name="frp-rejected" value="RE">
                    		Rechazado                    </label>
                </div>

                <h5>Anulado</h5>
                <div>
                	<label class="lbl-cb">
                		<input type="checkbox" id="frp-canceled" name="frp-canceled" value="AN">
                			Anulado                	</label>
                </div>
            </div>

            <div align="center">
            	<input type="hidden" id="idef" name="idef" value="QFMjMSQyMDEzNTM1NTI0YTM1MDg0YzAuMDgxNDgzNjg=">
                <input type="submit" id="frp-search" name="frp-search"
                	value="Buscar" class="frp-btn">
                <input type="reset" id="frp-reset" name="frp-reset"
                	value="Restablecer Campos" class="frp-btn">
            </div>
        </form>
        <div class="result-container">
            <div class="result-loading rl-trm"></div>
            <div class="result-search rs-trm">



				<table class="result-list" id="result-de">
					 <thead>
					    <tr>

					      <td>No. de Certificado</td>
					      <td>Entidad Financiera</td>
					      <td>Cliente</td>
					      <td>C.I.</td>
					      <td>Ciudad</td>
					      <td><?=htmlentities('Género', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Teléfono', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Celular</td>
					      <td>Email</td>
					      <td><?=htmlentities('Plazo Crédito', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Forma de Pago</td>
					      <td>Materia Asegurada</td>
					      <td>Valor Asegurado</td>
					      <td>Creado Por</td>
					      <td>Sucursal</td>
					      <td>Agencia</td>
					      <td>Fecha de Ingreso</td>
					      <td>Certificados Anulados</td>
					      <td>Anulado por</td>
					      <td><?=htmlentities('Fecha de Anulación', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Estado Banco</td>
					      <td><?=htmlentities('Motivo Estado Compañia', ENT_QUOTES, 'UTF-8');?></td>
					      <td>Porcentaje Extraprima</td>
					      <td><?=htmlentities('Fecha Respuesta final Compañia', ENT_QUOTES, 'UTF-8');?></td>
					      <td><?=htmlentities('Duración total del caso', ENT_QUOTES, 'UTF-8');?></td>

					    </tr>
					  </thead>
				</table>

            </div>
        </div>
    </div>
</div>
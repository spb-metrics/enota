<?php
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
?>
<?php 
class declaracao{
	
	private $tipo;
	public $titulo;
	public $ajax;
	
	public function __construct($tipo){
		$this->tipo = $tipo;
	}
	
	public function mostrar(){
		?>
		<table border="0" cellspacing="0" cellpadding="0" class="form">
		  <tr>
		    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		    <td width="650" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;<?php echo $this->titulo; ?><br /></td>  
		    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
		  </tr>
		  <tr>
		    <td width="18" background="img/form/lateralesq.jpg"></td>
		    <td align="center">
		        <form name="frmDeclacarao" id="frmDeclacarao" method="post" onsubmit="return false">
		            <input type="hidden" name="abertdecc" id="abertdecc">
					<input type="hidden" name="hdCancelaDecc" id="hdCancelaDecc" />
		            <fieldset><legend>Pesquisa de declara��es</legend>
		                <table width="100%">
		                    <tr>
		                        <td align="left">Nome/Raz&atilde;o Social</td>
		                        <td align="left"><input name="txtNome" type="text" class="texto" size="60" maxlength="100" /></td>
		                    </tr>
		                    <tr>
		                    	<td align="left">CNPJ</td>
		                        <td align="left"><input name="txtCNPJ" type="text" class="texto" size="20" maxlength="18" /></td>
		                    </tr>
		                    <tr>
		                    	<td align="left">N� da declara��o</td>
		                        <td align="left"><input name="txtNroDecc" type="text" class="texto" size="10" maxlength="10" /></td>
		                    </tr>
		                    <tr>
		                    	<td align="left">Compet&ecirc;ncia</td>
		                        <td align="left">
		                            <select name="cmbMes" class="combo">
		                                <option value=""></option>
		                                <?php
		                                //array dos meses comecando na posi��o 1 ate 12 e faz um for listando os meses no combo
		                                $meses = array(1=>"Janeiro","Fevereiro","Mar�o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
		                                for($x=1;$x<=12;$x++){
		                                    echo "<option value='$x'>$meses[$x]</option>";
		                                }//fim for meses
		                                ?>
		                            </select>
									<select name="cmbAno" class="combo">
										<option/>
										<?php
											$ano=date("Y");
											for($x=0; $x<=4; $x++){
												$year=$ano-$x;
												echo "<option value=\"$year\">$year</option>";
											}
										?>
									</select>
		                        </td>
		                    </tr>
		                    <tr>
		                    	<td align="left">Estado</td>
		                    	<td align="left">
		                        	<select name="cmbEstado" class="combo">
		                            	<option value=""></option>
		                            	<option value="B">Boleto</option>
		                                <option value="C">Cancelado</option>
		                                <option value="E">Escriturado</option>
		                                <option value="N">Normal</option>
		                            </select>
		                        </td>
		                    </tr>
		                    <tr>
		                    	<td align="left">Data Emiss�o</td>
		                        <td align="left"><input name="txtData" type="text" class="texto" size="12" maxlength="10" /></td>
		                    </tr>
		                    <tr>
		                    	<td align="left" colspan="2">
		                        	<input name="btPesquisar" type="submit" class="botao" value="Pesquisar" 
		                            onclick="acessoAjax('<?php echo $this->ajax;?>',this.form.id,'divDeclaracoes')" />
		                            &nbsp;
		                            <input name="btLimpar" type="reset" class="botao" value="Limpar" />
		                        </td>
		                    </tr>
		                </table>
		                <div id="divDeclaracoes"></div>
		            </fieldset>
		        </form>
			</td>
			<td width="19" background="img/form/lateraldir.jpg"></td>
		  </tr>
		  <tr>
		    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		    <td background="img/form/rodape_fundo.jpg"></td>
		    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
		  </tr>
		</table>
		<?php
	}
}


?>
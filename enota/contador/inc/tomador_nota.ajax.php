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
  include("../../include/conect.php");
  include("../../funcoes/util.php");
  $cnpjcpf =$_GET['txtTomadorCNPJ'];
  if($cnpjcpf!=""){
	  $query=mysql_query("SELECT nome,razaosocial,inscrmunicipal,logradouro,numero,complemento,bairro,cep,municipio,email,uf,codtipo FROM cadastro WHERE cnpj='$cnpjcpf' or cpf='$cnpjcpf'");
	  $dados=mysql_fetch_object($query);
	 $disable = "";
	 
	 if(strlen($cnpjcpf) == 18){
			$tomador = $dados->razaosocial;
		}elseif(strlen($cnpjcpf) == 14){
			$tomador = $dados->nome;
		}else{
			$tomador = null;
		}
  }
?>

<table width="100%" border="0" cellspacing="2" cellpadding="2"> 
<tr>
    <td width="25%" align="left">Nome/Raz�o Social<font color="#FF0000">*</font></td>
    <td width="75%" align="left"><input name="txtTomadorNome" id="txtTomadorNome" type="text" size="55" class="texto" value="<?php echo $dados->nome ;?>" <?php echo $disable; ?>>
</td>
  <tr>
    <td align="left">CEP</td>
    <td align="left">
	 <input name="txtTomadorCEP" id="txtTomadorCEP" type="text" onkeydown="return NumbersOnly( event );"  size="15" class="texto" maxlength="9" value="<?php echo $dados->cep ;?>" onkeyup="MaskCEP(this);"<?php echo $disable; ?> >
	</td>
  </tr>
  </tr>  
  <tr>
    <td align="left">Inscri��o Municipal</td>
    <td align="left"><input name="txtTomadorIM" id="txtTomadorIM" onkeydown="return NumbersOnly( event );"  type="text" size="30" class="texto" value="<?php echo $dados->inscrmunicipal ;?>"<?php echo $disable; ?>></td>
  </tr>
  <tr>
    <td align="left">Logradouro</td>
    <td align="left"><input name="txtTomadorLogradouro" id="txtTomadorLogradouro" type="text" size="30" class="texto" value="<?php echo $dados->logradouro ;?>" <?php echo $disable; ?>>
     &nbsp;&nbsp;N�mero <input name="txtTomadorNumero" onkeydown="return NumbersOnly( event );"  type="text" size="5" class="texto" maxlength="5" value="<?php echo $dados->numero ;?>" <?php echo $disable; ?>/>
	</td>
  </tr>  
  <tr>
    <td align="left">Complemento</td>
    <td align="left"><input name="txtTomadorComplemento" type="text" size="30" class="texto" value="<?php echo $dados->complemento ;?>" <?php echo $disable; ?>>
	</td>
  </tr>
  <tr>
    <td align="left">Bairro</td>
    <td align="left"><input name="txtTomadorBairro" id="txtTomadorBairro" type="text" size="30" class="texto" value="<?php echo $dados->bairro ;?>" <?php echo $disable; ?>></td>
  </tr>
  <tr>
    <td align="left">UF<font color="#FF0000">*</font></td>
    <td align="left">
    <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
        <input type="hidden" name="txtTomadorUF" value="<?php echo $dados->uf ;?>" />
        <select name="txtTomadorUF" id="txtTomadorUF" onchange="buscaCidades(this,'divTomadorMunicipio')" <?php echo $select; ?>>
            <option value=""></option>
            <?php
                $sqlcidades=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                while(list($uf_busca)=mysql_fetch_array($sqlcidades)){
                    echo "<option value=\"$uf_busca\"";if($uf_busca == $dados->uf){ echo "selected=selected"; }echo ">$uf_busca</option>";
                }
            ?>
        </select>
    </td>
  </tr>

  <tr>
    <td align="left">
		Munic�pio<font color="#FF0000">*</font></td>
    <td align="left">
        <div  id="divTomadorMunicipio">
        	<input type="hidden" name="txtTomadorMunicipio" id="txtTomadorMunicipio" value="<?php echo $dados->municipio ;?>" />
            <select name="txtTomadorMunicipio" id="txtTomadorMunicipio" class="combo" <?php echo $select; ?>>
                <?php
                    $sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$dados->uf'");
                    while(list($nome_municipio) = mysql_fetch_array($sql_municipio)){
                        echo "<option value=\"$nome_municipio\"";if(strtolower($nome_municipio) == strtolower($dados->municipio)){ echo "selected=selected";} echo ">$nome_municipio</option>";
                    }//fim while 
                ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <td align="left">E-mail</td>
    <td align="left">
		<input name="txtTomadorEmail" type="text" size="30" class="email" value="<?php echo $dados->email ;?>"<?php echo $disable; ?>>
	</td>
  </tr>
  <tr>
  	<td colspan="8" align="right"></td>
  </tr>
</table>  
<?php   
function acesso_negado()
{
    echo "<font size='3'>Acesso Negado</font>";
}

function getFerramentas() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/novo.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("novo");></td>';
    $retorno .= '<td><img src="imagens/alterar.png" style="cursor: pointer; border:0px;" name="bt_alterar" onClick=parent.cont.noalt("alterar");></td>';
    $retorno .= '<td><img src="imagens/excluir.png" style="cursor: pointer; border:0px;" name="bt_deletar" onClick="parent.cont.excluir();"></td>';
    $retorno .= '<td><img src="imagens/imprimir.png" style="cursor: pointer; border:0px;" id="imprimir_amarelos" name="bt_imprimir_amarelos" onclick="parent.cont.imprimir();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasAlterar() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/alterar.png" style="cursor: pointer; border:0px;" name="bt_alterar" onClick=parent.cont.noalt("alterar");></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasAlterar2() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/alterar.png" style="cursor: pointer; border:0px;" name="bt_alterar" onClick=parent.cont.noalt("alterar");></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasAlterarConcluir() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/alterar.png" style="cursor: pointer; border:0px;" name="bt_alterar" onClick=parent.cont.noalt("alterar");></td>';
    $retorno .= '<td><img src="imagens/concluir.png" style="cursor: pointer; border:0px;" name="bt_concluir" onClick=parent.cont.noalt("concluir");></td>';
    $retorno .= '</tr></table>';
    return $retorno;                                                    
}

function getFerramentas2() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/novo.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("novo");></td>';
    $retorno .= '<td><img src="imagens/alterar.png" style="cursor: pointer; border:0px;" name="bt_alterar" onClick=parent.cont.noalt("alterar");></td>';
    $retorno .= '<td><img src="imagens/excluir.png" style="cursor: pointer; border:0px;" name="bt_deletar" onClick="parent.cont.excluir();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasComImportar() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/novo.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("novo");></td>';
    $retorno .= '<td><img src="imagens/importar.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.importar();></td>';
    $retorno .= '<td><img src="imagens/alterar.png" style="cursor: pointer; border:0px;" name="bt_alterar" onClick=parent.cont.noalt("alterar");></td>';
    $retorno .= '<td><img src="imagens/excluir.png" style="cursor: pointer; border:0px;" name="bt_deletar" onClick="parent.cont.excluir();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasComCopiar() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/novo.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("novo");></td>';
    $retorno .= '<td><img src="imagens/copiar.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("copiar");></td>';
    $retorno .= '<td><img src="imagens/alterar.png" style="cursor: pointer; border:0px;" name="bt_alterar" onClick=parent.cont.noalt("alterar");></td>';
    $retorno .= '<td><img src="imagens/excluir.png" style="cursor: pointer; border:0px;" name="bt_deletar" onClick="parent.cont.excluir();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasSemAlterar() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/novo.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("novo");></td>';
    $retorno .= '<td><img src="imagens/excluir.png" style="cursor: pointer; border:0px;" name="bt_deletar" onClick="parent.cont.excluir();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasExportarLote() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/exportar.png" style="cursor: pointer; border:0px;" id="bt_exportar" name="bt_exportar" onclick="parent.cont.exportar();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasImpressao() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/imprimir.png" style="cursor: pointer; border:0px;" id="bt_imprimir" name="bt_imprimir" onclick="parent.cont.imprimir();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasFaturar() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/faturar.png" style="cursor: pointer; border:0px;" id="bt_faturar" name="bt_faturar" onclick="parent.cont.faturar();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasPedido() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/novo.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("novo");></td>';
    $retorno .= '<td><img src="imagens/excluir.png" style="cursor: pointer; border:0px;" name="bt_deletar" onClick="parent.cont.excluir();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasGravar() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasPagar() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/pagar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();" alt="Pagar" /></td></tr></table>';
    return $retorno;                                                    
}

function getFerramentasImportarLote() {
    $retorno = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align="right"><tr><td width="100%">&nbsp;</td>';
    $retorno .= '<td><img src="imagens/gravar.png" style="cursor: pointer; border:0px;" name="bt_gravar" onClick="parent.cont.gravar();"></td>';
    $retorno .= '<td><img src="imagens/novo.png" style="cursor: pointer; border:0px;" name="bt_novo" onClick=parent.cont.noalt("novo");></td></tr></table>';
    return $retorno;                                                    
}
    
function getFerramentasPedido2() {
    $retorno = "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='100%'>&nbsp;</td><td><img src='imagens/visualizar.png' style='cursor: pointer; border:0px;'  name='bt_visualizar'  onClick='gera_laudo();'></td>";
    $retorno .= "<td><img src='imagens/pagamento.png' style='cursor: pointer; border:0px;' name='bt_pagamento' id='botao_pagamento' onClick='pagamento();'></td>";
    $retorno .= "<td><img src='imagens/paciente.png' style='cursor: pointer; border:0px;' name='bt_pacientes' onClick='abrepaciente();'></td>";
    $retorno .= "<td><img src='imagens/exame.png' style='cursor: pointer; border:0px;' name='bt_exames' onClick='abrecadexame();'></td>";
    $retorno .= "<td><img src='imagens/medicacao.png' style='cursor: pointer; border:0px;' name='bt_medicamentos' onClick='parent.cont.popup_medicamentos();'></td>";
    $retorno .= "<td><img src='imagens/medico.png' style='cursor: pointer; border:0px;' name='bt_medicos' onClick='abremedico();'></td>";
    $retorno .= "<td><img src='imagens/obs.png' style='cursor: pointer; border:0px;' name='bt_observacoes' onClick='parent.cont.popup_observacoes();'></td>";
    $retorno .= "<td><img src='imagens/sep.png' height='47px;'></td>";
    $retorno .= "<td><img src='imagens/gravar.png' style='cursor: pointer; border:0px;' name='bt_gravar' onClick='gravar();'></td>";
    $retorno .= "<td><img src='imagens/novo.png' style='cursor: pointer; border:0px;' name='bt_novo' onClick='novoa();'></td>";
    $retorno .= "<td><img src='imagens/alterar.png' style='cursor: pointer; border:0px;' name='bt_alterar' onClick='alterar();'></td>";
    $retorno .= "<td><img src='imagens/excluir.png' style='cursor: pointer; border:0px;' name='bt_deletar' onClick='delete_atend();'></td>";
    $retorno .= "<td><img src='imagens/imprimir.png' style='cursor: pointer; border:0px;' id='imprimir_amarelos' name='bt_imprimir_amarelos' onclick='imprimirdigitados();'></td></tr></table>";
    
    return $retorno;
}
    
    function cabecalho($js) {

        $retorno = "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
    $retorno .= "   <meta http-equiv=\"cache-control\" content=\"no-cache\">\n";
    $retorno .= "   <meta http-equiv=\"Pragma\" content=\"no-cache\">\n";

      $retorno .= " <script src=\"../js/funcoes.js\"></script>\n"; 
      $retorno .= " <script language=\"javascript\" type=\"text/javascript\" src=\"inc/$js\"></script>\n"; 

        return $retorno;
    
    }
    
/*  function getFerramentas() {
$retorno = "
                          <img src=\"img/ferramentas2.gif\" alt=\"Barra de Ferramentas\" border=\"0\" usemap=\"#Map\">
                                  <map name=\"Map\">
                          <area shape=\"rect\" coords=\"178,3,220,44\" id=\"map_excluir\" href=\"javascript:excluir();\">
                          <area shape=\"rect\" coords=\"122,3,164,44\" id=\"map_editar\" href=\"javascript:noalt('alterar');\">
                          <area shape=\"rect\" coords=\"71,3,113,44\" id=\"map_novo\" href=\"javascript:noalt('novo');\">
                          <area shape=\"rect\" coords=\"20,3,62,44\" id=\"map_gravar\" href=\"javascript:gravar();\">
                        </map>";
      return $retorno;                      
                                
    } */
    
    function getPesquisa() {
    
    $retorno = 
    "          <td valign=\"top\" width=\"50%\" style=\"border-right:1px dashed #CCCCCC;\">
                  <form name=\"pesquisa\">
                  <table width=\"98%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                     <tr>
                        <td>Pesquisar: </td>
                        <td colspan=\"6\"><input class=\"text\" type=\"text\" name=\"search\" size=\"40\" maxlength=\"50\" onKeyUp=\"procurar(this.value);\"><img src=\"../imagens/search.gif\" alt=\"Pesquisar\" border=\"0\" hspace=\"2\" onClick=\"procurar(document.forms[0].search.value,event.keyCode);\" style=\"cursor:pointer;\">
                        </td>
                     </tr>
                     <tr><td>&nbsp;</td></tr>
                     <tr>
                        <td colspan=\"6\" align=\"center\">
                           <div id=\"resultado\">
                              <!-- DADOS -->                     
                           </div>
                        </td>
                     </tr>
                  </table>
                  </form>
               </td>    
    ";
    
        return $retorno;
        
    }
    
    function getSelect($id, $name, $query, $style='width: 150px;', $extra='') {
        global $db;
        $retorno = 
"   
                           <select id=\"secao\" name=\"secao\" style=\"$style;\">
                              <option value=\"\" name=\"\" selected> </option>\n";
                              
      $db->exec_query($query);
      $rs=$db->Regs();
      $nregs=$db->NumReg();
      $keys = array_keys($rs[0]);
                              
      foreach ($rs as $linha) {
                                
                              
            
      $retorno .='                        <option value="'.$linha[$keys[0]].'">'.$linha[$keys[1]].'</option>'."\n";

      }
   
      $retorno .="                     </select>";
    
        return $retorno;
    
    }   

	function getContador($tipo='GLOBAL')
	{
		GLOBAL $db;
		$db->exec_query("SELECT * FROM NextId WHERE name='$tipo'");
		if ($db->NumReg() > 0 ){
			$rs_cnt = $db->Regs();
			$Nextid = $rs_cnt[0]['Nextid'];
			$db->exec_query("UPDATE NextId SET Nextid=($Nextid + 1) WHERE name='$tipo'");
			$Nextid ++;
			return $Nextid;
		} else {
			$rs_cnt = $db->Regs();
			$Nextid = $rs_cnt[0]['Nextid'];
			$db->exec_query("INSERT INTO (name, NextId) VALUES ('$tipo', 1)");
			return 1;			
		} 
	}
	
    function getComboContrato($id_combo='nu_contrato', $todos=false, $matriz=false, $classe='combo', $style='width: 250px;', $onchange='', $extra='', $nu_cliente='')
	{
        global $db;
		
        $retorno = "<select id=\"$id_combo\" name=\"$id_combo\" class=\"$classe\" style=\"$style;\" onchange=\"$onchange\" $extra >\n";
		if (($todos) && ($matriz)) {
			$retorno .= "<option value=\"ZZ\">Todos</option>\n";
			$retorno .= "<option value=\"XX\">Matriz</option>\n";
		} else if (($todos)) {
			$retorno .= "<option value=\"ZZ\">Todos</option>\n";
		} else if (($matriz)) {
			$retorno .= "<option value=\"XX\">Matriz</option>\n";
		} else {
			$retorno .= "<option value=\"\">Selecione</option>\n";
		}
		
		// 1. Contratos Vigentes
			$query = "SELECT c.sq_contrato, o.sq_oportunidade, o.nm_obra 
					FROM cd_contrato c, cd_oportunidade o, cd_proposta p
					WHERE o.bl_deletado = 'false' AND p.bl_deletado = 'false' AND c.bl_deletado = 'false'
						AND c.cd_proposta = p.sq_proposta AND p.cd_oportunidade = o.sq_oportunidade 
						AND c.dt_encerramento_contrato IS NULL ";
			// Verifica se selecionou algum cliente;
			if ($nu_cliente){
				$query .=" AND (o.cd_cliente=$nu_cliente) ";
			}
			// Verifica se é da Matriz ou de algum Contrato ?
			if (isset($_SESSION["matriz"])){
				if($_SESSION["matriz"]!=1){
					if (isset($_SESSION["cd_contrato"])){
						$query .=" AND (c.sq_contrato = ".$_SESSION["cd_contrato"].") ";
					} else {
						$query .=" AND (c.sq_contrato = -1) ";
					}
				}
			}
			$query .=" ORDER BY nm_obra";
			$db->exec_query($query);
			$rs=$db->Regs();
			if ($db->NumReg() > 0) {
				$retorno .= "<optgroup label=\"Contratos Vigentes\">\n";
				foreach ($rs as $linha) {
					$retorno .= "<option value=\"".trim($linha['sq_contrato'])."\">".trim($linha['nm_obra'])."</option>\n";
				}
				$retorno .= "</optgroup>\n";
			}
			
		// 2. Contratos encerrados
			$query = "SELECT c.sq_contrato, o.sq_oportunidade, o.nm_obra 
					FROM cd_contrato c, cd_oportunidade o, cd_proposta p
					WHERE o.bl_deletado = 'false' AND p.bl_deletado = 'false' AND c.bl_deletado = 'false'
						AND c.cd_proposta = p.sq_proposta AND p.cd_oportunidade = o.sq_oportunidade 
						AND c.dt_encerramento_contrato IS NOT NULL ";
			// Verifica se selecionou algum cliente;
			if ($nu_cliente){
				$query .=" AND (o.cd_cliente=$nu_cliente) ";
			}
			// Verifica se é da Matriz ou de algum Contrato ?
			if (isset($_SESSION["matriz"])){
				if($_SESSION["matriz"]!=1){
					if (isset($_SESSION["cd_contrato"])){
						$query .=" AND (c.sq_contrato = ".$_SESSION["cd_contrato"].") ";
					} else {
						$query .=" AND (c.sq_contrato = -1) ";
					}
				}
			}
			$query .=" ORDER BY nm_obra";
			$db->exec_query($query);
			$rs=$db->Regs();
			if ($db->NumReg() > 0) {
				$retorno .=  "<optgroup label=\"Contratos Encerrados\">";
				foreach ($rs as $linha) {
					$retorno .= "<option value=\"".trim($linha['sq_contrato'])."\">".trim($linha['nm_obra'])."</option>\n";
				}
				$retorno .= "</optgroup>\n";
			}
        $retorno .="</select>\n";
		
        return $retorno;
    }
	
	
    function getComboContratoLocal($id_combo='nu_contrato', $todos=false, $matriz=false, $classe='combo', $style='width: 250px;', $onchange='', $extra='')
	{
        global $db;
		
        $retorno = "<select id=\"$id_combo\" name=\"$id_combo\" class=\"$classe\" style=\"$style;\" onchange=\"$onchange\" $extra >\n";
		if (($todos) && ($matriz)) {
			$retorno .= "<option value=\"ZZ\">Todos</option>\n";
			$retorno .= "<option value=\"XX\">Matriz</option>\n";
		} else if (($todos)) {
			$retorno .= "<option value=\"ZZ\">Todos</option>\n";
		} else if (($matriz)) {
			$retorno .= "<option value=\"XX\">Matriz</option>\n";
		} else {
			$retorno .= "<option value=\"\">Selecione</option>\n";
		}
		
		// 1. Contratos Vigentes
			$query = "SELECT c.sq_contrato, o.sq_oportunidade, o.nm_obra 
					FROM cd_contrato c, cd_oportunidade o, cd_proposta p
					WHERE o.bl_deletado = 'false' AND p.bl_deletado = 'false' AND c.bl_deletado = 'false'
						AND c.cd_proposta = p.sq_proposta AND p.cd_oportunidade = o.sq_oportunidade 
						AND c.dt_encerramento_contrato IS NULL ";
			// Verifica se é da Matriz ou de algum Contrato ?
			if (isset($_SESSION["matriz"])){
				if($_SESSION["matriz"]!=1){
					if (isset($_SESSION["cd_contrato"])){
						$query .=" AND (c.sq_contrato = ".$_SESSION["cd_contrato"].") ";
					} else {
						$query .=" AND (c.sq_contrato = -1) ";
					}
				}
			}
			$query .=" ORDER BY nm_obra";
			$db->exec_query($query);
			$rs=$db->Regs();
			if ($db->NumReg() > 0) {
				$retorno .= "<optgroup label=\"Contratos Vigentes\">\n";
				foreach ($rs as $linha) {
					$retorno .= "<option value=\"".trim($linha['sq_contrato'])."\">".trim($linha['nm_obra'])."</option>\n";
				}
				$retorno .= "</optgroup>\n";
			}

		// 2. Locais de Estoque
			// Verifica se é da Matriz ou de algum Contrato ?
			if (isset($_SESSION["matriz"])){
				if($_SESSION["matriz"]==1){
					$query = "SELECT le.* FROM cd_local_estoque le WHERE le.bl_deletado = 'false' ORDER BY nm_nome";
					$db->exec_query($query);
					$rs=$db->Regs();
					if ($db->NumReg() > 0) {
						$retorno .=  "<optgroup label=\"Locais de Estoque\">";
						foreach ($rs as $linha) {
							$retorno .= "<option value=\"L".trim($linha['sq_local_estoque'])."\">".trim($linha['nm_nome'])."</option>\n";
						}
						$retorno .= "</optgroup>\n";
					}
				}
			}
			
		// 3. Contratos encerrados
			$query = "SELECT c.sq_contrato, o.sq_oportunidade, o.nm_obra 
					FROM cd_contrato c, cd_oportunidade o, cd_proposta p
					WHERE o.bl_deletado = 'false' AND p.bl_deletado = 'false' AND c.bl_deletado = 'false'
						AND c.cd_proposta = p.sq_proposta AND p.cd_oportunidade = o.sq_oportunidade 
						AND c.dt_encerramento_contrato IS NOT NULL ";
			// Verifica se é da Matriz ou de algum Contrato ?
			if (isset($_SESSION["matriz"])){
				if($_SESSION["matriz"]!=1){
					if (isset($_SESSION["cd_contrato"])){
						$query .=" AND (c.sq_contrato = ".$_SESSION["cd_contrato"].") ";
					} else {
						$query .=" AND (c.sq_contrato = -1) ";
					}
				}
			}
			$query .=" ORDER BY nm_obra";
			$db->exec_query($query);
			$rs=$db->Regs();
			if ($db->NumReg() > 0) {
				$retorno .=  "<optgroup label=\"Contratos Encerrados\">";
				foreach ($rs as $linha) {
					$retorno .= "<option value=\"".trim($linha['sq_contrato'])."\">".trim($linha['nm_obra'])."</option>\n";
				}
				$retorno .= "</optgroup>\n";
			}
        $retorno .="</select>\n";
		
        return $retorno;
    }
	
	function getCampoEmpresa($sq_empresa, $campo='nome')
	{
        global $db;
		$valor = '';
		
	    // Pegar os Dados da Empresa
        $query = "SELECT * FROM cd_empresa WHERE sq_empresa = '".$sq_empresa."'";
        $db->exec_query($query);
        if ($db->NumReg() > 0 ){
            $rs_contrato = $db->Regs();
			
			switch ($campo) {
				case "nome":
					$valor = trim($rs_contrato[0]['nm_empresa']);
				break; 
				default: // Nome
					$valor = trim($rs_contrato[0]['nm_empresa']);
				break; 
			}
        }
		return $valor;
	}
		
	function getPermissaoAcesso($arquivo, $perfil)
	{
        global $db;
		
			// 1. Verificar caminho completo;
			$query = "SELECT * FROM cd_perfil_funcionalidade_web pf, cd_funcionalidade_web f WHERE f.url_pagina = '$arquivo' AND pf.cd_perfil_web='$perfil' AND pf.cd_funcionalidade_web = f.sq_funcionalidade";
			//echo "QUERY=$query\n";
			$db->exec_query($query);
			if ($db->NumReg()>0) {
				return true;
			} else {
				// 2. Verificar caminho completo cortado (SAO);
				$arquivo = str_replace("/sao", '', $arquivo);
				$query = "SELECT * FROM cd_perfil_funcionalidade_web pf, cd_funcionalidade_web f WHERE f.url_pagina = '$arquivo' AND pf.cd_perfil_web='$perfil' AND pf.cd_funcionalidade_web = f.sq_funcionalidade";
				//echo "QUERY=$query\n"; 
				$db->exec_query($query);
				if ($db->NumReg()>0) {
					return true;
				} else {
					return false;
				}
			}
	}
	
    function getComboCliente($id_combo='nu_cliente', $todos=false, $classe='combo', $style='width: 250px;', $onchange='', $extra='')
	{
        global $db;
		
        $retorno = "<select id=\"$id_combo\" name=\"$id_combo\" class=\"$classe\" style=\"$style;\" onchange=\"$onchange\" $extra >\n";
		if (($todos)) {
			$retorno .= "<option value=\"ZZ\">Todos</option>\n";
		} else {
			$retorno .= "<option value=\"\">Selecione</option>\n";
		}
		
		// 1. Contratos Vigentes
			$query = "SELECT sq_cliente, nm_cliente FROM cd_cliente WHERE bl_deletado = 'false' ORDER BY nm_cliente";
			$db->exec_query($query);
			$rs=$db->Regs();
			if ($db->NumReg() > 0) {
				foreach ($rs as $linha) {
					$retorno .= "<option value=\"".trim($linha['sq_cliente'])."\">".trim($linha['nm_cliente'])."</option>\n";
				}
			}
			
        $retorno .="</select>\n";
		
        return $retorno;
    }
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
		<title>Lista de Ordens em produção.</title>
		<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table.css";		
			@import "css/demo_table_jui.css";
			@import "css/jquery-ui-1.8.4.custom.css";
		</style>
        <link rel="stylesheet" href="data_plugin/themes/base/jquery.ui.all.css">
	    <link rel="stylesheet" href="data_plugin/css/demos.css">
		<script src="data_plugin/js/jquery-1.8.3.js"></script>	
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script src="data_plugin/js/jquery.ui.core.js"></script>
        <script src="data_plugin/js/jquery.ui.widget.js"></script>
        <script src="data_plugin/js/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
					
			/*jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
				return ((x < y) ? -1 : ((x > y) ?  1 : 0));
			};
			
			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
				return ((x < y) ?  1 : ((x > y) ? -1 : 0));
			};
			
			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
		
		/*		$('#exampl1e').dataTable( {
					"aaSorting": [ [0,'asc'], [1,'asc'] ],
					"aoColumnDefs": [
						{ "sType": 'string-case', "aTargets": [ 2 ] }
					]
				} );
			} );
			*/
			$(document).ready(function() {
				oTable = $('#example').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
			} );

		</script>

        <script>
        $(function() {
            $( "#datepicker" ).datepicker();
			$( "#datapickerfim" ).datepicker();
        });
		</script>
	</head>
    
<?php
function data($date){
		
		$dia = substr($date,0,2);
		$mes = substr($date,3,2);
		$ano = substr($date,6,4);
		$resultado = $ano.'-'.$mes.'-'.$dia;

		return $resultado;
	}

function date_dois($date){
		
		$dia = substr($date,8,2);
		$mes = substr($date,5,2);
		$ano = substr($date,0,4);

$resultado = $dia.'/'.$mes.'/'.$ano;

return $resultado;
	}
				
# Conexão com o banco de dados
mysql_connect("localhost", "root", "");

# Selecionado o banco
mysql_select_db("sistema_psd");

	# If para filtro de busca funcionar
	if ((!empty($_GET['inicio'])) && (!empty($_GET['fim'])) ){
		$where = "data_recibo BETWEEN '". data($_GET['inicio'])."' AND '". data($_GET['fim'])."'";
	}else{
	$where = "data_recibo LIKE '%".date("Y-m")."%'";
	}

# Roda a query para trazer as OPS do sistema
 $sql="SELECT * FROM tb_recibos WHERE  ".$where." ORDER BY numero_recibo DESC";
 $result = mysql_query($sql);

?>
	
<body id="dt_example">



<form style="position: relative; top: 18px; font-family: verdana; font-weight: bold; color: rgb(85, 85, 85); font-size: 11px; left: 282px;" method="get" action="">
	<label>De:  <input type="text" name="inicio" id="datepicker" /></label>
	<label>Até: <input type="text" name="fim" id="datapickerfim" /></label>   
	<label><input type="submit" style="background: none repeat scroll 0% 0% transparent; font-weight: bold; font-family: arial; color: black; border: 1px solid grey; border-radius: 5px 5px 5px 5px;" value="Filtrar" name="ok"></label>
</form>


	<div id="container">
		<div id="demo">
        
<?php 
	# Cria Header da tabela
	echo "                   
         <table cellpadding='0' cellspacing='0' border='0' class='display' id='example'>   
    <thead>
		<tr>
			<th>OP</th>
			<th>ID Externo</th>
			<th>Nome</th>
			<th>Status</th>
			<th>Local</th>
			<th>Gerado</th>
		</tr>
	</thead><tbody>";
	
 # While para rodar os campos na tabela usando fetch array
 while($row = mysql_fetch_array($result))
 {
?>
<?php    
	# Chama os campos que deseja
	echo "
		
		<tr class='gradeX'>
			<td> " . $row['numero_recibo'] . " </td>
			<td> " . $row['idExterno'] . "</td>
			<td> " . utf8_encode($row['nome_cadastro']). "</td>
			<td> " . $row['flagLibera'] . "</td>
			<td> " . $row['localRec'] . "</td>
			<td> " . date_dois($row['data_recibo']) . "</td>
		</tr>";
		
 }
echo "</tbody>

</table>";?>			
			</div>
			<style type="text/css">
				@import "../examples_support/syntax/css/shCore.css";
			</style>
			</div>
		</div>
</body>
</html>
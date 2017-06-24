<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<!-- JQuery v1.8.2 -->
	<script src="{{URL}}/scripts/jquery-1.8.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="{{URL}}/scripts/ckeditor/contents.css">
	<style type="text/css" media="screen">
		body{
			box-shadow: 2px 5px 15px 2px #999;
			font-size: 1.5em;
		}
		.section{
			padding: 20px;
		}
	</style>
	<style type="text/css" media="all">
		*{
			line-height: 1.6;
		}
		.section{
			/*margin:10px;*/
		}
		body{
			<?php if(!isset($oriental)) $oriental = 'potrait'; ?>
			@if($oriental=='potrait')
			width:996px;
			min-height: 1304px;
			@else
			height:996px;
			min-width: 1404px;
			@endif
			margin: auto;
			margin-top:20px;
			margin-bottom:20px;
			font-family:arial,helvetica,sans-serif;
		}
		table.table_list{
			border-collapse: collapse;
			width: 100%;
			margin: auto;
			border-spacing: 0;
			margin-left: 1px;
		}
		
		table.table_list tr th,table.table_list tr td{
			border: 1px solid #777;
			padding: 4px;
			font-size: 23px;
			font-family:arial,helvetica,sans-serif;
		}
		table.table_list tr td{
			text-align: left;
		}
		table.table_list tr th.center,table.table_list tr td.center{
			text-align: center;
		}
		table.table_list tr th{
			font-size: 25px;
			background: #e1e2e3;
			color:#000;
		}
		table.table_list tr th.money,table.table_list tr td.money{
			text-align: right;
			font-weight: bolder;
		}
		table.table_list tr.sum td{
			text-align: right;
			font-weight: bold;
			font-size: 25px;
		}
		table.table_list tr.sum td.money{
			letter-spacing: -1px;
		}
	</style>
</head>
<body>
	<div class="section">
		<?php echo isset($content) ? $content : '' ?>	
	</div>
</body>
	<script>
		$("table.table_list tr td.money").each(function(){
			value = $(this).text().replace(',','')
			while(value.indexOf(',')>0){
				value = value.replace(',','')
			}
			value = parseInt(value);
			value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$(this).text(value);
		})
	</script>
</html>
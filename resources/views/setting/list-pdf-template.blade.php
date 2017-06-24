<div class="row-fluid">
	<div class="span12">
		<div class="widget widget-2 widget-white">
			<div class="widget-head">
				<span class="heading">
					<span id="module_name"></span>
				</span>
			</div>
			<div class="widget-body center" id="pdf_content">
				<div  style="margin-bottom:15px;">
					<strong>Mẫu PDF:</strong> <select name="" id="select_mau" onchange="pdf_detail(this)">
						@foreach($pdf_templates as $pdf)
							<option data-id="{{$pdf['id']}}" data-name="{{$pdf['name']}}">{{$pdf['name']}}</option>
						@endforeach
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<strong>Kiểu in:</strong>
					<select id="select_oriental">
						<option value="potrait" data-width="996">Kiểu đứng</option>
						<option value="landscape" data-width="1404">Kiểu ngang</option>
					</select>
					<input type="hidden" value="" id="id_template">
				</div>
				<textarea id="edit_pdf"></textarea>
				<br/>
				<div class="center">
					<button class="btn btn-primary" onclick="save_template()">Lưu</button>
					<button class="btn btn-primary" onclick="print_template()">In Thử</button>
					<img src="images/load.gif" alt="Printing" id="loading" style="display:none;">
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css" media="screen">
	#cke_edit_pdf{
		margin : auto;
	}
</style>
<script>	
	var token = '{{ csrf_token() }}';
</script>
<script src="{{URL}}/scripts/ckeditor/ckeditor.js"></script>
<script>
	$(function(){
		CKEDITOR.basePath = '{{URL}}/scripts/ckeditor/';
		CKEDITOR.config.width = '996px';
		CKEDITOR.config.height = '450px';
		CKEDITOR.replace('edit_pdf', {
			"filebrowserImageUploadUrl": "scripts/ckeditor/plugins/imgupload/imgupload.php"
		});

		$("#select_oriental").on("change",function(){
			$("#cke_edit_pdf").width($(this).find("option:selected").attr('data-width'));
		})

		$("#select_mau").change();
	})
	

	function pdf_detail(obj){
		save_template();
		$("#module_name").text($(obj).find('option:selected').attr('data-name'));
		$("#id_template").val($(obj).find('option:selected').attr('data-id'));
		$.ajax({
			url : '{{URL}}/settings/get-template/'+$("#id_template").val(),
			type : 'GET',
			success: function(data){
				console.log(data);
				CKEDITOR.instances['edit_pdf'].setData(data.template)
				$("#select_oriental option").each(function(){

					if(this.value == data.oriental){
						$("#select_oriental option").attr("selected",false)
						$(this).attr('selected',true);
					}
				})
				if(data.oriental == 'landscape'){
					$("#cke_edit_pdf").width("1404px");
				}else{
					$("#cke_edit_pdf").width("996px");
				}
			}
		});
	}

	function save_template(){
		var template = CKEDITOR.instances['edit_pdf'].getData();
		var id = $("#id_template").val()?$("#id_template").val():0;
		var oriental = $("#select_oriental").val()?$("#select_oriental").val():0;
		if(id){
			$.ajax({
				url : '{{URL}}/settings/save-template',
				type : 'POST',
				data : {
					'id' : id,
					'template' : template,
					'oriental' : oriental
				},
				success: function(data){
					if(data.status == 'success'){
						toastr['success']('Save success');
					}else{
						toastr['error'](data.message);
					}
				}
			});
		}
	}

	function print_template(){
		$("#loading").css('display','inline-block');
		event.preventDefault();
		var id = $("#id_template").val()?$("#id_template").val():0;
		var name = $("#module_name").text()?$("#module_name").text():'';
		$.ajax({
			url : '{{URL}}/exports/print-test',
			type : 'POST',
			data:{
				'id' : id,
				'name' : name
			},
			success: function(data){
				if(data.status == 'success'){
					window.open(data.link,'_blank');
				}else{
					toastr['error'](data.message);
				}
				$("#loading").css('display','none');

			}
		});
	}
</script>

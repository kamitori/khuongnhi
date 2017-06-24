<div class="row">
	<div class="span6 quarter1">
		<div class="widget widget-2 widget-white">
			<div class="widget-head">
				<span class="heading">
					Tùy chỉnh khác
				</span>
			</div>
			<div class="widget-body">
				<div class="dd" id="list_menu">
					<ol class="dd-list">
						<li class="dd-item dd3-item">
							<div class="dd3-content" onclick="other_settings_list('oum-settings','đơn vị','oum')">
								Đơn vị
							</div>
						</li>
						<li class="dd-item dd3-item">
							<div class="dd3-content" onclick="other_settings_list('producttype-settings','loại sản phẩm','producttype')">
								Loại sản phẩm
							</div>
						</li>
						<li class="dd-item dd3-item">
							<div class="dd3-content" onclick="other_settings_list('companytype-settings','loại hình công ty','companytype')">
								Loại hình công ty
							</div>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="span6 quarter3">
		<div class="widget widget-2 widget-white">
			<div class="widget-head">
				<span class="heading">
					Danh sách <span id="module_name"></span>
					<a href="#" id="module_popup"><i class="fa fa-plus"></i></a>
				</span>
			</div>
			<div class="widget-body" id="other_content">
			</div>
		</div>
	</div>
</div>

<script>
	function other_settings_list(setting_function_name, name,module){
		$("#module_name").text(name);
		$("#module_popup").attr("onclick","create_"+module+"()")
		$.ajax({
			url: "<?php echo URL; ?>/settings/" + setting_function_name,
			type:"GET",
			// timeout: 15000,
			success: function(html){
				$("div#other_content").html(html);
			}
		});
	}
</script>
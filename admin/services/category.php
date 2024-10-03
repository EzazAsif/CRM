<br>
<h5 class="">Service Category</h5>
<hr>
<div class="row">
	<div class="container-fluid">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h5 class="card-title">List of Service Category</h5>
				<div class="card-tools">
					<button class="btn btn-flat btn-primary btn-sm" type="button" id="new_data"><span class="fa fa-plus"></span> New Category</button>
				</div>
			</div>
			<div class="card-body">
				<div class="container-fluid">
					<table class="table table-striped table-bordered">
						<colgroup>
							<col width="5%">
							<col width="30%">
							<col width="45%">
							<col width="20%">
						</colgroup>
						<thead>
							<tr>
								<th>#</th>
								<th>Category</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function load_data(){
		start_loader();
		if ( $.fn.DataTable.isDataTable('table') ) {
			$('table').DataTable().destroy();
			$('table tbody').html('')
		}
		$.ajax({
			url:_base_url_+"classes/Master.php?f=load_service_category",
			dataType: "json",
			error: err=>{
				console.log(err)
				alert_toast("An error occured",'error');
				end_loader();
			},
			success:function (resp){
				// resp = JSON.parse(resp)
				if(!!resp.status){
					if(resp.data.length > 0){
						let data = (resp.data);
						var i = 1;
						Object.keys(data).map((k)=>{
						let tr = $("<tr></tr>");
							tr.append('<td class="text-center">'+(i++)+'</td>')
							tr.append('<td><b>'+data[k].category+'</b></td>')
							tr.append('<td><span class="truncate">'+data[k].description+'</span></td>')
							tr.append('<td class="text-center"><div class="btn-group">'+
	                   ' <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">'+
	                    	'Action'+
	                      '<span class="sr-only">Toggle Dropdown</span>'+
	                    '</button>'+
	                    '<div class="dropdown-menu" role="menu" style="">'+
	                      '<a class="dropdown-item text-primary edit_data" data-id="'+(data[k].id)+'" href="javascript:void(0)"><span class="fa fa-edit"></span> Edit</a>'+
	                      '<div class="dropdown-divider"></div>'+
	                      '<a class="dropdown-item text-danger delete_data" data-id="'+(data[k].id)+'" href="javascript:void(0)"><span class="fa fa-trash text-fanger"></span> Delete</a>'+
	                   ' </div>'+
	                  '</div></td>')
							$('table tbody').append(tr)
						})
					}else{
							$('table tbody').html('')
					}
					end_loader();
				}else{
					alert_toast("An error occured",'error');
					end_loader();
				}
			},
			complete:function(){
				data_func()
				$('table').dataTable();
				end_loader();
			}
		})
	}

	function data_func(){
		$('.edit_data').click(function(){
			uni_modal('<span class="fa fa-edit text-primary"></span> Edit Service Category',_base_url_+'admin/services/manage_category.php?id='+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
			_conf('Are you sure to delete this data?','delete_data',[$(this).attr('data-id')]);
		})
	}
	function delete_data($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_service_category",
			method:'POST',
			data:{id:$id},
			dataType:'json',
			error:err=>{
				console.log(err);
				alert_toast("An error occured","error");
				end_loader();
			},
			success:function(resp){
				if(!!resp.status && resp.status == 'success'){
					alert_toast(" Data successfully deleted.","success");
					$('.modal').modal('hide');
				end_loader();
					load_data()
				}
			}
		})
	}
	$(document).ready(function(){
		load_data()
		$('#new_data').click(function(){
			uni_modal('<span class="fa fa-plus"></span> Create New Service Category',_base_url_+'admin/services/manage_category.php')
		})
	})
</script>
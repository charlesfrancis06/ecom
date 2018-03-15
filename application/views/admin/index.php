<div class="container">
	<h3>Product Lists</h3>
	<div class="alert alert-success" style="display: none;">
		
	</div>
	<div class="panel panel-info">
		  <div class="panel-heading">
	<button id="btnAdd" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
	<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
	<br>
			</div>
			 <div class="panel-body">
	<table id="myTable" class="table table-striped table-responsive" style="margin-top: 20px;">
		<thead>
			<tr>
				<td>ID</td>
				<td>Product Name</td>
				<td>Product Code</td>
				<td>Product Stock</td>
				<td width="20%">Product Image</td>
				<td>Product Price</td>
				<td>Action</td>
			</tr>
		</thead>
		<tbody id="showdata">
			
		</tbody>
	</table>
</div>
</div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        	<form id="myForm" action="" method="post" class="form-horizontal">
        		<input type="hidden" name="product_id" value="0">

        		<div class="form-group">
        			<label for="name" class="label-control col-md-4">Product Name</label>
        			<div class="col-md-8">
        				<input type="text" name="product_name" id="product_name" class="form-control">
        			</div>
        		</div>

        		<div class="form-group">
        			<label for="code" class="label-control col-md-4">Product Code</label>
        			<div class="col-md-8">
        				<input type="text" class="form-control" id="product_code" name="product_code">
        			</div>
        		</div>

        		<div class="form-group">
        			<label for="stock" class="label-control col-md-4">Product Stock</label>
        			<div class="col-md-8">
        				<input type="text" name="product_stock" id="product_stock" class="form-control">
        			</div>
        		</div>

        		<div class="form-group">
        			<label for="image" class="label-control col-md-4">Product Image</label>
        			<div class="col-md-8">
        				<input type="txt" name="product_image" id="product_image" class="form-control">
        			</div>
        		</div>

        		<div class="form-group">
        			<label for="price" class="label-control col-md-4">Product Price</label>
        			<div class="col-md-8">
        				<input type="text" name="product_price" id="product_price" class="form-control">
        			</div>
        		</div>

        		 	

        	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnSave" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirm Delete</h4>
      </div>
      <div class="modal-body">
        	Do you want to delete this record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnDelete" class="btn btn-danger">Delete</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$(function(){
		showAllProduct();

		//Add New
		$('#btnAdd').click(function(){
			$('#myModal').modal('show');
			$('#myModal').find('.modal-title').text('Add New Product');
			$('#myForm').attr('action', '<?php echo base_url() ?>admin/addProduct');
		});


		$('#btnSave').click(function(){
			var url = $('#myForm').attr('action');
			var data = $('#myForm').serialize();
			//validate form
			var product_name = $('input[name=product_name]');
			var product_code = $('input[name=product_code]');
			var product_stock = $('input[name=product_stock]');
			var product_image = $('input[name=product_image]');
			var product_price = $('input[name=product_price]');
			
			var result = '';
			if(product_name.val()==''){
				product_name.parent().parent().addClass('has-error');
			}else{
				product_name.parent().parent().removeClass('has-error');
				result +='1';
			}

			if(product_code.val()==''){
				product_code.parent().parent().addClass('has-error');
			}else{
				product_code.parent().parent().removeClass('has-error');
				result +='2';
			}

			if(product_stock.val()==''){
				product_stock.parent().parent().addClass('has-error');
			}else{
				product_stock.parent().parent().removeClass('has-error');
				result +='3';
			}

			if(product_image.val()==''){
				product_image.parent().parent().addClass('has-error');
			}else{
				product_image.parent().parent().removeClass('has-error');
				result +='4';
			}

			if(product_price.val()==''){
				product_price.parent().parent().addClass('has-error');
			}else{
				product_price.parent().parent().removeClass('has-error');
				result +='5';
			}

			if(result=='12345'){
				$.ajax({
					type: 'ajax',
					method: 'post',
					url: url,
					data: data,
					async: false,
					dataType: 'json',
					success: function(response){
						if(response.success){
							$('#myModal').modal('hide');
							$('#myForm')[0].reset();
							if(response.type=='add'){
								var type = 'added'
							}else if(response.type=='update'){
								var type ="updated"
							}
							$('.alert-success').html('Product '+type+' successfully').fadeIn().delay(4000).fadeOut('slow');
							showAllProduct();
						}else{
							alert('Error');
						}
					},
					error: function(){
						alert('Could not add data');
					}
				});
			}
		});

		//edit
		$('#showdata').on('click', '.item-edit', function(){
			var product_id = $(this).attr('data');
			$('#myModal').modal('show');
			$('#myModal').find('.modal-title').text('Edit Product');
			$('#myForm').attr('action', '<?php echo base_url() ?>admin/updateProduct');
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url() ?>admin/editProduct',
				data: {product_id: product_id},
				async: false,
				dataType: 'json',
				success: function(data){

					$('input[name=product_id]').val(data.product_id);
					$('input[name=product_name]').val(data.product_name);
					$('input[name=product_code]').val(data.product_code);
					$('input[name=product_stock]').val(data.product_stock);
					$('input[name=product_image]').val(data.product_image);
					$('input[name=product_price]').val(data.product_price);
				},
				error: function(){
					alert('Could not Edit Data');
				}
			});
		});

		//delete- 
		$('#showdata').on('click', '.item-delete', function(){
			var product_id = $(this).attr('data');
			$('#deleteModal').modal('show');
			//prevent previous handler - unbind()
			$('#btnDelete').unbind().click(function(){
				$.ajax({
					type: 'ajax',
					method: 'get',
					async: false,
					url: '<?php echo base_url() ?>admin/deleteProduct',
					data:{product_id:product_id},
					dataType: 'json',
					success: function(response){
						if(response.success){
							$('#deleteModal').modal('hide');
							$('.alert-success').html('Product Deleted successfully').fadeIn().delay(4000).fadeOut('slow');
							showAllEmployee();
						}else{
							alert('Error');
						}
					},
					error: function(){
						alert('Error deleting');
					}
				});
			});
		});



		//function
		function showAllProduct(){
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>admin/showAllProduct',
				async: false,
				dataType: 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
						html +='<tr>'+
									'<td>'+data[i].product_id+'</td>'+
									'<td>'+data[i].product_name+'</td>'+
									'<td>'+data[i].product_code+'</td>'+
									'<td>'+data[i].product_stock+'</td>'+
									'<td class="thead"><img height="20%" width="80%" class="img-thumbnail" src="<?php echo base_url();?>/image/'+data[i].product_image+'"></img></td>'+
									'<td>'+data[i].product_price+'</td>'+
									
									'<td>'+
										'<a href="javascript:;" class="btn btn-info item-edit" data="'+data[i].product_id+'"><span class="glyphicon glyphicon-pencil"></a>'+
										'<a href="javascript:;" class="btn btn-danger item-delete" data="'+data[i].product_id+'"><span class="glyphicon glyphicon-remove"></span></a>'+
									'</td>'+
							    '</tr>';
					}
					$('#showdata').html(html);
				},
				error: function(){
					alert('Could not get Data from Database');
				}
			});
		}
	});


function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>

 
  
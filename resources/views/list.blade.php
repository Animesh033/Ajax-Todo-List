<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    {{-- Font Icons --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    {{-- Jquery ui css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />

    <title>Ajax Todo List Project</title>
  </head>
  <body>

    <div class="container">
    	<br>
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="card" id="items">
					<div class="card-header">
						Ajax Todo List 
						<!-- Button trigger modal -->
						<a href="" class="float-right" id="addNew" data-toggle="modal" data-target="#exampleModal" ><i class="fas fa-plus-circle"></i></a>
					</div>
					<div class="card-body">

						<ul class="list-group list-group-flush">
							@foreach ($items as $item)
							<li class="list-group-item ourItem" data-toggle="modal" data-target="#exampleModal" >{{ $item->item }}
								<input type="hidden" id="itemId" value="{{ $item->id }}">
							</li>	
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-2">
				<input type="text" name="" id="searchItem" class="form-control" placeholder="Search">
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalTitle">Add New Item</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	@csrf {{-- It can be placed anywhere --}}
		      	<input type="hidden" id="id">
		        <input class="form-control" type="text" name="item" placeholder="Default input" id="addItem">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-warning" id="delete"  data-dismiss="modal" style="display: none;">Delete</button>
		        <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display: none;">Save changes</button>
		        <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal">Add</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script>
	$(document).ready(function() {
		$(document).on('click', '.ourItem', function(event) {
			event.preventDefault();
			var text = $(this).text();
			text = $.trim(text);
			var id = $(this).find('#itemId').val();
			$('#modalTitle').text('Edit Item');
			$('#addItem').val(text);
			$('#delete').show(400);
			$('#saveChanges').show(400);
			$('#addButton').hide(400);
			$('#id').val(id);
			console.log(text);
		});

		$(document).on('click', '#addNew', function(event) {
			event.preventDefault();
			var text = $(this).text();
			$('#modalTitle').text('Add New Item');
			$('#addItem').val("");
			$('#delete').hide(400);
			$('#saveChanges').hide(400);
			$('#addButton').show(400);
			console.log(text);
		});

		$('#addButton').click(function(event) {
			var input = $('#addItem').val();
			// alert(input);
			if (input == ''){
				alert('Please enter the item');
			}else{
				$.post(
					'list', 
					{'input': input, '_token' : $('input[name =_token]').val() 
				}, 
				function(data) {
					console.log(data);
					$('#items').load(location.href + ' #items');
				});
			}
		});

		$('#delete').click(function(event) {
			var id = $('#id').val();
			console.log(id);
			$.post(
				'delete', 
				{
					'id' : id, '_token' : $('input[name =_token]').val()
				}, 
				function(data) {
					$('#items').load(location.href + ' #items');
					console.log(data);
				});
		});

		$('#saveChanges').click(function(event) {
			var id = $('#id').val();
			var value = $('#addItem').val();
			console.log(id);
			$.post(
				'update', 
				{
					'id' : id,
					'value' : value, '_token' : $('input[name =_token]').val() 
				}, 
				function(data) {
					$('#items').load(location.href + ' #items');
					console.log(data);
				});
		});

		$( function() {

		    $( "#searchItem" ).autocomplete({
		      	source: '{{ url('search') }}' /*{{-- asset('search') --}}*/
		    });
		  } );
		
	});
    </script>
  </body>
</html>
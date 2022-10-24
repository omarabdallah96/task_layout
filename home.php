<?php
session_start();
//return to login if not logged in
if (!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
	header('location:index.php');
}



?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		#contacts {
			font-family: Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		#contacts td,
		#contacts th {
			border: 1px solid #ddd;
			padding: 8px;
		}

		#contacts tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		#contacts tr:hover {
			background-color: #ddd;
		}

		#contacts th {
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #04AA6D;
			color: white;
		}
	</style>

</head>

<body>
	<div class="container">
		<br>
		<a href="logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>

		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adddatamodal">
			+
		</button>
		<input type="text" name="" id="search" class="float-right" placeholder="Search By Name" />

		<br>
		<br>
		<div class="row">



			<table id="contacts">

				<thead>
					<th>First name</th>
					<th>Last name</th>
					<th>Phone number</th>
					<th>Birthdate</th>
					<th>City</th>
					<th>Action</th>


				</thead>
				<tbody id="contact_data">

				</tbody>
			</table>




		</div>
	</div>
	</div>
	<!-- Button trigger modal -->


	<!-- Modal -->
	<div class="modal fade" id="adddatamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="text" class="form-control mb-3" placeholder="name" id="first_name">
					<input type="text" class="form-control mb-3" placeholder="last name" id="last_name">

					<input type="text" class="form-control mb-3" placeholder="phone" id="phone">

					<input type="text" class="form-control mb-3" placeholder="City" max="7" id="city">
					<input type="date" class="form-control mb-3" placeholder="Department" id="dateofbirth">

					<input type="number" class="form-control mb-3" placeholder="Department" id="department_id">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" id="addContact" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>

<script>
	let filterby = null;
	let searchdata = null;
	$(document).ready(function() {
		ContactData()
	})

	function ContactData(filter, search) {


		$.ajax({
			url: "contactdata.php?getdata",
			dataType: 'JSON',
			data: {
				filterby: filter,
				search: search,
				page: 1
			},

			success: function(result) {


				// return;

				if (result.success) {
					html = ''

					data = result.data

					data.forEach(element => {

						html += `
					<tr>
					<td class="col-md-4 col-md-offset-"> 
					${element.first_name}
					
					</td>
					<td class="col-md-4 col-md-offset-"> 
					${element.last_name ??'--'}
					
					</td>
					<td class="col-md-4 col-md-offset-"> 
					${element.phone ??'--'}
					
					</td>
					<td class="col-md-4 col-md-offset-"> 
					${element.birthdate ??'--'}
					
					</td>
					<td class="col-md-4 col-md-offset-"> 	
					${element.city ??'--'}
					
					</td>

					<td class="col-md-4 col-md-offset-"> 

					<button onclick="DeleteContact(${element.id})">
					X
					</button>
					
					</td>
					
					</tr>`
					});
					$('#contact_data').empty();
					$('#contact_data').append(html);
				} else {
					console.log(result)
					NoDataFound()

				}

			},
			error: function(error) {
				console.log(error)
			}
		});
	}

	$('#search').on('keyup', function() {
		searchdata = $('#search').val();


		ContactData(filterby, searchdata)

	})

	function NoDataFound() {
		$('#contact_data').empty();
		html = '';

		html += `<tr>
					<td class=""> 
					--
					
					
					</td><td class=""> 
					--
					
					
					</td><td class=""> 
					--
					
					
					</td><td class=""> 
					--
					
					
					</td><td class=""> 
					--
					
					
					</td>
				
					</tr>`
		$('#contact_data').append(html)

	}

	$("#addContact").on('click', (function(e) {
		contact_data = {
			first_name: $('#first_name').val(),
			last_name: $('#last_name').val(),
			phone: $('#phone').val(),
			city: $('#city').val(),
			department_id: $('#department_id').val(),
			dateofbirth:$('#dateofbirth').val()



		}

		// return console.log(contact_data)
		$.ajax({
			url: "contactdata.php",
			type: "post",
			data: {
				addData: true,
				contact_data: contact_data
			},

			success: function(data) {
				console.log(data)
				$(':input').val('');
				window.location.reload()

				ContactData()
			},
			error: function(e) {
				$("#err").html(e).fadeIn();
			}
		});
	}));

	function DeleteContact(id) {
		$.ajax({
			url: "contactdata.php",
			type: "post",
			dataType: 'json',
			data: {
				deleteData: true,
				id: id
			},

			success: function(data) {

				console.log(data.success)
				if (data.success == true) {

					ContactData();



				} else {
					console.log("error")
				}
			},
			error: function(e) {
				$("#err").html(e).fadeIn();
			}
		});
	}
</script>
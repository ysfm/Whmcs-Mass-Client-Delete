<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WHMCS Mass Remove</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">


    <style type="text/css">
      .card {
          padding: 5px;
      }
      .card.title {
          background: gray;
          color: white;
      }
    </style>


  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://jsistem.com/logo.png" alt=""  height="72">
        <h2>MassClient Remove</h2>
        <p class="lead">This script use Whmcs remote api</p>
      </div>

       <form id="getlist">
         <div class="row">
          <div class="col">
          <div class="form-group">
            <label for="username">Username or Identifier</label>
            <input type="text" class="form-control" id="username" aria-describedby="login_help" placeholder="Identifier" name="auth">
            <small id="login_help" class="form-text text-muted">Setup -> Staff Management -> Manage API Credentials</small>
          </div>
          </div>
          <div class="col">
          <div class="form-group">
            <label for="secret">Password</label>
            <input type="text" class="form-control" id="secret" placeholder="secret" name="secret">
          </div>
          </div>

          <div class="col">
          <div class="form-group">
            <label for="limit">Limit</label>
            <input type="number" class="form-control" id="limit"  value="100" name="limit">
          </div>
          </div>
          <div class="col-12">
          <div class="form-group">
            <label for="Search">Search</label>
            <input type="text" class="form-control" id="Search" placeholder="Name/E-Mail" name="search">
          </div>
          </div>

          <div class="col-12">
          <div class="form-group">
            <label for="api">API URL</label>
            <input type="text" class="form-control" id="api" placeholder="https://www.localhost.com/includes/api.php" name="api">
          </div>
          </div>

        </div>
          <button type="submit" class="btn btn-primary">Get List</button>
        </form>
    
      <div id="mydata" style="margin-top: 50px;">




      </div>



      <footer class="my-5 pt-5 text-muted text-center text-small">
       <a href="#"> <p class="mb-1">&copy; 2019 Company JSistem</p></a>

      </footer>
    </div>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script type='text/javascript'>
      $("#getlist").submit(function(e) {

          e.preventDefault(); // avoid to execute the actual submit of the form.
          $('#mydata').empty();
          var form = $(this);
          $.ajax({
                 type: "POST",
                 url: "list.php",
                 dataType: 'json',
                 data: form.serialize(), // serializes the form's elements.
                 success: function(data)
                 {

                    if (data.result=='success') {
                      $('#mydata').html('<div id="myvalues"></div>');
                      var my_array = data.clients.client.sort(function(a, b) {
                          return parseFloat(a.id) - parseFloat(b.id);
                      });

                          var eklenecek = "";
                          eklenecek +='<div style="width: 100%; height: 50px;"><div style="float:left;"><button type="button" class="btn btn-info" onclick="select_all();">Select All</button></div> <div style="float:right;"><button type="button" class="btn btn-danger" onclick="delete_selected();">Delete Selected</button></div></div>';

                          eklenecek +='<div class="card title"><div class="row"><div class="col-1"> #ID </div>';
                          eklenecek +='<div class="col-3">Name</div>';
                          eklenecek +='<div class="col-2">E-mail</div>';
                          eklenecek +='<div class="col-2">Company</div>';
                          eklenecek +='<div class="col-2">Created Date</div>';
                          eklenecek +='<div class="col-2">Status</div></div></div>';
                          $('#myvalues').append(eklenecek);


                      $.each( data.clients.client, function( key, value ) {
                          var eklenecek = "";
                          eklenecek +='<div class="card" data_id="'+value.id+'"><div class="row"><div class="col-1"><input type="checkbox" name="deleted[]" value="'+value.id+'"> '+value.id+'</div>';
                          eklenecek +='<div class="col-3">'+value.firstname+' '+value.lastname+'</div>';
                          eklenecek +='<div class="col-2">'+value.email+'</div>';
                          eklenecek +='<div class="col-2">'+value.companyname+'</div>';
                          eklenecek +='<div class="col-2">'+value.datecreated+'</div>';
                          eklenecek +='<div class="col-2">'+value.status+'</div></div></div>';
                          $('#myvalues').append(eklenecek);
                      });

                    } else {
                      $('#mydata').html('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
                    }
                    console.log(data); 

                 }
               });


      });


      function select_all () {
        $('input[type=checkbox]').prop('checked', true);
      }


      function delete_selected () {
        var ids = [];

        $('input[type=checkbox]').each(function( index ) {
          if (this.checked)
            ids.push($(this).val());
        });

        for (var i = 0; i < ids.length; i++) {
            $.ajax({
                   type: "POST",
                   url: "delete.php",
                   dataType: 'json',
                   async: false,
                   data: {id: ids[i], auth: $('#username').val(), secret: $('#secret').val(), api: $('#api').val()}, // serializes the form's elements.
                   success: function(data)
                   {
                    if (data.result=='success') {
                      $('.card[data_id="'+data.clientid+'"]').html('<div class="alert alert-success" role="alert">'+data.clientid+' User Deleted!</div>');
                    } else {
                      $('#myvalues').find('.card:first').before('<div class="alert alert-warning" role="alert">'+data.message+' User Deleted!</div>');
                    }

                   }
                 });
          }
      }






    </script>



  </body>
</html>

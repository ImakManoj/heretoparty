<!-- carcreate.blade.php -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Mongodb</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  </head>
  <body>
    <div class="container">
      <center><h2>Mongo </h2></center><br/>
      <div class="container">
    </div>
      <form method="post" action="{{route('car.store')}}">
        @csrf
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Carcompany">Car Company:</label>
            <input type="text" class="form-control" name="carcompany">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Model">Model:</label>
            <input type="text" class="form-control" name="model">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Price">Price:</label>
            <input type="text" class="form-control" name="price">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <center><button type="submit" class="btn btn-success">Submit</button></center>
          </div>
        </div>
      </form>
   </div>
  </body>
</html>
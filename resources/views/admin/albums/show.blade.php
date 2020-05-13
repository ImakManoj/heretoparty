<?php 
use App\Http\Controllers\Controller;
?>

@extends('layouts.admin')

@section('content')
<?php use App\Http\Controllers\Admin\UsersController; ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View Category Data</h4>
                        <div class="sctn1">
                            <h4></h4>
                            <figure>
                                <?php
                                $picture = Controller::getFilePath($results->image, 'albums');
                                    if($picture) { ?>
                                        <img src="{{ $picture }}" width="40px">
                                        <?php
                                    }else{ ?>
                                        <img src="{{asset('public/uploads/images.jpg')}}" width="40px">
                                    <?php
                                    }
                                ?>
                            </figure>
                            <h4>{{ @$results->name }} </h4>
                        </div>
                        <div class="sctn2">
                            <p> <label>Title  :</label>
                                <span>
                                    {{ @$results->name }}
                                </span>
                            </p>
                            <p> <label>Subtitle  :</label>
                                <span>
                                    {{ @$results->subtitle }}
                                </span>
                            </p>
                        </div>
                        <div class="sctn2">
                            <p> <label>Description :</label>
                                <span>
                                    {{ @$results->description }}
                                </span>
                            </p>
                            <p> <label>Status :</label>
                                <span>
                                    {{ @$results->status == '1'?"Active":"Inactive" }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Category Songs list</h4>
                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Subtitle</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $counter = 1; ?>
                            @foreach($songs as $item)

                                <tr>
                                    <td>{{ @$counter }}</td>
                                    <td>
                                        <?php
                                        $picture = Controller::getFilePath($item->image, 'songPic');
                                            if($picture) { ?>
                                                <img src="{{ $picture }}" width="40px">
                                                <?php
                                            }else{ ?>
                                                <img src="{{asset('public/uploads/images.jpg')}}" width="40px">
                                            <?php
                                            }
                                        ?>
                                    </td>
<td>{{ strlen(@$item->name) > 20 ? substr(@$item->name, 0, 20)."..." : @$item->name  }}</td>
<td>{{ strlen(@$item->subtitle) > 20 ? substr(@$item->subtitle, 0, 20)."..." : @$item->subtitle  }}</td>
<td>{{ strlen(@$item->description) > 20 ? substr(@$item->description, 0, 20)."..." : @$item->description  }}</td>
<td><a href = "#" onclick="showDetails('<?php echo $item->id; ?>', '<?php echo $item->name; ?>', '<?php echo $item->subtitle; ?>', '<?php echo $item->description; ?>');" data-toggle="modal" data-target="#myModal">View</a></td>
                                </tr>
                                <?php $counter++; ?>
                             @endforeach
                               </tbody>
                            </table>
                        </div>
                    </div>
                            
                          
                </div>
            </div>
        </div> <!-- end row -->
    </div>
</div>
  
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>Music Details</center></h4>
        </div>
        <div class="modal-body">
            <div class="popup_section">
                <p> <label>Name  :</label>
                    <span id="name"></span>
                </p>
                <p> <label>Subtitle  :</label>
                    <span id="subtitle"></span>
                </p>
                <p> <label>Description  :</label>
                    <span id="description"></span>
                </p>
                
            </div>
          <center><p><span id="name"></span></p></center>
          <br>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal -->

  <script>
    function showDetails(id, name, subtitle, description) {
        console.log(name, subtitle);
        $('#id').val(id);
        $('#name').html(name);
        $('#subtitle').html(subtitle);
        $('#description').html(description);
    }
  </script>



@endsection

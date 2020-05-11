@extends('UserDashboard.Userslayouts.apps')
@section('title','Files')
@section('content')

            <div class="dashboard-content-wrap"> 
                <div class="dashboard-content-inner"> 

                <div class="white-box-shadow">
                    <div class="row-wrap">
                        <div class="d-title d-flex align-items-center justify-content-between">
                            <h3>Files</h3>
                            <div class="search-wrap">
                            <form>
                                <input type="text" class="form-control" placeholder="Search" >
                                 <button class="search-btn" type="button"><i class="fa fa-search"></i></button>
                            </form>
                            </div>
                       </div>
                       <div class="table-wrap files-table"> 
                         <table class="table table-bordered table-striped">
                              <thead class="primary-theme"> 
                                  <tr>
                                  <th>Sr. No.</th> 
                                  <th>Name</th>
                                  <th>Service name</th>
                                  <th>Document</th>
                                  <th>Action</th> 
                                  </tr>
                              </thead>  
                              <tbody>
                                  <tr>
                                  <td>1.</td>
                                  <td>Brochure 1</td>
                                  <td>Flooring</td>
                                  <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                  <td>
                                     <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                     <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                  </td>
                                  </tr>

                                  <tr>
                                    <td>2.</td>
                                    <td>Brochure 2</td>
                                    <td>Flooring</td>
                                    <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                    <td>
                                       <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                       <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    </td>
                                  </tr>


                                    <tr>
                                        <td>3.</td>
                                        <td>Brochure 3</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>4.</td>
                                        <td>Brochure 4</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>5.</td>
                                        <td>Brochure 5</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>6.</td>
                                        <td>Brochure 6</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>7.</td>
                                        <td>Brochure 7</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>8.</td>
                                        <td>Brochure 8</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>9.</td>
                                        <td>Brochure 9</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>10.</td>
                                        <td>Brochure 10</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>11.</td>
                                        <td>Brochure 11</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>12.</td>
                                        <td>Brochure 12</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>13.</td>
                                        <td>Brochure 13</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>14.</td>
                                        <td>Brochure 14</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>

                                      <tr>
                                        <td>15.</td>
                                        <td>Brochure 15</td>
                                        <td>Flooring</td>
                                        <td><i class="fa fa-file-pdf-o" aria-hidden="true"></i></td>
                                        <td>
                                           <a href="#" class="icon-btn view-icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                           <a href="#" class="icon-btn edit-icon-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                      </tr>



                              </tbody>
                              </table>
                       </div>
                   </div>
                </div> 
                </div>   <!-- dashboard-content-inn  -->
             </div>   

            <!-- dashboard-content-wrap  -->

    
@endsection
  
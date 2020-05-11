@extends('UserDashboard.Userslayouts.apps')
@section('title','Events')
@section('content')


 <div class="dashboard-content-wrap">
                <div class="dashboard-content-inner">
                    <div class="profile-box-wrap white-box-shadow">
                        <div class="row-wrap row-mb-50">
                            <div class="d-title">
                                <h3>My Events</h3>
                            </div>  
                            <div class="calanar-wraper">
                                <img src="{{asset('heretoparty')}}/images/calandar.jpg" alt="calandar.jpg" />
                            </div>
                       </div>

                       <div class="row-wrap">
                        <div class="d-title">
                            <h3>Recent Events</h3>
                        </div>  
                        <div class="table-wrap "> 
                            <table class="table table-bordered table-striped event-table">
                                 <thead class="primary-theme"> 
                                     <tr>
                                        <th>Service Image</th> 
                                        <th>Service Name</th>
                                        <th>Vendor Name</th>
                                        <th>Starting Date</th>
                                        <th>Price</th> 
                                     </tr>
                                 </thead>  
                                 <tbody>
                                     <tr>
                                         <td><figure class="table-fig" style="background-image: url('../images/table-fig-1.jpg');"></figure></td>
                                        <td>Make up</td>
                                        <td>Sarah</td> 
                                        <td>
                                            <span class="btn btn-default table-btn">02 January</span>
                                        </td>
                                        <td>
                                            $ 200 
                                        </td>
                                     </tr> 

                                     <tr>
                                        <td><figure class="table-fig" style="background-image: url('../images/table-fig-1.jpg');"></figure></td>
                                       <td>Make up</td>
                                       <td>Sarah</td> 
                                       <td>
                                           <span class="btn btn-default table-btn">10 January</span>
                                       </td>
                                       <td>
                                           $ 200 
                                       </td>
                                    </tr> 


                                    <tr>
                                        <td><figure class="table-fig" style="background-image: url('../images/table-fig-1.jpg');"></figure></td>
                                       <td>Make up</td>
                                       <td>Sarah</td> 
                                       <td>
                                           <span class="btn btn-default table-btn">20 January</span>
                                       </td>
                                       <td>
                                           $ 200 
                                       </td>
                                    </tr> 

                                    <tr>
                                        <td><figure class="table-fig" style="background-image: url('../images/table-fig-1.jpg');"></figure></td>
                                       <td>Make up</td>
                                       <td>Sarah</td> 
                                       <td>
                                           <span class="btn btn-default table-btn">20 January</span>
                                       </td>
                                       <td>
                                           $ 200 
                                       </td>
                                    </tr> 

                                 </tbody>
                                 </table>
                          </div>
                   </div>
                    </div>
                </div>
                <!-- dashboard-content-inn  -->
            </div> 



@endsection
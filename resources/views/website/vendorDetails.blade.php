@extends('website.layouts.app')
@section('title','Search')
@section('content')


        <section class="banner" style="background-image: url('{{asset($vendors->vendor_coverphoto)}}');">
            <section class="container">
                <article>
                    <h1>#{{$vendors->category_name}}</h1>
                </article>
                <div class="vendor-detail-box">
                    <figure style="background-image: url('{{asset($vendors->vendor_logo)}}');"></figure>
                    <div class="vendor-detail-box-info">
                        <button class="whislist"><i class="fa fa-heart-o"></i></button>
                        <h6>{{$vendors->vendor_name}}</h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            40 Reviews
                        </div>
                        <div class="website">
                            <a href="{{$vendors->vendor_website}}" target="_blank">{{$vendors->vendor_website}}</a>
                        </div>
                        <div class="price">
                            <p>Pricing starts from: <strong>${{$vendors->price}}</strong></p>
                        </div>
                        <div class="location">
                            {{$vendors->vendor_address}}
                        </div>
                        <div class="share-post">
                            <ul>
                                <li><a href="facebook.com" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="twitter.com" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="instagram.com" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="{{route('CreateQuote',[$vendors->vid])}}" class="btn btn-sm btn-default">Request Quote</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>


        </section>

        <section class="vendor-tag-list">
            <div class="container">
                <ul> 
                    @if(!$tag=='' && !empty($tag))
                        @foreach($tag as $t)
                         <li><a href="#">#{{$t->tag_name}}</a></li>
                        @endforeach
                    @endif
                   <!--  <li><a href="#">#Indian</a></li>
                    <li><a href="#">#Pakistani</a></li>
                    <li><a href="#">#Nikkah</a></li>
                    <li><a href="#">#Bengali</a></li>
                    <li><a href="#">#Tamli</a></li>
                    <li><a href="#">#Kenyan</a></li>
                    <li><a href="#">#Fijian </a></li>
                    <li><a href="#">#Punjabi </a></li>
                    <li><a href="#">#South-Indian </a></li>
                    <li><a href="#">More </a></li> -->
                </ul>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <h2 class="heading ">DJ</h2>
                <blockquote class="text-center">
                    <p> {{$vendors->description}}</p>
                </blockquote>


                <div class="vendor-service-list">
                    <div class="vendor-service-list-item">
                        <figure style="background-image: url('{{asset('heretoparty')}}/images/vendor-service-img-1.jpg');">
                            <figcaption>
                                <img src="{{asset('heretoparty')}}/images/dj-icon.png">
                            </figcaption>
                        </figure>
                        <h5>HIGH SOUND DJs</h5>
                    </div>
                    <div class="vendor-service-list-item">
                        <figure style="background-image: url('{{asset('heretoparty')}}/images/vendor-service-img-2.jpg');">
                            <figcaption>
                                <img src="{{asset('heretoparty')}}/images/maracas-icon.png">
                            </figcaption>
                        </figure>
                        <h5>orchestra</h5>
                    </div>
                    <div class="vendor-service-list-item">
                        <figure style="background-image: url('{{asset('heretoparty')}}/images/vendor-service-img-3.jpg');">
                            <figcaption>
                                <img src="{{asset('heretoparty')}}/images/spotlight-icon.png">
                            </figcaption>
                        </figure>
                        <h5>LIGHTING</h5>
                    </div>
                    <div class="vendor-service-list-item">
                        <figure style="background-image: url('{{asset('heretoparty')}}/images/vendor-service-img-4.jpg');">
                            <figcaption>
                                <img src="{{asset('heretoparty')}}/images/dance-icon.png">
                            </figcaption>
                        </figure>
                        <h5>DANCERS</h5>
                    </div>
                    <div class="vendor-service-list-item">
                        <figure style="background-image: url('{{asset('heretoparty')}}/images/vendor-service-img-5.jpg');">
                            <figcaption>
                                <img src="{{asset('heretoparty')}}/images/floor-icon.png">
                            </figcaption>
                        </figure>
                        <h5>FLOORING</h5>
                    </div>
                </div>


                <div class="vendor-description">
                    <div class="row">
                        <div class="col-lg-9">
                            <h2 class="heading text-left">Description</h2>
                            <div class="price-time">
                                <ul>
                                    <li>Price: $100</li>
                                    <li>Time duration: 5 Hours</li>
                                </ul>
                            </div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took. It is a long established fact that a reader will be distracted by the
                                readable content of a page when looking at its layout. The point of using Lorem Ipsum is
                                that it has a more-or-less normal distribution of letters, as opposed to using 'Content
                                here, content here', making it look like readable English. Many desktop publishing
                                packages and web page editors now use Lorem Ipsum as their default model text, and a
                                search for 'lorem ipsum' will uncover many web sites still in their infancy.</p>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                                architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas
                                sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
                                voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit
                                amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
                                labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis
                                nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
                                consequatur?</p>
                        </div>
                        <div class="col-lg-3">
                            <div class="availability-calendar">
                                <img src="{{asset('heretoparty')}}/images/dummy-calendar-img.jpg">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section brochures-section" style="background-image: url('{{asset('heretoparty')}}/images/vendor-gallery-bg.jpg');">
            <div class="container">

                <h2 class="heading">Brochures</h2>

                <div class="brochures-slider">
                    <div class="item">
                        <a href="#">
                            <i class="fa fa-file-pdf-o"></i>
                            Brochures Name
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <i class="fa fa-file-pdf-o"></i>
                            Brochures Name
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <i class="fa fa-file-pdf-o"></i>
                            Brochures Name
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <i class="fa fa-file-pdf-o"></i>
                            Brochures Name
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <i class="fa fa-file-pdf-o"></i>
                            Brochures Name
                        </a>
                    </div>
                </div>

                <hr>

                <h2 class="heading">Gallery</h2>
                <div class="gallery-slider">
                    @if(!$Gallery->isEmpty())
                    @foreach($Gallery as $g)
                    <div class="item">
                        <figure style="background-image: url('{{asset($g->images)}}');"></figure>
                    </div>
                    @endforeach
                    @endif
                   


            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="vendor-video">
                    
                       
                              <iframe style="width: 100%;height: 500px"  src="{{$vendors->video}}" frameborder="0" allowfullscreen></iframe>
                      
                 
                </div>

                <div class="rating-review-section">
                    <h2 class="heading text-left">Rating & Reviews </h2>

                    <img src="{{asset('heretoparty')}}/images/dummy-review-img.jpg">
                </div>
            </div>
        </section>


@endsection	
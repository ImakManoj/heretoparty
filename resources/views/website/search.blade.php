@extends('website.layouts.app')
@section('title','Search')
@section('content')


    <section class="banner inner-banner" style="background-image: url('{{asset('Heretoparty')}}/images/search-result-banner-img.jpg');">
      <section class="container">
        <article>
          <h1>Heretoparty</h1>
        </article>
      </section>
    </section> 

    <section class="section search-result-section">
      <article class="container">
        <article class="search-result-form">
          <form onsubmit="return false">
            <article class="form-group">
              <select class="form-control">
                <option>Services</option>
                @foreach($category as $c)
                <option value="{{$c->id}}">{{$c->category_name}}</option>
                @endforeach
              </select>
            </article>
            <article class="form-group">
              <select class="form-control">
                <option>Location</option>
                @foreach($city as $cityes)
                  <option value="{{$cityes->id}}">{{$cityes->city_name}}</option>
                @endforeach
              </select>
            </article>
            <article class="form-group">
              <select class="form-control">
                <option>Distance</option>
              <?php for($i=1;$i<=10; $i++){ $j=$i*10; ?>
                <option value="$j">{{$j}} KM</option>
           <?php   } ?>
              </select>
            </article>
            <article class="form-group range-slider">
              <input type="text" class="js-range-slider" value="" />
            </article>
            <article class="form-group rating-slider">
              <button type="button"><i class="fa fa-star-o"></i></button>
              <button type="button"><i class="fa fa-star-o"></i></button>
              <button type="button"><i class="fa fa-star-o"></i></button>
              <button type="button"><i class="fa fa-star-o"></i></button>
              <button type="button"><i class="fa fa-star-o"></i></button>
            </article>
          </form>
        </article>

        <article class="search-map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13004082.928417291!2d-104.65713107818928!3d37.275578278180674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sin!4v1584702138200!5m2!1sen!2sin"
            frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </article>

        <section class="search-result">
          <aside class="search-filter-sidebar">
            <h2>Tag</h2>
            <form>
              <ul>
              	@foreach($tag as $t)
                <li class="form-group checkbox-group">
                  <label>
                    <input type="checkbox" value="{{$t->id}}">
                    <span class="custom-checkbox"></span>
                    {{$t->tag_name}}
                  </label>
                </li>
                @endforeach
             
              </ul>
            </form>
          </aside>

          <section class="search-result-list">
            <aside class="top-filter-bar">
              <h5>Total: 30 results found for Caterers category</h5>
              <form>
                <article class="form-group">
                  <label>Sort By</label>
                  <select class="form-control">
                    <option>Recently Added</option>
                    <option>List item 1</option>
                    <option>List item 2</option>
                  </select>
                </article>
              </form>
            </aside>

            @foreach($vendors as $vend)
            <article class="search-result-list-item">
              <form class="selectable-check">
                <div class="form-group checkbox-group">
                  <label>
                    <input type="checkbox" name="type" value="{{$vend->vendorId}}">
                    <span class="custom-checkbox"></span>
                  </label>
                </div>
              </form>

              <button class="whislist"><i class="fa fa-heart-o"></i></button>

              <a href="{{route('vendorDetails',[$vend->vendorId])}}"><figure style="background-image: url('{{$vend->vendor_coverphoto}}');">
                <figcaption>{{$vend->category_name}}</figcaption>
              </figure></a>

              <div class="content">
               <a href="{{route('vendorDetails',[$vend->vendorId])}}"> <h6>{{$vend->first_name }} {{$vend->last_name }}</h6></a> 
                <div class="rating">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  40 Reviews
                </div>

                <div class="price">
                  ${{$vend->price }}
                </div>

                <div class="location">
                  {{$vend->vendor_address }}
                </div>

                <div class="taglist">
                  <a href="#">Menu 1</a>
                  <a href="#">Menu 2</a>
                  <a href="#">Waiters</a>
                  <a href="#">Delivery</a>
                  <a href="#">In House</a>
                </div>

                <div class="description">
                  <p>{{$vend->description }}</p>
                </div>

              </div>

            </article>
            @endforeach

             <button type="button" id="ApplyQuotes" class="btn btn-sm btn-default" style="margin-top: 1em;float: right;">Requesting Quotes</button>
          </section>

        </section>

      </article>
    </section>

<script>
    $(document).ready(function() {
        $("#ApplyQuotes").click(function(){
            var favorite = [];
            $.each($("input[name='type']:checked"), function(){
                favorite.push($(this).val());
            });
            //alert("My favourite sports are: " + favorite.join(", "));

            window.location.href="{{route('CreateQuote')}}/"+favorite.join(",")

        });
    });
</script>
@endsection
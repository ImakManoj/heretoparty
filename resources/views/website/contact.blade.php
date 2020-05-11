@extends('website.layouts.app')
@section('title','Contact')
@section('content')


<!-- Start Contact -->

  <section class="section">
            <article class="container">
                <aside class="contact-section">
                    <article class="contact-section-left-elem">
                        <h2>Contact Info</h2>
                        <ul>
                            <li>
                                <a href="tel:18002332742"> <i class="fa fa-phone"></i> 1 (800) 233-2742</a>
                            </li>
                            <li>
                                <a href="mailto:Info@Heretoparty.com"> <i class="fa fa-envelope"></i> Info@Heretoparty.com</a>
                            </li>
                            <li><i class="fa fa-map-marker"></i> #123 Street california,<br> USA
                            </li>
                        </ul>
                    </article>
                    <article class="contact-section-right-elem">
                        <h2 class="heading">Get In Touch</h2>
                        <form>
                            <aside class="row">
                                <article class="form-group col-sm-6">
                                    <input type="text" class="form-control" placeholder="Name">
                                </article>
                                <article class="form-group col-sm-6">
                                    <input type="text" class="form-control" placeholder="Business Name">
                                </article>
                                <article class="form-group col-sm-6">
                                    <input type="text" class="form-control" placeholder="Email">
                                </article>
                                <article class="form-group col-sm-6">
                                    <input type="text" class="form-control" placeholder="Phone">
                                </article>
                                <article class="form-group col-sm-6">
                                    <input type="text" class="form-control" placeholder="Website URL">
                                </article>
                                <article class="form-group col-sm-6">
                                    <select class="form-control">
                                        <option>Category</option>
                                        <option>Item List 1</option>
                                        <option>Item List 2</option>
                                    </select>
                                </article>
                                <article class="form-group col-sm-12">
                                    <textarea class="form-control" placeholder="Message"></textarea>
                                </article>
                            </aside>
                            <article class="text-center">
                                <input type="submit" class="btn btn-default" value="Submit">
                            </article>
                        </form>
                    </article>
                </aside>
            </article>
        </section>

        <section class="map-area">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13004082.928417291!2d-104.65713107818928!3d37.275578278180674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sin!4v1584451558758!5m2!1sen!2sin"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </section>

<!-- End  -->

@endsection
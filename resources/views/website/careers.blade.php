@extends('website.layouts.app')
@section('title','Careers')
@section('content')


<!-- Start Careers Html -->
	   <section class="banner inner-banner" style="background-image: url('images/career-banner-img.jpg');">
            <section class="container">
                <article>
                    <h1>Career</h1>
                </article>
            </section>
        </section>

        <section class="section career-section">
            <article class="container">
                <figure>
                    <img src="images/career-img.jpg" alt="career">
                </figure>
                <aside>
                    <h5>Lorem ipsum dolor sit amet</h5>
                    <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and
                        demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot
                        foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail
                        in their duty through weakness of will, which is the same as saying through shrinking from toil
                        and pain. These cases are perfectly simple and easy to distinguish. </p>

                    <h5>Aliquip ex ea commodo consequat </h5>

                    <ul class="group-border-list">
                        <li>
                            <p>Lorem ipsum dolor </p>
                            <a href="#" class="btn btn-sm btn-transparent">Apply Now</a>
                        </li>
                        <li>
                            <p>Lorem ipsum dolor </p>
                            <a href="#" class="btn btn-sm  btn-transparent">Apply Now</a>
                        </li>
                        <li>
                            <p>Lorem ipsum dolor </p>
                            <a href="#" class="btn btn-sm  btn-transparent">Apply Now</a>
                        </li>
                    </ul>

                </aside>
            </article>
        </section>

        <section class="section apply-job-section" style="background-image: url('images/apply-job-bg.jpg');">
            <article class="container">
                <h2 class="heading">Apply Job</h2>
                <form>
                    <aside class="row">
                        <article class="form-group col-sm-6">
                            <input type="text" class="form-control" placeholder="Name">
                        </article>
                        <article class="form-group col-sm-6">
                            <input type="text" class="form-control" placeholder="Email">
                        </article>
                        <article class="form-group col-sm-6">
                            <select class="form-control">
                                <option>Position</option>
                                <option>Item List 1</option>
                                <option>Item List 2</option>
                            </select>
                        </article>
                        <article class="form-group col-sm-6">
                            <input type="text" class="form-control" placeholder="Phone">
                        </article>
                        <article class="form-group col-sm-12">
                            <textarea class="form-control" placeholder="Message"></textarea>
                        </article>
                        <article class="form-group col-sm-12 custom-file-group">
                            <label for="resumeFile">Attach Resume</label>
                            <input type="file" id="resumeFile">
                        </article>

                    </aside>
                    <article class="text-center">
                        <input type="submit" class="btn btn-default" value="Submit">
                    </article>
                </form>
            </article>
        </section>

<!-- End  -->



@endsection
@extends ('layouts.master-landing')


@section ('content')


<main class="page-contact">

    <section class="contact-section">
        <div class="max-width padding">
            <div class="row align-items-center">
                <div class="col-12 col-lg-4 col-md-6 mb-5">
                    <div class="contact-group">
                        <b>Jojo Gumino</b>

                        <ul>
                            <li>Address: Address Here</li>
                            <li>Phone: +639 1234567</li>
                            <li>Mobile: +639 1234567</li>
                            <li>Email: jojo@agrabahadventures.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-md-6 mb-5">
                    <div class="contact-group">
                        <b>Joselito</b>

                        <ul>
                            <li>Address: Address Here</li>
                            <li>Phone: +639 1234567</li>
                            <li>Mobile: +639 1234567</li>
                            <li>Email: jun@agrabahadventures.com</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="max-width form">
                <h1 class="page-title text-center">GET IN TOUCH WITH US</h1>
                <form action="{{ route('post_mail') }}" method="post">
                    @csrf()
                    <div class="row">
                        <div class="col-12">
                            <input type="text" name="full_name" placeholder="Full Name">
                        </div>
                        <div class="col-12">
                            <input type="text" name="contact_number" placeholder="Contact Number">
                        </div>
                        <div class="col-12">
                            <input type="text" name="email_address" placeholder="Email Address">
                        </div>
                        <div class="col-12">
                            <textarea name="your_message" id="" cols="30" rows="10" placeholder="Message"></textarea>
                            <input type="submit" value="Let's Talk" class="text-center" readonly>
                        </div>
                    </div>
                </form>

                @if(session('success'))
                    <div class="message alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

        </div>
    </section>

</main>


@stop
@section ('scripts')

@endsection

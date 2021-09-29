@extends ('layouts.master-landing')


@section ('content')


<main class="page-about">

    <section class="height-100 about-section">
        <div class="max-width">
            <div class="row align-items-center">
                <div class="col-12 col-lg-4">
                    <h1 class="page-title">Agrabah Wharf</h1>
                    <div class="content">
                        <p>Agrabah Wharf is a platform created specifically for on spot trading and large volume trading that allows the farmers and fisherfolks to get direct access to market.</p>
                        <p>This platform also allows trading facility to manage all incoming and outgoing inventory in the area which automate its reporting capability.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <img src="{{ asset('images/landing/featured-2.jpg') }}" class="img-fluid mb-5" alt="about">
                </div>
            </div>
        </div>
    </section>

</main>


@stop
@section ('scripts')

@endsection
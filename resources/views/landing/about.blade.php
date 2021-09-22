@extends ('layouts.master-landing')


@section ('content')


<main class="page-about">

    <section class="height-100 about-section">
        <div class="max-width">
            <div class="row align-items-center">
                <div class="col-12 col-lg-4">
                    <h1 class="page-title">Agrabah Finance</h1>
                    <div class="content">
                        <p>With the Finance platform lending institution’s KYC processed is streamlined since borrowers are already pre-filling out the form online and uploading necessary requirements for the loan product.</p>
                        <p>On the farmer side they can now apply for loan at the convenience of their homes and receive the loan disbursement through digital banking which eliminates the long back and forth travel for farmers just to apply for loan.</p>
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
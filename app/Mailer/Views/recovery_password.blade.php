@extends('layouts.base')

@section('content')

<div class="container m-10">

    <div class="row">

        <p>We received a request to reset your password for your Budget Control account. To set a new password and regain access to your account, please follow the steps below:</p>
        <p>Click on the following <a href="{{$link}}">link</a> to reset your password:</p>
        <a href="{{$link}}" target="_blank"
                class="mt-5 mb-5 bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                Reset tour password
            </a>
    </div>
    <div class="row mt-5">
        
        <p>Best regards,</p>
        <p>The Budget Control Team</p>

    </div>

</div>

@endsection

@extends('layouts.footer')
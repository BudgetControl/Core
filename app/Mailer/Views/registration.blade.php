@extends('layouts.base')

@section('content')


<div class="container m-10">

        <div class="row">

            <p>Hello {{$name}},</p>
            <p>Thank you for registering with Budget Control, your home budget management solution. We're thrilled to
                have you on board and help you effectively manage your household finances.</p>
            <br />
            <p>To complete your registration and activate your email address, please follow the steps below:</p>
            <p>Click on the following <a href="{{$confirm_link}}">link</a> to activate your email address:</p>
            <br />
            <a href="{{$confirm_link}}" target="_blank"
                class="mt-5 mb-5 bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                Confirm Email
            </a>
        </div>
        <div class="row mt-5">
            <p>Remember that Budget Control offers a range of helpful features, including:</p>
            <ul class="list-disc">
                <li>Recording your daily expenses and income.</li>
                <li>Viewing detailed charts and reports to track your finances.</li>
                <li>Setting personalized savings goals.</li>
                <li>Receiving reminders for payment deadlines and monthly budgets.</li>
            </ul>
            <br />
            <p>We wish you an exceptional experience with Budget Control and success in achieving your financial goals.
            </p>
            <br />
            <p>Thank you again for choosing Budget Control!</p>
            <p>The Budget Control Team</p>
        </div>
        <div class="row">
            <p class="text-small">This link will work for 2 hours or until you reset your password.<br /><br />Lorem
                Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                standard dummy text.<br /><br /><strong>Best Regards,</strong><br /><strong>Unlayer Team </strong></p>

        </div>
    </div>

@endsection

@extends('layouts.footer')

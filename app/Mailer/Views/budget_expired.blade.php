@extends('layouts.base')

@section('content')

<style>
    .bw-warning {
        background-color: #fbbf24;
    }

    .bw-critical {
        background-color: #c70042;
    }
</style>

<div class="container m-10">

    <div class="row">

        <p>Hello {{$user_name}},</p>
        <p>We wanted to bring to your attention that one of your budgets has recently expired. It's an essential part of financial planning to ensure that your budget remains up-to-date to meet your financial goals effectively.</p>

        <div class="row">
            <div class="relative pt-1" @click="edit(budget.id)">
                <div class="flex mb-2 items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-emerald-600 bg-emerald-200">
                            {{ budget_name }}
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold inline-block text-blueGray-400 ml-10">
                            {{ difference }}{{ currency }} /
                        </span>

                        <span class="text-xs font-semibold inline-block text-emerald-600">
                            {{ percentage }}%
                        </span>
                    </div>
                </div>
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-emerald-200">
                    <div style="width:{{ percentage }}%" class="shadow-none flex flex-col bw-{{className}} text-center whitespace-nowrap text-white justify-center bg-emerald-500 bw-70">
                    </div>
                </div>
            </div>
        </div>

        <p>To continue benefiting from our budgeting features and stay on top of your financial game, we recommend reviewing and updating your budget at your earliest convenience.</p>
        <br />
        <p>Updating your budget ensures that you have the most accurate insights into your finances, helping you make informed decisions and stay on track toward your financial objectives.</p>
        <br />
        <p>If you have any questions or need assistance, feel free to reach out to our support team at [Your Support Email or Contact Information]. We're here to help you make the most of your financial journey.</p>
        <br />
        <p>Best regards,</p>
        <p>The Budget Control Team</p>

    </div>

</div>

</div>

@endsection

@extends('layouts.footer')
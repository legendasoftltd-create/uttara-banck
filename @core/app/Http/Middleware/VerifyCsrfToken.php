<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    protected $except = [
        '/price-plan-paytm-ipn',
        '/price-plan-payfast-ipn',
        '/price-plan-cashfree-ipn',
        '/price-plan-cinetpay-ipn',
        '/price-plan-paytabs-ipn',
        '/price-plan-iyzipay-ipn',
        '/price-plan-awdpay-ipn',

        '/event-paytm-ipn',
        '/pevent-payfast-ipn',
        '/event-cashfree-ipn',
        '/event-cinetpay-ipn',
        '/event-paytabs-ipn',
        '/event-iyzipay-ipn',
        '/event-awdpay-ipn',

        '/donation-paytm-ipn',
        '/donation-payfast-ipn',
        '/donation-cashfree-ipn',
        '/donation-cinetpay-ipn',
        '/donation-paytabs-ipn',
        '/donation-iyzipay-ipn',
        '/donation-awdpay-ipn',

        '/product-paytm-ipn',
        '/product-payfast-ipn',
        '/product-cashfree-ipn',
        '/product-cinetpay-ipn',
        '/product-paytabs-ipn',
        '/product-iyzipay-ipn',
        '/product-awdpay-ipn',

        '/appointment-paytm-ipn',
        '/appointment-payfast-ipn',
        '/appointment-cashfree-ipn',
        '/appointment-cinetpay-ipn',
        '/appointment-paytabs-ipn',
        '/appointment-iyzipay-ipn',
        '/appointment-awdpay-ipn',

        '/course-paytm-ipn',
        '/course-payfast-ipn',
        '/course-cashfree-ipn',
        '/course-cinetpay-ipn',
        '/course-paytabs-ipn',
        '/course-iyzipay-ipn',
        '/course-awdpay-ipn',

        '/job-paytm-ipn',
        '/job-payfast-ipn',
        '/job-cashfree-ipn',
        '/job-cinetpay-ipn',
        '/job-paytabs-ipn',
        '/job-iyzipay-ipn',
        '/job-awdpay-ipn',

    ];
}

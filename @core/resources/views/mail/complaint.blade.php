<!doctype html>
<html lang="en">
@php
    $default_lang = get_default_language();
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{get_static_option('site_'.$default_lang.'_title').' '. __('Mail')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            font-family: 'Open Sans', sans-serif;
        }
        .mail-container {
            max-width: 650px;
            margin: 0 auto;
            text-align: center;
            background-color: #f2f2f2;
            padding: 40px 0;
        }
        .inner-wrap {
            background-color: #fff;
            margin: 40px;
            padding: 30px 20px;
            text-align: left;
            box-shadow: 0 0 20px 0 rgba(0,0,0,0.01);
        }
        .inner-wrap p {
            font-size: 16px;
            line-height: 26px;
            color: #656565;
            margin: 0;
            margin-bottom: 20px;
        }
        table {
            margin: 0 auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table tr:nth-child(even){background-color: #f2f2f2;}

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #111d5c;
            color: white;
        }
        .logo-wrapper img{
            max-width: 200px;
        }
    </style>
</head>
<body>

<div class="mail-container">
    <div class="logo-wrapper">
        <a href="{{url('/')}}">
            {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
        </a>
    </div>
    <div class="inner-wrap">
        <p>{{__('Hello,')}} <br>{{__('A new complaint has been submitted from the website of').' '. get_static_option('site_'.get_default_language().'_title')}}</p>
        <table>
            <tr><th>{{__('Field')}}</th><th>{{__('Value')}}</th></tr>
            <tr><td>{{__('Concerned Division')}}</td><td>{{$complaint->concerned_division}}</td></tr>
            <tr><td>{{__('Concerned Branch')}}</td><td>{{$complaint->concerned_branch}}</td></tr>
            <tr><td>{{__('Full Name')}}</td><td>{{$complaint->full_name}}</td></tr>
            <tr><td>{{__('Address')}}</td><td>{{$complaint->address}}</td></tr>
            <tr><td>{{__('Mobile/Phone')}}</td><td>{{$complaint->mobile}}</td></tr>
            <tr><td>{{__('Email')}}</td><td>{{$complaint->email}}</td></tr>
            <tr><td>{{__('Has Account with Uttara Bank?')}}</td><td>{{$complaint->has_account ? __('Yes') : __('No')}}</td></tr>
            <tr><td>{{__('Nature of Complain')}}</td><td>{{$complaint->nature_of_complain}}</td></tr>
            <tr><td>{{__('Amount Involved')}}</td><td>{{$complaint->amount_involved}}</td></tr>
            <tr><td>{{__('Details of Complaint')}}</td><td>{{$complaint->details}}</td></tr>
            <tr><td>{{__('What they would like us to do')}}</td><td>{{$complaint->suggestion}}</td></tr>
        </table>
    </div>
    <footer>
        {!! get_footer_copyright_text() !!}
    </footer>
</div>

</body>
</html>

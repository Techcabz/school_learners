@extends('layouts.index')
@section('content')
    <br>
    <br>
    <br>
    <br>
    <div class="card">
        <a href="{{ asset('files/excel/test.xlsx') }}" download>Download Excel File</a>

    </div>
    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('files/excel/test.xlsx')) }}"
        width="100%" height="600px" frameborder="0">
    </iframe>
@endsection

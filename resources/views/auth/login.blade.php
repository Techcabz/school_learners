@extends('layouts.index')

@section('content')
    <div class="wrapper auth-section" style="margin-top: 5rem;">
        <div class="container-fluid mt-5">
            <div class="card o-hidden transparent border-0 my-5"
                style="background: inherit !important; margin-top: 10px !important">
                <div class="card-body p-0">
                    <div class="row p-0 mb-3">
                        <div class="col-2-lg col-md-4 col-sm-12"></div>
                        <div class="col-6-lg col-md-4 col-sm-12">
                            <div class="d-flex justify-content-center">
                                <livewire:auth.custom-login />
                            </div>
                        </div>
                        <div class="col-2-lg col-md-4 col-sm-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

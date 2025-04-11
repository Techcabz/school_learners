@extends('layouts.index')

@section('content')
    <div class="wrapper auth-section mt-5">
        <div class="container-fluid d-flex justify-content-center " >
            <div class="card o-hidden transparent border-0 my-5 "
                style="background: inherit !important;">
                <div class="card-body" style="max-width: 35rem; ">
                    <livewire:auth.custom-registration />
                            
                </div>
            </div>
        </div>
       
    </div>
@endsection

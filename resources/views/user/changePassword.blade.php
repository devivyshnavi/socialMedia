@extends('layouts.app')

<head>
    <style>
        input.parsley-success {
            color: #468847;
            background-color: #DFF0D8;
            border: 1px solid #D6E9C6;
        }

        input.parsley-error {
            color: #B94A48;
            background-color: #F2DEDE;
            border: 1px solid #EED3D7;
        }

        .parsley-errors-list {
            margin: 2px 0 3px;
            padding: 0;
            list-style-type: none;
            font-size: 0.9em;
            line-height: 0.9em;
            opacity: 0;
            color: #B94A48;

            transition: all .3s ease-in;
            -o-transition: all .3s ease-in;
            -moz-transition: all .3s ease-in;
            -webkit-transition: all .3s ease-in;
        }

        .parsley-errors-list.filled {
            opacity: 1;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://parsleyjs.org/dist/parsley.min.js"></script>
</head>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(Session::has('successMsg'))
                <div class="alert alert-info">{{Session::get('successMsg')}}</div>
                @endif
                @if(Session::has('errorMsg'))
                <div class="alert alert-danger">{{Session::get('errorMsg')}}</div>
                @endif
                <div class="card-header">Change password</div>

                <div class="card-body">
                    <form method="POST" action="/updatepassword/{{$data->id}}" id="passwordForm" data-parsely-validate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="oldpassword" class="col-md-4 col-form-label text-md-end">Old password</label>

                            <div class="col-md-6">
                                <input id="oldpassword" type="password" class="form-control @error('oldpassword') is-invalid @enderror" data-parsley-trigger="keyup" required name="oldpassword" autofocus>

                                @error('oldpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('oldpassword')}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="newpassword" class="col-md-4 col-form-label text-md-end">new password</label>

                            <div class="col-md-6">
                                <input id="newpassword" type="password" class="form-control @error('newpassword') is-invalid @enderror" data-parsley-minlength="8" data-parsley-trigger="keyup" required name="newpassword" autofocus>

                                @error('newpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('newpassword')}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="confirmpassword" class="col-md-4 col-form-label text-md-end">confirm password</label>

                            <div class="col-md-6">
                                <input id="confirmpassword" type="password" class="form-control @error('confirmpassword') is-invalid @enderror" data-parsley-trigger="keyup" data-parsley-equalto="#newpassword" required name="confirmpassword" autofocus>

                                @error('confirmpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('confirmpassword')}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Change password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    $(document).ready(function() {
        $('#passwordForm').parsley()
        on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
            })
            .on('form:submit', function() {
                return false;
            });
    })
</script>
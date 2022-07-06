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
        @if(Session::has('successMsg'))
        <div class="alert alert-info">{{Session::get('successMsg')}}</div>
        @endif
        @if(Session::has('errorMsg'))
        <div class="alert alert-danger">{{Session::get('errorMsg')}}</div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Profile</div>

                <div class="card-body">
                    <form method="POST" action="/update/{{$data->id}}" enctype="multipart/form-data" id="editForm" data-parsely-validate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="firstname" class="col-md-4 col-form-label text-md-end">First Name</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" data-parsley-trigger="keyup" required name="firstname" value="{{ $data->firstname }}" autocomplete="firstname" autofocus>

                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('firstname')}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lastname" class="col-md-4 col-form-label text-md-end">Last Name</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" data-parsley-trigger="keyup" name="lastname" value="{{ $data->lastname }}">

                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data->email }}" autocomplete="email" data-parsley-trigger="keyup" required data-parsely-type="email" readonly>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>

                            <div class="col-md-6">
                                <select name="status" id="status" class="form-control" required>
                                    <option value=" active" {{($data->status=='active')?'selected':''}}>Active</option>
                                    <option value="inactive" {{($data->status=='inactive')?'selected':''}}>In Active</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">Image</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control" name="image">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Update
                                </button>

                                <a href="/changepassword/{{$data->id}}" class="btn btn-primary text-white">Change password</a>

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
        $('#editForm').parsley()
        on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
            })
            .on('form:submit', function() {
                return false;
            });
    })
</script>
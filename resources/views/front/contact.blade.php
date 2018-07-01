@php
    $locale = app()->getLocale();
@endphp

@extends('layouts.front')

@section('title', ucfirst(__('routes.contact')))

@section('seo', '')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="">{{ __('Your Name') }}</label>

                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="email" class="">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="message" class="col-form-label">{{ __('Message') }}</label>

                                <textarea name="message" id="message" rows="10" class="form-control"></textarea>
                            </div>

                            <div class="form-group row mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

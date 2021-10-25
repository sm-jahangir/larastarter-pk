@extends('layouts.backend.app')

@section('title','Roles')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .dropify-wrapper .dropify-message p{
        font-size: initial;
    }
</style>
@endpush
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>{{ __((isset($user) ? 'Edit' : 'Create New') . ' User') }}</div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <a href="{{ route('app.users.index') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="fas fa-arrow-circle-left fa-w-20"></i>
                    </span>
                    {{ __('Back to list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- form start -->
        <form role="form" id="userFrom" method="POST"
            action="{{ isset($user) ? route('app.users.update',$user->id) : route('app.users.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if (isset($user))
            @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">User Info</h5>
                            <div class="form-group">
                              <label for="name">Name</label>
                              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $user->name ?? ''  }}" placeholder="Name" required autofocus />
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ $user->email ?? ''  }}" placeholder="email"  />
                                @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" {{ !isset($user) ? 'required' : '' }} />
                                @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="confirm_password" {{ !isset($user) ? 'required' : '' }} />
                                @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Select Role and Status</h5>
                            <div class="form-group">
                              <label for="role">Select Role</label>
                              <select class="js-example-basic-single form-control @error('role') is-invalid @enderror" name="role" id="role">
                                  @foreach ($roles as $key=>$role)
                                      <option value="{{ $role->id }}" @isset($user) {{ $user->role->id == $role->id ? 'selected' : '' }} @endisset>{{ $role->name }}</option>
                                  @endforeach
                              </select>
                              @error('role')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                            <div class="form-group">
                              <label for="avatar">Avatar</label>
                              <input type="file" data-default-file="{{ isset($user) ? $user->getFirstMediaUrl('avatar','thumb') : ''  }}" class="form-control dropify @error('avatar') is-invalid @enderror" name="avatar" id="avatar" />
                                
                              @error('avatar')
                                  <span class="text-danger" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
{{-- 
                            <x-forms.checkbox label="Status" name="status" class="custom-switch"
                                :value="$user->status ?? null" /> --}}
                                <div class="custom-control custom-switch mb-4">
                                    <input type="checkbox" name="status" class="custom-control-input" id="status" @isset($user) {{ $user->status == true ? 'checked' : '' }} @endisset />
                                    <label class="custom-control-label" for="status">Status</label>

                                  </div>

                                <button type="reset" class="btn btn-danger">Reset</button>
                               @isset($user)
                                    <button type="submit" class="btn btn-danger">Update</button>
                                @else
                                    <button type="submit" class="btn btn-primary">Create</button>
                                @endisset
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.dropify').dropify();
            $('.js-example-basic-single').select2();
        });
</script>
@endpush

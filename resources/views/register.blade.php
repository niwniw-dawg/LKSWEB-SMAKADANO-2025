@extends('layout')
@section('content')
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                            <div class="card-body">
                                <form action="{{route('proses_register')}}" method="POST" id="regForm">
                                {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputusername">Username</label>
                                        <input class="form-control py-4" id="inputusername" type="text" name="username" placeholder="Masukkan username" />
                                         @if ($errors->has('username'))
                                          <span class="error"> * {{ $errors->first('username') }}</span>
                                          @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputPassword">Password</label>
                                        <input class="form-control py-4" id="inputPassword" type="password" name="password" placeholder="Masukkan Password" />
                                        @if ($errors->has('password'))
                                          <span class="error">* {{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mt-4 mb-0">
                                        <button class="btn btn-primary btn-block" type="submit">Daftar!</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small"><a href="{{route('login')}}">Sudah Punya Akun? Login!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</div>
@endsection
@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a onclick="window.history.go(-1); return false;" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <h4 class="mx-auto"> Change Password </h4>
        </div>
        <form action="{{route('update-password')}}" method="POST"> 
            @csrf
            <div class="form-group mt-3">
                <label for="old_pass" class="form-label">Password Lama</label>
                <input type="password" class="form-control" id="old_pass" name="old_pass" placeholder="Password Lama" required>
            </div>

            <div class="form-group mt-3">
                <label for="new_pass" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="new_pass" name="new_pass" minlength="6" placeholder="Password Baru" required>
            </div>

            <div class="form-group mt-3">
                <label for="new_pass_confirmation" class="form-label">Confirm Password Baru</label>
                <input type="password" class="form-control" id="new_pass_confirmation" minlength="6" name="new_pass_confirmation" placeholder="Confirm Password Baru" required>
            </div>

            <div class="center mt-3">
                <button type="submit" class="btn btn-purple btn-sm mx-2 px-3"> Update Password </button>
            </div>
        </form>

    </div>

@include('ortu.footer.index')
    
@endsection
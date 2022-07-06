@extends('profile.layout')

@section('main')
  <h5>Two Factor Auth :</h5>
  <hr>
    

            @if($errors->any())
            
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

  <form action="#" method="post">
   @csrf
       
     <div class="form-group">
         <label for="type">Type</label>
         <select name="type" id="type" class="form-control">
            @foreach(config('twofactor.types') as $key => $name)
            <option value="{{ $key }} {{ old('type') == $key || auth()->user()->hasTwoFactor($key) ? 'selected' : '' }}">{{ $name }}</option>
            @endforeach
         </select>
     </div>
         <hr>
        <div class="form-group">
            <lable for="phone">Phone</lable>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="please add your number" value="{{old('phone', auth()->user()->phone_number)}}">

        </div>
        <hr>
        <div class="form-group">
            <button class="btn btn-primary">
                update
             </button>
        </div>

  </form>

  @endsection

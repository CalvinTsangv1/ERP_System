@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-white bg-dark ">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="postTitle" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <select id="postTitle" type="text" class="form-control @error('postTitle') is-invalid @enderror" name="postTitle"  value="{{ old('postTitle') }}" required autocomplete="postTitle">
                                    <option value="" selected >Please select your title</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Purchasing Manager">Purchasing Manager</option>
                                    <option value="Resturant Manager">Resturant Manager</option>
                                    <option value="Accounting Manager">Accounting Manager</option>
                                    <option value="Warehouse Clerk">Warehouse Clerk</option>
                                    <option value="Category Manager">Category Manager</option>
                                </select>
                                
                                @error('postTitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ 'postTitle' }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="branchID" class="col-md-4 col-form-label text-md-right">{{ __('Branch') }}</label>
                            <div class="col-md-6">
                                <select id="branchID" type="text" class="form-control @error('branchID') is-invalid @enderror" name="branchID"  value="{{ old('branchID') }}" required autocomplete="branchID">
                                    <option value="" selected >Please select your branch</option>
                                    
                                    
                                   <option value=47>A Smoking Affair</option>
                                    <option value=1>Accounting Department</option>
                                    <option value=9>Amitie Kitchen</option>
                                    <option value=16>ATUM Restaurant</option>
                                    <option value=7>Bellevue Bar and Grill</option>
                                    <option value=27>Black Coffee</option>
                                    <option value=39>Call Me Chef</option>
                                    <option value=11>Cobber Coffee and Tonys Pastry</option>
                                    <option value=23>Day and Nite by Master Kama</option>
                                    <option value=21>Deluxe Daikiya Japanese Restaurant</option>
                                    <option value=5>FAB Kitchen</option>
                                    <option value=13>Goobne Chicken</option>
                                    <option value=8>HAND3AG</option>
                                    <option value=36>Hanook Korean Restaurant</option>
                                    <option value=32>Harbourside Grill</option>
                                    <option value=30>Hibiki Japanese Yakiniku</option>
                                    <option value=34>Holam Bakery</option>
                                    <option value=29>Jie Genge</option>
                                    <option value=19>LAB EAT Restaurant & Bar</option>
                                    <option value=2>Marketing Department</option>
                                    <option value=33>Master Beef</option>
                                    <option value=26>Mini Friday</option>
                                    <option value=35>Moo Moo's</option>
                                    <option value=31>Mu Taiwan Noodles</option>
                                    <option value=6>Outdark</option>
                                    <option value=37>PANO</option>
                                    <option value=20>Paper Moon</option>
                                    <option value=44>Poach</option>
                                    <option value=41>Pom's Kitchen & Deli</option>
                                    <option value=3>Purchasing Department</option>
                                    <option value=40>Red Lobster</option>
                                    <option value=28>Shahrazad Lebanese Dining Lounge & Bar</option>
                                    <option value=24>Shine</option>
                                    <option value=22>Sky726</option>
                                    <option value=45>Sushi Kumo</option>
                                    <option value=18>Tadllie Plate</option>
                                    <option value=38>Tearapy</option>
                                    <option value=50>Thai BBQ Shrimp</option>
                                    <option value=12>The BASE nature</option>
                                    <option value=48>The Hangout Corner</option>
                                    <option value=14>The Market</option>
                                    <option value=17>The Place</option>
                                    <option value=15>Three on Canton</option>
                                    <option value=25>TONO DAIKIYA Japanese Restaurant</option>
                                    <option value=46>Towada Sushi</option>
                                    <option value=49>Uchi City Stone Grill House</option>
                                    <option value=10>Wanna Eat</option>
                                    <option value=4>Warehouse</option>
                                    <option value=43>Y Show Tasty</option>
                                    <option value=42>Yakinkumafia</option>

                                </select>
                                
                                @error('branchID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ branchID }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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

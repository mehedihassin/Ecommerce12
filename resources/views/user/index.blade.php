@extends('layouts.app')
@section('content')
<div class="container">
    <h1>User Dashboard</h1>
    <p>Welcome to the User dashboard!</p>
    
    <!-- Add more admin functionalities here -->  
    
    
       <li class="menu-item">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <div class="icon"><i class="fa fa-sign-out-alt"></i></div>
                                        <!-- Use your icon class -->
                                        <div class="text text-danger">Logout</div>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
</div>
@endsection    
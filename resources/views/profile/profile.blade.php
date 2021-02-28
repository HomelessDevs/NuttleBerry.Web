@extends('templates.main-template')
@section('content')
    @php
        if($user == null){
        echo 'User not found';
        }
        else{
        echo '<p>' . $user->name . '</p>';
                echo '<p>' . $user->role . '</p>';
        if($user->id == Auth::user()->id){
            echo '<a href=" ' . route('profile.edit', $user->id) . '">edit</a>';
        }
        if(Auth::user()->role == "teacher"  || Auth::user()->role == "admin"){
            if( $user->role != 'admin' && $user->role != 'teacher' ){
            echo '<form method="POST" action = "'. route('profile.promote', $user->id) .'">
                    '. method_field('PUT') . '

               ' . csrf_field()  . '
            <input type="submit" value = "promote to teacher">
            </form>
            ';}
            }
        }
    @endphp
    <h1>section</h1>
@endsection

@extends('front.layout.master')

@section('style')
    <style>
        .container div,.container span,.container p,.container h3,.container h1,.container h4,.container h5,.container h6,.container h2{
            font-family: 'Yekan', sans-serif!important;

        }
        .row{
        margin-right:0;
         margin-left: 0;
            }
</style>
@endsection

@section('content')
    <div class="container my-16">
        <div class="card">
            <?= $page->page ?>
        </div>

    </div>
@endsection

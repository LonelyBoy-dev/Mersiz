@extends('front.profile.layout')

@section('content_panel')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            لیست مورد علاقه
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">

            <div class="box-body">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th> تصویر </th>
                            <th> عنوان </th>
                            <th>قیمت</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($favorites as $item)

                            <tr>
                                <td><img width="80" src="{{asset($item->product->image)}}"></td>
                                <td><a target="_blank" href="product/{{$item->product->slug}}">{{Illuminate\Support\Str::limit($item->product->title,30)}}</a></td>
                                <td>{{number_format($item->product->price*(100-$item->product->discount)/100)}} تومان </td>
                                <td><button onclick="delete_favorite(this,{{$item->id}})" type="button" class="btn btn-danger">حذف</button></td>
                            </tr>
                        @endforeach
                        </tbody></table>
                </div>

            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('script')
        <script>
            function delete_favorite(tag,id) {
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('panel.delete_favorite')}}';
                var data = {_token: CSRF_TOKEN, id: id};
                $.post(url, data, function (msg) {
                    if(msg=="deleted"){
                        $(tag).parents('tr').remove();
                        alertify.set('notifier','position', 'bottom-left');
                        alertify.success('با موفقیت از لیست علاقه مندی حذف شد');
                    }
                });
            }
        </script>
@endsection

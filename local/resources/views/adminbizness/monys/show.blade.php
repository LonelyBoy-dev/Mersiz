@extends('adminbizness.layout.master')

@section('style_link')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
@endsection

@section('style')
    <style>
        .table th{
            text-align: center;
        }
        .nav-tabs > li{
            float: right;
        }
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 60px;
        }
    </style>
@endsection

@section('Admin_content')
    @if(session('askformoney'))
        <div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{session('askformoney')}}
        </div>
    @endif

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 80px">

            <div class="card" style="box-shadow: none">
                <a href="/adminb/monys" style="float:left;font-size: 10px;padding: 2px;margin: 10px 0 0 10px;background-color: #61c579 !important;" type="button" class="btn bg-green waves-effect">
                    <span>برگشت</span>
                    <i style="font-size: 16px" class="material-icons">arrow_back</i>
                </a>
                <div class="body">
                    <!-- Nav tabs -->

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div class="box-body">
                            <br>
                            <div class="container-fluid table-responsive">

                                <table class="table table-bordered text-center table-striped" id="myTable2"
                                       style="width: 100%;font-size: 13px">
                                    <thead class="bg-blue-gradient">
                                    <tr id="">
                                        <th>#</th>
                                        <th>نام و نام خانوادگی</th>
                                        <th>شماره حساب</th>
                                        <th>شماره کارت</th>
                                        <th>موبایل</th>
                                        <th>مبلغ</th>
                                        <th>وضعیت پرداخت</th>
                                        <th style="width: 10px">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=1; @endphp
                                    @foreach($walletsreports as $report)
                                        <?php
                                        $user=App\User::findorfail($report->user_id);
                                        ?>
                                        <tr>
                                            <th scope="row">{{$i++}}</th>
                                            <td><a href="{{route('users.edit',$user->id)}}">{{$user->name}}</a></td>
                                            <td>{{$user->account_number}}</td>
                                            <td>{{$user->card_number}}</td>
                                            <td>{{$user->mobile}}</td>
                                            <td><a onclick="setrowid({{$report->id}})" href="javascript:void(0);" data-toggle="modal" id="row_{{$report->id}}" data-target="#exampleModal">{{number_format($report->price)}} تومان </a></td>
                                            <td>@if($report->status=="PAY") <span style="color: #61c579;">پرداخت شده</span><span style="color: #61c579;float:right;width: 100%">{{Verta::instance($report->updated_at)->format('H:i Y-n-j')}}</span> @elseif($report->status=="UNPAYD") <span style="color: #ea7841;">پرداخت نشده</span> @elseif($report->status=="Waiting") <span style="color: #ea7841;">در انتظار پرداخت</span> @endif</td>
                                            <td>@if($report->status=="Waiting") <a href="/adminb/monys/pay/{{$report->id}}" type="submit" style="float:left;" class="btn btn-success">پرداخت </a> @endif</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>


    </div>

    <div class="modal ali-modal" id="exampleModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="commentText" class="col-form-label"> مبلغ قابل پرداخت:</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" name="price" class="form-control" placeholder="مبلق را وارد کنید">
                                    <input name="row_id" type="hidden">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                        <span style="float: left" id="replycm" onclick="set_price(this)" class="btn btn-primary">
                            ثبت
                        </span>
                    </div>

            </div>
        </div>
    </div>
@endsection

@section('script_link')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
@endsection


@section('script')
    <script>

        $('#myTable').DataTable({
            "lengthMenu": [
                [20, 30, 40],
                [20, 30, 40],
            ],
            "language": {
                "sEmptyTable": "هیچ داده‌ای در جدول وجود ندارد",
                "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "sInfoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "sInfoFiltered": "(فیلتر شده از _MAX_ ردیف)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "نمایش _MENU_ ردیف",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "جستجو:",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oPaginate": {
                    "sFirst": "برگه‌ی نخست",
                    "sLast": "برگه‌ی آخر",
                    "sNext": "بعدی",
                    "sPrevious": "قبلی"
                },
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            }
        });

        $('#myTable2').DataTable({
            "lengthMenu": [
                [20, 30, 40],
                [20, 30, 40],
            ],
            "language": {
                "sEmptyTable": "هیچ داده‌ای در جدول وجود ندارد",
                "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ ردیف",
                "sInfoEmpty": "نمایش 0 تا 0 از 0 ردیف",
                "sInfoFiltered": "(فیلتر شده از _MAX_ ردیف)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "نمایش _MENU_ ردیف",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "جستجو:",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oPaginate": {
                    "sFirst": "برگه‌ی نخست",
                    "sLast": "برگه‌ی آخر",
                    "sNext": "بعدی",
                    "sPrevious": "قبلی"
                },
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            }
        });

        $('.dataTables_length select').addClass('tbl_data');

    </script>

    <script>
        function setrowid(id) {
            $('input[name=row_id]').val(id)
            $('input[name=price]').val('');
        }
        function set_price(tag) {
            var price=$('input[name=price]').val();
            var row_id=$('input[name=row_id]').val();
            if (price!=""){
                var CSRF_TOKEN = '{{ csrf_token() }}';
                var url = '{{route('change_price_monys_user')}}';
                var data = {_token: CSRF_TOKEN,price:price,row_id:row_id};
                $.post(url, data, function (msg) {
                    $('#row_'+row_id).text(msg.price+ ' تومان ');
                    $('.modal-backdrop.in').css('display','none');
                    $('.ali-modal').css('display','none');
                });
            }else{
                $('input[name=price]').css('border-bottom','1px solid red');
            }

        }
    </script>
@endsection
@php
    Session::forget('askformoney');
@endphp

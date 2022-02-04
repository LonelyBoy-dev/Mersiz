@extends('front.profile.layout')

@section('content_panel')



            <div class="card mb-16 p-20">


                <div class="card-header card-header-right-border">
                    <div class="card-header_caption">
                        <div class="card-header_caption-title">
                            <div class="card-header_caption-text">درخواست وجه</div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center align-items-center pt-8 pr-36 pl-36"
                         style="height: 320px; box-sizing: border-box; flex-wrap:nowrap">

                        <div class="col-sm-8 d-flex flex-column justify-content-between main-box-shadow ml-20 mr-20"
                             style="height:100%;padding:30px; background-color: #f8f8f8; border-radius: 10px">

                            <div class="text-right">
                                <div class="h5 font-weight-bold" style="color: #363636">شماره کارت بانکی</div>
                                <div class="txt16-w500 w-90 mt-8" style="color: #686868; line-height: 28px">مشتری گرامی،
                                    به منظور بهره مندی از امکان عودت وجه، خواهشمند است شماره کارت خود را در قسمت زیر
                                    وارد نمایید
                                </div>
                            </div>
                            @php $cardNumber=explode('-',@$user->card_number) @endphp
                            <form method="post" autocomplete="off" id="cardForm" action="/profile/store-bankcard"
                                  novalidate="novalidate">
                                @csrf
                            <div id="cardInputs"
                                 class="form-group d-flex justify-content-end align-items-center mt-16 mb-24" dir="ltr">
                                <input type="text" maxlength="4" tabindex="2" minlength="4"
                                       class="form-control rounded-sm bg-light input-digit w-20 ml-16"
                                       style="min-width: 60px; max-width: 90px" data-val="true" data-val-regex=" "
                                       data-val-regex-pattern="\d{4}" data-val-required=" " id="CodePart1"
                                       name="CodePart1" value="{{@$cardNumber[0]}}">
                                <input type="text" maxlength="4" tabindex="3" minlength="4"
                                       class="form-control rounded-sm bg-light input-digit w-20 ml-16"
                                       style="min-width: 60px; max-width: 90px" data-val="true" data-val-regex=" "
                                       data-val-regex-pattern="\d{4}" data-val-required=" " id="CodePart2"
                                       name="CodePart2" value="{{@$cardNumber[1]}}">
                                <input type="text" maxlength="4" tabindex="4" minlength="4"
                                       class="form-control rounded-sm bg-light input-digit w-20 ml-16"
                                       style="min-width: 60px; max-width: 90px" data-val="true" data-val-regex=" "
                                       data-val-regex-pattern="\d{4}" data-val-required=" " id="CodePart3"
                                       name="CodePart3" value="{{@$cardNumber[2]}}">
                                <input type="text" maxlength="4" tabindex="5" minlength="4"
                                       class="form-control rounded-sm bg-light input-digit w-20 ml-16"
                                       style="min-width: 60px; max-width: 90px" data-val="true" data-val-regex=" "
                                       data-val-regex-pattern="\d{4}" data-val-required=" " id="CodePart4"
                                       name="CodePart4" value="{{@$cardNumber[3]}}">
                            </div>


                                <div class="text-right">
                                    <button class="btn btn-secondary" id="addCardButton"
                                            style="height: 43px; padding: 0px 48px" type="submit">افزودن شماره کارت
                                    </button>

                                </div>
                            </form>


                        </div>
                        <div class="col-sm-4 d-flex flex-column justify-content-center main-box-shadow ml-20"
                             style="height: 100%; padding:30px; background-color: #f8f8f8; border-radius: 10px">

                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="d-flex flex-column justify-content-between h-50">
                                    <div class="d-flex justify-content-between">
                                        <span>موجودی کیف پول شما:</span>
                                        <span>0 ریال</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span>مبلغ قابل برداشت:</span>
                                        <span> ریال</span>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#chooseAmountModal" style="height:43px; padding: 0px 48px">
                                        درخواست وجه نقد
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="mr-16 ml-16 mt-8">

                    </div>


                </div>

            </div>


            <div class="modal fade" id="chooseAmountModal" tabindex="-1" role="dialog"
                 aria-labelledby="chooseAmountModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered w-33" role="document">
                    <div class="modal-content p-16" style="border-radius:8px">
                        <div class="modal-header border-0">
                            <h4 class="modal-title">انتخاب مبلغ واریزی</h4>
                        </div>
                        <div class="modal-body border-0">
                            <div class="d-flex flex-column">
                                <div class="w-90 mb-16" style="color: gray">حداکثر مبلغ قابل برداشت شما <span
                                        class="text-secondary" style="direction:rtl"> {{setting()['currency']}} </span> می باشد، در صورتی که
                                    تمایل دارید کمتر از آن برداشت کنید قسمت زیر را تغییر دهید.
                                </div>
                                <div class="d-flex justify-content-center align-items-center bg-gray-100"
                                     style="overflow: hidden; height: 52px; border-radius: 10px; border: 0.5px solid #ebebeb">
                                    <span class="col-2"></span>
                                    <span class="col-8 text-center">
                            <input id="quantity" class="text-center m-0 border-0 bg-transparent" type="text" value=""
                                   style="width:100px; font-size: 18px">
                        </span>
                                    <span class="col-2 d-flex justify-content-center align-items-center bg-light h-100"
                                          style="font-size:18px; background-color:#fff">{{setting()['currency']}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex flex-row-reverse border-0">
                            <button type="button" class="btn btn-light text-center"
                                    style="padding: 0 64px; height: 43px" data-dismiss="modal">لغو
                            </button>
                            <button id="btnsubmitrequest" class="btn btn-primary text-center"
                                    style="padding: 0 80px; height: 43px">ثبت درخواست
                            </button>
                        </div>
                    </div>
                </div>
            </div>



        <style>
            hr {
                border: 0;
                clear: both;
                display: block;
                width: 100%;
                background-color: #f1f1f1;
                height: 1px;
            }
        </style>



        <script>


            $(document).ready(function () {
                var x =;
                $('#quantity').bind('copy paste cut', function (e) {
                    e.preventDefault();
                });

                $("#quantity").on('keydown keyup', function (e) {
                    if ($("#quantity").val() >= x
                        && e.keyCode !== 46 // keycode for delete
                        && e.keyCode !== 8 // keycode for backspace
                        && e.keyCode !== 40 // keycode for down arrow
                    ) {
                        e.preventDefault();
                        $("#quantity").val(x)
                    }
                    ;
                });
            });


            $(document).ready(function () {

                var CodeNum = '';
                var hasCatdNumber = 0;
                if (hasCatdNumber == 0) {
                    //$('#btnGetcash').css("color", "red");
                    $('#btnGetcash').addClass('rm-btn-hist');
                    $('#btnGetcash').removeClass('btn-primary');
                }


            });


            $('#btnGetcash').click(function () {

                var hasCatdNumber = 0;
                if (hasCatdNumber == 1) {
                    $('#myModal').modal('show');

                } else {
                    alert('شماره کارت را وارد کنید')
                }


            });


            $('#btnsubmitrequest').click(function () {
                var credit = $("#quantity:text").val();

                var codeNum = '';

                $.ajax({
                    type: 'Get',
                    url: '/Profile/RefundReturn?cardNumberAN=' + codeNum + '&' + 'amount=' + credit,
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    success: function (data) {
                        alert(data.responseText);
                        location.reload();

                    },
                    error: function (data) {
                        alert(data.responseText);
                        location.reload();

                    }
                });
            });


            var editable = true;
            var inputs = $("#cardInputs").children();
            $(document).ready(function () {
                for (var i = 0; i < 4; i++) {
                    if (inputs[i].value.length == 4) {
                        editable = false;
                    } else {
                        editable = true;
                    }
                }
                if (editable == false) {
                    //inputs.attr('readonly', true).addClass("unselectable");
                    inputs.attr('disabled', 'disabled');
                    inputs.addClass('disabled-input')
                } else {
                    inputs.attr('readonly', false).removeClass("unselectable");
                    inputs.removeAttr('disabled', 'disabled');
                }
            })

            $('#editCardButton').click(function () {

                if ($('#editCardButton').text() == "ویرایش شماره کارت") {
                    $('#cardForm').submit(function (e) {
                        $('.page-loading').css("display", "none")
                    });
                    $(this).text('ثبت شماره کارت');
                    $(this).removeClass('btn-dark')
                    inputs.removeClass('disabled-input')
                    $(this).addClass('btn-secondary')
                    $(this).removeAttr('disabled')
                    inputs.attr('readonly', false).removeClass("unselectable");
                    inputs.removeAttr('disabled', 'disabled');
                } else {
                    var permit = true
                    for (var i = 0; i < 4; i++) {
                        if (inputs[i].value.length == 4) {
                            permit = true & permit;
                        } else {
                            permit = false & permit;
                        }
                    }
                    if (permit) {
                        $('#editCardButton').attr('type', 'submit')
                        $('#cardForm').unbind('submit').submit()
                    }
                }

            });

        </script>
    </div>


@endsection
@section('script')
    @if(session('bankcard_store'))
        <script>
            alertify.set('notifier','position', 'top-right');
            alertify.success('<?= session('bankcard_store') ?>');
        </script>
    @endif
@endsection
@php
    Session::forget('bankcard_store');
@endphp

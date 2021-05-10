@extends('dashboard.app')
@section('dashboard-content')

@include('dashboard.inc.navbar')

    <div class="container py-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-9">
                        <div class="row" id="first-step" >
                            <div class="col-md-6  mb-3">
                                <div class="box-bank box-hover shadow-sm p-2 rounded border">
                                    <div class="img" style="background-image:url({{ asset('imgs/payments/aba.png') }})"></div>
                                    <div class="title">
                                        ABA Bank Transfer
                                        <span class="">Processing Time: 15 mins</span>
                                        <span class="">Fee: USD Free</span>
                                        <span class="">USD 5.00 - 5,000.00</span>
                                    </div>
                                    <a href="#"  class="stretched-link payment" data-description="Make a fund transfer to the receiving account below:" data-account-name="Koung Buntha" data-account-number="000715640" data-transaction="Transfer Reference #" data-transaction-example="ABA Reference # contain 16 characters." data-image="{{ asset('imgs/payments/aba.png') }}" data-fee="Free" data-min="10.00" data-max="5,000.00" data-processing-time="15 mins" data-payment="ABA Bank Transfer"></a>
                                </div>
                            </div>
                            <div class="col-md-6  mb-3">
                                <div class="box-bank box-hover shadow-sm p-2 rounded border">
                                    <div class="img" style="background-image:url({{ asset('imgs/payments/wing.png') }})"></div>
                                    <div class="title">Wing
                                        <span class="">Processing Time: 15 mins</span>
                                        <span class="">Fee: USD Free</span>
                                        <span class="">USD 5.00 - 5,000.00</span>
                                    </div>
                                    <a href="#"  class="stretched-link payment" data-account-name="Koung Buntha" data-description="Or visit their branch and make a transfer to our Wing account information below:" data-account-number="01723730" data-transaction="TID" data-transaction-example="Example: TID: EAxxXxXX" data-image="{{ asset('imgs/payments/wing.png') }}" data-fee="Free" data-min="10.00" data-max="5,000.00" data-processing-time="15 mins" data-payment="Wing"></a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="display:none" id="second-step">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <button id="btn-back" onclick="firstStep()" class="btn btn-defualt"><i class="fas fa-arrow-left"></i></button>
                                            <span class="mt-2">Enter Detail</span>
                                            <button class="btn btn-defualt"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="second-step box-bank">
                                            <div class="img"></div>
                                            <div class="title"></div>
                                        </div>
                                        <div class="py-3">
                                            <input type="text" placeholder="Account Name" id="account_name"  class="form-control mb-3 form-control-lg rounded-0 rounded-top">
                                            <input type="text" placeholder="Account Number" id="account_number"  class="form-control mb-3 form-control-lg rounded-0 rounded-top">
                                            <input type="text" placeholder="Deposit Amount" id="amount"  class="currency form-control mb-3 form-control-lg rounded-0 rounded-top">
                                            <button onclick="thirdStep()" class="d-block btn btn-sm btn-dark-700 rounded-0 shadow">AGREE & SUBMIT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset("js/jquery.inputmask.bundle.min.js") }}"></script>
        <script>
            $('.currency').formatNumberElement();
            $(".payment").click(function(){
                secondStep();
                Cookies.set('payment', $(this).attr('data-payment'));
                Cookies.set('fee', $(this).attr('data-fee'));
                Cookies.set('min', $(this).attr('data-min'));
                Cookies.set('max', $(this).attr('data-max'));
                Cookies.set('image', $(this).attr('data-image'));
                Cookies.set('processing', $(this).attr('data-processing-time'));
                Cookies.set('transaction', $(this).attr('data-transaction'));
                Cookies.set('transaction-example', $(this).attr('data-transaction-example'));
                Cookies.set('account-name', $(this).attr('data-account-name'));
                Cookies.set('account-number', $(this).attr('data-account-number'));
                Cookies.set('description', $(this).attr('data-description'));
            });
            function firstStep(){
                $("#second-step").fadeOut('fast');
                setTimeout(() => { $("#first-step").fadeIn('fast');}, 200);
            }
            function secondStep(){
                $("#first-step").fadeOut('fast');
                $("#third-step").fadeOut('fast');
                setTimeout(() => {
                    var text = `${Cookies.get('payment')}
                    <span class="">Processing Time: ${Cookies.get('processing')}</span>
                    <span class="">Fee: USD ${Cookies.get('fee')}</span>
                    <span class="min">USD ${Cookies.get('min')} - ${Cookies.get('max')}</span>`;
                    $(".second-step .img").css("background-image", `url(${Cookies.get('image')})`);
                    $(".second-step .title").html(text);
                    $("#second-step").fadeIn('fast');
                }, 200);
            }
            function thirdStep(){
                var errors = [];
                if( !$("#account_name").val()){
                    errors.push({'account_name':'Please enter your name'});
                    $("#account_name").addClass('is-invalid');
                }else{
                    errors.splice(1,'account_name ');
                    $("#account_name").removeClass('is-invalid');
                }
                if( !$("#account_number").val()){
                    $("#account_number").addClass('is-invalid');
                     errors.push({'account_number':'Please enter your account number'});
                }else{
                    errors.splice(1,'account_number');
                    $("#account_number").removeClass('is-invalid');
                }
                if( !$("#amount").val()){
                    errors.push({'amount':'Please enter the amount to withdraw!'});
                    $("#amount").addClass('is-invalid');
                }else{
                    errors.splice(1,'amount');
                    $("#amount").removeClass('is-invalid');
                }
                if(errors.length === 0){
                    $.ajax({
                        url:'/withdraw',
                        method:"POST",
                        data:{
                            '_token':$("meta[name='csrf-token']").attr('content'), 
                            'account_name':$("#account_name").val(),
                            'account_number':$("#account_number").val(),
                            'amount': $("#amount").val(),
                            'payment': Cookies.get('payment'),
                        },
                        success:function(data){
                            if(data.code === 200){
                                Swal.fire({
                                    'icon':"success",
                                    'text': data.message,
                                    'showConfirmButton':true,
                                    'confirmButtonText': 'Thank you',
                                });
                                setTimeout(() => {
                                    window.location.href = '/transactions';
                                }, 2000);
                            }else{
                                Swal.fire({
                                    'icon':"info",
                                    'text': data.message,
                                    'showConfirmButton':true,
                                    'confirmButtonText': 'Try again',
                                })
                            }
                        },
                        error: function(error){
                            console.error(error);
                        }
                    });
                }
            }
            function clearCookies(){
                Cookies.remove('payment');
                Cookies.remove('fee');
                Cookies.remove('min');
                Cookies.remove('max');
                Cookies.remove('processing');
                Cookies.remove('image');
                Cookies.remove('trasaction');
                Cookies.remove('trasaction-example');
                Cookies.remove('account-name');
                Cookies.remove('account-number');
                Cookies.remove('description');
                Cookies.remove('amount');
            }
            window.onbeforeunload = clearCookies;
            $("#money").click(function() {
                var inputLength = $("#money").val().length;
                setCaretToPos($("#money")[0], inputLength)
            });
            $("#amount").inputmask({ alias : "currency", prefix: '',rightAlign:false});
        </script>
    @endpush
@endsection
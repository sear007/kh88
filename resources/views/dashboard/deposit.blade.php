@extends('dashboard.app')
@section('dashboard-content')
<div class="nav-scroller shadow-sm">
<nav class="nav nav-underline" aria-label="Secondary navigation">
    <a class="nav-link active" href="#"><i class="me-1 fas fa-hand-holding-usd"></i>Deposit</a>
    <a class="nav-link" href="#"><i class="me-1 fas fa-dollar-sign"></i>Withdraw</a>
    <a class="nav-link" href="#"><span class="me-1 fa fa-funnel-dollar"></span> Transactions</a>
    <a class="nav-link" href="#"><span class="me-1 fa fa-money-check-alt"></span>Bank Accounts</a>
</nav>
</div>
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
                                        <span class="">USD 1.00 - 5,000.00</span>
                                    </div>
                                    <a href="#"  class="stretched-link payment" data-description="Make a fund transfer to the receiving account below:" data-account-name="Koung Buntha" data-account-number="000715640" data-transaction="Transfer Reference #" data-transaction-example="ABA Reference # contain 16 characters." data-image="{{ asset('imgs/payments/aba.png') }}" data-fee="Free" data-min="1.00" data-max="5,000.00" data-processing-time="15 mins" data-payment="ABA Bank Transfer"></a>
                                </div>
                            </div>
                            <div class="col-md-6  mb-3">
                                <div class="box-bank box-hover shadow-sm p-2 rounded border">
                                    <div class="img" style="background-image:url({{ asset('imgs/payments/wing.png') }})"></div>
                                    <div class="title">Wing
                                        <span class="">Processing Time: 15 mins</span>
                                        <span class="">Fee: USD Free</span>
                                        <span class="">USD 1.00 - 5,000.00</span>
                                    </div>
                                    <a href="#"  class="stretched-link payment" data-account-name="Koung Buntha" data-description="Or visit their branch and make a transfer to our Wing account information below:" data-account-number="01723730" data-transaction="TID" data-transaction-example="Example: TID: EAxxXxXX" data-image="{{ asset('imgs/payments/wing.png') }}" data-fee="Free" data-min="1.00" data-max="5,000.00" data-processing-time="15 mins" data-payment="Wing"></a>
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
                                            <input type="text" placeholder="Deposit Amount" id="amount"  class="currency form-control mb-3 form-control-lg rounded-0 rounded-top">
                                            <button onclick="thirdStep()" class="d-block btn btn-sm btn-dark-700 rounded-0 shadow">AGREE & SUBMIT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center" style="display:none" id="third-step">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <button id="btn-back" onclick="secondStep()" class="btn btn-defualt"><i class="fas fa-arrow-left"></i></button>
                                            <span class="mt-2">Enter Detail</span>
                                            <button class="btn btn-defualt"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="third-step box-bank">
                                            <div class="img"></div>
                                            <div class="title"></div>
                                        </div>
                                        <div class="py-3">
                                            <div class="py-3">
                                                <div class="bg-light shadow-sm  p-3 mb-3">
                                                    <div class="text-center">
                                                        <h5>Transfer funds now!</h5>
                                                        <p class="small text-muted" id="description"></p>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex ">
                                                        <div class="flex-fill small">
                                                            <span class="d-block">Account Name</span>
                                                            <span id="account-name"></span>
                                                        </div>
                                                        <div class="flex-fill small">
                                                            <span class="d-block">Account Number</span>
                                                            <span class="bold" id="account-number"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div>
                                                    <div class="p-2 bg-light shadow-sm mb-3">
                                                        <span class="d-block small text-muted">Deposit Amount</span>
                                                        <span class="d-block bold text-muted">USD <span class="currency" id="amount"></span></span>
                                                        <div class="mb-2"></div>
                                                        <input type="text" placeholder="TID" id="transaction"  class="form-control form-control-lg rounded-0 rounded-top">
                                                        <span class="text-muted small" id="transaction-example"></span>
                                                    </div>
                                                </div>
                                                <button id="btn_forthStep" disabled="disabled" onclick="forthStep()" class="d-block btn btn-sm btn-dark-700 rounded-0 shadow">AGREE & SUBMIT</button>
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
                validation();
                if($("#amount").val()){
                    if(1 > $("#amount").val()){
                        $("#amount").addClass('is-invalid');
                        $(".min").addClass('blink_me');
                        setTimeout(() => {
                            $("#amount").removeClass('is-invalid');
                            $(".min").removeClass('blink_me');
                        }, 2000);
                    }else{
                        $("#second-step").fadeOut('fast');
                        setTimeout(() => {
                            var text = `${Cookies.get('payment')}
                            <span class="">Processing Time: ${Cookies.get('processing')}</span>
                            <span class="">Fee: USD ${Cookies.get('fee')}</span>
                            <span class="min">USD ${Cookies.get('min')} - ${Cookies.get('max')}</span>`;
                            $(".third-step .img").css("background-image", `url(${Cookies.get('image')})`);
                            $(".third-step .title").html(text);
                            $("#third-step").fadeIn('fast');
                            $("#third-step #amount").text($("#amount").val());
                            Cookies.set('amount', $("#amount").val());
                            $("#third-step #account-name").text(Cookies.get('account-name'));
                            $("#third-step #account-number").text(Cookies.get('account-number'));
                            $("#transaction").attr('placeholder',Cookies.get('transaction'));
                            $("#third-step #transaction-example").text(Cookies.get('transaction-example'));
                            $("#third-step #description").text(Cookies.get('description'));
                        }, 200);

                    }
                }else{
                    $("#amount").addClass('is-invalid');
                    setTimeout(() => {
                        $("#amount").removeClass('is-invalid');
                    }, 1000);
                }
            }
            function forthStep(){
                //final submit
                var btn = $("#btn_forthStep");
                var payment = Cookies.get('payment');
                var amount = Cookies.get('amount');
                var transaction = $("#transaction").val();
                btn.prop("disabled",true);
                $.ajax({
                    url: '/deposit',
                    method: 'post',
                    data: {
                        "_token": $("meta[name='csrf-token']").attr('content'),
                        "payment": payment,
                        "amount": amount,
                        "transaction": transaction,
                    },
                    success: function(data){
                        if(data.code === 200){
                            Toast.fire({
                                icon: 'success',
                                title: data.message,
                                position: 'top'
                            });
                            setTimeout(()=>{window.location.href = '/transactions'},2000);
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: data.message,
                                position: 'top'
                            });
                            setTimeout(() => {
                                btn.prop("disabled",false);   
                            }, 500);
                        }
                    },
                    error: function(error){
                        console.error(error);
                    }
                })

            }
            function validation(){
                var tran_input = $("#transaction");
                var tran = $("#transaction").val();
                var exam = $("#transaction-example");
                var payment = Cookies.get('payment');
                var btn = $("#btn_forthStep");
                tran_input.keyup(function(){
                    if(payment === 'ABA Bank Transfer'){
                        var tran = tran_input.val();
                        if(tran.length < 16){
                            tran_input.addClass('is-invalid');
                            exam.addClass('blink_me');
                        }else{
                            btn.prop("disabled",false);
                            tran_input.removeClass('is-invalid');
                            tran_input.addClass('is-valid');
                            exam.removeClass('blink_me');
                        }

                    }else if( payment === 'Wing'){
                        var regExp = /^[a-zA-Z]+$/;
                        var Integer = /^\d+$/;
                        var tran = tran_input.val();
                        if(tran.length < 9){
                            tran_input.addClass('is-invalid');
                            exam.addClass('blink_me');
                        }else{
                            var str = tran.substring(0, 3);
                            if(regExp.test(str)){
                                var number = tran.slice(-6);
                                if(Integer.test(number)){
                                    //Success Validation
                                    btn.prop("disabled",false);
                                    tran_input.removeClass('is-invalid');
                                    tran_input.addClass('is-valid');
                                    exam.removeClass('blink_me');
                                }else{
                                    tran_input.addClass('is-invalid');
                                    exam.addClass('blink_me');
                                }
                            } else {
                                tran_input.addClass('is-invalid');
                                exam.addClass('blink_me');
                            }
                        }
                    }
                });
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
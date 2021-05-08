@extends('dashboard.app')
@section('dashboard-content')
<div class="nav-scroller shadow-sm">
<nav class="nav nav-underline" aria-label="Secondary navigation">
    <a class="nav-link" href="#"><i class="me-1 fas fa-hand-holding-usd"></i>Deposit</a>
    <a class="nav-link" href="#"><i class="me-1 fas fa-dollar-sign"></i>Withdraw</a>
    <a class="nav-link active" href="#"><span class="me-1 fa fa-funnel-dollar"></span> Transactions</a>
    <a class="nav-link" href="#"><span class="me-1 fa fa-money-check-alt"></span>Bank Accounts</a>
</nav>
</div>
    <div class="container py-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-12 col-md-9">
                        <div class="table-responsive">
                            <table class="table table table-striped">
                                <thead>
                                    <th>Reference No</th>
                                    <th>Method/Mode</th>
                                    <th>Amount(USD)</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @foreach ($credits as $credit)
                                        <tr>
                                            <td>
                                                <span class="small text-muted d-block">
                                                    {{ $credit->created_at->diffForHumans() }}
                                                </span>
                                                <span class="text-muted x-small">{{ Str::upper($credit->requestId) }}</span>
                                            </td>
                                            <td>{{ $credit->payment }}
                                                <span class="text-muted x-small d-block">Deposit</span>
                                            </td>
                                            <td>USD {{ number_format($credit->outStandingCredit,2) }}</td>
                                            <td>@if($credit->status) <span class="text-success">Success</span> @else <span class="text-muted">Pending</span> @endif</td>
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
                var transaction = Cookies.get('transaction');
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
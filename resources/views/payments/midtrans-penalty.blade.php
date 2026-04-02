@extends('layouts.front')
@section('content')
<div class="container py-5 text-center">
    <h3 class="mb-3">Menghubungkan ke Midtrans…</h3>
    <p>Mohon tunggu, jangan tutup halaman ini.</p>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            console.log('Payment success:', result);
            window.location.href = "{{ route('payments.penalty.midtrans.success', $return->id) }}";
        },
        onPending: function(result){
            console.log('Payment pending:', result);
            window.location.href = "{{ route('payments.penalty.midtrans.pending', $return->id) }}";
        },
        onError: function(result){
            console.error('Payment error:', result);
            window.location.href = "{{ route('payments.penalty.midtrans.error', $return->id) }}";
        },
        onClose: function(){
            alert('Pembayaran dibatalkan');
            window.location.href = "{{ route('payments.penalty.create', $return->id) }}";
        }
    });
</script>
@endsection
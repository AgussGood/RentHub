@extends('layouts.front')
@section('content')
<div class="container py-5 text-center">
    <h3 class="mb-3">Menghubungkan ke Midtrans...</h3>
    <p>Mohon tunggu, jangan tutup halaman ini.</p>
    <div class="spinner-border text-primary mt-3" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    // ✅ Debug logging
    console.log('=== MIDTRANS SNAP DEBUG ===');
    console.log('Snap Token:', '{{ $snapToken }}');
    console.log('Booking ID:', '{{ $booking->id }}');
    console.log('Order ID:', '{{ $orderId ?? "N/A" }}');
    
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            console.log('✅ Payment Success!', result);
            console.log('Transaction Status:', result.transaction_status);
            console.log('Order ID:', result.order_id);
            
            window.location.href = "{{ route('payments.midtrans.success', $booking->id) }}";
        },
        onPending: function(result){
            console.log('⏳ Payment Pending', result);
            window.location.href = "{{ route('payments.midtrans.pending', $booking->id) }}";
        },
        onError: function(result){
            console.log('❌ Payment Error', result);
            window.location.href = "{{ route('payments.midtrans.error', $booking->id) }}";
        },
        onClose: function(){
            console.log('🚪 Payment popup closed');
            alert('Pembayaran dibatalkan');
            window.location.href = "{{ route('payments.create', $booking->id) }}";
        }
    });
</script>
@endsection
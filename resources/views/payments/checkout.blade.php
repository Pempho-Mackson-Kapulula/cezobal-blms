<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SECURE CHECKOUT | CEZOBAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-white min-h-screen flex items-center justify-center font-sans">

    <div class="text-center space-y-6 p-8">
        <div class="relative w-24 h-24 mx-auto mb-8">
            <div class="absolute inset-0 border-4 border-zinc-900 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-red-600 rounded-full border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <h1 class="text-4xl font-black uppercase tracking-tighter italic">SECURE <span class="text-red-600">PORTAL</span></h1>
        <p class="text-zinc-500 text-[10px] font-black uppercase tracking-[0.4em] animate-pulse">
            Redirecting to PayChangu Gateway...
        </p>

        <form id="paychanguForm" method="POST" action="https://api.paychangu.com/hosted-payment-page">
            @csrf
            <input type="hidden" name="public_key" value="{{ env('PAYCHANGU_PUBLIC_KEY') }}">
            <input type="hidden" name="callback_url" value="{{ route('payment.callback') }}">
            <input type="hidden" name="return_url" value="{{ route('payment.complete') }}">
            <input type="hidden" name="tx_ref" value="{{ $payment->tx_ref }}">
            <input type="hidden" name="amount" value="{{ $payment->amount }}">
            <input type="hidden" name="currency" value="MWK">
            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
            <input type="hidden" name="first_name" value="{{ auth()->user()->name }}">
            <input type="hidden" name="title" value="{{ ucfirst($payment->payment_type) }} Payment">
            <input type="hidden" name="description" value="Team {{ $payment->team->name }} {{ ucfirst($payment->payment_type) }} Fee">
        </form>
    </div>

    <script>
        // Small delay to let the user see the transition
        setTimeout(() => {
            document.getElementById('paychanguForm').submit();
        }, 1200);
    </script>
</body>
</html>
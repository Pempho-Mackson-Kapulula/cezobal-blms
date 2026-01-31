<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANSACTION FAILED | CEZOBAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-white min-h-screen flex items-center justify-center font-sans p-6">

    <div class="max-w-md w-full bg-zinc-900 border-2 border-zinc-800 rounded-3xl p-10 text-center shadow-2xl relative overflow-hidden">
        <!-- Error Theme Background Glow -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-red-600/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <!-- Warning Icon with Pulsing Red Shadow -->
            <div class="w-20 h-20 bg-zinc-800 border-2 border-red-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_30px_rgba(220,38,38,0.2)]">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <!-- Dashboard Matching Typography -->
            <h1 class="text-3xl font-black uppercase tracking-tighter italic mb-2">PAYMENT <span class="text-red-600">FAILED</span></h1>
            <p class="text-zinc-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 leading-relaxed">
                The transaction could not be completed. Please check your balance or try a different payment method.
            </p>

            <div class="space-y-3">
                <!-- Retry Button -->
                <a href="{{ route('checkout', ['payment' => $payment_id ?? 1]) }}" 
                   class="block w-full py-4 bg-red-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-red-500 transition-all active:scale-95 shadow-lg shadow-red-900/20">
                    Try Again
                </a>

                <!-- Secondary Back Button -->
                <a href="{{ route('team-manager.dashboard') }}" 
                   class="block w-full py-4 bg-transparent border-2 border-zinc-800 text-zinc-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-zinc-800 hover:text-white transition-all">
                    Return to Dashboard
                </a>
                
                <div class="pt-6">
                    <div class="h-px w-12 bg-zinc-800 mx-auto mb-4"></div>
                    <p class="text-[9px] text-zinc-600 font-black uppercase tracking-[0.4em] italic">
                        Central Zone Basketball League Support
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

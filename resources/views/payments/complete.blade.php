<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANSACTION COMPLETE | CEZOBAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-950 text-white min-h-screen flex items-center justify-center font-sans p-6">

    <div class="max-w-md w-full bg-zinc-900 border-2 border-zinc-800 rounded-3xl p-10 text-center shadow-2xl relative overflow-hidden">
        <!-- Thematic Background Glow -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-red-600/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <!-- Icon with Red Shadow -->
            <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-[0_0_30px_rgba(220,38,38,0.4)]">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Typography matching your Team Finance Dashboard -->
            <h1 class="text-3xl font-black uppercase tracking-tighter italic mb-2">PAYMENT <span class="text-red-600">CONFIRMED</span></h1>
            <p class="text-zinc-500 text-[10px] font-black uppercase tracking-[0.3em] mb-8 leading-relaxed">
                Transaction Verified. Your team is officially cleared for the next stage of the tournament.
            </p>

            <div class="space-y-3">
                <!-- High-Contrast Button -->
                <a href="{{ route('team-manager.dashboard') }}" 
                   class="block w-full py-4 bg-white text-black text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-red-600 hover:text-white transition-all active:scale-95 shadow-lg shadow-white/5">
                    Return to Dashboard
                </a>
                
                <!-- Admin Tagline -->
                <div class="pt-6">
                    <div class="h-px w-12 bg-zinc-800 mx-auto mb-4"></div>
                    <p class="text-[9px] text-zinc-600 font-black uppercase tracking-[0.4em] italic">
                        Central Zone Basketball League
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

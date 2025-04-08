<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="margin: 0; padding: 0; overflow: hidden;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
/* Loader Container */
.loader-container {
    display: flex;
    flex-direction: column; /* Stack logo and wave loader */
    align-items: center;
    justify-content: center;
    position: fixed;
    width: 100%;
    height: 100vh;
    background-color: rgba(255, 255, 255, 0.788); /* Light background */
    z-index: 9999;
}

/* Logo with Waving Letters */
.logo {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Reduce Animation Duration */
.letter {
    width: 40px;
    height: auto;
    animation: waveLetter 1s ease-in-out infinite alternate; /* Reduced from 1.5s to 1s */
}

/* Waving Effect (Faster) */
@keyframes waveLetter {
    0% { transform: translateY(0); }
    50% { transform: translateY(-8px); } /* Reduced bounce height */
    100% { transform: translateY(0); }
}

/* Adjust Letter Animation Delays (Tighter Timing) */
.letter:nth-child(1) { animation-delay: 0s; }
.letter:nth-child(2) { animation-delay: 0.15s; } /* Faster stagger */
.letter:nth-child(3) { animation-delay: 0.3s; }
.letter:nth-child(4) { animation-delay: 0.45s; }
.letter:nth-child(5) { animation-delay: 0.6s; }
.letter:nth-child(6) { animation-delay: 0.75s; }

/* Wave Loader */
.center {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px; /* Add space below letters */
}

/* Wave Loader (Faster) */
/* Wave Loader with Custom Gradient */
.waveLoader {
    width: 8px;
    height: 35px;
    background: linear-gradient(to bottom, #102B3C, #ED1C24); /* Gradient Effect */
    margin: 9px;
    animation: waveMove 0.5s infinite ease-in-out;
    border-radius: 4px; /* Smooth rounded edges */
}


.letter.i {
    width: 13px; /* Adjust the size */
    height: auto;
}


/* Wave Animation */
@keyframes waveMove {
    0%, 100% { transform: scaleY(1); }
    50% { transform: scaleY(1.3); }
}


/* Faster Staggered Animation for Wave Loader */
.waveLoader:nth-child(1) { animation-delay: 0s; }
.waveLoader:nth-child(2) { animation-delay: 0.08s; } /* Reduced delays */
.waveLoader:nth-child(3) { animation-delay: 0.16s; }
.waveLoader:nth-child(4) { animation-delay: 0.24s; }
.waveLoader:nth-child(5) { animation-delay: 0.32s; }
.waveLoader:nth-child(6) { animation-delay: 0.4s; }
.waveLoader:nth-child(7) { animation-delay: 0.48s; }
.waveLoader:nth-child(8) { animation-delay: 0.56s; }


/* Adjusted Scale for Wave Animation */
@keyframes waveMove {
    0%, 100% { transform: scaleY(1); }
    50% { transform: scaleY(2.0); } /* Slightly smaller */
}

@keyframes fadeIn {
    0% { opacity: 0.3; }
    100% { opacity: 1; }
}


    </style>
</head>
<body class="bg-gray-100 min-h-screen flex" onload="hideLoader()">
    <!-- Loader -->
    <div class="loader-container" id="odc-loader">
        <div class="logo">
            <img src="{{ asset('images/o.png') }}" class="letter">
            <img src="{{ asset('images/d.png') }}" class="letter">
            <img src="{{ asset('images/e.png') }}" class="letter">
            <img src="{{ asset('images/c.png') }}" class="letter">
            <img src="{{ asset('images/c.png') }}" class="letter">
            <img src="{{ asset('images/i.png') }}" class="letter i">

        </div>
    
        <div class="center">
            <div class="waveLoader"></div>
            <div class="waveLoader"></div>
            <div class="waveLoader"></div>
            <div class="waveLoader"></div>
            <div class="waveLoader"></div>
            <div class="waveLoader"></div>
            <div class="waveLoader"></div>
            <div class="waveLoader"></div>
        </div>
    </div>
    
    
    
    <!-- Main Content -->
    <main class="w-full h-full max-w-[calc(100vw)] max-h-[calc(100vh-1rem)] overflow-auto">
        @yield('content')
    </main>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
    let loader = document.getElementById("odc-loader");

    // Show loader on page refresh
    loader.style.display = "flex";

    // Hide after 2 seconds (adjust time as needed)
    setTimeout(() => {
        loader.style.display = "none";
    }, 1300);
});

    </script>
    
</body>
</html>

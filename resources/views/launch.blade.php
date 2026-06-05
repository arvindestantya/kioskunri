<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Peresmian Peluncuran Aplikasi</title>
  <meta name="description" content="Halaman tombol peresmian sandi." />
    <link rel="stylesheet" href="{{ secure_asset('css/style-logo-launch.css') }}" /></head>
<body>
  <header class="header">
     <div class="logo-container">
      <img src="{{ secure_asset('img/Logo-Unri-tek-putih.png') }}" alt="Logo UNRI" class="header-logo" />
      <img src="{{ secure_asset('img/63unri.png') }}" alt="Logo UNRI" class="header-logo" />
      <img src="{{ secure_asset('img/dikti-blu.png') }}" alt="Logo UNRI" class="header-logo" />
    </div>
  </header>

  <main class="stage" role="main" aria-label="Halaman Peresmian">
    <h1 class="headline">Peresmian Peluncuran Logo</h1>
    <p class="subtitle">Sentuh tombol di bawah untuk meresmikan</p>

    <button id="launchButton" class="launch-button" aria-label="Tombol Peresmian">
      <span class="label">Resmikan</span>
    </button>


  </main>
  <div id="launchedOverlay" class="overlay sparkling" aria-hidden="true">
    <canvas id="fxCanvas"></canvas>

    <div id="countdown" class="countdown" aria-live="polite" aria-atomic="true"></div>
    <div class="overlay-content">
      <img id="appLogo" class="app-logo" src="{{ secure_asset('img/unrimilad63.png') }}" alt="Logo Aplikasi" aria-hidden="true" />
    </div>
  </div>
  <a href="/sandi-launch" class="next-button" aria-label="Lanjut ke halaman berikutnya">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M5 12h14"></path>
      <path d="M12 5l7 7-7 7"></path>
    </svg>
  </a>
<script src="{{ asset('js/logo-launch.js') }}"></script>
</body>
</html>

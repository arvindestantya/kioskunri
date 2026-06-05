<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Peresmian Peluncuran Aplikasi</title>
  <meta name="description" content="Halaman tombol peresmian sandi." />
    <link rel="stylesheet" href="{{ secure_asset('css/style-launch2.css') }}" /></head>
<body>
  <header class="header">
     <div class="logo-container">
      <img src="{{ secure_asset('img/Logo-Unri-tek-putih.png') }}" alt="Logo UNRI" class="header-logo" />
      <img src="{{ secure_asset('img/Logo-UPA-TIK color-teks white.png') }}" alt="Logo UNRI" class="header-logo" />
      <img src="{{ secure_asset('img/63unri.png') }}" alt="Logo UNRI" class="header-logo" />
      <img src="{{ secure_asset('img/dikti-blu.png') }}" alt="Logo UNRI" class="header-logo" />
    </div>
  </header>

  <main class="stage" role="main" aria-label="Halaman Peresmian">
    <h1 class="headline">Peresmian Peluncuran Aplikasi</h1>
    <p class="subtitle">Sentuh tombol di bawah untuk meresmikan</p>

    <button id="launchButton" class="launch-button" aria-label="Tombol Peresmian">
      <span class="label">Resmikan</span>
    </button>


  </main>
  <div id="launchedOverlay" class="overlay sparkling" aria-hidden="true">
    <canvas id="fxCanvas"></canvas>

    <div id="countdown" class="countdown" aria-live="polite" aria-atomic="true"></div>
    <div class="overlay-content">
      <img id="appLogo" class="app-logo" src="{{ secure_asset('img/Logo-Sandi-2.png') }}" alt="Logo Aplikasi" aria-hidden="true" />
      <!-- <p>Sistem Autentikasi dan Digitalisasi Ijazah</p> -->
      <div class="burst"></div>
      <h2>Sistem Autentikasi dan Digitalisasi Ijazah<br>Resmi Diluncurkan</h2>
      <p>Selamat kepada Rektor dan seluruh tim!</p>
    </div>
  </div>
<script src="{{ asset('js/launch.js') }}"></script>
</body>
</html>

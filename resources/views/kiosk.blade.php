<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Kiosk - {{ $faculty->name }}</title>
    <link rel="icon" href="{{ secure_asset('img/logo-type-warna-tulisan-hitam-1.png') }}">

    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/globals.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/styleguide.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/form.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/success-modal.css') }}" />
</head>
<body>
    <div class="KIOSK-UNRI">
      <div class="kiosk-layout"
           x-data="{ 
              facultyId: {{ $faculty->id }},
              flyers: {{ $flyers->pluck('path')->toJson() }},
              activeIndex: 0, 
              flyerKey: 1,
              get imageCount() { return this.flyers.length },
              isLightboxOpen: false,
              lightboxIndex: 0,
              isFormOpen: false,
              isFeedbackOpen: false,
              isSuccessOpen: false,

              startSlider() {
                  if (this.imageCount > 1) {
                      this.sliderInterval = setInterval(() => {
                          this.activeIndex = (this.activeIndex + 1) % this.imageCount;
                      }, 3000);
                  }
              }
          }"
          x-init="startSlider()">

        <div class="menu">
          <header class="header">
            <div class="logo-dan-nama">
              <img class="logo-type-warna" src="{{ secure_asset('img/logo-type-warna-tulisan-hitam-1.png') }}" />
              <img class="vector" src="{{ secure_asset('img/vector-1.svg') }}" />
              <div class="text-wrapper">{{ $faculty->name }}</div>
            </div>
            <div class="frame">
              <img class="image" src="{{ secure_asset('img/image-3.png') }}" /> <img class="dikti" src="{{ secure_asset('img/dikti-saintekberdampak-1.png') }}" />
            </div>
          </header>
          
          <div class="content">
            <a href="#" class="card-link" @click.prevent="isFormOpen = true"><figure class="frame-3"><img class="img" src="{{ secure_asset('img/image-4.png') }}" alt="Buku Tamu icon"><figcaption>Buku<br>Tamu</figcaption></figure></a>
            <a href="#" class="card-link"><figure class="frame-4"><img class="img" src="{{ secure_asset('img/image-6.png') }}" alt="Statistik Pengunjung icon"><figcaption>Statistik<br>Pengunjung</figcaption></figure></a>
            <a href="#" class="card-link"><figure class="frame-5"><img class="img" src="{{ secure_asset('img/image-7.png') }}" alt="Denah Lokasi icon"><figcaption>Denah Lokasi Fakultas</figcaption></figure></a>
            <a href="#" class="card-link"><figure class="frame-6"><img class="image-2" src="{{ secure_asset('img/image.png') }}" alt="Pengumuman Fakultas icon"><figcaption>Pengumuman<br>Fakultas</figcaption></figure></a>
            <a href="#" class="card-link"><figure class="frame-7"><img class="img" src="{{ secure_asset('img/image-13.png') }}" alt="Kegiatan Fakultas icon"><figcaption>Kegiatan<br>Fakultas</figcaption></figure></a>
            <a href="#" class="card-link"><figure class="frame-8"><img class="img" src="{{ secure_asset('img/image-12.png') }}" alt="Jadwal Penting icon"><figcaption>Jadwal<br>Penting</figcaption></figure></a>
            <a href="#" class="card-link"><figure class="frame-9"><img class="img" src="{{ secure_asset('img/image-14.png') }}" alt="Kontak Informasi icon"><figcaption>Kontak<br>Informasi</figcaption></figure></a>
            <a href="#" class="card-link" @click.prevent="isFeedbackOpen = true"><figure class="frame-10"><img class="img" src="{{ secure_asset('img/image-15.png') }}" alt="Kritik dan Saran icon"><figcaption>Kritik dan<br>Saran</figcaption></figure></a>
            <div class="frame-11"></div>
          </div>

          <footer class="footer">
            <div class="overlap-group"><div class="text-wrapper-4">Copyright @ Universitas Riau</div></div>
          </footer>
        </div>

        <div class="overlap">
          <template x-for="(path, index) in flyers" :key="index">
              <div class="flyer-item" x-show="activeIndex === index" x-transition.opacity.duration.1000ms x-cloak @click="isLightboxOpen = true; lightboxIndex = activeIndex">
                  <img class="flyer-bg-image" :src="'/storage/' + path" alt="">
                  <img class="flyer-fg-image" :src="'/storage/' + path" :alt="'Flyer Image ' + (index + 1)">
              </div>
          </template>

          <div class="flyer-dots" x-show="imageCount > 1">
              <template x-for="(path, index) in flyers" :key="index">
                  <div class="dot" :class="{ 'active': activeIndex === index }"></div>
              </template>
          </div>
          
          <div class="lightbox-overlay" x-show="isLightboxOpen" @keydown.escape.window="isLightboxOpen = false" @click.self="isLightboxOpen = false" x-transition.opacity.duration.300ms x-cloak>
              <button class="lightbox-close-button" @click="isLightboxOpen = false">×</button>
              <div x-show="imageCount > 1">
                <button class="lightbox-nav-button prev" @click="lightboxIndex = (lightboxIndex - 1 + imageCount) % imageCount">‹</button>
                <button class="lightbox-nav-button next" @click="lightboxIndex = (lightboxIndex + 1) % imageCount">›</button>
              </div>
              <div class="lightbox-content">
                  <template x-for="(path, index) in flyers" :key="index">
                      <div x-show="lightboxIndex === index" class="lightbox-image-wrapper"><img :src="'/storage/' + path" :alt="'Flyer Image ' + (index + 1) + ' in lightbox'"></div>
                  </template>
              </div>
          </div>

          <div class="form-modal-overlay" x-show="isFormOpen" @keydown.escape.window="isFormOpen = false" @click.self="isFormOpen = false" x-transition:enter.opacity.duration.300ms x-transition:leave.opacity.duration.300ms x-cloak>
              <main class="form" x-show="isFormOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                  <header class="headline">
                      <h1 class="frame"><span class="text-wrapper">Selamat Datang di {{ $faculty->name }}</span></h1>
                      <button class="close-button" aria-label="Tutup formulir" @click="isFormOpen = false"><img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" /></button>
                  </header>
                  <form class="input-field" 
                        @submit.prevent="
                            const formElement = $el;
                            const formData = new FormData(formElement);
                            
                            // INI ADALAH BAGIAN YANG DIPERBAIKI
                            fetch(`/api/faculties/${$data.facultyId}/guests`, {
                                method: 'POST',
                                body: formData,
                                headers: { 'Accept': 'application/json' }
                            })
                            .then(response => {
                                if (response.ok) {
                                    formElement.reset();
                                    isFormOpen = false;
                                    isSuccessOpen = true;
                                    setTimeout(() => { isSuccessOpen = false }, 3000);
                                } else {
                                    response.json().then(data => {
                                        console.error('Validation errors:', data.errors);
                                        let errorMessages = 'Gagal menyimpan data:\n';
                                        for (const key in data.errors) { errorMessages += `- ${data.errors[key][0]}\n`; }
                                        alert(errorMessages);
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Network Error:', error);
                                alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                            });
                        ">
                      <div class="input"><label for="nama" class="form-label">Nama</label><div class="field"><input id="nama" name="nama" class="content text-wrapper-2" type="text" placeholder="Ketik nama kamu di sini" required autocomplete="off" /></div></div>
                      <div class="input"><label for="handphone" class="form-label">No. Handphone</label><div class="field"><input id="handphone" name="no_handphone" class="content text-wrapper-2" type="tel" placeholder="Ketik No. HP kamu di sini" required autocomplete="off" /></div></div>
                      <div class="input"><label for="email" class="form-label">Email</label><div class="field"><input id="email" name="email" class="content-2" type="email" placeholder="Ketik email kamu di sini" required autocomplete="off" /></div></div>
                      <div class="input"><label for="jenis-pengunjung" class="form-label">Jenis Pengunjung</label><div class="field"><select id="jenis-pengunjung" name="jenis_pengunjung" class="content text-wrapper-2" required autocomplete="off"><option value="" disabled selected>Pilih Jenis Pengunjung</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="tendik">Tendik</option>
                        <option value="umum">Umum</option>
                        </select><img class="img" src="{{ secure_asset('img/dropdown.svg') }}" alt="Dropdown icon" aria-hidden="true" /></div>
                      </div>
                      <div class="input"><label for="perihal" class="form-label">Perihal</label><div class="field-2"><textarea id="perihal" name="perihal" class="content text-wrapper-2" placeholder="Ketik perihal kunjungan kamu" required autocomplete="off"></textarea></div></div>
                      <button type="submit" class="button"><div class="containt"><span class="label">Simpan</span></div></button>
                  </form>
              </main>
          </div>

          <div class="form-modal-overlay" x-show="isFeedbackOpen" @keydown.escape.window="isFeedbackOpen = false" @click.self="isFeedbackOpen = false" x-transition:enter.opacity.duration.300ms x-transition:leave.opacity.duration.300ms x-cloak>
            <main class="form" x-show="isFeedbackOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
              <header class="headline">
                <h1 class="frame"><span class="text-wrapper">Kritik & Saran</span></h1>
                <button class="close-button" aria-label="Tutup formulir" @click="isFeedbackOpen = false">
                  <img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" />
                </button>
              </header>
              <form class="input-field"
                    @submit.prevent="
                        const formElement = $el;
                        const formData = new FormData(formElement);

                        fetch(`/api/faculties/${$data.facultyId}/feedbacks`, {
                            method: 'POST',
                            body: formData,
                            headers: { 'Accept': 'application/json' }
                        })
                        .then(response => {
                            if (response.ok) {
                                formElement.reset();
                                isFeedbackOpen = false;
                                isSuccessOpen = true;
                                setTimeout(() => { isSuccessOpen = false }, 3000);
                            } else {
                                response.json().then(data => {
                                    console.error('Validation errors:', data.errors);
                                    let errorMessages = 'Gagal menyimpan data:\n';
                                    for (const key in data.errors) {
                                        errorMessages += `- ${data.errors[key][0]}\n`;
                                    }
                                    alert(errorMessages);
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Network Error:', error);
                            alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                        });
                    ">
                <div class="input">
                  <label for="nama-feedback" class="form-label">Nama</label>
                  <div class="field">
                    <input id="nama-feedback" name="nama" class="content text-wrapper-2" type="text" placeholder="Ketik nama kamu" required autocomplete="off" />
                  </div>
                </div>
                <div class="input">
                  <label for="kritik" class="form-label">Kritik</label>
                  <div class="field-2">
                    <textarea id="kritik" name="kritik" class="content text-wrapper-2" placeholder="Ketik kritik di sini" required autocomplete="off"></textarea>
                  </div>
                </div>
                <div class="input">
                  <label for="saran" class="form-label">Saran</label>
                  <div class="field-2">
                    <textarea id="saran" name="saran" class="content text-wrapper-2" placeholder="Ketik saran di sini" required autocomplete="off"></textarea>
                  </div>
                </div>
                <button type="submit" class="button">
                  <div class="containt"><span class="label">Kirim</span></div>
                </button>
              </form>
            </main>
          </div>

          
          <div class="success-modal-overlay" x-show="isSuccessOpen" x-transition:enter.opacity.duration.300ms x-transition:leave.opacity.duration.300ms x-cloak>
              <div class="success-modal-container" x-show="isSuccessOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                <img src="{{ secure_asset('img/32.png') }}" alt="Success Icon" class="success-modal-icon">
                <div class="success-modal-headline-wrapper">
                  <h2 class="success-modal-headline-text">Data kamu berhasil disimpan</h2>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
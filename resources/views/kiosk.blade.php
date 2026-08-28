<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Kiosk - {{ $faculty->name }}</title>
    <link rel="icon" href="{{ secure_asset('img/logo-type-warna-tulisan-hitam-1.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ secure_asset('css/app4.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/globals.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/styleguide.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/form9.css') }}" />
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
              isSurveyOpen: false,  // State untuk modal survei baru
              isContactModalOpen: false,
              isScheduleModalOpen: false,
              isMapModalOpen: false,
              isPPIDOpen: false,
              mapSliderIndex: 0,
              surveyRating: 0,
              hoverRating: 0,
              isStatsModalOpen: false,
              isAnnouncementModalOpen: false,
              isEventModalOpen: false,
              isMalPelayananOpen: false,
              jenisPengunjung: null,
              selectedChoice: null,
              caraMemperoleh: '',
              caraMendapatkan: '',
              alasanKeberatan: '',

              startSlider() {
                  if (this.imageCount > 1) {
                      this.sliderInterval = setInterval(() => {
                          this.activeIndex = (this.activeIndex + 1) % this.imageCount;
                      }, 5000);
                  }
              }
          }"
          x-init="startSlider()">

        <div class="menu">
          <header class="header">
            <div class="logo-dan-nama">
              <img class="logo-type-warna" src="{{ secure_asset('img/logo-type-warna-tulisan-hitam-1.png') }}" />
              <div class="text-wrapper">{{ $faculty->name }}</div>
            </div>
            <div class="frame">
              <img class="image" src="{{ secure_asset('img/image-3.png') }}" /> <img class="dikti" src="{{ secure_asset('img/dikti-saintekberdampak-1.png') }}" />
            </div>
          </header>

          <div class="content">
            @switch($faculty->slug)
                @case('unit-penunjang-akademik-tik')
                    <a href="#" class="card-link" @click.prevent="isFormOpen = true"><figure class="frame-3"><img class="img" src="{{ secure_asset('img/image-4.png') }}" alt="Buku Tamu icon"><figcaption>Buku<br>Tamu</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isStatsModalOpen = true"><figure class="frame-4"><img class="img" src="{{ secure_asset('img/image-6.png') }}" alt="Statistik Pengunjung icon"><figcaption>Statistik<br>Pengunjung</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isMapModalOpen = true"><figure class="frame-5"><img class="img" src="{{ secure_asset('img/image-7.png') }}" alt="Denah Lokasi icon"><figcaption>Denah<br>Unit</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isAnnouncementModalOpen = true"><figure class="frame-6"><img class="image-2" src="{{ secure_asset('img/image.png') }}" alt="Pengumuman Fakultas icon"><figcaption>Pengumuman<br>Unit</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isPPIDOpen = true"><figure class="frame-7"><img class="img" src="{{ secure_asset('img/logo-ppid.png') }}" alt="Kegiatan Fakultas icon"><figcaption>PPID</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isScheduleModalOpen = true"><figure class="frame-8"><img class="img" src="{{ secure_asset('img/image-12.png') }}" alt="Jadwal Penting icon"><figcaption>Jadwal<br>Penting</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isContactModalOpen = true"><figure class="frame-9"><img class="img" src="{{ secure_asset('img/image-14.png') }}" alt="Kontak Informasi icon"><figcaption>Kontak<br>Informasi</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isFeedbackOpen = true"><figure class="frame-10"><img class="img" src="{{ secure_asset('img/image-15.png') }}" alt="Kritik dan Saran icon"><figcaption>Kritik dan<br>Saran</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isSurveyOpen = true"><figure class="frame-11"> <img class="img" src="{{ secure_asset('img/icon-survey.png') }}" alt="Survey Kepuasan icon"><figcaption>Survey<br>Kepuasan</figcaption></figure></a>
                    @break
                @case('badan-pengelola-usaha')
                    <a href="#" class="card-link" @click.prevent="isFormOpen = true"><figure class="frame-3"><img class="img" src="{{ secure_asset('img/image-4.png') }}" alt="Buku Tamu icon"><figcaption>Buku<br>Tamu</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isStatsModalOpen = true"><figure class="frame-4"><img class="img" src="{{ secure_asset('img/image-6.png') }}" alt="Statistik Pengunjung icon"><figcaption>Statistik<br>Pengunjung</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isMapModalOpen = true"><figure class="frame-5"><img class="img" src="{{ secure_asset('img/image-7.png') }}" alt="Denah Lokasi icon"><figcaption>Denah<br>BPU</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isAnnouncementModalOpen = true"><figure class="frame-6"><img class="image-2" src="{{ secure_asset('img/image.png') }}" alt="Pengumuman Fakultas icon"><figcaption>Pengumuman<br>BPU</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isPPIDOpen = true"><figure class="frame-7"><img class="img" src="{{ secure_asset('img/logo-ppid.png') }}" alt="Kegiatan Fakultas icon"><figcaption>PPID</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isScheduleModalOpen = true"><figure class="frame-8"><img class="img" src="{{ secure_asset('img/image-12.png') }}" alt="Jadwal Penting icon"><figcaption>Jadwal<br>Penting</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isContactModalOpen = true"><figure class="frame-9"><img class="img" src="{{ secure_asset('img/image-14.png') }}" alt="Kontak Informasi icon"><figcaption>Kontak<br>Informasi</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isFeedbackOpen = true"><figure class="frame-10"><img class="img" src="{{ secure_asset('img/image-15.png') }}" alt="Kritik dan Saran icon"><figcaption>Kritik dan<br>Saran</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isSurveyOpen = true"><figure class="frame-11"> <img class="img" src="{{ secure_asset('img/icon-survey.png') }}" alt="Survey Kepuasan icon"><figcaption>Survey<br>Kepuasan</figcaption></figure></a>
                    @break
                @case('rektorat')
                    <a href="#" class="card-link" @click.prevent="isFormOpen = true"><figure class="frame-3"><img class="img" src="{{ secure_asset('img/image-4.png') }}" alt="Buku Tamu icon"><figcaption>Buku<br>Tamu</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isStatsModalOpen = true"><figure class="frame-4"><img class="img" src="{{ secure_asset('img/image-6.png') }}" alt="Statistik Pengunjung icon"><figcaption>Statistik<br>Pengunjung</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isMapModalOpen = true"><figure class="frame-5"><img class="img" src="{{ secure_asset('img/image-7.png') }}" alt="Denah Lokasi icon"><figcaption>Denah<br>Rektorat</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isAnnouncementModalOpen = true"><figure class="frame-6"><img class="image-2" src="{{ secure_asset('img/image.png') }}" alt="Pengumuman Fakultas icon"><figcaption>Pengumuman<br>Rektorat</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isPPIDOpen = true"><figure class="frame-7"><img class="img" src="{{ secure_asset('img/logo-ppid.png') }}" alt="PPID icon"><figcaption>PPID</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isScheduleModalOpen = true"><figure class="frame-8"><img class="img" src="{{ secure_asset('img/image-12.png') }}" alt="Jadwal Penting icon"><figcaption>Jadwal<br>Penting</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isContactModalOpen = true"><figure class="frame-9"><img class="img" src="{{ secure_asset('img/image-14.png') }}" alt="Kontak Informasi icon"><figcaption>Kontak<br>Informasi</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isFeedbackOpen = true"><figure class="frame-10"><img class="img" src="{{ secure_asset('img/image-15.png') }}" alt="Kritik dan Saran icon"><figcaption>Kritik dan<br>Saran</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isSurveyOpen = true"><figure class="frame-11"> <img class="img" src="{{ secure_asset('img/icon-survey.png') }}" alt="Survey Kepuasan icon"><figcaption>Survey<br>Kepuasan</figcaption></figure></a>
                    @break
                @case('fakultas-ilmu-sosial-dan-ilmu-politik')
                    <a href="#" class="card-link" @click.prevent="isFormOpen = true"><figure class="frame-3"><img class="img" src="{{ secure_asset('img/image-4.png') }}" alt="Buku Tamu icon"><figcaption>Buku<br>Tamu</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isMalPelayananOpen = true"><figure class="frame-4"><img class="img" src="{{ secure_asset('img/image-99.png') }}" alt="Ambil Antrian icon"><figcaption>Mal Pelayanan<br>Publik</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isMapModalOpen = true"><figure class="frame-5"><img class="img" src="{{ secure_asset('img/image-7.png') }}" alt="Denah Lokasi icon"><figcaption>Denah<br>Fakultas</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isAnnouncementModalOpen = true"><figure class="frame-6"><img class="image-2" src="{{ secure_asset('img/image.png') }}" alt="Pengumuman Fakultas icon"><figcaption>Pengumuman<br>Fakultas</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isEventModalOpen = true"><figure class="frame-7"><img class="img" src="{{ secure_asset('img/image-13.png') }}" alt="Kegiatan Fakultas icon"><figcaption>Kegiatan<br>Fakultas</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isScheduleModalOpen = true"><figure class="frame-8"><img class="img" src="{{ secure_asset('img/image-12.png') }}" alt="Jadwal Penting icon"><figcaption>Jadwal<br>Penting</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isContactModalOpen = true"><figure class="frame-9"><img class="img" src="{{ secure_asset('img/image-14.png') }}" alt="Kontak Informasi icon"><figcaption>Kontak<br>Informasi</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isFeedbackOpen = true"><figure class="frame-10"><img class="img" src="{{ secure_asset('img/image-15.png') }}" alt="Kritik dan Saran icon"><figcaption>Kritik dan<br>Saran</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isSurveyOpen = true"><figure class="frame-11"> <img class="img" src="{{ secure_asset('img/icon-survey.png') }}" alt="Survey Kepuasan icon"><figcaption>Survey<br>Kepuasan</figcaption></figure></a>
                    @break
                @default
                    <a href="#" class="card-link" @click.prevent="isFormOpen = true"><figure class="frame-3"><img class="img" src="{{ secure_asset('img/image-4.png') }}" alt="Buku Tamu icon"><figcaption>Buku<br>Tamu</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isStatsModalOpen = true"><figure class="frame-4"><img class="img" src="{{ secure_asset('img/image-6.png') }}" alt="Statistik Pengunjung icon"><figcaption>Statistik<br>Pengunjung</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isMapModalOpen = true"><figure class="frame-5"><img class="img" src="{{ secure_asset('img/image-7.png') }}" alt="Denah Lokasi icon"><figcaption>Denah<br>Fakultas</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isAnnouncementModalOpen = true"><figure class="frame-6"><img class="image-2" src="{{ secure_asset('img/image.png') }}" alt="Pengumuman Fakultas icon"><figcaption>Pengumuman<br>Fakultas</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isEventModalOpen = true"><figure class="frame-7"><img class="img" src="{{ secure_asset('img/image-13.png') }}" alt="Kegiatan Fakultas icon"><figcaption>Kegiatan<br>Fakultas</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isScheduleModalOpen = true"><figure class="frame-8"><img class="img" src="{{ secure_asset('img/image-12.png') }}" alt="Jadwal Penting icon"><figcaption>Jadwal<br>Penting</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isContactModalOpen = true"><figure class="frame-9"><img class="img" src="{{ secure_asset('img/image-14.png') }}" alt="Kontak Informasi icon"><figcaption>Kontak<br>Informasi</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isFeedbackOpen = true"><figure class="frame-10"><img class="img" src="{{ secure_asset('img/image-15.png') }}" alt="Kritik dan Saran icon"><figcaption>Kritik dan<br>Saran</figcaption></figure></a>
                    <a href="#" class="card-link" @click.prevent="isSurveyOpen = true"><figure class="frame-11"> <img class="img" src="{{ secure_asset('img/icon-survey.png') }}" alt="Survey Kepuasan icon"><figcaption>Survey<br>Kepuasan</figcaption></figure></a>
            @endswitch
          </div>

          <footer class="footer">
            <div class="overlap-group"><div class="text-wrapper-4">Copyright @ UPA TIK Universitas Riau</div></div>
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

        <div class="form-modal-overlay" x-show="isFormOpen" x-transition:enter.opacity.duration.300ms x-transition:leave.opacity.duration.300ms x-cloak>

            <main class="form" x-data="guestForm()" x-show="isFormOpen"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">

                <header class="headline">
                    <h1 class="frame"><span class="text-wrapper">Selamat Datang di {{ $faculty->name }}</span></h1>
                    <button class="close-button" aria-label="Tutup formulir" @click="isFormOpen = false; resetForm()"><img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" /></button>
                </header>

                <form class="input-field" @submit.prevent="submitForm">

                    <div class="input">
                        <label class="form-label">Jenis Pengunjung</label>
                        <div class="field flex items-center gap-x-6 py-2">
                            <div class="flex items-center">
                                <input x-model="formData.jenis_pengunjung" type="radio" id="jenis-mahasiswa" name="jenis_pengunjung" value="mahasiswa" class="radio-input" required>
                                <label for="jenis-mahasiswa" class="radio-label ml-2">Mahasiswa</label>
                            </div>
                            <div class="flex items-center">
                                <input x-model="formData.jenis_pengunjung" type="radio" id="jenis-dosen" name="jenis_pengunjung" value="dosen" class="radio-input" required>
                                <label for="jenis-dosen" class="radio-label ml-2">Dosen</label>
                            </div>
                            <div class="flex items-center">
                                <input x-model="formData.jenis_pengunjung" type="radio" id="jenis-tendik" name="jenis_pengunjung" value="tendik" class="radio-input" required>
                                <label for="jenis-tendik" class="radio-label ml-2">Tendik</label>
                            </div>
                            <div class="flex items-center">
                                <input x-model="formData.jenis_pengunjung" type="radio" id="jenis-umum" name="jenis_pengunjung" value="umum" class="radio-input" required @click="resetForPublicVisitor()">
                                <label for="jenis-umum" class="radio-label ml-2">Umum</label>
                            </div>
                        </div>
                    </div>

                    <template x-if="['tendik'].includes(formData.jenis_pengunjung)">
                        <div x-transition>
                            <div class="input">
                                <label for="no_identitas" class="form-label" x-text="formData.jenis_pengunjung === 'mahasiswa' ? 'NIM' : formData.jenis_pengunjung === 'dosen' ? 'NUPTK' : 'NIP'"></label>
                                <div class="field">
                                    <input id="no_identitas" name="no_identitas" x-model="formData.no_identitas" @blur="searchGuest" class="content text-wrapper-2" type="tel"
                                        :placeholder="formData.jenis_pengunjung === 'mahasiswa' ? 'Ketik NIM lalu keluar dari kolom ini' : formData.jenis_pengunjung === 'dosen' ? 'Ketik NUPTK lalu keluar dari kolom ini' : 'Ketik NIP lalu keluar dari kolom ini'"
                                        :required="['tendik'].includes(formData.jenis_pengunjung)" autocomplete="off" pattern="[0-9]+" title="Hanya boleh diisi angka." maxlength="20">
                                </div>
                            </div>
                            <div class="input">
                                <label for="nama_fakultas" class="form-label">Fakultas/Unit</label>
                                <div class="field">
                                    <input id="nama_fakultas" name="nama_fakultas" x-model="formData.nama_fakultas" :disabled="isGuestDataLocked" class="content text-wrapper-2" type="text" placeholder="Ketik fakultas kamu di sini"
                                        :required="['tendik'].includes(formData.jenis_pengunjung)" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="['mahasiswa', 'dosen'].includes(formData.jenis_pengunjung)">
                        <div x-transition>
                            <div class="input">
                                <label for="no_identitas" class="form-label" x-text="formData.jenis_pengunjung === 'mahasiswa' ? 'NIM' : 'NUPTK/NIP'"></label>
                                <div class="field">
                                    <input id="no_identitas" name="no_identitas" x-model="formData.no_identitas" @blur="searchGuest" class="content text-wrapper-2" type="tel"
                                        :placeholder="formData.jenis_pengunjung === 'mahasiswa' ? 'Ketik NIM lalu keluar dari kolom ini' : 'Ketik NUPTK/NIP lalu keluar dari kolom ini'"
                                        :required="['mahasiswa', 'dosen'].includes(formData.jenis_pengunjung)" autocomplete="off" pattern="[0-9]+" title="Hanya boleh diisi angka." maxlength="20">
                                </div>
                            </div>
                            <div class="input">
                                <label for="nama_fakultas" class="form-label">Fakultas</label>
                                <div class="field">
                                    <select id="nama_fakultas" name="nama_fakultas" x-model="formData.nama_fakultas" :disabled="isGuestDataLocked" class="content text-wrapper-2" type="text" placeholder="Ketik fakultas kamu di sini"
                                        :required="['mahasiswa', 'dosen'].includes(formData.jenis_pengunjung)" autocomplete="off">
                                        <option value="" disabled>Pilih Fakultas...</option>
                                        <option value="FKIP">FKIP</option>
                                        <option value="FMIPA">FMIPA</option>
                                        <option value="FT">F. TEKNIK</option>
                                        <option value="FEB">FEB</option>
                                        <option value="FAPERTA">FAPERTA</option>
                                        <option value="FAPERIKA">FAPERIKA</option>
                                        <option value="FISIP">FISIP</option>
                                        <option value="FH">F. HUKUM</option>
                                        <option value="FK">F. KEDOKTERAN</option>
                                        <option value="KEPERAWATAN">KEPERAWATAN</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="input">
                        <label for="nama" class="form-label">Nama</label>
                        <div class="field">
                            <input id="nama" name="nama" x-model="formData.nama" :disabled="isGuestDataLocked || !formData.jenis_pengunjung" class="content text-wrapper-2" type="text" placeholder="Ketik nama kamu di sini" required autocomplete="off" pattern="[\p{L}\s.,]+" title="Hanya boleh diisi huruf, spasi, titik, dan koma."/>
                        </div>
                    </div>
                    <template x-if="!isGuestDataLocked">
                        <div class="input" x-transition>
                            <label for="handphone" class="form-label">No. Handphone</label>
                            <div class="field">
                                <input id="handphone" name="no_handphone" x-model="formData.no_handphone" class="content text-wrapper-2" type="tel" placeholder="Ketik No. HP kamu di sini" required autocomplete="off" pattern="^\+?[0-9]+$" title="Hanya boleh diisi angka dan dapat diawali dengan tanda +." minlength="10" maxlength="13" :disabled="!formData.jenis_pengunjung"/>
                            </div>
                        </div>
                    </template>

                    <template x-if="!isGuestDataLocked">
                        <div class="input" x-transition>
                            <label for="email" class="form-label">Email</label>
                            <div class="field">
                                <input id="email" name="email" x-model="formData.email" class="content-2" type="email" placeholder="Ketik email kamu di sini" required autocomplete="off" :disabled="!formData.jenis_pengunjung"/>
                            </div>
                        </div>
                    </template>

                    <div class="input">
                        <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                        <div class="field">
                            <select id="jenis_layanan" name="jenis_layanan" x-model="formData.jenis_layanan" class="content text-wrapper-2" required :disabled="!formData.jenis_pengunjung">
                                <option value="" disabled>Pilih Layanan...</option>
                                @forelse ($services as $service)
                                    <option value="{{ $service->nama_layanan }}">{{ $service->nama_layanan }}</option>
                                @empty
                                @endforelse
                                <option value="Lainnya">Lainnya (Isi Manual)</option>
                            </select>
                        </div>
                    </div>

                    <div class="input">
                        <label for="perihal" class="form-label">Perihal</label>
                        <div class="field-2">
                            <textarea id="perihal" name="perihal" x-model="formData.perihal" class="content text-wrapper-2" placeholder="Ketik perihal kunjungan kamu" autocomplete="off" required :disabled="!formData.jenis_pengunjung"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="button"><div class="containt"><span class="label">Simpan</span></div></button>
                </form>
            </main>
        </div>

          <div class="form-modal-overlay" x-show="isFeedbackOpen" x-transition:enter.opacity.duration.300ms x-transition:leave.opacity.duration.300ms x-cloak>
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
                    <input id="nama-feedback" name="nama" class="content text-wrapper-2" type="text" placeholder="Ketik nama kamu" required autocomplete="off" pattern="[A-Za-z\s.,]+" title="Hanya boleh diisi huruf, spasi, titik, dan koma."/>
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

          <div class="form-modal-overlay" x-show="isSurveyOpen" x-transition:enter.opacity.duration.300ms x-transition:leave.opacity.duration.300ms x-cloak>
              <main class="form" x-show="isSurveyOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                  <header class="headline">
                      <h1 class="frame"><span class="text-wrapper">Beri Penilaian Anda</span></h1>
                      <button class="close-button" aria-label="Tutup formulir" @click="isSurveyOpen = false; surveyRating = 0;">
                          <img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" />
                      </button>
                  </header>
                  <form class="input-field" @submit.prevent="
                      const formElement = $el;
                      const formData = new FormData(formElement);
                      fetch(`/api/faculties/${$data.facultyId}/surveys`, {
                          method: 'POST', // <-- PASTIKAN BARIS INI ADA DAN BENAR
                          body: formData,
                          headers: {
                              'Accept': 'application/json'
                          }
                      })
                      .then(response => {
                          if (response.ok) {
                              formElement.reset();
                              isSurveyOpen = false;
                              surveyRating = 0;
                              isSuccessOpen = true;
                              setTimeout(() => { isSuccessOpen = false }, 3000);
                              } else { /* penanganan error */ }
                          })
                          .catch(error => { /* penanganan error */ });
                      ">

                      <div class="input">
                          <label for="nama-survey" class="form-label">Nama</label>
                          <div class="field">
                            <input id="nama-survey" name="nama" class="content text-wrapper-2" type="text" placeholder="Ketik nama kamu" required autocomplete="off" pattern="[A-Za-z\s.,]+" title="Hanya boleh diisi huruf, spasi, titik, dan koma."/>
                          </div>
                          <label class="form-label">Kepuasan Pelayanan</label>
                          <div class="star-rating" @mouseleave="hoverRating = 0">
                              <template x-for="i in 5" :key="i">
                                  <span class="star"
                                        @mouseover="hoverRating = i"
                                        @click="surveyRating = i"
                                        :class="{ 'filled': i <= surveyRating || i <= hoverRating }">★</span>
                              </template>
                          </div>
                          <input type="hidden" name="rating" x-model="surveyRating">
                      </div>

                      <div class="input">
                          <label for="pesan" class="form-label">Pesan (Opsional)</label>
                          <div class="field-2">
                              <textarea id="pesan" name="pesan" class="content text-wrapper-2" placeholder="Ketik pesan Anda di sini" autocomplete="off"></textarea>
                          </div>
                      </div>

                      <button type="submit" class="button" :disabled="surveyRating === 0" :class="{ 'button-disabled': surveyRating === 0 }">
                          <div class="containt"><span class="label">Kirim Penilaian</span></div>
                      </button>
                  </form>
              </main>
            </div>

            <div class="form-modal-overlay" x-show="isPPIDOpen" x-transition:enter.opacity.duration.300ms x-transition:leave.opacity.duration.300ms x-cloak>
                <main class="form" x-show="isPPIDOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">

                    <header class="headline">
                        <h1 class="frame">
                            <span class="text-wrapper" x-show="selectedChoice === null">Pilih Layanan</span>
                            <span class="text-wrapper" x-show="selectedChoice === 'permohonan'">Formulir Permohonan Informasi</span>
                            <span class="text-wrapper" x-show="selectedChoice === 'keberatan'">Formulir Keberatan Informasi</span>
                            <!-- <span class="text-wrapper" x-show="selectedChoice === 'pungli'">Formulir Pengaduan Pungli / Gratifikasi</span>
                            <span class="text-wrapper" x-show="selectedChoice === 'pejabat'">Formulir Pengaduan Penyalahgunaan Wewenang / Pelanggaran Pejabat</span>
                            <span class="text-wrapper" x-show="selectedChoice === 'mitra'">Formulir Pengaduan Penyalahgunaan Wewenang / Pelanggaran Mitra Kerja</span> -->
                        </h1>
                        <button class="close-button" aria-label="Tutup formulir"
                                @click="isPPIDOpen = false; selectedChoice = null; surveyRating = 0;">
                            <img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" />
                        </button>
                    </header>

                    <div class="radio-selection-wrapper" x-show="selectedChoice === null" x-transition:enter.opacity.duration.300ms>
                        <div class="input" style="margin-bottom: 1rem;">
                            <label class="form-label">Apa yang ingin Anda lakukan?</label>
                        </div>

                        <div class="radio-option-group">

                            <button type="button"
                                    class="button-choice"
                                    @click="selectedChoice = 'permohonan'"
                                    :class="{ 'selected': selectedChoice === 'permohonan' }"
                            >
                                <span>Buat Permohonan Informasi</span>
                            </button>

                            <br>

                            <button type="button"
                                    class="button-choice"
                                    @click="selectedChoice = 'keberatan'"
                                    :class="{ 'selected': selectedChoice === 'keberatan' }"
                            >
                                <span>Ajukan Keberatan Informasi</span>
                            </button>

                            <br>

                            <!-- <button type="button"
                                    class="button-choice"
                                    @click="selectedChoice = 'pungli'"
                                    :class="{ 'selected': selectedChoice === 'pungli' }"
                            >
                                <span>Pengaduan Pungli / Gratifikasi</span>
                            </button>

                            <br>

                            <button type="button"
                                    class="button-choice"
                                    @click="selectedChoice = 'pejabat'"
                                    :class="{ 'selected': selectedChoice === 'pejabat' }"
                            >
                                <span>Pengaduan Penyalahgunaan Wewenang / Pelanggaran Pejabat</span>
                            </button>

                            <br>

                            <button type="button"
                                    class="button-choice"
                                    @click="selectedChoice = 'mitra'"
                                    :class="{ 'selected': selectedChoice === 'mitra' }"
                            >
                                <span>Pengaduan Penyalahgunaan Wewenang / Pelanggaran Mitra Kerja</span>
                            </button> -->

                            <input type="hidden" name="choice" x-model="selectedChoice">
                        </div>
                    </div>

                    <div class="form-wrapper" x-show="selectedChoice === 'permohonan'" x-transition:enter.opacity.duration.300ms>

                        <button type="button" @click="selectedChoice = null; caraMemperoleh = ''; caraMendapatkan = '';" class="back-button" style="margin-bottom: 1rem; background: none; border: none; color: #007bff; cursor: pointer;">
                            &larr; Ganti Pilihan
                        </button>

                        {{-- <form class="input-field" @submit.prevent="
                            const formElement = $el;
                            const formData = new FormData(formElement);
                            // [PENTING] Ganti URL endpoint ini sesuai dengan API untuk 'permohonan'
                            fetch(`/api/faculties/${$data.facultyId}/permohonan-informasi`, {
                                method: 'POST', body: formData, headers: { 'Accept': 'application/json' }
                            })
                            .then(response => {
                                if (response.ok) {
                                    formElement.reset(); isPPIDOpen = false; selectedChoice = null;
                                    isSuccessOpen = true; setTimeout(() => { isSuccessOpen = false }, 3000);
                                } else { /* penanganan error */ }
                            }).catch(error => { /* penanganan error */ });
                        ">
                            <input type="hidden" name="jenis_layanan" value="permohonan">

                            <div class="form-content-wrapper">

                                <div class="input">
                                    <label for="permohonan-nama" class="form-label">Nama/ Instansi Pemohon Informasi *</label>
                                    <div class="field">
                                        <input id="permohonan-nama" name="nama" class="content text-wrapper-2" type="text" placeholder="Jawaban Anda" required autocomplete="off" />
                                    </div>
                                </div>
                                <div class="input">
                                    <label for="permohonan-ktp" class="form-label">Lampirkan foto KTP/SIM/ Identitas Lainnya *</label>
                                    <div class="field-file">
                                        <input id="permohonan-ktp" name="file_identitas" type="file" accept="image/*,application/pdf" capture="environment" required>
                                    </div>
                                </div>

                                <div class="grid-2-col-fields">
                                    <div class="input">
                                        <label for="permohonan-alamat-ktp" class="form-label">Alamat (Sesuai KTP/SIM/...) *</label>
                                        <div class="field-2">
                                            <textarea id="permohonan-alamat-ktp" name="alamat_ktp" class="content text-wrapper-2" placeholder="Jawaban Anda" required autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="input">
                                        <label for="permohonan-alamat-sekarang" class="form-label">Alamat saat ini (Kosongkan apabila sama)</label>
                                        <div class="field-2">
                                            <textarea id="permohonan-alamat-sekarang" name="alamat_sekarang" class="content text-wrapper-2" placeholder="Jawaban Anda" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid-2-col-fields">
                                    <div class="input">
                                        <label for="permohonan-no-hp" class="form-label">No. HP *</label>
                                        <div class="field">
                                            <input id="permohonan-no-hp" name="no_hp" class="content text-wrapper-2" type="tel" placeholder="Jawaban Anda" required autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="input">
                                        <label for="permohonan-email" class="form-label">Email *</label>
                                        <div class="field">
                                            <input id="permohonan-email" name="email" class="content text-wrapper-2" type="email" placeholder="Jawaban Anda" required autocomplete="off" />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid-2-col-fields">
                                    <div class="input">
                                        <label for="permohonan-informasi" class="form-label">Informasi yang Dibutuhkan *</label>
                                        <div class="field-2">
                                            <textarea id="permohonan-informasi" name="informasi" class="content text-wrapper-2" placeholder="Jawaban Anda" required autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="input">
                                        <label for="permohonan-tujuan" class="form-label">Tujuan Penggunaan Informasi *</label>
                                        <div class="field-2">
                                            <textarea id="permohonan-tujuan" name="tujuan" class="content text-wrapper-2" placeholder="Jawaban Anda" required autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="input">
                                    <label class="form-label">Cara Memperoleh Informasi *</label>
                                    <div class="radio-group">
                                        <label><input type="radio" name="cara_memperoleh" value="Membaca" x-model="caraMemperoleh" required> Membaca</label>
                                        <label><input type="radio" name="cara_memperoleh" value="Mendengarkan" x-model="caraMemperoleh"> Mendengarkan</label>
                                        <label><input type="radio" name="cara_memperoleh" value="Mencatat" x-model="caraMemperoleh"> Mencatat</label>
                                        <label><input type="radio" name="cara_memperoleh" value="Mendapatkan salinan hardcopy" x-model="caraMemperoleh"> Mendapatkan salinan informasi hardcopy (fotocopy)</label>
                                        <label><input type="radio" name="cara_memperoleh" value="Mendapatkan salinan softcopy" x-model="caraMemperoleh"> Mendapatkan salinan informasi softcopy (digital)</label>
                                        <label>
                                            <input type="radio" name="cara_memperoleh" value="Yang lain" x-model="caraMemperoleh"> Yang lain:
                                        </label>
                                        <div class="field" x-show="caraMemperoleh === 'Yang lain'">
                                            <input name="cara_memperoleh_lainnya" class="content text-wrapper-2" type="text" placeholder="Sebutkan cara lainnya"
                                                :required="caraMemperoleh === 'Yang lain'">
                                        </div>
                                    </div>
                                </div>

                                <div class="input" x-show="caraMemperoleh === 'Mendapatkan salinan hardcopy' || caraMemperoleh === 'Mendapatkan salinan softcopy'" x-transition>
                                    <label class="form-label">Cara Mendapatkan Salinan Informasi</label>
                                    <div class="radio-group">
                                        <label><input type="radio" name="cara_mendapatkan" value="Mengambil Langsung" x-model="caraMendapatkan"> Mengambil Langsung</label>
                                        <label><input type="radio" name="cara_mendapatkan" value="Melalui Kurir" x-model="caraMendapatkan"> Melalui Kurir</label>
                                        <label><input type="radio" name="cara_mendapatkan" value="Melalui Pos" x-model="caraMendapatkan"> Melalui Pos</label>
                                        <label><input type="radio" name="cara_mendapatkan" value="Melalui e-mail" x-model="caraMendapatkan"> Melalui e-mail</label>
                                        <label>
                                            <input type="radio" name="cara_mendapatkan" value="Yang lain" x-model="caraMendapatkan"> Yang lain:
                                        </label>
                                        <div class="field" x-show="caraMendapatkan === 'Yang lain'">
                                            <input name="cara_mendapatkan_lainnya" class="content text-wrapper-2" type="text" placeholder="Sebutkan cara lainnya"
                                                :required="caraMendapatkan === 'Yang lain'">
                                        </div>
                                    </div>
                                </div>

                                <div class="input">
                                    <label for="permohonan-tanggal" class="form-label">Tanggal *</label>
                                    <div class="field">
                                        <input id="permohonan-tanggal" name="tanggal" class="content text-wrapper-2" type="date" required />
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="button">
                                <div class="containt"><span class="label">Kirim Permohonan</span></div>
                            </button>
                        </form> --}}
                        <iframe
                            src="https://e-ppid.unri.ac.id/kiosk/permohonan/1"
                            title="Formulir Permohonan PPID"
                            allow="camera; microphone"
                            frameborder="0"
                            class="iframe-full-modal"
                        ></iframe>
                    </div>

                    <div class="form-wrapper" x-show="selectedChoice === 'keberatan'" x-transition:enter.opacity.duration.300ms>

                        <button type="button" @click="selectedChoice = null" class="back-button" style="margin-bottom: 1rem; background: none; border: none; color: #007bff; cursor: pointer;">
                            &larr; Ganti Pilihan
                        </button>

                        <iframe
                            src="https://e-ppid.unri.ac.id/kiosk/permohonan/2"
                            title="Formulir Permohonan PPID"
                            allow="camera; microphone"
                            frameborder="0"
                            class="iframe-full-modal"
                        ></iframe>


                        {{-- <form class="input-field" @submit.prevent="
                            const formElement = $el;
                            const formData = new FormData(formElement);
                            // [PENTING] Ganti URL endpoint ini sesuai dengan API untuk 'keberatan'
                            fetch(`/api/faculties/${$data.facultyId}/keberatan-informasi`, {
                                method: 'POST', body: formData, headers: { 'Accept': 'application/json' }
                            })
                            .then(response => {
                                if (response.ok) {
                                    formElement.reset(); isPPIDOpen = false; selectedChoice = null;
                                    isSuccessOpen = true; setTimeout(() => { isSuccessOpen = false }, 3000);
                                } else { /* penanganan error */ }
                            }).catch(error => { /* penanganan error */ });
                        ">
                            <input type="hidden" name="jenis_layanan" value="keberatan">

                            <div class="input">
                                <label for="keberatan-nama" class="form-label">Nama/ Instansi Pemohon *</label>
                                <div class="field">
                                    <input id="keberatan-nama" name="nama" class="content text-wrapper-2" type="text" placeholder="Jawaban Anda" required autocomplete="off" />
                                </div>
                            </div>
                            <div class="input">
                                <label for="permohonan-ktp" class="form-label">Lampirkan foto KTP/SIM/ Identitas Lainnya *</label>
                                <div class="field-file">
                                    <input id="permohonan-ktp"
                                        name="file_identitas"
                                        type="file"
                                        accept="image/*"
                                        capture="environment"
                                        required>
                                </div>
                            </div>
                            <div class="input">
                                <label for="keberatan-alamat-sekarang" class="form-label">Alamat saat ini *</label>
                                <div class="field-2">
                                    <textarea id="keberatan-alamat-sekarang" name="alamat_sekarang" class="content text-wrapper-2" placeholder="Jawaban Anda" required autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="input">
                                <label for="keberatan-telepon" class="form-label">No. Telepon/HP *</label>
                                <div class="field">
                                    <input id="keberatan-telepon" name="telepon" class="content text-wrapper-2" type="tel" placeholder="Jawaban Anda" required autocomplete="off" />
                                </div>
                            </div>

                            <div class="input">
                                <label for="keberatan-email" class="form-label">Email *</label>
                                <div class="field">
                                    <input id="keberatan-email" name="email" class="content text-wrapper-2" type="email" placeholder="Jawaban Anda" required autocomplete="off" />
                                </div>
                            </div>
                            <div class="input">
                                <label for="keberatan-informasi" class="form-label">Informasi yang Dimohon *</label>
                                <div class="field-2">
                                    <textarea id="keberatan-informasi" name="informasi" class="content text-wrapper-2" placeholder="Jawaban Anda" required autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="input">
                                <label for="keberatan-tujuan" class="form-label">Tujuan Penggunaan Informasi *</label>
                                <div class="field-2">
                                    <textarea id="keberatan-tujuan" name="tujuan" class="content text-wrapper-2" placeholder="Jawaban Anda" required autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="input">
                                <label class="form-label">Alasan Pengajuan Keberatan *</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="alasan" value="Tidak disediakannya informasi" x-model="alasanKeberatan" required> Tidak disediakannya informasi</label><br>
                                    <label><input type="radio" name="alasan" value="Tidak ditanggapinya informasi" x-model="alasanKeberatan"> Tidak ditanggapinya informasi</label><br>
                                    <label><input type="radio" name="alasan" value="Pengenaan biaya yang tidak wajar" x-model="alasanKeberatan"> Pengenaan biaya yang tidak wajar</label><br>
                                    <label><input type="radio" name="alasan" value="Penolakan atas permintaan informasi..." x-model="alasanKeberatan"> Penolakan atas permintaan informasi...</label><br>
                                    <label><input type="radio" name="alasan" value="Penyampaian informasi yang melebihi jangka waktu..." x-model="alasanKeberatan"> Penyampaian informasi yang melebihi jangka waktu...</label><br>
                                    <label>
                                        <input type="radio" name="alasan" value="Yang lain" x-model="alasanKeberatan"> Yang lain:
                                    </label>
                                    <div class="field" x-show="alasanKeberatan === 'Yang lain'">
                                        <textarea name="alasan_lainnya" class="content text-wrapper-2" placeholder="Tuliskan alasan lainnya"
                                                :required="alasanKeberatan === 'Yang lain'"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="button">
                                <div class="containt"><span class="label">Kirim Keberatan</span></div>
                            </button>
                        </form> --}}
                    </div>
                    <div class="form-wrapper" x-show="selectedChoice === 'pungli'" x-transition:enter.opacity.duration.300ms>

                        <button type="button" @click="selectedChoice = null" class="back-button" style="margin-bottom: 1rem; background: none; border: none; color: #007bff; cursor: pointer;">
                            &larr; Ganti Pilihan
                        </button>

                        <iframe
                            src="https://e-ppid.unri.ac.id/kiosk/permohonan/3"
                            title="Formulir Permohonan PPID"
                            allow="camera; microphone"
                            frameborder="0"
                            class="iframe-full-modal"
                        ></iframe>
                    </div>
                    <div class="form-wrapper" x-show="selectedChoice === 'pejabat'" x-transition:enter.opacity.duration.300ms>

                        <button type="button" @click="selectedChoice = null" class="back-button" style="margin-bottom: 1rem; background: none; border: none; color: #007bff; cursor: pointer;">
                            &larr; Ganti Pilihan
                        </button>

                        <iframe
                            src="https://e-ppid.unri.ac.id/kiosk/permohonan/4"
                            title="Formulir Permohonan PPID"
                            allow="camera; microphone"
                            frameborder="0"
                            class="iframe-full-modal"
                        ></iframe>
                    </div>
                    <div class="form-wrapper" x-show="selectedChoice === 'mitra'" x-transition:enter.opacity.duration.300ms>

                        <button type="button" @click="selectedChoice = null" class="back-button" style="margin-bottom: 1rem; background: none; border: none; color: #007bff; cursor: pointer;">
                            &larr; Ganti Pilihan
                        </button>

                        <iframe
                            src="https://e-ppid.unri.ac.id/kiosk/permohonan/5"
                            title="Formulir Permohonan PPID"
                            allow="camera; microphone"
                            frameborder="0"
                            class="iframe-full-modal"
                        ></iframe>
                    </div>

                </main>
            </div>

            <div class="form-modal-overlay z-50" x-show="isMalPelayananOpen" x-transition x-cloak>
                <div x-show="isMalPelayananOpen" x-transition
                     style="position:fixed; inset:1rem; background:#fff; border-radius:1rem; overflow:hidden; box-shadow:0 25px 50px rgba(0,0,0,0.4);">
                    <div id="mal-modal-header" style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-bottom:1px solid #e5e7eb; height:3.5rem; box-sizing:border-box;">
                        <span style="font-size:1.125rem; font-weight:700;">Mal Pelayanan Publik</span>
                        <button @click="isMalPelayananOpen = false" style="background:none; border:none; cursor:pointer; padding:0.25rem;">
                            <img src="{{ secure_asset('img/iconx.png') }}" alt="Tutup" style="width:1.5rem; height:1.5rem;">
                        </button>
                    </div>
                    <iframe
                        src="http://localhost/index.php?pages=nomor"
                        title="Mal Pelayanan Publik"
                        frameborder="0"
                        style="position:absolute; top:3.5rem; left:0; right:0; bottom:0; width:100%; height:calc(100% - 3.5rem); border:none;"
                    ></iframe>
                </div>
            </div>

            <div class="form-modal-overlay z-50"
                x-show="isContactModalOpen"
                x-transition x-cloak>

                <main class="form !max-w-lg bg-white" x-show="isContactModalOpen" x-transition>
                    <header class="headline">
                        <h1 class="frame"><span class="text-wrapper ">Kontak Informasi</span></h1>
                        <button class="close-button" aria-label="Tutup" @click="isContactModalOpen = false">
                            <img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" />
                        </button>
                    </header>

                    <div class="p-6 sm:p-8 space-y-4">
                        <h2 class="text-xl font-bold text-center text-gray-800 ">{{ $faculty->name }}</h2>

                        <ul class="space-y-5 pt-4">
                            @forelse ($contacts as $contact)
                                <li class="flex items-start gap-4">
                                    <div class="shrink-0 w-6 h-6 text-gray-500 mt-1">
                                        @switch(strtolower($contact->jenis_kontak))
                                            @case('no. telepon')
                                            @case('no telepon')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                                                @break
                                            @case('email')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                                                @break
                                            @case('website')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.953 11.953 0 0112 16.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                @break
                                            @case('alamat')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                                @break
                                            @case('instagram')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
                                                @break
                                            @case('whatsapp')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.487 5.235 3.487 8.413 0 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.447-4.433-9.886-9.889-9.886-5.448 0-9.886 4.434-9.889 9.885.002 2.024.603 3.965 1.738 5.63l-1.192 4.355 4.462-1.165zM16.47 14.382c-.215-.108-1.267-.627-1.466-.701-.199-.073-.343-.108-.487.108-.144.217-.553.701-.679.846-.126.144-.253.162-.468.054-.217-.108-.901-.334-1.716-.99-1.277-1.023-1.466-1.902-1.466-2.247s-.036-.51.072-.654c.108-.144.234-.36.343-.51.108-.144.144-.253.216-.42.072-.162.036-.306-.018-.414-.054-.108-.487-1.17-.679-1.598-.18-.396-.36-.343-.487-.343-.126 0-.27.009-.414.009-.144 0-.378.054-.577.271-.199.217-.769.752-.769 1.826s.787 2.121.896 2.269c.108.144 1.554 2.366 3.759 3.312.54.234.958.378 1.287.486.487.162.928.144 1.267.081.378-.054 1.267-.519 1.448-.986.18-.468.18-.867.126-.986-.054-.108-.199-.162-.414-.27z"/></svg>
                                                @break
                                            @default
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                                        @endswitch
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-600">{{ $contact->jenis_kontak }}</p>
                                        <p class="text-gray-800  break-words">{{ $contact->detail }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-gray-500 py-16">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6.75h-6v10.5h6" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 17.25H4.5a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h9" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 13.5h4.5m-4.5-3h4.5m-4.5-3h4.5" /></svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 ">Kontak Kosong</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada informasi kontak yang tersedia.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </main>
            </div>

            <div class="form-modal-overlay z-50"
                x-show="isScheduleModalOpen"
                x-transition x-cloak>

                <main class="form !max-w-2xl bg-white" x-show="isScheduleModalOpen" x-transition>
                    <header class="headline">
                        <h1 class="frame"><span class="text-wrapper ">Jadwal Penting</span></h1>
                        <button class="close-button" aria-label="Tutup" @click="isScheduleModalOpen = false">
                            <img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" />
                        </button>
                    </header>

                    <div class="p-6 sm:p-8">
                        <ul class="space-y-6">
                            @forelse ($schedules as $schedule)
                                <li class="flex items-start gap-4 pb-6 border-b border-gray-200 last:border-b-0">

                                    <div class="flex-shrink-0 w-20 text-center bg-indigo-50 p-3 rounded-lg">
                                        <p class="text-3xl font-bold text-indigo-600">
                                            {{ $schedule->start_date->format('d') }}
                                        </p>
                                        <p class="text-sm font-semibold text-indigo-500 uppercase">
                                            {{ $schedule->start_date->format('M') }}
                                        </p>
                                    </div>

                                    <div class="flex-grow">
                                        <h4 class="font-bold text-lg text-gray-800 ">{{ $schedule->title }}</h4>

                                        @if($schedule->end_date && $schedule->end_date->ne($schedule->start_date))
                                            <p class="text-xs font-medium text-gray-500 mb-2">
                                                Berlangsung hingga {{ $schedule->end_date->format('d M Y') }}
                                            </p>
                                        @endif

                                        @if($schedule->description)
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $schedule->description }}
                                            </p>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-gray-500 py-16">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 ">Tidak Ada Jadwal</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada jadwal penting yang akan datang.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </main>
            </div>

            <div class="form-modal-overlay z-50" x-show="isMapModalOpen" x-transition x-cloak>
                <main class="form !max-w-6xl bg-gray-50" x-show="isMapModalOpen" x-transition>
                    <header class="headline border-b">
                        <h1 class="frame"><span class="text-wrapper">Denah {{ $faculty->name }}</span></h1>
                        <button class="close-button" @click="isMapModalOpen = false"><img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" /></button>
                    </header>

                    <div class="relative p-4 bg-gray-100"
                         x-swipe:left="mapSliderIndex = (mapSliderIndex + 1) % {{ $faculty->maps->count() }}"
                         x-swipe:right="mapSliderIndex = (mapSliderIndex - 1 + {{ $faculty->maps->count() }}) % {{ $faculty->maps->count() }}">

                        @if($faculty->maps->isNotEmpty())
                            @foreach($faculty->maps as $index => $map)
                                <div x-show="mapSliderIndex === {{ $index }}" class="duration-300" x-transition.opacity>
                                    <h1 class="frame"><span class="text-wrapper">{{ $map->title }}</span></h1>
                                    <img src="{{ asset('storage/' . $map->path) }}" alt="Denah {{ $faculty->name }} #{{ $index + 1 }}" class="w-full h-auto rounded-lg shadow-md">
                                </div>
                            @endforeach

                            @if($faculty->maps->count() > 1)
                                <button @click="mapSliderIndex = (mapSliderIndex - 1 + {{ $faculty->maps->count() }}) % {{ $faculty->maps->count() }}"
                                    class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/50 rounded-full h-10 w-10 flex items-center justify-center hover:bg-white/80 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-10 h-10">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                </button>

                                {{-- Tombol Next --}}
                                <button @click="mapSliderIndex = (mapSliderIndex + 1) % {{ $faculty->maps->count() }}"
                                        class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/50 rounded-full h-10 w-10 flex items-center justify-center hover:bg-white/80 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-10 h-10">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            @endif

                        @else
                            @switch($faculty->slug)
                                @case('unit-penunjang-akademik-tik')
                                    <p class="text-center text-gray-500 py-20">Denah untuk unit ini belum tersedia.</p>
                                    @break
                                @case('rektorat')
                                    <p class="text-center text-gray-500 py-20">Denah untuk rektorat belum tersedia.</p>
                                    @break
                                @default
                                    <p class="text-center text-gray-500 py-20">Denah untuk fakultas ini belum tersedia.</p>
                            @endswitch
                        @endif
                    </div>
                </main>
            </div>

            <div class="form-modal-overlay z-50" x-show="isStatsModalOpen" x-transition x-cloak>
                <main class="form !max-w-3xl bg-gray-50" x-show="isStatsModalOpen" x-transition>
                    <header class="headline border-b">
                        <h1 class="frame"><span class="text-wrapper">Statistik Pengunjung</span></h1>
                        <button class="close-button" @click="isStatsModalOpen = false"><img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" /></button>
                    </header>

                    <div class="p-6 sm:p-8 flex justify-center items-center">
                        <div class="flex flex-col sm:flex-row justify-center items-center gap-6 text-center">

                            <div class="w-40 h-40 bg-white p-5 rounded-2xl shadow-sm border border-gray-200 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="bg-blue-100 p-3 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $todayVisitorCount ?? 0 }}</p>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Hari Ini</p>
                            </div>

                            <div class="w-40 h-40 bg-white p-5 rounded-2xl shadow-sm border border-gray-200 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="bg-green-100 p-3 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /><path d="M9 14l2 2 4-4"></path></svg>
                                </div>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $weekVisitorCount ?? 0 }}</p>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Minggu Ini</p>
                            </div>

                            <div class="w-40 h-40 bg-white p-5 rounded-2xl shadow-sm border border-gray-200 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="bg-purple-100 p-3 rounded-full mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <p class="text-3xl font-extrabold text-gray-800">{{ $monthVisitorCount ?? 0 }}</p>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Bulan Ini</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            <div class="form-modal-overlay z-50"
                x-show="isAnnouncementModalOpen"
                x-transition x-cloak>

                <main class="form !max-w-2xl bg-gray-50" x-show="isAnnouncementModalOpen" x-transition>
                    <header class="headline border-b">
                        @switch($faculty->slug)
                                @case('unit-penunjang-akademik-tik')
                                    <h1 class="frame"><span class="text-wrapper">Pengumuman Unit</span></h1>
                                    @break
                                @case('rektorat')
                                    <h1 class="frame"><span class="text-wrapper">Pengumuman Rektorat</span></h1>
                                    @break
                                @default
                                    <h1 class="frame"><span class="text-wrapper">Pengumuman Fakultas</span></h1>
                        @endswitch
                        <button class="close-button" aria-label="Tutup" @click="isAnnouncementModalOpen = false">
                            <img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" />
                        </button>
                    </header>

                    <div class="p-6 sm:p-8">
                        <ul class="space-y-6">
                            @forelse ($announcements as $announcement)
                                <li class="pb-6 border-b border-gray-200 last:border-b-0">
                                    <p class="text-xs text-gray-500">{{ $announcement->created_at->format('d M Y, H:i') }}</p>
                                    <h4 class="font-bold text-lg text-gray-800 mt-1">{{ $announcement->title }}</h4>
                                    <div class="prose prose-sm mt-2 text-gray-600">
                                        {!! $announcement->content !!}
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-gray-500 py-16">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-2.104 9.168-3.934" /></svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Pengumuman</h3>
                                    <p class="mt-1 text-sm text-gray-500">Saat ini belum ada pengumuman baru.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </main>
            </div>

            <div class="form-modal-overlay z-50"
                x-show="isEventModalOpen"
                x-transition x-cloak>

                <main class="form !max-w-3xl bg-gray-50" x-show="isEventModalOpen" x-transition>
                    <header class="headline border-b">
                        @switch($faculty->slug)
                            @case('unit-penunjang-akademik-tik')
                                <h1 class="frame"><span class="text-wrapper">Kegiatan Unit</span></h1>
                                @break
                            @case('rektorat')
                                <h1 class="frame"><span class="text-wrapper">Kegiatan Rektorat</span></h1>
                                @break
                            @default
                                <h1 class="frame"><span class="text-wrapper">Kegiatan Fakultas</span></h1>
                        @endswitch
                        <button class="close-button" aria-label="Tutup" @click="isEventModalOpen = false">
                            <img class="img" src="{{ secure_asset('img/iconx.png') }}" alt="Tombol tutup" />
                        </button>
                    </header>

                    <div class="p-6 sm:p-8">
                        <ul class="space-y-6">
                            @forelse ($events as $event)
                                <li class="flex flex-col sm:flex-row items-start gap-4 pb-6 border-b border-gray-200 last:border-b-0">
                                    @if($event->path)
                                    <img src="{{ asset('storage/' . $event->path) }}" alt="{{ $event->title }}" class="w-full sm:w-48 h-auto rounded-lg object-cover">
                                    @endif

                                    <div class="flex-grow">
                                        <h4 class="font-bold text-xl text-gray-800">{{ $event->title }}</h4>
                                        <div class="flex items-center gap-4 text-sm text-gray-500 mt-1">
                                            <div class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                <span>{{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}</span>
                                            </div>
                                            @if($event->location)
                                            <div class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                <span>{{ $event->location }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        @if($event->description)
                                            <div class="prose prose-sm mt-2 text-gray-600">
                                                {!! $event->description !!}
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-gray-500 py-16">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Kegiatan</h3>
                                    <p class="mt-1 text-sm text-gray-500">Saat ini belum ada kegiatan yang akan datang.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
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
    <script>
        function guestForm() {
            return {
                formData: {
                    nama: '',
                    no_handphone: '',
                    email: '',
                    jenis_pengunjung: '',
                    no_identitas: '',
                    nama_fakultas: '',
                    jenis_layanan: '',
                    perihal: ''
                },
                isGuestDataLocked: false,

                resetForPublicVisitor() {
                    this.formData = {
                        jenis_pengunjung: 'umum',
                        no_identitas: '',
                        nama_fakultas: '',
                        nama: '',
                        no_handphone: '',
                        email: '',
                        jenis_layanan: '',
                        perihal: ''
                    };
                    this.isGuestDataLocked = false;
                },

                async searchGuest() {
                    const noIdentitas = this.formData.no_identitas;
                    if (!noIdentitas) {
                        this.resetGuestData(false);
                        return;
                    };
                    try {
                        const response = await fetch(`/api/guests/search/${noIdentitas}`);
                        if (response.ok) {
                            const data = await response.json();
                            this.formData.nama = data.nama;
                            this.formData.no_handphone = data.no_handphone;
                            this.formData.email = data.email;
                            this.formData.nama_fakultas = data.nama_fakultas;
                            if(this.formData.jenis_pengunjung != data.jenis_pengunjung) {
                                this.formData.jenis_pengunjung = data.jenis_pengunjung;
                            }
                            this.isGuestDataLocked = true;
                        } else {
                            this.resetGuestData(false);
                        }
                    } catch (error) {
                        this.resetGuestData(false);
                    }
                },

                submitForm() {
                    const facultyId = '{{ $faculty->id }}';

                    const dataToSend = new FormData();
                    for (const key in this.formData) {
                        dataToSend.append(key, this.formData[key]);
                    }

                    fetch(`/api/faculties/${facultyId}/guests`, {
                        method: 'POST',
                        body: dataToSend,
                        headers: { 'Accept': 'application/json' },
                    })
                    .then(response => {
                        if (response.ok) {
                            this.isSuccessOpen = true;
                            setTimeout(() => location.reload(), 3000);
                        } else {
                            response.json().then(data => {
                                let errorMessages = 'Gagal menyimpan data:\n';
                                for (const key in data.errors) { errorMessages += `- ${data.errors[key][0]}\n`; }
                                alert(errorMessages);
                            });
                        }
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                    });
                },

                resetGuestData(resetNoIdentitas = true) {
                    if (resetNoIdentitas) {
                        this.formData.no_identitas = '';
                    }
                    this.formData.nama = '';
                    this.formData.no_handphone = '';
                    this.formData.email = '';
                    this.formData.nama_fakultas = '';
                    this.isGuestDataLocked = false;
                },

                resetForm() {
                    this.resetGuestData();
                    this.formData.jenis_pengunjung = '';
                    this.formData.jenis_layanan = '';
                    this.formData.perihal = '';
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="{{ secure_asset('js/alpine-swipe.min.js') }}"></script>
</body>
</html>

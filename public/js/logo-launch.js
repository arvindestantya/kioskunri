(() => {
  const canvas = document.getElementById('fxCanvas');
  const ctx = canvas.getContext('2d');
  let dpr = Math.max(1, window.devicePixelRatio || 1);
  let width = 0, height = 0;
  let particles = [];
  let running = false;
  let burstIntervalId = null;

  // Audio setup
  let audioCtx = null;
  const AUDIO_CONFIG = {
    tick: { type: 'square', freq: 1000, gain: 0.22 },
    launch: {
      type: 'triangle',
      chord: [523.25, 659.25, 783.99], // C5, E5, G5
      chordGain: 0.28,
      noiseGain: 0.18
    }
  };
  function ensureAudio() {
    if (!audioCtx) {
      const AC = window.AudioContext || window.webkitAudioContext;
      audioCtx = new AC();
    }
    if (audioCtx.state === 'suspended') {
      audioCtx.resume();
    }
  }

  function playTick() {
    try {
      ensureAudio();
      const o = audioCtx.createOscillator();
      const g = audioCtx.createGain();
      o.type = AUDIO_CONFIG.tick.type;
      o.frequency.setValueAtTime(AUDIO_CONFIG.tick.freq, audioCtx.currentTime);
      g.gain.setValueAtTime(0, audioCtx.currentTime);
      g.gain.linearRampToValueAtTime(AUDIO_CONFIG.tick.gain, audioCtx.currentTime + 0.01);
      g.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 0.18);
      o.connect(g).connect(audioCtx.destination);
      o.start();
      o.stop(audioCtx.currentTime + 0.2);
    } catch (e) {
      // no-op jika audio tidak tersedia
    }
  }

  function playLaunch() {
    try {
      ensureAudio();
      const now = audioCtx.currentTime;
      const chord = AUDIO_CONFIG.launch.chord;
      chord.forEach((freq, i) => {
        const o = audioCtx.createOscillator();
        const g = audioCtx.createGain();
        o.type = AUDIO_CONFIG.launch.type;
        o.frequency.setValueAtTime(freq, now);
        g.gain.setValueAtTime(0, now);
        g.gain.linearRampToValueAtTime(AUDIO_CONFIG.launch.chordGain, now + 0.05 + i * 0.02);
        g.gain.exponentialRampToValueAtTime(0.0001, now + 0.6 + i * 0.02);
        o.connect(g).connect(audioCtx.destination);
        o.start(now);
        o.stop(now + 0.8 + i * 0.02);
      });

      // subtle noise burst seperti kembang api
      const len = Math.floor(audioCtx.sampleRate * 0.25);
      const buf = audioCtx.createBuffer(1, len, audioCtx.sampleRate);
      const data = buf.getChannelData(0);
      for (let i = 0; i < len; i++) {
        const t = i / len;
        data[i] = (Math.random() * 2 - 1) * Math.pow(1 - t, 2);
      }
      const noise = audioCtx.createBufferSource();
      noise.buffer = buf;
      const ng = audioCtx.createGain();
      ng.gain.setValueAtTime(AUDIO_CONFIG.launch.noiseGain, now);
      ng.gain.exponentialRampToValueAtTime(0.0001, now + 0.25);
      noise.connect(ng).connect(audioCtx.destination);
      noise.start(now);
    } catch (e) {
      // abaikan jika audio gagal
    }
  }

  // Opsi runtime sederhana untuk mengubah konfigurasi audio
  window.setAudioConfig = (update) => {
    if (!update || typeof update !== 'object') return;
    if (update.tick) {
      AUDIO_CONFIG.tick.type = update.tick.type ?? AUDIO_CONFIG.tick.type;
      AUDIO_CONFIG.tick.freq = update.tick.freq ?? AUDIO_CONFIG.tick.freq;
      AUDIO_CONFIG.tick.gain = update.tick.gain ?? AUDIO_CONFIG.tick.gain;
    }
    if (update.launch) {
      AUDIO_CONFIG.launch.type = update.launch.type ?? AUDIO_CONFIG.launch.type;
      AUDIO_CONFIG.launch.chord = update.launch.chord ?? AUDIO_CONFIG.launch.chord;
      AUDIO_CONFIG.launch.chordGain = update.launch.chordGain ?? AUDIO_CONFIG.launch.chordGain;
      AUDIO_CONFIG.launch.noiseGain = update.launch.noiseGain ?? AUDIO_CONFIG.launch.noiseGain;
    }
  };

  const COLORS = ['#ff4570', '#ffd166', '#06d6a0', '#118ab2', '#8338ec', '#fca311', '#e71d36'];

  function resize() {
    width = canvas.clientWidth;
    height = canvas.clientHeight;
    canvas.width = Math.floor(width * dpr);
    canvas.height = Math.floor(height * dpr);
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }
  resize();
  window.addEventListener('resize', resize);

  function rand(min, max) { return Math.random() * (max - min) + min; }
  function pick(arr) { return arr[Math.floor(Math.random() * arr.length)]; }

  function spawnConfetti(x, y, count = 160) {
    for (let i = 0; i < count; i++) {
      const angle = rand(-Math.PI, Math.PI);
      const speed = rand(3, 9);
      particles.push({
        x, y,
        vx: Math.cos(angle) * speed,
        vy: Math.sin(angle) * speed - rand(2, 5),
        size: rand(2, 6),
        color: pick(COLORS),
        life: rand(1.2, 2.8),
        rotation: rand(0, Math.PI * 2),
        rSpeed: rand(-0.2, 0.2),
        type: 'confetti'
      });
    }
  }

  function spawnBurst(count = 60) {
    const x = rand(width * 0.2, width * 0.8);
    const y = rand(height * 0.2, height * 0.6);
    for (let i = 0; i < count; i++) {
      const angle = (i / count) * Math.PI * 2 + rand(-0.1, 0.1);
      const speed = rand(4, 8);
      particles.push({
        x, y,
        vx: Math.cos(angle) * speed,
        vy: Math.sin(angle) * speed,
        size: rand(2, 4),
        color: pick(COLORS),
        life: rand(0.8, 1.6),
        rotation: rand(0, Math.PI * 2),
        rSpeed: rand(-0.25, 0.25),
        type: 'burst'
      });
    }
  }

  function drawParticle(p) {
    ctx.save();
    ctx.translate(p.x, p.y);
    ctx.rotate(p.rotation);
    if (p.type === 'confetti') {
      ctx.fillStyle = p.color;
      ctx.fillRect(-p.size * 0.6, -p.size * 0.3, p.size, p.size * 0.6);
    } else {
      ctx.beginPath();
      ctx.arc(0, 0, p.size, 0, Math.PI * 2);
      ctx.fillStyle = p.color;
      ctx.fill();
    }
    ctx.restore();
  }

  function step(dt) {
    const gravity = 9.8 * 0.06;
    ctx.clearRect(0, 0, width, height);

    particles = particles.filter(p => {
      p.life -= dt;
      if (p.life <= 0) return false;
      p.vy += gravity;
      p.x += p.vx;
      p.y += p.vy;
      p.rotation += p.rSpeed;
      // friction ringan
      p.vx *= 0.995;
      p.vy *= 0.995;
      drawParticle(p);
      return p.x > -50 && p.x < width + 50 && p.y < height + 200;
    });
  }

  let lastTime = 0;
  function loop(ts) {
    if (!running) return;
    if (!lastTime) lastTime = ts;
    const dt = Math.min(0.033, (ts - lastTime) / 1000);
    lastTime = ts;
    step(dt);
    requestAnimationFrame(loop);
  }

  function startEffects() {
    running = true;
    lastTime = 0;
    requestAnimationFrame(loop);

    // Kembang api berkelanjutan (tanpa batas)
    if (!burstIntervalId) {
      burstIntervalId = setInterval(() => {
        spawnBurst(rand(40, 70));
      }, 800);
    }
  }

  // Interaksi tombol
  const btn = document.getElementById('launchButton');
  const overlay = document.getElementById('launchedOverlay');
  let launched = false;
  const GRADIENT_CLASSES = ['gradient-1','gradient-2','gradient-3','gradient-4','gradient-5','gradient-final'];

  function setOverlayGradientByCount(n) {
    overlay.classList.remove(...GRADIENT_CLASSES);
    if (n >= 1 && n <= 5) {
      overlay.classList.add(`gradient-${n}`);
    }
  }

  function centerOf(el) {
    const rect = el.getBoundingClientRect();
    return { x: rect.left + rect.width / 2, y: rect.top + rect.height / 2 };
  }

  function onLaunch() {
    if (launched) return;
    launched = true;
    
    // Aktifkan overlay dan efek fade/glow pada halaman
    overlay.classList.add('active');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.classList.add('prelaunch');

    // Jalankan countdown 5 → 1, lalu tampilkan ucapan dan efek
    const countdownEl = document.getElementById('countdown');
    let n = 5;
    countdownEl.textContent = String(n);
    setOverlayGradientByCount(n);
    const timer = setInterval(() => {
      n -= 1;
      if (n > 0) {
        countdownEl.textContent = String(n);
        setOverlayGradientByCount(n);
        // suara setiap detik countdown
        playTick();
      } else {
        clearInterval(timer);
        countdownEl.textContent = 'Launch!';
        // Tambahkan jeda ~2 detik sebelum pesan ucapan ditampilkan
        setTimeout(() => {
          // Tampilkan pesan ucapan
          overlay.classList.add('show-message');
          overlay.classList.remove(...GRADIENT_CLASSES);
          overlay.classList.add('gradient-final');
          
          // Tampilkan logo aplikasi bersamaan saat efek dimulai
          overlay.classList.add('logo-visible');
          const logo = document.getElementById('appLogo');
          if (logo) logo.setAttribute('aria-hidden', 'false');

          // Mulai efek kanvas dan konfeti dari pusat tombol
          const center = centerOf(btn);
          spawnConfetti(center.x, center.y, 220);
          startEffects();

          // suara peluncuran
          playLaunch();

          // Update tampilan tombol
          btn.classList.add('launched');
          const label = btn.querySelector('.label');
          if (label) label.textContent = 'Diluncurkan!';

          // Hilangkan efek prelaunch pada halaman
          document.body.classList.remove('prelaunch');

          // Sembunyikan seluruh UI utama (tombol, headline, subtitle)
          const stage = document.querySelector('.stage');
          if (stage) stage.setAttribute('aria-hidden', 'true');
          btn.style.display = 'none';
          document.body.classList.add('launched-phase');
        }, 2000);
      }
    }, 1000);
  }

  const nextBtn = document.querySelector('.next-button');
  if (nextBtn) nextBtn.classList.remove('is-visible'); // pastikan tersembunyi di awal

  function onLaunch() {
    if (launched) return;
    launched = true;

    overlay.classList.add('active');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.classList.add('prelaunch');

    const countdownEl = document.getElementById('countdown');
    let n = 5;
    countdownEl.textContent = String(n);
    setOverlayGradientByCount(n);

    // (opsional) pastikan tersembunyi selama countdown
    if (nextBtn) nextBtn.classList.remove('is-visible');

    const timer = setInterval(() => {
      n -= 1;
      if (n > 0) {
        countdownEl.textContent = String(n);
        setOverlayGradientByCount(n);
        playTick();
      } else {
        clearInterval(timer);
        countdownEl.textContent = 'Launch!';

        setTimeout(() => {
          overlay.classList.add('show-message');
          overlay.classList.remove(...GRADIENT_CLASSES);
          overlay.classList.add('gradient-final');

          // === Di sinilah logo tampil ===
          overlay.classList.add('logo-visible');
          const logo = document.getElementById('appLogo');
          if (logo) logo.setAttribute('aria-hidden', 'false');

          // === TAMPILKAN tombol next saat logo sudah visible ===
          if (nextBtn) nextBtn.classList.add('is-visible');

          const center = centerOf(btn);
          spawnConfetti(center.x, center.y, 220);
          startEffects();
          playLaunch();

          btn.classList.add('launched');
          const label = btn.querySelector('.label');
          if (label) label.textContent = 'Diluncurkan!';

          document.body.classList.remove('prelaunch');
          const stage = document.querySelector('.stage');
          if (stage) stage.setAttribute('aria-hidden', 'true');
          btn.style.display = 'none';
          document.body.classList.add('launched-phase');
        }, 2000);
      }
    }, 1000);
  }

  btn.addEventListener('pointerdown', onLaunch, { once: true });
  btn.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      onLaunch();
    }
  }, { once: true });
})();
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

    <section id="ai-style" class="py-24 bg-zinc-900 border-y border-zinc-800 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <div class="order-2 lg:order-1">
                    <div class="inline-block bg-amber-500/10 border border-amber-500/20 text-amber-500 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-6">
                        Real AI Face Detection
                    </div>
                    <h3 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-6 text-white leading-tight">
                        Temukan Gaya <span class="text-amber-500">Terbaikmu</span>
                    </h3>
                    <p id="face-desc" class="text-zinc-400 text-lg mb-8 leading-relaxed transition-all duration-500">
                        Sistem AI kami sedang bersiap. Saat kamera menyala, arahkan wajahmu lurus ke layar, dan biarkan algoritma kami mengukur struktur rahangmu secara otomatis!
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mb-10 pointer-events-none">
                        <button id="btn-oval" class="face-btn border border-zinc-700 text-zinc-400 px-6 py-3 font-bold uppercase tracking-widest transition-all">Oval</button>
                        <button id="btn-bulat" class="face-btn border border-zinc-700 text-zinc-400 px-6 py-3 font-bold uppercase tracking-widest transition-all">Bulat</button>
                        <button id="btn-kotak" class="face-btn border border-zinc-700 text-zinc-400 px-6 py-3 font-bold uppercase tracking-widest transition-all">Kotak</button>
                    </div>

                    <button onclick="startAiCamera()" id="btn-scan" class="bg-amber-500 text-zinc-950 px-8 py-4 font-black uppercase tracking-widest hover:bg-amber-400 transition-all flex items-center gap-3 w-full sm:w-auto justify-center group disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span id="scan-text">Memuat Model AI...</span>
                    </button>
                </div>

                <div class="order-1 lg:order-2 relative w-full max-w-sm mx-auto aspect-[3/4] bg-zinc-950 rounded-[2.5rem] overflow-hidden border-[8px] border-zinc-800 shadow-2xl transition-all duration-300" id="camera-frame" data-aos="fade-left" data-aos-delay="200">
                    
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=1000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-30 grayscale transition-all duration-500" id="scan-image" alt="Placeholder">
                    
                    <video id="camera-stream" class="absolute inset-0 w-full h-full object-cover hidden" autoplay muted playsinline></video>
                    
                    <canvas id="overlay" class="absolute inset-0 w-full h-full z-20"></canvas>
                    
                    <div class="absolute inset-0 z-30 flex flex-col justify-between p-6 bg-gradient-to-t from-zinc-950 via-transparent to-transparent pointer-events-none">
                        
                        <div class="flex justify-between items-center text-white/80">
                            <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse hidden" id="rec-dot"></div>
                            <span id="ai-status" class="text-[10px] uppercase tracking-widest font-bold bg-zinc-950/80 px-3 py-1 rounded-full border border-zinc-700">Menunggu AI</span>
                        </div>

                        <div class="pointer-events-auto">
                            <p class="text-[10px] text-zinc-400 uppercase tracking-widest mb-2 hidden" id="rec-title">Rekomendasi Rambut:</p>
                            <div id="style-container" class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide opacity-0 transition-opacity duration-500">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const dataWajah = {
                oval: {
                    label: 'Oval Face',
                    desc: 'Bentuk wajah proporsional dengan rasio memanjang. Sangat cocok dengan model bervolume di atas (Pompadour, Quiff) agar tidak membuat wajah makin panjang.',
                    styles: ['Pompadour', 'Quiff', 'Undercut']
                },
                bulat: {
                    label: 'Round Face',
                    desc: 'Panjang dan lebar wajah hampir sama. Tipiskan bagian samping (Fade) dan tinggikan bagian atas untuk ilusi wajah lebih tajam.',
                    styles: ['Faux Hawk', 'Side Part', 'Spiky']
                },
                kotak: {
                    label: 'Square Face',
                    desc: 'Rahang kuat dan lebar sejajar dengan dahi. Bentuk maskulin ini sangat cocok dengan potongan pendek dan tegas bergaya militer.',
                    styles: ['Buzz Cut', 'French Crop', 'Crew Cut']
                }
            };

            const video = document.getElementById('camera-stream');
            const btnScan = document.getElementById('btn-scan');
            const btnText = document.getElementById('scan-text');
            let isAiLoaded = false;
            let currentDetectedShape = null;

            // 1. Memuat Model AI saat halaman dibuka
            async function loadAI() {
                btnScan.disabled = true;
                // Kita gunakan CDN dari vladmandic yang stabil untuk hosting model weights
                const MODEL_URL = 'https://vladmandic.github.io/face-api/model/'; 
                
                try {
                    await Promise.all([
                        faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                        faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL)
                    ]);
                    isAiLoaded = true;
                    btnText.innerText = "Buka Kamera & Scan";
                    btnScan.disabled = false;
                    document.getElementById('ai-status').innerText = "AI Siap";
                } catch (error) {
                    console.error("Gagal memuat AI:", error);
                    btnText.innerText = "Gagal Memuat AI";
                }
            }

            // Jalankan fungsi memuat AI otomatis
            window.onload = loadAI;

            // 2. Membuka Kamera
            async function startAiCamera() {
                if (!isAiLoaded) return;
                
                btnText.innerText = "Meminta Izin Kamera...";
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } });
                    video.srcObject = stream;
                    document.getElementById('scan-image').classList.add('hidden');
                    video.classList.remove('hidden');
                    document.getElementById('rec-dot').classList.remove('hidden');
                    document.getElementById('ai-status').innerText = "Menganalisis Wajah...";
                    btnScan.classList.add('hidden'); // Sembunyikan tombol utama
                } catch (err) {
                    alert("Gagal mengakses kamera. Izinkan akses kamera di browser.");
                }
            }

            // 3. Proses Deteksi saat video berjalan
            video.addEventListener('play', () => {
                const canvas = document.getElementById('overlay');
                const displaySize = { width: video.clientWidth, height: video.clientHeight };
                faceapi.matchDimensions(canvas, displaySize);

                setInterval(async () => {
                    // Deteksi wajah dan 68 titik landmarks
                    const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks();
                    
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    if (detections) {
                        const resizedDetections = faceapi.resizeResults(detections, displaySize);
                        
                        // Gambar garis rahang (hijau futuristik)
                        faceapi.draw.drawFaceLandmarks(canvas, resizedDetections, { drawLines: true, color: '#10b981', lineWidth: 2 });
                        
                        // Hitung bentuk wajah
                        analyzeFaceShape(detections.landmarks.positions);
                    }
                }, 200); // Lakukan scan setiap 200 milidetik
            });

            // 4. Logika Matematika Menentukan Bentuk Wajah
            function analyzeFaceShape(points) {
                // Titik 8 adalah dagu bawah. Titik 27 adalah pangkal hidung (antara mata).
                const faceLength = points[8].y - points[27].y; 
                // Titik 0 dan 16 adalah ujung kiri dan kanan wajah dekat telinga
                const faceWidth = points[16].x - points[0].x;
                // Titik 4 dan 12 adalah lebar garis rahang bawah
                const jawWidth = points[12].x - points[4].x;

                let shape = '';

                // Rumus Sederhana (Heuristik)
                if (faceLength > faceWidth * 1.25) {
                    shape = 'oval'; // Wajah lebih panjang dari lebarnya
                } else if (jawWidth > faceWidth * 0.75) {
                    shape = 'kotak'; // Rahang lebar hampir sejajar dengan lebar wajah
                } else {
                    shape = 'bulat'; // Panjang dan lebar wajah seimbang, rahang melengkung
                }

                // Update UI jika bentuk wajah berubah (agar tidak berkedip)
                if(currentDetectedShape !== shape) {
                    currentDetectedShape = shape;
                    updateUI(shape);
                }
            }

            // 5. Update Tampilan berdasarkan hasil AI
            function updateUI(shape) {
                // Reset warna tombol
                document.querySelectorAll('.face-btn').forEach(btn => {
                    btn.classList.remove('border-amber-500', 'text-amber-500');
                    btn.classList.add('border-zinc-700', 'text-zinc-400');
                });
                
                // Nyalakan tombol sesuai bentuk wajah
                const activeBtn = document.getElementById(`btn-${shape}`);
                activeBtn.classList.remove('border-zinc-700', 'text-zinc-400');
                activeBtn.classList.add('border-amber-500', 'text-amber-500');
                
                // Update teks deskripsi
                document.getElementById('face-desc').innerText = dataWajah[shape].desc;
                document.getElementById('ai-status').innerText = `Deteksi: ${dataWajah[shape].label}`;

                // Update Rekomendasi Tombol Rambut
                const styleContainer = document.getElementById('style-container');
                styleContainer.innerHTML = '';
                dataWajah[shape].styles.forEach((style, index) => {
                    const btn = document.createElement('button');
                    btn.className = index === 0 ? 
                        'bg-amber-500 text-zinc-950 px-4 py-2 rounded-lg font-bold text-xs uppercase shrink-0' : 
                        'bg-zinc-950/80 border border-zinc-700 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase shrink-0';
                    btn.innerText = style;
                    styleContainer.appendChild(btn);
                });

                document.getElementById('rec-title').classList.remove('hidden');
                styleContainer.classList.remove('opacity-0');
            }
        </script>
    </section>
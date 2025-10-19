<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Görsel Show</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #000;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        .slideshow-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide {
            display: none;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .slide.active {
            display: block;
            animation: fadeIn 1s ease-in-out;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .no-visuals {
            color: white;
            text-align: center;
            font-size: 2rem;
            padding: 2rem;
        }

        /* Navigation controls (optional, hidden by default) */
        .controls {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 10;
        }

        body:hover .controls {
            opacity: 1;
        }

        .control-btn {
            background-color: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }

        .control-btn:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        /* Dots indicator */
        .dots {
            position: fixed;
            bottom: 70px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        body:hover .dots {
            opacity: 1;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dot.active {
            background-color: white;
        }
    </style>
</head>
<body>
    @if($visuals->count() > 0)
        <div class="slideshow-container">
            @foreach($visuals as $index => $visual)
                <div class="slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <img src="{{ $visual->image_data }}" alt="{{ $visual->title ?? 'Görsel ' . ($index + 1) }}">
                </div>
            @endforeach
        </div>

        <div class="dots">
            @foreach($visuals as $index => $visual)
                <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="currentSlide({{ $index }})"></span>
            @endforeach
        </div>

        <div class="controls">
            <button class="control-btn" onclick="changeSlide(-1)">&#10094; Önceki</button>
            <button class="control-btn" onclick="toggleAutoPlay()">
                <span id="playPauseText">Durdur</span>
            </button>
            <button class="control-btn" onclick="changeSlide(1)">Sonraki &#10095;</button>
        </div>

        <script>
            let currentIndex = 0;
            let autoPlayInterval;
            let isPlaying = true;
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');
            const totalSlides = slides.length;

            function showSlide(index) {
                // Remove active class from all slides and dots
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                // Wrap around if needed
                if (index >= totalSlides) {
                    currentIndex = 0;
                } else if (index < 0) {
                    currentIndex = totalSlides - 1;
                } else {
                    currentIndex = index;
                }

                // Add active class to current slide and dot
                slides[currentIndex].classList.add('active');
                dots[currentIndex].classList.add('active');
            }

            function changeSlide(direction) {
                showSlide(currentIndex + direction);
            }

            function currentSlide(index) {
                showSlide(index);
            }

            function toggleAutoPlay() {
                const playPauseText = document.getElementById('playPauseText');

                if (isPlaying) {
                    clearInterval(autoPlayInterval);
                    playPauseText.textContent = 'Başlat';
                    isPlaying = false;
                } else {
                    startAutoPlay();
                    playPauseText.textContent = 'Durdur';
                    isPlaying = true;
                }
            }

            function startAutoPlay() {
                autoPlayInterval = setInterval(() => {
                    changeSlide(1);
                }, 5000); // Change slide every 5 seconds
            }

            // Start auto-play on page load
            startAutoPlay();

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    changeSlide(-1);
                } else if (e.key === 'ArrowRight') {
                    changeSlide(1);
                } else if (e.key === ' ') {
                    e.preventDefault();
                    toggleAutoPlay();
                }
            });

            // Touch swipe support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            document.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            document.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) {
                    changeSlide(1); // Swipe left
                }
                if (touchEndX > touchStartX + 50) {
                    changeSlide(-1); // Swipe right
                }
            }
        </script>
    @else
        <div class="no-visuals">
            <p>Henüz görsel eklenmemiş.</p>
        </div>
    @endif
</body>
</html>

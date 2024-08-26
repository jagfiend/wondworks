<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>

        <style>
            :root {
                --hue: 0;
                --brush-size: 28px;
            }

            html, body {
                margin: 0;
                background: #111;
                color: white;
            }

            #doodler {
                display: block;
                margin: 12px auto 0;
            }

            .controls {
                display: flex;
                flex-direction: column;
                margin: 24px auto 0;
                width: 768px;
            }

            .control {
                display: flex;
                align-content: center;
                margin-bottom: 12px;
            }

            #huePicker {
                display: flex;
                align-items: center;
                background: linear-gradient(
                    90deg,
                    hsl(0, 100%, 60%),
                    hsl(60, 100%, 60%),
                    hsl(120, 100%, 60%),
                    hsl(180, 100%, 60%),
                    hsl(240, 100%, 60%),
                    hsl(300, 100%, 60%),
                    hsl(360, 100%, 60%)
                );
                padding: 10px 0;
            }

            input[name="huePicker"] {
                /* removing default appearance */
                -webkit-appearance: none;
                appearance: none;
                /* creating a custom design */
                width: 100%;
                cursor: pointer;
                outline: none;
                /*  slider progress trick  */
                overflow: hidden;
            }

            /* Thumb: webkit */
            input[name="huePicker"]::-webkit-slider-thumb {
                /* removing default appearance */
                -webkit-appearance: none;
                appearance: none;
                /* creating a custom design */
                height: 24px;
                width: 24px;
                background-color: transparent;
                border-radius: 50%;
                border: 2px solid black;
            }

            /* Thumb: Firefox */
            input[name="huePicker"]::-moz-range-thumb {
                height: 24px;
                width: 24px;
                background-color: transparent;
                border-radius: 50%;
                border: 1px solid black;
            }

            .brush-preview {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 50px;
                width: 50px;
            }

            .brush-size {
                height: var(--brush-size);
                width: var(--brush-size);
                background-color: hsl(var(--hue), 100%, 60%);
                border-radius: 50%;
            }

            .mr {
                margin-right: 16px;
            }

            .slider {
                flex: 1;
            }

            button {
                border: none;
                background: transparent;
            }

            .btn {
                background-color: black;
                border: 1px solid black;
                border-radius: 50%;
                color: white;
                height: 50px;
                width: 50px;
            }

            .btn:hover {
                cursor: pointer;
                border: 1px solid white;
            }
        </style>
    </head>
    <body>
        <main>
            <!-- canvas -->
            <canvas id="doodler" height="768" width="768"></canvas>

            <!-- controls -->
            <div class="controls">
                <!-- colour picker -->
                <div class="control">
                    <input
                        id="huePicker"
                        class="slider"
                        min="0"
                        max="360"
                        name="huePicker"
                        type="range"
                        value="0"
                    >
                </div>

                <div class="control">
                    <div class="brush-preview mr">
                        <div class="brush-size"></div>
                    </div>
                    <input
                        id="brushSizePicker"
                        class="slider mr"
                        min="8"
                        max="48"
                        type="range"
                        value="28"
                    >
                    <button id="toggleCanvasBackgroundBtn" class="btn mr">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>
                    <button id="resetCanvasBtn" class="btn mr">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                    <button id="saveDrawingBtn" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </main>

        <script>
            // canvas setup
            const canvas = document.querySelector('#doodler');
            const ctx = canvas.getContext('2d');

            // context defaults
            let isDark = true

            const getModeColour = function () {
                return isDark ? "black" : "white"
            }

            canvas.style.setProperty("background", getModeColour())

            ctx.lineJoin = 'round';
            ctx.lineCap = 'round';

            // handle drawing
            let isDrawing = false
            let lastX = 0
            let lastY = 0
            let hue
            let brushSize

            function draw(offsetX, offsetY) {
                if (!isDrawing) {
                    return
                }

                ctx.strokeStyle = `hsl(${hue}, 100%, 60%)`
                ctx.lineWidth = brushSize;

                ctx.beginPath()
                ctx.moveTo(lastX, lastY)
                ctx.lineTo(offsetX, offsetY)
                ctx.stroke()

                lastX = offsetX
                lastY = offsetY
            }

            function startDrawingMouse(e) {
                isDrawing = true

                lastX = e.offsetX
                lastY = e.offsetY

                draw(e)
            }

            function startDrawingTouch(e) {
                e.preventDefault()

                isDrawing = true

                lastX = e.touches[0].clientX
                lastY = e.touches[0].clientY

                draw(e)
            }

            // desktop
            canvas.addEventListener("mousedown", e => startDrawingMouse(e))
            canvas.addEventListener("mousemove", e => draw(e.offsetX, e.offsetY))
            canvas.addEventListener("mouseup", () => isDrawing = false)
            canvas.addEventListener("mouseout", () => isDrawing = false)

            // tablet
            canvas.addEventListener("touchstart", e => startDrawingTouch(e))
            canvas.addEventListener("touchmove", e => draw(e.touches[0].clientX, e.touches[0].clientY))
            canvas.addEventListener("touchend", () => isDrawing = false)

            // colour picker
            const huePicker = document.getElementById("huePicker")

            hue = huePicker.value

            const updateHue = function () {
                hue = this.value
                document.documentElement.style.setProperty("--hue", this.value)
            }

            huePicker.addEventListener("change", updateHue)
            huePicker.addEventListener("mousemove", updateHue)
            huePicker.addEventListener("touchstart", updateHue)
            huePicker.addEventListener("touchmove", updateHue)

            // brush size
            const brushSizePicker = document.getElementById("brushSizePicker")

            brushSize = brushSizePicker.value

            const updateBrushSize = function () {
                brushSize = this.value
                document.documentElement.style.setProperty("--brush-size", this.value + 'px')
            }

            brushSizePicker.addEventListener("change", updateBrushSize)
            brushSizePicker.addEventListener("mousemove", updateBrushSize)
            brushSizePicker.addEventListener("touchstart", updateBrushSize)
            brushSizePicker.addEventListener("touchmove", updateBrushSize)

            // dark mode toggle
            const toggleCanvasBackgroundBtn = document.getElementById("toggleCanvasBackgroundBtn")

            toggleCanvasBackgroundBtn.addEventListener("click", function (e) {
                isDark = !isDark

                canvas.style.setProperty("background", getModeColour())
            })

            // reset
            const resetCanvasBtn = document.getElementById("resetCanvasBtn")

            resetCanvasBtn.addEventListener("click", function (e) {
                ctx.clearRect(0, 0, canvas.width, canvas.height)
            })

            // save
            const saveDrawingBtn = document.getElementById("saveDrawingBtn")

            saveDrawingBtn.addEventListener("click", function (e) {
                // TODO
            })
        </script>
    </body>
</html>

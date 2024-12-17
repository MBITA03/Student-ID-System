
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Capture Student Image</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
    <style>
        #video, #canvas {
            display: none;
            margin: 10px 0;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-label {
            font-weight: bold;
        }
        .radio-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        #snap {
            margin-top: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Capture Student Image</h2>
        <a href="index.php" class="btn btn-outline-primary mb-3">Home</a>
        
        <form action="save_image.php" method="POST" enctype="multipart/form-data" class="form-group">
            <div class="mb-3">
                <label for="exam_no_search" class="form-label">Enter Exam No:</label>
                <input type="text" id="exam_no_search" name="exam_no_search" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Choose an option:</label>
                <div class="radio-option">
                    <input type="radio" id="uploadFile" name="uploadOption" value="file" checked>
                    <label for="uploadFile">Upload Image</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="capturePhoto" name="uploadOption" value="capture">
                    <label for="capturePhoto">Capture Photo</label>
                </div>
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <input type="file" id="photo" name="photo" accept="image/*" class="form-control">
            </div>

            <!-- Capture Image -->
            <div id="captureSection" class="mb-3">
                <video id="video" width="320" height="240" class="mb-2" autoplay></video>
                <button type="button" id="snap" class="btn btn-secondary btn-sm">Capture</button>
                <canvas id="canvas" width="320" height="240" class="mt-2"></canvas>
                <input type="hidden" name="capturedImage" id="capturedImage">
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-3">Save Image</button>
        </form>
    </div>

    <script>
        const uploadFileRadio = document.getElementById('uploadFile');
        const capturePhotoRadio = document.getElementById('capturePhoto');
        const photoInput = document.getElementById('photo');
        const captureSection = document.getElementById('captureSection');
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snapButton = document.getElementById('snap');
        const capturedImageInput = document.getElementById('capturedImage');

        // Hide capture section initially
        captureSection.style.display = 'none';

        // Show/hide upload or capture options based on selection
        uploadFileRadio.addEventListener('change', () => {
            photoInput.style.display = 'block';
            captureSection.style.display = 'none';
        });

        capturePhotoRadio.addEventListener('change', () => {
            photoInput.style.display = 'none';
            captureSection.style.display = 'block';
            startCamera();
        });

        // Start camera stream
        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                    video.style.display = 'block';
                })
                .catch(error => {
                    console.error("Error accessing camera: ", error);
                });
        }

        // Capture photo and stop video stream
        snapButton.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataUrl = canvas.toDataURL('image/png');
            capturedImageInput.value = dataUrl;
            video.style.display = 'none';
            canvas.style.display = 'block';
        });
    </script>
</body>
</html>

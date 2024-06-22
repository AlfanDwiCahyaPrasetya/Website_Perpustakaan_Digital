<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php");
    exit();
}

if (!isset($_GET['file'])) {
    header("Location: index.php");
    exit();
}

$file = basename(urldecode($_GET['file'])); // Only the file name
$filePath = "../uploaded_file/" . $file;

if (!file_exists($filePath)) {
    echo "File tidak tersedia.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf_viewer.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        #pdf-viewer {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            height: 80%;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        .pdf-page {
            width: 100%;
            height: 100%;
        }
        .pdf-page canvas {
            width: 100%;
            height: 100%;
        }
        .pdf-viewer-toolbar {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .pdf-viewer-toolbar button {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .pdf-viewer-toolbar button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="pdf-viewer">
        <div class="pdf-page" id="pdf-page"></div>
    </div>
    <div class="pdf-viewer-toolbar">
        <button id="prev-page">Previous</button>
        <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
        <button id="next-page">Next</button>
    </div>

    <script>
        const url = "<?php echo $filePath; ?>";
        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.5;

        const canvas = document.createElement('canvas'),
              ctx = canvas.getContext('2d');
        document.getElementById('pdf-page').appendChild(canvas);

        function renderPage(num) {
            pageRendering = true;

            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                return page.render(renderContext).promise;
            }).then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });

            document.getElementById('page-num').textContent = num;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }

        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });

        document.getElementById('prev-page').addEventListener('click', onPrevPage);
        document.getElementById('next-page').addEventListener('click', onNextPage);
    </script>
</body>
</html>


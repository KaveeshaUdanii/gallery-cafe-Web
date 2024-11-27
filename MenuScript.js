// Update the pdfUrl to point to your local PDF file
const pdfUrl = 'C:\wamp64\www\Gallery Cafe\choc_menu_book.pdf'; 

const pdfCanvas = document.getElementById('pdf-canvas');
const ctx = pdfCanvas.getContext('2d');

let pdfDoc = null;
let pageNum = 1;

pdfjsLib.getDocument(pdfUrl).promise.then(doc => {
    pdfDoc = doc;
    renderPage(pageNum);
});

function renderPage(num) {
    pdfDoc.getPage(num).then(page => {
        const viewport = page.getViewport({ scale: 1 });
        pdfCanvas.height = viewport.height;
        pdfCanvas.width = viewport.width;

        const renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };
        page.render(renderContext);
    });
}

document.getElementById('prevBtn').addEventListener('click', () => {
    if (pageNum <= 1) return;
    pageNum--;
    renderPage(pageNum);
});

document.getElementById('nextBtn').addEventListener('click', () => {
    if (pageNum >= pdfDoc.numPages) return;
    pageNum++;
    renderPage(pageNum);
});

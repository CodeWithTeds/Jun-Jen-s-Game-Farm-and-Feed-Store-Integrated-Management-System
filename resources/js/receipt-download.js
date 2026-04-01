import { toPng } from 'html-to-image';
import { jsPDF } from 'jspdf';

window.downloadReceipt = async (elementId, filename) => {
    try {
        const element = document.getElementById(elementId);
        if (!element) {
            console.error(`Element with ID ${elementId} not found`);
            return;
        }

        // Small delay to ensure any transitions are finished
        await new Promise(resolve => setTimeout(resolve, 300));

        // Use html-to-image to capture the receipt
        const dataUrl = await toPng(element, {
            pixelRatio: 3, 
            backgroundColor: '#ffffff',
            style: {
                display: 'block',
                visibility: 'visible'
            }
        });
        
        // Create a PDF with the same aspect ratio
        const imgWidth = 80; // Standard receipt width in mm
        const canvasAspectRatio = element.offsetHeight / element.offsetWidth;
        const pageHeight = imgWidth * canvasAspectRatio;
        
        // Construct jsPDF with explicit parameters
        const pdf = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: [imgWidth, pageHeight + 10], // Added a bit of margin
            compress: true
        });

        pdf.addImage(dataUrl, 'PNG', 0, 5, imgWidth, pageHeight);
        pdf.save(`${filename || 'receipt'}.pdf`);
    } catch (error) {
        console.error('Receipt download failed:', error);
        alert('Failed to download receipt. Please try again.');
    }
};


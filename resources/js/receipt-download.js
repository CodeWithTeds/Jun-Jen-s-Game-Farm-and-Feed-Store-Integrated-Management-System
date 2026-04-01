import html2canvas from 'html2canvas';
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

        // Use html2canvas to capture the receipt
        const canvas = await html2canvas(element, {
            scale: 3, // Higher scale for even better quality
            backgroundColor: '#ffffff',
            useCORS: true,
            allowTaint: true,
            logging: false,
            onclone: (clonedDoc) => {
                // Ensure the element is visible in the clone
                const clonedElement = clonedDoc.getElementById(elementId);
                if (clonedElement) {
                    clonedElement.style.display = 'block';
                    clonedElement.style.visibility = 'visible';
                }
            }
        });

        const imgData = canvas.toDataURL('image/png');
        
        // Create a PDF with the same aspect ratio
        const imgWidth = 80; // Standard receipt width in mm
        const canvasAspectRatio = canvas.height / canvas.width;
        const pageHeight = imgWidth * canvasAspectRatio;
        
        // Construct jsPDF with explicit parameters
        const pdf = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: [imgWidth, pageHeight + 10], // Added a bit of margin
            compress: true
        });

        pdf.addImage(imgData, 'PNG', 0, 5, imgWidth, pageHeight);
        pdf.save(`${filename || 'receipt'}.pdf`);
    } catch (error) {
        console.error('Receipt download failed:', error);
        alert('Failed to download receipt. Please try again.');
    }
};


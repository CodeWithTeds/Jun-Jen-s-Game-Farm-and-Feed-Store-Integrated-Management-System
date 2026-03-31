import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf';

window.downloadReceipt = async (elementId, filename) => {
    const element = document.getElementById(elementId);
    if (!element) return;

    // Use html2canvas to capture the receipt
    const canvas = await html2canvas(element, {
        scale: 2, // Higher scale for better quality
        backgroundColor: '#ffffff',
        useCORS: true,
        logging: false
    });

    const imgData = canvas.toDataURL('image/png');
    
    // Create a PDF with the same aspect ratio
    const imgWidth = 80; // Standard receipt width in mm
    const pageHeight = (canvas.height * imgWidth) / canvas.width;
    
    const pdf = new jsPDF({
        orientation: 'p',
        unit: 'mm',
        format: [imgWidth, pageHeight + 10]
    });

    pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, pageHeight);
    pdf.save(`${filename}.pdf`);
};

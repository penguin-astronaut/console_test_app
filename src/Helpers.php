<?php


namespace Penguin\ConsoleApp;



use TCPDF;

class Helpers
{
    public static function getFiles(string $folder, array $allowExtensions = []): array
    {
        $pattern = '#\.(' . implode('|', $allowExtensions) . ')$#i';
        $files = array_slice(scandir($folder), 2);
        $result = [];

        foreach ($files as $file) {
            $fullPathContent = $folder . '/' . $file;
            if (is_dir($fullPathContent)) {
                $result = array_merge($result, self::getFiles($fullPathContent, $allowExtensions));
            } elseif ($allowExtensions && preg_match($pattern, $file)) {
                $result[] = $fullPathContent;
            }
        }

        return $result;
    }

    public static function convertToPdf(array $files): void
    {
        foreach ($files as $file) {
            $content = file_get_contents($file);

            $isHtml = preg_match('#\.html$#i', $file);
            self::generatePdf($content, $file, $isHtml);
        }
    }


    private static function generatePdf(string $content, string $fileName, bool $isHtml = true): void
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


        $pdf->setFontSubsetting(true);

        $pdf->AddPage();
        if ($isHtml) {
            $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
        } else {
            $pdf->SetFont('dejavusans', '', 10, '', true);
            $pdf->Write(0, $content, '', 0, '', true, 0, false, false, 0);
        }

        $pdf->Output($fileName . '.pdf', 'F');
    }
}
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$dataFile = __DIR__ . '/data.json';
$data = json_decode(file_get_contents($dataFile), true);
$orders = $data['orders'] ?? [];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$order = null;
foreach ($orders as $o) {
    if ($o['id'] == $id) {
        $order = $o;
        break;
    }
}

if (!$order) {
    die('Order tidak ditemukan');
}

$settings = $data['settings'] ?? [
    'store_name' => 'Telur Pedia',
    'store_phone' => '0812-3456-7890',
    'store_address' => 'Tangerang, Indonesia',
    'store_email' => 'info@telurpedia.com'
];

// Buat HTML invoice
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Invoice #' . $order['id'] . '</title>
    <style>
        * { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        body { padding: 40px; background: #f8fafc; }
        .invoice-box {
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 12px;
        }
        .header { text-align: center; border-bottom: 2px solid #f59e0b; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { font-size: 28px; color: #0f172a; }
        .header h1 span { color: #f59e0b; }
        .header p { color: #64748b; font-size: 14px; }
        .info { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 14px; }
        .info .label { color: #64748b; }
        .info .value { font-weight: 600; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table th { background: #f1f5f9; padding: 10px; text-align: left; font-size: 13px; color: #64748b; border-bottom: 2px solid #e2e8f0; }
        table td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        .total { font-size: 18px; font-weight: 700; text-align: right; padding: 15px 0; border-top: 2px solid #f59e0b; margin-top: 10px; }
        .total span { color: #f59e0b; font-size: 22px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8; }
        .status { display: inline-block; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .status-new { background: #dbeafe; color: #1d4ed8; }
        .status-process { background: #fef3c7; color: #b45309; }
        .status-done { background: #d1fae5; color: #065f46; }
        @media print {
            body { background: white; padding: 20px; }
            .invoice-box { box-shadow: none; border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="header">
        <h1>🥚 Telur<span>Pedia</span></h1>
        <p>' . $settings['store_address'] . ' | ' . $settings['store_phone'] . '</p>
    </div>

    <div class="info">
        <div>
            <div><span class="label">INVOICE</span></div>
            <div style="font-size:22px;font-weight:800;color:#0f172a;">#INV-' . str_pad($order['id'], 4, '0', STR_PAD_LEFT) . '</div>
        </div>
        <div style="text-align:right;">
            <div><span class="label">Tanggal</span></div>
            <div class="value">' . date('d M Y', strtotime($order['date'])) . '</div>
            <div style="margin-top:4px;">
                <span class="status status-' . strtolower($order['status']) . '">' . $order['status'] . '</span>
            </div>
        </div>
    </div>

    <div style="background:#f8fafc;padding:15px;border-radius:8px;margin:10px 0 20px;">
        <div style="display:flex;justify-content:space-between;font-size:13px;">
            <div>
                <div><span class="label">Pelanggan</span></div>
                <div style="font-weight:600;color:#0f172a;">' . $order['customer'] . '</div>
                <div style="color:#64748b;">' . $order['phone'] . '</div>
            </div>
            <div style="text-align:right;">
                <div><span class="label">Pengiriman ke</span></div>
                <div style="color:#0f172a;max-width:250px;">' . $order['address'] . '</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Berat</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>' . $order['product'] . '</td>
                <td>-</td>
                <td>' . $order['qty'] . ' kg</td>
                <td>Rp ' . number_format($order['total'], 0, ',', '.') . '</td>
            </tr>
        </tbody>
    </table>

    <div style="display:flex;justify-content:space-between;padding:15px 0;border-top:2px solid #f59e0b;">
        <div>
            <div style="font-size:13px;color:#64748b;">Metode Pembayaran</div>
            <div style="font-weight:600;color:#0f172a;">' . ($order['payment'] ?? 'Transfer Bank') . '</div>
        </div>
        <div class="total">
            TOTAL <span>Rp ' . number_format($order['total'], 0, ',', '.') . '</span>
        </div>
    </div>

    <div style="margin-top:20px;padding:12px;background:#fef3c7;border-radius:8px;text-align:center;font-size:13px;color:#92400e;">
        <i class="fas fa-info-circle"></i> Terima kasih telah berbelanja! Pesanan akan segera diproses.
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Telur Pedia 🙏</p>
        <p style="margin-top:4px;">' . $settings['store_email'] . ' | ' . $settings['store_phone'] . '</p>
    </div>

    <div style="text-align:center;margin-top:20px;" class="no-print">
        <button onclick="window.print()" style="background:#f59e0b;color:white;padding:10px 30px;border:none;border-radius:50px;font-weight:700;cursor:pointer;font-size:14px;">
            <i class="fas fa-print"></i> Cetak / Download PDF
        </button>
        <a href="/" style="display:inline-block;margin-left:10px;color:#64748b;text-decoration:none;font-size:14px;">Kembali</a>
    </div>
</div>
</body>
</html>
';

// Generate PDF
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF
$dompdf->stream('invoice-' . $order['id'] . '.pdf', array('Attachment' => false));

// Tambahkan ini di bagian modal sukses (setelah tombol Beranda)

// Di modal sukses, tambah tombol:
<a href="/invoice.php?id=" id="invoiceLink" target="_blank" class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-full font-bold hover:bg-blue-600 transition text-sm text-center">
    <i class="fas fa-file-pdf"></i> Invoice
</a>

// Di fungsi processPayment, tambahkan:
document.getElementById('invoiceLink').href = '/invoice.php?id=' + data.order_id;

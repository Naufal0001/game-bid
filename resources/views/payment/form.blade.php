<h3>Total Bayar: Rp {{ number_format($transaction->amount) }}</h3>

<form method="POST" enctype="multipart/form-data">
    @csrf
    <label>Metode Pembayaran</label>
    <select name="method">
        <option value="bank_transfer">Transfer Bank</option>
        <option value="ewallet">E-Wallet</option>
    </select>

    <label>Bukti Pembayaran</label>
    <input type="file" name="proof" required>

    <button type="submit">Kirim</button>
</form>

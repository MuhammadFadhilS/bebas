<x-dashboard-layout>
    <h1 class="mt-4">Laporan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Laporan</li>
    </ol>

    <div class="row mb-5">
        <div class="col-12 mb-2">
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
        </div>

        <div class="col-12 mb-2">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
        </div>

        <div class="col">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Laporan Bulanan
                        </div>
                        <div class="card-body">
                            <form action="{{ route('report.pdf') }}" method="GET">
                                <div class="mb-3">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select" required>
                                        <option selected disabled>-- Pilih Bulan --</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tahun-bulanan" class="form-label">Tahun</label>
                                    <select name="tahun" id="tahun-bulanan" class="form-select" required>
                                        <option selected disabled>-- Pilih Tahun --</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-6 d-grid">
                                        <button type="submit" class="btn btn-danger">PDF</button>
                                    </div>
                                    <div class="col-6 d-grid">
                                        <a id="excel-linkk" class="btn btn-success">Excel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Laporan Tahunan
                        </div>
                        <div class="card-body">
                            <form action="{{ route('report.pdf') }}" method="GET">
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select">
                                        <option selected disabled>-- Pilih Tahun --</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-6 d-grid">
                                        <button type="submit" class="btn btn-danger">PDF</button>
                                    </div>
                                    <div class="col-6 d-grid">
                                        <a id="excel-link" class="btn btn-success">Excel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- First Table: Detailed Orders -->
            <div class="card">
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Customer</th>
                                <th>Nama Barang</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Ongkir</th>
                                <th>Total Harga</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama_customer }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp. {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($item->ongkir, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->bukti)
                                        <a href="{{ asset('storage/photos/' . $item->bukti) }}" target="_blank">Lihat Bukti</a>
                                    @else
                                        Tidak ada bukti
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Second Table: Sales Summary -->
            <div class="card mt-5">
                <div class="card-header">
                    Rangkuman Penjualan
                </div>
                <div class="card-body">
                    <table id="salesSummaryTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang Terjual</th>
                                <th>Harga Produk</th>
                                <th>Total Harga Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($salesSummary as $summary)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $summary->product_name }}</td>
                                <td>{{ $summary->total_qty_sold }}</td>
                                <td>Rp. {{ number_format($summary->product_price, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($summary->total_sales, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    const currentYear = new Date().getFullYear();
    const startYear = currentYear - 5;
    const endYear = currentYear + 5;

    const select = document.getElementById('tahun');
    const select2 = document.getElementById('tahun-bulanan');

    for (let year = startYear; year <= endYear; year++) {
        const option1 = document.createElement('option');
        option1.value = year;
        option1.textContent = year;
        select.appendChild(option1);

        const option2 = document.createElement('option');
        option2.value = year;
        option2.textContent = year;
        select2.appendChild(option2.cloneNode(true));
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('excel-link').addEventListener('click', function(event) {
            event.preventDefault();

            const tahun = document.getElementById('tahun').value;

            if (tahun) {
                const url = `/report-excel?tahun=${tahun}`;
                this.href = url;
                window.location.href = url;
            } else {
                alert('Pilih tahun terlebih dahulu!');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('excel-linkk').addEventListener('click', function(event) {
            event.preventDefault();

            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun-bulanan').value;

            if (bulan && tahun) {
                const url = `/report-excel?tahun=${tahun}&bulan=${bulan}`;
                this.href = url;
                window.location.href = url;
            } else {
                alert('Pilih bulan dan tahun terlebih dahulu!');
            }
        });
    });
    </script>
</x-dashboard-layout>

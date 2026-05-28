<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Struk #{{ $nota->id_nota }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        /* ================================================================
           THERMAL RECEIPT STYLESHEET
           Target: 80mm thermal printer (ESC/POS compatible)
           Typography: Space Mono (monospaced dot-matrix aesthetic)
           ================================================================ */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Mono', 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            width: 80mm;
            margin: 0 auto;
            padding: 8mm 4mm;
        }

        /* === HEADER === */
        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .receipt-header .shop-name {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .receipt-header .shop-tagline {
            font-size: 9px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #555;
            margin-top: 2px;
        }
        .receipt-header .shop-address {
            font-size: 9px;
            color: #666;
            margin-top: 4px;
            line-height: 1.3;
        }

        /* === TRANSACTION META === */
        .receipt-meta {
            border-bottom: 1px dashed #000;
            padding-bottom: 6px;
            margin-bottom: 6px;
            font-size: 11px;
        }
        .receipt-meta .meta-row {
            display: flex;
            justify-content: space-between;
            line-height: 1.6;
        }
        .receipt-meta .meta-label {
            color: #666;
        }
        .receipt-meta .meta-value {
            font-weight: 700;
            text-align: right;
        }

        /* === LINE ITEMS TABLE === */
        .receipt-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 11px;
        }
        .receipt-items thead th {
            text-align: left;
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #666;
            padding: 3px 0;
            border-bottom: 1px solid #ccc;
        }
        .receipt-items thead th:last-child {
            text-align: right;
        }
        .receipt-items tbody td {
            padding: 4px 0;
            vertical-align: top;
            border-bottom: 1px dotted #ddd;
        }
        .receipt-items tbody td:last-child {
            text-align: right;
            white-space: nowrap;
        }
        .item-name {
            font-weight: 700;
            font-size: 11px;
        }
        .item-detail {
            font-size: 9px;
            color: #666;
        }

        /* === TOTALS === */
        .receipt-totals {
            border-top: 1px dashed #000;
            padding-top: 6px;
            margin-bottom: 6px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            line-height: 1.8;
        }
        .totals-row.grand-total {
            font-size: 14px;
            font-weight: 700;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 4px 0;
            margin-top: 4px;
        }

        /* === FOOTER === */
        .receipt-footer {
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 8px;
            margin-top: 8px;
            font-size: 9px;
            color: #666;
        }
        .receipt-footer .thank-you {
            font-size: 11px;
            font-weight: 700;
            color: #000;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        /* === PRINT BUTTON (screen only) === */
        .print-actions {
            text-align: center;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #eee;
        }
        .print-actions button {
            font-family: 'Space Mono', monospace;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 10px 32px;
            border: 2px solid #000;
            background: #000;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s;
        }
        .print-actions button:hover {
            background: #fff;
            color: #000;
        }
        .print-actions .back-link {
            display: block;
            margin-top: 8px;
            font-size: 10px;
            color: #999;
            text-decoration: none;
        }
        .print-actions .back-link:hover {
            color: #000;
        }

        /* === DASHED SEPARATOR UTILITY === */
        .dashed {
            border: none;
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        /* ================================================================
           @MEDIA PRINT — Thermal Printer Optimization
           ================================================================ */
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }

            html, body {
                width: 80mm;
                margin: 0;
                padding: 4mm 3mm;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Hide print button during printing */
            .print-actions {
                display: none !important;
            }

            /* Remove browser default headers/footers */
            body::before,
            body::after {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- ============================================================ -->
    <!-- RECEIPT HEADER -->
    <!-- ============================================================ -->
    <div class="receipt-header">
        <div class="shop-name">2WHEELS HOUSE</div>
        <div class="shop-tagline">Workshop & Parts Center</div>
        <div class="shop-address">
            Jl. Contoh Alamat No. 123<br/>
            Telp: (021) 1234-5678
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- TRANSACTION METADATA -->
    <!-- ============================================================ -->
    <div class="receipt-meta">
        <div class="meta-row">
            <span class="meta-label">No. Nota</span>
            <span class="meta-value">{{ $nota->id_nota }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Tanggal</span>
            <span class="meta-value">{{ $nota->tanggal->format('d/m/Y') }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Waktu</span>
            <span class="meta-value">{{ $nota->created_at->format('H:i') }}</span>
        </div>
        <hr class="dashed"/>
        @if($nota->motor && $nota->motor->customer)
        <div class="meta-row">
            <span class="meta-label">Pelanggan</span>
            <span class="meta-value">{{ $nota->motor->customer->nama }}</span>
        </div>
        @endif
        <div class="meta-row">
            <span class="meta-label">Nopol</span>
            <span class="meta-value">{{ $nota->nopol }}</span>
        </div>
        <hr class="dashed"/>
        <div class="meta-row">
            <span class="meta-label">Admin</span>
            <span class="meta-value">{{ $nota->admin->nama ?? '-' }}</span>
        </div>
        @if($nota->mekanik)
        <div class="meta-row">
            <span class="meta-label">Mekanik</span>
            <span class="meta-value">{{ $nota->mekanik->nama }}</span>
        </div>
        @endif
    </div>

    <!-- ============================================================ -->
    <!-- LINE ITEMS -->
    <!-- ============================================================ -->
    <table class="receipt-items">
        <thead>
            <tr>
                <th style="width: 60%;">Item</th>
                <th style="width: 15%;">Qty</th>
                <th style="width: 25%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nota->details as $detail)
            <tr>
                <td>
                    <div class="item-name">{{ $detail->barang->nama ?? 'Item' }}</div>
                    <div class="item-detail">
                        {{ $detail->barang->jenis ?? '' }}
                        @if($detail->barang && $detail->barang->diskon > 0)
                            · Disc {{ $detail->barang->diskon }}%
                        @endif
                        @if($detail->barang)
                            <br/>@ Rp {{ number_format($detail->sub_total / max($detail->banyaknya, 1), 0, ',', '.') }}
                        @endif
                    </div>
                </td>
                <td>{{ $detail->banyaknya }}x</td>
                <td>{{ number_format($detail->sub_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ============================================================ -->
    <!-- TOTALS -->
    <!-- ============================================================ -->
    <div class="receipt-totals">
        <div class="totals-row">
            <span>Jumlah Item</span>
            <span>{{ $nota->details->sum('banyaknya') }} pcs</span>
        </div>
        <div class="totals-row grand-total">
            <span>TOTAL</span>
            <span>Rp {{ number_format($nota->total_jumlah, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- FOOTER -->
    <!-- ============================================================ -->
    <div class="receipt-footer">
        <div class="thank-you">Terima Kasih</div>
        <div>Barang yang sudah dibeli<br/>tidak dapat dikembalikan.</div>
        <div style="margin-top: 6px;">
            {{ $nota->tanggal->format('d M Y') }} · {{ $nota->id_nota }}
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- PRINT CONTROLS (hidden during print) -->
    <!-- ============================================================ -->
    <div class="print-actions">
        <button onclick="window.print()">&#9113; Cetak Struk</button>
        <a href="{{ route('service-desk') }}" class="back-link">&larr; Kembali ke Service Desk</a>
    </div>

</body>
</html>
